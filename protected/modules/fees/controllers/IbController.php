<?php

class IbController extends RController {

//	public function filters()
//	{
//		return array(
//			'rights', // perform access control for CRUD operations
//		);
//	}

    public function actionConfirm() {
        list($response, $unclean_response) = Yii::app()->Ib->getResponseDetail($_POST);
        $invoice_id = Yii::app()->session['invoice_id'];
        $transaction_id = Yii::app()->session['transaction_id'];
        $transaction = FeeTransactions::model()->findByPk($transaction_id);

        if (isset($response['txn_status'])) {
            //payment was completed successfully

            if ($transaction != NULL) {
                $transaction->responseparams = $unclean_response;
                $transaction->transaction_log = json_encode($response);
                $transaction->transaction_id = @$response['tpsl_txn_id'];

                if (!$transaction->amount)
                    $transaction->amount = Yii::app()->session['final_amount'];
                if (@$response['tpsl_txn_time'])
                    $transaction->date = date('Y-m-d H:i:s', strtotime($response['tpsl_txn_time']));

                if ($response['txn_msg'] == 'success') {
                    $transaction->status = 1;
                    $success = Yii::t('app', 'Your transaction is completed successfully.');
                } else if (isset($response['txn_err_msg']) && !empty($response['txn_err_msg'])) {
                    $transaction->status = -1;
                    $transaction->description = $response['txn_err_msg'];
                    $error = $response['txn_err_msg'];
                }

                if ($transaction->save()) {
                    // Unset the sessions set during buy action
                    unset(Yii::app()->session['final_amount']);
                    unset(Yii::app()->session['transaction_id']);
                    unset(Yii::app()->session['invoice_id']);
                    unset(Yii::app()->session['pay_mode']);
                }
            } else {
                $error = Yii::t('app', "We were unable find transaction '{$transaction_id}'. Contact Support Team");
            }
        } else {
            $error = Yii::t('app', 'We were unable to process your request. Please try again later');
        }

        if ($error != NULL)
            Yii::app()->user->setFlash('error', $error);
        if ($success != NULL)
            Yii::app()->user->setFlash('success', $success);

        $this->redirect(array('/fees/myInvoices/view', 'id' => $invoice_id));
    }

}
