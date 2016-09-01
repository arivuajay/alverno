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
   

    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app','MONTHLY STUDENT ATTENDANCE REPORT'); ?></div><br />
    <?php 
	$students = Students::model()->findAll("batch_id=:x AND is_active=:y AND is_deleted=:z", array(':x'=>$_REQUEST['id'],':y'=>1,':z'=>0));
	$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'],'is_active'=>1,'is_deleted'=>0));
	$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
	?>
    <!-- Department details -->
   <table width="640" style="font-size:13px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
        	<tr>
            	<td width="120" height="30"><?php echo Yii::t('app','Course');?></td>
                <td width="10">:</td>
                <td width="190"><?php echo ucfirst($course->course_name);?></td>
                
                <td width="120"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                <td width="10">:</td>
                <td width="190"><?php echo $batch->name;?></td>
            </tr>
            <tr>
            	<td><?php echo Yii::t('app','Total Students');?></td>
                <td>:</td>
                <td><?php echo count($students);?></td>
                
                <td><?php echo Yii::t('app','Month');?></td>
                <td>:</td>
                <td width="240"><?php echo $_REQUEST['month'];?></td>
			</tr>                
                
        </table>
  
    <!-- END Department details -->
    
    <!-- Monthly Attendance Table -->
         <table width="100%" cellspacing="0" cellpadding="0" class="attendance_table">
            <tr class="tablebx_topbg" style="background-color:#DCE6F1;">
                <td width="60"><?php echo Yii::t('app','Sl No');?></td>
                <td width="120"><?php echo Yii::t('app','Adm No');?></td>
                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                <td width="280"><?php echo Yii::t('app','Name');?></td>
                <?php } ?>
                <td width="158"><?php echo Yii::t('app','Working Days');?></td>
                <td width="100"><?php echo Yii::t('app','Leaves');?></td>
            </tr>
              <?php
				$monthly_sl = 1;
				foreach($students as $student) // Displaying each employee row.
				{
				?>
				<tr>
					<td style="padding-top:10px; padding-bottom:10px;"><?php echo $monthly_sl; $monthly_sl++;?></td>
					<td><?php echo $student->admission_no; ?></td>
                    <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
					<td><?php echo $student->studentFullName("forStudentProfile");?></td>
                    <?php } ?>
                    <td>
                	<?php
								$uid = Yii::app()->user->id;
								$holidaycount = 0;
								$holidaydetails = Holidays::model()->findAllByAttributes(array('user_id'=>$uid));
								$requiredmonth = date('m',strtotime($_REQUEST['month']));
								foreach($holidaydetails as $holidaydetail)
								{
									$startmonth = date('m',$holidaydetail->start);
									$endmonth = date('m',$holidaydetail->end);
									if($requiredmonth==$startmonth or $requiredmonth==$endmonth)
									{
										$holidaycount++;
									}
									
								}
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
								//$batchstart = date('Y-m',strtotime($batchdetails->start_date));
								//$batchend = date('Y-m',strtotime($batchdetails->end_date));
								$requiredyear = date('Y',strtotime($_REQUEST['month']));
								$number = cal_days_in_month(CAL_GREGORIAN, $requiredmonth, $requiredyear);
								$dt1 = $requiredyear."-".$requiredmonth."-01";
								$dt2 = $requiredyear."-".$requiredmonth."-".$number;

								$tm1 = strtotime($dt1);
								$tm2 = strtotime($dt2);
								
								$dt = array();
								if($number>0)
								{
									foreach($holidays as $holiday)
									{
										
										$day=Batches::model()->getDay($holiday);
										for($i=$tm1; $i<=$tm2;$i=$i+86400) {
										if(date("w",$i) == $day) {
										$dt[] = date("l Y-m-d ", $i);
										}
										
									}
									$dayscount =count($dt);
										//$dayscount += Batches::model()->Monthdaycount($holiday, strtotime($_REQUEST['month']), strtotime($_REQUEST['month']), $counter);								
									}
									
							 		echo $workingday = $number-($dayscount+$holidaycount);
								}
								else
								{
									echo "0";
								}
					?>
                </td>
					 <!-- Monthly Attendance column -->
					<td>
						<?php
						$criteria = new CDbCriteria;		
						$criteria->join = 'LEFT JOIN student_leave_types t1 ON t.leave_type_id = t1.id'; 
						$criteria->condition = 't1.is_excluded=:is_excluded and t.student_id=:student_id';
						$criteria->params = array(':is_excluded'=>0,':student_id'=>$student->id);
						//$attendances    = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$student->id));
						
						$attendances    = StudentAttentance::model()->findAll($criteria);
						//$attendances = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$student->id));
						$required_month = date('Y-m',strtotime($_REQUEST['month']));
						//$admission_month = date('Y-m',strtotime($student->admission_date));
						//if($required_month >= $admission_month)
						//{
						$leaves = 0;
						foreach($attendances as $attendance)
						{
							$attendance_month = date('Y-m',strtotime($attendance->date));
							if($attendance_month == $required_month)
							{
								$leaves++;
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
					<!-- End Monthly Attendance column -->
				</tr>
				<?php
				}
				?>
            
        </table>

    <!-- END Monthly Attendance Table -->
   
   <?php
    }
	else
	{
    ?>
    		<?php echo Yii::t('app','No data available!'); ?>
        
	<?php
    }
?>