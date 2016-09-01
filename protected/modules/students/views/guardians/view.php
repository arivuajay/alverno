
<?php
$this->breadcrumbs=array(
	Yii::t('app','Guardians')=>array('admin'),
	Yii::t('app','Manage'),
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
                <td width="247" valign="top">
			<?php $this->renderPartial('/default/left_side');?>
                </td>
                <td valign="top">
                <div class="cont_right formWrapper">
                	<?php
                    $guardian = Guardians::model()->findByAttributes(array('id'=>$_REQUEST['id']));                    
                   $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                    ?>
                    <h1><?php echo Yii::t('app','Guardian Profile').' : '.$guardian->parentFullName("forStudentProfile");?></h1>
                    
                   
                    <div class="emp_cntntbx">
                        <div class="table_listbx">
                        	<h5><?php echo Yii::t('app','GUARDIAN DETAILS');?></h5>
                                <div class="listbxtop_hdng"><?php echo Yii::t('app','Personal Details');?></div>
                                <div class="prof-view-col">
				<?php if(FormFields::model()->isVisible('first_name','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('first_name');?></li>                                       
                                        <li class="r-col"><?php echo $model->first_name; ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('last_name','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('last_name');?></li>                                       
                                        <li class="r-col"><?php echo $model->last_name; ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('relation','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('relation');?></li>                                       
                                        <li class="r-col"><?php echo $model->relation; ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('dob','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('dob');?></li>                                       
                                        <li class="r-col"><?php 
									
									if($guardian->dob=="0000-00-00")
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
										else
										{
										echo $guardian->dob;
										}
									}
									?></li>
                                    </ul>
                                <?php } ?>
                                    
                                    <?php if(FormFields::model()->isVisible('education','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('education');?></li>                                       
                                        <li class="r-col"><?php 
										if($guardian->education)
										{
											echo ucfirst($guardian->education); 
										}
										else
										{
											echo '-';
										}
										?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('occupation','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('occupation');?></li>                                       
                                        <li class="r-col"><?php if($guardian->occupation)
										{
											echo ucfirst($guardian->occupation);
										}
										else
										{
											echo '-';
										}?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('income','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('income');?></li>                                       
                                        <li class="r-col"><?php 
										if($guardian->income)
										{
											echo $guardian->income; 
										}
										else
										{
											echo '-';
										}
										?></li>
                                    </ul>
                                <?php } ?>
                                    
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Guardians','forAdminRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $field->varname;
                                                            if($guardian->$field_name)
                                                            {
                                                                if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($guardian->$field_name);
                                                                  }
                                                                  else if($field->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($guardian->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                    else {
                                                                    echo $guardian->$field_name; }
                                                                        
                                                                  }
                                                                    else
                                                                    {
                                                                    echo $guardian->$field_name; }
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
                                    <?php if(FormFields::model()->isVisible('email','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('email');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->email)
                                            {
                                                echo $guardian->email;
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('mobile_phone');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->mobile_phone)
                                            {
                                                echo $guardian->mobile_phone;
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_phone1');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->office_phone1)
                                            {
                                                echo $guardian->office_phone1;
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_phone2');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->office_phone2)
                                            {
                                                echo $guardian->office_phone2;
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_address_line1');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->office_address_line1)
                                            {
                                                echo ucfirst($guardian->office_address_line1);
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('office_address_line2');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->office_address_line2)
                                            {
                                                echo ucfirst($guardian->office_address_line2);
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('city','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('city');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->city)
                                            {
                                                echo ucfirst($guardian->city);
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('state','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('state');?></li>                                       
                                        <li class="r-col"><?php
                                            if($guardian->state)
                                            {
                                                echo ucfirst($guardian->state);
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?></li>
                                    </ul>
                                <?php } ?>
                                    <?php if(FormFields::model()->isVisible('country_id','Guardians','forAdminRegistration')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('country_id');?></li>                                       
                                        <li class="r-col"><?php 
										if($guardian->country_id!=NULL)
										{
											$posts=Countries::model()->findByAttributes(array('id'=>$guardian->country_id));
											echo $posts->name; 
										}
										else
										{
											echo '-';
										}?></li>
                                    </ul>
                                <?php } ?>
                                    
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $contact_fields= FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
                                    if($contact_fields)
                                    {
                                        foreach ($contact_fields as $ckey => $cfield) 
                                        {							
                                            if($cfield->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($cfield->varname,'Guardians','forAdminRegistration'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($cfield->varname);?></li>                                       
                                                        <li class="r-col"><?php 
                                                        $field_name= $cfield->varname;
                                                            if($guardian->$field_name)
                                                            {
                                                                if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                                    echo FormFields::model()->getFieldValue($guardian->$field_name);
                                                                  }
                                                                  else if($field->form_field_type==6){  // date value
                                                                    if($settings!=NULL){
                                                                      $date1  = date($settings->displaydate,strtotime($guardian->$field_name));
                                                                      echo $date1;
                                                                    }
                                                                    else {
                                                                    echo $guardian->$field_name; }
                                                                        
                                                                  }
                                                                    else
                                                                    {
                                                                    echo $guardian->$field_name; }
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
                   
                    <div class="pdtab_Con" style="position:relative;">
                        <h1><?php echo Yii::t('app','Students Details');?></h1>                        
                          
                    
                    <?php
                    $criteria = new CDbCriteria;		
					$criteria->join = 'LEFT JOIN guardian_list t1 ON t.id = t1.student_id'; 
					$criteria->condition = 't1.guardian_id=:guardian_id and t.is_active=:is_active and is_deleted=:is_deleted';
					$criteria->params = array(':guardian_id'=>$guardian->id,':is_active'=>1,'is_deleted'=>0);
					$active_students = Students::model()->findAll($criteria);					
                    ?>
                  
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                        <tr class="pdtab-h" >
                            <td align="center"><?php echo Yii::t('app','Sl No.');?></td>
                            <td align="center"><?php echo Yii::t('app','Student Name');?></td>
                            <?php if(FormFields::model()->isVisible('relation','Guardians','forAdminRegistration')){?>
                            <td align="center"><?php echo Yii::t('app','Relation');?></td>
                            <?php } ?>
                            
                        </tr>
<?php
					if($active_students){
						$i = 1;
						foreach($active_students as $active_student){
							$relation = GuardianList::model()->findByAttributes(array('student_id'=>$active_student->id,'guardian_id'=>$_REQUEST['id']));
?>
							<tr>
                            	<td align="center"><?php echo $i; ?></td>
                                <td align="center"><?php 
                                $name= "";
                                if(FormFields::model()->isVisible('first_name','Students','forAdminRegistration'))
                                {
                                    $name.= ucfirst($active_student->first_name);
                                }
                                if(FormFields::model()->isVisible('middle_name','Students','forAdminRegistration'))
                                {
                                    $name.= " ".ucfirst($active_student->middle_name);
                                }
                                if(FormFields::model()->isVisible('last_name','Students','forAdminRegistration'))
                                {
                                    $name.= " ".ucfirst($active_student->last_name);
                                }
                                echo CHtml::link($name,array('/students/students/view','id'=>$active_student->id)); 
                                //echo CHtml::link(ucfirst($active_student->first_name).' '.ucfirst($active_student->middle_name).' '.ucfirst($active_student->last_name),array('/students/students/view','id'=>$active_student->id)); 
                                ?>
                                </td>
                                <?php if(FormFields::model()->isVisible('relation','Guardians','forAdminRegistration')){?>
                                <td align="center"><?php echo ucfirst($relation->relation); ?></td><?php } ?>
                            </tr>
<?php	
							$i++;						
						}
					}else{
?>
						<tr><td colspan="3"><?php echo Yii::t('app','Nothing Found'); ?></td></tr>
<?php						
					}
?>                   
                    </table>
                    
                                                        
                    </div>
                </div>
    	</td>
	</tr>
</table>


