<?php
/**
 * Ajax Crud Administration
 * FinanceFeeCollectionsController *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 * @license The MIT License
 */

class FinanceFeeCollectionsController extends RController
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
				'actions'=>array('ajax_create','ajax_update','dateformat','convertTime'),
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
		$model=FinanceFeeCollections::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='finance-fee-collections-form')
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
             if(isset($_POST['update_id']))
			 {
			 $model= $this->loadModel($_POST['update_id']);
			 $model_1=FinanceFeeCategories::model()->findByAttributes(array('id'=>$model->fee_category_id));
			 }
			 else 
			 {
				 $model=new FinanceFeeCollections;
				 $model_1 = new FinanceFeeCategories;
				 
			 }
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


        $this->renderPartial('_ajax_form', array('model'=>$model,'model_1'=>$model_1), false, true);
      }

        	public function actionIndex(){

		$model=new FinanceFeeCollections('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FinanceFeeCollections']))
			$model->attributes=$_GET['FinanceFeeCollections'];
			
		$this->render('index',array('model'=>$model));
		
	}


        public function actionAjax_Update()
		{
		
			$create_flag = 0;
			if(isset($_POST['FinanceFeeCollections']))
			{
			   $model=$this->loadModel($_POST['update_id']);
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				if($settings!=NULL)
				{	$model->start_date=date($settings->displaydate,strtotime($model->start_date));
	
				}
			  
				if($model->fee_category_id!=$_POST['FinanceFeeCollections']['fee_category_id']){ // Delete student details from finance fees if fee_category_id is different.
					$create_flag = 1;
					FinanceFees::model()->deleteAll('fee_collection_id=:x' , array(':x' => $model->id));
					
				}
				
				$model->attributes=$_POST['FinanceFeeCollections'];
				 if($model->start_date)
					$model->start_date=date('Y-m-d',strtotime($model->start_date));
				if($model->end_date)
					$model->end_date=date('Y-m-d',strtotime($model->end_date));
				if($model->due_date)
					$model->due_date=date('Y-m-d',strtotime($model->due_date));
				$get_batch = FinanceFeeCategories::model()->findByAttributes(array('id'=>$model->fee_category_id));
				$model->batch_id = $get_batch->batch_id;
				
				if($model->save(false)){
					if($create_flag==1){
						$student = Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$model->batch_id,':y'=>1,':z'=>0));
						foreach($student as $students)
						 {
							$finance = new FinanceFees;
							$finance->fee_collection_id = $model->id;
							$finance->student_id = $students->id;
							$finance->is_paid = 0;
							$finance->save();
						 }
					}
					echo json_encode(array('success'=>true));
				 }else
					echo json_encode(array('success'=>false));
			}

}


  public function actionAjax_Create(){

       if(isset($_POST['FinanceFeeCollections']))
		{
						$list = $_POST['FinanceFeeCollections'];
                       $model=new FinanceFeeCollections;
					   
					   $model->attributes=$_POST['FinanceFeeCollections'];
					   if($model->start_date)
						$model->start_date=date('Y-m-d',strtotime($model->start_date));
						if($model->end_date)
						$model->end_date=date('Y-m-d',strtotime($model->end_date));
						if($model->due_date)
						$model->due_date=date('Y-m-d',strtotime($model->due_date));
						$cat = FinanceFeeCategories::model()->findByAttributes(array('id'=>$list['fee_category_id']));
						$model->batch_id = $cat->batch_id;
                       //return the JSON result to provide feedback.
					   $student = Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$cat->batch_id,':y'=>1,':z'=>0));
					   $current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
						if(Yii::app()->user->year)
						{
							$year = Yii::app()->user->year;
						}
						else
						{
							$year = $current_academic_yr->config_value;
						}
						$model->academic_yr_id=$year;
			            if($model->save(false)){
							
						foreach($student as $students)
						 {
							$finance = new FinanceFees;
							$finance->fee_collection_id = $model->id;
							$finance->student_id = $students->id;
							$finance->is_paid = 0;
							$finance->save();
						 }
								
							echo json_encode(array('success'=>true,'id'=>$model->primaryKey) );
							exit;
                        } else
                        {
                            echo json_encode(array('success'=>false));
                            exit;
                        }
		}
  }
 public function Dateformat($data)
 {
	 echo 'aaa';
	 print_r($data);
	// echo $data;
 }
  public function convertTime($date)

 {
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
	if($settings!=NULL)
	{	$date1=date($settings->displaydate,strtotime($date));

	}
	echo $date1;
	 
 }
 
     public function actionAjax_delete()
	 {
		$id=$_POST['id'];
		$deleted=$this->loadModel($id);
		if ($deleted->delete()){
			FinanceFees::model()->deleteAll('fee_collection_id=:x' , array(':x' => $id));
			echo json_encode (array('success'=>true));
			exit;
		}else{
			echo json_encode (array('success'=>false));
			exit;
		}
      }


}
