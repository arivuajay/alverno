<?php

/**
 * This is the model class for table "fee_ib_config".
 *
 * The followings are the available columns in table 'fee_ib_config':
 * @property integer $id
 * @property string $mrctCode
 * @property string $currencyType
 * @property string $bankCode
 * @property string $locatorURL
 * @property string $scheme_code
 * @property string $key
 * @property string $iv
 * @property string $sc_cc
 * @property string $sc_dc_ll
 * @property string $sc_dc_ul
 * @property string $sc_net_bank
 * @property integer $created_by
 */
class IbConfig extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return IbConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'fee_ib_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mrctCode, currencyType, bankCode,scheme_code, key, iv, created_by', 'required'),
            array('created_by', 'numerical', 'integerOnly' => true),
            array('mrctCode, bankCode', 'length', 'max' => 100),
            array('currencyType, sc_cc, sc_dc_ll, sc_dc_ul, sc_net_bank', 'length', 'max' => 10),
            array('locatorURL', 'length', 'max' => 13),
            array('scheme_code, key, iv', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, mrctCode, currencyType, bankCode, locatorURL,scheme_code, key, iv, sc_cc, sc_dc_ll, sc_dc_ul, sc_net_bank, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'mrctCode' => 'Mrct Code',
            'currencyType' => 'Currency Type',
            'bankCode' => 'Bank Code',
            'locatorURL' => 'Locator Url',
            'scheme_code' => 'Scheme Code',
            'key' => 'ENCRYPTION KEY',
            'iv' => 'ENCRYPTION IV',
            'sc_cc' => 'Service Charge Credit Card',
            'sc_dc_ll' => 'Service Charge Debit Card Upto Rs.2000',
            'sc_dc_ul' => 'Service Charge Debit Card above Rs.2000',
            'sc_net_bank' => 'Service Charge Net Banking of Other Banks',
            'created_by' => 'Created By',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('mrctCode', $this->mrctCode, true);
        $criteria->compare('currencyType', $this->currencyType, true);
        $criteria->compare('bankCode', $this->bankCode, true);
        $criteria->compare('locatorURL', $this->locatorURL, true);
        $criteria->compare('scheme_code', $this->scheme_code, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('iv', $this->iv, true);
        $criteria->compare('sc_cc', $this->sc_cc, true);
        $criteria->compare('sc_dc_ll', $this->sc_dc_ll, true);
        $criteria->compare('sc_dc_ul', $this->sc_dc_ul, true);
        $criteria->compare('sc_net_bank', $this->sc_net_bank, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getLocurlvalue($key = null) {
        $_array = array(
            'TEST' => 'https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl',
            'E2EWithIP' => 'http://10.10.60.46:8080/PaymentGateway/services/TransactionDetailsNew',
            'E2EWithDomain' => 'https://tpslvksrv6046/PaymentGateway/services/TransactionDetailsNew',
            'UATWithDomain' => 'https://www.tekprocess.co.in/PaymentGateway/services/TransactionDetailsNew',
            'UATWithIP' => 'http://10.10.102.157:8081/PaymentGateway/services/TransactionDetailsNew',
            'EAP UATWithIP' => 'http://10.10.102.158:8081/PaymentGateway/services/TransactionDetailsNew',
            'LIVE' => 'https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl',
            'Linux E2E' => 'http://10.10.60.247:8080/PaymentGateway/services/TransactionDetailsNew',
        );

        if (!is_null($key))
            return $_array[$key];

        return $_array;
    }

}
