<?php
//echo $course_id.'<br/>'.$batch_id.'<br/>'.$mode; 

// ******************* WEEK TABLE *********************/
if($mode == 1)
{

?>
    <div class="timetable" style="text-align:center">
        <?php
		
		$weekdays = Weekdays::model()->findAll("batch_id=:x", array(':x'=>$batch_id)); // Selecting weekdays of the batch
		if(count($weekdays) == 0)
		{
			$weekdays = Weekdays::model()->findAll("batch_id IS NULL");
		}
		
		$criteria=new CDbCriteria;
		$criteria->condition = "batch_id=:x";
		$criteria->params = array(':x'=>$batch_id);
		$criteria->order = "STR_TO_DATE(start_time, '%h:%i %p')";
        $timing = ClassTimings::model()->findAll($criteria); // Selecting class timings of the batch
		$count_timing = count($timing);
        if($timing!=NULL) // If class timing is set for the batch
        {
        ?>  
            
                <table border="0" align="center" width="100%" id="table" cellspacing="0">
                    <tbody>
                    	
                        <tr>
                            <td class="loader">&nbsp;</td>
                            <td class="td-blank"></td>
                            <?php 
                            foreach($timing as $timing_1)
							{
								echo '<td class="td"><div class="top">'.$timing_1->start_time.' - '.$timing_1->end_time.'</div></td>';	
							}
                            ?>
                        </tr> 
                        
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
						// SUNDAY
						if($weekdays[0]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','SUN');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative;">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[0]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END SUNDAY
						
						// MONDAY
                        if($weekdays[1]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','MON');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                   
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[1]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END MONDAY 
						
						// TUESDAY
						if($weekdays[2]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','TUE');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[2]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
											}
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END TUESDAY
						
						
						// WEDNESDAY
						if($weekdays[3]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','WED');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[3]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END WEDNESDAY
						
						
						// THURSDAY
						if($weekdays[4]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','THU');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[4]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END THURSDAY
						
                        // FRIDAY
						if($weekdays[5]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','FRI');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[5]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END FRIDAY
						
						// SATURDAY
						if($weekdays[6]['weekday']!=0) 
                        {
						?>
                            <tr>
                                <td class="td"><div class="name"><?php echo Yii::t('app','SAT');?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$weekdays[6]['weekday'],'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        <?php 
						} 
						// END SATURDAY
						?>
                    </tbody>
                </table>
        <?php
        }
        else // If class timing is not set for the batch
        {
            echo '<i>'.Yii::t('app','No Timetable is set for this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i>';
        }
        ?>
    </div>
    <br /> <br />
<?php
}
// ******************* END WEEK TABLE *********************/

// ******************* DAY TABLE *********************/
elseif($mode == 2)
{
	//echo 'DAY';
?>
	<div class="timetable" style="text-align:center">
    	<?php
		//$weekdays = Weekdays::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday'=>$day));
		
		/*$weekdays = Weekdays::model()->findAll("batch_id=:x", array(':x'=>$batch_id)); // Selecting weekdays of the batch
		if(count($weekdays) == 0)
		{
			$weekdays = Weekdays::model()->findAll("batch_id IS NULL");
		}*/

		$criteria=new CDbCriteria;
		$criteria->condition = "batch_id=:x";
		$criteria->params = array(':x'=>$batch_id);
		$criteria->order = "STR_TO_DATE(start_time, '%h:%i %p')";
        $timing = ClassTimings::model()->findAll($criteria); // Selecting class timings of the batch
		
		$count_timing = count($timing);
        if($timing!=NULL) // If class timing is set for the batch
        {
			$weekdays = Weekdays::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday'=>$day));
			if(count($weekdays) == 0)
			{
				$criteria1 = new CDbCriteria;
				$criteria1->condition = 'weekday=:week AND batch_id IS NULL';
				$criteria1->params = array(':week'=>$day);
				$weekdays = Weekdays::model()->find($criteria1);
			}
			//echo count($weekdays).$weekdays->weekday.'/'.$day;
			if($weekdays->weekday != 0)
			{
        ?> 
        		<table border="0" align="center" width="100%" id="table" cellspacing="0">
                    <tbody>
                    	
                        <tr>
                            <td class="loader">&nbsp;</td>
                            <td class="td-blank"></td>
                            <?php 
                            foreach($timing as $timing_1)
							{
								echo '<td class="td"><div class="top">'.$timing_1->start_time.' - '.$timing_1->end_time.'</div></td>';	
							}
                            ?>
                        </tr> 
                        
                        <tr class="blank">
                            <td></td>
                            <td></td>
                            <?php
                            for($i=0;$i<$count_timing;$i++)
                            {
                            	echo '<td></td>';  
                            }
							if($day == 1)
							{
								$day_name = 'SUN';
							}
							elseif($day == 2)
							{
								$day_name = 'MON';
							}
							elseif($day == 3)
							{
								$day_name = 'TUE';
							}
							elseif($day == 4)
							{
								$day_name = 'WED';
							}
							elseif($day == 5)
							{
								$day_name = 'THU';
							}
							elseif($day == 6)
							{
								$day_name = 'FRI';
							}
							elseif($day == 7)
							{
								$day_name = 'SAT';
							}
							
                            ?>
                            
                        </tr>
                        <tr>
							<td class="td"><div class="name"><?php echo Yii::t('app',$day_name);?></div></td>
                                <td class="td-blank"></td>
                                <?php
                                for($i=0;$i<$count_timing;$i++)
                                {
								?>
								<td class="td">
                                    <div  onclick="" style="position: relative; ">
                                        <div class="tt-subject" style="width:120px; margin:0 auto;">
                                            <div class="subject">
                                            <?php
                                            $set =  TimetableEntries::model()->findByAttributes(array('batch_id'=>$batch_id,'weekday_id'=>$day,'class_timing_id'=>$timing[$i]['id'])); 			
                                            if($set != NULL)
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
													$electname = ElectiveGroups::model()->findByAttributes(array('id'=>$elec_sub->elective_group_id,'batch_id'=>$_REQUEST['bid']));
													
													if($electname!=NULL)
													{
														echo $electname->name.'<br>';
													}
													
												}
												
												/*if($yes_delete == 1)
												{
												echo CHtml::link('',array('timetableEntries/remove','id'=>$set->id,'batch_id'=>$_REQUEST['bid']),array('confirm'=>Yii::t('app','Are you sure?'),'class'=>'delete'));
												}*/
                                            }
											else
											{
												$is_break = ClassTimings::model()->findByAttributes(array('id'=>$timing[$i]['id'],'is_break'=>1));
												if($is_break!=NULL)
												{	
													echo Yii::t('app','Break');	
												}	
											}
                                            ?>
                                            </div>
                                        </div>
									</div>
								</td> 
                                <?php
                                }
                                ?>
                            </tr>
                        
					</tbody>
				</table>                                            
         
        <?php
			}
			else
			{
				echo '<i>'.Yii::t('app','No Timetable is set for this day!').'</i>';
			}
		} // END If class timing is set for the batch
		else // If class timing is NOT set for the batch
        {
            echo '<i>'.Yii::t('app','No Timetable is set for this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i>';
        }
        ?>		
	</div>
    <br /> <br />
<?php
}
// ******************* END DAY TABLE *********************/
?>    
