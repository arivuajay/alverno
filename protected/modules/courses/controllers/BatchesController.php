<?php

class BatchesController extends RController
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
				'actions'=>array('index','view','manage','Batchstudents','Addnew','settings','Addupdate','remove','promote','deactivate','activate','elective','studentelectives','Removeelective'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update,actionname'),
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
	       public function actionAssignteacher(){

              //Figure out if we are updating a Model or creating a new one.
             if(isset($_POST['batch_id']))
			 {
			 	$model= $this->loadModel($_POST['batch_id']);
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				if($settings!=NULL)
				{	
					$model->start_date=date($settings->displaydate,strtotime($model->start_date));
					$model->end_date=date($settings->displaydate,strtotime($model->end_date));							
				}				
			 }			 
			 else 
			 {
				$model=new Batches;
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

		if(isset($_POST['batch_id']) and $_POST['batch_id']==0)
		{
			$this->renderPartial('_ajax_form', array('model'=>$model,'batch_id'=>$_POST['batch_id']), false, true);
		}
		else
		{
        	$this->renderPartial('_ajax_form', array('model'=>$model), false, true);
		}
      } 
	 
	  public function actionAjax_Update(){
		if(isset($_POST['Batches']))
		{
           $model=$this->loadModel($_POST['update_id']);
			$model->attributes=$_POST['Batches'];
			$model->start_date=date('Y-m-d',strtotime($model->start_date));
			$model->end_date=date('Y-m-d',strtotime($model->end_date));
			
			/*$data=SubjectName::model()->findByAttributes(array('id'=>$model->name));
						if($data!=NULL)
						{
							$model->name=$data->name;
							$model->code=$data->code;
							
						}*/
			if( $model->save(false)){
                         echo json_encode(array('success'=>true));
		             }else
                     echo json_encode(array('success'=>false));
                }

	}


  		public function actionAjax_Create(){

       if(isset($_POST['Batches']))
		{
                       $model=new Batches;
					   
                      //set the submitted values
                        $model->attributes=$_POST['Batches'];
						
						/*$data=SubjectName::model()->findByAttributes(array('id'=>$model->name));
						if($data!=NULL)
						{
							$model->name=$data->name;
							$model->code=$data->code;
							
						}*/
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
		$model=new Batches;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
		if(Yii::app()->user->year)
		{
			$year = Yii::app()->user->year;
		}
		else
		{
			$year = $current_academic_yr->config_value;
		}
		
		if(isset($_POST['Batches']))
		{			
			$model->attributes=$_POST['Batches'];
			$list = $_POST['Batches'];
					if(!$list['start_date']){
						$s_d="";
					}
					else{
						$s_d=date('Y-m-d',strtotime($list['start_date']));
					}
					if(!$list['end_date']){
						$e_d="";
					}
					else{
						$e_d=date('Y-m-d',strtotime($list['end_date']));
					}
			$model->start_date=$s_d;
			$model->end_date=$e_d;
			$model->academic_yr_id=$year;
			if($model->save()){
				
		//In case of non duplicate feature
				if(!isset($_POST['Batches']['duplicate']) or (isset($_POST['Batches']['duplicate']) and $_POST['Batches']['duplicate'] == 0)){ 
					//Add common class timings
					$commonClassTimings = ClassTimings::model()->findAllByAttributes(array('batch_id'=>0));
					if($commonClassTimings){
						foreach($commonClassTimings as $commonClassTiming){
							$model_1 = new ClassTimings;
							$model_1->attributes = $commonClassTiming->attributes;
							$model_1->batch_id = $model->id;
							$model_1->admin_id = $commonClassTiming->id;
							$model_1->save();
						}
					}
					
					//Add common subject
					$common_subjects = SubjectsCommonPool::model()->findAllByAttributes(array('course_id'=>$model->course_id));
					if($common_subjects){
						foreach($common_subjects as $common_subject){
							$model_2 = new Subjects;
							$model_2->name = $common_subject->subject_name;
							$model_2->code = $common_subject->subject_code;
							$model_2->batch_id = $model->id;
							$model_2->max_weekly_classes = $common_subject->max_weekly_classes;
							$model_2->admin_id = $common_subject->id;
							$model_2->save();
						}
					}
				}
				
		//In case of duplicate batch 
				
				if(isset($_POST['Batches']['duplicate']) and $_POST['Batches']['duplicate'] == 1){
					
					$duplicate_batch_details = Batches::model()->findByAttributes(array('id'=>$_POST['Batches']['batch_list']));
					if($model->employee_id == NULL and $duplicate_batch_details->employee_id !=NULL){
						$model->saveAttributes(array('employee_id'=>$duplicate_batch_details->employee_id));
					}
										
					if($_POST['Batches']['duplicate_options'] == 1 or $_POST['Batches']['duplicate_options'] == 2 or $_POST['Batches']['duplicate_options'] == 3){ // 1 => Duplicate both subjetcs & electives, 2 => Duplicate Subjects Only, 3 => Duplicate electives only.	
										
						//Duplicate subject & subject association details
						if($_POST['Batches']['duplicate_options'] != 3){
							$all_subjects = Subjects::model()->findAllByAttributes(array('batch_id'=>$_POST['Batches']['batch_list'],'elective_group_id'=>0,'is_deleted'=>0));
						
							if($all_subjects){
								foreach($all_subjects as $all_subject){
									//Duplicate Subjects details
									$new_sub_entry = new Subjects;
									$new_sub_entry->attributes = $all_subject->attributes;
									$new_sub_entry->batch_id = $model->id;
									$new_sub_entry->no_exams = 0;
									$new_sub_entry->created_at = date('Y-m-d H:i:s');
									$new_sub_entry->updated_at = NULL;
									$new_sub_entry->admin_id = $all_subject->admin_id;
									$new_sub_entry->is_edit = $all_subject->is_edit;
									if($new_sub_entry->save()){								
										//Duplicate subject association details								
										$sub_associations = EmployeesSubjects::model()->findAllByAttributes(array('subject_id'=>$all_subject->id));
										if($sub_associations){
											foreach($sub_associations as $sub_association){
												$new_sub_association = new EmployeesSubjects;
												$new_sub_association->employee_id = $sub_association->employee_id;
												$new_sub_association->subject_id = $new_sub_entry->id;
												$new_sub_association->save();
											}
										}
									}
								}
							}
						}
						
						//Duplicate Elective Subjects & Elective subject association
						if($_POST['Batches']['duplicate_options'] != 2){
							$all_elective_groups = ElectiveGroups::model()->findAllByAttributes(array('batch_id'=>$_POST['Batches']['batch_list'],'is_deleted'=>0));						
							if($all_elective_groups){
								foreach($all_elective_groups as $all_elective_group){
									//Add elective group to elective group table
									$new_elective_group = new ElectiveGroups;
									$new_elective_group->attributes = $all_elective_group->attributes;								
									$new_elective_group->batch_id = $model->id;
									$new_elective_group->max_weekly_classes = 1;//This field is not in the elective group table. To aviod validation  given in this model 
									$new_elective_group->created_at = date('Y-m-d H:i:s');
									$new_elective_group->updated_at = NULL;									
									
									if($new_elective_group->save()){
										//Add elective group to subject table
										$sub_elective_group = Subjects::model()->findByAttributes(array('elective_group_id'=>$all_elective_group->id,'is_deleted'=>0,'batch_id'=>$_POST['Batches']['batch_list']));
										if($sub_elective_group){
											$new_sub_elective_group = new Subjects;
											$new_sub_elective_group->attributes = $sub_elective_group->attributes;
											$new_sub_elective_group->batch_id = $model->id;
											$new_sub_elective_group->elective_group_id = $new_elective_group->id;
											$new_sub_elective_group->created_at = date('Y-m-d H:i:s');
											$new_sub_elective_group->updated_at = NULL;
											$new_sub_elective_group->save();
										}
										
										//Add Electives
										$electives = Electives::model()->findAllByAttributes(array('elective_group_id'=>$all_elective_group->id,'batch_id'=>$_POST['Batches']['batch_list'],'is_deleted'=>0));
										if($electives){
											foreach($electives as $elective){
												$new_elective = new Electives;
												$new_elective->attributes = $elective->attributes;
												$new_elective->elective_group_id = $new_elective_group->id;
												$new_elective->batch_id = $model->id;
												$new_elective->created_at = date('Y-m-d H:i:s');
												$new_elective->updated_at = NULL;
												if($new_elective->save()){
													//Elective subject Association
													$elective_sub_associations = EmployeeElectiveSubjects::model()->findAllByAttributes(array('elective_id'=>$elective->id,'subject_id'=>$sub_elective_group->id));
													if($elective_sub_associations){
														foreach($elective_sub_associations as $elective_sub_association){
															$new_elective_sub_association = new EmployeeElectiveSubjects;
															$new_elective_sub_association->employee_id = $elective_sub_association->employee_id;
															$new_elective_sub_association->elective_id = $new_elective->id;
															$new_elective_sub_association->subject_id = $new_sub_elective_group->id;
															$new_elective_sub_association->save();
														}
													}
												}
											}
										}
									}
								}
							}
						}
						
												
					}
				}
				
				echo CJSON::encode(array(
                        'status'=>'success',						
						'batchid'=>$model->id
                        ));
                 exit;    
  								
            }
			else
			{
				echo CJSON::encode(array(
                        'status'=>'error',
						'errors'=>CActiveForm::validate($model),
                        ));
                 exit;    
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
		$model=$this->loadModel($id);
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if($settings!=NULL){	
			$date1=date($settings->displaydate,strtotime($model->start_date));
			$date2=date($settings->displaydate,strtotime($model->end_date));
		}
		$model->start_date=$date1;
		$model->end_date=$date2;
		
		if(isset($_POST['Batches'])){
			$model->attributes=$_POST['Batches'];			
			$model->start_date=date('Y-m-d', strtotime($model->start_date)); 
			$model->end_date=date('Y-m-d', strtotime($model->end_date)); 
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionManage() 
	{                                    
		 
		 $this->render('manage'); 
	}
	public function actionBatchstudents()
	{                                    
		 
		 $this->render('batchstudents'); 
	}
	public function actionStudentelectives() 
	{                                    
		 $this->render('studentelectives'); 
	}
	
	public function actionAcademicbatches()
	{
		if(isset($_POST['year']))
		{
			$data = Batches::model()->findAll('academic_yr_id=:x AND is_deleted=:y AND id<>:z AND is_active=1',array(':x'=>$_POST['year'],':y'=>0,':z'=>$_POST['id']));
		}
		
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")), true);
		$data=CHtml::listData($data,'id','coursename');
		foreach($data as $value=>$title)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($title),true);
		}
	}
	public function actionActionname()
	{
		$actions = PromoteOptions::model()->findAll(array('condition'=>'option_value <> "In Progress"'));
		$options = CHtml::listData($actions,'option_value','option_name');
		//echo CHtml::dropDownList('action', '', $options,array('prompt'=>Yii::t('app','Select'))); 
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','Select Action')), true);
		foreach($options as $value=>$title)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($title),true);
		}
	}
	
	public function actionPromote() 
	{
		$err_flag = 0;
		if(isset($_POST['promote'])){
			$err_msg = Yii::t('app','Please fix the following input errors:').'<br/>';
			if(isset($_POST['sid'])){
				if($_POST['action']==NULL){
					$err_flag 	= 1;
					$err_msg 	= $err_msg.'- '.Yii::t('app','Select an action').'<br/>'; 
				}
				else if($_POST['action']!=2){
					if($_POST['year']==NULL){
						$err_flag 	= 1;
						$err_msg 	= $err_msg.'- '.Yii::t('app','Select an academic year').'<br/>'; 
					}
					if($_POST['batch_id']==NULL or $_POST['batch_id']==0){
						$err_flag 	= 1;
						$err_msg 	= $err_msg.'- '.Yii::t('app','Select a batch').'<br/>';  
					}
				}
				
				//check for error
				if($err_flag == 0){
					foreach($_POST['sid'] as $sid){
						$Student				= Students::model()->findByAttributes(array('id'=>$sid));
						if($Student){
							$batch_student 			= BatchStudents::model()->findByAttributes(array('student_id'=>$Student->id,'batch_id'=>$Student->batch_id));
							if($batch_student){		// if already there is an entry in batch_studetns, change the status to 0
								$batch_student->status			= 0;
								$batch_student->result_status 	= $_POST['action'];
								$batch_student->save();
							}
													
							if($_POST['action'] == 2){	// make as an alumni
								$Student->saveAttributes(array('batch_id'=>0));
							}
							else{	// not an alumni, move the student to new bacth with status 1								
								$already_exists				= BatchStudents::model()->findByAttributes(array('student_id'=>$Student->id,'batch_id'=>$_POST['batch_id']));
								if($already_exists){
									$already_exists->result_status 	= 0;
									$already_exists->status 		= 1;
									if($already_exists->save()){									
										$Student->saveAttributes(array('batch_id'=>$already_exists->batch_id));	//set new batch_id in students table
									}
								}
								else{
									$new_batch 					= new BatchStudents;
									$new_batch->student_id 		= $Student->id;
									$new_batch->batch_id 		= $_POST['batch_id'];
									$new_batch->academic_yr_id 	= $_POST['year'];
									$new_batch->status 			= 1;
									if($new_batch->save()){									
										$Student->saveAttributes(array('batch_id'=>$new_batch->batch_id));	//set new batch_id in students table
									}
								}
							}
						}
					} 
					
					Yii::app()->user->setFlash('success',Yii::t('app','Action performed successfully'));	
					$this->redirect(array('promote', 'id' =>$_REQUEST['id']));	
				}
			}
			else{
				$err_flag = 1;	
				if($_POST['action']==NULL or $_POST['action']==0){					
					$err_msg = $err_msg.'- '.Yii::t('app','Select an action').'<br/>';					
				}
				elseif($_POST['action'] != 2){
					if($_POST['year']==NULL or $_POST['year']==0){
						$err_msg 	= $err_msg.'- '.Yii::t('app','Select an academic year').'<br/>';
					}
					if($_POST['batch_id']==NULL or $_POST['batch_id']==0){					
						$err_msg 	= $err_msg.'- '.Yii::t('app','Select a batch').'<br/>';					
					}	
				}
				$err_msg = $err_msg.'- '.Yii::t('app','Select at least one student').'<br/>';
			}
			if($err_flag==1){
				Yii::app()->user->setFlash('errorMessage',$err_msg);
			} 
		}
		$this->render('promote'); 
	}

	public function actionElective() 
	{
		if(isset($_POST['elective']))
		{
		
			if(isset($_POST['sid']))
        	 {
				
				  if(isset($_POST['elective_id']) and $_POST['elective_id']!=NULL)
					{ 
					  foreach($_POST['sid'] as $sid)
				 		{
							
							$Student=Students::model()->findByAttributes(array('id'=>$sid));
							
							$student_elective = StudentElectives::model()->findByAttributes(array('student_id'=>$sid,'elective_group_id'=>$_POST['elective_group_id']));
							if($_POST['elective_id']!=NULL and $_POST['elective_id']!=0)
							{
								
								// new record
								if($student_elective==NULL)
								{
									$electives  = new StudentElectives;
									$electives->student_id = $sid;
									$electives->batch_id = $_REQUEST['id'];
									$electives->elective_id = $_POST['elective_id'];
									$electives->elective_group_id = $_POST['elective_group_id'];
									$electives->status = 1;
									$electives->created = date('Y-m-d h:i:s');
									$electives->save();
									Yii::app()->user->setFlash('success',Yii::t('app','Elective added to the student'));
							
								}
								else
								{
								
									Yii::app()->user->setFlash('error',Yii::t('app','Elective is already assigned'));
									$this->redirect(array('elective', 'id' =>$_REQUEST['id']));
								}
							}
							else
							{
								Yii::app()->user->setFlash('error',Yii::t('app','Select  a subject'));
								$this->redirect(array('elective', 'id' =>$_REQUEST['id']));
							}
						}
						
					 
					 $this->redirect(array('elective', 'id' =>$_REQUEST['id']));
					 }
					 else
					 {
						 Yii::app()->user->setFlash('bid',Yii::t('app','Select a Subject!'));
             			$this->redirect(array('elective', 'id' =>$_REQUEST['id']));
			 		  }
				 
				 }
				 else
				 {
					 if(isset($_POST['elective_id']) and $_POST['elective_id']!=NULL)
					 {
						 Yii::app()->user->setFlash('sid',Yii::t('app','Select atleast one student!'));
					 }
					 else
					 {
			
						 Yii::app()->user->setFlash('sid', Yii::t('app','* Select atleast one student!'));
						 Yii::app()->user->setFlash('bid', Yii::t('app','* Select a subject!'));
					 }
             		$this->redirect(array('elective', 'id' =>$_REQUEST['id']));
			 
		 	}
		}
		 $this->render('elective'); 
	}
	public function actionSettings() 
	{                                    
		 
		 $this->render('settings'); 
	}
	
	public function actionDeactivate() 
	{  
	
	     $model=Batches::model()->findByPk($_REQUEST['id']);   
		 $model->saveAttributes(array('is_active'=>'0'));                               
		 
		 $this->redirect(array('courses/deactivatedbatches'));
	}
	public function actionActivate() 
	{  
	
	     $model=Batches::model()->findByPk($_REQUEST['id']);   
		 $model->saveAttributes(array('is_active'=>'1'));                               
		 
		 $this->redirect(array('batchstudents', 'id' =>$_REQUEST['id']));
	}
	public function actionRemoveelective() 
	{
		$student_elective	= StudentElectives::model()->findByPk($_REQUEST['eid']);
		if($student_elective){			
			$student_id			= $student_elective->student_id;
			$elective_group_id	= $student_elective->elective_group_id;
			$student_elective->delete();			
			//find subject with elective_group_id as $elective_group_id
			$subject		= Subjects::model()->findByAttributes(array('elective_group_id'=>$elective_group_id));
			if($subject){
				//get all exams related to this $subject->id
				$exams			= Exams::model()->findAllByAttributes(array('subject_id'=>$subject->id));
				if(count($exams)>0){					
					$exams		= CHtml::listData($exams, 'id', 'id');
					$criteria	= new CDbCriteria;
					$criteria->compare('student_id', $student_id);
					$criteria->addInCondition('exam_id', $exams);
					//get exam scores for this $exam->id and $student_id
					$exam_scores	= ExamScores::model()->findAll($criteria);
					if(count($exam_scores)>0){
						//setup a warning flash message if there is examscores added for this student
						Yii::app()->user->setFlash('warning', Yii::t("app", "You have to remove exam scores for this student if needed !"));
					}
				}
			}			
		}
		else{
			Yii::app()->user->setFlash('warning', Yii::t("app", "Such a relation not found !"));
		}
		$this->redirect(array('studentelectives', 'id' =>$_REQUEST['id']));
	}
	public function actionAddnew() {
        //$model=$this->loadModel(3);
			$model=new Batches;
        // Ajax Validation enabled
        $this->performAjaxValidation($model);
        // Flag to know if we will render the form or try to add 
        // new jon.
		$flag=true;
	   	if(isset($_POST['Submit']))
        {  										 
			$flag=false;
			$model->attributes=$_POST['Batches'];
			$model->start_date=date('Y-m-d', strtotime($model->start_date)); 
			$model->end_date=date('Y-m-d', strtotime($model->end_date)); 
			$model->academic_yr_id=Yii::app()->user->year;
			$model->save();			  
		}
		if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('create',array('model'=>$model,'val1'=>$_GET['val1']),false,true);
		}
   }
  public function actionAddupdate(){ 
		  $flag=true;
		  
		  $this->performAjaxValidation($model);
		  if(isset($_POST['Batches'])){   
				$flag=false;
				$model=Batches::model()->findByPk($_GET['val1']);				
				$model->attributes=$_POST['Batches'];
				$model->start_date=date('Y-m-d', strtotime($model->start_date)); 
				$model->end_date=date('Y-m-d', strtotime($model->end_date)); 
				if($model->save()){
					echo CJSON::encode(array('status'=>'success',));
					exit;
				}else{					
					echo CJSON::encode(array(
                        'status'=>'error',
						'errors'=>CActiveForm::validate($model),
                        ));
                 exit;    
			    }				
		 }
		if($flag){
				$model=Batches::model()->findByPk($_GET['val1']);
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
				if($settings!=NULL)
				{	
					$date1=date($settings->displaydate,strtotime($model->start_date));
					$date2=date($settings->displaydate,strtotime($model->end_date));
				}
			$model->start_date=$date1;
			$model->end_date=$date2;
			
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('update',array('model'=>$model,'val1'=>$_GET['val1'],'course_id'=>$_GET['course_id']),false,true);
		}
	}
   public function actionRemove(){
			$val = $_GET['val1'];
			$model=Batches::model()->findByPk($val);
			$model->is_active = 0;
			$model->is_deleted = 1;
			$model->employee_id = ' ';
			if($model->save()){
					// Student Deletion
					$students = Students::model()->findAllByAttributes(array('batch_id'=>$model->id));
					
					foreach($students as $student){
						
						//Making student user inactive
						if($student->uid!=NULL and $student->uid!=0){
							$student_user = User::model()->findByAttributes(array('id'=>$student->uid));
							if($student_user!=NULL){

								$student_user->saveAttributes(array('status'=>'0'));
							}
						}
						
						//Making parent user inactive
						$parent = Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
						if($parent->uid!=NULL and $parent->uid!=0){
							$parent_user = User::model()->findByAttributes(array('id'=>$parent->uid));
							if($parent_user!=NULL){

								$parent_user->saveAttributes(array('status'=>'0'));
							}
						}

						$student->saveAttributes(array('is_active'=>'0','is_deleted'=>'1')); // Student Deleted
						
						
					}
					
					// Subject Association Deletion
					$subjects = Subjects::model()->findAllByAttributes(array('batch_id'=>$model->id));
					foreach($subjects as $subject){
						EmployeesSubjects::model()->DeleteAllByAttributes(array('subject_id'=>$subject->id));
						 $subject->delete();
					}
					
					
					
					// Exam Group Deletion
					
					$examgroups = ExamGroups::model()->findAllByAttributes(array('batch_id'=>$model->id));
					
					foreach($examgroups as $examgroup){
						
						// Exams Deletion
						$exams = Exams::model()->findAllByAttributes(array('exam_group_id'=>$examgroup->id));
						foreach($exams as $exam){
							
							//Exam Score Deletion
							$examscores = ExamScores::model()->DeleteAllByAttributes(array('exam_id'=>$exam->id));
							$exam->delete(); //Exam Deleted
							
						}
						
						$examgroup->delete(); //Exam Group Deleted
						
					}
					
					//Fee Collection Deletion
					
					$collections = FinanceFeeCollections::model()->findAllByAttributes(array('batch_id'=>$model->id));
					foreach($collections as $collection){
						
						// Finance Fees Deletion
						$student_fees = FinanceFees::model()->DeleteAllByAttributes(array('fee_collection_id'=>$collection->id)); 
								
						$collection->delete(); // Fee Collection Deleted
						
					}
					
					//Fee Category Deletion
					
					$categories = FinanceFeeCategories::model()->findAllByAttributes(array('batch_id'=>$model->id));
					
					foreach($categories as $category){
						
						// Fee Particular Deletion	
						$particulars = FinanceFeeParticulars::model()->DeleteAllByAttributes(array('finance_fee_category_id'=>$category->id)); 
						
						
						$category->delete(); // Fee Category Deleted
					
					}
					
					//Timetable Entry Deletion
					$periods = TimetableEntries::model()->DeleteAllByAttributes(array('batch_id'=>$model->id)); 
					
					//Class Timings Deletion
					$class_timings = ClassTimings::model()->DeleteAllByAttributes(array('batch_id'=>$model->id)); 
					
					//Delete Weekdays
					$weekdays = Weekdays::model()->DeleteAllByAttributes(array('batch_id'=>$model->id));
				
			}			
			echo $val;
			
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
		$dataProvider=new CActiveDataProvider('Batches');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Batches('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Batches']))
			$model->attributes=$_GET['Batches'];

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
		$model=Batches::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='batches-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionWaitinglist()
	{
		
		$this->render('waitinglist');
	}
	
}
