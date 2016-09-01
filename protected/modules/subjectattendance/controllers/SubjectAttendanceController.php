<?php

class SubjectAttendanceController extends RController
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

	public function actionCoursewise(){
	}
	public function actionIndividual(){
		
		$model = Students::model()->findByPk($_REQUEST['id']);
		$this->render('individual',array(
			'model'=>$model,
		));
	}
	public function actionAttendance(){
	}
	public function actionSpattendance(){
	}
	public function actionTpattendance(){
	}

	
}
