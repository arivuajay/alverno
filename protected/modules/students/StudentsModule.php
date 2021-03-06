<?php

class StudentsModule extends CWebModule
{
	public $defaultController = 'students';
	public $subjectMaxCharsDisplay = 100;
	public $ellipsis = '...';
	public $allowableCharsSubject = '0-9a-z.,!?@\s*$%#&;:+=_(){}\[\]\/\\-';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'students.models.*',
			'students.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function fieldLabel($model, $field, $type=0){
		
		if($type==0)
		{
			return $model::model()->getAttributeLabel($field);
		}
		else
		{
			return 0;
		}
	}

	public function labelCourseBatch(){
		return Yii::t('app', 'Course')." / ".$this->fieldLabel("Students", 'batch_id');
	}

	public function isFieldVisible($model=NULL, $field=NULL, $scope=NULL){
		$found	= NULL;
		if($field!=NULL and $model!=NULL and $scope!=NULL){
			$criteria				= new CDbCriteria;
			$criteria->condition 	= "`varname`=:varname and `model`=:model";
			$criteria->params 		= array('varname'=>$field_name,'model'=>$model);			
			$found 					= FormFields::model()->$scope()->find($criteria);				
		}

		if($found != NULL)
			return true;
		else
			return false;
	}

	public function studentsOfBatch($batch_id, $is_active=1){
		$criteria = new CDbCriteria;
        $criteria->condition = '`t`.`is_deleted`=:is_deleted AND `t`.`is_active`=:is_active AND `bs`.`batch_id`=:batch_id';
        $criteria->params[':is_deleted'] = 0;
        $criteria->params[':is_active']  = $is_active;
        $criteria->params[':batch_id']   = $batch_id;

        if($is_active){
        	$criteria->condition 	.= " AND `bs`.`result_status`=:result_status AND `bs`.`status`=:status";
	        $criteria->params[':result_status']  = 0;
	        $criteria->params[':status']   	 = 1;
	    }

        $criteria->join 	= "JOIN `batch_students` `bs` ON `bs`.`student_id`=`t`.`id`";

        return Students::model()->findAll($criteria);
	}

	/*public function isStudentFullnameVisible($scope){
		return $this->isFieldVisible("Students", 'first_name', $scope) || $this->isFieldVisible("Students", 'middle_name', $scope) || $this->isFieldVisible("Students", 'last_name', $scope);
	}

	public function isParentFullnameVisible($scope){
		return $this->isFieldVisible("Guardians", 'first_name', $scope) || $this->isFieldVisible("Guardians", 'last_name', $scope);
	}*/
}