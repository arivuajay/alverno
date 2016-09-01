<?php
$this->breadcrumbs=array(
	Yii::t('app','Weekdays')=>array('index'),
	Yii::t('app','Manage'),
);
?>
<style>
#table{
	border-top:1px #C5CED9 solid;
	/*margin:30px 30px;*/
	border-right:1px #C5CED9 solid;
}
.timetable td{
	border-left:1px #C5CED9 solid;
	padding:10px;
	border-bottom:1px #C5CED9 solid;
	width:auto;
	/*min-width:30px;*/
	font-size:10px;
	text-align:center;
}
hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}
</style>

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
	?> 
        <!-- Header -->
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="first">
                               <?php $logo=Logo::model()->findAll();?>
                                <?php
                                if($logo!=NULL)
                                {
                                    //Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
                                    echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" height="100" />';
                                }
                                ?>
                    </td>
                    <td align="center" valign="middle" class="first" style="width:300px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; padding-left:10px;">
                                    <?php $college=Configurations::model()->findAll(); ?>
                                    <?php echo $college[0]->config_value; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                    <?php echo $college[1]->config_value; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                    <?php echo 'Phone: '.$college[2]->config_value; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
      <hr />
        <!-- End Header --> 
    <div align="center" style="display:block; text-align:center;"><?php echo Yii::t('app','CLASS TIME TABLE');?></div><br />
    <!-- Course details -->
     <table style="font-size:14px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
            <?php $batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
                  $course_name = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
				  $class_teacher = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
            ?>
            <tr>
                <td style="width:130px;"><?php echo Yii::t('app','Course');?></td>
                <td style="width:10px;">:</td>
                <td style="width:550px;"><?php echo $course_name->course_name; ?></td>
            
                <td  style="width:130px;"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                <td style="width:10px;">:</td>
                <td><?php echo $batch->name; ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('app','Class Teacher');?></td>
                <td>:</td>
                <td >
					<?php 
					if($class_teacher!=NULL)
					{
						echo $class_teacher->first_name.' '.$class_teacher->last_name;
					}
					else
					{
						echo '-';
					}
					?>
				</td>
   				<?php
				$total_students = Students::model()->countByAttributes(array('batch_id'=>$_REQUEST['id'],'is_active'=>1,'is_deleted'=>0));
				?>
                <td><?php echo Yii::t('app','Total students');?></td>
                <td>:</td>
                <td width="195"><?php echo $total_students; ?></td>
            </tr>
           
        </table>

    <!-- END Course details -->
     <?php    
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
		if(isset($timing) and $timing!=NULL)
		{
	?>

		
		<table  align="left" width="100%" id="table" cellspacing="0" cellpadding="0" class="timetable" >
			<tr style="background:#DCE6F1">
			  <td  style="background:#DCE6F1;">&nbsp;</td>
			  <?php 
					foreach($timing as $timing_1)
					{
						//echo $timing_1->start_time.'<br>';  ?>
					<?php echo '<td style="font-size:11px;background:#E1EAEF;word-break:break-all;">'.$timing_1->start_time .' -<br> '.$timing_1->end_time.'</td>';?>
				<?php 	}
			   ?>
			</tr> <!-- timetable_tr -->
			
			<?php if($weekdays[0]['weekday']!=0)
			{ ?>
			<tr>
				<td><?php echo 	 Yii::t('app','SUN') ;?></td>
		 
				 <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						  ?>
						<td class="td">
							<?php
		$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[0]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{		
							$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
							if($is_break!=NULL)
							{	
								echo  Yii::t('app','Break');	
							}	
						}
						elseif($set->is_elective ==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
				 ?>
							
						  </td>
					<?php  }
					  ?>
				 </tr>
			  <?php }  ?>
			  <?php   if($weekdays[1]['weekday']!=0)
			  { ?>
			  <tr>
				<td><?php echo 	 Yii::t('app','MON') ;?></td>
			  
					 <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?> <td>
					   <?php 
								
				$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
								$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
								if($is_break!=NULL)
								{	
									echo  Yii::t('app','Break');	
								}	
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
						?> </td>
						<?php  
					 }
					?>
				  <!--timetable_td -->
				
			  </tr><!--timetable_tr -->
			  <?php } ?>
			 <?php  if($weekdays[2]['weekday']!=0)
			  {
			  ?>
				  <tr>
				<td ><?php echo 	 Yii::t('app','TUE') ;?></td>
			  
				 <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?> <td>
					<?php		
						$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[2]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
							$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
							if($is_break!=NULL)
							{	
								echo  Yii::t('app','Break');	
							}	
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
							?>
							  </td> 
					<?php  }
					?><!--timetable_td -->
				
			  </tr><!--timetable_tr -->
			  <?php } ?>
			  <?php
			  if($weekdays[3]['weekday']!=0)
			  { ?>
				  <tr>
				<td><?php echo 	 Yii::t('app','WED') ;?></td>
			 
				 <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?> <td >
								<?php 
									$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[3]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
								$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
								if($is_break!=NULL)
								{	
									echo  Yii::t('app','Break');	
								}							
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
								?>
							  </td>
					 <?php           
					 }
					?><!--timetable_td -->
				
			  </tr><!--timetable_tr -->
			  <?php }
			  ?>
			  <?php
			  if($weekdays[4]['weekday']!=0)
			  {  ?>
				  <tr>
				<td><?php echo 	 Yii::t('app','THU') ;?></td>
			 
				  <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?><td>
					   <?php  
						$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[4]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
								$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
								if($is_break!=NULL)
								{	
									echo  Yii::t('app','Break');	
								}	
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
						?>
							  </td>  
					 <?php
					 }
					?><!--timetable_td -->
				
			  </tr><!--timetable_tr -->
			  <?php } ?>
			  <?php
			  if($weekdays[5]['weekday']!=0)
			  { ?>
			  
				  <tr>
				<td><?php echo 	 Yii::t('app','FRI') ;?></td>
			   
				 <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?><td>
						<?php		
						$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[5]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
							$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
							if($is_break!=NULL)
							{	
								echo  Yii::t('app','Break');	
							}	
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
						 ?>
							  </td>
					  <?php        
					 }
					?><!--timetable_td -->
				
			  </tr><!--timetable_tr -->
			  <?php }  ?>
			  <?php
			  if($weekdays[6]['weekday']!=0)
			  { ?>
			  <tr>
				<td><?php echo 	 Yii::t('app','SAT') ;?></td>
				
				  <?php
					  for($i=0;$i<$count_timing;$i++)
					  {
						?><td class="td">
						<?php	
									$set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$_REQUEST['id'],'weekday_id'=>$weekdays[6]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
						if(count($set)==0)
						{	
							$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
							if($is_break!=NULL)
							{	
								echo  Yii::t('app','Break');	
							}
						}
						elseif($set->is_elective==0)
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
										echo '<span style="font-size:9px;">(' .$employee->first_name.')</span>';										
									}
									else
									{
										echo '<span style="font-size:9px;">(' .$time_emp->first_name.')</span>';
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
						 ?>
							  </td>
				   <?php            
					 }
					?><!--timetable_td -->
				
			  </tr>
			<?php } ?>
		  </table>
		
	<?php
	 }
     else
	 {
	?>
		
        <?php echo  '<i>'.Yii::t('app','No Class Timings is set for this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i>'; ?>
       
    	
	<?php
	 }
	 ?>
     
       <?php /*?><?php
		$batch = Weekdays::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));
		if(count($batch)==0)
		$batch = Weekdays::model()->findAll("batch_id IS NULL");
		?><?php */?>
        
        <?php
		
	}
	?>
 
