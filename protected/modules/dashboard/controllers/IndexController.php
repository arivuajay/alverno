<?php
class IndexController extends RController
{
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}
	public function actionIndex()
	{
		if(Yii::app()->user->id)
		{
			$this->render('index');
		}
		else
		{
			$this->redirect('user/login');
		}
	}
}