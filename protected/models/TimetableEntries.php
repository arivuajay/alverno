<?php

/**
 * This is the model class for table "timetable_entries".
 *
 * The followings are the available columns in table 'timetable_entries':
 * @property integer $id
 * @property integer $batch_id
 * @property integer $weekday_id
 * @property integer $class_timing_id
 * @property integer $subject_id
 * @property integer $employee_id
 */
class TimetableEntries extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TimetableEntries the static model class
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
		return 'timetable_entries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		    array('batch_id, weekday_id, subject_id, employee_id', 'required'),

			array('batch_id, weekday_id, class_timing_id, subject_id, employee_id', 'numerical', 'integerOnly'=>true),
			//array('employee_id','check_allocation'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('employee_id','check'),
                        array('subject_id','check_subject'),
			array('id, batch_id, weekday_id, class_timing_id, subject_id, employee_id', 'safe', 'on'=>'search'),
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
                    'classTiming' => array(self::BELONGS_TO, 'ClassTimings', 'class_timing_id'),
                    'subject' => array(self::BELONGS_TO, 'Subjects', 'subject_id'),
		);
	}

        public function getFieldClassSubject() {
            return "{$this->classTiming->start_time} - {$this->classTiming->end_time} : {$this->subject->name}";
        }

        public function check($attribute,$params)
        {

            $flag=0;
            $criteria= new CDbCriteria();
            $criteria->condition= 'batch_id<>:batch_id and employee_id=:employee_id and weekday_id=:weekday_id';
            $criteria->params=array(':batch_id'=>  $this->batch_id, ':employee_id'=>  $this->employee_id, ':weekday_id'=>  $this->weekday_id);
            $model= $this->model()->findAll($criteria);

           if($model)
            {
                foreach ($model as $data)
                {
                    $class_time_id= $data->class_timing_id;

                    $class_model= ClassTimings::model()->findByPk($class_time_id);
                    $start_time= $class_model->start_time;
                    $end_time= $class_model->end_time;

                    $current_class= $this->class_timing_id;
                    $curr_class_model= ClassTimings::model()->findByPk($current_class);
                    $curr_start_time= $curr_class_model->start_time;
                    $curr_end_time= $curr_class_model->end_time;


                    if($start_time <= $curr_start_time or $end_time >=$curr_end_time)
                    {
                        $flag==1;
                        if($start_time <= $curr_start_time)
                        {
                            if($curr_start_time<$end_time)
                            {
                                $this->addError($attribute,Yii::t('app','Teacher assigned to another').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"));
                            }
                        }
                        elseif ($end_time >=$curr_end_time)
                        {


                            if($end_time<$curr_start_time)
                            {
                                $this->addError($attribute,Yii::t('app','Teacher assigned to another').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"));
                            }
                        }
                        else
                        {
                            $this->addError($attribute,Yii::t('app','Teacher assigned to another').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"));
                        }


                    }


                }
            }

        }

                /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("app",'ID'),
			'batch_id' => Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
			'weekday_id' => Yii::t("app",'Weekday'),
			'class_timing_id' => Yii::t("app",'Class Timing'),
			'subject_id' => Yii::t("app",'Subject'),
			'employee_id' => Yii::t("app",'Teacher'),
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
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('weekday_id',$this->weekday_id);
		$criteria->compare('class_timing_id',$this->class_timing_id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('employee_id',$this->employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function check_subject($attribute,$params)
	{
		$sub_id  = $this->subject_id;

		if($this->is_elective == 2)
		{
			$elective = Electives::model()->findByPk($this->subject_id);
			$subject = Subjects::model()->findByAttributes(array('elective_group_id'=>$elective->elective_group_id));

			$subs_id  = $this->subject_id;
			$max_count = $subject->max_weekly_classes;

			$classcount=TimetableEntries::model()->findAllByAttributes(array('subject_id'=>$subs_id,'batch_id'=>$this->batch_id,'is_elective'=>2));

				if(count($classcount)>=$max_count)
				{
					$this->addError($attribute, Yii::t("app",'Maximum weekly classes of this subject is exceeded!'));
				}
		}
		else
		{
		if($sub_id!=NULL){
			$count=Subjects::model()->findByAttributes(array('id'=>$sub_id));
			$max_count=$count->max_weekly_classes;
			$classcount=TimetableEntries::model()->findAllByAttributes(array('subject_id'=>$sub_id,'batch_id'=>$this->batch_id,'is_elective'=>0));

			if(count($classcount)>=$max_count)
			{
				$this->addError($attribute, Yii::t("app",'Maximum weekly classes of this subject is exceeded!'));
			}
		}
		}

	}

	/* public function check_allocation($attribute,$params)
	{
		$emp_id	  = $this->employee_id;
		if($emp_id!=NULL)
		{
			$time_table_entries = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$emp_id)); //get all timetable entries for selected employee
			$current_batch  	= Batches::model()->findByAttributes(array('id'=>$this->batch_id)); //get details of selected batch
			$current_timing 	= ClassTimings::model()->findByAttributes(array('id'=>$this->class_timing_id)); //get class timing details of current slot

			foreach($time_table_entries as $time_table_entry)
			{
				$batch = Batches::model()->findByAttributes(array('id'=>$time_table_entry->batch_id));
					if($batch->start_date <= $current_batch->end_date and $current_batch->start_date <= $batch->end_date){
						$class_timing = ClassTimings::model()->findByAttributes(array('id'=>$time_table_entry->class_timing_id);
							if($class_timing->start_time <= $current_timing->end_time and $current_timing->start_time <= $class_timing->end_time){
								$this->addError('employee_id', 'This teacher is already assigned this hour!');
							}
					}
			}
		}
	} */
}