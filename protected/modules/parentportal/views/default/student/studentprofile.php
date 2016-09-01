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
    $guardian = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $students = Students::model()->findAllByAttributes(array('parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
    $student_list = CHtml::listData($students,'id','studentnameforparentportal');
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
    ?>

<div class="pageheader">
	<div class="col-lg-8">
		<h2><i class="fa fa-male"></i><?php echo Yii::t('app','Student Profile'); ?> <span><?php echo Yii::t('app','View your profile here'); ?></span></h2>
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
			
			<li class="active"><?php echo Yii::t('app','Student Profile'); ?></li>
		</ol>
	</div>
	<div class="clearfix"></div>
</div>
<?php
			if(count($students)==1 or (isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)) // Single Student 
			{
				if(count($students)>1) 
				{
			
				$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id'],'parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
				} 
				else
				{
					$student = Students::model()->findByAttributes(array('parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
						
				}
				 
			?>
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
					<h4 class="person-name"><?php echo $student->studentFullName('forParentPortal');?></h4>
                    <?php if(FormFields::model()->isVisible('batch_id','Students','forParentPortal')){?>
                        <div class="text-muted"><strong><?php echo Yii::t('app','Course :');?> </strong>
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
		<div class="panel-heading"> 
			<!-- panel-btns -->
			<h3 class="panel-title"><?php echo Yii::t('app','Student Details'); ?></h3>
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
				<div class="flashMessage" style="color:#C00; padding-left:300px;"> <?php echo Yii::app()->user->getFlash('successMessage'); ?> </div>
				<?php
                                endif;
                                
                                if(Yii::app()->user->hasFlash('errorMessage')): 
                                ?>
				<div class="flashMessage" style="color:#C00; padding-left:300px;"> <?php echo Yii::app()->user->getFlash('errorMessage'); ?> </div>
				<?php
                                endif;
                                ?>
								
								<!--repeated div starts-->
                                <?php if(FormFields::model()->isVisible('admission_date','Students','forParentPortal')){?>
								<div class="col-sm-6 clearfix sp_col">
									
									<!--left div starts-->
									<div class="col-sm-6">
										<strong><?php 
										
										echo Students::model()->getAttributeLabel('admission_date');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                                if($settings!=NULL)
                                                {	
                                                    $date1=date($settings->displaydate,strtotime($student->admission_date));
                                                    echo $date1;
                                                }
                                                else
                                                {
                                                    echo $student->admission_date;
                                                }
                                                ?>
									</div>
								
								</div>
                                <?php
								}
								?>
								<!--repeated div ends-->
                                 <?php if(FormFields::model()->isVisible('city','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('city');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php echo $student->city; ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('date_of_birth','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('date_of_birth');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
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
								<!--repeated div ends-->
                                <!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('national_student_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php echo $student->national_student_id; ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                <?php if(FormFields::model()->isVisible('birth_place','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('birth_place');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                          echo $student->birth_place; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('blood_group','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('blood_group');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                          echo $student->blood_group; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('state','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('state');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                          echo $student->state; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('country_id','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('country_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           $count = Countries::model()->findByAttributes(array('id'=>$student->country_id));
                                                if(count($count)!=0)
                                                echo $count->name; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('nationality_id','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('nationality_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                            $natio_id=Nationality::model()->findByAttributes(array('id'=>$student->nationality_id));
                                            echo $natio_id->name; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                <?php if(FormFields::model()->isVisible('gender','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('gender');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                            if($student->gender=='M')
                                            echo Yii::t('app','Male');
                                            else 
                                            echo Yii::t('app','Female'); 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                  <!-- DYNAMIC FIELDS START -->
                                 <?php
                                 $student_fields1= FormFields::model()->getDynamicFields(1, 1, "forParentPortal");
								 if($student_fields1)
                                    {
                                        foreach ($student_fields1 as $key => $field) 
                                        {
											$field_name = $field->varname;
											if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Students','forParentPortal'))
                                                { ?>
												
												<div class="col-sm-6 clearfix sp_col">
													<!--left div starts-->
													<div class="col-sm-6">
														<strong><?php echo $student->getAttributeLabel($field->varname);?></strong>
													</div>
													<!--right div starts-->
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
								
								   <?php		}
											}
										}
									} ?>
                                     <!-- DYNAMIC FIELDS ENDS -->
                                 <?php if(FormFields::model()->isVisible('pin_code','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('pin_code');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->pin_code; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('address_line1','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('address_line1');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->address_line1;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                <?php if(FormFields::model()->isVisible('address_line2','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('address_line2');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->address_line2;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('phone1','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('phone1');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->phone1;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('phone2','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('phone2');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->phone2;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('language','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('language');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->language;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                 <?php if(FormFields::model()->isVisible('email','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('email');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                           echo $student->email;
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                <?php if(FormFields::model()->isVisible('student_category_id','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('student_category_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                          $cat =StudentCategories::model()->findByAttributes(array('id'=>$student->student_category_id));
                                                if($cat!=NULL)
                                                echo $cat->name; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                  <?php if(FormFields::model()->isVisible('religion','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('religion');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                          echo $student->religion; 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                <?php if(FormFields::model()->isVisible('immediate_contact_id','Students','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $student->getAttributeLabel('immediate_contact_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
										<?php 
                                         echo ucfirst($guardian->first_name).' '.ucfirst($guardian->last_name); 
                                        ?>
									</div>
								</div>
								<!--repeated div ends-->
                                <?php
								 }
								?>
                                
                               
                                 <!-- DYNAMIC FIELDS START -->
								<?php
								$student_fields2= FormFields::model()->getDynamicFields(1, 2, "forParentPortal");
								 if($student_fields2)
                                    {
                                        foreach ($student_fields2 as $key => $field) 
                                        {
											if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Students','forParentPortal'))
                                                { ?>
												
												<div class="col-sm-6 clearfix sp_col">
													<!--left div starts-->
													<div class="col-sm-6">
														<strong><?php echo $student->getAttributeLabel($field->varname);?></strong>
													</div>
													<!--right div starts-->
													<div class="col col-sm-6">
														<?php
														 $field_name = $field->varname;
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
								
								   <?php		}
											}
										}
									}
								 ?>
                                  <!-- DYNAMIC FIELDS END -->
								<div class="clearfix"></div>
								
				
			</div>
		</div>
		<div class="panel-heading"> 
			<!-- panel-btns -->
			<h3 class="panel-title"><?php echo Yii::t('app','Guardian Details');?></h3>
		</div>
		<?php
$guardian_details = GuardianList::model()->findAllByAttributes(array('student_id'=>$student->id));
if($guardian_details)
{	
?>
		<div class="people-item">
			<?php        
		foreach($guardian_details as $guardian_detail)
		{
			$guardians = Guardians::model()->findAllByAttributes(array('id'=>$guardian_detail->guardian_id));
			foreach($guardians as $guardian)
			{
?>
			<div class="table-responsive" style="padding:10px;
                    border:1px solid #eee;
                    margin-bottom:20px;
                    border-radius:5px">
				<h4 class="person-name"><?php 
				if(FormFields::model()->isVisible('first_name','Guardians','forParentPortal'))
				echo $guardian->first_name;
                if(FormFields::model()->isVisible('last_name','Guardians','forParentPortal'))
                 echo " ".$guardian->last_name;?></h4>
                
                <?php if(FormFields::model()->isVisible('relation','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('relation');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
                                    if($guardian->relation!=NULL)
                                    {
                                   		 echo $guardian->relation;
                                    }
                                    else
                                    {
                                   		 echo '-';
                                    }
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                
                <?php if(FormFields::model()->isVisible('dob','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('dob');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->dob==0000-00-00)
									{
									echo '-';
									}
									else
									{
									if($settings!=NULL)
									{
									$date1=date($settings->displaydate,strtotime($guardian->dob));
									echo $date1;
									}
									
									
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                 <?php if(FormFields::model()->isVisible('education','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('education');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->education!=NULL)
									{
										echo $guardian->education;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('occupation','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('occupation');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->occupation!=NULL)
									{
										echo $guardian->occupation;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                  <?php if(FormFields::model()->isVisible('income','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('income');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->income!=NULL)
									{
										echo $guardian->income;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                  <!-- DYNAMIC FIELDS START -->
                                <?php
                                 $parent_fields1= FormFields::model()->getDynamicFields(2, 1, "forParentPortal");
								 if($parent_fields1)
                                    {
                                        foreach ($parent_fields1 as $key => $field) 
                                        {
											if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Guardians','forParentPortal'))
                                                { ?>
												
												<div class="col-sm-6 clearfix sp_col">
													<!--left div starts-->
													<div class="col-sm-6">
														<strong><?php echo $guardian->getAttributeLabel($field->varname);?></strong>
													</div>
													<!--right div starts-->
                                                    <div class="col col-sm-6">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($guardian->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($guardian->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $guardian->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($guardian->$field_name) and $guardian->$field_name!="")?$guardian->$field_name:"-";
                                                          }
                                                        ?>
                                                      </div>
													
												</div>
								     <?php
								  		}
											}
										}
									}
                                    ?>
                      <!-- DYNAMIC FIELDS ENDS -->    
              <?php   if(FormFields::model()->isVisible('email','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('email');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->email!=NULL)
									{
										echo $guardian->email;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                  <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('mobile_phone');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->mobile_phone!=NULL)
									{
										echo $guardian->mobile_phone;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('office_phone1');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->office_phone1!=NULL)
									{
										echo $guardian->office_phone1;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('office_phone2');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->office_phone2!=NULL)
									{
										echo $guardian->office_phone2;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                 <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('office_address_line1');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->office_address_line1!=NULL)
									{
										echo $guardian->office_address_line1;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('office_address_line2');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->office_address_line2!=NULL)
									{
										echo $guardian->office_address_line2;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('city','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('city');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->city!=NULL)
									{
										echo $guardian->city;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                 <?php if(FormFields::model()->isVisible('state','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('state');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
									if($guardian->state!=NULL)
									{
										echo $guardian->state;
									}
									else
									{
										echo '-';
									}
                                    ?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
                 <?php if(FormFields::model()->isVisible('country_id','Guardians','forParentPortal')){?>
								<!--repeated div starts-->
								<div class="col-sm-6 clearfix sp_col">
								    <!--left div starts-->
									<div class="col-sm-6">
										<strong><?php echo $guardian->getAttributeLabel('country_id');?></strong>
									</div>
									<!--right div starts-->
									<div class="col-sm-6">
									<?php 
								if($guardian->country_id!=NULL)
								{
									 $count = Countries::model()->findByAttributes(array('id'=>$guardian->country_id));
											if(count($count)!=0)
											 echo $count->name;
								}
								else
								{
									echo '-';
								}
									?>
									</div>
								</div>
								<!--repeated div ends-->
				<?php
                 }
                ?>
             
                                  <!-- DYNAMIC FIELDS START -->  <?php
                                 $parent_fields2= FormFields::model()->getDynamicFields(2, 2, "forParentPortal");
								 if($parent_fields2)
                                    {
                                        foreach ($parent_fields2 as $key => $field) 
                                        {
											if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Guardians','forParentPortal'))
                                                { ?>
												
												<div class="col-sm-6 clearfix sp_col">
													<!--left div starts-->
													<div class="col-sm-6">
														<strong><?php echo $guardian->getAttributeLabel($field->varname);?></strong>
													</div>
													<!--right div starts-->
													<div class="col col-sm-6">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($guardian->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($guardian->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $guardian->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($guardian->$field_name) and $guardian->$field_name!="")?$guardian->$field_name:"-";
                                                          }
                                                        ?>
                                                      </div>
												</div>
								
								   <?php		}
											}
										}
									}
                                  ?>
                    <!-- DYNAMIC FIELDS ENDS -->
				<div class="clearfix"></div>
				<?php
		}
?>
			</div>
			<?php        
	}
?>
		</div>
		<?php	
}
?>
		<div class="panel-heading"> 
			<!-- Document Area -->
			<h3 class="panel-title"><?php echo Yii::t('app','Documents'); ?></h3>
		</div>
		<div class="people-item">
        <?php
		if(FormFields::model()->isVisible('file','StudentDocument','forParentPortal'))
         { 
		  
		?>
			<div class="table-responsive">
				<?php
				
                                $documents = StudentDocument::model()->findAllByAttributes(array('student_id'=>$student->id)); // Retrieving documents of student with id $_REQUEST['id'];
                                ?>
				<table class="table table-hover mb30">
					<tbody>
						<?php
                                        if($documents) // If documents present
                                        {
                                            foreach($documents as $document) // Iterating the documents
                                            {
                                        ?>
						<tr>
							<td width="90%"><?php echo ucfirst($document->doc_type);?></td>
							<td width="10%"><?php
                                                        $status_data="";
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
                                                        echo '<div class="'.$class.'">'.$status_data.'</div>';
                                                        echo '</div>';
                                                        ?></td>
							<td width="10%"><ul class="tt-wrapper">
									<li>
										<?php 
                                                                if($document->is_approved == 1)
                                                                {
                                                                echo CHtml::link('<span>'.Yii::t('app','You cannot edit an approved document').'</span>', array('documentupdate','id'=>$document->student_id,'document_id'=>$document->id),array('class'=>'tt-edit-disabled','onclick'=>'return false;')); 
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
							<?php /*?><td width="10%">
                                                    <!--<a class="dcumnt_dnld" href="#"></a>-->
                                                    <?php echo CHtml::link('dd', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'document_delet','style'=>'text-indent:-99999px;','confirm'=>'Are you sure you want to delete this?')); ?>
                                                   
                                                    </td>
                                                    <td width="10%">
                                                     <?php echo CHtml::link('d', array('download','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'dcumnt_dnld','style'=>'text-indent:-99999px;')); ?>
                                                    </td><?php */?>
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
					</tbody>
				</table>
			</div>
			<h5 class="subtitle mb5"><?php echo Yii::t('app','Upload Documents'); ?></h5>
			<div class="form-group">
				<?php
                                if($documents==NULL) 
                                {
                                    $document = new studentDocument;
                                }
                                  echo $this->renderPartial('student/documentform', array('model'=>$document,'sid'=>$student->id)); 
                                ?>
			</div>
            <?php
            }
			?>
		</div>
	</div>
</div>
<?php
			
			} // END Single Student
			elseif(count($students)>1 and !isset($_REQUEST['id'])) // More than one Student. Display List
			{
			?>
<div class="contentpanel"> 
	<!-- <div class="col-sm-9 col-lg-12">-->
	<div>
		<?php
								foreach($students as $student)
								{
								?>
		<div class="people-item">
			<div class="media"> <a href="#" class="pull-left">
				<?php
                            if($student->photo_file_name!=NULL)
                            { 
								$path = Students::model()->getProfileImagePath($student->id);
                            	echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" class="thumbnail media-object" />';
                            }
                            elseif($student->gender=='M')
                            {
                                echo '<img  src="images/portal/s_profile_m_icon.png" class="thumbnail media-object" alt='.$student->first_name.' />'; 
                            }
                            elseif($student->gender=='F')
                            {
                                echo '<img  src="images/portal/s_profile_fmicon.png" class="thumbnail media-object" alt='.$student->first_name.' />';
                            }
                            ?>
				</a>
				<div class="media-body">
					<h4 class="person-name"> <?php echo CHtml::link($student->studentFullName('forParentPortal'), array('/parentportal/default/studentprofile', 'id'=>$student->id));?></h4>
					<div class="text-muted">
						<?php
								
								if($student->batch_id!=0 and $student->batch_id!=NULL)
								{
									$batch = Batches::model()->findByPk($student->batch_id);
								}
								else if ($student->batch_id==0)
								{
									
									$criteria = new CDbCriteria();
									$criteria->condition  = "student_id =:sid";
									$criteria->params = array(':sid'=>$student->id);
									$criteria->order = "id DESC";
									$criteria->limit = 1;
									
									$last = BatchStudents::model()->findAll($criteria);
									$batch = Batches::model()->findByPk($last[0]->batch_id);
								?>
						Alumni
						<?php	
								}

								?>
					</div>
                    <?php if(FormFields::model()->isVisible('batch_id','Students','forParentPortal')){?>
                        <div class="text-muted"><?php echo Yii::t('app','Course :');?>
                            <?php 
                                            echo $batch->course123->course_name;
                                            ?>
                        </div>
                        <div class="text-muted"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.':';?> <?php echo $batch->name;?></div>
                    <?php } ?>    
					<div class="text-muted"><?php echo Yii::t('app','Admission No').' :';?> <?php echo $student->admission_no; ?></div>
				</div>
			</div>
		</div>
		<?php
                } // END foreach($students as $student)
                ?>
		<?php                
			} // END More than one student. End Display List
			elseif(count($students)<=0) // No Student
			{
			?>
		<div class="yellow_bx" style="background-image:none;width:750px;padding-bottom:45px;">
			<div class="y_bx_head"> <?php echo Yii::t('app','No student details are available now!'); ?> </div>
		</div>
		<?php
			} // END No Student
			?>
	</div>
</div>
