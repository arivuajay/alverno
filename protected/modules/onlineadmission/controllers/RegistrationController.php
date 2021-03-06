<?php
class RegistrationController extends RController
{

	public $layout='//layouts/public';


	/*public function filters()
	{
	  return array(
	   'rights', // perform access control for CRUD operations
	  );
	}*/

	public function actionIndex()
	{

		$model = new ApplicationStatus;
		if(isset($_POST['ApplicationStatus']))
		{
			$model->attributes = $_POST['ApplicationStatus'];
			$model->registration_id = $_POST['ApplicationStatus']['registration_id'];
			$model->password = $_POST['ApplicationStatus']['password'];
			$profile_id = $model->authenticate();
			if($model->validate() and $profile_id!= NULL)
			{

				Yii::app()->session['profile'] = $profile_id;
				$this->redirect(array('status'));
			}

		}
		if(Yii::app()->session['profile'])
		{
			Yii::app()->session->remove('profile');
		}

		$this->render('index',array('model'=>$model));
	}

	public function actionEdit()
	{
		$model		= Students::model()->findByAttributes(array('id'=>Yii::app()->session['profile']));
		$model_1	= Guardians::model()->findByAttributes(array('id'=>$model->parent_id));
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		if(!empty($_POST)){
			$model->attributes = $_POST['Students'];
			$model_1->attributes = $_POST['Guardians'];
			if($model->date_of_birth){
				$model->date_of_birth = date('Y-m-d',strtotime($model->date_of_birth));
			}
			if($model_1->dob){
				$model_1->dob = date('Y-m-d',strtotime($model_1->dob));
			}
			if($file=CUploadedFile::getInstance($model,'photo_data')){
				$model->photo_file_name=$file->name;
      		}

			//dynamic fields
			$fields   = FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}

			$fields   = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}

			$fields   = FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model_1->$field_name!=NULL and $model_1->$field_name!="0000-00-00" and $settings!=NULL){
						$model_1->$field_name = date('Y-m-d',strtotime($model_1->$field_name));
					}
				}
			}

			$fields   = FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model_1->$field_name!=NULL and $model_1->$field_name!="0000-00-00" and $settings!=NULL){
						$model_1->$field_name = date('Y-m-d',strtotime($model_1->$field_name));
					}
				}
			}

			$validate	= $model->validate();
			$validate1	= $model_1->validate();

			if($validate and $validate1){
				if($model->save() and $model_1->save()){
					$is_guardian_list = GuardianList::model()->findByAttributes(array('student_id'=>$model->id,'guardian_id'=>$model_1->id));
					if($is_guardian_list == NULL){
						$guardian_list= new GuardianList;
						$guardian_list->student_id= $model->id;
						$guardian_list->guardian_id= $model_1->id;
						$guardian_list->relation= $model_1->relation;
						$guardian_list->save();
					}else{
						$is_guardian_list->relation = $model_1->relation;
						$is_guardian_list->save();
					}
					//Save the profile pic to the folder
					if($model->photo_file_name!=NULL){
						if(!is_dir('uploadedfiles/')){
							mkdir('uploadedfiles/');
						}
						if(!is_dir('uploadedfiles/student_profile_image/')){
							mkdir('uploadedfiles/student_profile_image/');
						}
						if(!is_dir('uploadedfiles/student_profile_image/'.$model->id)){
							mkdir('uploadedfiles/student_profile_image/'.$model->id);
						}

						//compress the image
						$info = getimagesize($_FILES['Students']['tmp_name']['photo_data']);
						if($info['mime'] == 'image/jpeg'){
							$image = imagecreatefromjpeg($_FILES['Students']['tmp_name']['photo_data']);
						}elseif($info['mime'] == 'image/gif'){
							$image = imagecreatefromgif($_FILES['Students']['tmp_name']['photo_data']);
						}elseif($info['mime'] == 'image/png'){
							$image = imagecreatefrompng($_FILES['Students']['tmp_name']['photo_data']);
						}
						$temp_file_name = $_FILES['Students']['tmp_name']['photo_data'];
						$destination_file = 'uploadedfiles/student_profile_image/'.$model->id.'/'.$_FILES['Students']['name']['photo_data'];
						imagejpeg($image, $destination_file, 30);
					}
					$this->redirect(array('status'));
				}
			}
		}
		//dynamic date fields
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		$fields   = FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
		foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
		}

		$fields   = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
		foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
		}

		$fields   = FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
		foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model_1->$field_name!=NULL and $model_1->$field_name!="0000-00-00" and $settings!=NULL){
					$model_1->$field_name = date($settings->displaydate,strtotime($model_1->$field_name));
				}
				else{
					$model_1->$field_name=NULL;
				}
			}
		}

		$fields   = FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
		foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model_1->$field_name!=NULL and $model_1->$field_name!="0000-00-00" and $settings!=NULL){
					$model_1->$field_name = date($settings->displaydate,strtotime($model_1->$field_name));
				}
				else{
					$model_1->$field_name=NULL;
				}
			}
		}
		$this->render('edit',array('model'=>$model,'model_1'=>$model_1,'course'=>$_POST['Students']['course'],'batch_id'=>$_POST['Students']['batch_id']));
	}
//Step1 is for storing student details
	public function actionStep1()
	{
		$roles=Rights::getAssignedRoles(Yii::app()->user->Id);
		if(Yii::app()->user->id!=NULL and key($roles)!=NULL and (key($roles) == 'parent') and $_GET['token']==NULL)
		{
			$model = new Students;
                        $model_1 = new StudentSiblings;
			$DetilsOfLoginedParent = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));

			$criteria = new CDbCriteria;
            $criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active AND parent_id=:id';
            $criteria->params[':is_deleted'] = 0;
            $criteria->params[':is_active'] = 1;
			$criteria->params[':id'] = $DetilsOfLoginedParent->id;
			$criteria->limit = 1;
			$DetailsOfStudents = Students::model()->findAll($criteria);

			foreach($DetailsOfStudents as $studentDetail)
			{
				$model->address_line1 = $studentDetail->address_line1;
				$model->address_line2 = $studentDetail->address_line2;
				$model->city = $studentDetail->city;
				$model->state = $studentDetail->state;
				$model->pin_code = $studentDetail->pin_code;
				$model->country_id = $studentDetail->country_id;
				$model->religion = $studentDetail->religion;
				$model->nationality_id = $studentDetail->nationality_id;
				$model->student_category_id = $studentDetail->student_category_id;
			}
		}
		elseif($_GET['token']==NULL and $_GET['token']=='' and $_REQUEST['from']==NULL and Yii::app()->user->Id!=NULL and key($roles)!=NULL and (key($roles) == 'Admin'))
		{
			$model	=	new Students;
                        $model_1 = new StudentSiblings;
		}
		elseif($_GET['token']==NULL and $_GET['token']=='' and $_REQUEST['from']==NULL and Yii::app()->user->Id==NULL)
		{
			$model	=	new Students;
                        $model_1 = new StudentSiblings;
		}
		elseif(isset($_GET['token']))
		{
			$token		= isset($_GET['token'])?$_GET['token']:NULL;
			//checking session
			$this->checkAccess($token);
			$student_id	= $this->decryptToken($token);

			$model		= Students::model()->findByPk($student_id);
                        $model_1 	= StudentSiblings::model()->findByAttributes(array('student_id'=>$student_id,'type'=>1));
			if($model_1 == NULL){
                            $model_1 = new StudentSiblings;
			}
		}
		elseif($_REQUEST['from']=='online')
		{
			$model = new Students;
                        $model_1 = new StudentSiblings;
			$studentDetails = Students::model()->findByAttributes(array('id'=>Yii::app()->session['profile']));
			Yii::app()->session['parent_id'] = 	$studentDetails->parent_id;
		//details of student
			$model->address_line1 = $studentDetails->address_line1;
			$model->address_line2 = $studentDetails->address_line2;
			$model->city = $studentDetails->city;
			$model->state = $studentDetails->state;
			$model->pin_code = $studentDetails->pin_code;
			$model->country_id = $studentDetails->country_id;
			$model->religion = $studentDetails->religion;
			$model->nationality_id = $studentDetails->nationality_id;
			$model->student_category_id = $studentDetails->student_category_id;
		}
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
		if($settings!=NULL and $model->date_of_birth!=NULL)
		{
			$date_of_birth=date($settings->displaydate,strtotime($model->date_of_birth));
			$model->date_of_birth = $date_of_birth;

		}
		if(!empty($_POST))
		{
			$model->attributes = $_POST['Students'];
                        $model_1->attributes = $_POST['StudentSiblings'];
			$model->password = substr(md5(uniqid(mt_rand(), true)), 0, 10);
			if($_GET['token']==NULL){
				$model->registration_id = $this->getRegistrationId();
			}

			$model->registration_date = date('Y-m-d');
			if($model->date_of_birth)
			{
				$model->date_of_birth = date('Y-m-d',strtotime($model->date_of_birth));
			}
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
			if($settings!=NULL)
			{
				$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
				date_default_timezone_set($timezone->timezone);

			}
			$model->created_at = date('Y-m-d H:i:s');
			if($file=CUploadedFile::getInstance($model,'photo_data'))
			{
				$model->photo_file_name=$file->name;
      		}

			//dynamic fields
			$fields   = FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}

			$fields   = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
					}
				}
			}
		//For saving current selected academic_yr for online admission
			$academic_yr = OnlineRegisterSettings::model()->findByAttributes(array('id'=>2));
			$model->academic_yr = $academic_yr->config_value;

			$model->is_completed =  1;
			$model->type = 1;
			$model->is_online = 1;
			$model->admission_no = 0;
			$model->admission_date = date('Y-m-d');
			$validate = $model->validate();
			$validate1 = $model_1->validate();

			if($validate and $validate1)
			{
				if($model->save()){
                                        //if student have any siblings
					if($model->is_siblings == 'Yes'){
						$model_1->student_id = $model->id;
						if($_FILES['StudentSiblings']['name']['file_name']!=NULL){
							$model_1->file_name = $_FILES['StudentSiblings']['name']['file_name'];
						}
						if($_FILES['StudentSiblings']['type']['file_name']!=NULL){
							$model_1->file_type = $_FILES['StudentSiblings']['type']['file_name'];
						}
						$model_1->type = 1;
						if($model_1->save()){
							if(!is_dir('uploadedfiles/')){
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/online_student_sibling_card/')){
								mkdir('uploadedfiles/online_student_sibling_card/');
							}
							if(!is_dir('uploadedfiles/online_student_sibling_card/'.$model->id)){
								mkdir('uploadedfiles/online_student_sibling_card/'.$model->id);
							}
							$temp_file_loc = $_FILES['StudentSiblings']['tmp_name']['file_name'];
							$destination_file = 'uploadedfiles/online_student_sibling_card/'.$model->id.'/'.$_FILES['StudentSiblings']['name']['file_name'];
							move_uploaded_file($temp_file_loc,$destination_file);
						}
					}else{
						if($model_1->student_id!=NULL){
							$model_1->delete();
						}
					}

					//Save the profile pic to the folder
					if($model->photo_file_name!=NULL){
						if(!is_dir('uploadedfiles/')){
							mkdir('uploadedfiles/');
						}
						if(!is_dir('uploadedfiles/student_profile_image/')){
							mkdir('uploadedfiles/student_profile_image/');
						}
						if(!is_dir('uploadedfiles/student_profile_image/'.$model->id)){
							mkdir('uploadedfiles/student_profile_image/'.$model->id);
						}
						//compress the image
						$info = getimagesize($_FILES['Students']['tmp_name']['photo_data']);
						if($info['mime'] == 'image/jpeg'){
							$image = imagecreatefromjpeg($_FILES['Students']['tmp_name']['photo_data']);
						}elseif($info['mime'] == 'image/gif'){
							$image = imagecreatefromgif($_FILES['Students']['tmp_name']['photo_data']);
						}elseif($info['mime'] == 'image/png'){
							$image = imagecreatefrompng($_FILES['Students']['tmp_name']['photo_data']);
						}
						$temp_file_name = $_FILES['Students']['tmp_name']['photo_data'];
						$destination_file = 'uploadedfiles/student_profile_image/'.$model->id.'/'.$_FILES['Students']['name']['photo_data'];
						imagejpeg($image, $destination_file, 30);
					}

					Yii::app()->user->setState("enrollment_id", $this->encryptToken($model->id));
					$this->redirect(array('step2', 'token'=>$this->encryptToken($model->id)));
				}
			}
		}
		$fields   = FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
		if($model->date_of_birth!=NULL and $settings!=NULL){
			$date1=date($settings->displaydate,strtotime($model->date_of_birth));
			$model->date_of_birth=$date1;
		}
        foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
        }

		$fields   = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
        foreach ($fields as $key => $field) {
			if($field->form_field_type==6){  // date value
				$field_name = $field->varname;
				if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
					$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
				}
				else{
					$model->$field_name=NULL;
				}
			}
        }
		$this->render('step1',array('model'=>$model, 'model_1'=>$model_1,'course'=>$_POST['Students']['course'],'batch_id'=>$_POST['Students']['batch_id']));
	}
//step2 is for storing parent details
	public function actionStep2()
	{
		$roles=Rights::getAssignedRoles(Yii::app()->user->Id);
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		//checking session
		$this->checkAccess($token);

		$student_id	= $this->decryptToken($token);
		$student_data		= Students::model()->findByPk($student_id);
		if($student_data!=NULL)
		{
			if(Yii::app()->user->id!=NULL and key($roles)!=NULL and (key($roles) == 'parent'))
			{
				$model = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));;
				$detailsOfParent = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
				//$model->attributes = $detailsOfParent->attributes;
			}
			elseif($student_data->parent_id==0 and Yii::app()->session['parent_id']==NULL and Yii::app()->user->Id!=NULL and key($roles)!=NULL and (key($roles) == 'Admin'))
			{
				$model=new Guardians;
			}
			elseif($student_data->parent_id==0 and Yii::app()->session['parent_id']==NULL)
			{
				$model=new Guardians;
			}
			elseif($student_data->parent_id!=0)
			{
				$model=Guardians::model()->findByPk($student_data->parent_id);
			}
			elseif(Yii::app()->session['parent_id']!=NULL)
			{
				$model=Guardians::model()->findByPk(Yii::app()->session['parent_id']);
			}
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));

			if(!empty($_POST))
			{
				$model->attributes = $_POST['Guardians'];
				if(isset($_POST['Guardians']['same_address']) and $_POST['Guardians']['same_address']==1){
					$model->same_address			= $_POST['Guardians']['same_address'];
					$model->office_phone1			= $student_data->phone1;
					$model->office_phone2			= $student_data->phone2;
					$model->office_address_line1 	= $student_data->address_line1;
					$model->office_address_line2 	= $student_data->address_line2;
					$model->city 					= $student_data->city;
					$model->state					= $student_data->state;
					$model->country_id				= $student_data->country_id;
				}
				if(isset($_POST['Guardians']['dob']) and $_POST['Guardians']['dob']!=NULL){
					$model->dob = date('Y-m-d',strtotime($_POST['Guardians']['dob']));
				}

				$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
				if($settings!=NULL)
				{
					$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
					date_default_timezone_set($timezone->timezone);

				}

				//dynamic fields
				$fields   = FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
				foreach ($fields as $key => $field) {
					if($field->form_field_type==6){  // date value
						$field_name = $field->varname;
						if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
							$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
						}
					}
				}

				$fields   = FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
				foreach ($fields as $key => $field) {
					if($field->form_field_type==6){  // date value
						$field_name = $field->varname;
						if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
							$model->$field_name = date('Y-m-d',strtotime($model->$field_name));
						}
					}
				}
				$model->created_at = date('Y-m-d H:i:s');
				$validate = $model->validate();
				if($validate)
				{
					if(Yii::app()->user->id!=NULL)
					{
						$is_registered_parent = Guardians::model()->findByAttributes(array('email'=>$detailsOfParent->email));
						if(isset($is_registered_parent) and $is_registered_parent!=NULL)
						{
							$student_data->saveAttributes(array('parent_id'=>$is_registered_parent->id,'is_completed'=>2));
							$is_guardian_list = GuardianList::model()->findByAttributes(array('student_id'=>$student_data->id,'guardian_id'=>$model->id));
							if($is_guardian_list == NULL){
								$guardian_list= new GuardianList;
								$guardian_list->student_id= $student_data->id;
								$guardian_list->guardian_id= $model->id;
								$guardian_list->relation= $model->relation;
								$guardian_list->save();
							}else{
								$is_guardian_list->relation = $model->relation;
								$is_guardian_list->save();
							}
							$this->redirect(array('step3', 'token'=>$this->encryptToken($student_data->id)));
						}
						else
						{
							if($model->save())
							{
								$student_data->saveAttributes(array('parent_id'=>$model->id,'is_completed'=>2));
								$is_guardian_list = GuardianList::model()->findByAttributes(array('student_id'=>$student_data->id,'guardian_id'=>$model->id));
								if($is_guardian_list == NULL){
									$guardian_list= new GuardianList;
									$guardian_list->student_id= $student_data->id;
									$guardian_list->guardian_id= $model->id;
									$guardian_list->relation= $model->relation;
									$guardian_list->save();
								}else{
									$is_guardian_list->relation = $model->relation;
									$is_guardian_list->save();
								}
								$this->redirect(array('step3', 'token'=>$this->encryptToken($student_data->id)));
							}
						}
					}
					elseif(Yii::app()->session['parent_id']==NULL)
					{
						if($model->save())
						{
							$student_data->saveAttributes(array('parent_id'=>$model->id,'is_completed'=>2));
							$is_guardian_list = GuardianList::model()->findByAttributes(array('student_id'=>$student_data->id,'guardian_id'=>$model->id));
							if($is_guardian_list == NULL){
								$guardian_list= new GuardianList;
								$guardian_list->student_id= $student_data->id;
								$guardian_list->guardian_id= $model->id;
								$guardian_list->relation= $model->relation;
								$guardian_list->save();
							}else{
								$is_guardian_list->relation = $model->relation;
								$is_guardian_list->save();
							}
							$this->redirect(array('step3', 'token'=>$this->encryptToken($student_data->id)));
						}
					}
					else
					{
						$student_data->saveAttributes(array('parent_id'=>Yii::app()->session['parent_id'],'is_completed'=>2));
						$is_guardian_list = GuardianList::model()->findByAttributes(array('student_id'=>$student_data->id,'guardian_id'=>$model->id));
						if($is_guardian_list == NULL){
							$guardian_list= new GuardianList;
							$guardian_list->student_id= $student_data->id;
							$guardian_list->guardian_id= $model->id;
							$guardian_list->relation= $model->relation;
							$guardian_list->save();
						}else{
							$is_guardian_list->relation = $model->relation;
							$is_guardian_list->save();
						}
						$this->redirect(array('step3', 'token'=>$this->encryptToken($student_data->id)));
					}
				}
			}
			$fields   = FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
					}
					else{
						$model->$field_name=NULL;
					}
				}
			}

			$fields   = FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type==6){  // date value
					$field_name = $field->varname;
					if($model->$field_name!=NULL and $model->$field_name!="0000-00-00" and $settings!=NULL){
						$model->$field_name = date($settings->displaydate,strtotime($model->$field_name));
					}
					else{
						$model->$field_name=NULL;
					}
				}
			}
			$this->render('step2',array('model'=>$model));
		}
		else
		{
			throw new CHttpException(404,Yii::t('app','Your datas not found.'));
		}
	}
//Step3 is for storing student documents
	public function actionStep3()
	{

		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		//checking session
		$this->checkAccess($token);

		$student_id	= $this->decryptToken($token);
		$student_data		= Students::model()->findByPk($student_id);
		//echo $_POST['CenterUploads']['sid'];exit;
		$model=new StudentDocument;
		$flag = 1;
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types
		$files_not_saved = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StudentDocument']))
		{

			$list = $_POST['StudentDocument'];
			$no_of_documents = count($list['title']); // Counting the number of files uploaded (No of rows in the form)
			for($i=0;$i<$no_of_documents;$i++) //Iterating the documents uploaded
			{
				$studentDocumentList = StudentDocumentList::model()->findByAttributes(array('id'=>$_POST['StudentDocument']['title'][$i]));
				$value = explode('.',$_FILES['StudentDocument']['name']['file'][$i]);
				$model=new StudentDocument;
				$model->student_id = $student_id;
				if($studentDocumentList){
					$model->doc_type = $studentDocumentList->name;
				}
				$model->is_approved = 1;
				$model->title = $_POST['StudentDocument']['title'][$i];
				$extension = end($value); // Get extension of the file
				$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
				$model->file_type = $_FILES['StudentDocument']['type']['file'][$i];

				$file_size = $_FILES['StudentDocument']['size']['file'][$i];
				if($model->student_id!='' and $model->title!='' and $model->file!='' and $model->file_type!='') // Checking if Document name and file is uploaded
				{
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{
						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/student_document/')) // Creating student_document directory
							{
								mkdir('uploadedfiles/student_document/');
							}
							if(!is_dir('uploadedfiles/student_document/'.$model->student_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/student_document/'.$model->student_id);
							}
							$temp_file_loc = $_FILES['StudentDocument']['tmp_name']['file'][$i];
							$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;
							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								if($model->save()) // Saving the model to database
								{
									$flag = 1;
								}
								else // If model not saved
								{

									$flag = 0;
									if(file_exists($destination_file))
									{
										unlink($destination_file);
									}
									$files_not_saved = $files_not_saved.', '.$model->file;
									Yii::app()->user->setFlash('errorMessage',Yii::t('app','File(s)').' '.$files_not_saved.' '.Yii::t('app','was not saved to the database. Please try again.'));
									continue;
								}
							}
							else // If file not saved to the directory
							{
								$flag = 0;
								$files_not_saved = $files_not_saved.', '.$model->file;
								Yii::app()->user->setFlash('errorMessage',Yii::t('app','File(s)').' '.$files_not_saved.' '.Yii::t('app','was not saved. Please try again.'));
								continue;
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage',Yii::t('app','File size must not exceed 5MB!'));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','Only files with these extensions are allowed: jpg, png, pdf, doc, txt.'));
					}
				}
				elseif($model->title=='' and $model->file_type!='') // If document name is empty
				{
					$flag = 0;
					Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document Name cannot be empty!'));
					//$this->redirect(array('create','model'=>$model,'id'=>$_REQUEST['id']));
				}
				elseif($model->title!='' and $model->file_type=='') // If file is not selected
				{
					$flag = 0;
					Yii::app()->user->setFlash('errorMessage',Yii::t('app','File is not selected!'));

				}
				elseif($model->student_id=='' and $model->title=='' and $model->file=='' and $model->file_type=='')
				{
					$flag=1;
				}
			}
			if($flag == 1) // If no errors, go to next step of the student registration
			{
				//$this->redirect(array('view','id'=>$model->id));
				if($_POST['StudentDocument']['document']==1)
				{
					$this->redirect(array('step3','token'=>$this->encryptToken($student_data->id)));
				}
				else
				{

					$this->redirect(array('registration/documentView','token'=>$this->encryptToken($student_data->id)));
				}
			}
			else // If errors are present, redirect to the same page
			{
				if($_POST['StudentDocument']['document']==1)
				{
					$this->redirect(array('step3','token'=>$this->encryptToken($student_data->id)));
				}
				else
				{
					$this->redirect(array('step3','token'=>$this->encryptToken($student_data->id)));
				}
			}
		} // END isset

		$this->render('step3',array(
			'model'=>$model,'token'=>$this->encryptToken($student_data->id),
		));
	}
//Registration step finished
	public function actionFinish(){
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		//checking session
		$this->checkAccess($token);

		$student_id	= $this->decryptToken($token);
		$student_data	=	Students::model()->findByPk($student_id);
		$student_data->saveAttributes(array('is_completed'=>3));
		$parent_details	=	Guardians::model()->findByPk($student_data->parent_id);
		if($student_data!=NULL and $parent_details!=NULL){
			Yii::app()->user->setState("enrollment_id",'');
			Yii::app()->session->remove('parent_id');
		//mail
			Students::model()->sendRegistrationMail($student_data->id);

			$this->render('finish', array('model'=>$student_data));
		}
		else{
			throw new CHttpException(404,Yii::t('app','Your datas not found.'));
		}
	}
//Edit the uploaded documents during registration
	public function actionDocumentUpdate()
	{
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		//checking session
		$this->checkAccess($token);

		$student_id	= $this->decryptToken($token);
		$student_data	=	Students::model()->findByPk($student_id);
		$model = StudentDocument::model()->findByPk($_REQUEST['document_id']);
		$old_model = $model->attributes;
		$flag = 1; // If 1, no errors. If 0, some error is present.
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['StudentDocument']))
		{
			$list = $_POST['StudentDocument'];

			$studentDocumentList = StudentDocumentList::model()->findByAttributes(array('id'=>$list['title']));
			if($studentDocumentList){
				$model->doc_type = $studentDocumentList->name;
			}

			$model->student_id = $student_id;
			$model->title = $list['title'];
			if($model->title!=NULL and $model->student_id!=NULL)
			{
				if($_FILES['StudentDocument']['name']['file']!=NULL)
				{
					$value = explode('.',$_FILES['StudentDocument']['name']['file']);
					$extension = end($value); // Get extension of the file
					$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
					$model->file_type = $_FILES['StudentDocument']['type']['file'];
					$file_size = $_FILES['StudentDocument']['size']['file'];
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{
						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/student_document/')) // Creating student_document directory
							{
								mkdir('uploadedfiles/student_document/');
							}
							if(!is_dir('uploadedfiles/student_document/'.$model->student_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/student_document/'.$model->student_id);
							}
							$temp_file_loc = $_FILES['StudentDocument']['tmp_name']['file'];
							$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;

							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								$flag = 1;

							}
							else // If file not saved to the directory
							{
								$flag = 0;
								Yii::app()->user->setFlash('errorMessage',Yii::t('app','File').' '.$model->file.' '.Yii::t('app','was not saved. Please try again.'));
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage',Yii::t('app','File size must not exceed 5MB!'));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','Only files with these extensions are allowed: jpg, png, pdf, doc, txt.'));
					}
				}
				else // No files selected
				{
					if($old_model['file']!=NULL and $list['new_file_field']==1)
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','No file selected!'));
					}

				}
			}
			else // No title entered
			{
				$flag = 0;
				Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document Name cannot be empty!'));
			}


			if($flag == 1) // Valid data
			{
				if($model->save())
				{
					if($_FILES['OnlineStudentDocument']['name']['file']!=NULL)
					{
						$old_destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$old_model['file'];
						if(file_exists($old_destination_file))
						{
							unlink($old_destination_file);
						}
					}
					$this->redirect(array('registration/step3','token'=>$this->encryptToken($student_data->id)));
				}
				else
				{

					Yii::app()->user->setFlash('errorMessage',Yii::t('app','Cannot update the document now. Try again later.'));
					$this->redirect(array('documentUpdate','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				}

			}
			else
			{
				$this->redirect(array('documentUpdate','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				/*$this->render('update',array(
					'model'=>$model,'student_id'=>$_REQUEST['id']
				));*/

			}
		}

		$this->render('update',array(
			'model'=>$model,'token'=>$this->encryptToken($student_data->id),
		));
	}
//Downloading the student document during registration
	public function actionDownload()
	{
		if(isset($_GET['token']))
		{
			$token		= isset($_GET['token'])?$_GET['token']:NULL;
			//checking session
			$this->checkAccess($token);
			$student_id	= $this->decryptToken($token);
		}
		elseif($_REQUEST['student_id'])
		{
			$student_id = $_REQUEST['student_id'];
		}
		$model=StudentDocument::model()->findByPk($_REQUEST['id']);
		$file_path = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;
		$file_content = file_get_contents($file_path);
		$model->title = str_replace(' ','',$model->title);
		header("Content-Type: ".$model->file_type);
		header("Content-disposition: attachment; filename=".$model->title);
		header("Pragma: no-cache");
		echo $file_content;
		exit;
	}

//Deleteing the student document during registration
	public function actionDeletes()
	{
		if(isset($_GET['token']))
		{
			$token		= isset($_GET['token'])?$_GET['token']:NULL;
			//checking session
			$this->checkAccess($token);
			$student_id	= $this->decryptToken($token);
		}
		elseif($_REQUEST['student_id'])
		{
			$student_id = $_REQUEST['student_id'];
		}
		$model=StudentDocument::model()->findByPk($_REQUEST['document_id']);
		$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;
		if(file_exists($destination_file))
		{
			if(unlink($destination_file))
			{
				$model->delete();
				Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document deleted successfully!'));
			}
		}
		if(isset($_GET['token']))
		{
			$this->redirect(array('registration/step3','token'=>$this->encryptToken($student_id)));
		}
		else
		{
			$this->redirect(array('registration/status'));
		}
	}

	public function actionDocumentView()
	{
		$model = OnlineStudentDocument::model()->findByAttributes(array('student_id'=>$id));
		$this->render('view',array(
			'model'=>$model,
			'id'=>$id
		));
	}

	public function actionLogout()
	{
		$model = new ApplicationStatus;
		if(Yii::app()->session['profile'])
		{
			Yii::app()->session->remove('profile');
		}
		$this->redirect(array('index'));
	}

	public function actionSuccess()
	{
		$this->render('success');
	}

	public function actionStatus()
	{

		$this->render('status');
	}

	public function actionView()
	{

		$roles=Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
		foreach($roles as $role)
		{
			if(sizeof($roles)==1 and $role->name == 'Admin')
			{
				$this->layout = '//layouts/column2';
				$model = RegisteredStudents::model()->findByAttributes(array('id'=>$_REQUEST['id']));
				$model_1 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id));
				$model_2 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id_2));
				$this->render('view',array('model'=>$model,'model_1'=>$model_1,'model_2'=>$model_2));
			}
			else
			{
				throw new CHttpException(404,Yii::t('app','The page cannot be found.'));
			}
		}
	}



	/*
	* Function to generate Registration ID
	*/
	private function getRegistrationId()
	{
		$adm_no = Yii::app()->db->createCommand()
				  ->select("MAX(CAST(registration_id AS UNSIGNED)) as `max_adm_no`")
				  ->from('students')
				  ->where('is_online=:is_online', array(':is_online'=>1))
				  ->queryRow();

		//$lastId = Students::model()->lastRecord()->find();

		if($adm_no['max_adm_no']!=0)
		{
			$regId = $adm_no['max_adm_no']+1;
		}
		else
		{
			$regIdStart = OnlineRegisterSettings::model()->findByPk(3);
			$regId = $regIdStart->config_value;

		}

		return $regId;
	}



	/**
	* Approve Registered Student
	*/
	public function actionApprove()
	{
		$model = RegisteredStudents::model()->findByAttributes(array('id'=>$_REQUEST['id']));


		// Flag to know if we will render the form or try to add
        // new jon.
        $flag=true;


		if(!empty($_POST))
		{

			RegisteredStudents::model()->approveProcess($_POST['RegisteredStudents']['id'],$_POST['batch']);
			echo CJSON::encode(array(
                        'status'=>'success',
                        ));
             exit;
		}
		if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('approve',array('model'=>$model),false,true);
		}
	}





	/**
	* Disapprove Registered Student
	*/
	public function actionDisapprove()
	{
		$model = RegisteredStudents::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$parent1 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id));
		$model->saveAttributes(array('status'=>-1,'agent'=>Yii::app()->user->id));
		$notification = NotificationSettings::model()->findByAttributes(array('id'=>15));
		$college=Configurations::model()->findByPk(1);
		if($notification->mail_enabled == '1' or $notification->sms_enabled == '1')
		{
		//Mail to student
			if($notification->student == '1' and $notification->mail_enabled == '1')
			{
				$studentemail = EmailTemplates::model()->findByPk(43);
				$studentemail2 = EmailTemplates::model()->findByPk(44);
				$subject = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$studentemail->template);
				$message = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$studentemail2->template);
				UserModule::sendMail($model->email,strip_tags($subject),$message);
			}
		//Send sms
			if($notification->student == '1' and $notification->sms_enabled == '1')
			{
				$college=Configurations::model()->findByPk(1);
				$from = $college->config_value;
				$sms_template = SystemTemplates::model()->findByAttributes(array('id'=>31));
				$sms_message = $sms_template->template;
				SmsSettings::model()->sendSms($model->phone1,$from,$sms_message);
			}

		//Mail to parent 1
			if($notification->parent_1 == '1' and $notification->mail_enabled == '1')
			{
				$parent1email = EmailTemplates::model()->findByPk(39);
				$parent1email2 = EmailTemplates::model()->findByPk(40);
				$subject1 = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$parent1email->template);
				$message1 = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$parent1email2->template);
				$message1 = str_replace("{{STUDENT NAME}}",ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name),$message1);
				UserModule::sendMail($parent1->email,strip_tags($subject1),$message1);
			}
		//Send sms
			if($notification->parent_1 == '1' and $notification->sms_enabled == '1')
			{
				$college=Configurations::model()->findByPk(1);
				$from = $college->config_value;
				$sms_template = SystemTemplates::model()->findByAttributes(array('id'=>30));
				$sms_message = $sms_template->template;
				SmsSettings::model()->sendSms($parent1->mobile_phone,$from,$sms_message);
			}

		//Mail to parent 2
			if($model->parent_id_2!=0 and $notification->parent_2 == '1' and $notification->mail_enabled == '1')
			{
				$parent2 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id_2));
				$parent2email = EmailTemplates::model()->findByPk(39);
				$parent2email2 = EmailTemplates::model()->findByPk(40);
				$subject2 = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$parent2email->template);
				$message2 = str_replace("{{SCHOOL}}",ucfirst($college->config_value),$parent2email2->template);
				$message2 = str_replace("{{STUDENT NAME}}",ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name),$message2);
				UserModule::sendMail($parent2->email,strip_tags($subject2),$message2);
			}

		//Send sms
			if($model->parent_id_2!=0 and $notification->parent_2 == '1' and $notification->sms_enabled == '1')
			{
				$parent2 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id_2));
				$college=Configurations::model()->findByPk(1);
				$from = $college->config_value;
				$sms_template = SystemTemplates::model()->findByAttributes(array('id'=>30));
				$sms_message = $sms_template->template;
				SmsSettings::model()->sendSms($parent2->mobile_phone,$from,$sms_message);
			}


		}

		Yii::app()->user->setFlash('successMessage', Yii::t('app','Action performed successfully'));
		if($_REQUEST['flag']==1)
		{
			$this->redirect(array('onlineapplicants'));
		}
		else
		{
			$this->redirect(array('approval'));
		}
	}

	/**
	* Delete Registered Student
	*/
	public function actionDelete()
	{
		$model = RegisteredStudents::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$parent_1 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id));
		if($model->parent_id_2!=0)
		{
			$parent_2 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id_2));
			$parent_2->delete();
		}
		//$model->saveAttributes(array('status'=>-2,'is_deleted'=>1));
		$parent_1->delete();
		$model->delete();
		Yii::app()->user->setFlash('successMessage', Yii::t('app','Action performed successfully'));
		if($_REQUEST['flag']==1)
		{
			$this->redirect(array('onlineapplicants'));
		}
		else
		{
			$this->redirect(array('approval'));
		}

	}

	public function actionRemove()
	{
		if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL){
			$student_id = $_REQUEST['id'];
		}else{
			$token		= isset($_GET['token'])?$_GET['token']:NULL;
			//checking session
			$this->checkAccess($token);
			$student_id	= $this->decryptToken($token);
		}
		$model = Students::model()->findByAttributes(array('id'=>$student_id));
		$file_name = $model->photo_file_name;
		if($model->saveAttributes(array('photo_file_name'=>''))){
			$path = 'uploadedfiles/student_profile_image/'.$model->id.'/'.$file_name;
			if(file_exists($path)){
				unlink($path);
			}
		}
		if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL){
			$this->redirect(array('edit'));
		}else{
			$this->redirect(array('step1','token'=>$this->encryptToken($student_id)));
		}
	}
	public function actionDisplaySavedImage()
		{
			$model=$this->loadModel($_GET['id']);
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-length: '.$model->photo_file_size);
			header('Content-Type: '.$model->photo_content_type);
			header('Content-Disposition: attachment; filename='.$model->photo_file_name);
			echo $model->photo_data;
		}
	public function loadModel($id)
	{
		$model=RegisteredStudents::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	public function actionChechclassavailability()
	{
			$flag = 0;
			$batch_id = $_POST['batchId'];
		if(isset($_POST['batchId']) and $_POST['batchId']!=NULL and $_POST['batchId']!='')
		{
			$criteria = new CDbCriteria;
            $criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
            $criteria->params[':is_deleted'] = 0;
            $criteria->params[':is_active'] = 1;


            $batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$batch_id,'status'=>1));
            if($batch_students)
            {
             $count = count($batch_students);
             $criteria->condition = $criteria->condition.' AND (';
             $i = 1;
             foreach($batch_students as $batch_student)
             {

              $criteria->condition = $criteria->condition.' id=:student'.$i;
              $criteria->params[':student'.$i] = $batch_student->student_id;
              if($i != $count)
              {
               $criteria->condition = $criteria->condition.' OR ';
              }
              $i++;

             }
             $criteria->condition = $criteria->condition.')';
            }
            else
            {
             $criteria->condition = $criteria->condition.' AND batch_id=:batch_id';
             $criteria->params[':batch_id'] = $batch_id;
            }


            $posts=Students::model()->findAll($criteria);
            $student_count = count($posts);
			$current_academic_yr = AcademicYears::model()->findByAttributes(array('status'=>1));
			$room = ClassRoomAssociation::model()->findAllByAttributes(array('batch_id'=>$batch_id,'academic_year_id'=>$current_academic_yr->id));
			if($room==NULL)
			{
				$flag = 2;
			}
			if($flag!=2)
			{
				foreach($room as $rooms)
				{
					$capacity = ClassRooms::model()->findByAttributes(array('id'=>$rooms->room_id));
					if($student_count>=$capacity->capacity)
					{
						$flag = 1;
					}

				}
			}
			$all_students = Students::model()->findAllByAttributes(array('batch_id'=>$batch_id,'is_active'=>1,'is_deleted'=>0));
			$current_student_no = count($all_students);
			if($flag == 0)
			{
				echo Yii::t('app','Available+Maximum Students :').' '.$capacity->capacity.Yii::t('app','+Current student no :').' '.$current_student_no;
			}
			elseif($flag == 1)
			{
				//echo "Class room Filled. Select another BATCH";
				echo Yii::t('app','Class room Filled+Maximum Students :').' '.$capacity->capacity.Yii::t('app','+Current student no :').' '.$current_student_no;
			}
			else
			{
				echo Yii::t('app','No class room alloted+Maximum Students :').' '.$capacity->capacity.Yii::t('app','+Current student no :').' '.$current_student_no;
			}
		}
		else
		{
			echo Yii::t('app','nil');
		}

	}

	public function actionOld()
	{
		$parent_uid = $_REQUEST['loginedParentUid'];
		$room = Guardians::model()->findAllByAttributes(array('uid'=>$parent_uid));
		var_dump($room);exit;
	}

	public function actionProfileedit()
	{
		$this->layout = '//layouts/column2';
		$model = RegisteredStudents::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$model_1 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id));
		$p1_present = 0;
		$p2_present = 0;
		$p1_valid = 0;
		if($model_1)
		{
			$p1_present = 1;
		}

		$model_2 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->parent_id_2));
		if($model_2)
		{
			$p2_present = 1;
		}
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if($settings!=NULL)
		{
			$model->date_of_birth=date($settings->displaydate,strtotime($model->date_of_birth));


		}
		if(!empty($_POST))
		{
			/*$model = RegisteredStudents::model()->findByAttributes(array('id'=>Yii::app()->session['profile']));
			$model_1 = RegisteredGuardians::model()->findByAttributes(array('id'=>$model->id));*/

			$model->attributes = $_POST['RegisteredStudents'];
			$model_1->attributes = $_POST['RegisteredGuardians'][1];
			$model_2->attributes = $_POST['RegisteredGuardians'][2];
			if($model->date_of_birth)
				$model->date_of_birth = date('Y-m-d',strtotime($model->date_of_birth));
			if(isset($_POST['RegisteredGuardians'][1]['dob']))
			{
				$model_1->dob = date('Y-m-d',strtotime($_POST['RegisteredGuardians'][1]['dob']));
			}
			if(isset($_POST['RegisteredGuardians'][2]['dob']))
			{
				$model_2->dob = date('Y-m-d',strtotime($_POST['RegisteredGuardians'][2]['dob']));
			}
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
			if($settings!=NULL)
			{
				$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
				date_default_timezone_set($timezone->timezone);

			}

			$model->updated_at = date('Y-m-d H:i:s');
			$model_1->updated_at = date('Y-m-d H:i:s');
			if($file=CUploadedFile::getInstance($model,'photo_data'))
			 {
				$model->photo_file_name=$file->name;
				$model->photo_content_type=$file->type;
				$model->photo_file_size=$file->size;
				$model->photo_data=file_get_contents($file->tempName);
      		  }
			$model->validate();

			if($p1_present==1)
			{
				$model_1->validate();
				$p1_valid = 1;
			}

			if($model->validate())
			{
				if(($model->save()))
				{
					$p1_save = 0;
					if($p1_valid == 1)
					{

						if($model_1->save())
						{
							$p1_save = 1;
						}
					}
					if(isset($model_2->attributes) and $model_2->attributes!=NULL and $p2_present==1 and $p1_save==1)
					{
						if($model_2->validate())
						{
							if($model_2->save());
							{
								$this->redirect(array('view','id'=>$model->id));

							}
						}
					}
					else
					{
						$this->redirect(array('view','id'=>$model->id));
						exit;
					}
				}
			}

		}
		$this->render('profileedit',array('model'=>$model,'model_1'=>$model_1,'model_2'=>$model_2));
	}

	//Email check
	public function actionEmailcreate(){
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $firstName.$lastName;
		$finalemail =  $this->emailcheck($email);
		$this->renderPartial('emailcreate',array(
			 'email'=>$finalemail)
		);

	}
	public function emailcheck($email, $step=0)
	{
		$tmp_email	= $email;
		if($step!=0){
			$tmp_email	= $email.'_'.$step;
		}
		$tmp_email	.= '@madressa.net';
		$student = Students::model()->findByAttributes(array('email'=>$tmp_email));
		$user = User::model()->findByAttributes(array('email'=>$tmp_email));
		if($student==NULL and $user==NULL)
		{
			return $tmp_email;
		}
		else
		{
			$step++;
			return $this->emailcheck($email, $step);
		}
	}
	public function actionShowImage()
	{
			//$model=$this->loadModel($_GET['id']);
		 	$model=Logo::model()->findByPk($_GET['id']);
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-length: '.$model->photo_file_size);
			header('Content-Type: '.$model->photo_content_type);
			header('Content-Disposition: attachment; filename='.$model->photo_file_name);
			echo  $model->photo_data;
	}

	public function actionCalculateYear()
	{

		if(isset($_POST['RegisteredStudents']))
		{
			$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
			if(Yii::app()->user->year)
			{
				$yr = Yii::app()->user->year;

			}
			else
			{
				$yr = $current_academic_yr->config_value;
			}

			$start_year = AcademicYears::model()->findByAttributes(array('id'=>$yr));
			$start_year = date('Y',strtotime($start_year->start));

			$dob = date('Y-m-d',strtotime($_POST['RegisteredStudents']['date_of_birth']));
			$from = new DateTime($dob);
			$cut_off = $start_year.'-6-30';
			$to = new DateTime($cut_off);
			$age = $from->diff($to)->y;
			$criteria = new CDbCriteria;
			//$criteria->condition='(:age BETWEEN max_age AND min_age)';
			$criteria->condition= 'min_age <= :age and max_age >= :age';
			$criteria->params = array(':age'=>$age);
			$year = StudentCalculatedYear::model()->find($criteria);

			if($year)
			{
				echo CHtml::encode($year->year);
			}
			else
			{
				echo CHtml::encode(Yii::t('app','Not Eligible'));
			}
		}

	}
	protected function encryptToken($token){
		$salt	= rand(5, 9);
		for($i=0; $i<$salt; $i++){
			$token	= strrev(base64_encode($token));
		}
		$token	.= rand(1000, 9999);
		$token	.= $salt;
		return $token;
	}

	protected function decryptToken($token){
		$salt 	= substr($token, -1);
		$token	= substr_replace($token, "", -5);
		for($i=0; $i<$salt; $i++){
			$token	= base64_decode(strrev($token));
		}
		return $token;
	}

	protected function checkAccess($token){
		if(!(Yii::app()->user->hasState("enrollment_id") and $this->decryptToken(Yii::app()->user->getState("enrollment_id"))==$this->decryptToken($token))){
			$this->redirect(array('/user/login'));
		}
	}

	private function generateRandomString($length = 5)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function actionAddrow()
	{
		$model=new StudentDocument;
		$result = $this->renderPartial('_ajaxform', array('model'=>$model,'id'=>$_REQUEST['id']),true,true);
		echo json_encode($result);
		Yii::app()->end();
	}
//editing the student document after registration and before approve
	public function actionStdDocEdit()
	{
		$token		= isset($_GET['token'])?$_GET['token']:NULL;

		$student_id	= $this->decryptToken($token);
		$student_data	=	Students::model()->findByPk($student_id);
		$model = StudentDocument::model()->findByPk($_REQUEST['document_id']);
		$old_model = $model->attributes;
		$flag = 1; // If 1, no errors. If 0, some error is present.
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['StudentDocument']))
		{
			$list = $_POST['StudentDocument'];
			$studentDocumentList = StudentDocumentList::model()->findByAttributes(array('id'=>$list['title']));
			if($studentDocumentList){
				$model->doc_type = $studentDocumentList->name;
			}
			$model->student_id = $student_id;
			$model->title = $list['title'];
			if($model->title!=NULL and $model->student_id!=NULL)
			{
				if($_FILES['StudentDocument']['name']['file']!=NULL)
				{
					$value = explode('.',$_FILES['StudentDocument']['name']['file']);
					$extension = end($value); // Get extension of the file
					$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
					$model->file_type = $_FILES['StudentDocument']['type']['file'];
					$file_size = $_FILES['StudentDocument']['size']['file'];
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{
						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/student_document/')) // Creating student_document directory
							{
								mkdir('uploadedfiles/student_document/');
							}
							if(!is_dir('uploadedfiles/student_document/'.$model->student_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/student_document/'.$model->student_id);
							}
							$temp_file_loc = $_FILES['StudentDocument']['tmp_name']['file'];
							$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;

							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								$flag = 1;

							}
							else // If file not saved to the directory
							{
								$flag = 0;
								Yii::app()->user->setFlash('errorMessage',Yii::t('app','File').' '.$model->file.' '.Yii::t('app','was not saved. Please try again.'));
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage',Yii::t('app','File size must not exceed 5MB!'));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','Only files with these extensions are allowed: jpg, png, pdf, doc, txt.'));
					}
				}
				else // No files selected
				{
					if($old_model['file']!=NULL and $list['new_file_field']==1)
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','No file selected!'));
					}

				}
			}
			else // No title entered
			{
				$flag = 0;
				Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document Name cannot be empty!'));
			}


			if($flag == 1) // Valid data
			{
				if($model->save())
				{
					if($_FILES['StudentDocument']['name']['file']!=NULL)
					{
						$old_destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$old_model['file'];
						if(file_exists($old_destination_file))
						{
							unlink($old_destination_file);
						}
					}
					if(Yii::app()->user->id!=NULL)
					{
						$this->redirect(array('registration/status','id'=>$model->student_id,'from'=>'parent'));
					}
					else
					{
						$this->redirect(array('registration/status'));
					}
				}
				else
				{

					Yii::app()->user->setFlash('errorMessage',Yii::t('app','Cannot update the document now. Try again later.'));
					$this->redirect(array('stdDocEdit','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				}

			}
			else
			{
				$this->redirect(array('stdDocEdit','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				/*$this->render('update',array(
					'model'=>$model,'student_id'=>$_REQUEST['id']
				));*/

			}
		}

		$this->render('stdDocEdit',array(
			'model'=>$model,'token'=>$this->encryptToken($student_data->id),
		));
	}
	public function actionMissingDocEdit()
	{
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		$doc_id = $_REQUEST['document_id'];
		$doclist = StudentDocumentList::model()->findByPk($doc_id);
		$student_id	= $this->decryptToken($token);

		$student_data	=	RegisteredStudents::model()->findByPk($student_id);
		$model=new StudentDocument;
		//$old_model = $model->attributes;
		$flag = 1; // If 1, no errors. If 0, some error is present.
		$valid_file_types = array('image/jpeg','image/png','application/pdf','application/msword','text/plain'); // Creating the array of valid file types


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['StudentDocument']))
		{

			$list = $_POST['StudentDocument'];
			//var_dump($list);exit;
			$model->student_id = $student_id;
			$model->title = $list['title'];
			$model->doc_type = $doclist->name;
			$model->is_approved = 1;
			if($model->title!=NULL and $model->student_id!=NULL)
			{
				if($_FILES['StudentDocument']['name']['file']!=NULL)
				{
					$value = explode('.',$_FILES['StudentDocument']['name']['file']);
					$extension = end($value); // Get extension of the file
					$model->file = $this->generateRandomString(rand(6,10)).'.'.$extension; // Generate random string as filename
					$model->file_type = $_FILES['StudentDocument']['type']['file'];
					$file_size = $_FILES['StudentDocument']['size']['file'];
					if(in_array($model->file_type,$valid_file_types)) // Checking file type
					{
						if($file_size <= 5242880) // Checking file size
						{
							if(!is_dir('uploadedfiles/')) // Creating uploaded file directory
							{
								mkdir('uploadedfiles/');
							}
							if(!is_dir('uploadedfiles/student_document/')) // Creating student_document directory
							{
								mkdir('uploadedfiles/student_document/');
							}
							if(!is_dir('uploadedfiles/student_document/'.'online_'.$model->student_id)) // Creating student directory for saving the files
							{
								mkdir('uploadedfiles/student_document/'.'online_'.$model->student_id);
							}
							$temp_file_loc = $_FILES['StudentDocument']['tmp_name']['file'];
							$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;

							if(move_uploaded_file($temp_file_loc,$destination_file)) // Saving the files to the folder
							{
								$flag = 1;

							}
							else // If file not saved to the directory
							{
								$flag = 0;
								Yii::app()->user->setFlash('errorMessage',Yii::t('app','File').' '.$model->file.' '.Yii::t('app','was not saved. Please try again.'));
							}
						}
						else // If file size is too large. Greater than 5 MB
						{
							$flag = 0;
							Yii::app()->user->setFlash('errorMessage',Yii::t('app','File size must not exceed 5MB!'));
						}
					}
					else // If file type is not valid
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','Only files with these extensions are allowed: jpg, png, pdf, doc, txt.'));
					}
				}
				else // No files selected
				{
					if($old_model['file']!=NULL and $list['new_file_field']==1)
					{
						$flag = 0;
						Yii::app()->user->setFlash('errorMessage',Yii::t('app','No file selected!'));
					}

				}
			}
			else // No title entered
			{
				$flag = 0;
				Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document Name cannot be empty!'));
			}


			if($flag == 1) // Valid data
			{
				if($model->save())
				{
					if($_FILES['StudentDocument']['name']['file']!=NULL)
					{
						$old_destination_file = 'uploadedfiles/student_document/'.'online_'.$model->student_id.'/'.$old_model['file'];
						if(file_exists($old_destination_file))
						{
							unlink($old_destination_file);
						}
					}
					if(Yii::app()->user->id!=NULL)
					{
						$this->redirect(array('registration/status','id'=>$model->student_id,'from'=>'parent'));
					}
					else
					{
						$this->redirect(array('registration/status'));
					}
				}
				else
				{

					Yii::app()->user->setFlash('errorMessage',Yii::t('app','Cannot update the document now. Try again later.'));
					$this->redirect(array('missingDocEdit','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				}

			}
			else
			{
				$this->redirect(array('missingDocEdit','token'=>$this->encryptToken($student_data->id),'document_id'=>$_REQUEST['document_id']));
				/*$this->render('update',array(
					'model'=>$model,'student_id'=>$_REQUEST['id']
				));*/

			}


			}


		$this->render('missingDocEdit',array(
			'model'=>$model,'token'=>$this->encryptToken($student_data->id),
		));
	}
	//Downloading the student document from status checking profile
	public function actionstdDocDownload()
	{
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		$student_id	= $this->decryptToken($token);

		$model=StudentDocument::model()->findByPk($_REQUEST['id']);
		$file_path = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;
		$file_content = file_get_contents($file_path);
		$model->title = str_replace(' ','',$model->title);
		header("Content-Type: ".$model->file_type);
		header("Content-disposition: attachment; filename=".$model->title);
		header("Pragma: no-cache");
		echo $file_content;
		exit;
	}

//Deleteing the student document from status checking profile
	public function actionstdDocDelete()
	{
		$token		= isset($_GET['token'])?$_GET['token']:NULL;
		$student_id	= $this->decryptToken($token);

		$model=StudentDocument::model()->findByPk($_REQUEST['document_id']);
		$destination_file = 'uploadedfiles/student_document/'.$model->student_id.'/'.$model->file;
		if(file_exists($destination_file))
		{
			if(unlink($destination_file))
			{
				$model->delete();
				Yii::app()->user->setFlash('errorMessage',Yii::t('app','Document deleted successfully!'));
			}
		}
		if(Yii::app()->user->id!=NULL)
		{
			$this->redirect(array('registration/status','id'=>$model->student_id,'from'=>'parent'));
		}
		else
		{
			$this->redirect(array('registration/status'));
		}
	}

	public function actionDisplaybatch()
	{
		$criteria=new CDbCriteria;
		$criteria->condition = "is_deleted =:x AND is_active=:y AND course_id=:course_id";
		$criteria->params = array(':x'=>'0',':y'=>'1',':course_id'=>$_REQUEST['course']);
		//$criteria->order = 'last_name ASC';
		$batches = Batches::model()->findAll($criteria);
		$batches=CHtml::listData($batches,'id','name');

	   echo "<option value=''>".Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")."</option>";
	   foreach($batches as $value=>$batcheName)
	   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($batcheName),true);

	}


}