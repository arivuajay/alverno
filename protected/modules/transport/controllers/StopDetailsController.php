<?php
class StopDetailsController extends RController
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
				'actions'=>array('index','view','manage'),
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
		$model=new StopDetails;
		//$err_flag = 0;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StopDetails']))
		{
			$add	=	false;
			$model->attributes=$_POST['StopDetails'];
			$route=RouteDetails::model()->findByAttributes(array('id'=>$_POST['StopDetails']['route_id']));
			$list=$_POST['StopDetails'];
			/*print_r($_POST);
			echo $list['fare'][0];
			exit;*/
			if(isset($_REQUEST['stops'])){
				$cnt=$_REQUEST['stops'];
				$add	=	true;
			}
			else{
				$cnt=$route['no_of_stops'];
			}
	        for($i=0;$i<$cnt;$i++)
				{
					
					if($list['stop_name'][$i]!=NULL and $list['fare'][$i]!=NULL and $_POST['arrival_mrng'][$i]!=NULL and $_POST['arrival_evng'][$i]!=NULL)
					{	
						$model=new StopDetails;
						$model->route_id=$_POST['StopDetails']['route_id'];
						$model->stop_name=$list['stop_name'][$i];
						$model->fare=$list['fare'][$i];
						$model->arrival_mrng=$_POST['arrival_mrng'][$i];
						$model->arrival_evng=$_POST['arrival_evng'][$i];
						if($model->validate() && $model->save()){
							$id	=	$model->route_id;
							$croute	=	RouteDetails::model()->findByPk($id);
							//$croute->saveAttributes(array('no_of_stops'=>$croute->no_of_stops+1));
						}
						else{
							$err_flag = 2;
						}
					}
					else{
						$err_flag = 1;
						
					}
				}
				if($err_flag==0){
					$this->redirect(array('manage','id'=>$model->route_id));
				}
				elseif($err_flag==1){
					Yii::app()->user->setFlash('errorMessage',Yii::t("app","All fields are required!"));
					$this->redirect(array('create','id'=>$_POST['StopDetails']['route_id']));
				}
				elseif($err_flag==2){
				    Yii::app()->user->setFlash('errorMessage',Yii::t("app","Enter valid data!"));
					$this->redirect(array('create','id'=>$_POST['StopDetails']['route_id']));
				}
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
		//$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/*if(isset($_POST['StopDetails']))
		{
			$model->attributes=$_POST['StopDetails'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}*/
		//$model=$this->loadModel($id);
		$model	=	StopDetails::model()->findAllByAttributes(array('route_id'=>$id));
		if(isset($_POST['StopDetails'])){
			$allStops	=	$_POST['StopDetails'];
			//var_dump($allStops);exit;
			foreach($allStops as $stop){
				$id	=	$stop['id'];
				$current=$this->loadModel($id);
				$current->stop_name		=	$stop['stop_name'];
				$current->fare		=	$stop['fare'];
				$current->arrival_mrng	=	$stop['arrival_mrng'];
				$current->arrival_evng	=	$stop['arrival_evng'];
				$current->save();
			}
			$this->redirect(array('manage','id'=>$current->route_id));
			//$model	=	StopDetails::model()->findAllByAttributes(array('route_id'=>$_REQUEST['id']));
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
	
	public function actionRemove($id)
	{	
		if(is_numeric($id)){
			$model	=	$this->loadModel($id);
			$id	=	$model->route_id;
			if($model->delete()){
				$route	=	RouteDetails::model()->findByPk($id);
				$route->saveAttributes(array('no_of_stops'=>$route->no_of_stops-1));
			}
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage','id'=>$model->route_id));
		}
		
		
	}
	
	public function actionRemoveAll($id){
		if(is_numeric($id)){
			StopDetails::model()->deleteAllbyAttributes(array('route_id'=>$id));
			$route	=	RouteDetails::model()->findByPk($id);
			$route->saveAttributes(array('no_of_stops'=>0));
			$this->redirect(array('stopDetails/manage','id'=>$id));
		}
		else{
			$this->redirect(array('RouteDetails/manage'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StopDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionManage()
	{
		$model=new StopDetails;
		
		$this->render('manage',array('model'=>$model));
		
		
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StopDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StopDetails']))
			$model->attributes=$_GET['StopDetails'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionEdit($id){
		$model=$this->loadModel($id);
		if(isset($_POST['StopDetails']))
		{
			$model->attributes=$_POST['StopDetails'];
			if($model->save())
				$this->redirect(array('stopDetails/manage','id'=>$model->route_id));
		}
		$this->render('edit',array('model'=>$model));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=StopDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='stop-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
