<?php
/**
 * Ajax Crud Administration
 * ExamController *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 * @license The MIT License
 */

class ExamController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

public function   init() {
             $this->registerAssets();
              parent::init();
 }

  private function registerAssets(){

            Yii::app()->clientScript->registerCoreScript('jquery');

         //IMPORTANT about Fancybox.You can use the newest 2.0 version or the old one
        //If you use the new one,as below,you can use it for free only for your personal non-commercial site.For more info see
		//If you decide to switch back to fancybox 1 you must do a search and replace in index view file for "beforeClose" and replace with 
		//"onClosed"
        // http://fancyapps.com/fancybox/#license
          // FancyBox2
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
         // FancyBox
         //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
         // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.css','screen');
        //JQueryUI (for delete confirmation  dialog)
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/js/jquery-ui-1.8.12.custom.min.js', CClientScript::POS_HEAD);
         Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/css/dark-hive/jquery-ui-1.8.12.custom.css','screen');
          ///JSON2JS
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');
       

           //jqueryform js
               Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/jquery.form.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/form_ajax_binding.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/client_val_form.css','screen');

 }


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
				'actions'=>array('returnView'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('ajax_create','ajax_update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','returnForm','ajax_delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ExamGroups::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='exam-groups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        //AJAX CRUD

         public function actionReturnView(){

               //don't reload these scripts or they will mess up the page
                //yiiactiveform.js still needs to be loaded that's why we don't use
                // Yii::app()->clientScript->scriptMap['*.js'] = false;
                $cs=Yii::app()->clientScript;
                $cs->scriptMap=array(
                                                 'jquery.min.js'=>false,
                                                 'jquery.js'=>false,
                                                 'jquery.fancybox-1.3.4.js'=>false,
                                                 'jquery.fancybox.js'=>false,
                                                 'jquery-ui-1.8.12.custom.min.js'=>false,
                                                 'json2.js'=>false,
                                                 'jquery.form.js'=>false,
                                                'form_ajax_binding.js'=>false
        );

        $model=$this->loadModel($_POST['id']);
        $this->renderPartial('view',array('model'=>$model),false, true);
      }

             public function actionReturnForm(){

              //Figure out if we are updating a Model or creating a new one.
             if(isset($_POST['update_id']))$model= $this->loadModel($_POST['update_id']);else $model=new ExamGroups;
            //  Comment out the following line if you want to perform ajax validation instead of client validation.
            //  You should also set  'enableAjaxValidation'=>true and
            //  comment  'enableClientValidation'=>true  in CActiveForm instantiation ( _ajax_form  file).


             //$this->performAjaxValidation($model);

               //don't reload these scripts or they will mess up the page
                //yiiactiveform.js still needs to be loaded that's why we don't use
                // Yii::app()->clientScript->scriptMap['*.js'] = false;
                $cs=Yii::app()->clientScript;
                $cs->scriptMap=array(
                                                 'jquery.min.js'=>false,
                                                 'jquery.js'=>false,
                                                 'jquery.fancybox-1.3.4.js'=>false,
                                                 'jquery.fancybox.js'=>false,
                                                 'jquery-ui-1.8.12.custom.min.js'=>false,
                                                 'json2.js'=>false,
                                                 'jquery.form.js'=>false,
                                                 'form_ajax_binding.js'=>false
        );


        $this->renderPartial('_ajax_form', array('model'=>$model), false, true);
      }

	public function actionIndex(){
		$model=new ExamGroups('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['id']))
			$model->batch_id=$_GET['id'];

		$this->render('index',array('model'=>$model));
		
	}
	
	/*publish a particular exam group date*/
	
	public function actionPublishDate()
	{
		
		if($_REQUEST['exam_group_id']!=NULL and $_REQUEST['id']!=NULL)
		{
			$exam_group = ExamGroups::model()->findByPk($_REQUEST['exam_group_id']);
			$exam_group->is_published = 1;
			if($exam_group->save())
			{
				if(!isset($_GET['ajax']))
				{
    				$this->redirect(Yii::app()->request->urlReferrer);
				}
				//$this->redirect(array('index'));
			}
		}
	}
	
	/*publish a particular exam group result*/
	
	public function actionPublishResult()
	{
		
		if($_REQUEST['exam_group_id']!=NULL and $_REQUEST['id']!=NULL)
		{
			$exam_group = ExamGroups::model()->findByPk($_REQUEST['exam_group_id']);
			$exam_group->result_published = 1;
			if($exam_group->save())
			{
				if(!isset($_GET['ajax']))
				{
    				$this->redirect(Yii::app()->request->urlReferrer);
				}
				//$this->redirect(array('index'));
			}
		}
	}



	public function actionAjax_Update()
	{
		if(isset($_POST['ExamGroups']))
		{
			$model=$this->loadModel($_POST['update_id']);
			
			// For SMS
			$prev_name = $model->name;
		   	$prev_is_published = $model->is_published; // Fetching previous is_published
			$prev_result_published = $model->result_published; // Fetching previous result_published
			$prev_exam_date = $model->exam_date; //Fetching previous exam date
			// End For SMS
			
			// For Activity Feed
			$old_model = $model->attributes; // For activity feed	
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
			if($settings!=NULL)
			{	
				$old_exam_date = date($settings->displaydate,strtotime($old_model['exam_date']));			
			}
			// End For Activity Feed
			
			
			$model->attributes=$_POST['ExamGroups'];
			$model->exam_date=date('Y-m-d',strtotime($model->exam_date));
			if($model->save(false))
			{
			
				// Saving to activity feed
				$results = array_diff_assoc($_POST['ExamGroups'],$old_model); // To get the fields that are modified.
				
				foreach($results as $key => $value)
				{
					if($key == 'name')
					{
						$value = ucfirst($value);
					}
					elseif($key == 'is_published')
					{
						if($value == 1)
						{
							$value = Yii::t('app','Published');
						}
						else
						{
							$value = Yii::t('app','Not Published');
						}
						
						if($old_model[$key] == 1)
						{
							$old_model[$key] = Yii::t('app','Published');
						}
						else
						{
							$old_model[$key] = Yii::t('app','Not Published');
						}
					}
					elseif($key == 'result_published')
					{
						if($value == 1)
						{
							$value = Yii::t('app','Result Published');
						}
						else
						{
							$value = Yii::t('app','Result Not Published');
						}
						
						if($old_model[$key] == 1)
						{
							$old_model[$key] = Yii::t('app','Result Published');
						}
						else
						{
							$old_model[$key] = Yii::t('app','Result Not Published');
						}
					}
					elseif($key == 'exam_date')
					{
						$old_model[$key] = $old_exam_date;
					}
					
					
					//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
					ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'12',$model->id,ucfirst($model->name),$model->getAttributeLabel($key),$old_model[$key],$value); 
				}	
				//END saving to activity feed	
				
				// Send SMS if saved
				$notification = NotificationSettings::model()->findByAttributes(array('id'=>6));
				$college=Configurations::model()->findByPk(1);
				$to = '';
				$message = '';
				if($settings!=NULL)
				{	
					$model->exam_date=date($settings->displaydate,strtotime($model->exam_date));				
				}
				// Send Schedule SMS only if, SMS is enabled and schedule is published
				if($notification->sms_enabled=='1' or $notification->mail_enabled == '1' or $notification->msg_enabled == '1'){ 
					$students=Students::model()->findAll("batch_id=:x", array(':x'=>$model->batch_id)); //Selecting students of the batch
					foreach ($students as $student){ 
						if($student->phone1){ // Checking if phone number is provided
							$to = $student->phone1;	
						}
						elseif($student->phone2){
							$to = $student->phone2;
						}
						if($to!=''){ // Sending SMS to each student
							$college=Configurations::model()->findByPk(1);
							$from = $college->config_value;
							if($prev_is_published=='0' and $model->is_published=='1' and $prev_result_published=='0' and $model->result_published=='0'){ 
								// If exam schedule made published and result is not published
								$template=SystemTemplates::model()->findByPk(8);
								$message = $template->template;
								$message = str_replace("<Exam Name>",$model->name,$message);
							//Mail	
								if($notification->mail_enabled == '1' and $notification->student == '1')
								{									
									$template=EmailTemplates::model()->findByPk(6);
									$mail_subject = $template->subject;
									$mail_message = $template->template;																	
									$mail_subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_subject);
									$mail_subject = str_replace("{{EXAM NAME}}",$model->name,$mail_subject);																		
									$mail_message = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_message);
									$mail_message = str_replace("{{EXAM NAME}}",$model->name,$mail_message);
									$mail_message = str_replace("{{EXAM DATE}}",$model->exam_date,$mail_message);
																	
									UserModule::sendMail($student->email,$mail_subject,$mail_message);
								}																		
							//Message
								if($notification->msg_enabled == '1' and $notification->student == '1')
								{
									$msg_subject = $model->name.Yii::t('app',' is scheduled');
									$msg_message = Yii::t('app','Hi, ').$model->name.Yii::t('app',' exam is scheduled on ').$model->exam_date;
									NotificationSettings::model()->sendMessage($student->uid,$msg_subject,$msg_message);
								}
							}
							elseif($prev_is_published=='1' and $model->is_published=='1' and $prev_result_published=='0' and $model->result_published=='0'){ 
								// If exam schedule already published and result is not published
								if (strcasecmp($prev_name, $model->name) == 0){ // Checking if exam name is changed and if not changed.
									if(strcasecmp($prev_exam_date, $model->exam_date) != 0){
										$template=SystemTemplates::model()->findByPk(9);
										$message = $template->template;
										$message = str_replace("<Exam Name>",$model->name,$message);
									   //Mail : published exam date is changed to another date
									   	 if($notification->mail_enabled == '1' and $notification->student == '1')
										 {
											$template=EmailTemplates::model()->findByPk(7);											
											$mail_subject = $template->subject;
											$mail_message = $template->template;
											$mail_subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_subject);
											$mail_subject = str_replace("{{EXAM NAME}}",$model->name,$mail_subject);																						
											$mail_message = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_message);
											$mail_message = str_replace("{{EXAM NAME}}",$model->name,$mail_message);
											$mail_message = str_replace("{{EXAM DATE}}",$model->exam_date,$mail_message);
																								
											UserModule::sendMail($student->email,$mail_subject,$mail_message);
										 }
										 										 
										//Message
										 if($notification->msg_enabled == '1' and $notification->student == '1')
										 {
											$msg_subject = $model->name.Yii::t('app',' is schedule is modified');
											$msg_message = 'Hi, '.$model->name.Yii::t('app',' exam is scheduled on ').$model->exam_date;
											NotificationSettings::model()->sendMessage($student->uid,$msg_subject,$msg_message);
										 }
									}
								}
								else{ // If exam name is changed.
									$template=SystemTemplates::model()->findByPk(10);
									$message = $template->template;
									$message = str_replace("<Old Exam Name>",$prev_name,$message);
									$message = str_replace("<New Exam Name>",$model->name,$message);
									//Mail
									 if($notification->mail_enabled == '1' and $notification->student == '1')
									 {
										$template=EmailTemplates::model()->findByPk(9);											
										$mail_subject = $template->subject;
										$mail_message = $template->template;
										$mail_subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_subject);
										$mail_subject = str_replace("{{EXAM NAME}}",$model->name,$mail_subject);																						
										$mail_message = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_message);
										$mail_message = str_replace("{{EXAM NAME}}",$model->name,$mail_message);
										$mail_message = str_replace("{{OLD EXAM NAME}}",$prev_name,$mail_message);
																							
										UserModule::sendMail($student->email,$mail_subject,$mail_message);
									 }									 
									//Message
									 if($notification->msg_enabled == '1' and $notification->student == '1')
									 {
										$msg_subject = $prev_name.Yii::t('app',' name is modified');
										$msg_message = Yii::t('app','Hi, ').$prev_name.Yii::t('app',' exam name is changed to ').$model->name.'.';
										NotificationSettings::model()->sendMessage($student->uid,$msg_subject,$msg_message);
									 }
									if(strcasecmp($prev_exam_date, $model->exam_date) != 0){ // if exam name is changed and date is also changed.
										$template=SystemTemplates::model()->findByPk(11);
										$message = $template->template;
										$message = str_replace("<Old Exam Name>",$prev_name,$message);
										$message = str_replace("<New Exam Name>",$model->name,$message);
									//Mail	
										if($notification->mail_enabled == '1' and $notification->student == '1')
										{
											$template=EmailTemplates::model()->findByPk(8);											
											$mail_subject = $template->subject;
											$mail_message = $template->template;
											$mail_subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_subject);
											$mail_subject = str_replace("{{EXAM NAME}}",$model->name,$mail_subject);																						
											$mail_message = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_message);
											$mail_message = str_replace("{{EXAM NAME}}",$model->name,$mail_message);
											$mail_message = str_replace("{{OLD EXAM NAME}}",$prev_name,$mail_message);
											$mail_message = str_replace("{{EXAM DATE}}",$model->exam_date,$mail_message);
																								
											UserModule::sendMail($student->email,$mail_subject,$mail_message);
										}										
									//Message
										if($notification->msg_enabled == '1' and $notification->student == '1')
									 	{
											$msg_subject = $prev_name.Yii::t('app',' details are modified');
											$msg_message = Yii::t('app','Hi, ').$prev_name.Yii::t('app',' exam name is changed to ').$model->name.Yii::t('app','. Also, the schedule is modified');
											NotificationSettings::model()->sendMessage($student->uid,$msg_subject,$msg_message);
										}
									}
								}
								
							}
							
							if($message!='' and $notification->sms_enabled == '1' and $notification->student == '1'){ // Send SMS if there is some message.
								SmsSettings::model()->sendSms($to,$from,$message);
							}
						} // End send SMS to each student
					
				// Send Result SMS only if, SMS is enabled and result is published
				if($notification->sms_enabled=='1' or $notification->mail_enabled == '1' or $notification->msg_enabled == '1'){ // Exam Result SMS
					if($model->is_published=='1' and $prev_result_published=='0' and $model->result_published=='1'){
						//If result is published
						//SMS	
						if($notification->sms_enabled and $notification->student == '1')
						{
							$from = $college->config_value;
							$template=SystemTemplates::model()->findByPk(12);
							$message = $template->template;
							$message = str_replace("<Exam Name>",$model->name,$message);
							
							SmsSettings::model()->sendSms($to,$from,$message);
						}
					//Mail
						if($notification->mail_enabled == '1' and $notification->student == '1')
						{							
							$template=EmailTemplates::model()->findByPk(11);
							$mail_subject = $template->subject;
							$mail_message = $template->template;
							$mail_subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_subject);
							$mail_subject = str_replace("{{EXAM NAME}}",$model->name,$mail_subject);														
							$mail_message = str_replace("{{SCHOOL NAME}}",$college->config_value,$mail_message);
							$mail_message = str_replace("{{EXAM NAME}}",$model->name,$mail_message);
													
							UserModule::sendMail($student->email,$mail_subject,$mail_message);
						}						
					//Message	
						if($notification->msg_enabled == '1' and $notification->student == '1')
						{
							$msg_subject = $model->name.Yii::t('app',' results published');
							$msg_message = Yii::t('app','Hi, ').$model->name.Yii::t('app',' exam result is published.');
							NotificationSettings::model()->sendMessage($student->uid,$msg_subject,$msg_message);
						}
					}
				}
			}
		}
				
				echo json_encode(array('success'=>true));
			}
			else
				echo json_encode(array('success'=>false));
		}
	}


	public function actionAjax_Create()
	{
		if(isset($_POST['ExamGroups']))
		{
			$model=new ExamGroups;
			//set the submitted values
			$model->attributes=$_POST['ExamGroups'];
			
			if($model->exam_date)
			$model->exam_date=date('Y-m-d',strtotime($model->exam_date));
			//return the JSON result to provide feedback.
			if($model->save(false))
			{
						
				//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
				ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'11',$model->id,ucfirst($model->name),NULL,NULL,NULL); 
			
				// Send SMS if saved
				$notification = NotificationSettings::model()->findByAttributes(array('id'=>6));
				$college=Configurations::model()->findByPk(1);
				$to = '';
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				if($settings!=NULL)
				{	
					$model->exam_date=date($settings->displaydate,strtotime($model->exam_date));				
				}
				// Send SMS only if, SMS is enabled and schedule is published
				if($model->is_published=='1'){ 
					$students=Students::model()->findAll("batch_id=:x and is_deleted=:y and is_active=:z", array(':x'=>$model->batch_id,':y'=>0,':z'=>1)); //Selecting students of the batch
					foreach ($students as $student){ 
						if($student->phone1){ // Checking if phone number is provided
							$to = $student->phone1;	
						}
						elseif($student->phone2){
							$to = $student->phone2;
						}
					//SMS	
						if($to!='' and $notification->sms_enabled=='1' and $notification->student == '1'){ // Sending SMS to each student							
							$from = $college->config_value;
							$template=SystemTemplates::model()->findByPk(8);
							$message = $template->template;
							$message = str_replace("<Exam Name>",$model->name,$message);
							
							SmsSettings::model()->sendSms($to,$from,$message);
						}
					//Mail
						if($notification->mail_enabled == '1' and $notification->student == '1')
						{
							$template=EmailTemplates::model()->findByPk(6);											
							$subject = $template->subject;
							$message = $template->template;
							$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);
							$subject = str_replace("{{EXAM NAME}}",$model->name,$subject);											
							$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
							$message = str_replace("{{EXAM NAME}}",$model->name,$message);
							$message = str_replace("{{EXAM DATE}}",$model->exam_date,$message);
							
							UserModule::sendMail($student->email,$subject,$message);								
						}	
						
					//message
						if($schedule_notification->msg_enabled == '1' and $schedule_notification->student == '1')
						{											
							$subject = $model->name.Yii::t('app',' is scheduled');
							$message = Yii::t('app','Hi, ').$model->name.Yii::t('app',' exam is scheduled on ').$model->exam_date;
							NotificationSettings::model()->sendMessage($student->uid,$subject,$message);
								
						}	
					}
				}
				
				
				echo json_encode(array('success'=>true,'id'=>$model->primaryKey) );
				exit;
			} 
			else
			{
				echo json_encode(array('success'=>false));
				exit;
			}
		}
	}

	public function actionAjax_delete()
	{
		$id = $_POST['id'];
		$model = $this->loadModel($id);
		$deleted_batch_id = $model->batch_id; // Saving the id of the batch that is going to be deleted.
		if ($model->delete())
		{
			//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
			ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'13',$model->id,ucfirst($model->name),NULL,NULL,NULL); 
			
			// For SMS,mail,message
			$notification = NotificationSettings::model()->findByAttributes(array('id'=>6));
			$college=Configurations::model()->findByPk(1);
			$to = '';
			if(($notification->sms_enabled=='1' or $notification->msg_enabled == '1' or $notification->mail_enabled == '1')  and $model->is_published == '1'){ // Checking if SMS is enabled.
				$students=Students::model()->findAll("batch_id=:x", array(':x'=>$deleted_batch_id)); //Selecting students of the batch
				foreach ($students as $student){ 
					if($student->phone1){ // Checking if phone number is provided
						$to = $student->phone1;	
					}
					elseif($student->phone2){
						$to = $student->phone2;
					}
				//SMS	
					if($to!='' and $notification->sms_enabled=='1' and $notification->student=='1'){ // Sending SMS to each student						
						$from = $college->config_value;
						$template=SystemTemplates::model()->findByPk(13);
						$message = $template->template;
						$message = str_replace("<Exam Name>",$model->name,$message);
						
						SmsSettings::model()->sendSms($to,$from,$message);						
					}
				//Mail	
					if($notification->mail_enabled=='1' and $notification->student=='1')
					{								
						$template=EmailTemplates::model()->findByPk(10);
						$subject = $template->subject;
						$message = $template->template;												
						$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);
						$subject = str_replace("{{EXAM NAME}}",$model->name,$subject);								
						$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
						$message = str_replace("{{EXAM NAME}}",$model->name,$message); 
														
						UserModule::sendMail($student->email,$subject,$message);
					}	
									
				//Message	
					if($notification->msg_enabled=='1' and $notification->student=='1')
					{
						$subject = $model->name.Yii::t('app',' is cancelled');
						$message = Yii::t('app','Hi, ').$model->name.Yii::t('app',' exam is cancelled.');
						NotificationSettings::model()->sendMessage($student->uid,$subject,$message);
					}	
				}
			}
			// End For SMS
					
					
			// Delete Exam and exam score					
			 $exam=Exams::model()->findAllByAttributes(array('exam_group_id'=>$id));
			   //print_r($exam);
			 foreach ($exam as $exam1)
			 {  
			   $examscore=ExamScores::model()->findAllByAttributes(array('exam_id'=>$exam1->id));
			  
				 foreach($examscore as $examscore1)
				 {
				 	$examscore1->delete();
				 }
				  $exam1->delete();
			   }
			// End Delete Exam and exam score
			
			
			
			echo json_encode (array('success'=>true));
			exit;
		}
		else
		{
			echo json_encode (array('success'=>false));
			exit;
		}
	}


}
