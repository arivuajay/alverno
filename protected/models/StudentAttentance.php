<?php

/**
 * This is the model class for table "student_attentance".
 *
 * The followings are the available columns in table 'student_attentance':
 * @property integer $id
 * @property integer $student_id
 * @property integer $date
 * @property integer $timetable_id
 * @property string $reason
 */
class StudentAttentance extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StudentAttentance the static model class
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
		return 'student_attentance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, date, reason, timetable_id, leave_type_id', 'required'),
			array('student_id', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>120),
			//array('reason','CRegularExpressionValidator','pattern'=>'/^[a-zA-Z .-]+/','message'=>"{attribute} should contain only letters"),
			//array('reason', 'required'),
			array('date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, date, reason, batch_id,timetable_id, leave_type_id', 'safe', 'on'=>'search'),
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
                    'timetable' => array(self::BELONGS_TO, 'TimetableEntries', 'timetable_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("app",'ID'),
			'student_id' => Yii::t("app",'Student'),
			'date' => Yii::t("app",'Date'),
			'reason' => Yii::t("app",'Reason'),
			'timetable_id' => Yii::t("app",'Timetable'),
			'leave_type_id' => Yii::t("app",'Leave Type'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom)
		{
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}

	function countDays($startDay,$endDay)
	{
		$startTimeStamp = strtotime($startDay);
		$endTimeStamp = strtotime($endDay);

		$timeDiff = abs($endTimeStamp - $startTimeStamp);

		$numberDays = ($timeDiff/86400)+1;  // 86400 seconds in one day

		// and you might want to convert to integer
		$numberDays = intval($numberDays);

		return $numberDays;
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('timetable_id',$this->timetable_id);
		$criteria->compare('leave_type_id',$this->leave_type_id);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}