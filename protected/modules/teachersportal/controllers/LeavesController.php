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
		$model->viewed_by_user=1;
		
		$model->save();
		$this->render('view',array(
			'model'=>$model,
		));
	}
	public function actionCheck()
	{
		$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$flag = 0;
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
   		if($settings!=NULL)
    	{
		   $date=$settings->dateformat;		   
	 	}
   		 else
		{
			$date = 'dd-mm-yy';					 		
		}
		$taken=ApplyLeaves::model()->findAllByAttributes(array('employee_id'=>Yii::app()->user->id,'employee_leave_types_id'=>$_POST['ApplyLeaves']['employee_leave_types_id'],'approved'=>1));
	//Getting dates b/w start & end date	
		$date_between = array();
		$begin = new DateTime($_POST['ApplyLeaves']['start_date']);
		$end = new DateTime($_POST['ApplyLeaves']['end_date']);		
		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		foreach($daterange as $date){
			$date_between[] = $date->format("Y-m-d");
		}
		if(!in_array($_POST['ApplyLeaves']['end_date'],$date_between))
		{
			$date_between[] = date('Y-m-d',strtotime($_POST['ApplyLeaves']['end_date']));
		}
								
	
		$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$_POST['ApplyLeaves']['employee_leave_types_id']));
		foreach($taken as $taken1)
		{
			$days=$days+$taken1->no_days;
		}
		$time=strtotime($_POST['ApplyLeaves']['end_date']) - strtotime($_POST['ApplyLeaves']['start_date']);
		
		$days_no=$time/86400;
		
		if($_POST['ApplyLeaves']['is_half_day']==1){
			if($days_no < 0){
				//$days_no = 0;
				echo $days_no;exit;
			}
		}else{ 
		
			if($days_no == 0){
				$days_no = 1;
			}elseif($days_no < 0){				
				$days_no = 0;
				echo '-1';exit;
			}
		}
		
		
		//check Start Date is larger than Current Date
		$date_diff = strtotime($_POST['ApplyLeaves']['start_date']) - strtotime(date('Y-m-d'));
		
		/*if($date_diff <= 0)
		{
			echo '-2';exit;
		}*/
	//Checking whether selected date contain a leave taken date
		for($i = 0; $i<count($date_between); $i++){
			$leavecheck_1 = EmployeeAttendances::model()->findByAttributes(array('employee_id'=>$employee->id,'attendance_date'=>$date_between[$i]));
			
			if($leavecheck_1){
				$flag = 1;				
			}
		}	
		if($flag == 1)
		{
			echo '-3';exit;
		}
		
	//Check whether leave already applied on the selected dates
		$criteria = new CDbCriteria;
		$criteria->condition = 'employee_id=:employee_id and approved<>:approved';
		$criteria->params = array(':employee_id'=>Yii::app()->user->id,':approved'=>1);		
		$applied_leave_details = ApplyLeaves::model()->findAll($criteria);
		
		$applied_leave_dates = array();
		foreach($applied_leave_details as $applied_leave_detail){
			$begin_date = new DateTime($applied_leave_detail->start_date);
			$end_date = new DateTime($applied_leave_detail->end_date);		
			$dateranges = new DatePeriod($begin_date, new DateInterval('P1D'), $end_date);
			foreach($dateranges as $date1){
				if(!in_array($date1->format("Y-m-d"),$applied_leave_dates)){
					$applied_leave_dates[] = $date1->format("Y-m-d");
				}
			}
			if(!in_array($applied_leave_detail->end_date,$applied_leave_dates)){
				$applied_leave_dates[] = $applied_leave_detail->end_date;
			}
		}
		$is_already_applied = 0;
		if($applied_leave_dates){
			for($j = 0; $j<count($date_between); $j++){
				if(in_array($date_between[$j],$applied_leave_dates)){
					echo -5;exit;
				}
			}
		}
			
		if($_POST['ApplyLeaves']['is_half_day']==1){
			
			$time=strtotime($_POST['ApplyLeaves']['end_date']) - strtotime($_POST['ApplyLeaves']['start_date']);
			$days_no=$time/86400;
			if($days_no > 0){
				echo '-7';exit;
			}
			
		}
		//Check holiday
		$holidays = Holidays::model()->findAll();
		$days_arr = array();
		foreach($holidays as $holiday)
		{
			$days_arr[] = date('Y-m-d',$holiday->start);
		}
		
		for($i = 0;$i<count($date_between);$i++)
		{
			if(in_array($date_between[$i],$days_arr))
			{
				echo -4;exit;
			}
		}			
		$available = $type->max_leave_count-($days+$days_no);				
		echo $available.',';		
	}
	
	public function actionCheckHalfDay(){
		
		$time=strtotime($_POST['ApplyLeaves']['end_date']) - strtotime($_POST['ApplyLeaves']['start_date']);
		$days_no=$time/86400;
		if($days_no > 0){
			echo '-1';exit;
		}
		else{
			echo '1';exit;
		}
		
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ApplyLeaves;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$criteria=new CDbCriteria;
		$criteria->condition='employee_id=:val1';
		$criteria->params=array(':val1'=>Yii::app()->user->id);
		$criteria->order='date DESC';
		
		$total = ApplyLeaves::model()->count($criteria);
		$pages = new CPagination($total);
        $pages->setPageSize(10);
        $pages->applyLimit($criteria);  // the trick is here!
		$posts = ApplyLeaves::model()->findAll($criteria);
		//$applied=ApplyLeaves::model()->findAll($criteria);
		
		
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   		if($settings!=NULL)
   		{
     	 $date=$settings->displaydate;
	   
   		}
  	 	else
	    {
			$date = 'd-m-Y';	 
		}
		
		$model=new ApplyLeaves;
		
		$criteria = new CDbCriteria();
		$criteria->compare('status',1,true);
		$criteria->order = 'name';
		$type=EmployeeLeaveTypes::model()->findAll($criteria);
		
		if(isset($_POST['ApplyLeaves']))
		{ 
			$model->attributes=$_POST['ApplyLeaves'];
			$model->reason = $_POST['ApplyLeaves']['reason'];
			$model->approved = 0;			

			if($model->start_date)
    			 $model->start_date=date('Y-m-d',strtotime($model->start_date));
			if($model->end_date)
    			 $model->end_date=date('Y-m-d',strtotime($model->end_date));
			
			if($_POST['ApplyLeaves']['is_half_day']==1){
				if($_POST['half_session']==1){
					$model->half = 1;
				}
				else if($_POST['half_session']==2){
					$model->half = 2;
				}
			}else{
				$model->half = 0;
			}
			
			$time=strtotime($model->end_date) - strtotime($model->start_date);
			$days_no=$time/86400;
			
			if($days_no == 0)//if startdate end endate are same its taken as 1 day
				$days_no = 1;
			else if($days_no > 0)
				$days_no += 1;
			else if($days_no < 0)
				$days_no = 0;
			
			
				
			$model->no_days=$days_no;
			
			
			if($model->save()){
				Yii::app()->user->setFlash('success', Yii::t('app', 'Leave Request Sent Successfully'));
				$users = AuthAssignment::model()->findAllByAttributes(array('itemname'=>'Admin'));
				$subject=Yii::t('app', 'Leave Request');
				$data=$_POST['ApplyLeaves']['reason'];
				$employee=Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
				$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$model->employee_leave_types_id));
				
				
				$data="
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td valign='top' width='75%'>
								<div style='padding-left:20px;'>
									<strong>".Yii::t('app', 'Leave Request')."</strong> : 
									<div>
										<div>
											<h1>".$employee->concatened."</h1>&nbsp;&nbsp;&nbsp;
											<h2><strong>".Yii::t('app', 'Type')."</strong> : ".$type->name."</h2>&nbsp&nbsp&nbsp<strong>".Yii::t('app', 'Start Date')."</strong> : ". date($date,strtotime($model->start_date))."&nbsp;&nbsp;&nbsp;<strong>".Yii::t('app', 'End Date')."</strong> : ". date($date,strtotime($model->end_date))."&nbsp;&nbsp;&nbsp;<strong>".Yii::t('app', 'Reason')."</strong> : ". $model->reason ."<br>
											
										<div class='lreq_bottom'  align='right'>"; 
											
											$data.= CHtml::link(Yii::t('app', 'View Leave Requests'), array('/employees/leaves'),array('class'=>'dash_link'))."
										
										<div class='clear'></div>
										</div>
									</div>
								</div>
							</td>
						</tr>
    </table>";
				
				if($users!=NULL)
				{
					foreach($users as $user)
					{
						$result[]=$this->send_mail($user->userid,$subject,$data);
					}
				}
				
				$this->redirect(array('create'));
			}
		}
		$model->half = 0;		
		$this->render('create',array('type'=>$type,'model'=>$model,'list'=>$posts,
		'pages' => $pages,
		'item_count'=>$total,
		'page_size'=>10,));
	}
//Cancel leave request
	public function actionCancel($id){
		$model = ApplyLeaves::model()->findByAttributes(array('id'=>$id));
		if($model->delete()){
			//In case of approved or rejected situation
			if($model->approved != 0){
				$substitute_details = TeacherSubstitution::model()->findAllByAttributes(array('leave_request_id'=>$id));
				if($substitute_details)
				{
					foreach($substitute_details as $substitute_detail)
					{
						$substitute_detail->delete();
					}
				}
				
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
			}
		}
		$this->redirect(array('/teachersportal/leaves/create'));	
			
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
			throw new CHttpException(400, Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ApplyLeaves');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
			throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
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
						$conv->addError('to', Yii::t('app', 'User not found?'));
				}
			}
			
			if($conv->interlocutor_id && $conv->initiator_id == $conv->interlocutor_id) {
				$conv->addError('to', Yii::t('app', "Can't send message to self!"));
			}
			
			if(!Yii::app()->getModule('mailbox')->isAdmin() && $conv->interlocutor_id == Yii::app()->getModule('mailbox')->newsUserId){
				$conv->addError('to', Yii::t('app', "User not found?"));
			}
			
			// check user-to-user perms
			if(!$conv->hasErrors() && !Yii::app()->getModule('mailbox')->userToUser && !Yii::app()->getModule('mailbox')->isAdmin())
			{
				if(!Yii::app()->getModule('mailbox')->isAdmin($conv->to))
					$conv->addError('to', Yii::t('app', "Invalid user!"));
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
