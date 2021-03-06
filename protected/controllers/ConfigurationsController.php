<?php

class ConfigurationsController extends RController
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
				'actions'=>array('setup','DisplaySavedImage','Remove','DisplayLogoImage'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','viewyear'),
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
	
	public function actionSetup()
	{
		$this->layout = 'no_layout';
		$model = new User;
		if(isset($_POST['User']))
		{
			 //Generating The Salt and hasing the password
		   $salt = $model->generateSalt();
		   $_POST['User']['password'] = $model->hashPassword($_POST['User']['password'],$salt);
		   $_POST['User']['salt'] = $salt;
		   $model->attributes=$_POST['User'];
			if($model->save())
			{
				
					$model=new Configurations;
		            $logo = new Logo;
				$posts_1=Configurations::model()->findByAttributes(array('id'=>1));
			$posts_1->config_value = $_POST['collegename'];
			$posts_1->save();
			
			$posts_2=Configurations::model()->findByAttributes(array('id'=>2));
			$posts_2->config_value = $_POST['address'];
			$posts_2->save();
			
			$posts_3=Configurations::model()->findByAttributes(array('id'=>3));
			$posts_3->config_value = $_POST['phone'];
			$posts_3->save();
			
			$posts_4=Configurations::model()->findByAttributes(array('id'=>4));
			$posts_4->config_value = $_POST['attentance'];
			$posts_4->save();
			
			$posts_5=Configurations::model()->findByAttributes(array('id'=>13));
			$posts_5->config_value = $_POST['startyear'];
			$posts_5->save();
			
			$posts_6=Configurations::model()->findByAttributes(array('id'=>14));
			$posts_6->config_value = $_POST['endyear'];
			$posts_6->save();
			
			$posts_8=Configurations::model()->findByAttributes(array('id'=>5));
			$posts_8->config_value = $_POST['currency'];
			$posts_8->save();
			
			$posts_9=Configurations::model()->findByAttributes(array('id'=>6));
			$posts_9->config_value = $_POST['language'];
			$posts_9->save();
			
			/*$posts_10=Configurations::model()->findByAttributes(array('id'=>6));
			$posts_10->config_value = $_POST['logo'];
			$posts_10->save();*/
			if($file=CUploadedFile::getInstance($logo,'uploadedFile'))
       		 {
			$logo = new Logo;
            $logo->photo_file_name=$file->name;
            $logo->photo_content_type=$file->type;
            $logo->photo_file_size=$file->size;
            $logo->photo_data=file_get_contents($file->tempName);
			if(!is_dir('uploadedfiles/')){
				mkdir('uploadedfiles/');
			}
			if(!is_dir('uploadedfiles/school_logo/')){
				mkdir('uploadedfiles/school_logo/');
			}
			move_uploaded_file($file->tempName,'uploadedfiles/school_logo/'.$file->name);
      		$logo->save();
			$posts_10=Configurations::model()->findByAttributes(array('id'=>18));
			$posts_10->config_value = Yii::app()->db->getLastInsertId();;
			$posts_10->save();
			 }
			if(isset($_POST['dateformat']) && (isset($_POST['timeformat'])) && isset($_POST['timezone'])&& isset($_POST['language']))
			 {
				 
				 $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				 $date='';
				 if(settings!=NULL)
				 {
				 $settings->user_id=Yii::app()->user->id;
				 $settings->dateformat=$_POST['dateformat'];
					
				 					if($_POST['dateformat']=='m/d/yy')
									$settings->displaydate='m/d/Y';
									else if($_POST['dateformat']=='M d.yy')
									$settings->displaydate='M d.Y';
									else if($_POST['dateformat']=='D, M d.yy')
									$settings->displaydate='D, M d.Y';
									else if($_POST['dateformat']=='d M yy')
									$settings->displaydate='d M Y';
									else if($_POST['dateformat']=='yy/m/d')
									$settings->displaydate='Y/m/d';				
				    $settings->timeformat=$_POST['timeformat'];
				    $settings->timezone=$_POST['timezone'];
				    $settings->language=$_POST['language'];
				 }
				 else
				 {
					  $settings->user_id=Yii::app()->user->id;
				 	  $settings->dateformat=$_POST['dateformat'];
					  if($_POST['dateformat']=='m/d/yy')
									$settings->displaydate='m/d/Y';
									else if($_POST['dateformat']=='M d.yy')
									$settings->displaydate='M d.Y';
									else if($_POST['dateformat']=='D, M d.yy')
									$settings->displaydate='D, M d.Y';
									else if($_POST['dateformat']=='d M yy')
									$settings->displaydate='d M Y';
									else if($_POST['dateformat']=='yy/m/d')
									$settings->displaydate='Y/m/d';
					 
				 	  $settings->timeformat=$_POST['timeformat'];
				      $settings->timezone=$_POST['timezone'];
				      $settings->language=$_POST['language'];
				 }
				 $settings->save();
			 }
			$posts_11=Configurations::model()->findByAttributes(array('id'=>12));
			$posts_11->config_value = $_POST['network'];
			$posts_11->save();
			
			$posts_12=Configurations::model()->findByAttributes(array('id'=>7));
			$posts_12->config_value = $_POST['admission_number'];
			$posts_12->save();
			
			$posts_13=Configurations::model()->findByAttributes(array('id'=>8));
			$posts_13->config_value = $_POST['employee_number'];
			$posts_13->save();
				
			
				$this->redirect(array('site/login'));
			}
		}
		
		
		$this->render('setup',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Configurations;
		$logo = new Logo;
                $favicon= new Favicon;
		$err_flag = 0;
		$err_msg = Yii::t('app','Please fix the following input errors:').'<br/>';
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
			//exit;
		if(isset($_POST['submit']))
		{
			
			if($_POST['collegename'])
			{
				$posts_1=Configurations::model()->findByAttributes(array('id'=>1));
				$posts_1->config_value = $_POST['collegename'];
				$posts_1->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','School / College name cannot be blank').'<br/>';
			}
			
			if($_POST['registrationid'])
			{
				$posts_2=Configurations::model()->findByAttributes(array('id'=>22));
				$posts_2->config_value = $_POST['registrationid'];
				$posts_2->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Registration ID cannot be blank').'<br/>';
			}
			
			$posts_3=Configurations::model()->findByAttributes(array('id'=>23));
			$posts_3->config_value = $_POST['founded'];
			$posts_3->save();
			
			$posts_4=Configurations::model()->findByAttributes(array('id'=>27));
			$posts_4->config_value = $_POST['curriculam'];
			$posts_4->save();
			
			if($_POST['address'])
			{
				$posts_5=Configurations::model()->findByAttributes(array('id'=>2));
				$posts_5->config_value = $_POST['address'];
				$posts_5->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Address cannot be blank').'<br/>';
			}
			
			$posts_6=Configurations::model()->findByAttributes(array('id'=>24));
			$posts_6->config_value = $_POST['zipcode'];
			if(is_numeric($_POST['zipcode']))
			{
			
			$posts_6->save();
			}
			else
			{
				$err_flag = 1;
					$err_msg = $err_msg.'- '.Yii::t('app','Zip code is not valid').'<br/>';
			}
			
			if($_POST['phone1'])
			{
				if($_POST['phone1'] and filter_var($_POST['phone1'],FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]*$/"))))
				{
					$posts_7=Configurations::model()->findByAttributes(array('id'=>3));
					$posts_7->config_value = $_POST['phone1'];
					$posts_7->save();
				}
				else
				{
					$err_flag = 1;
					$err_msg = $err_msg.'- '.Yii::t('app','Phone number is not valid').'<br/>';
				}
				
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Phone cannot be blank').'<br/>';
			}
			
			if(($_POST['phone2'] and filter_var($_POST['phone2'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]*$/")))) or ($_POST['phone2'] == NULL))
			{
				$posts_8=Configurations::model()->findByAttributes(array('id'=>28));
				$posts_8->config_value = $_POST['phone2'];
				$posts_8->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Alternate Phone number is not valid').'<br/>';
			}
			
			if($_POST['email'])
			{
				if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
				{
					$posts_9=Configurations::model()->findByAttributes(array('id'=>25));
					$posts_9->config_value = $_POST['email'];
					$posts_9->save();
				}
				else
				{
					$err_flag = 1;
					$err_msg = $err_msg.'- '.Yii::t('app','Email is not valid').'<br/>';
				}
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Email cannot be blank').'<br/>';	
			}
			
			$posts_10=Configurations::model()->findByAttributes(array('id'=>26));
			$posts_10->config_value = $_POST['fax'];
			$posts_10->save();
			
			
			if($file=CUploadedFile::getInstance($logo,'uploadedFile'))
                        {
				$logo = new Logo;
				$logo->photo_file_name=$file->name;
				$logo->photo_content_type=$file->type;
				$logo->photo_file_size=$file->size;
				$logo->photo_data=file_get_contents($file->tempName);
				if(!is_dir('uploadedfiles/')){
					mkdir('uploadedfiles/');
				}
				if(!is_dir('uploadedfiles/school_logo/')){
					mkdir('uploadedfiles/school_logo/');
				}
				move_uploaded_file($file->tempName,'uploadedfiles/school_logo/'.$file->name);
				
				$file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'uploadedfiles/school_logo/'.$file->name);  // image
				
				//$logo->save();
				if($logo->save()){
				}
				else{
					$err_flag = 1;
				}
				
				$posts_img=Configurations::model()->findByAttributes(array('id'=>18));
				$posts_img->config_value = Yii::app()->db->getLastInsertId();
				$posts_img->save();
			}
                        
                        
                        if($fav_file=CUploadedFile::getInstance($favicon,'icon'))
                        {
				$fav = new Favicon;
				$fav->icon=$fav_file->name;
				
                                
				if(!is_dir('uploadedfiles/')){
					mkdir('uploadedfiles/');
				}
				if(!is_dir('uploadedfiles/school_favicon/')){
					mkdir('uploadedfiles/school_favicon/');
				}
				move_uploaded_file($fav_file->tempName,'uploadedfiles/school_favicon/'.$fav_file->name);
				
				$fav_file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'uploadedfiles/school_favicon/'.$fav_file->name);  // image
				
				//$logo->save();
				if($fav->save()){
				}
				else{
					$err_flag = 1;
				}
				
				
			}

			$posts_11=Configurations::model()->findByAttributes(array('id'=>29));
			$posts_11->config_value = $_POST['principalname'];
			$posts_11->save();
			
			if(($_POST['principalemail'] and filter_var($_POST['principalemail'], FILTER_VALIDATE_EMAIL)) or ($_POST['principalemail']==NULL))
			{
				$posts_12=Configurations::model()->findByAttributes(array('id'=>30));
				$posts_12->config_value = $_POST['principalemail'];
				$posts_12->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Principal Email is not valid').'<br/>';
			}
			
			if($_POST['email']==$_POST['principalemail'])
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','College and Principal Mail Ids cannot be the same !').'<br/>';
			}
			
			if(($_POST['principalphone'] and filter_var($_POST['principalphone'],FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]*$/")))) or ($_POST['principalphone'] == NULL))
			{
				$posts_13=Configurations::model()->findByAttributes(array('id'=>31));
				$posts_13->config_value = $_POST['principalphone'];
				$posts_13->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Principal Phone number is not valid').'<br/>';
			}
			
			if(($_POST['principalmobile'] and filter_var($_POST['principalmobile'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]*$/")))) or ($_POST['principalmobile'] == NULL))
			{
				$posts_14=Configurations::model()->findByAttributes(array('id'=>32));
				$posts_14->config_value = $_POST['principalmobile'];
				$posts_14->save();
			}
			else
			{
				$err_flag = 1;
				$err_msg = $err_msg.'- '.Yii::t('app','Principal Mobile number is not valid').'<br/>';
			}
			
			$academic_years = AcademicYears::model()->findAll();
			$count = count($academic_years);
			if($count > 0)
			{
				
				if($_POST['academic_year'])
				{
					$posts_15=Configurations::model()->findByAttributes(array('id'=>35));
					$posts_15->config_value = $_POST['academic_year'];
					if($posts_15->save())
					{
						$old_year = AcademicYears::model()->findByAttributes(array('status'=>1));
						if($old_year)
						{
							$old_year->status = 0;
							$old_year->save();
						}
						
						$new_year = AcademicYears::model()->findByAttributes(array('id'=>$_POST['academic_year']));
						$new_year->status = 1;
						$new_year->save();
					}
					
					
				}
				else
				{
					$err_flag = 1;
					$err_msg = $err_msg.'- '.Yii::t('app','Select an academic year').'<br/>';	
				}
				
			}
			
			$posts_17=Configurations::model()->findByAttributes(array('id'=>13));
			$posts_17->config_value = $_POST['financial_yr_start'];
			$posts_17->save();
			
			$posts_18=Configurations::model()->findByAttributes(array('id'=>14));
			$posts_18->config_value = $_POST['financial_yr_end'];
			$posts_18->save();

			$posts_19=Configurations::model()->findByAttributes(array('id'=>12));
			$posts_19->config_value = $_POST['network'];
			$posts_19->save();
			
			$posts_20=Configurations::model()->findByAttributes(array('id'=>5));
			$posts_20->config_value = $_POST['currency'];
			$posts_20->save();
			
			$posts_language=Configurations::model()->findByAttributes(array('id'=>6));
			$posts_language->config_value = $_POST['language'];
			$posts_language->save();
			
			if(isset($_POST['dateformat']) && (isset($_POST['timeformat'])) && isset($_POST['timezone'])&& isset($_POST['language']))
			{
			
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				$date='';
				if($settings!=NULL)
				{
					$settings->user_id=Yii::app()->user->id;
					$settings->dateformat=$_POST['dateformat'];
					
					if($_POST['dateformat']=='m/d/yy')
						$settings->displaydate='m/d/Y';
					else if($_POST['dateformat']=='M d.yy')
					$settings->displaydate='M d.Y';
						else if($_POST['dateformat']=='D, M d.yy')
					$settings->displaydate='D, M d.Y';
						else if($_POST['dateformat']=='d M yy')
					$settings->displaydate='d M Y';
						else if($_POST['dateformat']=='yy/m/d')
					$settings->displaydate='Y/m/d';
					
					$settings->timeformat=$_POST['timeformat'];
					$settings->timezone=$_POST['timezone'];
					$settings->language=$_POST['language'];
				}
				else
				{
					$settings = new UserSettings;
					$settings->user_id=Yii::app()->user->id;
					$settings->dateformat=$_POST['dateformat'];
					if($_POST['dateformat']=='m/d/yy')
						$settings->displaydate='m/d/Y';
					else if($_POST['dateformat']=='M d.yy')
						$settings->displaydate='M d.Y';
					else if($_POST['dateformat']=='D, M d.yy')
						$settings->displaydate='D, M d.Y';
					else if($_POST['dateformat']=='d M yy')
						$settings->displaydate='d M Y';
					else if($_POST['dateformat']=='yy/m/d')
						$settings->displaydate='Y/m/d';
					
					$settings->timeformat=$_POST['timeformat'];
					$settings->timezone=$_POST['timezone'];
					$settings->language=$_POST['language'];
				}
				$settings->save();
			}
			
			
			$posts_21=Configurations::model()->findByAttributes(array('id'=>4));
			$posts_21->config_value = $_POST['attentance'];
			$posts_21->save();
			
			
			//Saving online admission mumber
			$online_settings = OnlineRegisterSettings::model()->findByAttributes(array('id'=>3));
			$online_settings->config_value = $_POST['start_no'];
			$online_settings->save();
			
			/*$posts_adm_no=Configurations::model()->findByAttributes(array('id'=>7));
			$posts_adm_no->config_value = $_POST['admission_number'];
			$posts_adm_no->save();
			 
			$posts_emp_no=Configurations::model()->findByAttributes(array('id'=>8));
			$posts_emp_no->config_value = $_POST['employee_number'];
			$posts_emp_no->save();*/
					
			
			if($err_flag==0){
				Yii::app()->user->setFlash('successMessage',Yii::t('app',"Configurations saved successfully!"));
				$this->redirect(array('create'));
			}
			else
			{
				Yii::app()->user->setFlash('errorMessage',$err_msg);
			}
		}
		$this->render('create',array(
			'model'=>$model,'logo'=>$logo,'favicon'=>$favicon
		));
			}
	public function actionDisplaySavedImage()
		{
			//$model=$this->loadModel($_GET['id']);
		 	$model=Logo::model()->findByPk($_GET['id']);
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-length: '.$model->photo_file_size);
			header('Content-Type: '.$model->photo_content_type);
			header('Content-Disposition: attachment; filename='.$model->photo_file_name);
				echo  $model->photo_data;
		}
		
		public function actionDisplayLogoImage()
		{
		 	$model=Logo::model()->findByPk($_GET['id']);
			echo '<img src="uploadedfiles/school_logo/'.$model->photo_file_name.'" alt="'.$model->photo_file_name.'" class="imgbrder" width="119" />';
		}
		
		
	public function actionRemove()
	{
		
		$posts_1=Logo::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$logo_path='uploadedfiles/school_logo/'.$posts_1->photo_file_name;
		if(file_exists($logo_path)){
			unlink($logo_path);
		}
		$posts_1->delete();
		$this->redirect(array('create'));
	}
        
        //for remove fav icon
        public function actionFavremove()
	{
		
		$posts=  Favicon::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$icon_path='uploadedfiles/school_favicon/'.$posts->icon;
		if(file_exists($icon_path)){
			unlink($icon_path);
		}
		$posts->delete();
		$this->redirect(array('create'));
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

		if(isset($_POST['submit']))
		{
			
			$posts_1=Configurations::model()->findByAttributes(array('id'=>1));
			$posts_1->config_value = $_POST['collegename'];
			$posts_1->save();
			
			$posts_2=Configurations::model()->findByAttributes(array('id'=>2));
			$posts_2->config_value = $_POST['address'];
			$posts_2->save();
			
			$posts_3=Configurations::model()->findByAttributes(array('id'=>3));
			$posts_3->config_value = $_POST['phone'];
			$posts_3->save();
			
			$posts_4=Configurations::model()->findByAttributes(array('id'=>4));
			$posts_4->config_value = $_POST['attentance'];
			$posts_4->save();
			
			$posts_5=Configurations::model()->findByAttributes(array('id'=>13));
			$posts_5->config_value = $_POST['startyear'];
			$posts_5->save();
			
			$posts_6=Configurations::model()->findByAttributes(array('id'=>14));
			$posts_6->config_value = $_POST['endyear'];
			$posts_6->save();
			
			$posts_7=Configurations::model()->findByAttributes(array('id'=>14));
			$posts_7->config_value = $_POST['currency'];
			$posts_7->save();
			
			$posts_8=Configurations::model()->findByAttributes(array('id'=>5));
			$posts_8->config_value = $_POST['currency'];
			$posts_8->save();
			
			$posts_9=Configurations::model()->findByAttributes(array('id'=>6));
			$posts_9->config_value = $_POST['language'];
			$posts_9->save();
			
			if($file=CUploadedFile::getInstance($model,'logo'))
       		 {
				 
			$logo = new Logo;
            $logo->photo_file_name=$file->name;
            $logo->photo_content_type=$file->type;
            $logo->photo_file_size=$file->size;
            $logo->photo_data=file_get_contents($file->tempName);
      		 $logo->save();
			$posts_10=Configurations::model()->findByAttributes(array('id'=>18));
			$posts_10->config_value = Yii::app()->db->getLastInsertId();;
			$posts_10->save();
			 }
			
			$posts_11=Configurations::model()->findByAttributes(array('id'=>12));
			$posts_11->config_value = $_POST['network'];
			$posts_11->save();
			
			$posts_12=Configurations::model()->findByAttributes(array('id'=>7));
			$posts_12->config_value = $_POST['admission_number'];
			$posts_12->save();
			
			$posts_13=Configurations::model()->findByAttributes(array('id'=>8));
			$posts_13->config_value = $_POST['employee_number'];
			$posts_13->save();
				$this->redirect(array('create'));
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
		$dataProvider=new CActiveDataProvider('Configurations');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Configurations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Configurations']))
			$model->attributes=$_GET['Configurations'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * View complete details of a particular year, without changing the current active year
	 */
	public function actionViewyear()
	{
		/*if($_POST['yid'])
		{
			$year = Configurations::model()->findByAttributes(array('id'=>35));
			$year->config_value = $_POST['yid'];
			$year->save();
		}*/
		if($_POST['system_yid'])
		{
			Yii::app()->user->setState('year', $_POST['system_yid']);			
		}
		
		exit;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Configurations::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='configurations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionFeatures()
	{
		$model = new Configurations;
		$var1 = Configurations::model()->findByAttributes(array('id'=>38));
		$var2 = Configurations::model()->findByAttributes(array('id'=>39)); 
		$model->achievements = $var1->config_value;
		$model->complaints = $var2->config_value;
		if(isset($_POST['Configurations']))
		{
			if(isset($_POST['Configurations']['achievements']))
				{
					if($_POST['Configurations']['achievements']=='0')
					{
						$var1->config_value = 0;
						$var1->save();
					}
					else
					{
						$var1->config_value = 1;
						$var1->save();	
					}
					
				}
				if(isset($_POST['Configurations']['complaints']))
				{
					if($_POST['Configurations']['complaints']=='0')
					{
						$var2->config_value = 0;
						$var2->save();	
					}
					else
					{
						$var2->config_value = 1;
						$var2->save();	
					}
					
				}
				Yii::app()->user->setFlash('successMessage', Yii::t('app',"Action performed successfully"));
				$this->redirect(array('configurations/features'));
		}
		$this->render('features', array('model'=>$model,));
	}
	
}
