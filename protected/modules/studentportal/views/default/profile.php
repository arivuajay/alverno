<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic' rel='stylesheet' type='text/css'>
<style>
.sp_col{
  border-bottom:1px #eee solid;
  padding-bottom:8px;
}
</style>

<script>
	function getstudent() // Function to see student profile
	{
		var studentid = document.getElementById('studentid').value;
		if(studentid!='')
		{
			window.location= 'index.php?r=parentportal/default/studentprofile&id='+studentid;	
		}
		else
		{
			window.location= 'index.php?r=parentportal/default/studentprofile';
		}
	}
</script>
<?php $this->renderPartial('leftside');?>
<?php    
	$student=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $guard = Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));


    $student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentPortal');
    $guardian_visible_fields  = FormFields::model()->getVisibleFields('Guardians', 'forStudentPortal');

    ?>

<div class="pageheader">
  <div class="col-lg-8">
    <h2><i class="fa fa-user"></i><?php echo Yii::t('app','Profile');?><span><?php echo Yii::t('app','View your profile here'); ?> <?php echo CHtml::link('<span>'.Yii::t('app','Edit Profile').'</span>',array('editprofile'),array('class'=>'addbttn last'));?></span></h2>
  </div>
  <div class="col-lg-2">
    <?php if(count($students)==1 or (isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)) // Show drop down only if more than 1 student present
        {
        echo CHtml::dropDownList('sid','',$student_list,array('prompt'=>Yii::t('app','Select Student'),'id'=>'studentid','class'=>'form-control input-sm mb14','style'=>'width:auto;','options'=>array($_REQUEST['id']=>array('selected'=>true)),'onchange'=>'getstudent();'));}
        ?>
  </div>
  <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
    <ol class="breadcrumb">
      <!--<li><a href="index.html">Home</a></li>-->
      
      <li class="active"><?php echo Yii::t('app','Profile'); ?></li>
    </ol>
  </div>
  <div class="clearfix"></div>
</div>
<div class="contentpanel">
  <!--<div class="col-sm-9 col-lg-12">-->
  <div>
    <div class="people-item">
      <div class="media"> <a href="#" class="pull-left">
        <?php
                     if($student->photo_file_name!=NULL)
                     {
						$path = Students::model()->getProfileImagePath($student->id);		 
                        echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" width="100" height="103" class="thumbnail media-object" />';
                    }
                    elseif($student->gender=='M')
                    {
                        echo '<img  src="images/portal/prof-img_male.png" alt='.$student->first_name.' width="100" height="103" class="thumbnail media-object" />'; 
                    }
                    elseif($student->gender=='F')
                    {
                        echo '<img  src="images/portal/prof-img_female.png" alt='.$student->first_name.' width="100" height="103" class="thumbnail media-object" />';
                    }
                    ?>
        </a>
        <div class="media-body">
          <?php
          if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
          ?>
          <h4 class="person-name"><?php echo $student->studentFullName("forStudentPortal");?></h4>
          <?php
          }
          ?>
          <?php if(in_array('batch_id', $student_visible_fields)){ ?>      
          <div class="text-muted"><strong><?php echo Yii::t('app','Course').' :';?></strong>
            <?php 
              $batch = Batches::model()->findByPk($student->batch_id);
              echo $batch->course123->course_name;
            ?>
          </div>          
          <div class="text-muted"> <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' :';?></strong> <?php echo $batch->name;?></div>
          <?php } ?>
          <div class="text-muted"><strong><?php echo Yii::t('app','Admission No').' :';?></strong> <?php echo $student->admission_no; ?></div>
          
        </div>
      </div>
    </div>
    
    <!-- END div class="profile_top" -->
    
    <div class="panel-heading"> 
      <!-- panel-btns -->
      <h3 class="panel-title"><?php echo Yii::t('app','Profile Details'); ?></h3>      
    </div>
    <div class="people-item">
      <div class="table-responsive">
        <?php
				Yii::app()->clientScript->registerScript(
				   'myHideEffect',
				   '$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
				   CClientScript::POS_READY
				);
				
				if(Yii::app()->user->hasFlash('successMessage')): 
				?>
        <div class="flashMessage" style="background:#FFF; color:#C00; padding-left:300px;"> <?php echo Yii::app()->user->getFlash('successMessage'); ?> </div>
        <?php
				endif;
				
				if(Yii::app()->user->hasFlash('errorMessage')): 
				?>
        <div class="flashMessage" style="background:#FFF; color:#C00; padding-left:300px;"> <?php echo Yii::app()->user->getFlash('errorMessage'); ?> </div>
        <?php
				endif;
				?>
          
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('admission_date');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php
              if($student->admission_date==NULL){
                echo "-";
              }
              else{
                if($settings!=NULL){ 
                  $date1=date($settings->displaydate,strtotime($student->admission_date));
                  echo $date1;
                }
                else
                  echo $student->admission_date;
              }
              ?>
            </div>
            </div>

            <?php if(in_array('date_of_birth', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('date_of_birth');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              if($settings!=NULL)
              {
              $date1=date($settings->displaydate,strtotime($student->date_of_birth));
              echo $date1;
              }
              else
              {
              echo $student->date_of_birth;
              }
              ?>
            </div>
            </div>
            <?php } ?>
            
             <?php if(in_array('national_student_id', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('national_student_id');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->national_student_id) and $student->national_student_id!="")?$student->national_student_id:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('gender', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('gender');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              if($student->gender=='M')
              echo Yii::t('app','Male');
              else 
              echo Yii::t('app','Female'); 
              ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('blood_group', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('blood_group');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->blood_group) and $student->blood_group!="")?$student->blood_group:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('birth_place', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('birth_place');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->birth_place) and $student->birth_place!="")?$student->birth_place:'-'; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('nationality_id', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('nationality_id');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              $natio_id=Nationality::model()->findByAttributes(array('id'=>$student->nationality_id));
              if($natio_id!=NULL)
                echo $natio_id->name; 
              else
                echo "-";
              ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('language', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('language');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->language) and $student->language!="")?$student->language:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('religion', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('religion');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->religion) and $student->religion!="")?$student->religion:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('student_category_id', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('student_category_id');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              $cat =StudentCategories::model()->findByAttributes(array('id'=>$student->student_category_id));
              if($cat!=NULL)
                echo $cat->name; 
              else
                echo "-";
              ?>
            </div>
            </div>
            <?php } ?>

            <?php
            // dynamic fields in personal details
            $fields   = FormFields::model()->getDynamicFields(1, 1, "forStudentPortal");
            foreach ($fields as $key => $field) {
              $field_name = $field->varname;
            ?>
              <?php if(in_array($field_name, $student_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
              <div class="col col-sm-6">
                <strong><?php echo $student->getAttributeLabel($field_name);?></strong>
              </div>
              <div class="col col-sm-6">
                <?php
                  if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                    echo FormFields::model()->getFieldValue($student->$field_name);
                  }
                  else if($field->form_field_type==6){  // date value
                    if($student->$field_name==NULL or $student->$field_name=="0000-00-00"){
                      echo "-";
                    }
                    else{
                      if($settings!=NULL){
                        $date1  = date($settings->displaydate,strtotime($student->$field_name));
                        echo $date1;
                      }
                      else{
                        echo $student->$field_name;
                      }
                    }
                  }
                  else{
                    echo (isset($student->$field_name) and $student->$field_name!="")?$student->$field_name:"-";
                  }
                ?>
              </div>
              </div>
              <?php } ?>
            <?php               
            }
            //dynamic fields end
            ?>

            <?php if(in_array('address_line1', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('address_line1');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->address_line1) and $student->address_line1!="")?$student->address_line1:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('address_line2', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('address_line2');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->address_line2) and $student->address_line2!="")?$student->address_line2:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('city', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('city');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->city) and $student->city!="")?$student->city:'-'; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('state', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('state');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->state) and $student->state!="")?$student->state:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('pin_code', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('pin_code');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->pin_code) and $student->pin_code!="")?$student->pin_code:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('country_id', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('country_id');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              $count = Countries::model()->findByAttributes(array('id'=>$student->country_id));
              if(count($count)!=0)
                echo $count->name;
              else
                echo "-";
              ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('phone1', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('phone1');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->phone1) and $student->phone1!="")?$student->phone1:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('phone2', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('phone2');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->phone2) and $student->phone2!="")?$student->phone2:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php if(in_array('email', $student_visible_fields)){ ?>
            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo $student->getAttributeLabel('email');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php echo (isset($student->email) and $student->email!="")?$student->email:"-"; ?>
            </div>
            </div>
            <?php } ?>

            <?php
            // dynamic fields in contact details
            $fields   = FormFields::model()->getDynamicFields(1, 2, "forStudentPortal");
            foreach ($fields as $key => $field) {
              $field_name = $field->varname;
            ?>
              <?php if(in_array($field_name, $student_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
              <div class="col col-sm-6">
                <strong><?php echo $student->getAttributeLabel($field_name);?></strong>
              </div>
              <div class="col col-sm-6">
                <?php
                  if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                    echo FormFields::model()->getFieldValue($student->$field_name);
                  }
                  else if($field->form_field_type==6){  // date value
                    if($settings!=NULL){
                      $date1  = date($settings->displaydate,strtotime($student->$field_name));
                      echo $date1;
                    }
                    else{
                      echo $student->$field_name;
                    }
                  }
                  else{
                    echo (isset($student->$field_name) and $student->$field_name!="")?$student->$field_name:"-";
                  }
                ?>
              </div>
              </div>
              <?php } ?>
            <?php               
            }
            //dynamic fields end
            ?>

            <div class="col-sm-6 clearfix sp_col">
            <div class="col col-sm-6">
              <strong><?php echo Yii::t('app','Emergency Contact');?></strong>
            </div>
            <div class="col col-sm-6">
              <?php 
              echo $guard->parentFullName("forStudentPortal");
              ?>
            </div>
            </div>

            <?php
            // dynamic fields in personal details
            $fields   = FormFields::model()->getDynamicFields(3, 1, "forStudentPortal");
            foreach ($fields as $key => $field) {
              $field_name = $field->varname;
            ?>
              <?php if(in_array($field_name, $student_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
              <div class="col col-sm-6">
                <strong><?php echo $student->getAttributeLabel($field_name);?></strong>
              </div>
              <div class="col col-sm-6">
                <?php
                  if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                    echo FormFields::model()->getFieldValue($student->$field_name);
                  }
                  else if($field->form_field_type==6){  // date value
                    if($settings!=NULL){
                      $date1  = date($settings->displaydate, strtotime($student->$field_name));
                      echo $date1;
                    }
                    else{
                      echo $student->$field_name;
                    }
                  }
                  else{
                    echo (isset($student->$field_name) and $student->$field_name!="")?$student->$field_name:"-";
                  }
                ?>
              </div>
              </div>
              <?php } ?>
            <?php               
            }
            //dynamic fields end
            ?>

            <div class="clearfix"></div>
      </div>
    </div>
    
    <!-- END div class="profile_details"-->
    
    <div class="panel-heading"> 
      <!-- panel-btns -->
      <h3 class="panel-title"><?php echo Yii::t('app','Guardian Details'); ?></h3>
    </div>
    <div class="people-item">
        <div class="table-responsive">
           
                <?php 
  $guardian_list_data= GuardianList::model()->findAllByAttributes(array('student_id'=>$student->id));
  if($guardian_list_data)
  {
      foreach($guardian_list_data as $key=>$data)
      {
        $guardian_model= Guardians::model()->findByPk($data->guardian_id);
        if($guardian_model)
        {      
          ?>
            <div class="row">
              <div class="col-sm-12">
                <strong><?php echo Yii::t('app', 'Guardian');?> : <?php echo $key+1;?></strong>
              </div>
              <br />
              <br />

              <?php if(FormFields::model()->isVisible("fullname", "Guardians", "forStudentPortal")){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo Yii::t('app','Name');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->parentFullName("forStudentPortal"); ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('relation', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('relation');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->relation; ?>
                </div>
              </div>
              <?php } ?>

              <?php if(in_array('dob', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('dob');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->dob; ?>
                </div>
              </div>
              <?php } ?>

              <?php if(in_array('education', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('education');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->education; ?>
                </div>
              </div>
              <?php } ?>

              <?php if(in_array('occupation', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('occupation');?></strong>
                </div>
                <div class="col col-sm-6">
                    <?php echo $guardian_model->occupation;  ?>
                </div>
              </div>
              <?php } ?>

              <?php if(in_array('income', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('income');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->income; ?>
                </div>
              </div>
              <?php } ?>

              <?php
              // dynamic fields in personal details
              $fields   = FormFields::model()->getDynamicFields(2, 1, "forStudentPortal");
              foreach ($fields as $key => $field) {
                $field_name = $field->varname;
              ?>
                <?php if(in_array($field_name, $guardian_visible_fields)){ ?>
                <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel($field_name);?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php
                    if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                      echo FormFields::model()->getFieldValue($guardian_model->$field_name);
                    }
                    else if($field->form_field_type==6){  // date value
                      if($settings!=NULL){
                        $date1  = date($settings->displaydate, strtotime($guardian_model->$field_name));
                        echo $date1;
                      }
                      else{
                        echo $guardian_model->$field_name;
                      }
                    }
                    else{
                      echo (isset($guardian_model->$field_name) and $guardian_model->$field_name!="")?$guardian_model->$field_name:"-";
                    }
                  ?>
                </div>
                </div>
                <?php } ?>
              <?php               
              }
              //dynamic fields end
              ?>


              <?php if(in_array('email', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('email');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->email; ?>
                </div>
              </div>
              <?php } ?>

              <?php if(in_array('mobile_phone', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('mobile_phone');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->mobile_phone; ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('office_phone1', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('office_phone1');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->office_phone1;  ?>
                </div>
              </div>
              <?php } ?>



              <?php if(in_array('office_phone2', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('office_phone2');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->office_phone2;  ?>
                </div>
              </div>
              <?php } ?>
          

              <?php if(in_array('office_address_line1', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('office_address_line1');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->office_address_line1; ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('office_address_line2', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('office_address_line2');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->office_address_line2; ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('city', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('city');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->city;  ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('state', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('state');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php echo $guardian_model->state;  ?>
                </div>
              </div>
              <?php } ?>


              <?php if(in_array('country_id', $guardian_visible_fields)){ ?>
              <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel('country_id');?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php 
                  $country_model= Countries::model()->findByPk($guardian_model->country_id);
                  if($country_model)
                  {
                      echo $country_model->name;
                  }                
                  ?>
                </div>
              </div>
              <?php
              }
              ?>

              <?php
              // dynamic fields in personal details
              $fields   = FormFields::model()->getDynamicFields(2, 2, "forStudentPortal");
              foreach ($fields as $key => $field) {
                $field_name = $field->varname;
              ?>
                <?php if(in_array($field_name, $guardian_visible_fields)){ ?>
                <div class="col-sm-6 clearfix sp_col">
                <div class="col col-sm-6">
                  <strong><?php echo $guardian_model->getAttributeLabel($field_name);?></strong>
                </div>
                <div class="col col-sm-6">
                  <?php
                    if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                      echo FormFields::model()->getFieldValue($guardian_model->$field_name);
                    }
                    else if($field->form_field_type==6){  // date value
                      if($settings!=NULL){
                        $date1  = date($settings->displaydate, strtotime($guardian_model->$field_name));
                        echo $date1;
                      }
                      else{
                        echo $guardian_model->$field_name;
                      }
                    }
                    else{
                      echo (isset($guardian_model->$field_name) and $guardian_model->$field_name!="")?$guardian_model->$field_name:"-";
                    }
                  ?>
                </div>
                </div>
                <?php } ?>
              <?php               
              }
              //dynamic fields end
              ?>

            </div>
            <br />
            <?php
        }       
      }
  } 
  ?>            
            <div class="clearfix"></div>
            
        </div>
    </div>
    
    
    
    <div class="panel-heading"> 
      <!-- Document Area -->
      <h3 class="panel-title"><?php echo Yii::t('app','Document Name'); ?></h3>
    </div>
    <div class="people-item">
      <div class="table-responsive">
        <?php
                    $documents = StudentDocument::model()->findAllByAttributes(array('student_id'=>$student->id)); // Retrieving documents of student with id $_REQUEST['id'];
                    ?>
        <table class="table table-hover mb30">
          <?php
                            if($documents) // If documents present
                            {
                                foreach($documents as $document) // Iterating the documents
                                {
                            ?>
          <tr>
            <td width="90%"><?php echo ucfirst($document->title);?></td>
            <td width="10%"><?php $status_data="";
											// Setting class for status label
											if($document->is_approved == -1)
											{
												$class = 'tag_disapproved';
                                                                                                $status_data=Yii::t('app',"Disapproved");
											}
											elseif($document->is_approved == 0)
											{
												$class = 'tag_pending';
                                                                                                $status_data=Yii::t('app',"Pending");
											}
											elseif($document->is_approved == 1)
											{
												$class = 'tag_approved';
                                                                                                $status_data=Yii::t('app',"Approved");
											}
											echo '<div style="width:127px">';
											echo '<div class="'.$class.'" style="padding:4px 35px 0px;">'.$status_data.'</div>';
											echo '</div>';
											?></td>
            <td width="10%"><ul class="tt-wrapper">
                <li>
                  <?php 
                                                    if($document->is_approved == 1)
                                                    {
                                                    echo CHtml::link('<span>'.Yii::t('app','You cannot edit an approved document.').'</span>', array('documentupdate','id'=>$document->student_id,'document_id'=>$document->id),array('class'=>'tt-edit-disabled','onclick'=>'return false;')); 
                                                    }
                                                    else
                                                    {
                                                        echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('documentupdate','id'=>$document->student_id,'document_id'=>$document->id),array('class'=>'tt-edit')); 
                                                    }
                                                    ?>
                </li>
                <li>
                  <?php 
                                                 echo CHtml::link('<span>'.Yii::t('app','Download').'</span>', array('download','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-download')); 
                                                 ?>
                </li>
                <li>
                  <?php 
													if($document->is_approved == 1)
													{
														echo CHtml::link('<span>'.Yii::t('app','You cannot delete an approved document.').'</span>', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-delete-disabled','onclick'=>'return false;')); 
													}
													else
													{
														echo CHtml::link('<span>'.Yii::t('app','Delete').'</span>', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-delete','confirm'=>Yii::t('app','Are you sure you want to delete this?'))); 
													}
													?>
                </li>
              </ul></td>
          </tr>
          <?php	
                                }
                                
                            }
                            else // If no documents present
                            {
                            ?>
          <tr>
            <td colspan="2" style="text-align:center;"><?php echo Yii::t('app','No document(s) uploaded'); ?></td>
          </tr>
          <?php
                            }
                            ?>
        </table>
      </div>
    </div>
    <!-- END div class="document_table" -->
    <div class="panel-heading">
      <h5 class="panel-title"><?php echo Yii::t('app','Upload Documents'); ?> 
        <!-- Document form --></h5>
    </div>
    <div class="people-item">
      <div class="form-group">
        <div class="form">
          <?php
                    if($documents==NULL) 
                    {
                        $document = new studentDocument;
                    }
                      echo $this->renderPartial('documentform', array('model'=>$document,'sid'=>$student->id)); 
                    ?>
        </div>
      </div>
      <!-- form --> </div>
  </div>
</div>
