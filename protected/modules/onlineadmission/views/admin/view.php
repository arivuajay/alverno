<style type="text/css">
.max_student{ border-left: 3px solid #fff;
    margin: 0 3px;
    padding: 6px 0 6px 3px;
    word-break: break-all;}
</style>
<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('/students/students/index'),
	Yii::t('app','Online Registration'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
            	<h1>
					<?php echo Yii::t('app','Registered Student Profile').' : '; ?>
                    <?php						 
						if(FormFields::model()->isVisible("fullname", "Students", 'forOnlineRegistration')){
							echo $model->studentFullName('forOnlineRegistration');
						}
					?>
                </h1>
                <?php
                $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                $status_data="";
				// Setting class for status label
				if($model->status == -1)
				{
					$status_class = 'tag_disapproved';
                                        $status_data=Yii::t('app',"Disapproved");
				}
				elseif($model->status == 0)
				{
					$status_class = 'tag_pending';
                                        $status_data=Yii::t('app',"Pending");
				}
				elseif($model->status == 1)
				{
					$status_class = 'tag_approved';
                                        $status_data=Yii::t('app',"Approved");
				}
				elseif($model->status == -3)
				{
					$status_class = 'tag_waiting';
                                        $status_data=Yii::t('app',"Waiting");
				}
				?>
				
                <div class="online_but" style="position:relative; float:right; padding:10px 0 0 0; bottom:0px">
                	<div class="<?php echo $status_class; ?>" style="float:left;"><?php echo $status_data; ?></div>
                    <ul class="tt-wrapper" style="width:326px;">
                        <li>
                        <?php
                        if($model->status == 1)
                        { 
                            echo CHtml::link('<span>'.Yii::t('app','Approved').'</span>', array('#'),array('class'=>'tt-approved-disabled','onclick'=>'return false;'));
                        }
                        else
                        {
                           
                            /*echo CHtml::ajaxLink('<span>'.Yii::t('app','Approve').'</span>',$this->createUrl('approve'),array(
                                'onclick'=>'$("#jobDialog'.$model->id.'").dialog("open"); return false;',
                                'update'=>'#jobDialog123'.$model->id,'type' =>'GET','data'=>array('id' =>$model->id)),array('id'=>'showJobDialog'.$model->id,'class'=>'tt-approved'));*/
								
							echo CHtml::ajaxLink('<span>'.Yii::t('app','Approve').'</span>',$this->createUrl('admin/approve'),array(
															'onclick'=>'$("#jobDialog'.$model->id.'").dialog("open"); return false;',
															'update'=>'#jobDialog123'.$model->id,'type' =>'GET','data'=>array('id' =>$model->id),),array('id'=>'showJobDialog'.$model->id,'class'=>'tt-approved'));
															
                            
                        }
                        ?>
                        </li>
					<?php
                        if($model->status != 1)
                        {
                    ?>
                        <li>
                        <?php 
                        if($model->status == -1)
                        {
                            
                            echo CHtml::link('<span>'.Yii::t('app','Disapproved').'</span>', array('#'),array('class'=>'tt-disapproved-disabled','onclick'=>'return false;')); 
                        }
                        else
                        {
                            echo CHtml::link('<span>'.Yii::t('app','Disapprove').'</span>', array('disapprove','id'=>$model->id),array('class'=>'tt-disapproved','confirm'=>Yii::t('app','Are you sure you want to disapprove this?'))); 
                        }
                        
                        ?>
                        </li>
                   <?php
						}
			       ?>
                   <?php if($model->status != 1){ ?>
                        <li>
                            <?php echo CHtml::link('<span>'.Yii::t('app','Delete').'</span>', array('delete','id'=>$model->id),array('class'=>'tt-delete','confirm'=>Yii::t('app','Are you sure you want to delete this?'))); ?>
                        </li>
                  <?php } ?>      
                        <?php
							if($model->status == 0)
							{
						?>		
                        <li>                        
                            <?php echo CHtml::link('<span>'.Yii::t('app','Waiting List').'</span>', array('WaitinglistStudents/create','id'=>$model->id),array('class'=>'tt-waiting',)); ?>                                                  
                        </li>
                        <?php
							}
						?>
                        
						<?php
                            if($model->status == 0 or $model->status == -3)
                            {
						?>  
                        <li>                      		
							<?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('profileedit','id'=>$model->id),array('class'=>'tt-edit',)); ?>
                        </li>   
                        <?php   
							}
						?>
                        
                        <!--<li><a href="#" class="tt-download"><span>Download</span></a></li>-->
                    </ul>
                    <div  id="<?php echo 'jobDialog123'.$model->id;?>"></div>
                </div>
                
                <div class="clear"></div>
                
                <div class="emp_right_contner">
                    <div class="emp_tabwrapper">
                    	<div class="emp_cntntbx">
                        <div class="student_img">
                            
                            <?php
												 $student=Students::model()->findByAttributes(array('id'=>$model->id));
												 if($student->photo_file_name){ 
												 	$path = Students::model()->getProfileImagePath($student->id);
													echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" width="100" height="100"  />';
												 }
												 elseif($student->gender == 'M')
												 {
													echo '<img  src="images/s_prof_m_image.png" alt='.$student->first_name.' />'; 
												 }
												 elseif($student->gender == 'F')
												 {
													echo '<img  src="images/s_prof_fe_image.png" alt='.$student->first_name.' />';  
												 }
											?>
                            </div>
                            
                            
                        <div class="table_listbx">
                            <div class="table_listbx">                        	
                                <div class="listbxtop_hdng"><?php echo Yii::t('app','General');?></div>
                                <div class="prof-view-col">
				<?php if(FormFields::model()->isVisible('registration_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('registration_id');?></li>                                       
                                        <li class="r-col"><?php echo $model->registration_id; ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('registration_date','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('registration_date');?></li>                                       
                                        <li class="r-col"><?php 
                                        
                                        if($settings!=NULL)
                                        {	
                                            $model->registration_date = date($settings->displaydate,strtotime($model->registration_date));
                                        }
                                            echo $model->registration_date; 
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                	<?php if(FormFields::model()->isVisible('national_student_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('national_student_id');?></li>                                       
                                        <li class="r-col"><?php
                                            if($model->national_student_id)
                                            {                                                 
                                                echo $model->national_student_id;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('date_of_birth','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('date_of_birth');?></li>                                       
                                        <li class="r-col"><?php
                                            if($model->date_of_birth)
                                            { 
                                                if($settings!=NULL)
                                                {	
                                                    $model->date_of_birth = date($settings->displaydate,strtotime($model->date_of_birth));
                                                }
                                                echo $model->date_of_birth;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('gender','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('gender');?></li>                                       
                                        <li class="r-col"><?php
                                            if($model->gender == 'M') 
                                            {
                                                echo Yii::t('app','Male');
                                            }
                                            elseif($model->gender == 'F') 
                                            {
                                                echo Yii::t('app','Female');
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('blood_group','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('blood_group');?></li>                                       
                                        <li class="r-col"><?php
                                            if($model->blood_group)
                                            {                                                 
                                                echo $model->blood_group;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('birth_place','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('birth_place');?></li>                                       
                                        <li class="r-col"><?php
                                            $nationality=Nationality::model()->findByAttributes(array('id'=>$model->nationality_id));
                                            if($nationality)
                                            {                                                 
                                                echo $nationality->name;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('nationality_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('nationality_id');?></li>                                       
                                        <li class="r-col"><?php
					$nationality=Nationality::model()->findByAttributes(array('id'=>$model->nationality_id));
                                            if($nationality)
                                            {                                                 
                                                echo $nationality->name;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('language','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('language');?></li>                                       
                                        <li class="r-col"><?php
                                            if($model->language) 
                                            {
                                                echo $model->language;
                                            }                                           
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('batch_id');?></li>                                       
                                        <li class="r-col"><?php                                           							
                                              $batch_name = Batches::model()->findByAttributes(array('id'=>$model->batch_id));
                                              if($batch_name)
                                              {
                                                    echo $batch_name->course123->course_name.' / '.$batch_name->name;						
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('student_category_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('student_category_id');?></li>                                       
                                        <li class="r-col"><?php 
                                            $category =StudentCategories::model()->findByAttributes(array('id'=>$model->student_category_id));
                                            if($category !=NULL)
                                            {
                                                echo $category->name;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('religion','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('religion');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->religion)
                                              {
                                                    echo $model->religion;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $contact_fields= FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
                                    if($contact_fields)
                                    {
                                        foreach ($contact_fields as $ckey => $cfield) 
                                        {							
                                            if($cfield->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($cfield->varname,'Students','forOnlineRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($cfield->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $cfield->varname;
                                                            if($model->$field_name)
                                                            {
                                                                if(in_array($cfield->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($model->$field_name);
                                                                  }
                                                                  else if($cfield->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($model->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                  }
                                                                    else
                                                                    {
                                                                        echo $model->$field_name; 
                                                                    }
                                                            }
                                                            else
                                                            {
                                                                    echo '-';
                                                            }
                                                            ?></li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->
                                    
                                    
                                    
                                    
                                     <div class="clear"></div>
                                </div>
                                
                                
                                <div class="listbxtop_hdng"><?php echo Yii::t('app','Contact Details');?></div>
                                <div class="prof-view-col">
                                    <?php if(FormFields::model()->isVisible('address_line1','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('address_line1');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->address_line1)
                                              {
                                                    echo $model->address_line1;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('address_line2','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('address_line2');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->address_line2)
                                              {
                                                    echo $model->address_line2;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('city','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('city');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->city)
                                              {
                                                    echo $model->city;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('state','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('state');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->state)
                                              {
                                                    echo $model->state;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('country_id','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('country_id');?></li>                                       
                                        <li class="r-col">
                                         <?php
                                                $country = Countries::model()->findByAttributes(array('id'=>$model->country_id));
                                                if($country)
                                                {
                                                        echo $country->name;
                                                }
                                                else
                                                {
                                                        echo '-';
                                                }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('pin_code','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('pin_code');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->pin_code)
                                              {
                                                    echo $model->pin_code;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('phone1','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('phone1');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->phone1)
                                              {
                                                    echo $model->phone1;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('phone2','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('phone2');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->phone2)
                                              {
                                                    echo $model->phone2;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('email','Students','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('email');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model->email)
                                              {
                                                    echo $model->email;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $student_contact_fields= FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
                                    if($student_contact_fields)
                                    {
                                        foreach ($student_contact_fields as $ckey => $cfield) 
                                        {							
                                            if($cfield->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($cfield->varname,'Students','forOnlineRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($cfield->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $cfield->varname;
                                                            if($model->$field_name)
                                                            {
                                                                if(in_array($cfield->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($model->$field_name);
                                                                  }
                                                                  else if($cfield->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($model->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                  }
                                                                    else
                                                                    {
                                                                    echo $model->$field_name; }
                                                            }
                                                            else
                                                            {
                                                                    echo '-';
                                                            }
                                                            ?></li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->
                                     <div class="clear"></div>
                                </div>
                                
                                <div class="listbxtop_hdng"><?php echo Yii::t('app','Parent Details');?></div>
                                <div class="prof-view-col">
                                    <?php if(FormFields::model()->isVisible("fullname", "Guardians", "forOnlineRegistration")){?>
                                    <ul>
                                        <li class="l-col"><?php echo "Full Name"; //echo $model->getAttributeLabel('first_name');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              $name= "";
                                                if(FormFields::model()->isVisible('first_name','Guardians','forAdminRegistration'))
                                                {
                                                    $name.= $model_1->first_name;
                                                }
                                                if(FormFields::model()->isVisible('last_name','Guardians','forAdminRegistration'))
                                                {
                                                    $name.= " ".$model_1->last_name;
                                                }
                                                echo $name;
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('relation','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('relation');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->relation)
                                              {
                                                    echo $model_1->relation;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('dob','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('dob');?></li>                                       
                                        <li class="r-col">
                                         <?php 
                                                        

                                                        if($model_1->dob != NULL and $model_1->dob!= '0000-00-00')
                                                        {
                                                                if($settings!=NULL)
                                                                {	
                                                                        $model_1->dob = date($settings->displaydate,strtotime($model_1->dob));
                                                                }
                                                                echo $model_1->dob;
                                                        }
                                                        else
                                                        {
                                                                echo '-';
                                                        }
                                                ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('education','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('education');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->education)
                                              {
                                                    echo $model_1->education;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('occupation','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('occupation');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->occupation)
                                              {
                                                    echo $model_1->occupation;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('income','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('income');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->income)
                                              {
                                                    echo $model_1->income;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>   
                                    
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $parent_fields= FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
                                    if($parent_fields)
                                    {
                                        foreach ($parent_fields as $ckey => $cfield) 
                                        {							
                                            if($cfield->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($cfield->varname,'Guardians','forOnlineRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model_1->getAttributeLabel($cfield->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $cfield->varname;
                                                            if($model_1->$field_name)
                                                            {
                                                                if(in_array($cfield->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($model_1->$field_name);
                                                                  }
                                                                  else if($cfield->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($model_1->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                  }
                                                                    else
                                                                    {
                                                                    echo $model_1->$field_name; }
                                                            }
                                                            else
                                                            {
                                                                    echo '-';
                                                            }
                                                            ?></li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->
                                     <div class="clear"></div>
                                </div>
                                
                                <div class="listbxtop_hdng"><?php echo Yii::t('app','Parent Contact Details');?></div>
                                <div class="prof-view-col">
                                    <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_address_line1');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->relation)
                                              {
                                                    echo $model_1->office_address_line1;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_address_line2');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->office_address_line2)
                                              {
                                                    echo $model_1->office_address_line2;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    
                                    <?php if(FormFields::model()->isVisible('city','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('city');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->city)
                                              {
                                                    echo $model_1->city;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?> 
                                    <?php if(FormFields::model()->isVisible('state','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('state');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->state)
                                              {
                                                    echo $model_1->state;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('country_id','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('country_id');?></li>                                       
                                        <li class="r-col">
                                         <?php
                                                    $country = Countries::model()->findByAttributes(array('id'=>$model_1->country_id));
                                                    if($country)
                                                    {
                                                            echo $country->name;
                                                    }
                                                    else
                                                    {
                                                            echo '-';
                                                    }
                                            ?>
                                        </li>
                                    </ul>
                                <?php } ?>   
                                    <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_phone1');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->office_phone1)
                                              {
                                                    echo $model_1->office_phone1;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_phone2');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->office_phone2)
                                              {
                                                    echo $model_1->office_phone2;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('mobile_phone');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->mobile_phone)
                                              {
                                                    echo $model_1->mobile_phone;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('email','Guardians','forOnlineRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('email');?></li>                                       
                                        <li class="r-col">
                                         <?php                                           																	  
                                              if($model_1->email)
                                              {
                                                    echo $model_1->email;
                                              }
                                              else
                                              {
                                                      echo "-";
                                              }
                                        ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                                    
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $parent_contact_fields= FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
                                    if($parent_contact_fields)
                                    {
                                        foreach ($parent_contact_fields as $ckey => $cfield) 
                                        {							
                                            if($cfield->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($cfield->varname,'Guardians','forOnlineRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model_1->getAttributeLabel($cfield->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $cfield->varname;
                                                            if($model_1->$field_name)
                                                            {
                                                                if(in_array($cfield->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($model_1->$field_name);
                                                                  }
                                                                  else if($cfield->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($model_1->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                  }
                                                                    else
                                                                    {
                                                                    echo $model_1->$field_name; }
                                                            }
                                                            else
                                                            {
                                                                    echo '-';
                                                            }
                                                            ?></li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->
                                     <div class="clear"></div>
                                </div>
                                
                            </div>
                                
                            </div><br /> <!-- END div class="table_listbx" -->                            
    <!--Student  document  Listing-->
    
                                <?php if(FormFields::model()->isVisible('file','StudentDocument','forOnlineRegistration')){?>
    
    						<table width="100%">
                                                    <tr class="listbxtop_hdng">
                                                            <td colspan="4"><?php echo Yii::t('app','Student Document Details');?></td>                                        
                                                    </tr>
                                                </table>	
    						<div class="document_table">
                            	<?php
								$documents = StudentDocument::model()->findAllByAttributes(array('student_id'=>$model->id)); // Retrieving documents of student with id $_REQUEST['id'];
								if($documents) // If documents present
										{
								?>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                       <th width="40%"><?php echo Yii::t('app','Document Name'); ?></th>
                                       <th width="40%"><?php echo Yii::t('app','Document Type'); ?></th>
                                      <?php if($model->status != 1){ ?> 
                                       <th width="20%"><?php echo Yii::t('app','Download'); ?></th>
                                      <?php } ?> 
                                    </tr>
                                </tbody>
                                </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:none;">
                                    	<?php
                                    	
											foreach($documents as $document) // Iterating the documents
											{
												$studentDocumentList = StudentDocumentList::model()->findByAttributes(array('id'=>$document->title));
										?>
                                                <tr>
                                                    <td width="40%"><?php echo ucfirst($studentDocumentList->name);?></td>
                                                    <td width="40%"><?php echo ucfirst($document->file_type);?></td>
                                                  <?php if($model->status != 1){ ?>   
                                                    <td width="20%">
                                                    	<ul class="tt-wrapper">
                                                        	
															<li>
                                                           		<?php echo CHtml::link('<span>'.Yii::t('app','Download').'</span>', array('admin/download','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-download')); ?>
															</li>
                                                        </ul>
                                                    </td>
                                                  <?php } ?>  
												</tr>
                                        <?php	
											} // End foreach($documents as $document)
										?>
                                        </table>
                                        <?php	
										}										
										else // If no documents present
										{
										?>   
                                        	<br />                                        
                                            <div align="center"><?php echo Yii::t('app','No document(s) uploaded'); ?></div>
                                        <?php
										}
										?>
                                    
                              
                            </div>  
                                <?php } ?><br />
<br />


<?php
$criteria = new CDbCriteria;
					  $criteria->join = 'LEFT JOIN student_document sd ON sd.title = t.id and sd.student_id = '.$model->id.'';
		 			 $criteria->addCondition('sd.title IS NULL');
					
                    $documents = StudentDocumentList::model()->findAll( $criteria);
					if($documents) // If documents present
                            {
								$flag = 1;
								?>
                                <table width="100%">
                                                    <tr class="listbxtop_hdng">
                                                            <td colspan="4"><?php echo Yii::t('app','Missing Document Details');?></td>                                        				<td><?php echo CHtml::link('<span>'.Yii::t('app','Notify Parent').'</span>', array('admin/notify','id'=>$_REQUEST['id']),array('class'=>'formbut','confirm'=>'Notify parent?'));?></td>
                                                    </tr>
                                                </table>
                                                <div class="document_table">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                       <th width="40%"><?php echo Yii::t('app','Document Name'); ?></th>
                                     
                                    </tr>
                                </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:none;">
                                    	<?php
                                    	
											foreach($documents as $document) // Iterating the documents
											{
												
										?>
                                                <tr>
                                                    <td width="40%"><?php echo ucfirst($document->name);?></td>
                                                   
												</tr>
                                        <?php	
											} // End foreach($documents as $document)
										?>
                                        </table>
                                <?php
							}
							
							?>
                            </div><br />
<br />


<?php /*?><?php
if($flag ==1)
{
?>
     <div>
                       <?php echo CHtml::link('<span>'.Yii::t('app','Notify Parent').'</span>', array('admin/notify','id'=>$_REQUEST['id']),array('class'=>'formbut','confirm'=>'Notify parent?'));?></div>
                       <?php } ?><?php */?><br />
<br />
    
                        </div> <!-- END div class="emp_cntntbx" -->
                    </div> <!-- END div class="emp_tabwrapper" -->
                </div> <!-- END div class="emp_right_contner" -->
                
                         
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table> 
<script type="text/javascript">
function check(studentId){
	
	$("[name=batch]").unbind('change');
	$("[name=batch]").change(function(){
		var batchId	= $(this).val();
		$.ajax({
			type: "POST",
			url: <?php echo CJavaScript::encode(Yii::app()->createUrl('onlineadmission/admin/chechclassavailability'))?>,
			data: {'batchId':batchId},
			success: function(result){
				
				 if(result!='nil')
				 {
					$(".newstatus:last-child").show();
					var finalResult = result.split("+");
					$(".newstatus:last-child").text(finalResult[0]);					
					$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[1]+"</span>");
					$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[2]+"</span>");
				 }
				 else
				 {
					 $(".newstatus:last-child").hide();
				 }
				
			}
		});	
	});
	checkclassavailability(studentId);	
}

function checkclassavailability(studentId){
	
	var batchId	= $("[name=batch]:last").val();	
	$.ajax({
		type: "POST",
		url: <?php echo CJavaScript::encode(Yii::app()->createUrl('onlineadmisssion/admin/chechclassavailability'))?>,
		data: {'batchId':batchId},
		success: function(result){
			
			 if(result!='nil')
			 {
				$(".newstatus:last-child").show();
				var finalResult = result.split("+");
				$(".newstatus:last-child").text(finalResult[0]);					
				$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[1]+"</span>");
				$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[2]+"</span>");
			 }
			 else
			 {
				 $(".newstatus:last-child").hide();
			 }
		}
	});	
}
</script>           