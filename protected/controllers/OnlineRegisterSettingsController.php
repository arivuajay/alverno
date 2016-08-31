<?php

class OnlineRegisterSettingsController extends RController
{
	public function actionIndex()
	{		
		$model= new OnlineRegisterSetting2;				
		if(!empty($_POST))
		{		 
			$model->attributes = $_POST['OnlineRegisterSetting2'];				
			if($model->validate())
			{
				$posts_1=OnlineRegisterSettings::model()->findByAttributes(array('id'=>1));
				$posts_1->config_value = $model->status;
				$posts_1->save();
								
				$posts_2=OnlineRegisterSettings::model()->findByAttributes(array('id'=>2));
				$posts_2->config_value = $model->academic_year;
				$posts_2->save();
				
				$posts_3=OnlineRegisterSettings::model()->findByAttributes(array('id'=>3));
				$posts_3->config_value = $model->reg_no;
				$posts_3->save();
				
				$posts_4=OnlineRegisterSettings::model()->findByAttributes(array('id'=>4));
				$posts_4->config_value = $_POST['OnlineRegisterSetting2']['show_link'];
				$posts_4->save();
				
				Yii::app()->user->setFlash('successMessage', Yii::t('app',"Action performed successfully"));
				$this->redirect(array('index'));
			}		 
		}		
		$this->render('index',array('model'=>$model));
	}


	public function filters()
	{
	  return array(
	   'rights', // perform access control for CRUD operations
	  );
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
	
	public function actionClearYear()
	{
		$posts=OnlineRegisterSettings::model()->findByAttributes(array('id'=>2));
		$posts1=OnlineRegisterSettings::model()->findByAttributes(array('id'=>1));
		$posts->config_value = 0;
		$posts1->config_value = 0;
		if($posts->save() and $posts1->save())
		{
			echo '1';			
		}
		else
		{
			echo '0';
		}
		
	}
	
}