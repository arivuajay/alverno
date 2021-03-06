<?php

/**
 * This is the model class for table "students".
 *
 * The followings are the available columns in table 'students':
 * @property integer $id
 * @property string $admission_no
 * @property string $class_roll_no
 * @property string $admission_date
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $batch_id
 * @property string $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $birth_place
 * @property integer $nationality_id
 * @property string $language
 * @property string $religion
 * @property integer $student_category_id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $city
 * @property string $state
 * @property string $pin_code
 * @property integer $country_id
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property integer $immediate_contact_id
 * @property integer $is_sms_enabled
 * @property string $photo_file_name
 * @property string $photo_content_type
 * @property string $photo_data
 * @property string $status_description
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $has_paid_fees
 * @property integer $photo_file_size
 * @property integer $user_id
 */
class Students extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Students the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $status;
	public $dobrange;
	public $admissionrange;
	public $task_type;
	
	private $_modelReg;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'students';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			/*validation rules for importcsv*/
			array('admission_no, admission_date, first_name, last_name, email, date_of_birth, gender, address_line1, address_line2, city, state, pin_code, phone1', 'required',),
			array('admission_no, phone1, email','unique'),
			array('email','email'),
			array('email','check'),
			/*validation rules for importcsv*/
			
			array('admission_no, parent_id, batch_id, nationality_id, student_category_id, country_id, immediate_contact_id, is_sms_enabled, is_active, is_deleted, has_paid_fees, photo_file_size, pin_code, phone1, phone2, user_id, uid', 'numerical', 'integerOnly'=>true),
			array('admission_no, class_roll_no, first_name, middle_name, last_name, gender, blood_group, birth_place, language, religion, address_line1, address_line2, city, state, email, photo_file_name, photo_content_type, status_description', 'length', 'max'=>255),
			array('admission_date, date_of_birth, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('photo_data', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true),
			array('id, admission_no, parent_id, class_roll_no, admission_date, first_name, middle_name, last_name, batch_id, date_of_birth, gender, blood_group, birth_place, nationality_id, language, religion, student_category_id, address_line1, address_line2, city, state, pin_code, country_id, phone1, phone2, email, immediate_contact_id, is_sms_enabled, photo_file_name, photo_content_type, photo_data, status_description, is_active, is_deleted, created_at, updated_at, has_paid_fees, photo_file_size, user_id', 'safe', 'on'=>'search'),
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
	
	public function check($attribute,$params)
    {
		if($this->$attribute!='')
		{
			$validate = User::model()->findByAttributes(array('email'=>$this->$attribute));
			/*if($validate!=NULL)
			{
			
				$this->addError($attribute,'Email already in use');
			}*/
		}
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'uid' => Yii::t('app','User ID'),
			'id' => Yii::t("app",'ID')
		);
		$model=$this->getFields();
		
		foreach ($model as $field)
			$labels[$field->varname] = Yii::t('app',$field->title);
			
		return $labels;	
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
		$criteria->compare('admission_no',$this->admission_no,true);
		$criteria->compare('class_roll_no',$this->class_roll_no,true);
		$criteria->compare('admission_date',$this->admission_date,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('nationality_id',$this->nationality_id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('student_category_id',$this->student_category_id);
		$criteria->compare('address_line1',$this->address_line1,true);
		$criteria->compare('address_line2',$this->address_line2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('pin_code',$this->pin_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('immediate_contact_id',$this->immediate_contact_id);
		$criteria->compare('is_sms_enabled',$this->is_sms_enabled);
		$criteria->compare('photo_file_name',$this->photo_file_name,true);
		$criteria->compare('photo_content_type',$this->photo_content_type,true);
		$criteria->compare('photo_data',$this->photo_data,true);
		$criteria->compare('status_description',$this->status_description,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('has_paid_fees',$this->has_paid_fees);
		$criteria->compare('photo_file_size',$this->photo_file_size);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getval()
	{
		return '"123"';
	}
	
	public function getFullname()
	{
	
		return '</td><td  style="padding:0 0 0 20px;" >'.CHtml::link($this->first_name.' '.$this->last_name, array('/students/students/view', 'id'=>$this->id)).'
								   </td><td  style="padding:0 0 0 20px;">'.$this->admission_no.'</td>'.
								 '</tr>';
									 
	}
	public function getStudentname()
	{
		return ucfirst($this->first_name).' '.ucfirst($this->middle_name).' '.ucfirst($this->last_name);
	}
	
	
	public function studentFullName($scope='forStudentProfile'){
		$name 	= "";

		if(FormFields::model()->isVisible('first_name', 'Students', $scope))
        {
            $name 	.= ucfirst($this->first_name);
        }

        if(FormFields::model()->isVisible('middle_name','Students', $scope))
        {
            $name 	.= (($name!="")?" ":"").ucfirst($this->middle_name);
        }

        if(FormFields::model()->isVisible('last_name','Students', $scope))
        {
            $name 	.= (($name!="")?" ":"").ucfirst($this->last_name);
        }

        return $name;
	}
	
	public function getFields() {		
		$scope 	= "forAdminRegistration";		
		$criteria	= new CDbCriteria;		
		$criteria->condition	= "`tab_selection`=:tab_selection AND `model`=:model";
		$criteria->params		= array(':tab_selection'=>1, 'model'=>"Students");			

		if($scope!=NULL){
			$this->_modelReg	= FormFields::model()->$scope()->findAll($criteria);
		}		
		return $this->_modelReg;		
	}
	
}