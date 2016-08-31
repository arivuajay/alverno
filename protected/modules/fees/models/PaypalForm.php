<?php

class PaypalForm extends CFormModel
{
    public $amount;
 
    public function rules()
    {
        return array(
        	array('amount', 'required'),
            array('amount', 'type', 'type'=>'float', 'message'=>Yii::t('app', '{attribute} must be a valid number')),
        );
    }
}