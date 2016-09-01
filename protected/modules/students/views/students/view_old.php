<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('index'),
	Yii::t('app','View'),
);


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
				
				<h1 style="margin-top:.67em;"><?php echo Yii::t('app','Student Profile :');?> <?php echo ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name); ?><br />
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
								<h5>Student Details</h5>
								<div class="listbxtop_hdng"><?php echo Yii::t('app','Student Details');?></div>
								<div class="prof-view-col">
								<?php if(FormFields::model()->isVisible('admission_date','Students','forStudentProfile')){	?>
								
									<ul>
										<li class="l-col"><?php echo $model->getAttributeLabel('admission_date');?></li>
										<li class="r-col"><?php 
								
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->admission_date));
									echo $date1;
		
								}
								else
								echo $model->admission_date; ?></li>
								
									</ul>
                                    <?php } ?>
                                    <?php if(FormFields::model()->isVisible('city','Students','forStudentProfile')){ ?> 
									<ul>
										<li class="l-col"><?php echo Yii::t('app','City');?></li>
										<li class="r-col"><?php echo $model->city; ?></li>
									</ul>
                                    <?php } ?>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Date of Birth');?></li>
										<li class="r-col"><?php 
									if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->date_of_birth));
									echo $date1;
		
								}
								else
								echo $model->date_of_birth; 
								 ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Birth Place');?></li>
										<li class="r-col"><?php echo $model->birth_place; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Blood Group');?></li>
										<li class="r-col"><?php echo $model->blood_group; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','State');?></li>
										<li class="r-col"><?php echo $model->state; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Country');?></li>
										<li class="r-col"><?php 
	$count = Countries::model()->findByAttributes(array('id'=>$model->country_id));
	if(count($count)!=0)
	echo $count->name; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Nationality');?></li>
										<li class="r-col"><?php
    $natio_id=Nationality::model()->findByAttributes(array('id'=>$model->nationality_id));
    echo $natio_id->name;?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Gender');?></li>
										<li class="r-col"><?php if($model->gender=='M')
			echo Yii::t('app','Male');
		else 
			echo Yii::t('app','Female');	 ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Pin Code');?></li>
										<li class="r-col"><?php echo $model->pin_code; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Address Line 1');?></li>
										<li class="r-col"><?php echo $model->address_line1; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Address Line 2');?></li>
										<li class="r-col"><?php echo $model->address_line2; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Phone 1');?></li>
										<li class="r-col"><?php echo $model->phone1; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Phone 2');?></li>
										<li class="r-col"><?php echo $model->phone2; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Language');?></li>
										<li class="r-col"><?php echo $model->language; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Email');?></li>
										<li class="r-col"><?php echo $model->email; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Category');?></li>
										<li class="r-col"><?php 
	$cat =StudentCategories::model()->findByAttributes(array('id'=>$model->student_category_id));
	if($cat !=NULL)
	 echo $cat->name; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Religion');?></li>
										<li class="r-col"><?php echo $model->religion; ?></li>
									</ul>
									<div class="clear"></div>
								</div>
								<h5>Student Details</h5>
								<div class="listbxtop_hdng"><?php echo Yii::t('app','Parent Details');?></div>
								<div class="prof-view-col">
									<?php 
  $guardian_list_data= GuardianList::model()->findAllByAttributes(array('student_id'=>$model->id));
  if($guardian_list_data)
  {
      foreach($guardian_list_data as $key=>$data)
      {
        $guardian_model= Guardians::model()->findByPk($data->guardian_id);
        if($guardian_model)
        {      
          ?>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Name');?></li>
										<li class="r-col"><?php echo ucfirst($guardian_model->first_name).' '.ucfirst($guardian_model->last_name); ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Relation');?></li>
										<li class="r-col"><?php echo $data->relation; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Address Line 1');?></li>
										<li class="r-col"><?php echo $guardian_model->office_address_line1; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Address Line 2');?></li>
										<li class="r-col"><?php echo $guardian_model->office_address_line2; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Occupation');?></li>
										<li class="r-col"><?php echo $guardian_model->occupation;  ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Email Address');?></li>
										<li class="r-col"><?php echo $guardian_model->email; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Contact Number');?></li>
										<li class="r-col"><?php echo $guardian_model->mobile_phone; ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Office Phone 1');?></li>
										<li class="r-col"><?php echo $guardian_model->office_phone1;  ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Office Phone 2');?></li>
										<li class="r-col"><?php echo $guardian_model->office_phone2;  ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','City');?></li>
										<li class="r-col"><?php echo $guardian_model->city;  ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','State');?></li>
										<li class="r-col"><?php echo $guardian_model->state;  ?></li>
									</ul>
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
								<div class="listbxtop_hdng"><?php echo Yii::t('app','Emergency Contact');?></div>
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
		  echo ucfirst($immed_model->first_name).' '.ucfirst($immed_model->last_name).'&nbsp;&nbsp;'.CHtml::link(Yii::t('app','Edit'), array('/students/guardians/update', 'id'=>$immed_model->id,'std'=>$model->id));
	  }
	   ?>
									</div>
									<div class="clear"></div>
								</div>
								<div class="listbxtop_hdng"><?php echo Yii::t('app','Student Previous Datas');?></div>
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
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Institution');?></li>
										<li class="r-col"><?php if($prev->institution!=NULL){echo $prev->institution;} else { echo '-';} ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Year');?></li>
										<li class="r-col"><?php if($prev->year!=NULL){ echo $prev->year;} else { echo '-';} ?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Course');?></li>
										<li class="r-col"><?php if($prev->course!=NULL){echo $prev->course; } else { echo '-';}?></li>
									</ul>
									<ul>
										<li class="l-col"><?php echo Yii::t('app','Total Mark');?></li>
										<li class="r-col"><?php if($prev->total_mark!=NULL){echo $prev->total_mark;} else { echo '-';} ?></li>
									</ul>
									
									<div class="clear"></div>
									<div class="notavail" style="font-weight:bold;"><?php echo CHtml::link(Yii::t('app','Edit'), array('studentPreviousDatas/update','id'=>$model->id,'pid'=>$prev->id)); ?></div>
								</div>
								<div class="notavail" style="font-weight:bold;">
									<?php
			}
		}
		
		echo CHtml::link(Yii::t('app','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		
		?>
									<?php } ?>
								</div>
								
								<div class="ea_pdf" style="top:4px; right:6px;"> <?php echo CHtml::link(Yii::t('app','Generate PDF'), array('Students/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank','class'=>'pdf_but')); ?> </div>
							</div>
						</div>
					</div>
				</div>
			</div></td>
	</tr>
</table>
