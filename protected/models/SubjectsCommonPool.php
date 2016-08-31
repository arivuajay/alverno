<?php

/**
 * This is the model class for table "subjects_common_pool".
 *
 * The followings are the available columns in table 'subjects_common_pool':
 * @property integer $id
 * @property integer $course_id
 * @property string $subject_name
 * @property string $subject_code
 * @property integer $max_weekly_classes
 */
class SubjectsCommonPool extends CActiveRecord
{
	public $all_batches;
	/**
	 * Returns the static model of the specified AR class.
	 * @return SubjectsCommonPool the static model class
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
		return 'subjects_common_pool';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, subject_name, subject_code, max_weekly_classes', 'required'),
			array('course_id, max_weekly_classes', 'numerical', 'integerOnly'=>true),
			array('subject_name, subject_code', 'length', 'max'=>225),
			array('subject_name,subject_code','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, course_id, subject_name, subject_code, max_weekly_classes', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'course_id' => Yii::t('app','Course'),
			'subject_name' => Yii::t('app','Subject Name'),
			'subject_code' => Yii::t('app','Subject Code'),
			'max_weekly_classes' => Yii::t('app','Maximum Weekly Classes'),
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('subject_code',$this->subject_code,true);
		$criteria->compare('max_weekly_classes',$this->max_weekly_classes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}