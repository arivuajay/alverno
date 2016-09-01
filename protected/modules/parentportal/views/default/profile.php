<style>
.sp_col{
	border-bottom:1px #eee solid;
	padding-bottom:8px;
}
</style>
<?php 
    $this->renderPartial('leftside');
	
    $guardian = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));    
    //$students = Students::model()->findAllByAttributes(array('parent_id'=>$guardian->id));
	$criteria = new CDbCriteria;		
	$criteria->join = 'LEFT JOIN guardian_list t1 ON t.id = t1.student_id'; 
	$criteria->condition = 't1.guardian_id=:guardian_id and t.is_active=:is_active and is_deleted=:is_deleted';
	$criteria->params = array(':guardian_id'=>$guardian->id,':is_active'=>1,'is_deleted'=>0);
	$students = Students::model()->findAll($criteria);  
	  
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
    ?>

<div class="pageheader">
	<h2><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Profile'); ?> <span><?php echo Yii::t('app','View your profile here'); ?></span></h2>
	<div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
		<ol class="breadcrumb">
			<!--<li><a href="index.html">Home</a></li>-->
			<li class="active"><?php echo Yii::t('app','Profile'); ?></li>
		</ol>
	</div>
</div>
<div class="contentpanel"> 
	<!--<div class="col-sm-9 col-lg-12">-->
	<div>
		<div class="people-item">
			<div class="media">
				<div class="col-lg-10">
					<div class="media-body">
						<h4 class="person-name"><?php echo $guardian->parentFullName('forParentPortal');?></h4>
						<div class="text-muted"><i class="fa fa-user"></i>
							<?php
                    foreach($students as $student)
					{
						$guardian_relation = GuardianList::model()->findByAttributes(array('guardian_id'=>$guardian->id,'student_id'=>$student->id));
						
						if($guardian_relation and $student->studentFullName('forParentPortal')!=''){							
							echo Yii::t('app',ucfirst($guardian_relation->relation)).' '.Yii::t('app','of').' : '; 
							echo CHtml::link($student->studentFullName('forParentPortal'), array('/parentportal/default/studentprofile','id'=>$student->id)).'&nbsp;&nbsp;&nbsp;';
						}
					}
					?>
						</div>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="edit_bttns" style="float:right;margin-top: 13px">
						<ul>
							<li><?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>',array('default/edit','id'=>$guardian->id),array('class'=>'addbttn last'));?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="people-item">
			
			<div class="table-responsive">
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
												
													<div class="col-sm-6">
														<strong><?php echo $guardian->getAttributeLabel($field->varname);?></strong>
													</div>
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
                
				
			</div>
			
			<!-- panel --> 
			
		</div>
	</div>
</div>