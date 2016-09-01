<style>
.attendance_table{
	margin:30px 0px;
	font-size:8px;
	text-align:center;
	width:auto;
	/*max-width:600px;*/
	border-top:1px #C5CED9 solid;
	border-right:1px #C5CED9 solid;
}
.attendance_table td{
	border-left:1px #C5CED9 solid;
	padding-top:10px; 
	padding-bottom:10px;
	border-bottom:1px #C5CED9 solid;
	width:auto;
	font-size:13px;
	
}

.attendance_table th{
	font-size:14px;
	padding:10px;
	border-left:1px #C5CED9 solid;
	border-bottom:1px #C5CED9 solid;
}
hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}

</style>
<?php
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
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
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
                            }
                            ?>
                </td>
                <td align="center" valign="middle" class="first" style="width:300px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; width:300px;  padding-left:10px;">
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
                                <?php echo Yii::t('app','Phone: ').$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr />
        <br />
	<!-- End Header -->

	<?php
    if(isset($_REQUEST['id']))
    {  
   ?>
   
    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app','STUDENT ATTENDANCE REPORT'); ?></div><br />
    <?php 
	$individual = Students::model()->findByAttributes(array('id'=>$_REQUEST['student'],'batch_id'=>$_REQUEST['id']));
	$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'],'is_active'=>1,'is_deleted'=>0));
	$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
	?>
   
    <!-- Individual Details -->
            <table width="685" style="font-size:13px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
        		<tr>
                	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                    <td width="120">
                        <?php echo Yii::t('app','Name'); ?>
                    </td>
                    <td width="10">
                        <strong>:</strong>
                    </td>
                    <td width="212">
                        <?php echo $individual->studentFullName("forStudentProfile");?>
                    </td>
                    <td width="120">
                        <?php echo Yii::t('app','Admission Number'); ?>
                    </td>
                   <td width="10">
                        <strong>:</strong>
                    </td>
                    <td width="212">
                        <?php echo $individual->admission_no; ?>
                    </td>
                    <?php
					}
					else{
					?>                    
                    <td width="120">
                        <?php echo Yii::t('app','Admission Number'); ?>
                    </td>
                   <td width="10">
                        <strong>:</strong>
                    </td>
                    <td width="212">
                        <?php echo $individual->admission_no; ?>
                    </td>
                    <td width="120">&nbsp;</td>
                    <td width="10">&nbsp;</td>
                    <td width="212">&nbsp;</td>
                    <?php
					}
					?>
                </tr>
                <tr>
                    <td>
                       <?php echo Yii::t('app','Admission Date'); ?>
                    </td>
                   <td>
                        <strong>:</strong>
                    </td>
                    <td>
                        <?php 
                        if($individual->admission_date!=NULL)
                        {
                            $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                            if($settings!=NULL)
                            {	
                                $individual->admission_date = date($settings->displaydate,strtotime($individual->admission_date));
                            }
                            echo $individual->admission_date; 
                        }
                        else
                        {
                            echo '-';
                        }
                        ?>
                    </td>
                   <td>
                        <?php echo Yii::t('app','Working Days'); ?>
                    </td>
                   <td>
                        <strong>:</strong>
                    </td>
                    <td>
                    	<?php
						
											$student_details=Students::model()->findByAttributes(array('id'=>$individual->id)); 
											
											if($student_details->admission_date>=$batch->start_date)
											{ 
											$batch_start  = date('Y-m-d',strtotime($student_details->admission_date));
											
											}
											else
											{
											$batch_start  = date('Y-m-d',strtotime($batch->start_date));
											}
						
						                $batch_end    = date('Y-m-d');
										$batch_end1  = date('Y-m-d',strtotime($batch->end_date));	
										
										$batch_days_1  = array();
										$batch_range_1 = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end1);  // to find total session
										$batch_days_1  = array_merge($batch_days_1,$batch_range_1);
										
										$days = array();
										$days_1 = array();
										$weekArray = array();
										
										$total_working_days_1 = array();
										$weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x'=>$batch->id,':y'=>"0"));
										if(count($weekdays)==0)
										{
											
											$weekdays = Weekdays::model()->findAll("batch_id IS NULL AND weekday<>:y",array(':y'=>"0"));
										}
										
										foreach($weekdays as $weekday)
										{
											
											$weekday->weekday = $weekday->weekday - 1;
											if($weekday->weekday <= 0)
											{
												$weekday->weekday = 7;
											}
											$weekArray[] = $weekday->weekday;
										}
										
										
										
										foreach($batch_days_1 as $batch_day_1)
										{
											$week_number = date('N', strtotime($batch_day_1));
											if(in_array($week_number,$weekArray)) // If checking if it is a working day
											{
												array_push($days_1,$batch_day_1);
											}
										}
										
										$holidays = Holidays::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
										$holiday_arr=array();
										foreach($holidays as $key=>$holiday)
										{
											if(date('Y-m-d',$holiday->start)!=date('Y-m-d',$holiday->end))
											{
												$date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d',$holiday->start),date('Y-m-d',$holiday->end));
												foreach ($date_range as $value) {
													$holiday_arr[] = date('Y-m-d',$date_range);
												}
											}
											else
											{
												$holiday_arr[] = date('Y-m-d',$holiday->start);
											}
										}
										
										
										foreach($days_1 as $day_1)
										{
											
											if(!in_array($day_1,$holiday_arr)) // If checking if it is a working day
											{
												array_push($total_working_days_1,$day_1);
											}
										}
								/*$uid = Yii::app()->user->id;
								$holidaycount = count(Holidays::model()->findAllByAttributes(array('user_id'=>$uid)));
								$weekdetails = Weekdays::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id']));
								$weekdays = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
								$index=0;
								foreach($weekdetails as $key=>$value)
								{
									if($value->weekday==0)
									{
										$holidays[$index] = $weekdays[$key];
										$index++;
									}
								}
								
								$batchdetails = Batches::model()->findByAttributes(array('name'=>$batch->name));
								/*$datetime1 = new DateTime($batchdetails->start_date);
								$datetime2 = new DateTime($batchdetails->end_date);
								$interval = $datetime1->diff($datetime2);
								$days = $interval->format('%a');
								$date11 = strtotime($batchdetails->start_date);
								$date22 = strtotime($batchdetails->end_date);
								$diff = $date22 - $date11;
								$days = floor($diff/(60*60*24)) + 1;
								$dayscount = 0;
								$counter = 0;								
							 	foreach($holidays as $holiday)
								{
									$dayscount += Batches::model()->Daycount($holiday, strtotime(date('d-m-Y',strtotime($batchdetails->start_date))), 
										strtotime(date('d-m-Y',strtotime($batchdetails->end_date))), $counter);								
								}
							 	echo $workingday = $days-($dayscount+$holidaycount);*/
							 echo count($total_working_days_1);  	
								
                    	?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t('app','Leaves Taken'); ?>
                    </td>
                   <td>
                        <strong>:</strong>
                    </td>
                    <td>
                        <?php 
                        //$leaves = StudentAttentance::model()->findAll('student_id=:x ORDER BY date ASC',array(':x'=>$individual->id));
						/*$criteria = new CDbCriteria;		
						$criteria->join = 'LEFT JOIN student_leave_types t1 ON t.leave_type_id = t1.id'; 
						$criteria->condition = 't1.is_excluded=:is_excluded and t.student_id=:student_id';
						$criteria->params = array(':is_excluded'=>0,':student_id'=>$individual->id);
						$leaves    = StudentAttentance::model()->findAll($criteria);
                        echo count($leaves);*/
						$criteria = new CDbCriteria;		
							$criteria->join = 'LEFT JOIN student_leave_types t1 ON t.leave_type_id = t1.id'; 
							$criteria->condition = 't1.is_excluded=:is_excluded and t.student_id=:student_id';
							$criteria->params = array(':is_excluded'=>0,':student_id'=>$individual->id);
							$leaves    = StudentAttentance::model()->findAll($criteria);
								echo count($leaves);
                        ?>
                    </td>
                </tr>
            </table>
    <!-- END Individual Details -->                            
    
    <!-- Individual Report Table -->
         <table width="700" cellspacing="0" cellpadding="0" class="attendance_table">
            <tr class="tablebx_topbg" style="background-color:#DCE6F1;">
                <td width="70"><?php echo Yii::t('app','Sl No');?></td>
                <td width="205"><?php echo Yii::t('app','Leave Date');?></td>
                <td width="450"><?php echo Yii::t('app','Reason');?></td>
            </tr>
             <?php
			if($leaves!=NULL)
			{
				$individual_sl = 1;
				foreach($leaves as $leave) // Displaying each leave row.
				{
				?>
				<tr>
					<td width="70" style="padding-top:10px; padding-bottom:10px;"><?php echo $individual_sl; $individual_sl++;?></td>
					 <!-- Individual Attendance row -->
					<td width="205">
						<?php 
						$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
						if($settings!=NULL)
						{	
							$leave->date=date($settings->displaydate,strtotime($leave->date));
						}
						echo $leave->date; 
						?>
					</td>
					<td width="450">
						<?php
						if($leave->reason!=NULL)
						{
							echo $leave->reason;
						}
						else
						{
							echo '-';
						}
						?>
					</td>
					<!-- End Individual Attendance row -->
				</tr>
			<?php
				}
			}
			else
			{
			?>
				<tr>
					<td colspan="3" style="padding-top:10px; padding-bottom:10px;">
						<?php echo Yii::t('app','No leaves taken!'); ?>
					</td>
				</tr>
			<?php
			}
			?>
        </table>

    <!-- END Individual Report Table -->
    
   
   <?php
    }
	else
	{
    ?>
    		<?php echo Yii::t('app','No data available!'); ?>
        
	<?php
    }
?>