<?php

class IbForm extends CFormModel {

    public $pay_mode;
    public $amount;
    public $service_charge;

    public function rules() {
        return array(
            array('pay_mode, amount,service_charge', 'required'),
            array('amount', 'type', 'type' => 'float', 'message' => Yii::t('app', '{attribute} must be a valid number')),
        );
    }

}
