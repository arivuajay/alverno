<?php

class FinanceFeesController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','Payfees','unpaid','unpaidpdf','allpaidpdf','printreceipt','cashregister','partialfees','partialreceipt'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FinanceFees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FinanceFees']))
		{
			$model->attributes=$_POST['FinanceFees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FinanceFees']))
		{
			$model->attributes=$_POST['FinanceFees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,Yii::t('app','Invalid request. Please do not repeat this request again.'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FinanceFees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionUnpaid()
	{
		
		$this->render('unpaid');
	}
	public function actionAllpaid()
	{
		
		$this->render('allpaid');
	}
	public function actionPrintreceipt()
	{
		$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$student = $student->first_name.' '.$student->last_name.' Fees Receipt.pdf';
		//saving receipt details
		$receipt = FeeReceipt::model()->findByAttributes(array('student'=>$_REQUEST['id'],'batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['collection']));
		if($receipt==NULL){
			$newReceipt	=	new FeeReceipt;
			$newReceipt->student	=	$_REQUEST['id'];
			$newReceipt->batch		=	$_REQUEST['batch'];
			$newReceipt->collection	=	$_REQUEST['collection'];
			if($newReceipt->validate()){
				$newReceipt->save();
				$receipt_no	=	$newReceipt->id;
			}
		}
		else{
			$receipt_no	=	$receipt->id;
		}
		
		# HTML2PDF has very similar syntax
				  
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('printreceipt', array('batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['course'],'id'=>$posts->id,'receipt_no'=>$receipt_no), true));
        $html2pdf->Output($student);
		//$this->render('printreceipt');
	}
	
	public function actionPartialreceipt()
	{
		$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$student = $student->first_name.' '.$student->last_name.' Fees Receipt.pdf';
		//saving receipt details
		$receipt = FeeReceipt::model()->findByAttributes(array('student'=>$_REQUEST['id'],'batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['collection']));
		if($receipt==NULL){
			$newReceipt	=	new FeeReceipt;
			$newReceipt->student	=	$_REQUEST['id'];
			$newReceipt->batch		=	$_REQUEST['batch'];
			$newReceipt->collection	=	$_REQUEST['collection'];
			if($newReceipt->validate()){
				$newReceipt->save();
				$receipt_no	=	$newReceipt->id;
			}
		}
		else{
			$receipt_no	=	$receipt->id;
		}
		
		# HTML2PDF has very similar syntax
				  
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('partialreceipt', array('batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['course'],'id'=>$posts->id,'receipt_no'=>$receipt_no), true));
        $html2pdf->Output($student);
		//$this->render('printreceipt');
	}
	
	public function actionPaid()
	{
		
		$this->render('paid');
	}
	public function actionPayfees()
	{
		$list  = FinanceFees::model()->findByAttributes(array('id'=>$_GET['val1']));
		$list->fees_paid = $_GET['fees'];
		$list->is_paid = 1;
		$list->save();
		echo 'Paid';
		exit;
		
	}
	public function actionPartialfees()
	{
		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        {
			$model = $this->loadModel($_POST['FinanceFees']['id']);
			$student = Students::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['student_id']));
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['fee_collection_id']));
			$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
					if(count($check_admission_no)>0){ // If any particular is present for this student
						$adm_amount = 0;
						foreach($check_admission_no as $adm_no){
							$adm_amount = $adm_amount + $adm_no->amount;
						}
						$fees = $adm_amount;						
					}
					else{ // If any particular is present for this student category
						$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
						if(count($check_student_category)>0){
							$cat_amount = 0;
							foreach($check_student_category as $stu_cat){
								$cat_amount = $cat_amount + $stu_cat->amount;
							}
							$fees = $cat_amount;
							
						}
						else{ //If no particular is present for this student or student category
							$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
							if(count($check_all)>0){
								$all_amount = 0;
								foreach($check_all as $all){
									$all_amount = $all_amount + $all->amount;
								}
								$fees = $all_amount;
							}
							else{
								$fees = 0; // If no particular is found.
							}
						}
					}
			
		}
		elseif(isset($_REQUEST['id']))
		{
			$model  = $this->loadModel($_REQUEST['id']);
		}
        // Flag to know if we will render the form or try to add 
        // new jon.
        $flag=true;
        if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        { 
		
		if($_POST['FinanceFees']['fees_paid']==NULL)
		{
			echo CJSON::encode(array(
					'status'=>'error',
					'errors'=>CActiveForm::validate($model),					
				));
				exit;
		}
			$flag = false;			
			$fees_paid = $model->fees_paid + $_POST['FinanceFees']['fees_paid'];
			$model->fees_paid = $_POST['FinanceFees']['fees_paid'];
			if(!$model->validate()) 
			{
				echo CJSON::encode(array(
					'status'=>'error',
					'errors'=>CActiveForm::validate($model),
					//'errors'=>array('FinanceFees_fees_paid'=>'Fees cannot be blank')
				));
				exit;
			}
			
			else
			{
				
			if($model->saveAttributes(array('fees_paid'=>$fees_paid)))
			//if($model->save())
			{
				if($fees <= $fees_paid)
				{
					$model->saveAttributes(array('is_paid'=>1));	
				}
						echo CJSON::encode(array(
									'status'=>'success',
									));
							 exit;    
											
						}
			}
			}
			if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('partialfees',array('model'=>$model),false,true);
			}
		
		
	}
	
	public function actionEditfees()
	{
		
		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        {
			$model = $this->loadModel($_POST['FinanceFees']['id']);
			$student = Students::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['student_id']));
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['fee_collection_id']));
			$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
			if(count($check_admission_no)>0){ // If any particular is present for this student
				$adm_amount = 0;
				foreach($check_admission_no as $adm_no){
					$adm_amount = $adm_amount + $adm_no->amount;
				}
				$fees = $adm_amount;						
			}
			else{ // If any particular is present for this student category
				$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
				if(count($check_student_category)>0){
					$cat_amount = 0;
					foreach($check_student_category as $stu_cat){
						$cat_amount = $cat_amount + $stu_cat->amount;
					}
					$fees = $cat_amount;
					
				}
				else{ //If no particular is present for this student or student category
					$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
					if(count($check_all)>0){
						$all_amount = 0;
						foreach($check_all as $all){
							$all_amount = $all_amount + $all->amount;
						}
						$fees = $all_amount;
					}
					else{
						$fees = 0; // If no particular is found.
					}
				}
			}
			
		}
		elseif(isset($_REQUEST['id']))
		{
			$model  = $this->loadModel($_REQUEST['id']);
		}
		// Flag to know if we will render the form or try to add 
        // new json.
        $flag=true;
		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        { 
			$flag = false;
			if($_POST['FinanceFees']['fees_paid']==NULL)
			{
				echo CJSON::encode(array(
						'status'=>'error',
						'errors'=>CActiveForm::validate($model),					
					));
					exit;
			}
			$fees_paid = $_POST['FinanceFees']['fees_paid'];
			
			$model->fees_paid = $_POST['FinanceFees']['fees_paid'];
			if(!$model->validate()) 
			{
				echo CJSON::encode(array(
					'status'=>'error',
					'errors'=>CActiveForm::validate($model),
					//'errors'=>array('FinanceFees_fees_paid'=>'Fees cannot be blank')
				));
				exit;
			}else{
			
				if($model->saveAttributes(array('fees_paid'=>$fees_paid)))
				//if($model->save())
				{
					if($fees == $fees_paid)
					{
						$model->saveAttributes(array('is_paid'=>1));	
					}
					elseif($fees != $fees_paid and $model->is_paid == 1)
					{
						$model->saveAttributes(array('is_paid'=>0));
					}
					echo CJSON::encode(array(
							'status'=>'success',
							));
					exit;      
				}
				else
				{
					echo CJSON::encode(array(
							'status'=>'error',
							));
					 exit;    
				}
			}
		}
		if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('partialfees',array('model'=>$model),false,true);
		}
	}
	
	/*public function loadModel($id)
	{
		$model=FinanceFees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/
	/*public function actionUnpaidpdf()
	 {
		 $collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
//$particular = FinanceFeeParticulars::model()->findByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id));
$data = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
		
	$amount = 0;
		 
         

	 Yii::import('application.extensions.fpdf.*');
     require('fpdf.php');
	 $pdf = new FPDF();
     $pdf->AddPage();
     $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(75,10,'Unpaid Students',0,0,'C');
	 $pdf->Ln();
	 $pdf->Ln();
	 $pdf->SetFont('Arial','BU',10);
	 
	 $w= array(40,40,40,60);

	 $header = array('Sl.No','Student Name','Fees');
	
    //Header
    for($i=0;$i<count($header);$i++)
	{
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',false);
    
	}
     $pdf->Ln();
	 $pdf->SetFont('Arial','',10);

	 $fill=false;
	 $i=40;
	 foreach($data as $data1)
	 {
	 
	 $amount = $amount + $data1->amount;
	 $list  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
	}
	 $j = 1;
		 foreach($list as $list_1)
		 {
			 $posts=Students::model()->findByAttributes(array('id'=>$list_1->student_id));
			 $pdf->Cell($i,6,$j,1,0,'C',$fill);
			 $pdf->Cell($i,6,$posts->first_name,1,0,'L',$fill);
	 		$pdf->Cell($i,6,$amount,1,0,'C',$fill);
	 		$pdf->Ln();
			$j++;
	 
	 }
     $pdf->Output();
	 Yii::app()->end();
	 }*/
	 
	public function actionUnpaidpdf()
    {
        $batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
		$batch_name = $batch_name->name.Yii::t('app',' Students With Pending Fees.pdf');
		
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('unpaidpdf',array('model'=>$_REQUEST['collection']), true));
        $html2pdf->Output($batch_name);
 
	}
	
	public function actionAllpaidpdf()
    {
        $batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
		$batch_name = $batch_name->name.Yii::t('app',' Students Paind and Unpaid Fees.pdf');
		
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('allpaidpdf',array('model'=>$_REQUEST['collection']), true));
        $html2pdf->Output($batch_name);
 
	}
	 
	 
	 public function actionCashregister(){

		  if(isset($_POST['search']))
		{
			
			$criteria = new CDbCriteria;
				if(isset($_POST['student_id']) and $_POST['student_id']!=NULL)
				{
					
					
					$criteria->condition='id LIKE :match';
		 			$criteria->params = array(':match' =>$_POST['student_id'].'%');
					
					
			
				}
				
			$total = Students::model()->count($criteria);
			$pages = new CPagination($total);
      	    $pages->setPageSize(Yii::app()->params['listPerPage']);
			$pages->applyLimit($criteria);  // the trick is here!
			$posts = Students::model()->findAll($criteria);
			$this->render('cashregister',array('model'=>$model,
			'list'=>$posts,
			'pages' => $pages,
			'item_count'=>$total,
			'page_size'=>Yii::app()->params['listPerPage'],
			));	
		}

		$this->render('cashregister');
		
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FinanceFees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FinanceFees']))
			$model->attributes=$_GET['FinanceFees'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=FinanceFees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='finance-fees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
	public function actionPrec(){
		$this->renderPartial('printreceipt');
	}
	
	public function actionSendsms(){
		/*echo 'Batch ID: '.$_REQUEST['batch_id'].'<br/>';
		echo 'Fee Collection ID: '.$_REQUEST['collection'].'<br/>';
		echo 'Days in between: '.$_REQUEST['date_status'].'<br/>';
		echo 'Amount: '.$_REQUEST['amount'].'<br/>';*/
		$notification = NotificationSettings::model()->findByAttributes(array('id'=>8));
		$college=Configurations::model()->findByPk(1);
		if($notification->sms_enabled=='1' or $notification->mail_enabled=='1' or $notification->msg_enabled=='1') // Checking if SMS or mail or message is enabled.
		{
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
			
			$unpaid_students  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL)
			{	
				$collection->due_date=date($settings->displaydate,strtotime($collection->due_date));				
			}
			foreach ($unpaid_students as $unpaid_student){
				
				$student=Students::model()->findByAttributes(array('id'=>$unpaid_student->student_id));
				$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
				
				$to_parent = '';
				$to_student = '';
				$message = '';
				if(count($guardian)!=0 and $guardian->mobile_phone!=NULL){ // If guardian is added
					$to_parent = $guardian->mobile_phone;
				}
				if($student->phone1){ // Checking if phone number is provided
					$to_student = $student->phone1;	
				}
				elseif($student->phone2){
					$to_student = $student->phone2;
				}
				
				$from = $college->config_value;
				// Checking the days between the current date and due date. And, the customising the message accordingly
				if($_REQUEST['date_status']<1){
					
					$template=SystemTemplates::model()->findByPk(19);
					$message = $template->template;
					$message = str_replace("<Fee Collection Name>",$collection->name,$message);
					$message = str_replace("<Due Date>",$collection->due_date,$message);
					$template=SystemTemplates::model()->findByPk(16);
					$message1 = $template->template;
					$message1 = str_replace("<Fee Collection Name>",$collection->name,$message1);
					$message1 = str_replace("<Due Date>",$collection->due_date,$message1);
					
					
				}
				elseif($_REQUEST['date_status']>1 and $_REQUEST['date_status']<=7){
					
					$template=SystemTemplates::model()->findByPk(17);
					$message = $template->template;
					$message = str_replace("<Fee Collection Name>",$collection->name,$message);
					$message = str_replace("<Due Date>",$collection->due_date,$message);
					$template=SystemTemplates::model()->findByPk(14);
					$message1 = $template->template;
					$message1 = str_replace("<Fee Collection Name>",$collection->name,$message1);
					$message1 = str_replace("<Due Date>",$collection->due_date,$message1);
					
				}
				elseif($_REQUEST['date_status']==1){
					
					$template=SystemTemplates::model()->findByPk(18);
					$message = $template->template;
					$message = str_replace("<Fee Collection Name>",$collection->name,$message);
					$message = str_replace("<Due Date>",$collection->due_date,$message);
					$template=SystemTemplates::model()->findByPk(15);
					$message1 = $template->template;
					$message1 = str_replace("<Fee Collection Name>",$collection->name,$message1);
					$message1 = str_replace("<Due Date>",$collection->due_date,$message1);
					
				}
				//echo 'Message: '.$message.'<br/><br/>';
				if($message!=''){ // Send SMS if message is set
				
					if($to_parent!='' and $notification->sms_enabled=='1' and $notification->parent_1=='1'){ // If unpaid and parent phone number is provided, send SMS
						SmsSettings::model()->sendSms($to_parent,$from,$message1);
					} // End check if parent phone number is provided
					
					if($to_student!='' and $notification->sms_enabled=='1' and $notification->student=='1'){ // If unpaid and student phone number is provided, send SMS
						SmsSettings::model()->sendSms($to_student,$from,$message);
					} // End check if student phone number is provided
										
				} // End check if message is set
							
			//Send Mail		
				if($notification->mail_enabled=='1')
				{					
					if($notification->student == '1')
					{
						$template=EmailTemplates::model()->findByPk(12);
						$subject = $template->subject;
						$message = $template->template;
						$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);
						
						$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
						$message = str_replace("{{FEE COLLECTION NAME}}",$collection->name,$message);
						$message = str_replace("{{DUE DATE}}",$collection->due_date,$message);
																					
						UserModule::sendMail($student->email,$subject,$message);
					}					
					if($notification->parent_1 == '1')
					{
						$template=EmailTemplates::model()->findByPk(13);
						$subject = $template->subject;
						$message = $template->template;
						$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);						
						$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
						$message = str_replace("{{FEE COLLECTION NAME}}",$collection->name,$message);
						$message = str_replace("{{DUE DATE}}",$collection->due_date,$message);
																				
						UserModule::sendMail($guardian->email,$subject,$message);
					}					
				}
		//Send Message		
				if($notification->msg_enabled=='1') // Send Message
				{
					$to_parent = $guardian->uid;
					$to_student = $student->uid;
					$subject = Yii::t('app','Reminder to pay Fees');
					$message =Yii::t('app','The due date to pay ').$collection->name.Yii::t('app',' fees is/was ').$collection->due_date;
					if($notification->student=='1')
					{
						NotificationSettings::model()->sendMessage($to_student,$subject,$message);
					}
					if($notification->parent_1=='1')
					{						
						NotificationSettings::model()->sendMessage($to_parent,$subject,$message);
					}
					
				}
			} // End for each student
			Yii::app()->user->setFlash('notification',Yii::t('app','Notifications send Successfully!'));
			//exit;
		} // End check whether SMS is enabled
		$this->redirect(array('unpaid','batch'=>$_REQUEST['batch_id'],'course'=>$_REQUEST['collection']));
	} // End send SMS function
}
