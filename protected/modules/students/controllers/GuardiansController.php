<?php

class GuardiansController extends RController
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
				'actions'=>array('index','view','Addguardian'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','guardiandelete','search'),
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
		$model=new Guardians;
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                $check_flag = 0;
		$render_flag = 0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if($_POST['student_id'])
		{
			$guardian = Students::model()->findByAttributes(array('id'=>$_POST['student_id']));
			$gid = $guardian->parent_id;			
		}
		elseif($_POST['guardian_id'])
		{
			$gid = $_POST['guardian_id'];
		}
		elseif($_POST['guardian_mail'])
		{
			$gid = $_POST['guardian_mail'];
			
		}
		
		if($gid!=NULL and $gid!=0)
		{
			//$render_flag = 1;
			$model = Guardians::model()->findByAttributes(array('id'=>$gid));
                        if($model->dob=="0000-00-00")
                        {
                            $model->dob="";
                        }
			$this->render('create',array(
			'model'=>$model,'radio_flag'=>1,'guardian_id'=>$gid
			));	
			exit;
		}
		elseif((isset($_POST['student_id']) or isset($_POST['guardian_id']) or isset($_POST['guardian_mail'])) and ($gid==NULL or $gid==0))
		{
			Yii::app()->user->setFlash('errorMessage',Yii::t('app',"Guardian not found..!"));
		}
		
		if(isset($_POST['Guardians']))
		{                                              
			$model->attributes 	= $_POST['Guardians'];
			$model->ward_id		= $_POST['Guardians']['ward_id'];
			if($_POST['Guardians']['relation']== 'Others')
			{
				$model->relation= $_POST['Guardians']['relation_other'];
				$model->relation_other= $model->relation;
			}
			if(isset($_POST['Guardians']['dob']) and $_POST['Guardians']['dob']!=NULL){
				$model->dob = date('Y-m-d',strtotime($_POST['Guardians']['dob']));
			}
			
			//dynamic fields
			$fields   = FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
			foreach ($fields as $key => $field) {			
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}
			
			$fields   = FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
			foreach ($fields as $key => $field) {			
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}
			
			$student_data = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(isset($_POST['Guardians']['same_address']) and $_POST['Guardians']['same_address']==1){
				$model->same_address			= $_POST['Guardians']['same_address'];
				$model->office_phone1			= $student_data->phone1;
				$model->office_phone2			= $student_data->phone2;
				$model->office_address_line1 	= $student_data->address_line1;
				$model->office_address_line2 	= $student_data->address_line2;
				$model->city 					= $student_data->city;
				$model->state					= $student_data->state;
				$model->country_id				= $student_data->country_id;
			}
                        
                       
			$model->validate();
			if($_POST['Guardians']['user_create']==1)
			{
				$check_flag = 1;
			}
			//print_r($_POST['Guardians']); exit;
			if($model->save())
			{
                            //exit();
                            //save data to guardian list table - for multiple guardian referance
                            $guardian_list= new GuardianList;
                            $guardian_list->student_id= $model->ward_id;
                            $guardian_list->guardian_id= $model->id;
                            $guardian_list->relation= $model->relation;
                            $guardian_list->save();
                            
				//echo $model->ward_id; exit;
				$student = Students::model()->findByAttributes(array('id'=>$model->ward_id));
                                if($student->parent_id==0)
                                {
                                	$student->parent_id	= $model->id;
                                	$student->save();
                                    //$student->saveAttributes(array('parent_id'=>$model->id));
                                }
				
				if($_POST['Guardians']['user_create']==0)
				{
                                    
					//adding user for current guardian
					$user=new User;
					$profile=new Profile;
					$user->username = substr(md5(uniqid(mt_rand(), true)), 0, 10);
					$user->email = $model->email;
					$user->activkey=UserModule::encrypting(microtime().$model->first_name);
					$password = substr(md5(uniqid(mt_rand(), true)), 0, 10);
					$user->password=UserModule::encrypting($password);
					$user->superuser=0;
					$user->status=1;
					
					if($user->save())
					{
						
					//assign role
					$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
					$authorizer->authManager->assign('parent', $user->id);
					
					//profile
					$profile->firstname = $model->first_name;
					$profile->lastname = $model->last_name;
					$profile->user_id=$user->id;
					$profile->save();
					
					//saving user id to guardian table.
					$model->saveAttributes(array('uid'=>$user->id));
					//$model->uid = $user->id;
					//$model->save();
					
					// for sending sms
					$notification = NotificationSettings::model()->findByAttributes(array('id'=>3));
					$college=Configurations::model()->findByPk(1);
					$to = '';
					if($notification->sms_enabled=='1' and $notification->parent_1 == '1') // Checking if SMS is enabled.
					{
						if($model->mobile_phone){
							$to = $model->mobile_phone;	
						}
						
							if($to!=''){ // Send SMS if phone number is provided								
								$from = $college->config_value;
								$template=SystemTemplates::model()->findByPk(1);
								$message = $template->template;
								$message = str_replace("<School Name>",$college->config_value,$message);
								
								$template=SystemTemplates::model()->findByPk(2);
								$login_message = $template->template;
								$login_message = str_replace("<School Name>",$college->config_value,$login_message);
								$login_message = str_replace("<Password>",$password,$login_message);
								SmsSettings::model()->sendSms($to,$from,$message);
								SmsSettings::model()->sendSms($to,$from,$login_message);
							} // End send SMS
					} // End check if SMS is enabled
				//Mail	
					if($notification->mail_enabled == '1' and $notification->parent_1 == '1')
					{						
						$template=EmailTemplates::model()->findByPk(2);
						$subject = $template->subject;
						$message = $template->template;				
						$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);																	
						$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
						$message = str_replace("{{EMAIL}}",$model->email,$message);
						$message = str_replace("{{PASSWORD}}",$password,$message);
						
						UserModule::sendMail($model->email,$subject,$message);						
					}
				//Message	
					if($notification->msg_enabled == '1' and $notification->parent_1 == '1')
					{						
						$to = $model->uid;
						$subject = Yii::t('app','Welcome to').' '.$college->config_value;
						$message = Yii::t('app','Hi, Welcome to').' '.$college->config_value.'.'.Yii::t('app','We are looking forward to your esteemed presence and cooperation with our organization.');
						NotificationSettings::model()->sendMessage($to,$subject,$message);
					}
					
				}
						
			}
            if(isset($_POST['which_btn']) and $_POST['which_btn']==1){ //In case of Save & Continue Button click
				$this->redirect(array('addguardian','id'=>$_REQUEST['id']));
			}else{
            	$this->redirect(array('create','id'=>$model->ward_id));//In case of Save Button click
			}
       }
	}

	$fields   = FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
	foreach ($fields as $key => $field) {			
		if($field->form_field_type==6){  // date value
			$field_name = $field->varname;
			if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
				$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
			}
			else{
				$model->$field_name=NULL;
			}
		}
	}
	
	$fields   = FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
	foreach ($fields as $key => $field) {			
		if($field->form_field_type==6){  // date value
			$field_name = $field->varname;
			if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
				$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
			}
			else{
				$model->$field_name=NULL;
			}
		}
	}
		/*if($render_flag == 0)
		{*/
			$this->render('create',array(
				'model'=>$model,'check_flag'=>$check_flag
			));
		//}
	}
        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Guardians']))
		{
                    
                    $student_id= $_POST['Guardians']['ward_id'];
			$old_model = $model->attributes;
			$model->attributes=$_POST['Guardians'];
			 if($_POST['Guardians']['relation']== 'Others')
			{
				$model->relation= ucfirst($_POST['Guardians']['relation_other']);
				$model->relation_other= $model->relation;
			}
			if(isset($_POST['Guardians']['dob']) and $_POST['Guardians']['dob']!=NULL){
				$model->dob = date('Y-m-d',strtotime($_POST['Guardians']['dob']));
			}
			
			//dynamic fields
			$fields   = FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
			foreach ($fields as $key => $field) {			
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}
			
			$fields   = FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
			foreach ($fields as $key => $field) {			
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}
			if($model->validate())
                        {
			if($model->save())
			{
                            //save new email id to user table
                            $user_id= $model->uid;
                            $usr_model= User::model()->findByPk($user_id);
                            if($usr_model)
                            {
                                $usr_model->email= $model->email;
                                $usr_model->save();
                            }
                           // echo $student_id; exit;
				$guard_list= GuardianList::model()->findByAttributes(array('student_id'=>$student_id,'guardian_id'=>$model->id));
				if($guard_list)
				{
					$guard_list->saveAttributes(array('relation'=>$model->relation));
				}
				else
				{
					$guardian_list= new GuardianList;
					$guardian_list->student_id= $student_id;
					$guardian_list->guardian_id= $model->id;
					$guardian_list->relation= $model->relation;
					$guardian_list->save();
				}
				
				if($_REQUEST['std']==NULL)
				{
                                    
					if($_REQUEST['sid'])
					{
                                            
                                            $student = Students::model()->findByAttributes(array('id'=>$_REQUEST['sid']));
                                            if($student->parent_id==0)
                                            {
                                                $student->saveAttributes(array('parent_id'=>$_REQUEST['id']));
                                            }
                                            //echo $_REQUEST['id'].'/'.$student->first_name; exit;
                                            $this->redirect(array('create','id'=>$_REQUEST['sid'],'gid'=>$_REQUEST['id']));
					}else
					{
                                            if(isset($_REQUEST['status']) && $_REQUEST['status']==1)
                                            {
                                                $this->redirect(array('/students/guardians/create','id'=>$_REQUEST['s_id']));
                                            }
                                            else
                                                
						$this->redirect(array('/students/guardians/admin'));
					}
				}
				else
				{
					
					
					// Saving to activity feed
					$results = array_diff_assoc($_POST['Guardians'],$old_model); // To get the fields that are modified.
					//print_r($old_model);echo '<br/><br/>';print_r($_POST['Students']);echo '<br/><br/>';print_r($results);echo '<br/><br/>'.count($results);echo '<br/><br/>';
					foreach($results as $key => $value)
					{
						if($key != 'updated_at')
						{
							
							if($key == 'country_id')
							{
								$value = Countries::model()->findByAttributes(array('id'=>$value));
								$value = $value->name;
								
								$old_model_value = Countries::model()->findByAttributes(array('id'=>$old_model[$key]));
								$old_model[$key] = $old_model_value->name;
							}
							//echo $key.'-'.$model->getAttributeLabel($key).'-'.$value.'-'.$old_model[$key].'<br/>';
							//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
							ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'15',$model->id,ucfirst($model->first_name).' '.ucfirst($model->last_name),$model->getAttributeLabel($key),$old_model[$key],$value); 
						}
					}
					
					//END saving to activity feed
					
					$this->redirect(array('students/view','id'=>$_REQUEST['std']));
				}
			}
                        }
                        else
                        {
                            
                                $gid= $_REQUEST['id'];
                            
                            
                            $this->render('create',array(
                                'model'=>$model,'radio_flag'=>1,'guardian_id'=>$gid
                                ));	
                                exit;
                        }
		}
		
		if($model->dob!=NULL and $model->dob == '0000-00-00'){
			$model->dob = '';
		}
		if($settings!=NULL and $model->dob!=NULL and $model->dob != '0000-00-00'){				
			$date1=date($settings->displaydate,strtotime($model->dob));
			$model->dob=$date1;
		}
		
		$fields   = FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
        foreach ($fields as $key => $field) {			
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
        }
		
		$fields   = FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
        foreach ($fields as $key => $field) {			
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
        }
		
		$this->render('update',array(
			'model'=>$model,
		));
	}
        
	/*public function actionAddguardian()
	{
		$model=new Guardians;
		  if(isset($_POST['Guardians']))
		   {
			  $list = $_POST['Guardians'];
              if(isset($_POST['Guardians']['radio']) and $_POST['Guardians']['radio']!=NULL)
              {
                $student = Students::model()->findByAttributes(array("id"=>$list['ward_id']));
                $student->immediate_contact_id = $list['radio'];
                $student->save();
              }
			   $this->redirect(array('studentPreviousDatas/create','id'=>$list['ward_id']));
				//$this->redirect(array('students/view','id'=>$list['ward_id']));
			   
		   }
		$this->render('addguardian',array('model'=>$model));
	}*/

	public function actionAddguardian($id)
	{
		$model = Students::model()->findByPk($id);
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if($model!=NULL){
			if(isset($_POST['Students']))
			{
				$model->attributes 				= $_POST['Students'];
				$model->immediate_contact_id 	= $_POST['Students']['immediate_contact_id'];
				
				$fields   = FormFields::model()->getDynamicFields(3, 1, "forAdminRegistration");				
				foreach ($fields as $key => $field) {			
					if($field->form_field_type==6){  // date value
						$field_name = $field->varname;
						if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
							$model->$field_name = date('Y-m-d',strtotime($model->$field_name));												
						}
					}
				}
				
				if($model->save()){
					$this->redirect(array('studentPreviousDatas/create','id'=>$id));
				}
			}

			$fields   = FormFields::model()->getDynamicFields(3, 1, "forAdminRegistration");
			foreach ($fields as $key => $field) {			
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
					}
					else{
						$model->$field_name=NULL;
					}
				}
			}
			
			$this->render('addguardian',array('model'=>$model));
		}
		else{
			throw new CHttpException(400, Yii::t('app','Invalid request. Please do not repeat this request again.'));
		}
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
			
			$model = Guardians::model()->findByAttributes(array('id'=>$id));
			// we only allow deletion via POST request
			//$this->loadModel($id)->delete();
			if($this->loadModel($id)->delete())
			{
				if($user=User::model()->findByAttributes(array('id'=>$model->uid)))
				$user->saveAttributes(array('status'=>'0'));
			}
			
			//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
			ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'16',$model->id,ucfirst($model->first_name).' '.ucfirst($model->last_name),$model->getAttributeLabel($key),$old_model[$key],$value); 
			
			
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,Yii::t('app','Invalid request. Please do not repeat this request again.'));
	}
        
        //delete guardians data from guardianlist, guardians, profile, and users
        public function actionGuardiandelete($id) 
        {
			
                $returnArray = array();
                $list_model = GuardianList::model()->findByAttributes(array('id'=>$id));
                Yii::app()->user->setState('guardian_id',$list_model->guardian_id);                
                $list_model->delete();
                $gid= Yii::app()->user->getState('guardian_id');
                $listmdl= GuardianList::model()->findAllByAttributes(array('guardian_id'=>$gid));               
                if(!$listmdl)
                {
                        $model = Guardians::model()->findByAttributes(array('id'=>$gid));
                        
                        $userlist= User::model()->findByAttributes(array('id'=>$model->uid));
                        if($userlist)
                        {
                            $userlist->delete();                            
                        }
                        
                        $profilelist= Profile::model()->findByAttributes(array('user_id'=>$model->uid));
                        if($profilelist)
                        {
                            $profilelist->delete();                            
                        }
                                                                        
			// we only allow deletion via POST request
			$this->loadModel($gid)->delete();
                                                
                }
                              
            }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Guardians');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Guardians('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Guardians']))
			$model->attributes=$_GET['Guardians'];

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
		$model=Guardians::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='guardians-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionSearch()
        {
            if(isset($_GET['name']) and $_GET['name']!=NULL)
		{
			$name_lists = array();
			$criteria = new CDbCriteria;
			if((substr_count( $_GET['name'],' '))==0)
			{ 	
				$criteria->condition='first_name LIKE :name or middle_name LIKE :name or last_name LIKE :name';
				$criteria->params[':name'] = $_GET['name'].'%';
			}
			else if((substr_count( $_GET['name'],' '))>=1)
			{
				$name=explode(" ",$_GET['name']);
				$criteria->condition='first_name LIKE :name or middle_name LIKE :name or last_name LIKE :name';
				$criteria->params[':name'] = $name[0].'%';
				$criteria->condition=$criteria->condition.' and '.'(first_name LIKE :name1 or middle_name LIKE :name1 or last_name LIKE :name1)';
				$criteria->params[':name1'] = $name[1].'%';			
			}
			$names = Students::model()->findAll($criteria);
			foreach($names as $student_name)
			{
                            $list_model= GuardianList::model()->findAllByAttributes(array('student_id'=>$student_name->id));
                            foreach($list_model as $data)
                            {
				$name_lists[] = $data->guardian_id;
                            }
			}  
                        
                        $criteria2= new CDbCriteria();
			$criteria2->addInCondition('id', $name_lists); 
                        $total = Guardians::model()->count($criteria2);
                        $pages = new CPagination($total);
                        $pages->setPageSize(Yii::app()->params['listPerPage']);
                        $pages->applyLimit($criteria2);
                        
                        
                        
                        $model = Guardians::model()->findAll($criteria2);                                                
                        $this->render('search',array('model'=>$model,                                       
                                        'pages' => $pages,
                                        'item_count'=>$total,
                                        'page_size'=>Yii::app()->params['listPerPage'],)) ;

                                        }	
            else {
                                            $this->render('search');
                
            }
                
            
        }
}
