<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		
		
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']) and $_POST['User']!=NULL )
		{
			$model->attributes=$_POST['User'];
			$password	= $_POST['User']['password'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					//send mail
					//UserModule::sendMail($model->email,UserModule::t("You are registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please login to your account with your email id as username and password {password}",array('{password}'=>$password)));
					$notification = NotificationSettings::model()->findByAttributes(array('id'=>12));
					$college=Configurations::model()->findByPk(1);
				//Mail	
					if($notification->mail_enabled == '1')
					{						
						$template=EmailTemplates::model()->findByPk(16);
						$subject = $template->subject;
						$message = $template->template;						
						$subject = str_replace("{{SCHOOL NAME}}",$college->config_value,$subject);						
						$message = str_replace("{{SCHOOL NAME}}",$college->config_value,$message);
						$message = str_replace("{{PASSWORD}}",$password,$message);																				
						UserModule::sendMail($model->email,$subject,$message);
					}	
				//Message					
					if($notification->msg_enabled == '1')
					{						
						$to = $model->id;
						$subject = 'Welcome to '.$college->config_value;
						$message = 'Hi, Welcome to '.$college->config_value.'. We are looking forward to your esteemed presence and cooperation with our organization.';
						NotificationSettings::model()->sendMessage($to,$subject,$message);
					}
					$profile->user_id=$model->id;
					$profile->save();
				}
				$this->redirect(array('/rights/assignment/user','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
                                
                                $usermodel= $this->Usermodel($model->id);
                                if($usermodel)
                                {
                                    if($usermodel==1)
                                    {
                                        $usr_model= Guardians::model()->findByAttributes(array('uid'=>  $model->id));
                                        $usr_model->email= $model->email;                                                                                
                                        $usr_model->save();
                                    }
                                    if($usermodel==2)
                                    {
                                        $usr_model= Students::model()->findByAttributes(array('uid'=> $model->id));
                                        $usr_model->email=$model->email;
                                        $usr_model->save();
                                    }
                                    if($usermodel==3)
                                    {
                                        $usr_model= Employees::model()->findByAttributes(array('uid'=>  $model->id));
                                        $usr_model->email= $model->email;
                                        $usr_model->save();
                                    }
                                }
                                
                                
				$this->redirect(array('/rights/assignment/user','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			if($model->delete()){
				$roles = Rights::getAssignedRoles($model->id);
				if(sizeof($roles)==1 and key($roles) == 'student'){
					$student = Students::model()->findByAttributes(array('uid'=>$model->id));
					if($student){
						$student->saveAttributes(array('uid'=>0));
					}
				}
				
				if(sizeof($roles)==1 and key($roles) == 'teacher'){
					$employee = Employees::model()->findByAttributes(array('uid'=>$model->id));
					if($employee){
						$employee->saveAttributes(array('uid'=>0));
					}
				}
				
				if(sizeof($roles)==1 and key($roles) == 'parent'){
					$guardian = Guardians::model()->findByAttributes(array('uid'=>$model->id));
					if($guardian){
						$guardian->saveAttributes(array('uid'=>0));
					}
				}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_POST['ajax']))
			   $this->redirect(array('/user/admin'));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	//check the user type and model
        public function Usermodel($id)
        {
            $user_model="";
            $roles=Rights::getAssignedRoles($id); // check for single role					
		foreach($roles as $role)
		{
                    $user_base= $role->name;
                    if($user_base=='parent')
                    {
                        $user_model= "1";
                    }
                    else if($user_base=='student')
                    {
                        $user_model= "2";
                    }
                    else if($user_base=='teacher')
                    {
                        $user_model= "3";
                    }                                        
                }
                return $user_model;
        }
}