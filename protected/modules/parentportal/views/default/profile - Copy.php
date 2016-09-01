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
						<h4 class="person-name"><?php echo ucfirst($guardian->first_name.' '.$guardian->last_name);?></h4>
						<div class="text-muted"><i class="fa fa-user"></i>
							<?php
                    foreach($students as $student)
					{
						$guardian_relation = GuardianList::model()->findByAttributes(array('guardian_id'=>$guardian->id,'student_id'=>$student->id));
						
						if($guardian_relation){
							echo Yii::t('app',ucfirst($guardian_relation->relation)).' '.Yii::t('app','of').' : '; 
							echo CHtml::link(ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name), array('/parentportal/default/studentprofile','id'=>$student->id)).'&nbsp;&nbsp;&nbsp;';
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
				<table class="table table-hover mb30">
					<thead>
					</thead>
					<tbody>
						<tr>
							<td><strong><?php echo Yii::t('app','Email');?></strong></td>
							<td><?php echo $guardian->email; ?></td>
							<td><strong><?php echo Yii::t('app','Mobile Phone');?></strong></td>
							<td><?php echo $guardian->mobile_phone; ?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','Occupation');?></strong></td>
							<td><?php 
							if($guardian->occupation)
							{
								echo $guardian->occupation;
							}
							else
							{
								echo '-';
							}
							?></td>
							<td><strong><?php echo Yii::t('app','Income');?></strong></td>
							<td><?php 
							if($guardian->income)
							{
								echo $guardian->income;
							}
							else
							{
								echo '-';
							}
							?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','Education');?></strong></td>
							<td><?php 
							if($guardian->education)
							{
								echo $guardian->education;
							}
							else
							{
								echo '-';
							}
							?></td>
							<td><strong><?php echo Yii::t('app','Date of Birth');?></strong></td>
                            <td><?php 
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
							?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','Office Phone 1');?></strong></td>
							<td><?php 
							if($guardian->office_phone1)
							{
								echo $guardian->office_phone1;
							}
							else
							{
								echo '-';
							}
							?></td>
							<td><strong><?php echo Yii::t('app','Office Phone 2');?></strong></td>
							<td><?php 
							if($guardian->office_phone2)
							{
								echo $guardian->office_phone2;
							}
							else
							{
								echo '-';
							}
							?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','Office Address Line 1');?></strong></td>
							<td><?php 
							if($guardian->office_address_line1)
							{
								echo $guardian->office_address_line1;
							}
							else
							{
								echo '-';
							}
							?></td>
							<td><strong><?php echo Yii::t('app','Office Address Line 2');?></strong></td>
							<td><?php 
							if($guardian->office_address_line2)
							{
								echo $guardian->office_address_line2;
							}
							else
							{
								echo '-';
							}
							?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','City');?></strong></td>
							<td><?php 
							if($guardian->city)
							{
								echo $guardian->city;
							}
							else
							{

								echo '-';
							}
							?></td>
							<td><strong><?php echo Yii::t('app','State');?></strong></td>
							<td><?php 
							if($guardian->state)
							{
								echo $guardian->state;
							}
							else
							{
								echo '-';
							}
							?></td>
						</tr>
						<tr>
							<td><strong><?php echo Yii::t('app','Country');?></strong></td>
							<td><?php 
							if($guardian->country_id)
							{
								$country = Countries::model()->findByAttributes(array('id'=>$guardian->country_id));
								if($country)
								{
									echo $country->name;
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
							?></td>
							<td colspan="2">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<!-- panel --> 
			
		</div>
	</div>
</div>