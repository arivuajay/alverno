<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('index'),
	Yii::t('app','View'),
);
$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="247" valign="top"><?php $this->renderPartial('profileleft');?></td>
		<td valign="top"><div class="cont_right formWrapper"> 
				<!--<div class="searchbx_area">
    <div class="searchbx_cntnt">
    	<ul>
        <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
        <li><input class="textfieldcntnt"  name="" type="text" /></li>
        </ul>
    </div>
    
    </div>-->
				
				<h1 style="margin-top:.67em;">
					<?php 
						echo Yii::t('app','Student Profile :').' ';
						if(FormFields::model()->isVisible("fullname", "Students", 'forStudentProfile')){
							echo $model->studentFullName('forStudentProfile');
						} 
					?><br />
				</h1>
				<div class="edit_bttns last">
					<ul>
						<li> <?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('update', 'id'=>$model->id,'status'=>1),array('class'=>' edit ')); ?> </li>
						<li> <?php echo CHtml::link('<span>'.Yii::t('app','Students').'</span>', array('students/manage'),array('class'=>'edit last'));?> </li>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="emp_right_contner">
					<div class="emp_tabwrapper">
						<?php $this->renderPartial('tab');?>
						<div class="clear"></div>
						<div class="emp_cntntbx" >
							<?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id)); ?>
							<div class="table_listbx">
								<h5><?php echo Yii::t('app','STUDENT DETAILS');?></h5>
								<div class="listbxtop_hdng"><?php echo Yii::t('app','Personal Details');?></div>
								<div class="prof-view-col">
								<?php if(FormFields::model()->isVisible('admission_date','Students','forStudentProfile')){?>
                                    <ul>
                                        <li class="l-col"><?php echo $model->getAttributeLabel('admission_date');?></li>
                                        <li class="r-col"><?php if($settings!=NULL)
                                                                {	
                                                                    $date1=date($settings->displaydate,strtotime($model->admission_date));
                                                                    echo $date1;
                                        
                                                                }
                                                                else
                                                                echo $model->admission_date; ?></li>
                                    </ul>
                           <?php } ?>
                           <?php if(FormFields::model()->isVisible('national_student_id','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('national_student_id');?></li>
										<li class="r-col"><?php if($model->national_student_id)
																{
																echo $model->national_student_id;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                           <?php if(FormFields::model()->isVisible('date_of_birth','Students','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('date_of_birth');?></li>
										<li class="r-col"> <?php if($settings!=NULL and $model->date_of_birth!=NULL){	
																	$date1=date($settings->displaydate,strtotime($model->date_of_birth));
																	echo $date1;										
																}else{
																	echo '-';
																}
														  ?></li>
									</ul>
                            <?php } ?>
                           
                            <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('gender');?></li>
										<li class="r-col"><?php if($model->gender=='M')
																echo Yii::t('app','Male');
																else 
																echo Yii::t('app','Female');?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('blood_group','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('blood_group');?></li>
										<li class="r-col"><?php if($model->blood_group)
																{
																echo $model->blood_group;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('birth_place','Students','forStudentProfile')){?>                         
									<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('birth_place');?></li>
										<li class="r-col"><?php if($model->birth_place)
																{
																echo $model->birth_place;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?> 
                            <?php if(FormFields::model()->isVisible('nationality_id','Students','forStudentProfile')){?>
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('nationality_id');?></li>
										<li class="r-col"><?php $natio_id=Nationality::model()->findByAttributes(array('id'=>$model->nationality_id));
																if($natio_id){
    															echo $natio_id->name;
																}
																else
																{
																	echo '-';
																}?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('language','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('language');?></li>
										<li class="r-col"><?php if($model->language)
																{
																echo $model->language;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('religion','Students','forStudentProfile')){?>
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('religion');?></li>
										<li class="r-col"><?php if($model->religion)
																{
																echo $model->religion;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul> 
                            <?php } ?> 
                            <?php if(FormFields::model()->isVisible('student_category_id','Students','forStudentProfile')){?>
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('student_category_id');?></li>
										<li class="r-col"><?php if($model->student_category_id){
																$cat =StudentCategories::model()->findByAttributes(array('id'=>$model->student_category_id));
																if($cat !=NULL)
																echo $cat->name;
																}
																else
																{
																	echo '-';
																}?></li>
                                    </ul>
                           <?php } ?>
                           <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(1, 1, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Students','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($model->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($model->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $model->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($model->$field_name) and $model->$field_name!="")?$model->$field_name:"-";
                                                          }
                                                        ?>
														</li>
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
                        	<?php if(FormFields::model()->isVisible('address_line1','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('address_line1');?></li>
										<li class="r-col"><?php if($model->address_line1)
																{
																echo $model->address_line1;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('address_line2','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('address_line2');?></li>
										<li class="r-col"><?php if($model->address_line2)
																{
																echo $model->address_line2;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('city','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('city');?></li>
										<li class="r-col"><?php if($model->city)
																{
																echo $model->city;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('state','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('state');?></li>
										<li class="r-col"><?php if($model->state)
																{
																echo $model->state;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('pin_code','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('pin_code');?></li>
										<li class="r-col"><?php if($model->pin_code)
																{
																echo $model->pin_code;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('country_id','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('country_id');?></li>
										<li class="r-col"><?php if($model->country_id){
																$count = Countries::model()->findByAttributes(array('id'=>$model->country_id));
																if(count($count)!=0)
																echo $count->name;
																}
																else
																{
																	echo '-';
																}?></li>
									</ul>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('phone1','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('phone1');?></li>
										<li class="r-col"><?php if($model->phone1)
																{
																echo $model->phone1;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?>  
                            <?php if(FormFields::model()->isVisible('phone2','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('phone2');?></li>
										<li class="r-col"><?php if($model->phone2)
																{
																echo $model->phone2;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?> 
                            <?php if(FormFields::model()->isVisible('email','Students','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('email');?></li>
										<li class="r-col"><?php if($model->email)
																{
																echo $model->email;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                            <?php } ?> 
                            		
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(1, 2, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Students','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($model->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($model->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $model->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($model->$field_name) and $model->$field_name!="")?$model->$field_name:"-";
                                                          }
                                                        ?>
														
														</li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->               
                         <div class="clear"></div>
                        </div>           
                      
					
								<h5><?php echo Yii::t('app','PARENT DETAILS');?></h5>
								
									<?php 
  $guardian_list_data= GuardianList::model()->findAllByAttributes(array('student_id'=>$model->id));
  if($guardian_list_data)
  {?>
	  
								
                                <?php
      foreach($guardian_list_data as $key=>$data)
      {
        $guardian_model= Guardians::model()->findByPk($data->guardian_id);
        if($guardian_model)
        {      
          ?>
          <div class="listbxtop_hdng"><?php echo Yii::t('app','Personal Details');?></div>
          <div class="prof-view-col">
           						<?php if(FormFields::model()->isVisible('first_name','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('first_name');?></li>
										<li class="r-col"><?php echo ucfirst($guardian_model->first_name); ?></li>
									</ul>
                               <?php } ?>    
                               <?php if(FormFields::model()->isVisible('last_name','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('last_name');?></li>
										<li class="r-col"><?php echo ucfirst($guardian_model->last_name); ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('relation','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('relation');?></li>
										<li class="r-col"><?php if($guardian_model->relation)
																{
																echo $guardian_model->relation;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php }  ?> 
                               <?php if(FormFields::model()->isVisible('dob','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('dob');?></li>
										<li class="r-col"><?php if($settings!=NULL and $guardian_model->dob!=NULL and $guardian_model->dob!='0000-00-00'){	
																	$date1=date($settings->displaydate,strtotime($guardian_model->dob));
																	echo $date1;										
																}else{
																	echo '-';
																}
														  ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('education','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('education');?></li>
										<li class="r-col"><?php if($guardian_model->education)
																{
																echo $guardian_model->education;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?>    
                               <?php if(FormFields::model()->isVisible('occupation','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('occupation');?></li>
										<li class="r-col"><?php if($guardian_model->occupation)
																{
																echo $guardian_model->occupation;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?>    
                               <?php if(FormFields::model()->isVisible('income','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('income');?></li>
										<li class="r-col"><?php if($guardian_model->income)
																{
																echo $guardian_model->income;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?>
                               		
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(2, 1, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Guardians','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $guardian_model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($guardian_model->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($guardian_model->$field_name));
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
														</li>
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
								<?php if(FormFields::model()->isVisible('email','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('email');?></li>
										<li class="r-col"><?php if($guardian_model->email)
																{
																echo $guardian_model->email;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?>
                               <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('mobile_phone');?></li>
										<li class="r-col"><?php if($guardian_model->mobile_phone)
																{
																echo $guardian_model->mobile_phone;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('office_phone1');?></li>
										<li class="r-col"><?php if($guardian_model->office_phone1)
																{
																echo $guardian_model->office_phone1;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('office_phone2');?></li>
										<li class="r-col"><?php if($guardian_model->office_phone2)
																{
																echo $guardian_model->office_phone2;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('office_address_line1');?></li>
										<li class="r-col"><?php if($guardian_model->office_address_line1)
																{
																echo $guardian_model->office_address_line1;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('office_address_line2');?></li>
										<li class="r-col"><?php if($guardian_model->office_address_line2)
																{
																echo $guardian_model->office_address_line2;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('city','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('city');?></li>
										<li class="r-col"><?php if($guardian_model->city)
																{
																echo $guardian_model->city;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('state','Guardians','forStudentProfile')){?>
									<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('state');?></li>
										<li class="r-col"><?php if($guardian_model->state)
																{
																echo $guardian_model->state;
																}
																else 
																{ 
																echo '-';
																} ?></li>
									</ul>
                               <?php } ?> 
                               <?php if(FormFields::model()->isVisible('country_id','Guardians','forStudentProfile')){?> 
                            		<ul>
										<li class="l-col"><?php echo $guardian_model->getAttributeLabel('country_id');?></li>
										<li class="r-col"><?php $count = Countries::model()->findByAttributes(array('id'=>$guardian_model->country_id));
																if(count($count)!=0)
																echo $count->name; ?></li>
									</ul>
                              <?php } ?>
                              		
                                    <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(2, 2, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Guardians','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $guardian_model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($guardian_model->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($guardian_model->$field_name));
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
														</li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->  
                              <div class="clear"></div>
                              </div>
      <?php                         

        }
        else { echo Yii::t('app',"Parent Deatils Not Available");  }
      }
  }
  else
  { ?>
            <div class="notavail"><?php echo Yii::t('app','Parent Deatils Not Available');?></div>
            <?php 
  }
  ?>
								<h5><?php echo Yii::t('app','EMERGENCY CONTACT');?></h5>
								<div class="prof-view-col">
									<div class="notavail" style="font-weight:bold;">
										<?php echo Yii::t('app','In case of emergencies,');?><br />
											<?php echo ' '.Yii::t('app','contact : ');?>
											<?php
	  $posts=Students::model()->findByPk($_REQUEST['id']);
	  if($posts->immediate_contact_id==0)
	  {
		  echo Yii::t('app',"No Guardians are added").'&nbsp;&nbsp;'.CHtml::link(Yii::t('app','Add new'), array('guardians/create&id='.$model->id)); 
	  }
	  else
	  {
              $immed_model= Guardians::model()->findByPk($posts->immediate_contact_id);
              if($immed_model)
			  {
				   if(FormFields::model()->isVisible("fullname", "Guardians", 'forStudentProfile')){
				  
		  echo $immed_model->ParentFullname('forStudentProfile').'&nbsp;&nbsp;'.CHtml::link(Yii::t('app','Edit'), array('/students/guardians/update', 'id'=>$immed_model->id,'std'=>$model->id));
			  }
			  }
	  }
	   ?>
       </div>
       
        <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(3, 1, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'Students','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $model->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($model->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($model->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $model->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($model->$field_name) and $model->$field_name!="")?$model->$field_name:"-";
                                                          }
                                                        ?>
														</li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                    <!-- DYNAMIC FIELDS END -->     						
                                    <div class="clear"></div>
									</div>
									
								
								<h5><?php echo Yii::t('app','STUDENT PREVIOUS DATAS');?></h5>
									<?php
    $previous=StudentPreviousDatas::model()->findAllByAttributes(array('student_id'=>$model->id));
	if(count($previous)==0)
	{
		echo '<div class="notavail" style="font-weight:bold;">';
		echo Yii::t('app','No Previous Datas');
		echo '</div>';
		echo '<div class="notavail" style="font-weight:bold;">'; 
		echo CHtml::link(Yii::t('app','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</div>';	
	}
	else {
	?>
									<?php
		foreach($previous as $prev){
			if($prev->institution!=NULL or $prev->year!=NULL or $prev->course!=NULL or $prev->total_mark!=NULL){
		?>
							<div class="prof-view-col">
                                 <?php if(FormFields::model()->isVisible('institution','StudentPreviousDatas','forStudentProfile')){?> 
									<ul>
										<li class="l-col"><?php echo $prev->getAttributeLabel('institution');?></li>
										<li class="r-col"><?php if($prev->institution!=NULL){echo $prev->institution;} else { echo '-';} ?></li>
									</ul>
                                 <?php } ?> 
                                 <?php if(FormFields::model()->isVisible('year','StudentPreviousDatas','forStudentProfile')){?>   
									<ul>
										<li class="l-col"><?php echo $prev->getAttributeLabel('year');?></li>
										<li class="r-col"><?php if($prev->year!=NULL){ echo $prev->year;} else { echo '-';} ?></li>
									</ul>
                                 <?php } ?>   
									
                                 <?php if(FormFields::model()->isVisible('course','StudentPreviousDatas','forStudentProfile')){?>   
                                 	<ul> 
										<li class="l-col"><?php echo $prev->getAttributeLabel('course');?></li>
										<li class="r-col"><?php if($prev->course!=NULL){echo $prev->course; } else { echo '-';}?></li>
									</ul>
                                 <?php } ?> 
                                 <?php if(FormFields::model()->isVisible('total_mark','StudentPreviousDatas','forStudentProfile')){?>     
									<ul>
										<li class="l-col"><?php echo $prev->getAttributeLabel('total_mark');?></li>
										<li class="r-col"><?php if($prev->total_mark!=NULL){echo $prev->total_mark;} else { echo '-';} ?></li>
									</ul>
                                    
                                 <?php } ?>  
                                 <!-- DYNAMIC FIELDS START -->
                                    <?php 
                                    $fields= FormFields::model()->getDynamicFields(4, 1, "forStudentProfile");
                                    if($fields)
                                    {
                                        foreach ($fields as $key => $field) 
                                        {							
                                            if($field->form_field_type!=NULL)
                                            {
                                                if(FormFields::model()->isVisible($field->varname,'StudentPreviousDatas','forStudentProfile'))
                                                {
                                                    ?>    
                                                        <ul>
                                                        <li class="l-col"><?php echo $prev->getAttributeLabel($field->varname);?></li>                                       
                                                        <li class="r-col">
														<?php
														 $field_name = $field->varname;
                                                          if(in_array($field->form_field_type, array(3, 4, 5))){  // dropdown, radio, checkbox
                                                            echo FormFields::model()->getFieldValue($prev->$field_name);
                                                          }
                                                          else if($field->form_field_type==6){  // date value
                                                            if($settings!=NULL){
                                                              $date1  = date($settings->displaydate,strtotime($prev->$field_name));
                                                              echo $date1;
                                                            }
                                                            else{
                                                              echo $prev->$field_name;
                                                            }
                                                          }
                                                          else{
                                                            echo (isset($prev->$field_name) and $prev->$field_name!="")?$prev->$field_name:"-";
                                                          }
                                                        ?>
														</li>
                                                    </ul><?php
                                                } 
                                            } 				                                            
                                        }
                                    }
                                    ?>
                                   
                                    <!-- DYNAMIC FIELDS END -->     
                                    
									
									<div class="clear"></div>
									<div class="notavail" style="font-weight:bold;"><?php echo CHtml::link(Yii::t('app','Edit'), array('studentPreviousDatas/update','id'=>$model->id,'pid'=>$prev->id)); ?></div>
								</div>
								
									<?php
			}
		}
		
		echo '<div class="notavail" style="font-weight:bold;">';
		echo CHtml::link(Yii::t('app','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</div>';
		?>
									<?php } ?>
								
								
								<div class="ea_pdf" style="top:7px; right:6px;"> <?php echo CHtml::link(Yii::t('app','Generate PDF'), array('Students/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank','class'=>'pdf_but')); ?> </div>
							</div>
						</div>
					</div>
				</div>
			</div></td>
	</tr>
</table>
