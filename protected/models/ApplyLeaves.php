<?php

/**
 * This is the model class for table "apply_leaves".
 *
 * The followings are the available columns in table 'apply_leaves':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $employee_leave_types_id
 * @property integer $is_half_day
 * @property string $start_date
 * @property string $end_date
 * @property string $reason
 * @property integer $approved
 * @property integer $viewed_by_manager
 * @property string $manager_remark
 */
class ApplyLeaves extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ApplyLeaves the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apply_leaves';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, employee_leave_types_id,start_date,end_date,reason', 'required'),
			array('employee_id, employee_leave_types_id, is_half_day, approved, viewed_by_manager,viewed_by_user', 'numerical', 'integerOnly'=>true),
			
			array('start_date,end_date', 'type', 'type' => 'date', 'message' => '{attribute}: '.Yii::t("app",'is not a date!'), 'dateFormat' => 'yyyy-MM-dd'),
			array('start_date,end_date,date,no_days', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, employee_id, employee_leave_types_id, is_half_day, start_date, end_date, reason, approved, viewed_by_manager, manager_remark', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("app",'ID'),
			'employee_id' => Yii::t("app",'Teacher'),
			'employee_leave_types_id' => Yii::t("app",'Leave Types'),
			'is_half_day' => Yii::t("app",'Is Half Day'),
			'start_date' => Yii::t("app",'Start Date'),
			'end_date' => Yii::t("app",'End Date'),
			'reason' => Yii::t("app",'Reason'),
			'approved' => Yii::t("app",'Approved'),
			'viewed_by_manager' => Yii::t("app",'Viewed By Manager'),
			'manager_remark' => Yii::t("app",'Manager Remark'),
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('employee_leave_types_id',$this->employee_leave_types_id);
		$criteria->compare('is_half_day',$this->is_half_day);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('viewed_by_manager',$this->viewed_by_manager);
		$criteria->compare('manager_remark',$this->manager_remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDay($str)
	{
		if($str == 'Sun')
		{
			return 1;
		}
		elseif($str == 'Mon')
		{
			return 2;
		}
		elseif($str == 'Tue')
		{
			return 3;
		}
		elseif($str == 'Wed')
		{
			return 4;
		}
		elseif($str == 'Thu')
		{
			return 5;
		}
		elseif($str == 'Fri')
		{
			return 6;
		}
		elseif($str == 'Sat')
		{
			return 7;
		}
		else
		{
			return;
		}
	}
	
	public function getBatches($emp_id)
	{
		//get batches belongs to the employee
		$batches = Batches::model()->findAllByAttributes(array('employee_id'=>$emp_id,'is_active'=>1,'is_deleted'=>0));
		
		$batch_array=array();
		foreach($batches as $batch)
		{
			$batch_array[]=$batch->id;
		}
		
		$timetables = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$emp_id));
		foreach($timetables as $timetable)
		{
			if($timetable->batch_id)
			{
				$is_batch = Batches::model()->findByAttributes(array('id'=>$timetable->batch_id));
				if((!in_array($timetable->batch_id,$batch_array)) and ($is_batch!=NULL))
				{
					$batch_array[] = $timetable->batch_id;
				}
			}
		}
		
		return $batch_array;
	}
//Selecting free employees	
	public function getEmployees($batch_id,$employee_id)
	{
		$employee_ids = array();		
		$batch = Batches::model()->findByAttributes(array('id'=>$batch_id));		
		$subjects = Subjects::model()->findAllByAttributes(array('batch_id'=>$batch_id,'is_deleted'=>0));			
		if($subjects)
		{
			foreach($subjects as $subject)
			{
				$employee_subjects = EmployeesSubjects::model()->findAllByAttributes(array('subject_id'=>$subject->id));	
				
				foreach($employee_subjects as $employee_subject)
				{
					$employee = Employees::model()->findByAttributes(array('id'=>$employee_subject->employee_id,'is_deleted'=>0));										
					if((!in_array($employee->id,$employee_ids)) and ($employee->id!=$employee_id))
					{
						$employee_ids[] = $employee->id;
					}
				}																
			}										
		}	
	//Getting class teacher		
		if(($batch->employee_id!=NULL) and ($batch->employee_id!=$employee_id))
		{
			if(!in_array($batch->employee_id,$employee_ids))
			{
				$employee_ids[] = $batch->employee_id;
			}
		}
		
	//Getting elective employees	
		$electives = Electives::model()->findAllByAttributes(array('batch_id'=>$batch_id,'is_deleted'=>0));
		
		if($electives){
			foreach($electives as $elective){
				$elective_employees = EmployeeElectiveSubjects::model()->findAllByAttributes(array('elective_id'=>$elective->id));				
				if($elective_employees){
					foreach($elective_employees as $elective_employee){
						if((!in_array($elective_employee->employee_id,$employee_ids)) and ($elective_employee->employee_id!=$employee_id)){
							$employee_ids[] = $elective_employee->employee_id;
						}
					}
				}
			}
		}				
		return $employee_ids;				
	}
//Check if the employee is available to take the class	
	public function getAvailableEmp($emp_id,$class_timing_id,$batch_id,$weekday_id,$date)
	{
		$flag = 0;			
		$employee = Employees::model()->findByAttributes(array('id'=>$emp_id));
		$criteria = new CDbCriteria;
		$criteria->condition = 'employee_id =:employee_id and approved =:approved and start_date >=:start_date';
		$criteria->params = array(':employee_id'=>$employee->uid,':start_date'=>date('Y-m-d'),':approved'=>1);
		$leave_requests = ApplyLeaves::model()->findAll($criteria);
		
		foreach($leave_requests as $leave_request)
		{			
			$date_between = array();
			$begin = new DateTime($leave_request->start_date);
			$end = new DateTime($leave_request->end_date);
			
			$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
			
			foreach($daterange as $date1){
				$date_between[] = $date1->format("Y-m-d");
			}
			
			if(!in_array($leave_request->end_date,$date_between))
			{
				$date_between[] = date('Y-m-d',strtotime($leave_request->end_date));
			}			
			if(in_array(date('Y-m-d',strtotime($date)),$date_between))
			{
				return 0;
			}
		}
							
		$batches = $this->getBatches($emp_id);
		
		$class_timing = ClassTimings::model()->findByAttributes(array('id'=>$class_timing_id));		
		
		if($batches)
		{
			for($i = 0; $i < count($batches); $i++)
			{
				$is_avaialable = ClassTimings::model()->findByAttributes(array('batch_id'=>$batches[$i],'start_time'=>$class_timing->start_time,'end_time'=>$class_timing->end_time,'is_break'=>0));
				if($is_avaialable)
				{
					$is_employee_avaialable = TimetableEntries::model()->findByAttributes(array('batch_id'=>$batches[$i],'weekday_id'=>$weekday_id,'class_timing_id'=>$is_avaialable->id,'employee_id'=>$emp_id));
				}	
				
				$is_leave_apply = TeacherSubstitution::model()->findByAttributes(array('substitute_emp_id'=>$emp_id,'date_leave'=>date('Y-m-d',strtotime($date))));
				
				if($is_leave_apply)
				{
					$flag = 1;
				}			
				if($is_employee_avaialable)
				{
					$flag = 1;
				}
				
																
			}
			if($flag == 0)
			{
				
				return $emp_id;
			}
			else
			{
				return 0;
			}
				
		}
		else
		{
			return $emp_id;
		}
		
	}
}