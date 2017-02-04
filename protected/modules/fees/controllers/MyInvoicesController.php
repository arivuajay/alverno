<?php

class MyInvoicesController extends RController {

    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function actionIndex() {
        //user config
        $settings = UserSettings::model()->findByAttributes(array('user_id' => Yii::app()->user->id));

        //filtered invoices
        $search = new FeeInvoices;
        $search->uid = "";
        $search->is_paid = "";

        $page_size = 10;
        $criteria = new CDbCriteria;

        //conditions
        //invoice recipient
        if (isset($_REQUEST['FeeInvoices']['id']) and $_REQUEST['FeeInvoices']['id'] != NULL) {
            $search->id = $_REQUEST['FeeInvoices']['id'];
            $criteria->compare("`t`.`table_id`", $_REQUEST['FeeInvoices']['id']);
        }

        $guardian = Guardians::model()->findByAttributes(array('uid' => Yii::app()->user->id));
        $criteria->join = "JOIN `guardian_list` `gl` ON `gl`.`student_id`=`t`.`table_id`";
        $criteria->compare("`gl`.`guardian_id`", $guardian->id);

        $criteria->compare("`t`.`user_type`", 1); //student

        $criteria->order = "`id` DESC";
        $total = FeeInvoices::model()->count($criteria);
        $pages = new CPagination($total);
        $pages->setPageSize($page_size);
        $pages->applyLimit($criteria);
        $invoices = FeeInvoices::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->join = "JOIN `guardian_list` `gl` ON `gl`.`student_id`=`t`.`id`";
        $criteria->compare("`gl`.`guardian_id`", $guardian->id);
        $children = Students::model()->findAll($criteria);

        $this->render('index', array('search' => $search, 'invoices' => $invoices, 'pages' => $pages, 'item_count' => $total, 'page_size' => $page_size, 'children' => $children));
    }

    public function actionView($id) {
        $criteria = new CDbCriteria;
        $guardian = Guardians::model()->findByAttributes(array('uid' => Yii::app()->user->id));

        $criteria->join = "JOIN `guardian_list` `gl` ON `gl`.`student_id`=`t`.`table_id`";
        $criteria->compare("`t`.`user_type`", 1); //student
        $criteria->compare("`t`.`id`", $id);
        $criteria->compare("`gl`.`guardian_id`", $guardian->id);

        $invoice = FeeInvoices::model()->find($criteria);
        if ($invoice) {
            $criteria = new CDbCriteria;
            $criteria->compare("invoice_id", $id);
            $particulars = FeeInvoiceParticulars::model()->findAll($criteria);

            $current_payment_gateway = FeePaymentTypes::model()->paymentGateway();
            // check which payment gateway
            if ($current_payment_gateway == 1) { //paypal
                $gateway = new PaypalForm;

                if (isset($_POST['PaypalForm'])) {
                    $gateway->attributes = $_POST['PaypalForm'];
                    if ($gateway->validate()) {
                        $paymentInfo = array();
                        $paymentInfo['Order']['theTotal'] = $gateway->amount;
                        $paymentInfo['Order']['description'] = $invoice->name;
                        $paymentInfo['Order']['quantity'] = 1;

                        $transaction = new FeeTransactions;
                        $transaction->invoice_id = $invoice->id;
                        $transaction->date = date("Y-m-d H:i:s");
                        $transaction->payment_type = 1;
                        $transaction->amount = $gateway->amount;
                        $transaction->status = 0; //pending

                        if ($transaction->save()) {
                            Yii::app()->session['final_amount'] = $gateway->amount;
                            Yii::app()->session['transaction_id'] = $transaction->id;
                            Yii::app()->session['invoice_id'] = $invoice->id;

                            // call paypal
                            $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo);
                            //Detect Errors
                            if (!Yii::app()->Paypal->isCallSucceeded($result)) {
                                if (Yii::app()->Paypal->apiLive === true) {
                                    //Live mode basic error message
                                    $error = Yii::t('app', 'We were unable to process your request. Please try again later');
                                } else {
                                    //Sandbox output the actual error message to dive in.
                                    $error = Yii::t('app', (isset($result['L_LONGMESSAGE0'])) ? $result['L_LONGMESSAGE0'] : ((isset($result['Error']['Number'])) ? $result['Error']['Number'] : "Error found"));
                                }

                                Yii::app()->user->setFlash('error', $error);
                            } else {
                                // send user to paypal
                                $token = urldecode($result["TOKEN"]);

                                $payPalURL = Yii::app()->Paypal->paypalUrl . $token;
                                $this->redirect($payPalURL);
                            }
                        }
                    }
                }
            } else if ($current_payment_gateway == 5) { //IOB
                $gateway = new IbForm;

                if (isset($_POST['IbForm'])) {
                    $gateway->attributes = $_POST['IbForm'];
                    $gateway->pay_mode = $_POST['pay_mode'];

                    if ($gateway->validate()) {
                        $paymentInfo = array();
                        $paymentInfo['Order']['payMode'] = $gateway->pay_mode;
                        $paymentInfo['Order']['theTotal'] = $gateway->amount;
                        $paymentInfo['Order']['serviceCharge'] = $gateway->service_charge;
                        $paymentInfo['Order']['description'] = $invoice->name;
                        $paymentInfo['Order']['quantity'] = 1;

                        $transaction = new FeeTransactions;
                        $transaction->invoice_id = $invoice->id;
                        $transaction->date = $paymentInfo['Order']['date'] = date("Y-m-d H:i:s");
                        $transaction->payment_type = $current_payment_gateway;
                        $transaction->amount = $gateway->amount;
                        $transaction->status = 0; //pending

                        if ($transaction->save()) {
                            Yii::app()->session['final_amount'] = $gateway->amount;
                            Yii::app()->session['transaction_id'] = $paymentInfo['Order']['txn_id'] = $transaction->id;
                            Yii::app()->session['invoice_id'] = $invoice->id;

                            // call IB
                            list($rState, $request) = Yii::app()->Ib->addRequestParam($paymentInfo);
                            if (!$rState) {
                                Yii::app()->user->setFlash('info', $request);
                            } else {
                                $this->redirect($request);
                            }
                        }
                    }
                }
            }

            $this->render('view', array('invoice' => $invoice, 'particulars' => $particulars, 'gateway' => $gateway));
        } else {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionPay($id) {
        $criteria = new CDbCriteria;
        $guardian = Guardians::model()->findByAttributes(array('uid' => Yii::app()->user->id));

        $criteria->join = "JOIN `guardian_list` `gl` ON `gl`.`student_id`=`t`.`table_id`";
        $criteria->compare("`t`.`user_type`", 1); //student
        $criteria->compare("`t`.`id`", $id);
        $criteria->compare("`gl`.`guardian_id`", $guardian->id);

        $invoice = FeeInvoices::model()->find($criteria);
        if ($invoice) {
            $invoice->amount_paid = $invoice->total_amount;
            $invoice->is_paid = 1;
            if ($invoice->save()) {
                //redirect after procesing
                $this->redirect(array("/fees/invoices/view", 'id' => $id));
            }
        } else {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionPrint($id) {
        $invoice = FeeInvoices::model()->findByPk($id);
        if ($invoice) {
            $criteria = new CDbCriteria;
            $criteria->compare("invoice_id", $id);
            $particulars = FeeInvoiceParticulars::model()->findAll($criteria);
            //$this->renderPartial('_print', array('invoice'=>$invoice, 'particulars'=>$particulars));exit;
            $pdf_name = "invoice.pdf";
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->setDefaultFont('freesans');
            $html2pdf->WriteHTML($this->renderPartial('_print', array('invoice' => $invoice, 'particulars' => $particulars), true));
            $html2pdf->Output($pdf_name);
        } else {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
