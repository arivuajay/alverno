<?php

class IbForm extends CFormModel {

    public $amount;
    public $service_charge;

    public function rules() {
        return array(
            array('amount,service_charge', 'required'),
            array('amount', 'type', 'type' => 'float', 'message' => Yii::t('app', '{attribute} must be a valid number')),
        );
    }

}
