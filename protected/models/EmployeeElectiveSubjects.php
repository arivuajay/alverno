<?php

/**
 * This is the model class for table "employee_elective_subjects".
 *
 * The followings are the available columns in table 'employee_elective_subjects':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $elective_id
 * @property integer $subject_id
 */
class EmployeeElectiveSubjects extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmployeeElectiveSubjects the static model class
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
		return 'employee_elective_subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, elective_id, subject_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, employee_id, elective_id, subject_id', 'safe', 'on'=>'search'),
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
			'elective_id' => Yii::t("app",'Elective'),
			'subject_id' => Yii::t("app",'Subject'),
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
		$criteria->compare('elective_id',$this->elective_id);
		$criteria->compare('subject_id',$this->subject_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function Employeenotassigned($id,$elect)
	{
		    $results=array();
			$emp=Employees::model()->findAllByAttributes(array('employee_department_id'=>$id));
			if($emp!=NULL)
			{
				$i=0;
				foreach($emp as $emp1)
				{
					if(EmployeeElectiveSubjects::model()->findByAttributes(array('employee_id'=>$emp1->id,'elective_id'=>$elect))==NULL)
					{
						$results[$i] = $emp1;
						$i++;
					}
					
				}
			}
			return $results;
	}
}