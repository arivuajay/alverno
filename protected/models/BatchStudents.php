<?php

/**
 * This is the model class for table "batch_students".
 *
 * The followings are the available columns in table 'batch_students':
 * @property integer $id
 * @property integer $student_id
 * @property integer $batch_id
 * @property integer $academic_yr_id
 * @property integer $status
 */
class BatchStudents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BatchStudents the static model class
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
		return 'batch_students';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('academic_yr_id, status', 'required'),
			array('student_id, batch_id, academic_yr_id, status, result_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, batch_id, academic_yr_id, status, result_status', 'safe', 'on'=>'search'),
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
                    'batch' => array(self::BELONGS_TO, 'Batches', 'batch_id'),
                    'student' => array(self::BELONGS_TO, 'Students', 'student_id'),
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
			'batch_id' => Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
			'academic_yr_id' => Yii::t("app",'Academic Yr'),
			'status' => Yii::t("app",'Status'),
			'result_status' => Yii::t("app",'Result Status'),
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
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('academic_yr_id',$this->academic_yr_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('result_status',$this->result_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}