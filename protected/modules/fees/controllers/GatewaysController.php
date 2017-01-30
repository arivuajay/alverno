<?php

class GatewaysController extends RController {

    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function actionSettings() {
        $current_payment_gateway = FeePaymentTypes::model()->paymentGateway();

        if ($current_payment_gateway == 1) {
            $gateway = PaypalConfig::model()->find();
            if ($gateway == NULL)
                $gateway = new PaypalConfig;
        }else if ($current_payment_gateway == 5) {
            $gateway = IbConfig::model()->find();
            if ($gateway == NULL)
                $gateway = new IbConfig;
        }

        if (isset($_POST['PaypalConfig'])) {
            $gateway->attributes = $_POST['PaypalConfig'];
            $gateway->created_by = Yii::app()->user->id;
            if ($gateway->save()) {
                $this->redirect(array('settings'));
            }
        } else if (isset($_POST['IbConfig'])) {
            $gateway->attributes = $_POST['IbConfig'];
            $gateway->created_by = Yii::app()->user->id;
            if ($gateway->save()) {
                $this->redirect(array('settings'));
            }
        }

        $this->render('settings', array('gateway' => $gateway));
    }

}
