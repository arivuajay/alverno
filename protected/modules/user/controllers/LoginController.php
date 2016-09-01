<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	public $layout='//layouts/login';
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
                                    
                                    
					$this->lastVisit();
					//Yii::import('application.controllers.ActivityFeedController');
					//SmsSettings::model()->sendSms($to,$from,$message); To call an action written on a controller
					//Adding activity to feed via saveFeed($initiator_id,$activity_type,$goal_id,$goal_name,$field_name,$initial_field_value,$new_field_value)
					ActivityFeed::model()->saveFeed(Yii::app()->user->Id,'1',NULL,NULL,NULL,NULL,NULL); 
					$roles=Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
					       foreach($roles as $role)
						   if(sizeof($roles)==1 and $role->name == 'parent')
						   {
							   $this->redirect(array('/parentportal/default/dashboard'));
							   
						   }
						   if(sizeof($roles)==1 and $role->name == 'student')
						   {
							   $this->redirect(array('/studentportal/default/dashboard'));
							   
						   }
						   if(sizeof($roles)==1 and $role->name == 'teacher')
						   {
							   $this->redirect(array('/teachersportal/default/dashboard'));
							   
						   } 
						 if(Yii::app()->user->checkAccess('admin'))
						 {	
							 if (Yii::app()->user->returnUrl=='/index.php')
								$this->redirect(Yii::app()->controller->module->returnUrl);
							else
								$this->redirect(Yii::app()->user->returnUrl);
						 }
						 else
					     {
							 $this->redirect(array('/dashboard'));
						 }
                                    
                                                 
                                                 
                                                 
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}