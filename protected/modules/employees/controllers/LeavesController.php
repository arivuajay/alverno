<?php

class LeavesController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{				
		$model=$this->loadModel($id);
		$model->viewed_by_manager=1;
		$model->save();
		
		$employee=Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
		$date_between = array();
		$begin = new DateTime($model->start_date);
		$end = new DateTime($model->end_date);
		
		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		
		foreach($daterange as $date){
			$date_between[] = $date->format("Y-m-d");
		}
		if(!in_array($model->end_date,$date_between))
		{
			$date_between[] = date('Y-m-d',strtotime($model->end_date));
		}
		
		$batch_array = ApplyLeaves::model()->getBatches($employee->id);
		
	//Check whether the employee is a substitute
		$date_arr = array();
		$date_employee_substitute = '';
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		for($i = 0; $i<count($date_between); $i++){
			$is_emp_substitute = TeacherSubstitution::model()->findByAttributes(array('substitute_emp_id'=>$employee->id,'date_leave'=>$date_between[$i]));
			if($is_emp_substitute){
				$date_arr[] = date($settings->displaydate,strtotime($is_emp_substitute->date_leave));	
			}			
		}
		if($date_arr){
			$date_employee_substitute = implode(', ',$date_arr);
		}
			
		$this->render('view',array(
			'model'=>$model,'days'=>$days,'batch_array'=>$batch_array,'date_between'=>$date_between,'date_employee_substitute'=>$date_employee_substitute
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model=new ApplyLeaves;
		$type=EmployeeLeaveTypes::model()->findAll();
		
		if(isset($_POST['ApplyLeaves']))
		{
			$model->attributes=$_POST['ApplyLeaves'];
			
			if($model->start_date)
    			 $model->start_date=date('Y-m-d',strtotime($model->start_date));
			if($model->end_date)
    			 $model->end_date=date('Y-m-d',strtotime($model->end_date));
			
			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','Leave Request Sent Successfully'));
				$users = AuthAssignment::model()->findAllByAttributes(array('itemname'=>'Admin'));
				$subject=Yii::t('app','Leave Request');
				$reason=$_POST['ApplyLeaves']['reason'];
				if($users!=NULL)
				{
					
					foreach($users as $user)
					{
						$result[]=$this->send_mail($user->userid,$subject,$reason);
					}
				}
				
				$this->redirect(array('create'));
			}
		}
		
		$this->render('create',array('type'=>$type,'model'=>$model));
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

		if(isset($_POST['ApplyLeaves']))
		{
			$model->attributes=$_POST['ApplyLeaves'];
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
		//$dataProvider=new CActiveDataProvider('ApplyLeaves');
		$criteria=new CDbCriteria;
		$criteria->order='date DESC';
		
		//$model=ApplyLeaves::model()->findAll($criteria);
		$total = ApplyLeaves::model()->count($criteria);
		$pages = new CPagination($total);
        $pages->setPageSize(10);
        $pages->applyLimit($criteria);  // the trick is here!
		$posts = ApplyLeaves::model()->findAll($criteria);
		
		
		
		$this->render('index',array(
		'list'=>$posts,
		'pages' => $pages,
		'item_count'=>$total,
		'page_size'=>10,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ApplyLeaves('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ApplyLeaves']))
			$model->attributes=$_GET['ApplyLeaves'];

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
		$model=ApplyLeaves::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='apply-leaves-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionApprove($id)
	{			
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   		if($settings!=NULL)
   		{
     	 $date=$settings->displaydate;
	   
   		}
  	 	else
	    {
			$date = 'd-m-Y';	 
		}
		$model=$this->loadModel($id);
		$model->approved=1;
		if($model->save()){
			if($model->is_half_day){
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				$model_1							=	new EmployeeAttendances;
				$model_1->attendance_date			=	$model->start_date;
				$model_1->employee_id				=	$employee->id;
				$model_1->employee_leave_type_id 	= 	$model->employee_leave_types_id;
				$model_1->reason					=	$model->reason;
				$model_1->is_half_day				=	$model->is_half_day;
				$model_1->half						=	$model->half;				
				$model_1->save();
				
			}else{
				$date_arr = Configurations::daterange($model->start_date,$model->end_date);
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				foreach($date_arr as $val){
					$model_1							=	new EmployeeAttendances;
					$model_1->attendance_date			=	$val;
					$model_1->employee_id				=	$employee->id;
					$model_1->employee_leave_type_id 	= 	$model->employee_leave_types_id;
					$model_1->reason					=	$model->reason;
					$model_1->is_half_day				=	$model->is_half_day;
					$model_1->half						=	$model->half;					
					$model_1->save();
				}
			}
		}
		
		$subject=Yii::t('app','Leave Request Accepted');
		$data="<strong>".Yii::t('app','Start Date')."</strong> : ". date($date,strtotime($model->start_date))."&nbsp;&nbsp;&nbsp;&nbsp;<strong>".Yii::t('app','End Date')."</strong> : ". date($date,strtotime($model->end_date))."<br> ".Yii::t('app','Leave Request Accepted');
		$this->send_mail($model->employee_id,$subject,$data);
		if(isset($_REQUEST['flag']) && $_REQUEST['flag']==1)
		{
			$this->redirect(array('/mailbox'));
		}
		else
			$this->redirect(array('view','id'=>$model->id));
		
	}
	
	public function actionAddSubstitute()
	{					
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   		if($settings!=NULL){
     	 $date=$settings->displaydate;	   
   		}else{
			$date = 'd-m-Y';	 
		}	
		
		if(!empty($_POST['time_table_entry_id']))
		{
			for($i = 0; $i < count($_POST['time_table_entry_id']); $i++)
			{
				$timetable_entry = TimetableEntries::model()->findByAttributes(array('id'=>$_POST['time_table_entry_id'][$i]));
				if(isset($_POST['substitute_employee_id'][$i]) and $_POST['substitute_employee_id'][$i]!=NULL)
				{
					$teacherSubstitute = new TeacherSubstitution;
					$teacherSubstitute->date = $timetable_entry->weekday_id;
					$teacherSubstitute->batch = $timetable_entry->batch_id	;
					$teacherSubstitute->time_table_entry_id = $timetable_entry->id;
					$teacherSubstitute->substitute_emp_id = $_POST['substitute_employee_id'][$i];
					$teacherSubstitute->leave_request_id = $_POST['leave_request_id'];
					$teacherSubstitute->date_leave = date('Y-m-d',strtotime($_POST['leave_date'][$i]));	
					$teacherSubstitute->leave_requested_emp_id = $_POST['leave_requested_emp_id'];				
					$teacherSubstitute->save();		
				}				
			}
		}		
		$model=$this->loadModel($_POST['leave_request_id']);
		$model->approved=1;
		
		//mark absent in attendance...............
		if($model->save()){
			if($model->is_half_day){
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				$model_1							=	new EmployeeAttendances;
				$model_1->attendance_date			=	$model->start_date;
				$model_1->employee_id				=	$employee->id;
				$model_1->employee_leave_type_id 	= 	$model->employee_leave_types_id;
				$model_1->reason					=	$model->reason;
				$model_1->is_half_day				=	$model->is_half_day;
				$model_1->half						=	$model->half;				
				$model_1->save();
				
			}else{
				$date_arr = Configurations::daterange($model->start_date,$model->end_date);
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				foreach($date_arr as $val){
					$model_1							=	new EmployeeAttendances;
					$model_1->attendance_date			=	$val;
					$model_1->employee_id				=	$employee->id;
					$model_1->employee_leave_type_id 	= 	$model->employee_leave_types_id;
					$model_1->reason					=	$model->reason;
					$model_1->is_half_day				=	$model->is_half_day;
					$model_1->half						=	$model->half;					
					$model_1->save();
				}
			}
		}
		//mark absent in attendance...............
		$subject=Yii::t('app','Leave Request Accepted');
		$data="<strong>".Yii::t('app','Start Date')."</strong> : ". date($date,strtotime($model->start_date))."&nbsp;&nbsp;&nbsp;&nbsp;<strong>".Yii::t('app','End Date')."</strong> : ". date($date,strtotime($model->end_date))."<br>".Yii::t('app','Leave Request Accepted');
		$this->send_mail($model->employee_id,$subject,$data);
		if(isset($_REQUEST['flag']) && $_REQUEST['flag']==1)
		{
			$this->redirect(array('/mailbox'));
		}
		else
		$this->redirect(array('view','id'=>$model->id));
		
	}
	public function actionReject($id)
	{
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   		if($settings!=NULL){
     	 $date=$settings->displaydate;	   
   		}else{
			$date = 'd-m-Y';	 
		}
		$model=$this->loadModel($id);
		$old_status = $model->approved;
		$model->approved = 2;
		if($model->save())
		{
			$substitute_details = TeacherSubstitution::model()->findAllByAttributes(array('leave_request_id'=>$id));
			if($substitute_details)
			{
				foreach($substitute_details as $substitute_detail)
				{
					$substitute_detail->delete();
				}
			}
			
			//remove absent in attendance...............
			if($model->is_half_day){
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				$attendance = EmployeeAttendances::model()->findByAttributes(array('employee_id'=>$employee->id,'attendance_date'=>$model->start_date));
				if($attendance){
					$attendance->delete();
				}
				
			}else{
				$date_arr = Configurations::daterange($model->start_date,$model->end_date);
				$employee = Employees::model()->findByAttributes(array('uid'=>$model->employee_id));				
				foreach($date_arr as $val){
					$attendance = EmployeeAttendances::model()->findByAttributes(array('employee_id'=>$employee->id,'attendance_date'=>$val));
					if($attendance){
						$attendance->delete();
					}
				}
			}
			//remove absent in attendance...............
			
		}
		$subject=Yii::t('app','Leave Request Rejected');
		$data="<strong>".Yii::t('app','Start Date')."</strong> : ". date($date,strtotime($model->start_date))."&nbsp;&nbsp;&nbsp;&nbsp;<strong>".Yii::t('app','End Date')."</strong> : ". date($date,strtotime($model->end_date))."<br>".Yii::t('app','Leave Request Rejected');
		$this->send_mail($model->employee_id,$subject,$data);
		if(isset($_REQUEST['flag']) && $_REQUEST['flag']==1)
		{
			$this->redirect(array('/mailbox'));
		}
		else
		$this->redirect(array('view','id'=>$model->id));
		
	}
	public function send_mail($to,$subject,$message)
	{
				
		if(isset($to))
		{
			$t = time();
			$conv = new Mailbox();
			$conv->subject = ($subject)? $subject : Yii::app()->getModule('mailbox')->defaultSubject;
			$conv->to = $to;
			$conv->initiator_id = Yii::app()->getModule('mailbox')->getUserIdMail();

			// Check if username exist
			if(strlen($to)>1)
				$conv->interlocutor_id = Yii::app()->getModule('mailbox')->getUserIdMail($to);
			else
				$conv->interlocutor_id = 0;
			// ...if not check if To field is user id
			if(!$conv->interlocutor_id)
			{
				if($to && (Yii::app()->getModule('mailbox')->allowLookupById || Yii::app()->getModule('mailbox')->isAdmin()))
					$username = Yii::app()->getModule('mailbox')->getUserName($to);
				if(@$username) {
					$conv->interlocutor_id = $to;
					$conv->to = $username;
				}
				else {
					// possible that javscript was off and user selected from the userSupportList drop down.
					if( $this->module->getUserIdMail($to)) {
						$conv->to = $to;
						$conv->initiator_id = Yii::app()->getModule('mailbox')->getUserIdMail($to);
					}
					else
						$conv->addError('to',Yii::t('app','User not found?'));
				}
			}
			
			if($conv->interlocutor_id && $conv->initiator_id == $conv->interlocutor_id) {
				$conv->addError('to', Yii::t('app',"Can't send message to self!"));
			}
			
			if(!Yii::app()->getModule('mailbox')->isAdmin() && $conv->interlocutor_id == Yii::app()->getModule('mailbox')->newsUserId){
				$conv->addError('to', Yii::t('app',"User not found?"));
			}
			
			// check user-to-user perms
			if(!$conv->hasErrors() && !Yii::app()->getModule('mailbox')->userToUser && !Yii::app()->getModule('mailbox')->isAdmin())
			{
				if(!Yii::app()->getModule('mailbox')->isAdmin($conv->to))
					$conv->addError('to', Yii::t('app',"Invalid user!"));
			}
			
			$conv->modified = $t;
			$conv->bm_read = Mailbox::INITIATOR_FLAG;
			if(Yii::app()->getModule('mailbox')->isAdmin())
				$msg = new Message('admin');
			else
				$msg = new Message('user');
			$msg->text = $message;
			$validate = $conv->validate(array('text'),false); // html purify
			$msg->created = $t;
			$msg->sender_id = $conv->initiator_id;
			$msg->recipient_id = $conv->interlocutor_id;
			if(Yii::app()->getModule('mailbox')->checksums) {
				$msg->crc64 = Message::crc64($msg->text); // 64bit INT
			}
			else
				$msg->crc64 = 0;
			// Validate
			$validate = $conv->validate(null,false); // don't clear errors
			$validate = $msg->validate() && $validate;
			
			if($validate)
			{
				$conv->save();
				$msg->conversation_id = $conv->conversation_id;
				$msg->save();
				//Yii::app()->user->setFlash('success', "Message has been sent!");
				//$this->redirect(array('message/inbox'));
				return 'success';
			}
			else
			{
				//Yii::app()->user->setFlash('error', "Error sending message!");
				return 'error';
			}
		}
	}
	
	
	
}
