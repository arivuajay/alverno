<?php

class ExamScoresController extends RController
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
				'actions'=>array('index','view'),
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
		$model=new ExamScores;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ExamScores']))
		{
			$model->attributes=$_POST['ExamScores'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
//Manage exam score
	public function actionClassexamscore()
	{
		$this->render('classexamscore',array('batch_id'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
	}
	public function actionAllexamscore()
	{
		$model=new ExamScores;
		if(isset($_POST['ExamScores']))
		{
			$list = $_POST['ExamScores'];
			$count = count($list['student_id']);
			for($i=0;$i<$count;$i++)
			{
				if($list['marks'][$i]!=NULL or $list['remarks'][$i]!=NULL)
				{
					$exam=Exams::model()->findByAttributes(array('id'=>$_REQUEST['exam_id']));
					$sub = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
					if($sub->elective_group_id!=0)
					{
							$studentelctive = StudentElectives::model()->findAllByAttributes(array('student_id'=>$list['student_id'][$i]));
							if($studentelctive==NULL)
							{
								Yii::app()->user->setFlash('error','Elective is not assigned for the student');
								$this->redirect(array('examScores/allexamscore','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['exam_id']));
							}
							else
							{
								$model=new ExamScores;
						
								$model->exam_id = $_REQUEST['exam_id']; 
								$model->student_id = $list['student_id'][$i];
								$model->marks = $list['marks'][$i];
								$model->remarks = $list['remarks'][$i];
								$exam_group = Exams::model()->findByPk($_REQUEST['exam_id']);
								$is_grade = ExamGroups::model()->findByPk($exam_group->exam_group_id);
								if($is_grade->exam_type=="Marks")
								{
									$model->grading_level_id = NULL;
								}
								elseif($is_grade->exam_type=="Grades" or $is_grade->exam_type=="Marks And Grades")
								{
									$grade_values = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id']));
									foreach($grade_values as $grade_value)
									{
										if($list['marks'][$i]>=$grade_value->min_score)
										{
											$model->grading_level_id = $grade_value->id;
										}
									}
								}
								//$model->grading_level_id = $list['grading_level_id'];
					
								if(($list['marks'][$i])< ($exam->minimum_marks)) 
								{
						
									$model->is_failed = 1;
								}
								else 
								{
									$model->is_failed = '';
								}
									$model->created_at = $list['created_at'];
									$model->updated_at = $list['updated_at'];
									//$model->save();
									if($model->save())
										{
											
											$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
											$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
						
											$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
											$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
											$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
											$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
											$goal_name = $student_name.' for the exam '.$exam;
						
						
												//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
											ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
										}
							}
					}
					else
					{
					 	$model=new ExamScores;
						$model->exam_id = $_REQUEST['exam_id']; 
						$model->student_id = $list['student_id'][$i];
						$model->marks = $list['marks'][$i];
						$model->remarks = $list['remarks'][$i];
						$exam_group = Exams::model()->findByPk($_REQUEST['exam_id']);
						$is_grade = ExamGroups::model()->findByPk($exam_group->exam_group_id);
						//$model->grading_level_id = $list['grading_level_id'];
						if($is_grade->exam_type=="Marks")
						{
							$model->grading_level_id = NULL;
						}
						elseif($is_grade->exam_type=="Grades" or $is_grade->exam_type=="Marks And Grades")
						{
							$grade_values = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id']));
							foreach($grade_values as $grade_value)
							{
								if($list['marks'][$i]>=$grade_value->min_score)
								{
									$model->grading_level_id = $grade_value->id;
								}
							}
						}
					
						if(($list['marks'][$i])< ($exam->minimum_marks)) 
						{
						
							$model->is_failed = 1;
						}
						else 
						{
							$model->is_failed = '';
						}
						$model->created_at = $list['created_at'];
						$model->updated_at = $list['updated_at'];
						//$model->save();
						if($model->save())
						{
							
							$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
							$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
						
							$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
							$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
							$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
							$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
							$goal_name = $student_name.' for the exam '.$exam;
						
						
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
							ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
						}
					}
				}
			}	
				$this->redirect(array('examScores/allexamscore','bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
		   }
		$this->render('allexamscore',array('bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id'],'model'=>$model));
	}
//Add exam score	
	public function actionAddscores()
	{		
		$model=new ExamScores;

		if(isset($_POST['ExamScores']))
		{
			
			$list = $_POST['ExamScores'];
			$count = count($list['student_id']);
			
			for($i=0;$i<$count;$i++)
			{
				if($list['marks'][$i]!=NULL or $list['remarks'][$i]!=NULL)
				{
					$exam=Exams::model()->findByAttributes(array('id'=>$list['exam_id']));
					$sub = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
					// if elective subject
					if($sub->elective_group_id!=0)
					{
						$studentelctive = StudentElectives::model()->findAllByAttributes(array('student_id'=>$list['student_id'][$i]));
						// elective is not assigned
					
					if($studentelctive==NULL)
							{
								Yii::app()->user->setFlash('error', Yii::t('app', 'Elective is not assigned for the student'));
								$this->redirect(array('/teachersportal/examScores/classexamscore','bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
							}
							else
							{
								$model=new ExamScores;
						
								$model->exam_id = $list['exam_id']; 
								$model->student_id = $list['student_id'][$i];
								$model->marks = $list['marks'][$i];
								$model->remarks = $list['remarks'][$i];
								$model->grading_level_id = $list['grading_level_id'];
								if(($list['marks'][$i])< ($exam->minimum_marks)) 
								{
									$model->is_failed = 1;
								}
								else 
								{
									$model->is_failed = '';
								}
								$model->created_at = $list['created_at'];
								$model->updated_at = $list['updated_at'];
								//$model->save();
								if($model->save())
								{
									$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
									$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
									$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
									if($subject_name!=NULL)
									{
										$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
										$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
										$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
										$goal_name = $student_name.' for the exam '.$exam;
									}
									else
									{
										$goal_name = $student_name;
									}
						
						
						
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
						ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
					}
							}
					
					}
					// not elective
					else
					{
						$model=new ExamScores;
						
								$model->exam_id = $list['exam_id']; 
								$model->student_id = $list['student_id'][$i];
								$model->marks = $list['marks'][$i];
								$model->remarks = $list['remarks'][$i];
								$model->grading_level_id = $list['grading_level_id'];
								if(($list['marks'][$i])< ($exam->minimum_marks)) 
								{
									$model->is_failed = 1;
								}
								else 
								{
									$model->is_failed = '';
								}
								$model->created_at = $list['created_at'];
								$model->updated_at = $list['updated_at'];
								//$model->save();
								if($model->save())
								{
									$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
									$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
									$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
									if($subject_name!=NULL)
									{
										$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
										$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
										$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
										$goal_name = $student_name.' '.Yii::t('app', 'for the exam').' '.$exam;
									}
									else
									{
										$goal_name = $student_name;
									}
						
						
						
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
						ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
					}
					}
					
				}
			}
				
				if($_REQUEST['allexam']==1){
					$url = '/teachersportal/examScores/allexamscore';
				}
				else{
					$url = '/teachersportal/examScores/classexamscore';
				}
				$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
		   }
			
		$this->render('classexamscore',array(
			'model'=>$model,
		));
	
	}
//Exam score update	
	public function actionClassexamupdate($id)
	{
		
		$model=ExamScores::model()->findByAttributes(array('id'=>$id));
		$old_model = $model->attributes; // For activity feed	
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['ExamScores']) and $_POST['ExamScores']!=NULL)
		{
			
			$model->attributes=$_POST['ExamScores'];
			$exam=Exams::model()->findByAttributes(array('id'=>$_REQUEST['exam_id']));
			if($model->marks < $exam->minimum_marks){
				$model->is_failed = 1;
			}
			else 
			{
					$model->is_failed = '';
			}
			if($model->save())
			{
				// Saving to activity feed
				$results = array_diff_assoc($model->attributes,$old_model); // To get the fields that are modified. 
				foreach($results as $key => $value)
				{
					if($key!='updated_at')
					{
						$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
						$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
						
						$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
						$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
						$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
						$exam_name = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
						$goal_name = $student_name.' for the exam '.$exam_name;
						
						if($key=='is_failed')
						{
							if($value == 1)
							{
								$value = 'Fail';
							}
							else
							{
								$value = 'Pass';
							}
							
							if($old_model[$key] == 1)
							{
								$old_model[$key] = 'Fail';
							}
							else
							{
								$old_model[$key] = 'Pass';
							}
						}
						
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
						ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'21',$model->id,$goal_name,$model->getAttributeLabel($key),$old_model[$key],$value); 
					}
				}
				//END saving to activity feed
				
				//if($_REQUEST['allexam']==1){
					$url = '/teachersportal/examScores/allexamscore';
				//}
				//else{
					//$url = '/teachersportal/examScores/classexamscore';
				//}
				
				$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
			}
		}
		
		$this->render('classexamupdate',array(
			'model'=>$model,'batch_id'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']
		));
	}
	
//Delete exam score
	public function actionDeleteexamscore($id)
	{
		$delete = ExamScores::model()->findByAttributes(array('id'=>$id));
		
		
		//$model = ExamScores::model()->findByAttributes(array('id'=>$id));
			
		$student = Students::model()->findByAttributes(array('id'=>$delete->student_id));
		$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
		
		$exam = Exams::model()->findByAttributes(array('id'=>$delete->exam_id));
		$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
		$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
		$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
		$exam_name = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
		$goal_name = $student_name.' for the exam '.$exam_name;
		
		$delete->delete();
		
		//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
		ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'22',$delete->id,$goal_name,NULL,NULL,NULL); 
		
		if($_REQUEST['allexam']==1){
			$url = 'default/allexam';
		}
		else{
			$url = '/teachersportal/examScores/classexamscore';
		}
		$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'exam_id'=>$_REQUEST['exam_id']));
		
	} 	
//Delete all exam scores	
	public function actionDeleteall()
	{
		
		$delete = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
		foreach($delete as $delete1)
		{
			$delete1->delete();
		}
		
		if($_REQUEST['allexam']==1)
		{
			$url = '/teachersportal/examScores/allexamscore';
		}
		else
		{
			$url = '/teachersportal/examScores/classexamscore';
		}
			$this->redirect(array($url,'bid'=>$_REQUEST['id'],'exam_group_id'=>$_REQUEST['exam_group_id'],'r_flag'=>$_REQUEST['r_flag'],'exam_id'=>$_REQUEST['exam_id']));
		
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

		if(isset($_POST['ExamScores']))
		{
			
			$model->attributes=$_POST['ExamScores'];
			if($model->save())
				$this->redirect(array('allexamscore','exam_id'=>$_REQUEST['examid'],'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id']));
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
		$dataProvider=new CActiveDataProvider('ExamScores');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ExamScores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExamScores']))
			$model->attributes=$_GET['ExamScores'];

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
		$model=ExamScores::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='exam-scores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
