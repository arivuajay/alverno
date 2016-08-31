<?php

class TeachersController extends RController
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
	 
	 public function actionView($id)
	{
		$this->render('/fileUploads/teacher_view',array(
			'model'=>$this->loadAuthorized(array('id'=>$id,'created_by'=>Yii::app()->user->id)),
		));
	}
	public function actionIndex()
	{
		$criteria	=	new CDbCriteria;
		$criteria->condition	=	'`file`<>:null';
		$criteria->params	=	array(':null'=>'');		
		$roles	=	Rights::getAssignedRoles(Yii::app()->user->id); // check for single role
		$user_roles	=	array();
		foreach($roles as $role){
			$user_roles[]	=	'"'.$role->name.'"';
		}
		$teacher = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$batches = Batches::model()->findAllByAttributes(array('employee_id'=>$teacher->id));
		foreach($batches as $classteacher)
		{
			
			$batch[] = $classteacher->id;
			
		}
		
		$timetable = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$teacher->id));
		foreach($timetable as $period)
		{
			
			$batch[] = $period->batch_id;
		}
		
		$unique_batch = array_unique($batch);
		
		if(count($unique_batch)>0)
		{
			$criteria->condition			.=	' AND (`placeholder`=:null OR `created_by`=:user_id OR (`placeholder` IN ('.implode(',',$user_roles).')) AND (`batch` IS NULL OR `batch` IN ('.implode(',',$unique_batch).'))) ';
		}
		else
		{
			$criteria->condition			.=	' AND (`placeholder`=:null OR `created_by`=:user_id) OR (`placeholder` IN ('.implode(',',$user_roles).'))';
		}
		$criteria->params[':user_id']	=	Yii::app()->user->id;
		$criteria->order	=	'`created_at` DESC';
		
		$files		=	FileUploads::model()->findAll($criteria);
		if(isset($_POST['Downfiles'])){
			$selected_files	=	$_POST['Downfiles'];
			$slfiles	=	array();
			foreach($selected_files as $s_file){
				$model	=	FileUploads::model()->findByPk($s_file);
				if($model!=NULL){					
					$slfiles[]	=	'uploads/shared/'.$model->id.'/'.$model->file;
				}
			}			
			$zip			=	Yii::app()->zip;
			$fName			=	$this->generateRandomString(rand(10,20)).'.zip';
			$zipFile		=	'compressed/'.$fName;
			if($zip->makeZip($slfiles,$zipFile)){
				$fcon	=	file_get_contents($zipFile);
				header('Content-type:text/plain');
				header('Content-disposition:attachment; filename='.$fName);
				header('Pragma:no-cache');
				echo $fcon;
				unlink($zipFile);
			}
			else{
				Yii::app()->user->setFlash('success',Yii::t('app','Can\'t download'));
			}
			
		}
		$roles=Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
		foreach($roles as $role)
		{				
			if(sizeof($roles)==1 and $role->name == 'teacher')
			{
				$this->render('/fileUploads/teacher_index',array('files'=>$files));//if the current role is teacher,it render teacher_index.php page else it take index.php page
			}
			else
			{
				$this->render('/fileUploads/index',array('files'=>$files));
			}
		}
	}
	
	public function actionCreate()
	{
		$model=new FileUploads;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FileUploads']))
		{
			$model->attributes	=	$_POST['FileUploads'];
			$model->created_by	=	Yii::app()->user->id;			
			$model->file		=	CUploadedFile::getInstance($model,'file');
			//$obj_img			=	$model->file;
			$obj_img			=	CUploadedFile::getInstance($model,'file');
			$model->file_type	=	$obj_img->type;
			if($model->save()){
				if($obj_img!=NULL){	
					$path	=	'uploads/shared/'.$model->id.'/';
					if(!is_dir($path)){
						mkdir($path);
					}					
					//generate random image name
					//$randomImage	=	$this->generateRandomString(rand(10,15)).'.'.$obj_img->extensionName;
					$randomImage = $obj_img->name;
					if(!$obj_img->saveAs($path.$randomImage)){
						$model->file	=	NULL;							
					}
					else{
						$model->file	=	$randomImage;
					}					
				}
				else{
					$model->file	=	NULL;
				}
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('/fileUploads/teacher_create',array(
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
		$model=$this->loadAuthorized(array('id'=>$id,'created_by'=>Yii::app()->user->id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['FileUploads']))
		{
			$model->attributes	=	$_POST['FileUploads'];
			$obj_img		=	CUploadedFile::getInstance($model,'file');
			if($obj_img!=NULL){
				$model->file		=	$obj_img;
				$model->file_type	=	$obj_img->type;
			}
			if($model->placeholder=='')	
				$model->placeholder	=	NULL;
										
			if($model->save()){				
				if($obj_img!=NULL){
					$path	=	'uploads/shared/'.$model->id.'/';
					if(!is_dir($path)){
						mkdir($path);
					}					
					//generate random image name
					//$randomImage	=	$this->generateRandomString(rand(10,15)).'.'.$obj_img->extensionName;
					
					$randomImage = $obj_img->name;
					
					if(!$obj_img->saveAs($path.$randomImage)){
						$model->file	=	NULL;							
					}
					else{
						$model->file	=	$randomImage;
					}			
					$model->save();		
				}				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('/fileUploads/teacher_update',array(
			'model'=>$model,
		));
	}
	
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadAuthorized(array('id'=>$id,'created_by'=>Yii::app()->user->id));
			if($model!=NULL and $model->file!=NULL){
				$image_path	=	'uploads/shared/'.$model->id.'/'.$model->file;
				if(file_exists($image_path)){
					if(unlink($image_path)){
						rmdir('uploads/shared/'.$model->id.'/');
					}
				}
			}
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,Yii::t('app','Invalid request. Please do not repeat this request again.'));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FileUploads('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FileUploads']))
			$model->attributes=$_GET['FileUploads'];
		$model->created_by	=	Yii::app()->user->id;		
			
		$this->render('/fileUploads/teacher_admin',array(
			'model'=>$model,
		));
	}
	
	public function actionRemovefile($id){
		$model=$this->loadAuthorized(array('id'=>$id,'created_by'=>Yii::app()->user->id));
		if($model!=NULL and $model->file!=NULL){
			$image_path	=	'uploads/shared/'.$model->id.'/'.$model->file;
			if(file_exists($image_path)){
				if(unlink($image_path)){
					$model->file		=	NULL;
					$model->file_type	=	NULL;
					$model->save();
				}
			}
			else{
				echo Yii::t('app','file not exists');
				exit;
			}
		}
		$this->redirect(array('update','id'=>$id));
	}
	
	public function loadModel($id)
	{
		$model=FileUploads::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}
	
	public function loadAuthorized($attributes)
	{
		$model=FileUploads::model()->findByAttributes($attributes);
		if($model===null){
			if(Yii::app()->request->isAjaxRequest){
				header("HTTP/1.0 404 Not Found");
				echo Yii::t('app','You are not authorized to perform this action.');
				exit;
			}
			else
				throw new CHttpException(404,Yii::t('app','You are not authorized to perform this action.'));
		}
		return $model;
	}

	
	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}