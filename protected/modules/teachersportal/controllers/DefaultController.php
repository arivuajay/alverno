<?php

class DefaultController extends RController
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	public function actionProfile()
	{
		$this->render('profile');
	}
	public function actionAttendance()
	{
		$this->render('attendance/attendance');
	}
	public function actionEventlist()
	{
		$this->render('eventlist');
	}
	public function actionEmployeeAttendance()
	{
		$this->render('attendance/empattendance');
	}
	public function actionView()
	{

		$this->renderPartial('view',array('event_id'=>$_REQUEST['event_id']),false,true);
	}
	public function actionStudentAttendance()
	{
		$this->render('attendance/studattendance');
	}
	public function actionTimetable()
	{
		$this->render('timetable/timetable');
	}
	public function actionEmployeeTimetable()
	{
		$this->render('timetable/emptimetable');
	}
	public function actionStudentTimetable()
	{
		$this->render('timetable/studtimetable');
	}
	public function actionDayTimetable()
	{
		$this->render('timetable/daytimetable',array('model'=>$model));
	}
	public function actionExamination()
	{
		$this->render('examination/examination');
	}
	public function actionAllExam()
	{
		$this->render('examination/examination');
	}
	public function actionClassExam()
	{
		$this->render('examination/examination');
	}

	public function actionPdf()
     {
		$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$batch_name = $batch_name->name.' Class Timetable.pdf';

        # HTML2PDF has very similar syntax

        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		 $html2pdf = new HTML2PDF('L', 'A4', 'en');
		 $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('exportpdf', array(), true));
 		$html2pdf->Output($batch_name);
        ////////////////////////////////////////////////////////////////////////////////////
	}

	public function actionDayPdf()
     {
		//$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$batch_name = ' Class Day Timetable.pdf';

        # HTML2PDF has very similar syntax

        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		 $html2pdf = new HTML2PDF('L', 'A4', 'en');
		 $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('daytimetablepdf', array(), true));
 		$html2pdf->Output($batch_name);
        ////////////////////////////////////////////////////////////////////////////////////
	}
	/*---------PaySlip---------*/
	public function actionPayslip()
	{
		$model=Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$this->render('payslip',array(
			'model'=>$model,
		));
	}

	/* --------Attendance------- */
	public function actionAddnew()
	{

		$model=new StudentAttentance;
		$model1=new StudentLeaveTypes;
        // Ajax Validation enabled
        $this->performAjaxValidation($model);
        // Flag to know if we will render the form or try to add
        // new jon.
        $flag=true;
        if(isset($_POST['StudentAttentance']))
		{
			$flag=false;
			$model->attributes=$_POST['StudentAttentance'];
			$model->batch_id= $_POST['StudentAttentance']['batch_id'];
			$model->leave_type_id = $_POST['StudentAttentance']['leave_type_id'];
			if(!$model->validate()) {
				  echo CJSON::encode(array(
				'status'=>'error',
			   'errors'=>CActiveForm::validate($model)
			   ));
			 }


			if($model->save())
			{
				$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
				if($settings!=NULL)
				{
					$date=date($settings->displaydate,strtotime($model->date));
				}

				//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
				ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'8',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);

				echo CJSON::encode(array(
                        'status'=>'success',
                        ));
                 exit;
			}
         }
		if($flag)
		{
                        $timetable = TimetableEntries::model()->findByPk($_GET['timetable']);

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('attendance/create',array('model'=>$model,'model1'=>$model1,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id'],'batch_id'=>$_GET['batch_id'],'timetable' => $timetable),false,true);
		}
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-attentance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionEditLeave()
	{

		$model=StudentAttentance::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$model1=StudentLeaveTypes::model()->findByAttributes(array('id'=>$model->leave_type_id,'status'=>1));

		// Ajax Validation enabled
		//$this->performAjaxValidation($model);
		// Flag to know if we will render the form or try to add
		// new jon.
		$flag=true;
		if(isset($_POST['StudentAttentance']))
		{
			$reason =  $_POST['StudentAttentance']['reason'];
			$leave_type = $_POST['StudentAttentance']['leave_type_id'];
			$old_model = $model->attributes;
			$flag=false;
			$model->attributes=$_POST['StudentAttentance'];
			  $model->batch_id= $_POST['StudentAttentance']['batch_id'];
			  $model->leave_type_id = $_POST['StudentAttentance']['leave_type_id'];
			if($model->save())
			{

				$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
				$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
				if($settings!=NULL)
				{	$date=date($settings->displaydate,strtotime($model->date));

				}


				// Saving to activity feed
				$results = array_diff_assoc($_POST['StudentAttentance'],$old_model); // To get the fields that are modified.
				//print_r($old_model);echo '<br/><br/>';print_r($_POST['Students']);echo '<br/><br/>';print_r($results);echo '<br/><br/>'.count($results);echo '<br/><br/>';
				foreach($results as $key => $value)
				{
					if($key != 'date')
					{
						//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
						ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'9',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$model->getAttributeLabel($key),$date,$value);
					}

				}
				//END saving to activity feed
				echo CJSON::encode(array(
                        'status'=>'success',
                        ));
                 exit;

			}
			else
			{
				echo CJSON::encode(array(
                        'status'=>'error',
						'reason'=>$reason,
						'leave_type'=>$leave_type
                        ));
                 exit;
			}

		}
		// var_dump($model->geterrors());
		if($flag)
		{
                        $timetable = TimetableEntries::model()->findByPk($model->timetable_id);
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;


			$this->renderPartial('attendance/update',array('model'=>$model,'model1'=>$model1,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id'],'batch_id'=>$_GET['batch_id'],'timetable' => $timetable),false,true);
		}
	}

	public function actionDeleteLeave()
	{
		$flag=true;
		$model=StudentAttentance::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		if($model->delete())
		{
			$flag=false;
			$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
			if($settings!=NULL)
			{
				$date=date($settings->displaydate,strtotime($model->date));
			}

		//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
		ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'10',$model->student_id,ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name),$date,NULL,NULL);
		}

		 if($flag) {

				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('update',array('model'=>$model,'day'=>$_GET['day'],'month'=>$_GET['month'],'year'=>$_GET['year'],'emp_id'=>$_GET['emp_id']),false,true);

		}

	}

	/* --------Attendance End------- */

	/*--------- Scores ------------*/

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

				if($_REQUEST['allexam']==1){
					$url = 'default/allexam';
				}
				else{
					$url = 'default/classexam';
				}
				$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'r_flag'=>$_REQUEST['r_flag'],'exam_id'=>$_REQUEST['exam_id']));
		   }

		$this->render('examination',array(
			'model'=>$model,
		));

	}

	public function actionDeleteall()
	{

		$delete = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
		foreach($delete as $delete1)
		{
			$delete1->delete();
		}

		if($_REQUEST['allexam']==1){
					$url = 'default/allexam';
		}
		else{
			$url = 'default/classexam';
		}
			$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'r_flag'=>$_REQUEST['r_flag'],'exam_id'=>$_REQUEST['exam_id']));

	}

	public function actionDelete($id)
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
			$url = 'default/classexam';
		}
		$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'r_flag'=>$_REQUEST['r_flag'],'exam_id'=>$_REQUEST['exam_id']));

	}
	public function actionEmployeepicupload($id)
	{
		$model=Employees::model()->findByAttributes(array('id'=>$id));
		$file_name = $model->photo_file_name;
		$model->photo_file_name = $_FILES["file"]["name"];
		if(!$model->save()){
			echo 'Failed';
		}
		else{
			//Delete the already exist image
			$path = 'uploadedfiles/employee_profile_image/'.$model->id.'/'.$file_name;
			if(file_exists($path)){
				unlink($path);
			}
			//Save the profile pic to the folder
			if($model->photo_file_name!=NULL){
				if(!is_dir('uploadedfiles/')){
					mkdir('uploadedfiles/');
				}
				if(!is_dir('uploadedfiles/employee_profile_image/')){
					mkdir('uploadedfiles/employee_profile_image/');
				}
				if(!is_dir('uploadedfiles/employee_profile_image/'.$model->id)){
					mkdir('uploadedfiles/employee_profile_image/'.$model->id);
				}

				//compress the image
				$info = getimagesize($_FILES['file']['tmp_name']);
				if($info['mime'] == 'image/jpeg'){
					$image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
				}elseif($info['mime'] == 'image/gif'){
					$image = imagecreatefromgif($_FILES['file']['tmp_name']);
				}elseif($info['mime'] == 'image/png'){
					$image = imagecreatefrompng($_FILES['file']['tmp_name']);
				}

				$temp_file_name = $_FILES['file']['tmp_name'];
				$destination_file = 'uploadedfiles/employee_profile_image/'.$model->id.'/'.$_FILES["file"]["name"];
				imagejpeg($image, $destination_file, 30);
			}
			echo 'saved';
		}
		exit;
	}

	public function actionUpdate($id)
	{

		$model=ExamScores::model()->findByAttributes(array('id'=>$id));
		$old_model = $model->attributes; // For activity feed

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ExamScores']))
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

				if($_REQUEST['allexam']==1){
					$url = 'default/allexam';
				}
				else{
					$url = 'default/classexam';
				}

				$this->redirect(array($url,'bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id'],'r_flag'=>$_REQUEST['r_flag'],'exam_id'=>$_REQUEST['exam_id']));
			}
		}

		$this->render('examination/examination',array(
			'model'=>$model,
		));
	}

	/*------- Scores End -------------*/


	/*
	* For adding documents
	*/


	public function actionDocument()
	{
		//echo $_POST['EmployeeDocument']['sid'];exit;
		$model=new EmployeeDocument;
		$flag = 1;
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types
		$files_not_saved = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EmployeeDocument']))
		{
			$list = $_POST['EmployeeDocument'];
			$no_of_documents = count($list['title']); // Counting the number of files uploaded (No of rows in the form)
			for($i=0;$i<$no_of_documents;$i++) //Iterating the documents uploaded
			{
				$model=new EmployeeDocument;
				$model->employee_id = $_POST['EmployeeDocument']['employee_id'][$i];
				$model->title = $_POST['EmployeeDocument']['title'][$i];
				$extension = end(explode('.',$_FILES['EmployeeDocument']['name']['file'][$i])); // Get extension of the file
				$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
				$model->file_type = $_FILES['EmployeeDocument']['type']['file'][$i];
				$model->is_approved = 0;
				$model->uploaded_by = Yii::app()->user->Id;
				$file_size = $_FILES['EmployeeDocument']['size']['file'][$i];
				if($model->employee_id!='' and $model->title!='' and $model->file!='' and $model->file_type!='') // Checking if Document name and file is uploaded
				{
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{

						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/employee_document/')) // Creating employee_document directory
							{
								mkdir('uploadedfiles/employee_document/');
							}
							if(!is_dir('uploadedfiles/employee_document/'.$model->employee_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/employee_document/'.$model->employee_id);
							}
							$temp_file_loc = $_FILES['EmployeeDocument']['tmp_name']['file'][$i];
							$destination_file = 'uploadedfiles/employee_document/'.$model->employee_id.'/'.$model->file;
							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								if($model->save()) // Saving the model to database
								{
									$flag = 1;
								}
								else // If model not saved
								{
									$flag = 0;
									if(file_exists($destination_file))
									{
										unlink($destination_file);
									}
									$files_not_saved = $files_not_saved.', '.$model->file;
									Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File(s) ".$files_not_saved." was not saved. Please try again."));
									continue;
								}
							}
							else // If file not saved to the directory
							{
								$flag = 0;
								$files_not_saved = $files_not_saved.', '.$model->file;
								Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File(s) ".$files_not_saved." was not saved. Please try again."));
								continue;
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File size must not exceed 5MB!"));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage', Yii::t('app', "Only files with these extensions are allowed:")." jpg, png, pdf, doc, txt.");
					}
				}
				elseif($model->title=='' and $model->file_type!='') // If document name is empty
				{
					$flag = 0;
					Yii::app()->user->setFlash('errorMessage',Yii::t('app', "Document Name cannot be empty!"));
					//$this->redirect(array('create','model'=>$model,'id'=>$_REQUEST['id']));
				}
				elseif($model->title!='' and $model->file_type=='') // If file is not selected
				{

					$flag = 0;
					Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File is not selected!"));

				}
				elseif($model->employee_id=='' and $model->title=='' and $model->file=='' and $model->file_type=='')
				{
					$flag=1;
				}
			}
			if($flag == 1) // If no errors, go to next step of the student registration
			{
				$this->redirect(array('profile'));

			}
			else // If errors are present, redirect to the same page
			{
				$this->redirect(array('profile'));

			}
		} // END isset
/*
		$this->render('create',array(
			'model'=>$model,
		));*/
	}
	public function actionDeletes()
	{

		$model = EmployeeDocument::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$destination_file = 'uploadedfiles/employee_document/'.$model->employee_id.'/'.$model->file;
		if(file_exists($destination_file))
		{
			if(unlink($destination_file))
			{
				$model->delete();
				Yii::app()->user->setFlash('successMessage', Yii::t('app', "Document deleted successfully!"));
			}
		}
		$this->redirect(array('profile'));
	}

	/**
	* Download Files
	*/
	public function actionDownload()
	{
		$model = EmployeeDocument::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$file_path = 'uploadedfiles/employee_document/'.$model->employee_id.'/'.$model->file;
		$file_content = file_get_contents($file_path);
		$model->title = str_replace(' ','',$model->title);
		header("Content-Type: ".$model->file_type);
		header("Content-disposition: attachment; filename=".$model->file);
		header("Pragma: no-cache");
		echo $file_content;
		exit;
	}

	private function generateRandomString($length = 5)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function actionDocumentupdate()
	{

		$model= EmployeeDocument::model()->findByAttributes(array('id'=>$_REQUEST['document_id'])); //Here $_REQUEST['id'] is student ID and $_REQUEST['document_id'] is document ID
		$old_model = $model->attributes;
		//var_dump($old_model);exit;
		$flag = 1; // If 1, no errors. If 0, some error is present.
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['EmployeeDocument']))
		{
			$list = $_POST['EmployeeDocument'];
			$model->employee_id = $list['employee_id'];
			$model->title = $list['title'];

			if(($model->title != $old_model['file']) or ($_FILES['EmployeeDocument']['name']['file']!=NULL))
			{
				//echo 'dfsd';exit;
				$model->is_approved = 0;
			}
			if($model->title!=NULL and $model->employee_id!=NULL)
			{
				if($_FILES['EmployeeDocument']['name']['file']!=NULL)
				{

					$extension = end(explode('.',$_FILES['EmployeeDocument']['name']['file'])); // Get extension of the file
					$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
					$model->file_type = $_FILES['EmployeeDocument']['type']['file'];
					$file_size = $_FILES['EmployeeDocument']['size']['file'];
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{
						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/employee_document/')) // Creating employee_document directory
							{
								mkdir('uploadedfiles/employee_document/');
							}
							if(!is_dir('uploadedfiles/employee_document/'.$model->employee_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/employee_document/'.$model->employee_id);
							}
							$temp_file_loc = $_FILES['EmployeeDocument']['tmp_name']['file'];
							$destination_file = 'uploadedfiles/employee_document/'.$model->employee_id.'/'.$model->file;

							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								$flag = 1;

							}
							else // If file not saved to the directory
							{
								$flag = 0;
								Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File")." ".$model->file." ".Yii::t('app', "was not saved. Please try again."));
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage', Yii::t('app', "File size must not exceed 5MB!"));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage', Yii::t('app', "Only files with these extensions are allowed:")." jpg, png, pdf, doc, txt.");

					}
				}
				else // No files selected
				{
					if($old_model['file']!=NULL and $list['new_file_field']==1)
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage', Yii::t('app', "No file selected!"));
					}

				}
			}
			else // No title entered
			{
				$flag = 0;
				Yii::app()->user->setFlash('errorMessage', Yii::t('app', "Document Name cannot be empty!"));
			}


			if($flag == 1) // Valid data
			{
				if($model->save())
				{
					if($_FILES['EmployeeDocument']['name']['file']!=NULL)
					{
						$old_destination_file = 'uploadedfiles/employee_document/'.$model->employee_id.'/'.$old_model['file'];
						if(file_exists($old_destination_file))
						{
							unlink($old_destination_file);
						}
					}
					$this->redirect(array('profile'));
				}
				else
				{

					Yii::app()->user->setFlash('errorMessage', Yii::t('app', "Cannot update the document now. Try again later."));
					$this->redirect(array('documentupdate','id'=>$model->employee_id,'document_id'=>$_REQUEST['document_id']));
				}

			}
			else
			{
				$this->redirect(array('documentupdate','id'=>$model->employee_id,'document_id'=>$_REQUEST['document_id']));
				/*$this->render('update',array(
					'model'=>$model,'employee_id'=>$_REQUEST['id']
				));*/

			}
		}

		$this->render('documents/documentupdate',array(
			'model'=>$model,'employee_id'=>$_REQUEST['id']
		));

	}
	public function actionAchievements()
	{
		$this->render('achievements');
	}
	public function actionAchievementDownload()
	{
		$model=Achievements::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$file_path = 'uploadedfiles/employee_achievement_document/'.$model->user_id.'/'.$model->file;
		$file_content = file_get_contents($file_path);
		$model->doc_title = str_replace(' ','',$model->doc_title);
		header("Content-Type: ".$model->file_type);
		header("Content-disposition: attachment; filename=".$model->file);
		header("Pragma: no-cache");
		echo $file_content;
		exit;
	}

	public function actionDashboard()
	{
		$this->render('dashboard');
	}
}
