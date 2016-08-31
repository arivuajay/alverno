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
	  $batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
      $course_id=$batch->course_id;
      $course=Courses::model()->findByAttributes(array('id'=>$course_id));?>

<?php
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
//$subjects=Subjects::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));

//echo CHtml::dropDownList('batch_id','',CHtml::listData(Subjects::model()->findAll("batch_id=:x",array(':x'=>$_REQUEST['id'])), 'id', 'name'), array('empty'=>'Select Type'));

  if(isset($_REQUEST['id']))
  {

	if(!isset($_REQUEST['mon']))
	{
		$mon = date('F');
		$mon_num = date('n');
	}
	else
	{
		$mon = EmployeeAttendances::model()->getMonthname($_REQUEST['mon']);
		$mon_num = $_REQUEST['mon'];
	}
	$num = cal_days_in_month(CAL_GREGORIAN, $mon_num, $_REQUEST['year']); // 31
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
                <td align="center" valign="middle" class="first" >
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
                                <?php echo Yii::t('app','Phone').': '.$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
   <hr />
   <br />
   
    <!-- End Header -->
    

    <div align="center" style="display:block; text-align:center;"><?php echo Yii::t('app','CLASS STUDENT ATTENDANCE'); ?></div><br />
    <?php $students=Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$_REQUEST['id'],':y'=>1,':z'=>0)); ?>
    <!-- Student details -->
   <table style="font-size:14px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
           
            <tr>
            	<?php 
				$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
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
				?>
                <td style="width:150px;"><?php echo Yii::t('app','Course'); ?></td>
                <td style="width:10px;">:</td>
                <td style="width:350px;">
					<?php 
					if($course->course_name!=NULL)
						echo ucfirst($course->course_name);
					else
						echo '-';
					?>
				</td>
                
                 <?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile'))
                                { ?>               
                <td width="150"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></td>
                <td>:</td>
                <td width="350">
					<?php 
					if($batch->name!=NULL)
						echo ucfirst($batch->name);
					else
						echo '-';
					?>
				</td>
                                <?php }
                                else
                                {
                                    ?><td width="150"></td><td></td><td width="350"></td><?php
                                }
                                ?>
            
            </tr>
            <tr>
            	<td><?php echo Yii::t('app','Total Students'); ?></td>
                <td>:</td>
                <td>
					<?php 
					if($students!=NULL)
						echo count($students);
					else
						echo '-';
					?>
				</td>
            	<td><?php echo Yii::t('app','Month'); ?></td>
                <td>:</td>
                <td><?php echo $mon.' '.$_REQUEST['year']; ?></td>
            </tr>
           
        </table>
  
    <!-- END Student details -->
 	<!-- Attendance table -->

    <table width="100%" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#DCE6F1;">
        <?php
			 if(FormFields::model()->isVisible("fullname", "Students", 'forStudentProfile'))
			 { ?>
            <td width="90"><?php echo Yii::t('app','Name');?></td>
            <?php } ?>
            <?php
            for($i=1;$i<=$num;$i++)
            {
            echo '<td width="4">'.getweek($i,$_REQUEST['mon'],$_REQUEST['year']).'<span>'.$i.'</span></td>';
            }
            ?>
        </tr>
        <?php
        $j=0;
        $holidays = Holidays::model()->findAll();
		$holiday_arr=array();
		foreach($holidays as $key=>$holiday)
		{
			if(date('Y-m-d',$holiday->start)!=date('Y-m-d',$holiday->end))
			{
				$date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d',$holiday->start),date('Y-m-d',$holiday->end));
				foreach ($date_range as $value) {
					$holiday_arr[$value] = $holiday->id;
				}
			}
			else
			{
				$holiday_arr[date('Y-m-d',$holiday->start)] = $holiday->id;
			}
		}
        foreach($students as $student)
        {
			$holiday_1=0;
        if($j%2==0)
        $class = 'class="odd"';	
        else
        $class = 'class="even"';	
        
        ?>
        <tr <?php echo $class; ?> >
        <?php
			 if(FormFields::model()->isVisible("fullname", "Students", 'forStudentProfile'))
			 { ?>
            <td class="name">
			<?php
            $name='';
            $name= $student->studentFullName('forStudentProfile');
            echo $name; ?></td>
            <?php } ?>
            <?php
            for($i=1;$i<=$num;$i++)
            {
            echo '<td>';
           // $find = StudentAttentance::model()->findByAttributes("date=:x AND student_id=:y", array(':x'=>$_REQUEST['year'].'-'.$mon_num.'-'.$i,':y'=>$student->id));
			$find = StudentAttentance::model()->findByAttributes(array('date'=>$_REQUEST['year'].'-'.$mon_num.'-'.$i,'student_id'=>$student->id));
			$leave_types=StudentLeaveTypes::model()->findByAttributes(array('id'=>$find->leave_type_id));
			$today_day = date('d');
			$today_month = date('n');
			$today_year = date('Y');
			$cell_date = date('Y-m-d',strtotime($_REQUEST['year'].'-'.$mon_num.'-'.$i));
			$today_date = date('Y-m-d');
			if($cell_date > $today_date )
			{
				$cell = "";
			}
			else if(array_key_exists($cell_date, $holiday_arr))
			{
				$holiday_1++;
				$cell = '<div style="background-color:#F00;width:10px;height:10px;display:block;"></div>';
			}
			else if(!in_array($cell_date,$days) and !array_key_exists($cell_date, $holiday_arr)){
				
				$cell = '<div style="width:10px; height:10px; background:#F2F2F2;display:block;"></div>';
			}
			else
			{
				$cell = '<div style="background-color:#093;width:10px;height:10px;display:block;"></div>';
			}
            if(count($find)==0)
            {
            echo $cell;
            }
            else
            echo  '<span style="color:'.$leave_types->colour_code.'">'.$leave_types->label.'</span>';
            
            echo '</td>';
            }
            ?>
        </tr>
        <?php $j++; }?>
    </table>
	<!-- END Attendance table -->
<?php } ?>
