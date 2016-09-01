<?php

class TeachersTimetableController extends RController
{
	public function actionIndex()
	{
		if(isset($_REQUEST['dep_id']) and isset($_REQUEST['employee_id']) and isset($_REQUEST['day_id']))
		
			$this->render('index',array('department_id'=>$_REQUEST['dep_id'],'employee_id'=>$_REQUEST['employee_id'],'day_id'=>$_REQUEST['day_id']));
		else
			$this->render('index',array());
	}

		
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'rights', // perform access control for CRUD operations
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
	public function actionEmployeename()
	{			
		$data=Employees::model()->findAll('employee_department_id=:id AND is_deleted=:y',array(':id'=>(int) $_POST['department_id'],':y'=>0));
		
		echo CHtml::tag('option', array('value' => ''), CHtml::encode(Yii::t('app','Select Teacher')), true);
		echo CHtml::tag('option', array('value' => 0), CHtml::encode(Yii::t('app','All Teacher')), true);
		$data=CHtml::listData($data,'id','first_name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
	 }
	 
	 public function actionFullPdf()
     {
		//$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['bid']));
		$batch_name = ' Teacher Timetable.pdf';
        
        # HTML2PDF has very similar syntax
		
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		 $html2pdf = new HTML2PDF('L', 'A4', 'en');
		 $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('exportpdf', array(), true));
 		$html2pdf->Output($batch_name);
        ////////////////////////////////////////////////////////////////////////////////////
	}
	
	public function actionFullTeacherPdf()
     {
		//$batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['bid']));
		$batch_name = ' Teacher Timetable.pdf';
        
        # HTML2PDF has very similar syntax
		
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
		 $html2pdf = new HTML2PDF('L', 'A4', 'en');
		 $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($this->renderPartial('exportfullpdf', array(), true));
 		$html2pdf->Output($batch_name);
        ////////////////////////////////////////////////////////////////////////////////////
	}
	
}