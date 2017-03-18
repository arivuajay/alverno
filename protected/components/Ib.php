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

    protected $APICred = [
        'CC' => ['mrctCode' => 'L135123','scheme_code'=>'Vani','key'=>'8000453122IFPXYK','iv'=>'9534092042EKOCTP'],
        'DC' => ['mrctCode' => 'L135124','scheme_code'=>'Vani','key'=>'4562285868SXTCYY','iv'=>'5290732622QXGLGP'],
        'NB' => ['mrctCode' => 'L131352','scheme_code'=>'Vani ','key'=>'3556621102SUSRVD','iv'=>'7916019637XOEHMY'],
    ];

    public function init() {
        $ibconfig = IbConfig::model()->findByPk(1);
        $this->bankCode = $ibconfig->bankCode;
        $this->locatorURL = IbConfig::getLocurlvalue($ibconfig->locatorURL);

        if ($ibconfig->currencyType)
            $this->currencyType = $ibconfig->currencyType;
    }

    public function __construct() {

    }

    public function addRequestParam($paymentInfo = array()) {
        $APICred = $this->APICred[Yii::app()->session['pay_mode']];
        $this->mrctCode = $APICred['mrctCode'];
        $this->scheme_code = $APICred['scheme_code'];
        $this->key = $APICred['key'];
        $this->iv = $APICred['iv'];
        
        if(in_array(Yii::app()->session['pay_mode'],array('DC'))){
            $amt = number_format((float) $paymentInfo['Order']['theTotal'], 2, '.', '');
        }else{
            $amt = number_format((float) $paymentInfo['Order']['theTotal'] + $paymentInfo['Order']['serviceCharge'], 2, '.', '');
        }

        $transactionRequestBean = new TransactionRequestBean();
        //Setting all values here
        $txnNo = $paymentInfo['Order']['txn_id'];
        $req_detail = "{$this->scheme_code}_{$amt}_0.0";
        $customerId = $paymentInfo['Order']['CustomerId'];
        $customerName = $paymentInfo['Order']['CustomerName'];
        $tpsl_txn_id = 'TXN00'.rand(1,10000);
        
        $transactionRequestBean->setMerchantCode($this->mrctCode);
        $transactionRequestBean->setAccountNo('');
        $transactionRequestBean->setITC('');
        $transactionRequestBean->setMobileNumber('');
        $transactionRequestBean->setCustomerName($customerName);
        $transactionRequestBean->setRequestType($this->requestType);
        $transactionRequestBean->setMerchantTxnRefNumber($txnNo);
        $transactionRequestBean->setAmount($amt);
        $transactionRequestBean->setCurrencyCode($this->currencyType);
        $transactionRequestBean->setReturnURL(Yii::app()->createAbsoluteUrl($this->returnURL));
        $transactionRequestBean->setS2SReturnURL($this->s2SReturnURL);
        $transactionRequestBean->setShoppingCartDetails($req_detail);
        $transactionRequestBean->setTxnDate(date('d-m-Y'));
        $transactionRequestBean->setBankCode($this->bankCode);
        $transactionRequestBean->setTPSLTxnID($tpsl_txn_id);
        $transactionRequestBean->setCustId($customerId);
        $transactionRequestBean->setCardId('');
        $transactionRequestBean->setKey($this->key);
        $transactionRequestBean->setIv($this->iv);
        $transactionRequestBean->setWebServiceLocator($this->locatorURL);
        $transactionRequestBean->setMMID('');
        $transactionRequestBean->setOTP('');
        $transactionRequestBean->setCardName('');
        $transactionRequestBean->setCardNo('');
        $transactionRequestBean->setCardCVV('');
        $transactionRequestBean->setCardExpMM('');
        $transactionRequestBean->setCardExpYY('');
        $transactionRequestBean->setTimeOut($this->timeOut);
    
        $requestParams = print_r($transactionRequestBean, true);

        $responseDetails = $transactionRequestBean->getTransactionToken();
        $responseDetails = (array) $responseDetails;
        $response = $responseDetails[0];

        if (is_string($response) && preg_match('/^msg=/', $response)) {
            $outputStr = str_replace('msg=', '', $response);
            $outputArr = explode('&', $outputStr);
            $str = $outputArr[0];

            $transactionResponseBean = new TransactionResponseBean();
            $transactionResponseBean->setResponsePayload($str);
            $transactionResponseBean->setKey($this->key);
            $transactionResponseBean->setIv($this->iv);

            $response = $transactionResponseBean->getResponsePayload();
            return array(false, implode(', ', $response), $requestParams);
        } elseif (is_string($response) && preg_match('/^txn_status=/', $response)) {
            return array(false, implode(', ', $response), $requestParams);
        }

        return array(true, $response, $requestParams);
    }

    public function getResponseDetail($response = array()) {
        $APICred = $this->APICred[Yii::app()->session['pay_mode']];
        $this->key = $APICred['key'];
        $this->iv = $APICred['iv'];
        
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

        return array($output, $response);
    }

}
