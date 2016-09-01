<?php
$this->breadcrumbs=array(
	Yii::t('app','Timetable')=>array('/timetable'),
	Yii::t('app','Weekdays'),
);?>
<!--<script language="javascript">
function getid()
{
var id= document.getElementById('drop').value;
window.location = "index.php?r=weekdays/timetable&id="+id;
}
</script>-->
<style>
.timetable{ width:712px;overflow-x:auto; overflow-y: hidden; }
.timetable table{overflow-x:auto;}
.top{ width:66px;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
        	<div class="cont_right formWrapper">
                <!--<div class="searchbx_area">
                <div class="searchbx_cntnt">
                <ul>
                <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                <li><input class="textfieldcntnt"  name="" type="text" /></li>
                </ul>
                </div>
                
                </div>-->
                
                
                <div class="clear"></div>
                <div class="emp_right_contner">
                    <div class="emp_tabwrapper">
						<?php $this->renderPartial('/default/tab');?>
                        
                        <div class="clear"></div>
                        <div class="emp_cntntbx" style="padding-top:20px;">
                        	<?php
							$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
							if(Yii::app()->user->year)
							{
								$year = Yii::app()->user->year;
							}
							else
							{
								$year = $current_academic_yr->config_value;
							}
							$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
							$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
							$yes_insert = 0;
							$yes_delete = 0;
							if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
							 {
								 $yes_insert = 1;
							 }
							 
							 if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
							 {
								 $yes_delete = 1;
							 }
							 
							 if($year != $current_academic_yr->config_value and ($is_insert->settings_value==0 or $is_delete->settings_value==0))
							 {
									
								?>
								
									<div>
										<div class="yellow_bx" style="background-image:none;width:95%;padding-bottom:45px; margin-bottom:25px;">
											<div class="y_bx_head" style="width:95%;">
											<?php 
												echo Yii::t('app','You are not viewing the current active year. ');
												if($is_insert->settings_value==0 and $is_delete->settings_value!=0)
												{ 
													echo Yii::t('app','To assign a subject, enable Insert option in Previous Academic Year Settings.');
												}
												elseif($is_insert->settings_value!=0 and $is_delete->settings_value==0)
												{
													echo Yii::t('app','To remove a subject, enable Delete option in Previous Academic Year Settings.');
												}
												else
												{
													echo Yii::t('app','To manage the timetable, enable the required options in Previous Academic Year Settings.');	
												}
											?>
											</div>
											<div class="y_bx_list" style="width:95%;">
												<h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
											</div>
										</div>
									</div>
								
								
								<?php	
								}
							 
							?>
                            <div class="c_subbutCon" align="right" style="width:100%">
                                <div class="edit_bttns" style=" top:6px; right:0px">
                                    <ul>
                                    
                                    <li><?php echo CHtml::link('<span>'.Yii::t('app','Set Week Days').'</span>',array('/timetable/weekdays','id'=>$_REQUEST['id']),array('class'=>'addbttn'));?></li>
                                    
                                    <li><?php echo CHtml::link('<span>'.Yii::t('app','Set Class Timings').'</span>',array('/timetable/classTiming','id'=>$_REQUEST['id']),array('class'=>'addbttn last'));?></li>
                                    
                                    </ul>
                                <div class="clear"></div>
                                </div> <!-- END div class="edit_bttns" -->
                            </div> <!-- END div class="c_subbutCon" -->
                            <?php 
                            $present = PeriodEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id']));
                            /*if($present!=NULL){
                            echo CHtml::link(Yii::t('app','Publish Time Table'), array('Weekdays/Publish', 'id'=>$_REQUEST['id']),array('class'=>'cbut')); 
                            }*/
                            ?>&nbsp;
                            
                            <?php $timing = ClassTimings::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id'])); // Display pdf button only if there is class timings.
                            if($timing!=NULL){
                            	echo CHtml::link(Yii::t('app','Generate PDF'), array('Weekdays/pdf','id'=>$_REQUEST['id']),array('class'=>'cbut','target'=>'_blank')); 
                            } ?>
                            
                            <div  style="width:100%">
                            
                                <div class="">
                                
									<?php
                                    
                                    if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)
                                    {
										//Getting dates in a week
										$day = date('w');
										$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
										$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
										$date_between = array();
										$begin = new DateTime($week_start);
										$end = new DateTime($week_end);
										
										$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
										
										foreach($daterange as $date){
											$date_between[] = $date->format("Y-m-d");
										}
										if(!in_array($week_end,$date_between))
										{
											$date_between[] = date('Y-m-d',strtotime($week_end));
										}   
										   
										$times=Batches::model()->findAll("id=:x", array(':x'=>$_REQUEST['id']));
										$weekdays=Weekdays::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));										
										if(count($weekdays)==0)
											$weekdays=Weekdays::model()->findAll("batch_id IS NULL");
										?> 
                                        <br /><br />
										<?php 
										$criteria=new CDbCriteria;
								        $criteria->condition = "batch_id=:x";
								        $criteria->params = array(':x'=>$_REQUEST['id']);
								        $criteria->order = "STR_TO_DATE(start_time, '%h:%i %p')";  
										$timing = ClassTimings::model()->findAll($criteria);
										
										$count_timing = count($timing);
										if($timing!=NULL)
										{
										?>
                                            <div class="timetable" style="margin-top:10px;">
                                                <table border="0" align="center" width="100%" id="table" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="loader">&nbsp;</td><!--timetable_td_tl -->
                                                            <td class="td-blank"></td>
                                                            <?php 
                                                            foreach($timing as $timing_1)
                                                            {
																$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
																if($settings!=NULL)
																{	
																	$time1=date($settings->timeformat,strtotime($timing_1->start_time));
																	$time2=date($settings->timeformat,strtotime($timing_1->end_time));
																}
																echo '<td class="td"><div class="top">'.$time1.' - '.$time2.'</div></td>';	
																//echo '<td class="td"><div class="top">'.$timing_1->start_time.' - '.$timing_1->end_time.'</div></td>';	
                                                            }
                                                            ?>
                                                        </tr> <!-- timetable_tr -->
                                                        <tr class="blank">
                                                            <td></td>
                                                            <td></td>
                                                            <?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
                                                            	echo '<td></td>';  
                                                            }
                                                            ?>
                                                        </tr>
														<?php 
                                                        if($weekdays[0]['weekday']!=0) // SUNDAY
                                                        {
                                                        ?>
                                                        <tr>
                                                        	<td class="td">
                                                            	<div class="name"><?php echo Yii::t('app','SUN');?></div>
															</td>
                                                        	<td class="td-blank"></td>
															<?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo '<td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">'; 
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[0]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		if($yes_insert==1)
																		{
																	  echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'].'").dialog("open"); return false;',														'update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[0]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}	
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																}
																?>
																<?php echo 	'</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?>
                                                        </tr>
														<?php 
                                                        } // SUNDAY
														if($weekdays[1]['weekday']!=0) // MONDAY
														{ 
														?>
														<tr>
															<td class="td">
                                                            	<div class="name"><?php echo Yii::t('app','MON');?></div>
                                                            </td>
															<td class="td-blank"></td>
															<?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'].'").dialog("open"); return false;',															'update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}			
																	
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																}
																
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?>
                                                            <!--timetable_td -->
														</tr><!--timetable_tr -->
														<?php 
														} 
														if($weekdays[2]['weekday']!=0) // TUESDAY
														{
														?>
														<tr>
															<td class="td"><div class="name"><?php echo Yii::t('app','TUE');?></div></td>
															<td class="td-blank"></td>
															<?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[2]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{
																		
																		if($yes_insert == 1)
																		{	
																			echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[2]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																	
																	
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																}
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?><!--timetable_td -->
														
														</tr><!--timetable_tr -->
														<?php 
														} // TUESDAY
														if($weekdays[3]['weekday']!=0) // WEDNESDAY
														{
														?>
														<tr>
                                                            <td class="td"><div class="name"><?php echo Yii::t('app','WED');?></div></td>
                                                            <td class="td-blank"></td>
                                                            <?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[3]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		
																		
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[3]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}	
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));	
																	}
																}
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?><!--timetable_td -->
														</tr><!--timetable_tr -->
														<?php 
														}
														if($weekdays[4]['weekday']!=0) // THURSDAY
														{  ?>
														<tr>
															<td class="td"><div class="name"><?php echo Yii::t('app','THU');?></div></td>
															<td class="td-blank"></td>
															<?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[4]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{	
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[4]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}			
																
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																}
																
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?><!--timetable_td -->
														</tr><!--timetable_tr -->
														<?php 
														}
														if($weekdays[5]['weekday']!=0) // FRIDAY
														{ 
														?>
														<tr>
                                                            <td class="td"><div class="name"><?php echo Yii::t('app','FRI');?></div></td>
                                                            <td class="td-blank"></td>
                                                            <?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[5]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[5]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																}
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?><!--timetable_td -->
														</tr><!--timetable_tr -->
														<?php 
														} 
														if($weekdays[6]['weekday']!=0) // SATURDAY
														{ 
														?>
														<tr>
															<td class="td"><div class="name"><?php echo Yii::t('app','SAT');?></div></td>
															<td class="td-blank"></td>
															<?php
                                                            for($i=0;$i<$count_timing;$i++)
                                                            {
																echo ' <td class="td">
																<div  onclick="" style="position: relative; ">
																<div class="tt-subject">
																<div class="subject">';
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[6]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[6]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'],'class'=>'remove-form')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}
																}
																else
																{
																	if($set->is_elective==0)
																	{
																		
																		$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																		if($time_sub!=NULL)
																		{
																			echo $time_sub->name.'<br>';
																			$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																		if($time_emp!=NULL)
																		{
																			$is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$time_emp->id,'time_table_entry_id'=>$set->id));
																			
																			if($is_substitute and in_array($is_substitute->date_leave,$date_between))
																			{
																				$employee = Employees::model()->findByAttributes(array('id'=>$is_substitute->substitute_emp_id));
																				echo '<div class="employee">'.$employee->first_name.'</div>';
																			}
																			else
																			{
																				if($time_sub!=NULL)
																				{
																					echo '<div class="employee">'.$time_emp->first_name.'</div>';
																				}
																			}
																		}
																		}
																		else
																		{
																			echo '-<br>';
																		}
																	}
																	else
																	{ 
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
																	}
																	
																	
																}
																echo '</div>
																</div>
																</div>
																<div id="jobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'].'"></div>
																</td>';  
                                                            }
                                                            ?><!--timetable_td -->
														</tr>
														<?php 
														}
														?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- END div class="timetable" -->
										<?php 
										}
										else
										{
										echo '<i>'.Yii::t('app','No Class Timings').'</i>';
										
										}?>
                                    
									<?php
                    
                                    } // if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)
                                    
                                    ?> 
                                </div>
                            
                            </div> <!-- END div  style="width:100%" -->
                           
                        </div> <!-- END div class="emp_cntntbx" -->
                    </div> <!-- END div class="emp_tabwrapper" -->
                
                </div> <!-- END div class="emp_right_contner" -->
                
                
                
                
                
                
                
                <?php
                $batch = Weekdays::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));
                if(count($batch)==0)
                    $batch = Weekdays::model()->findAll("batch_id IS NULL");
                ?>
                
               
            
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>
<script>
$('.remove-form,.ui-icon-closethick').click(function(){
	$('#timetable-entries-form').remove();	
	});
</script>