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
				'actions'=>array('index','view','pdf'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteall'),
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
			$list = $_POST['ExamScores'];
			$count = count($list['student_id']);
			
			for($i=0;$i<$count;$i++)
			{
				if($list['marks'][$i]!=NULL or $list['remarks'][$i]!=NULL)
				{
					$exam = Exams::model()->findByAttributes(array('id'=>$_REQUEST['examid']));
					$sub = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
					//var_dump($sub->attributes);
					// if elective not assigned
					if($sub->elective_group_id!=0)
					{
						
							$studentelctive = StudentElectives::model()->findByAttributes(array('student_id'=>$list['student_id'][$i]));
							if($studentelctive==NULL)
							{
								Yii::app()->user->setFlash('error',Yii::t('app','Elective is not assigned for the student'));
								$this->redirect(array('examScores/create','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']));
							}
							else
							{
								$model=new ExamScores;
								$model->exam_id = $list['exam_id'];
								$model->student_id = $list['student_id'][$i];
								$model->marks = $list['marks'][$i];
								$model->remarks = $list['remarks'][$i];
								//$exam_group =
								$exam_group = Exams::model()->findByPk($_REQUEST['examid']);
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
								
								//$model->grading_level_id = $_REQUEST['id'];
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
					
									$student_data = ExamScores::model()->findByAttributes(array('student_id'=>$model->student_id,'exam_id'=>$list['exam_id']));
									if($student_data==NULL)
									{
										if($model->save())
										{
											$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
											$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
									
											$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
											$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
											$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
											$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
											$goal_name = $student_name.Yii::t('app','for the exam').$exam;
							
							
										//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
											ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
									}
							    }
							}
					}
					else
					{
						$model=new ExamScores;
						
						$model->exam_id = $list['exam_id']; 
						$model->student_id = $list['student_id'][$i];
						$model->marks = $list['marks'][$i];
						$model->remarks = $list['remarks'][$i];
						//$model->grading_level_id = $_REQUEST['id'];
						$exam_group = Exams::model()->findByPk($_REQUEST['examid']);
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
					
						$student_data = ExamScores::model()->findByAttributes(array('student_id'=>$model->student_id,'exam_id'=>$list['exam_id']));
						if($student_data==NULL)
						{
							if($model->save())
							{
								$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
								$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
							
								$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
								$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
								$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
								$exam = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
								$goal_name = $student_name.Yii::t('app','for the exam').$exam;
							
							
							//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
								ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'20',$model->id,$goal_name,NULL,NULL,NULL); 
							}
						}
				   }
				}
			}
				$this->redirect(array('examScores/create','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']));
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
	public function actionUpdate($sid)
	{
		$model=$this->loadModel($sid);
		$old_model = $model->attributes; // For activity feed	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		#Remove decimals
		$model->marks=number_format($model->marks);

		if(isset($_POST['ExamScores']))
		{
			$model->attributes=$_POST['ExamScores'];
			$exam = Exams::model()->findByAttributes(array('id'=>$model->exam_id));
			if(($model->marks)< ($exam->minimum_marks)) 
			{
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
						$goal_name = $student_name.Yii::t('app','for the exam').$exam_name;
						
						if($key=='is_failed')
						{
							if($value == 1)
							{
								$value = Yii::t('app','Fail');
							}
							else
							{
								$value = Yii::t('app','Pass');
							}
							
							if($old_model[$key] == 1)
							{
								$old_model[$key] = Yii::t('app','Fail');
							}
							else
							{
								$old_model[$key] = Yii::t('app','Pass');
							}
						}
						
						
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
						ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'21',$model->id,$goal_name,$model->getAttributeLabel($key),$old_model[$key],$value); 
					}
				}
				//END saving to activity feed
				$this->redirect(array('examScores/create','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']));
			}
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
			$model = ExamScores::model()->findByAttributes(array('id'=>$id));
			
			$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
			$student_name = ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
			
			$exam = Exams::model()->findByAttributes(array('id'=>$model->exam_id));
			$subject_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
			$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
			$batch = Batches::model()->findByAttributes(array('id'=>$examgroup->batch_id));
			$exam_name = ucfirst($subject_name->name).' - '.ucfirst($examgroup->name).' ('.ucfirst($batch->name).'-'.ucfirst($batch->course123->course_name).')';
			$goal_name = $student_name.Yii::t('app','for the exam').$exam_name;
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
			
			//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
			ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'22',$model->id,$goal_name,NULL,NULL,NULL); 
			
			
			
			
			
			
			
			
			// we only allow deletion via POST request
			//$this->loadModel($id)->delete();

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
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
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
	
	public function actionDeleteall()
	{
		$delete = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['examid']));
		foreach($delete as $delete1)
		{
			$delete1->delete();
		}
		
		
		$this->redirect(array('create','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']));
	}
	
	 public function actionPdf()
    { 
	   //echo $_REQUEST['id'];
	  // echo $_REQUEST['examid']; exit;
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf = new HTML2PDF('L', 'A4', 'en');
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('printpdf',array('model'=>ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']))), true)); 
        $html2pdf->Output();
 
        ////////////////////////////////////////////////////////////////////////////////////
	}
	 
	// public function actionPdf()
	// {
//		 $college=Configurations::model()->findByPk(1);
//		 $logo=Logo::model()->findAll();
//         $data = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['examid']));
//
//	 Yii::import('application.extensions.fpdf.*');
//     require('fpdf.php');$pdf = new FPDF();
//	 
//	 
//     $pdf->AddPage();
//     $pdf->SetFont('Arial','B',15);
//	 $pdf->SetTextColor(0,0,0);
//	 $pdf->SetFillColor(250,100,100);
//	 //$pdf->Image(Yii::app()->baseUrl.'/uploadedfiles/',0,0,100,20);
//	 $pdf->Cell(180,5,$college->config_value,0,0,'C');
//	 $pdf->Cell(180,5,$logo->photo_file_name,0,0,'C');
//	
//	 $pdf->Ln();
//	 $college=Configurations::model()->findByPk(2);
//	 $pdf->SetFont('Arial','B',8);
//	 $pdf->Cell(180,5,$college->config_value,0,0,'C');
//	 $pdf->Ln();
//	 $pdf->SetFont('Arial','BU',15);
//	 $pdf->Cell(20,10,'Exam Scores',0,0,'C');
//	 $pdf->Ln();
//	 $pdf->Ln();
//	 $pdf->SetFont('Arial','BU',10);
//	 
//	 $w= array(40,40,60,40);
//
//	 $header = array('Name','Score','Remarks','Result');
//	  $pdf->SetTextColor(255,255,255);
//    //Header
//    for($i=0;$i<count($header);$i++)
//	{
//        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
//    
//	}
//    $pdf->Ln();
//	$pdf->SetTextColor(0,0,0);
//	$pdf->SetFont('Arial','',10);
//
//	 $fill=false;
//	 $i=40;
//	 foreach($data as $data1)
//	 {
//	 $pdf->Cell($i,6,Students::model()->findByAttributes(array('id'=>$data1->student_id))->first_name,1,0,'L',$fill);
//	 
//	 $pdf->Cell($i,6,$data1->marks,1,0,'C',$fill);
//	 $pdf->Cell($i+20,6,$data1->remarks,1,0,'C',$fill);
//	 if($data1->is_failed=='1')
//	 {
//		 $pdf->Cell($i,6,'Failed',1,0,'C',$fill);
//	 }
//	 else
//	 {
//		 $pdf->Cell($i,6,'Passed',1,0,'C',$fill);
//	 }
//	 $pdf->Ln();
//	 }
//	 
//     $pdf->Output();
//	 Yii::app()->end();
//	 }
	 
	
}
