<?php
class ComplaintsController extends RController
{
	
	
	public function   init()
	 {
             $this->registerAssets();
              parent::init();
 	 }
	 public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

  private function registerAssets()
  	{

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
	public function actionCategories()
	{
		$model=new ComplaintCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ComplaintCategories']))
			$model->attributes=$_GET['ComplaintCategories'];

		$this->render('categories',array('model'=>$model));
		
	}
	
	public function actionReturnForm(){

              //Figure out if we are updating a Model or creating a new one.
             if(isset($_POST['update_id']))$model= $this->loadModel($_POST['update_id']);else $model=new ComplaintCategories;
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
	
	public function actionAjax_Update()
	{
		if(isset($_POST['ComplaintCategories']))
		{
           $model=$this->loadModel($_POST['update_id']);
			$model->attributes=$_POST['ComplaintCategories'];
			if( $model->save(false))
			{
                         echo json_encode(array('success'=>true));
		             
			}else
                     echo json_encode(array('success'=>false));
            }

	}


  public function actionAjax_Create(){

               if(isset($_POST['ComplaintCategories']))
		{
                       $model=new ComplaintCategories;
                      //set the submitted values
                        $model->attributes=$_POST['ComplaintCategories'];
                       //return the JSON result to provide feedback.
			            if($model->save(false)){
                                echo json_encode(array('success'=>true,'id'=>$model->primaryKey) );
                                exit;
                        } else
                        {
                            echo json_encode(array('success'=>false));
                            exit;
                        }
		}
  }

     public function actionAjax_delete(){
                 $id=$_POST['id'];
                 $deleted=$this->loadModel($id);
                if ($deleted->delete() ){
               echo json_encode (array('success'=>true));
               exit;
                }else{
                  echo json_encode (array('success'=>false));
                  exit;
                           }
      }
	  
	  
	  
	  public function loadModel($id)
	{
		$model=ComplaintCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t("app",'The requested page does not exist.'));
		return $model;
	}
	  public function actionIndex()
	   {
		   	$flag = 0;
		    $model = new Complaints;
		 	$criteria = new CDbCriteria;
			$criteria->join = 'LEFT JOIN authassignment t1 ON t.uid = t1.userid'; 
			$criteria->order = 't.status ASC, t.id DESC, t.date DESC';
			
			if(isset($_REQUEST['subject']) and $_REQUEST['subject']!=NULL)
			{
				$criteria->condition='t.subject LIKE :subject';
				$criteria->params[':subject'] = $_REQUEST['subject'].'%';
				$flag = 1;
			}
			if(isset($_REQUEST['Complaints']['status']) and $_REQUEST['Complaints']['status']!=NULL)
			{
				$model->status = $_REQUEST['Complaints']['status'];
				if($flag == 1){
					$criteria->condition = $criteria->condition.' AND t.status = :status';
				}else{
					$criteria->condition='t.status = :status';
				}
				$criteria->params[':status'] = $_REQUEST['Complaints']['status'];
				$flag = 1;
			}
			
			if(isset($_REQUEST['role_type']) and $_REQUEST['role_type']!=NULL){
				if($flag == 1){
					$criteria->condition = $criteria->condition.' AND t1.itemname=:itemname';					
				}else{
					$criteria->condition = 't1.itemname=:itemname';
				}
				$criteria->params[':itemname'] = $_REQUEST['role_type'];
			}
			
			if(isset($_REQUEST['user_name']) and $_REQUEST['user_name']!=NULL)
				{
					$criteria1 = new CDbCriteria;
					$criteria1->condition = 'firstname LIKE :name' ;
					$criteria1->params[':name'] = $_REQUEST['user_name'].'%';
				$users = Profile::model()->findAll($criteria1);
				$ids = array();
				foreach($users as $user)
				{
					$ids[] = $user->user_id;
				}			
				$criteria->addInCondition('uid', $ids);
			}
			
			
			
			$count = Complaints::model()->count($criteria);
			
		   	$pages  = new CPagination($count);
        	$pages->setPageSize(Yii::app()->params['listPerPage']);
        	$pages->applyLimit($criteria); 
			
			$complaints = Complaints::model()->findAll($criteria);
			
		   	$this->render('index',array(
			'model'=>$model,
			'complaints'=>$complaints,
			'item_count'=>$count,
			'pages'=>$pages,
			'page_size'=>Yii::app()->params['listPerPage'],));
	   }
	   public function actionCreate()
	   {
		    $viewfile = '_othercreate';
		    $roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
			if(sizeof($roles)==1 and key($roles) == 'student')
			{
				 $this->layout = '/portallayouts/studentmain';
				 $viewfile = '_portalcreate'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'parent')
			{
				 $this->layout = '/portallayouts/none';
				 $viewfile = '_portalcreate'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'teacher')
			{
				 $this->layout = '/portallayouts/teachers';
				 $viewfile = '_portalcreate'; 
			}
			
			
		    $model= new Complaints;
		  
		  if(isset($_POST['Complaints']))
		  {
		   
		  
		   $model->attributes=$_POST['Complaints'];
		   $model->uid=Yii::app()->user->id;
		   $model->date=date('Y-m-d H:i:s');
		    $model->viewed=0;
		   $model->status=0;
		   
			
			if($model->save())
			{
				$this->redirect(array('feedbacklist'));
				
			}}
		    $this->render($viewfile,array('model'=>$model));
		
	   }
	   
	   public function actionRead()
	   {
		   $model		=	new ComplaintFeedback;
		   $complaint_model     =Complaints::model()->findByAttributes(array('id'=>$_REQUEST["id"]));
		   
		
		
		if(isset($_POST['ComplaintFeedback']))
		{	
			$model->uid				=	Yii::app()->user->id;
			date_default_timezone_set('Asia/Kolkata');
			//$model_1->attributes=$_POST['Allcomments'];
			
			$model->complaint_id=	$_REQUEST["id"];;
			$model->feedback =	$_POST['ComplaintFeedback']['feedback'];
			$model->date = date('Y-m-d H:i:s');
			
			
			if($model->save())
			{
				 $complaint_model->viewed=1;
				 $complaint_model->save();
				$this->redirect(array('read','id'=>$_REQUEST["id"]));
			}
		   
		}
		   
		   $this->render('read',array('model' =>$model));
	   }
	   public function actionFeedbacklist()
	   {
		    $page_size	= 10;
		   	$criteria = new CDbCriteria;
			$criteria->condition = 'uid=:uid';
			$criteria->params = array(':uid'=>Yii::app()->user->id);
			$criteria->order = 'status ASC, id DESC, date DESC';			
		   	$count			= Complaints::model()->count($criteria);
			$pages 			= new CPagination($count);
			$pages->setPageSize($page_size);
			$pages->applyLimit($criteria);		
			$complaints		= Complaints::model()->findAll($criteria);
		   
		   $viewfile = '_otherfeedbacklist';
		    $roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
			
			if(sizeof($roles)==1 and key($roles) == 'student')
			{
				 $this->layout = '/portallayouts/studentmain';
				 $viewfile = '_portalfeedbacklist'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'parent')
			{
				 $this->layout = '/portallayouts/none';
				 $viewfile = '_portalfeedbacklist'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'teacher')
			{
				 $this->layout = '/portallayouts/teachers';
				 $viewfile = '_portalfeedbacklist'; 
			}
		   
		     
		   $this->render($viewfile,array(
		   	'pages' => $pages,
			'item_count'=>$count,
			'page_size'=>$page_size,
			'complaints'=>$complaints,
			));
		   
		   
	   }
	   
	   public function actionClose($id)
	   {
		   $complaint=Complaints::model()->findByPk($id);
		   $complaint->status=1;
		   if($complaint->save())
		   {
			   if(Yii::app()->user->id==1)
			   {
			   $this->redirect(array('index'));
			   }
			   else
			   {
				   $this->redirect(array('feedbacklist'));
			   }
		   }
		   
	   }
	   public function actionReopen($id)
	   {
		   $complaint=Complaints::model()->findByPk($id);
		   $complaint->status=0;
		   $complaint->reopened_date=date('Y-m-d H:i:s');;
		   if($complaint->save())
		   {
			   if(Yii::app()->user->id==1)
			   {
			   $this->redirect(array('read','id'=>$id));
			   }
			   else
			   {
				   $this->redirect(array('feedback','id'=>$id));
			   }
		   }
		   
	   }
	   public function actionFeedback()
	   {
		   $user = Complaints::model()->findByAttributes(array('id'=>$_REQUEST["id"] , 'uid'=>Yii::app()->user->id));
		   if($user)
		   {		   
			   $model		=	new ComplaintFeedback;
			   if(isset($_POST['ComplaintFeedback']))
				{	
					$model->uid				=	Yii::app()->user->id;
					date_default_timezone_set('Asia/Kolkata');
					$model->complaint_id=	$_REQUEST["id"];;
					$model->feedback =	$_POST['ComplaintFeedback']['feedback'];
					$model->date = date('Y-m-d H:i:s');
					if($model->save())
					{
						
						$this->redirect(array('feedback','id'=>$_REQUEST["id"]));
					}
				   
				}
				$viewfile = 'otherfeedback';
		    $roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
			
			if(sizeof($roles)==1 and key($roles) == 'student')
			{
				 $this->layout = '/portallayouts/studentmain';
				 $viewfile = 'portalfeedback'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'parent')
			{
				 $this->layout = '/portallayouts/none';
				 $viewfile = 'portalfeedback'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'teacher')
			{
				 $this->layout = '/portallayouts/teachers';
				 $viewfile = 'portalfeedback'; 
			}
		   
			   
				$this->render($viewfile,array('model' =>$model));
		   }else{
			   throw new CHttpException(404,Yii::t("app",'The requested page does not exist.'));
		   }
	   }
	   
	   public function actionUpdate($id)
	{
		
		$model=ComplaintFeedback::model()->findByAttributes(array('id'=>$id));
		
			$viewfile = 'update';
		    $roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
			
			if(sizeof($roles)==1 and key($roles) == 'student')
			{
				 
				 $viewfile = 'portalupdate'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'parent')
			{
				 
				 $viewfile = 'portalupdate'; 
			}
			if(sizeof($roles)==1 and key($roles) == 'teacher')
			{
				 
				 $viewfile = 'portalupdate'; 
			}
		   		
                $this->renderPartial($viewfile,array('model'=>$model),false,true);
	}
	
	
	
	public function actionDisplay()
	{
		if(isset($_POST['ComplaintFeedback']) and 	$_POST['ComplaintFeedback']!=NULL) 
		{ 
			$model=ComplaintFeedback::model()->findByPk($_POST['ComplaintFeedback']['id']);
			$model->feedback = 	$_POST['ComplaintFeedback']['feedback'];
			$model->date=date('Y-m-d H:i:s'); 
			
			
			if($model->save())
			{
				echo CJSON::encode(array(
						'status'=>'success',                                					
				));
				exit;
			}
		}				
	}
	
	
	public function actionDelete($id)
	{
		$model=ComplaintFeedback::model()->findByAttributes(array('id'=>$id));
		if($model)
		{
			$model->delete();
			 if(Yii::app()->user->id==1)
			   {
					$this->redirect(array('read','id'=>$model->complaint_id));
			   }
			   else
			   {
				   $this->redirect(array('feedback','id'=>$model->complaint_id));
			   }
		}
		
		
	}
	
	
	
	

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}