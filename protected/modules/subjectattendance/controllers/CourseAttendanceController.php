<?php

class CourseAttendanceController extends RController
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
				'actions'=>array('index','view','Addnew','Attentancepdf','Pdf','Attentstud','Pdf1','studentattendancepdf'),
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
		$model=new StudentAttentance;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StudentAttentance']))
		{
			$model->attributes=$_POST['StudentAttentance'];
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

		if(isset($_POST['StudentAttentance']))
		{
			$model->attributes=$_POST['StudentAttentance'];
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$dataProvider=new CActiveDataProvider('StudentAttentance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
		public function actionAddnew() 
		{
			$model=new StudentAttentance;
			// Ajax Validation enabled
			$this->performAjaxValidation($model);
			// Flag to know if we will render the form or try to add 
			// new jon.
			$flag=true;
			if(isset($_POST['StudentAttentance']))
			{       
				$flag=false;
				$model->attributes=$_POST['StudentAttentance'];
				if(isset($_POST['StudentAttentance']))
			{       
				$flag=false;
				$model->attributes=$_POST['StudentAttentance'];
				if(!$model->validate()) {
					echo CJSON::encode(array(
						'status'=>'error',
						'errors'=>CActiveForm::validate($model)
				));
			}
			else{
				if($model->save()) 
				{
					$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
					if($settings!=NULL)
					{	
						$date=date($settings->displaydate,strtotime($model->date));
					}
					
					//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
					ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'8',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);
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
			}
			if($flag) 
			{
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('create',array('model'=>$model,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id']),false,true);
			}
		}
	
	/*
		edit the marked leave
		*/
		
	public function actionEditLeave()
	{
		$model=StudentAttentance::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		// Ajax Validation enabled
		//$this->performAjaxValidation($model);
		// Flag to know if we will render the form or try to add 
		// new jon.
		$flag=true;
		if(isset($_POST['StudentAttentance']))
		{    
			$old_model = $model->attributes;    
			$flag=false;
			$model->attributes=$_POST['StudentAttentance'];
			if($_POST['StudentAttentance']['reason'] == NULL)
			{
				echo CJSON::encode(array(
									'status'=>'error',
									));
							 exit;    
			}
			else
			{
			
				if($model->save()) 
				{
					$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
					if($settings!=NULL)
					{	$date=date($settings->displaydate,strtotime($model->date));
				
					}
					
					
					// Saving to activity feed
					$results = array_diff_assoc($_POST['StudentAttentance'],$old_model); // To get the fields that are modified.
					//print_r($old_model);echo '<br/><br/>';print_r($_POST['Students']);echo '<br/><br/>';print_r($results);echo '<br/><br/>'.count($results);echo '<br/><br/>';
					foreach($results as $key => $value)
					{
						if($key != 'date')
						{
							//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
							ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'9',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$model->getAttributeLabel($key),$date,$value);
						}
						
					}	
					//END saving to activity feed	
	
				}
				echo CJSON::encode(array(
									'status'=>'success',
									));
			}
		}
		// var_dump($model->geterrors());
		if($flag) {
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		
		
		$this->renderPartial('update',array('model'=>$model,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id']),false,true);
		}
	}
		/* Delete the marked leave
		*/
	public function actionDeleteLeave()
	{
		$flag=true;
		$model=StudentAttentance::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$attendance=StudentAttentance::model()->DeleteAllByAttributes(array('id'=>$_REQUEST['id']));
		$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		if($settings!=NULL)
		{	
			$date=date($settings->displaydate,strtotime($model->date));	
		}
		
		//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
		ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'10',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);
		
		 if($flag) {
                   
				    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					$this->renderPartial('update',array('model'=>$model,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id']),false,true);
					
	}			  
		
	
	}
	
	
		
	public function actionAttentancepdf()
	{
		//$this->layout='';
		//header("Content-type: image/jpeg");
		//echo $model->photo_data;
		$this->render('printpdf',array(
			'model'=>$this->loadModel($_REQUEST['id']),
		));
	}
	 public function actionPdf()
    {
        
		$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$batch_name = $batch_name->name.' Student Attendance.pdf';
		
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf = new HTML2PDF('L', 'A4', 'en');
        $html2pdf->WriteHTML($this->renderPartial('attentancepdf', array(), true));
        $html2pdf->Output($batch_name);
 
        ////////////////////////////////////////////////////////////////////////////////////
	}
	public function actionAttentstud()
	{
		//$this->layout='';
		//header("Content-type: image/jpeg");
		//echo $model->photo_data;
		$this->render('printpdf',array(
			'model'=>$this->loadModel($_REQUEST['id']),
		));
	}
	 public function actionPdf1()
    {
        
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();

        $html2pdf->WriteHTML($this->renderPartial('attentstud', array('model'=>StudentAttentance::model()->findByAttributes(array('student_id'=>$_REQUEST['id']))), true));
        $html2pdf->Output();
 
        ////////////////////////////////////////////////////////////////////////////////////
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StudentAttentance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StudentAttentance']))
			$model->attributes=$_GET['StudentAttentance'];

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
		$model=StudentAttentance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-attentance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionStudentattendancepdf()
	 {
		 $data=Students::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));
		 
		 
         

	 Yii::import('application.extensions.fpdf.*');
     require('fpdf.php');$pdf = new FPDF();
     $pdf->AddPage();
     $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(75,10,'Teacher Attendance Report',0,0,'C');
	 $pdf->Ln();
	 $pdf->Ln();
	 $pdf->SetFont('Arial','BU',10);
	 
	 $w= array(40,40,60);

	 $header = array('Name','Leaves','Remarks');
	 
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
	 $pdf->Cell($i,6,$data1->first_name,1,0,'L',$fill);
	 
	 $fullday=count(StudentAttentance::model()->findAllByAttributes(array('student_id'=>$data1->id)));
	 $total=$fullday;
	 
	 $pdf->Cell($i,6,$total,1,0,'C',$fill);
	 $pdf->Cell($i+20,6,'',1,0,'C',$fill);
	 
	 $pdf->Ln();
	 }
	 
     $pdf->Output();
	 Yii::app()->end();
	 }
	 
	 public function actionSendsms(){ // Function to send Attendance SMS to all students of a batch
	  
		$notification = NotificationSettings::model()->findByAttributes(array('id'=>4));
		$college=Configurations::model()->findByPk(1);
		if($notification->sms_enabled=='1' or $notification->msg_enabled=='1' or $notification->mail_enabled=='1'){ // Checking if SMS is enabled.
			 $students = Students::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['batch_id'])); // Selecting the students of the batch
			 $today = date("Y-m-d");
			 $sms_status = 0; // Setting a flag variable to check whether atleast one sms was sent.
			 $mail_status = 0;
			 $msg_status = 0;
			 
			 
			 if($students!=NULL){
				 foreach ($students as $student){
					$is_absent = StudentAttentance::model()->find("date=:x AND student_id=:y", array(':x'=>$today,':y'=>$student->id));
					$absent_no = count($is_absent);
					//var_dump($is_absent->attributes); exit;
					if(count($is_absent)!='0' and count($is_absent)!=NULL){ // Checking whether the student was absent
						$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
						
						if(count($guardian)!='0'){ // Check if guardian added
							$to = '';
							if($guardian->mobile_phone){ //Checking if phone number is provided
								$to = $guardian->mobile_phone;
							}
							$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
							if($settings!=NULL)
							{	
								$today=date($settings->displaydate,strtotime($today));				
							}
							if($to!='' and $notification->sms_enabled=='1' and $notification->parent_1=='1') // If absent and phone number is provided, send SMS								
							{
								$from = $college->config_value;
								$template=SystemTemplates::model()->findByPk(5);
								$message = $template->template;
								$message = str_replace("<Child’s First Name>",$student->first_name,$message);
								$message=str_replace("<Date>",$today,$message);	
								$message = str_replace("<Reason>",$is_absent->reason,$message);
								
								SmsSettings::model()->sendSms($to,$from,$message);
								$sms_status = 1; // Set flag variable to 1 if atleast one sms was sent.
								
							} // End check phone number
						//mail
							if($notification->mail_enabled == '1' and $notification->parent_1=='1')
							{   
								$template=EmailTemplates::model()->findByPk(15);
								$subject = $template->subject;
								$message = $template->template;								
								$subject=str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);								
								$message=str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
								$message = str_replace("{{STUDENT NAME}}",ucfirst($student->first_name).' '.ucfirst($student->last_name),$message);
								$message = str_replace("{{REASON}}",$is_absent->reason,$message);
								$message=str_replace("{{DATE}}",$today,$message);																												
								$to=$guardian->email;//mail ids of parents														
								UserModule::sendMail($to,$subject,$message);//to send mail  whn the admin mark as absent
								$mail_status = 1;
							}
							
						//Message
							if($notification->msg_enabled=='1' and $notification->parent_1=='1') // Send Message
							{								
								$to_parent = $guardian->uid;							
								$subject = 'Student Attendance';
								$message = 'Your child '.ucfirst($student->first_name).' '.ucfirst($student->last_name).' was absent on '.$today.' due to '.$is_absent->reason;
														
								NotificationSettings::model()->sendMessage($to_parent,$subject,$message);	
								$msg_status = 1;													
							}
							 Yii::app()->user->setFlash('notification','Notification send Successfully!');		
							
						} // End check if guardian added
					} // End check whether the student was absent
					
				 } // End for each student
				 
				
				 if($sms_status==0 or $msg_status==0 or $mail_status==0){ // This flag variable will be one if atleast one sms was sent.
					 Yii::app()->user->setFlash('notification','No absentees today!');
				 } 
				
			 } // End check whether students are present in the batch.
			 else{
				 Yii::app()->user->setFlash('notification','No students!');
			 }
		 } // End check if SMS is enabled
		 if(isset($_REQUEST['flag']) and ($_REQUEST['flag']==1)){
			 $this->redirect(array('/courses/studentAttentance','id'=>$_REQUEST['batch_id']));
		 }
		 else{
			 $this->redirect(array('index','id'=>$_REQUEST['batch_id']));
		 }
		
	 } // End send SMS function
	
}
