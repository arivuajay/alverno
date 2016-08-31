<?php

class SubjectAttendanceController extends Controller
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
			//'rights', // perform access control for CRUD operations
		);
	}

	public function actionBatchwise($id){
		$batch = Batches::model()->findByAttributes(array('id'=>$id));
		$this->render('batchwise',array(
			'batch'=>$batch,
		));
	}
	
	public function actionIndividual(){
		
		$model = Students::model()->findByPk($_REQUEST['id']);
		$this->render('individual',array(
			'model'=>$model,
		));
	}
	public function actionIndividualPdf(){
		
		$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$student = $student->first_name.' '.$student->last_name.' Attendance.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf = new HTML2PDF('L', 'A4', 'en');
        $html2pdf->WriteHTML($this->renderPartial('individual_pdf', array(), true));
        $html2pdf->Output($student);
		
	}
	public function actionCourseAttendance($id){
		$batch = Batches::model()->findByAttributes(array('id'=>$id));
		$this->render('courseattendance',array(
			'batch'=>$batch,
		));
	}
	public function actionCourseAttendancePdf($id){
		
		$batch_name = Batches::model()->findByAttributes(array('id'=>$id));
		$batch_name = $batch_name->name.' Student Attendance.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
        $html2pdf->WriteHTML($this->renderPartial('courseattendance_pdf', array(), true));
        $html2pdf->Output($batch_name);
	}
	public function actionSpAttendance(){
		$this->layout='application.views.portallayouts.studentmain';
		$student = Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$this->render('spattendance',array(
			'student'=>$student,
		));
	}
	
	//list all batches of teacher..........
	public function actionTpBatches(){
		
		$this->layout='application.views.portallayouts.teachers';
		$this->render('tpBatches');
		
	}
	public function actionTpAttendance($id){
		$this->layout='application.views.portallayouts.teachers';
		$batch = Batches::model()->findByAttributes(array('id'=>$id));
		$this->render('tpattendance',array(
			'batch'=>$batch,
		));
		
	}
	
	//mark attendance.............
	public function actionAddnew() {
        $model=new StudentSubjectAttendance;
        // Ajax Validation enabled
        //$this->performAjaxValidation($model);
        if(isset($_POST['StudentSubjectAttendance']) and isset($_POST['StudentSubjectAttendance']['reason'])){      
		 	$model->attributes=$_POST['StudentSubjectAttendance'];
			
			
			if($model->validate()){
				if($model->save()){
					
					$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
					if($settings!=NULL)
						$date=date($settings->displaydate,strtotime($model->date));			
					
					//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
					ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'8',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);
					 echo CJSON::encode(array('status'=>'success'));
					 exit;      
				}
				else{
					echo CJSON::encode(array('status'=>'error'));
					exit;    
				}
            	 
     		}else{
				echo CJSON::encode(array('status'=>'error','errors'=>CActiveForm::validate($model)));
				exit;
			}
	    }
		
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$this->renderPartial('create',array('model'=>$model,'date'=>$_GET['date'],'student_id'=>$_GET['std_id'],'subject_id'=>$_GET['subject_id'],'timing_id'=>$_GET['timing_id']),false,true);
		
   }
   
   //Edit attendance.............
	public function actionEditLeave() {
		
        $model = StudentSubjectAttendance::model()->findByAttributes(array('date'=>$_GET['date'],'student_id'=>$_GET['std_id'],'subject_id'=>$_GET['subject_id'],'timing_id'=>$_GET['timing_id']));
		
        // Ajax Validation enabled
        //$this->performAjaxValidation($model);
        if(isset($_POST['StudentSubjectAttendance']) and isset($_POST['StudentSubjectAttendance']['reason'])){
			  
			$post = $_POST['StudentSubjectAttendance']; 
			$model = StudentSubjectAttendance::model()->findByAttributes(array('date'=>$post['date'],'student_id'=>$post['student_id'],'subject_id'=>$post['subject_id'],'timing_id'=>$post['timing_id']));
			
			$old_model = $model->attributes;   
			$model->attributes = $post;
			
			
			if($model->validate()){
				if($model->save()){
					
					$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
					if($settings!=NULL)
						$date=date($settings->displaydate,strtotime($model->date));			
					
					// Saving to activity feed
					$results = array_diff_assoc($post,$old_model); // To get the fields that are modified.
					foreach($results as $key => $value)
					{
						if($key != 'date')
							ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'9',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$model->getAttributeLabel($key),$date,$value);
						
					}	
					//END saving to activity feed
					
					 echo CJSON::encode(array('status'=>'success'));
					 exit;      
				}
				else{
					echo CJSON::encode(array('status'=>'error'));
					exit;    
				}
            	 
     		}else{
				echo CJSON::encode(array('status'=>'error','errors'=>CActiveForm::validate($model)));
				exit;
			}
	    }
		
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$this->renderPartial('update',array('model'=>$model,'date'=>$_GET['date'],'student_id'=>$_GET['std_id'],'subject_id'=>$_GET['subject_id'],'timing_id'=>$_GET['timing_id']),false,true);
		
   
	}
	
	/* Delete the marked leave */
	public function actionDeleteLeave()
	{
		$post = $_POST['StudentSubjectAttendance']; 
		$model = StudentSubjectAttendance::model()->findByAttributes(array('date'=>$post['date'],'student_id'=>$post['student_id'],'subject_id'=>$post['subject_id'],'timing_id'=>$post['timing_id']));
		
		$attendance=StudentSubjectAttendance::model()->DeleteAllByAttributes(array('date'=>$post['date'],'student_id'=>$post['student_id'],'subject_id'=>$post['subject_id'],'timing_id'=>$post['timing_id']));
		
		$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		if($settings!=NULL)
		{	
			$date=date($settings->displaydate,strtotime($model->date));	
		}
		
		//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
		ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'10',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);
		exit;
	}
	
}
