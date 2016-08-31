<!--<script language="javascript">
<!--<script language="javascript">
function getid()
{
    var id= document.getElementById('drop').value;
    window.location = "index.php?r=weekdays/timetable&id="+id;
}
</script>-->

<style>
.container
{
	background:#FFF;
}

.tt-subject {
    width: 80px;
}
</style>
<?php
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

$batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
$this->breadcrumbs=array(
Yii::t('app','Courses')=>array('/courses'),
$batch->name=>array('/courses/batches/batchstudents','id'=>$_REQUEST['id']),
Yii::t('app','TimeTable'),
);
?>
<div style="background:#FFF;"> <!-- DIV 1 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
        <td valign="top">
			<?php                                
			if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)
			{ 
			?>
            	<div style="padding:20px;"> <!-- DIV 2 -->
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
                            <?php $this->renderPartial('/batches/tab');?>
                            <div class="clear"></div>
                            <div class="emp_cntntbx" style="padding-top:10px;">
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
                                $is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
								$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
                                $is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
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
								 
                                ?>
                            
                            	
                                <div class="c_subbutCon" align="right" style="width:100%">
                                    <div class="edit_bttns" style=" top:7px; right:-4px;">
                                        <ul>
                                            <li>
                                            <?php echo CHtml::link('<span>'.Yii::t('app','Set Week Days').'</span>', array('/courses/weekdays','id'=>$_REQUEST['id']),array('class'=>'addbttn'));?>
                                            </li>
                                            <li>
                                            <?php echo CHtml::link('<span>'.Yii::t('app','Set Class Timings').'</span>', array('/courses/classTiming','id'=>$_REQUEST['id']),array('class'=>'addbttn last'));?>
                                            </li>
                                        </ul>
                                    <div class="clear"></div>
                                    </div> <!-- END div class="edit_bttns" -->
                                </div> <!-- END div class="c_subbutCon" -->
                            
                                <div  style="width:100%">
                                    <div>
										<?php     
                                        $times=Batches::model()->findAll("id=:x", array(':x'=>$_REQUEST['id']));
                                        $weekdays=Weekdays::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));
                                        if(count($weekdays)==0)
                                        	$weekdays=Weekdays::model()->findAll("batch_id IS NULL");
                                        ?> <br /><br />
                                        <?php   
										$criteria=new CDbCriteria;
										$criteria->condition = "batch_id = :batch_id";
   										$criteria->params=(array(':batch_id'=>$_REQUEST['id']));
										$criteria->order = "STR_TO_DATE(start_time, '%h:%i %p')";
                                        $timing = ClassTimings::model()->findAll($criteria);
                                        $count_timing = count($timing);
                                        if($timing!=NULL)
                                        {
                                        ?>
                                        	<div style="position:absolute; top:13px; left:0px; width:240px; height:35px;"> 
												<?php //echo CHtml::link(Yii::t('app','Publish Time Table'), array('Weekdays/Publish', 'id'=>$_REQUEST['id']),array('class'=>'cbut')); ?>&nbsp;
                                                <?php echo CHtml::link(Yii::t('app','Generate PDF'), array('Weekdays/pdf','id'=>$_REQUEST['id']),array('class'=>'cbut','target'=>'_blank')); ?>
                                            </div>
                                
                                            <div class="timetable" style="margin-top:10px; width:959px; overflow:scroll">
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
																echo '<td class="td"><div class="top">'.$time1.' -<br> '.$time2.'</div></td>';	
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
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[0]['weekday'],
																		'class_timing_id'=>$timing[$i]['id'])); 			
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),
																		array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'].'").dialog("open"); return false;',
																		      'update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'],'type' =>'GET',
																			  'data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[0]['weekday'],'class_timing_id'=>$timing[$i]['id']),
																			  'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[0]['weekday'],'class'=>'assignbutton')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),
																			array('class'=>'addbttn last','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}	
																}
																else
																{
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL)
																	{
																		echo $time_sub->name.'<br>';
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
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																	array('confirm'=>Yii::t('app','Are you sure you want to delete this subject?'),'class'=>'delete'));
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
																//echo "batch".$_REQUEST['id'];
																//echo "week_id".$weekdays[1]['weekday'];
																//echo "classtiming".$timing[$i]['id'];exit;
																$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 	
																//var_dump($set);exit;		
																if(count($set)==0)
																{
																	$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
																	if($is_break==NULL)
																	{	
																		
																		if($yes_insert==1)
																		{
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'].'").dialog("open"); return false;',															'update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[1]['weekday'],'class'=>'assignbutton')) ;
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
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	
																	$time_emp = Employees::model()->findByAttributes(array('id'=>$set->employee_id));
																	if($time_sub!=NULL)
																	{
																		echo $time_sub->name.'<br>';
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
																	
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																				array('confirm'=>Yii::t('app','Are you sure you want to delete this subject? '),'class'=>'delete'));
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
																			echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[2]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[2]['weekday'],'class'=>'assignbutton')) ;
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
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL){echo $time_sub->name.'<br>';}
																	else
																	{
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
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
																	
																	if($yes_delete == 1)
																	{
																	echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																				array('confirm'=>Yii::t('app','Are you sure you want to delete this subject?'),'class'=>'delete'));
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
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[3]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[3]['weekday'],'class'=>'assignbutton')) ;
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
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL){echo $time_sub->name.'<br>';}
																	else
																	{
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
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
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																		array('confirm'=>Yii::t('app','Are you sure you want to delete this subject? '),'class'=>'delete'));	
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
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[4]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[4]['weekday'],'class'=>'assignbutton')) ;
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
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL){echo $time_sub->name.'<br>';}
																	else
																	{
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
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
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																		array('confirm'=>Yii::t('app','Are you sure you want to delete this subject?'),'class'=>'delete'));
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
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[5]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[5]['weekday'],'class'=>'assignbutton')) ;
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
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL){echo $time_sub->name.'<br>';}
																	else
																	{
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
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
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																		array('confirm'=>Yii::t('app','Are you sure you want to delete this subject?'),'class'=>'delete'));
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
																		echo CHtml::ajaxLink(Yii::t('app','Assign'),$this->createUrl('TimetableEntries/settime'),array('onclick'=>'$("#jobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'].'").dialog("open"); return false;','update'=>'#jobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'],'type' =>'GET','data'=>array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[6]['weekday'],'class_timing_id'=>$timing[$i]['id']),'dataType'=>'text',),array('id'=>'showJobDialog'.$timing[$i]['id'].$weekdays[6]['weekday'],'class'=>'set_time','class'=>'assignbutton')) ;
																		}
																		else
																		{
																			echo CHtml::link('<span>'.Yii::t('app','Assign').'</span>', array('#'),
																			array('class'=>'addbttn last set_time','onclick'=>'alert("'.Yii::t('app','Enable Insert Option in Previous Academic Year Settings').'"); return false;'));
																		}
																		
																		
																	}
																	else
																	{
																		echo Yii::t('app','Break');
																	}
																}
																else
																{
																	$time_sub = Subjects::model()->findByAttributes(array('id'=>$set->subject_id));
																	if($time_sub!=NULL){echo $time_sub->name.'<br>';}
																	else
																	{
																		$elec_sub = Electives::model()->findByAttributes(array('id'=>$set->subject_id));
																		$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['id']));
																		
																		if($electname!=NULL)
																		{
																			echo $electname->name.'<br>';
																		}
																		
																	}
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
																	
																	if($yes_delete == 1)
																	{
																		echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['id']),
																					array('confirm'=>Yii::t('app','Are you sure you want to delete this subject?'),'class'=>'delete'));
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
                                            </div>
										<?php 
                                        }
                                        else
                                        { //echo '<i>'.Yii::t('app','No Class Timings').'</i>';
										?>
                                            
											 <div><br />
												<div class="a_feed_innercntnt" style="text-align:center; padding:10px; border:none;">
													<div></div>
													<h1><strong><?php echo '<i>'.Yii::t('app','No Class Timings are set!').'</i>'; ?></strong></h1>
												</div>
											</div>
										<?php                                            
                                        }?>
                                    </div>                            
                                </div> <!-- END div  style="width:100%" -->
                            </div> <!-- END div class="emp_cntntbx" -->
                                
                                
                                <!--<div class="table_listbx">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody><tr>
                                <td class="listbx_subhdng">Sl no.</td>
                                <td class="listbx_subhdng">Student Name</td>
                                <td class="listbx_subhdng">Admission Number</td>
                                <td class="listbx_subhdng">Gender</td>
                                <td class="listbx_subhdng">Actions</td>
                                </tr>
                                <tr><td>1</td><td><a href="/osv2.1/osadmin/index.php?r=students/view&amp;id=1">Balusamy</a></td><td>1</td><td>fff</td><td>gggg</td>                    </tr></tbody></table>
                              
                                </div>-->
                                <!--</div>
                                </div>-->
                                
                                
						</div> <!-- END div class="emp_tabwrapper" -->
					</div> <!-- END div class="emp_right_contner"-->
				</div> <!-- END DIV 2 -->
				<?php
				$batch = Weekdays::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));
				if(count($batch)==0)
					$batch = Weekdays::model()->findAll("batch_id IS NULL");
				?>            
           <?php
            }
            ?>
            
        </td>
    </tr>
</table>
</div> <!-- END DIV 1 -->
<script>
$(".assignbutton").click(function(e) {
    $('form#timetable-entries-form').remove();
	$('#elective_table').remove();
});
</script>
