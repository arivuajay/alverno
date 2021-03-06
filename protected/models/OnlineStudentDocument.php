<?php

/**
 * This is the model class for table "online_student_document".
 *
 * The followings are the available columns in table 'online_student_document':
 * @property integer $id
 * @property integer $student_id
 * @property string $title
 * @property string $file
 * @property string $file_type
 * @property integer $uploaded_by
 * @property string $created_at
 */
class OnlineStudentDocument extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OnlineStudentDocument the static model class
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
		return 'online_student_document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, title, file, file_type,', 'required'),
			array('student_id', 'numerical', 'integerOnly'=>true),
			array('title, file, file_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, title, file, file_type,created_at', 'safe', 'on'=>'search'),
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
			'student_id' => Yii::t("app",'Student'),
			'title' => Yii::t("app",'Title'),
			'file' => Yii::t("app",'File'),
			'file_type' => Yii::t("app",'File Type'),			
			'created_at' => Yii::t("app",'Created At'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('file_type',$this->file_type,true);
		//$criteria->compare('uploaded_by',$this->uploaded_by);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}