<?php
class TransactionsController extends RController
{
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	
	public function actionAdd(){
		$transaction	= new FeeTransactions;
		if(isset($_POST["FeeTransactions"]) and Yii::app()->request->isAjaxRequest){
			$transaction->attributes	= $_POST["FeeTransactions"];
			if($_POST["FeeTransactions"]["date"]!=NULL and $_POST["FeeTransactions"]["date"]!="")
				$transaction->date			= date("Y-m-d H:i:s", strtotime($_POST["FeeTransactions"]["date"]));

			$obj_img		=	CUploadedFile::getInstance($transaction,'proof');
			if($obj_img!=NULL){
				$transaction->proof			=	$obj_img;
				$transaction->proof_type	=	$obj_img->type;
			}

			if($transaction->validate() and $transaction->save()){
				if($obj_img!=NULL){
					$path	=	'uploads/transaction_proof/';
					if(!is_dir($path)){
						mkdir($path);
					}
					$path	.= $transaction->id.'/';
					if(!is_dir($path)){
						mkdir($path);
					}					
					//generate random image name
					$randomImage	=	$this->generateRandomString(rand(10,15)).'.'.$obj_img->extensionName;
					
					if(!$obj_img->saveAs($path.$randomImage)){
						$transaction->proof	=	NULL;							
					}
					else{
						$transaction->proof	=	$randomImage;
					}			
					$transaction->save();		
				}


				$criteria		= new CDbCriteria;
				$criteria->compare('invoice_id', $transaction->invoice_id);
				$alltransactions	= FeeTransactions::model()->findAll($criteria);
				$settings		= UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				$row			= $this->renderPartial("application.modules.fees.views.transactions._transaction", array("count"=>count($alltransactions), "transaction"=>$transaction, 'settings'=>$settings), true);
				echo json_encode(array("status"=>"success", "row"=>$row));
			}
			else{
				echo json_encode(array(
					"status"=>"error",
					"errors"=>json_decode(CActiveForm::validate($transaction))
				));
			}
		}
	}

	public function actionRemove(){
		$response	= array("status"=>"error");
		if(Yii::app()->request->isAjaxRequest and isset($_POST['id'])){
			$id 			= $_POST['id'];
			$transaction 	= FeeTransactions::model()->findByPk($id);
			if($transaction!=NULL){
				$transaction->is_deleted	= 1;
				$transaction->deleted_by	= Yii::app()->user->id;
				if($transaction->save())
					$response['status']	= "success";
			}
		}

		echo json_encode($response);
		Yii::app()->end();
	}

	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function actionDownload($id){
		$transaction 	= FeeTransactions::model()->findByAttributes(array('id'=>$id, 'is_deleted'=>0));
		if($transaction!=NULL and $transaction->proof!=NULL){
			$file 	= $transaction->proof;
			$path 	= "uploads/transaction_proof/" . $transaction->id . "/" . $file;
			if (file_exists($path)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.basename($file).'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($path));
			    readfile($path);
			    exit;
			}
		}
		else{
			throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
	}
}