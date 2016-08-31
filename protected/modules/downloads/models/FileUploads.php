<?php

/**
 * This is the model class for table "file_uploads".
 *
 * The followings are the available columns in table 'file_uploads':
 * @property integer $id
 * @property string $title
 * @property integer $category
 * @property string $placeholder
 * @property integer $course
 * @property integer $batch
 * @property string $file
 * @property string $file_type
 * @property integer $created_by
 * @property string $created_at
 */
class FileUploads extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FileUploads the static model class
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
		return 'file_uploads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category, file', 'required'),
			array('category, course, batch, academic_yr_id, created_by', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('file', 'file', 'types'=>'jpg, jpeg, png, gif, pdf, mp4, doc, txt, ppt, docx', 'allowEmpty'=>true),
			array('placeholder', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, category, placeholder, course, batch, file, file_type, academic_yr_id,created_by, created_at', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app','ID'),
			'title' => Yii::t('app','Title'),
			'category' => Yii::t('app','Category'),
			'placeholder' => Yii::t('app','Placeholder'),
			'course' => Yii::t('app','Course'),
			'batch' => Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
			'file' => Yii::t('app','File'),
			'file_type' => Yii::t('app','File Type'),
			'academic_yr_id' => Yii::t('app','Academic Year'),
			'created_by' => Yii::t('app','Created By'),
			'created_at' => Yii::t('app','Created At'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('placeholder',$this->placeholder,true);
		$criteria->compare('course',$this->course);
		$criteria->compare('batch',$this->batch);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('academic_yr_id',$this->academic_yr_id,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetCourse($data,$row)
	{  
		if($data->course)
		{
			$course = Courses::model()->findByAttributes(array('id'=>$data->course));
			
			if($course->course_name)
			{
				return ucfirst($course->course_name);
			}
			else
			{
				echo '-';
			}
		}
		else
		{
			echo '-';
		}
	}
	
	public function GetBatch($data,$row)
	{
		if($data->batch)
		{
			$batch = Batches::model()->findByAttributes(array('id'=>$data->batch));
			if($batch->name)
			{
				return ucfirst($batch->name);
			}
			else
			{
				echo '-';
			}
		}
		else
		{
			echo '-';
		}
	}
	
	public function GetYear($data,$row)
	{
		if($data->academic_yr_id)
		{
			$year = AcademicYears::model()->findByAttributes(array('id'=>$data->academic_yr_id));
			if($year->name)
			{
				return ucfirst($year->name);
			}
			else
			{
				echo '-';
			}
		}
		else
		{
			echo '-';
		}
	}
	
	public function GetPlaceholder($data,$row)
	{
		if($data->placeholder)
		{
			return ucfirst($data->placeholder);
		}
		else
		{
			return 'Public';
		}
	}
}