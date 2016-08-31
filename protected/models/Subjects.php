<?php

/**
 * This is the model class for table "subjects".
 *
 * The followings are the available columns in table 'subjects':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $batch_id
 * @property integer $no_exams
 * @property integer $max_weekly_classes
 * @property integer $elective_group_id
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 */
class Subjects extends CActiveRecord
{
	public $job;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Subjects the static model class
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
		return 'subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		
			array('batch_id, no_exams, max_weekly_classes, elective_group_id, is_deleted', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>50),
			array('batch_id, name, max_weekly_classes, code', 'required'),
			//array('name','unique','message' => "This subject name already exists."),
			//array('name','codes','message' => "This  Event Type already exists."),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, batch_id, no_exams, max_weekly_classes, elective_group_id, is_deleted, created_at, updated_at, admin_id, is_edit', 'safe', 'on'=>'search'),
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
		 'batch123'=>array(self::BELONGS_TO, 'Batches', 'batch_id'),        
		);

	}
	
	#Checking unique subject name in a batch
	public function codes($attribute,$params)
	{
		
	    $flag=0;
		$subject=Subjects::model()->findAllByAttributes(array('batch_id'=>$this->batch_id,'is_deleted'=>0));
		foreach($subject as $subject_1)
		{
			if($subject_1->name == $this->name)
			{
			$flag=1;
			}
		} 
		if($flag==1)
		{
		$this->addError($attribute, Yii::t("app",'This subject is already added'));
		}
	}	
	 
	 /**
	 * @return array customized attribute labels (name=>label)
	 */
	 
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("app",'ID'),
			'name' => Yii::t("app",'Name'),
			'code' => Yii::t("app",'Code'),
			'batch_id' => Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
			'no_exams' => Yii::t("app",'No Exams'),
			'max_weekly_classes' => Yii::t("app",'Max Weekly Classes'),
			'elective_group_id' => Yii::t("app",'Elective Group'),
			'is_deleted' => Yii::t("app",'Is Deleted'),
			'created_at' => Yii::t("app",'Created At'),
			'updated_at' => Yii::t("app",'Updated At'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('no_exams',$this->no_exams);
		$criteria->compare('max_weekly_classes',$this->max_weekly_classes);
		$criteria->compare('elective_group_id',$this->elective_group_id);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getbatchname()
	{
		$batches=Batches::model()->findByAttributes(array('id'=>$this->batch_id,'is_deleted'=>0));
			return $this->name.'('.$batches->name.')';
	}
		
		
	
	
	
}