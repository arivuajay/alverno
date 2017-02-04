<?php

/**
 * This is the model class for table "student_siblings".
 *
 * The followings are the available columns in table 'student_siblings':
 * @property integer $id
 * @property integer $student_id
 * @property string $name
 * @property string $class
 * @property string $file_name
 * @property string $file_type
 * @property integer $type
 */
class StudentSiblings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StudentSiblings the static model class
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
		return 'student_siblings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			array('student_id, type', 'numerical', 'integerOnly'=>true),
			array('name, class, file_name, file_type', 'length', 'max'=>255),
			array('file_name', 'file', 'types'=>'jpg,jpeg, png', 'allowEmpty' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, name, class, file_name, file_type, type', 'safe', 'on'=>'search'),
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
			'student_id' => 'Student',
			'name' => 'Name of the Sibling *',
			'class' => 'Class *',
			'file_name' => 'Upload ID card *',
			'file_type' => 'File Type',
			'type' => 'Type',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}