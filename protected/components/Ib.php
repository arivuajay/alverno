<?php

require_once dirname(__FILE__) . '/ib/TransactionRequestBean.php';
require_once dirname(__FILE__) . '/ib/TransactionResponseBean.php';

class Ib extends CComponent {

    public $mrctCode;
    public $requestType = 'T';
    public $currencyType = 'INR';
    public $bankCode;
    public $locatorURL;
    public $scheme_code;
    public $key;
    public $iv;
    public $timeOut = '';
    public $returnURL = '/fees/ib/confirm';
    public $s2SReturnURL = 'https://tpslvksrv6046/LoginModule/Test.jsp';

    public function init() {
        $ibconfig = IbConfig::model()->findByPk(1);
        $this->mrctCode = $ibconfig->mrctCode;
        $this->bankCode = $ibconfig->bankCode;
        $this->locatorURL = IbConfig::getLocurlvalue($ibconfig->locatorURL);
        $this->scheme_code = $ibconfig->scheme_code;
        $this->key = $ibconfig->key;
        $this->iv = $ibconfig->iv;

        if ($ibconfig->currencyType)
            $this->currencyType = $ibconfig->currencyType;
    }

    public function __construct() {

    }

    public function addRequestParam($paymentInfo = array()) {
        $fullName = trim($paymentInfo['Member']['first_name'] . " " . $paymentInfo['Member']['last_name']);

        $transactionRequestBean = new TransactionRequestBean();
        //Setting all values here
        $transactionRequestBean->setMerchantCode($this->mrctCode);
        $transactionRequestBean->setRequestType($this->requestType);
        $transactionRequestBean->setCurrencyCode($this->currencyType);
        $transactionRequestBean->setBankCode($this->bankCode);
        $transactionRequestBean->setKey($this->key);
        $transactionRequestBean->setIv($this->iv);
        $transactionRequestBean->setWebServiceLocator($this->locatorURL);
        $transactionRequestBean->setTimeOut($this->timeOut);
        $transactionRequestBean->setS2SReturnURL($this->s2SReturnURL);
        $transactionRequestBean->setReturnURL(Yii::app()->createAbsoluteUrl($this->returnURL));

        $transactionRequestBean->setCustomerName($fullName);
        $transactionRequestBean->setMerchantTxnRefNumber($paymentInfo['Order']['txn_id']);
        $amt = number_format((float) $paymentInfo['Order']['theTotal'] + $paymentInfo['Order']['serviceCharge'], 2, '.', '');
        $transactionRequestBean->setAmount($amt);
        $req_detail = "{$this->scheme_code}_{$amt}_0.0";
        $transactionRequestBean->setShoppingCartDetails($req_detail);
        $transactionRequestBean->setTxnDate(date('Y-m-d', strtotime($paymentInfo['Order']['date'])));
        $transactionRequestBean->setTPSLTxnID('TXN00' . rand(1, 10000));

        $url = $transactionRequestBean->getTransactionToken();

        $responseDetails = $transactionRequestBean->getTransactionToken();
        $responseDetails = (array) $responseDetails;
        $response = $responseDetails[0];

        if (is_string($response) && preg_match('/^msg=/', $response)) {
            $outputStr = str_replace('msg=', '', $response);
            $outputArr = explode('&', $outputStr);
            $str = $outputArr[0];

            $transactionResponseBean = new TransactionResponseBean();
            $transactionResponseBean->setResponsePayload($str);
            $transactionResponseBean->setKey($val['key']);
            $transactionResponseBean->setIv($val['iv']);

            $response = $transactionResponseBean->getResponsePayload();
            return array(false, implode(', ', $response));
        } elseif (is_string($response) && preg_match('/^txn_status=/', $response)) {
            return array(false, implode(', ', $response));
        }

        return array(true, $response);
    }

    public function getResponseDetail($response = array()) {
        if (is_array($response)) {
            $str = $response['msg'];
        } else if (is_string($response) && strstr($response, 'msg=')) {
            $outputStr = str_replace('msg=', '', $response);
            $outputArr = explode('&', $outputStr);
            $str = $outputArr[0];
        } else {
            $str = $response;
        }

        $transactionResponseBean = new TransactionResponseBean();

        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($this->key);
        $transactionResponseBean->setIv($this->iv);

        $response = $transactionResponseBean->getResponsePayload();

        $array = explode("|", $response);
        $output = [];
        foreach ($array as $v) {
            list($key, $value) = explode("=", $v);
            $output[$key] = $value;
        }

        return $output;
    }

}
