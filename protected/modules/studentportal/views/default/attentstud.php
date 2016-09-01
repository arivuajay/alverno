<?php
$this->breadcrumbs=array(
	Yii::t('app','Student Attentances')=>array('/courses'),
	Yii::t('app','Attendance'),
);
?>
<style>
.attendance_table{
	border-top:1px #C5CED9 solid;
	margin:30px 0px;
	font-size:12px;
	border-right:1px #C5CED9 solid;
}
.attendance_table td{
	border-left:1px #C5CED9 solid;
	padding:5px 6px;
	border-bottom:1px #C5CED9 solid;
	
}

hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}
</style>

<?php
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentPortal');
function getweek($date,$month,$year)
{
$date = mktime(0, 0, 0,$month,$date,$year); 
$week = date('w', $date); 
switch($week) {
case 0: 
return 'S<br>';
break;
case 1: 
return 'M<br>';
break;
case 2: 
return 'T<br>';
break;
case 3: 
return 'W<br>';
break;
case 4: 
return 'T<br>';
break;
case 5: 
return 'F<br>';
break;
case 6: 
return 'S<br>';
break;
}
}
?>

<?php

$model1 = new EmployeeAttendances;
$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
  if($student!=NULL)
  {

	if(!isset($_REQUEST['mon']))
	{
		$mon = date('F');
		$mon_num = date('n');
		$curr_year = date('Y');
	}
	else
	{
		$mon = $model1->getMonthname($_REQUEST['mon']);
		$mon_num = $_REQUEST['mon'];
		$curr_year = date('Y');
	}
	$num = cal_days_in_month(CAL_GREGORIAN, $mon_num, $curr_year); // 31
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
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px;   padding-left:10px;">
                                <?php $college=Configurations::model()->findAll(); ?>
                                <?php echo $college[0]->config_value;  ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo $college[1]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo Yii::t('app','Phone:').' '.$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
   
    
    <hr />
    <!-- End Header -->
    <br />
    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app','STUDENT ATTENDANCE'); ?></div><br />
    <!-- Student details -->
    
        <table style="font-size:14px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
            <?php 
				//$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
            ?>
            <tr>
                <?php
                if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
                ?>
                <td style="width:150px;"><?php echo Yii::t('app','Name'); ?></td>
                <td style="width:10px;">:</td>
                <td style="width:350px;"><?php echo $student->studentFullName("forStudentPortal"); ?></td>
                <td width="150"><?php echo Yii::t('app','Admission Number'); ?></td>
                <td style="width:10px;">:</td>
                <td width="350"><?php echo $student->admission_no; ?></td>                
                <?php
                }
                else{
                ?>
                <td width="150"><?php echo Yii::t('app','Admission Number'); ?></td>
                <td style="width:10px;">:</td>
                <td width="350"><?php echo $student->admission_no; ?></td>                
                <td style="width:150px;">&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:350px;">&nbsp;</td>
                <?php
                }
                ?>

                
            
                <?php /*?><td><b>Month</b></td>
                <td style="width:10px;">:</td>
                <td><?php echo $mon.' '.$_REQUEST['year']; ?></td><?php */?>
            </tr>
            
            <tr>
            	<?php 
				$batch = Batches::model()->findByAttributes(array('id'=>$student->batch_id));
				$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
				
				//find working days.............
				$batch_start = date('Y-m-d',strtotime($batch->start_date));
                $batch_end = date('Y-m-d',strtotime($batch->end_date));
				$days = array();
				$batch_days = array();
				$batch_range = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end);
				$batch_days = array_merge($batch_days,$batch_range);
				
				$weekArray = array();
                $weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x'=>$batch->id,':y'=>"0"));
                if(count($weekdays)==0)
                	$weekdays = Weekdays::model()->findAll("batch_id IS NULL AND weekday<>:y",array(':y'=>"0"));
					
                foreach($weekdays as $weekday)
				{
					$weekday->weekday = $weekday->weekday - 1;
					if($weekday->weekday <= 0)
					{
						$weekday->weekday = 7;
					}
					$weekArray[] = $weekday->weekday;
				}
                foreach($batch_days as $batch_day)
				{
					$week_number = date('N', strtotime($batch_day));
					if(in_array($week_number,$weekArray)) // If checking if it is a working day
					{
						array_push($days,$batch_day);
					}
				}
				
				
				
				//find working days.............

                if(FormFields::model()->isVisible('batch_id', 'Students', "forStudentPortal")){
				?>

                <td><?php echo Yii::t('app','Course'); ?></td>
                <td>:</td>
                <td>
					<?php 
					if($course->course_name!=NULL)
						echo ucfirst($course->course_name);
					else
						echo '-';
					?>
				</td>
                
                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></td>
                <td>:</td>
                <td>
					<?php 
					if($batch->name!=NULL)
						echo ucfirst($batch->name);
					else
						echo '-';
					?>
				</td>
                <?php 
                }   
                ?>
            
            </tr>
            <tr>
            	<td><?php echo Yii::t('app','Month'); ?></td>
                <td>:</td>
                <td colspan="4"><?php echo $mon.' '.$_REQUEST['yid']; ?></td>
            </tr>
           
        </table>
   
    <!-- END Student details -->
    
   <!-- Attendance table -->
   <br/>
 	<?php echo Yii::t('app','Yearly Student Attendance Report');?>
    <table width="100%" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#DCE6F1;">
            <?php /*?><td width="180"><?php echo Yii::t('app','Sl No');?></td><?php */?>
            <td width="280"><?php echo Yii::t('app','Adm No');?></td>
            <?php
            if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
            ?>
            <td width="320"><?php echo Yii::t('app','Name');?></td>
            <?php 
            }
            ?>
            <td width="190"><?php echo Yii::t('app','Working Days');?></td>
            <td width="185"><?php echo Yii::t('app','Leaves');?></td>
        </tr>
        <?php
        $yearly_sl = 1;
        //foreach($students as $student) // Displaying each employee row.
        //{
        ?>
        <tr>
            <?php /*?><td style="padding-top:10px; padding-bottom:10px;"><?php echo $yearly_sl; $yearly_sl++;?></td><?php */?>
            <td><?php echo $student->admission_no; ?></td>
            <?php
            if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
            ?>
            <td>
                <?php echo $student->studentFullName("forStudentPortal");?>
            </td>
            <?php 
            }
            ?>
            <td>
                <?php
                            $admindetails = User::model()->findByAttributes(array('username'=>'admin'));
							$required_year = $_REQUEST['yid'];
                            $uid = $admindetails->id;
                            $holidaycount = 0;
                            $holidaydetails = Holidays::model()->findAllByAttributes(array('user_id'=>$uid));
                            foreach($holidaydetails as $holidaydetail)
                            {
                                $startyear = date('Y',$holidaydetail->start);
                                $endyear = date('Y',$holidaydetail->end);
                                if($required_year==$startyear or $required_year==$endyear)
                                {
                                    $holidaycount++;
                                }
                                
                            }
                            $weekdetails = Weekdays::model()->findAllByAttributes(array('batch_id'=>$student->batch_id));
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
                            $batchstartyear = date('Y',strtotime($batchdetails->start_date));
                            $batchendyear = date('Y',strtotime($batchdetails->end_date));
                            if($required_year==$batchstartyear or $required_year==$batchendyear)
                            {
                               /* $datetime1 = new DateTime($batchdetails->start_date);
                                $datetime2 = new DateTime($batchdetails->end_date);
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a');*/
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
                                echo $workingday = $days-($dayscount+$holidaycount);
                            }
                            else
                            {
                                echo "0";
                            }
                ?>
            </td>
             <!-- Yearly Attendance column -->
            <td>
                <?php
                $attendances = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$student->id));
                //$joining_year = date('Y',strtotime($employee->joining_date));
                //if($required_year >= $joining_year)
                //{
                $leaves = 0;
                foreach($attendances as $attendance)
                {
                    $attendance_year = date('Y',strtotime($attendance->date));
                    if($attendance_year == $required_year)
                    {
						$exist_leave = StudentLeaveTypes::model()->findByAttributes(array('id'=>$attendance->leave_type_id,'is_excluded'=>0));
						if($exist_leave!=NULL)
						{
                        	$leaves++;
						}
                    }
                }
                echo $leaves;
                //}
                //else
                //{
                //	echo 'No data';
                //}
                ?>
            </td>
            <!-- End Yearly Attendance column -->
        </tr>
        <?php /*?><?php
        }
        ?><?php */?>
    </table>
    <br/>
    <?php echo Yii::t('app','Individual Student Attendance Report');?>
    <table width="100%" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#DCE6F1;">
            <td width="165"><?php echo Yii::t('app','Sl No');?></td>
            <td width="250"><?php echo Yii::t('app','Leave Type');?></td>
            <td width="280"><?php echo Yii::t('app','Leave Date');?></td>
            <td width="280"><?php echo Yii::t('app','Reason');?></td>
        </tr>
        <?php
        $studleaves = StudentAttentance::model()->findAll('student_id=:x ORDER BY date ASC',array(':x'=>$student->id));
        if($studleaves!=NULL)
        {
            $individual_sl = 1;
            foreach($studleaves as $studleave) // Displaying each leave row.
            {
				$exist_leave = StudentLeaveTypes::model()->findByAttributes(array('id'=>$studleave->leave_type_id));
				//if($exist_leave!=NULL)
				//{
            ?>
            <tr>
                <td style="padding-top:10px; padding-bottom:10px;"><?php echo $individual_sl; $individual_sl++;?></td>
                <td>
                	<?php
						if($exist_leave!=NULL)
						{
							echo $exist_leave->name;
						}
						else
							echo "-";
					?>
                </td>
                 <!-- Individual Attendance row -->
                <td>
                    <?php 
                    $settings=UserSettings::model()->findByAttributes(array('user_id'=>$admindetails->id));
                    if($settings!=NULL)
                    {	
                        $studleave->date = date($settings->displaydate,strtotime($studleave->date));
                    }
                    echo $studleave->date; 
                    ?>
                </td>
                <td>
                    <?php
                    if($studleave->reason!=NULL)
                    {
                        echo $studleave->reason;
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
				//}
            }
        }
        else
        {
        ?>
            <tr>
                <td colspan="4" style="padding-top:10px; padding-bottom:10px;" align="center">
                    <strong><?php echo Yii::t('app','No leaves taken!'); ?></strong>
            
</td>
            </tr>
        <?php
        }
        ?>
    </table>
    
     <!-- END Attendance table -->
<?php } ?>
