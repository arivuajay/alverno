<?php

class DefaultController extends RController
{
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('is_deleted',0);
		$total = Employees::model()->count($criteria);
		$criteria->order = 'id DESC';
		$criteria->limit = '5';
		$posts = Employees::model()->findAll($criteria);
		
		$criteria1 = new CDbCriteria;
		$criteria1->compare('is_deleted',0);
		$total1 = Students::model()->count($criteria);
		$criteria1->order = 'id DESC';
		$criteria1->limit = '5';
		$posts1 = Students::model()->findAll($criteria);
		
		$this->render('index',array(
			'total'=>$total,'list'=>$posts,
			'total1'=>$total1,'list1'=>$posts1
		));
		
	}
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	public function actionAdvancedreport()
	{ 
		$model=new Students;
		$criteria = new CDbCriteria;
		$criteria->compare('is_deleted',0);  // normal DB field
		$flag=0;
		
		if(isset($_REQUEST['search']))
		{   		    
			if(isset($_REQUEST['guard']) and $_REQUEST['guard']!=NULL)
			{
				$flag=1;
			}
			else
			{
				$flag=0;
			}
			
				
			if(isset($_REQUEST['studentname']) and $_REQUEST['studentname']!=NULL)
			{
			
				//$criteria->condition='(first_name LIKE :match or last_name LIKE :match or middle_name LIKE :match)';
				//$criteria->params = array(':match' => $_POST['studentname'].'%');
				if((substr_count( $_REQUEST['studentname'],' '))==0)
				{ 	
					$criteria->condition=$criteria->condition.' and (first_name LIKE :name or last_name LIKE :name or middle_name LIKE :name)';
					$criteria->params[':name'] = $_REQUEST['studentname'].'%';
				}
				else if((substr_count( $_REQUEST['studentname'],' '))<=1)
				{
					$name=explode(" ",$_REQUEST['studentname']);
					$criteria->condition=$criteria->condition.' and (first_name LIKE :name or last_name LIKE :name or middle_name LIKE :name)';
					$criteria->params[':name'] = $name[0].'%';
					$criteria->condition=$criteria->condition.' and (first_name LIKE :name1 or last_name LIKE :name1 or middle_name LIKE :name1)';
					$criteria->params[':name1'] = $name[1].'%';
				}
			}
			if(isset($_REQUEST['admissionnumber']) and $_REQUEST['admissionnumber']!=NULL)
			{
				
				$criteria->condition=$criteria->condition.' and  admission_no LIKE :admission';
			   $criteria->params[':admission'] = $_REQUEST['admissionnumber'];
			}
			
			if(isset($_REQUEST['email']) and $_REQUEST['email']!=NULL)
			{
				
				$criteria->condition=$criteria->condition.' and  email LIKE :email';
			   $criteria->params[':email'] = $_REQUEST['email'].'%';
			}
		
			if(isset($_REQUEST['Students']['gender']) and $_REQUEST['Students']['gender']!=NULL)
			{
				
				$criteria->condition=$criteria->condition.' and gender LIKE :gender';
			   $criteria->params[':gender'] = $_REQUEST['Students']['gender'].'%';
			}
			if(isset($_REQUEST['Students']['blood_group']) and $_REQUEST['Students']['blood_group']!=NULL)
			{
	
				$criteria->condition=$criteria->condition.' and blood_group = :blood_group';
				 $criteria->params[':blood_group'] = $_REQUEST['Students']['blood_group'];
			}
					
			if(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']!=NULL)
			{
				 
				  $model->dobrange = $_REQUEST['Students']['dobrange'] ;
				  if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
				  {
					  if($_REQUEST['Students']['dobrange']=='2')
					  {  
						  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
						  $criteria->condition=$criteria->condition.' and  date_of_birth = :date_of_birth';
						  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
					  }
					  if($_REQUEST['Students']['dobrange']=='1')
					  {  
					  
						  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
						  $criteria->condition=$criteria->condition.' and date_of_birth < :date_of_birth';
						  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
					  }
					  if($_REQUEST['Students']['dobrange']=='3')
					  {  
						  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
						  $criteria->condition=$criteria->condition.' and date_of_birth > :date_of_birth';
						  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
					  }
					  
				  }
			}
			elseif(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']==NULL)
			{
				  if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
				  {
					  $model->date_of_birth = $_REQUEST['Students']['date_of_birth'];
					  $criteria->condition=$criteria->condition.' and date_of_birth = :date_of_birth';
					  $criteria->params[':date_of_birth'] = date('Y-m-d',strtotime($_REQUEST['Students']['date_of_birth']));
				  }
			}
			if(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']!=NULL)
			{
				  
				  $model->admissionrange = $_REQUEST['Students']['admissionrange'] ;
				  if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
				  {
					  if($_REQUEST['Students']['admissionrange']=='2')
					  {  
						  $model->admission_date = $_REQUEST['Students']['admission_date'];
						  $criteria->condition=$criteria->condition.' and admission_date = :admission_date';
						  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
					  }
					  if($_REQUEST['Students']['admissionrange']=='1')
					  {  
					  
						  $model->admission_date = $_REQUEST['Students']['admission_date'];
						  $criteria->condition=$criteria->condition.' and  admission_date < :admission_date';
						  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
					  }
					  if($_REQUEST['Students']['admissionrange']=='3')
					  {  
						  $model->admission_date = $_REQUEST['Students']['admission_date'];
						  $criteria->condition=$criteria->condition.' and admission_date > :admission_date';
						  $criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
					  }
					  
				  }
			}
			elseif(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']==NULL)
			{
				if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
				{
					$model->admission_date = $_REQUEST['Students']['admission_date'];
					$criteria->condition=$criteria->condition.' and admission_date = :admission_date';
					$criteria->params[':admission_date'] = date('Y-m-d',strtotime($_REQUEST['Students']['admission_date']));
				}
			  
			}
			
			$criteria->order = 'first_name ASC';
			$total = Students::model()->count($criteria);
			$pages = new CPagination($total);
			$pages->setPageSize(Yii::app()->params['listPerPage']);
			$pages->applyLimit($criteria);  // the trick is here!
			$posts = Students::model()->findAll($criteria);
			$this->render('advancedreport',array('model'=>$model,'flag'=>$flag,
				'list'=>$posts,
				'pages' => $pages,
				'item_count'=>$total,
				'page_size'=>Yii::app()->params['listPerPage'],)) ;
		
				
		}
		else
		{  
			$this->render('advancedreport',array('model'=>$model,'flag'=>$flag));
		}
			
	}
	public function loadModel($id)
	{
		$model=ExamGroups::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}
	public function actionAssessment()
	{
		$model_1=new ExamGroups;
		$criteria = new CDbCriteria;
		if(isset($_POST['search']) && $_REQUEST['yid']!=NULL && $_REQUEST['batch']!=NULL  )
		{
			
			if(isset($_POST['ExamGroups']['id']) &&  $_POST['ExamGroups']['id']!=NULL)
			{
					$criteria->condition='exam_group_id LIKE :match';
					$criteria->params = array(':match' => $_POST['ExamGroups']['id'].'%');
			}
			
				$criteria->order = 'id ASC';
		
				$total = Exams::model()->count($criteria);
				$pages = new CPagination($total);
       			$pages->setPageSize(Yii::app()->params['listPerPage']);
       		 	$pages->applyLimit($criteria);  // the trick is here!
				$posts = Exams::model()->findAll($criteria);
				$this->render('assessment',array('model_1'=>$model_1,
					'list'=>$posts, 'batch_id'=>$_POST['batch'],
					'group_id'=>$_POST['ExamGroups']['id'],'year_id'=>$_POST['yid'])) ;
		
		}
		else
		{
			$this->render('assessment',array('model_1'=>$model_1));
		}
	}
	public function actionBatch()
	{
		
		if(isset($_POST['batch']))
		{
			
			$data=ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$_POST['batch']));
		}
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','Select Examination')), true);
		$data=CHtml::listData($data,'id','name');
		  foreach($data as $value=>$title)
		  {
			  echo CHtml::tag('option',
						 array('value'=>$value),CHtml::encode($title),true);
		  }
	}
	
	public function actionBatchlist()
	{		
	
	    	
		$data=Batches::model()->findAll('academic_yr_id=:id AND is_active=:x AND is_deleted=:y',array(':id'=>(int) $_POST['yid'],':x'=>1,':y'=>0));
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")), true);
		$data=CHtml::listData($data,'id','name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
	}
	
	public function actionBatchname()
	{			
		$data=Batches::model()->findAll('course_id=:id AND is_active=:x AND is_deleted=:y',array(':id'=>(int) $_POST['cid'],':x'=>1,':y'=>0));
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")), true);
		$data=CHtml::listData($data,'id','name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
	}
	public function actionStudentexam()
	{
		
		$model=new Students;
		$flag=0;
			if(isset($_POST['search']))
			{
				$criteria = new CDbCriteria;
				if(isset($_POST['student_id']) and $_POST['student_id']!=NULL)
				{
					$criteria->condition='student_id LIKE :match';
					$criteria->params[':match'] = $_POST['student_id'];
					$id=$_POST['student_id'];	
				}
				else
				{
					$flag = 1;
					//$this->redirect(array('studentexam','flag'=>$flag));
					$this->render('studentexam',array('flag'=>$flag));
					exit;
				}
			
			$total = ExamScores::model()->count($criteria);
			$pages = new CPagination($total);
      	    $pages->setPageSize(Yii::app()->params['listPerPage']);
			$pages->applyLimit($criteria);  // the trick is here!
			$posts = ExamScores::model()->findAll($criteria);
			
			
				$flag = 1;
				$this->render('studentexam',array('model'=>$model,'student'=>$id,
				'list'=>$posts,
				'pages' => $pages,
				'item_count'=>$total,
				'page_size'=>Yii::app()->params['listPerPage'],
				));
			exit;
		}
		
			$this->render('studentexam',array('model'=>$model));
		
	}
	public function actionEmployeeattendance()
	{
		if(isset($_POST['dep_id']))
		{
			$this->render('employeeattendance',array('dep_id'=>$_POST['dep_id']));
		}
		else
		{
			$this->render('employeeattendance');
		}
		
	}
	public function actionStudentattendance()
	{
		if(isset($_POST['batch_id']))
		{
			$this->render('studentattendance',array('batch_id'=>$_POST['batch_id']));
		}
		else
		{
			$this->render('studentattendance');
		}
		
	}
	 public function actionAssessmentpdf()
    {
        $pdf_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = $pdf_name->name.Yii::t('app','Assessment').' Report.pdf';
        # HTML2PDF has very similar syntax
		
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf = new HTML2PDF('L', 'A4', 'en');
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('assesspdf', array('model'=>$this->loadModel($_REQUEST['examid'])), true));
        $html2pdf->Output($pdf_name);
 
        
	}
	
	public function actionStudentexampdf()
    {
        $student_name = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$exam_name = ExamGroups::model()->findByAttributes(array('id'=>$_REQUEST['exam_group_id']));
		$pdf_name = ucfirst($student_name->first_name).' '.ucfirst($student_name->last_name).' '.ucfirst($exam_name->name).Yii::t('app',' Assessment').' Report.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('studentexampdf', array(), true));
        $html2pdf->Output($pdf_name);
 
       
	}
	
	public function actionEmpoverallpdf()
    {
      	$department_name = EmployeeDepartments::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($department_name->name).Yii::t('app',' Employees Overall Attendance').' Report.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('empoverallpdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionEmpyearlypdf()
    {
      	$department_name = EmployeeDepartments::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($department_name->name).Yii::t('app',' Employees Yearly Attendance Report ').$_REQUEST['year'].'.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('empyearlypdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionEmpmonthlypdf()
    {
      	$department_name = EmployeeDepartments::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($department_name->name).Yii::t('app',' Employees Monthly Attendance Report ').$_REQUEST['month'].'.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('empmonthlypdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionEmpindividualpdf()
    {
		$employee_name = Employees::model()->findByAttributes(array('id'=>$_REQUEST['employee']));
		$pdf_name = ucfirst($employee_name->first_name).' '.ucfirst($employee_name->last_name).Yii::t('app',' Teacher Attendance').' Report.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('empindividualpdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionStudentoverallpdf()
    {
      	$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($batch_name->name).Yii::t('app',' Students Overall Attendance').'Report.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('studentoverallpdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionStudentyearlypdf()
    {
      	$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($batch_name->name).Yii::t('app',' Students Yearly Attendance Report ').$_REQUEST['year'].'.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('studentyearlypdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	public function actionPercentpdf()
    {
		$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
		if(Yii::app()->user->year)
		{
		$year = Yii::app()->user->year;
		//echo Yii::app()->user->year;
		}
		else
		{
		$year = $current_academic_yr->config_value;
		} 
		if($_GET['batch_id'] == 'All')
		{	
		$criteria = new CDbCriteria;
		$criteria->condition = "is_deleted=:x AND academic_yr_id=:y";
		$criteria->params = array(':x'=>'0',':y'=>$year);
		
		$batches = Batches::model()->findAll($criteria);
		//$batches = Batches::model()->findAll("is_deleted=:x AND academic_yr_id=:y", array(':x'=>'0',':y'=>$year));
		
		}
		else{	
		$batches = Batches::model()->findAll("is_deleted=:x AND academic_yr_id=:y AND id=:z", array(':x'=>'0',':y'=>$year,':z'=>$_GET['batch_id'])); 
		}
      	
		$pdf_name = ucfirst($batch_name->name).Yii::t('app',' Attendance Percentage Report ').'.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		$html2pdf = new HTML2PDF('L', 'A4', 'en');
		$html2pdf->setDefaultFont('freesans');
		$html2pdf->WriteHTML($this->renderPartial('percentpdf', array('batches'=>$batches,'perc'=>$per), true));
		
        $html2pdf->Output($pdf_name);
	}
	
	public function actionStudentmonthlypdf()
    {
      	$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$pdf_name = ucfirst($batch_name->name).Yii::t('app',' Students Monthly Attendance Report ').$_REQUEST['month'].'.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('studentmonthlypdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	
	public function actionStudentindividualpdf()
    {
		$student_name = Students::model()->findByAttributes(array('id'=>$_REQUEST['student']));
		$pdf_name = ucfirst($student_name->first_name).' '.ucfirst($student_name->last_name).Yii::t('app',' Student Attendance').'Report.pdf';
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('studentindividualpdf', array(), true));
        $html2pdf->Output($pdf_name);
	}
	public function actionReminder()
	{
		
		if(isset($_GET['search_button']))
		{
			
			$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
						if(Yii::app()->user->year)
						{
							$year = Yii::app()->user->year;
							
						}
						else
						{
							$year = $current_academic_yr->config_value;
						} 
			if($_GET['batch_id'] == 'All')
				{	
					$criteria = new CDbCriteria;
					$criteria->condition = "is_deleted=:x AND academic_yr_id=:y";
					$criteria->params = array(':x'=>'0',':y'=>$year);
					//$total = Batches::model()->count($criteria);
					//$total = count($criteria);
					/*$pages = new CPagination($total);
					$pages->setPageSize(10);
					$pages->applyLimit($criteria);  // the trick is here!*/
					$batches = Batches::model()->findAll($criteria);
					
				}
			else{	
					$criteria = new CDbCriteria;
					$criteria->condition = "is_deleted=:x AND academic_yr_id=:y AND id=:z";
					$criteria->params = array(':x'=>'0',':y'=>$year,':z'=>$_GET['batch_id']);
					/*$total = count($criteria);
					$pages = new CPagination($total);
					$pages->setPageSize(10);
					$pages->applyLimit($criteria);  // the trick is here!*/
					$batches = Batches::model()->findAll($criteria); 
					//var_dump($_GET['batch_id']);exit;
					
			}
		   
			$this->render('reminder',array(
			'batches'=>$batches,
			'pages' => $pages,
			'item_count'=>$total,
			'page_size'=>10,
			)) ;
				exit;
				
			}
			$this->render('reminder');
	
		
	}

}