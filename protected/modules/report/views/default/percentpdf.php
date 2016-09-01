<style>

table.attendance_table{ border-collapse:collapse}

.attendance_table{
	font-size:6px;
	text-align:center;
	width:auto;
}
.attendance_table td{
	padding:10px 8px; 
	width:auto;
	font-size:13px;
	border:1px #CCC solid;
	/*word-break:break-all;*/
}

.attendance_table th{
	font-size:14px;
	padding:10px;
	border:1px #CCC solid;
}
hr{ border-bottom:1px solid #999;
	border-top:0px solid #000}
	
td{ font-size:12px;}

h5{ margin:15px 0 0 0px;
	padding:0px}
</style>
<?php
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
if(isset($_GET['batch_id']))
    {  	
	
	foreach($batches as $batch){ 
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
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" height="85" />';
                            }
                            ?>
                </td>
                <td align="center" valign="middle" class="first" style="width:300px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:17px; width:300px;  padding-left:10px;">
                                <?php $college=Configurations::model()->findAll(); ?>
                                <?php echo $college[0]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:12px; padding-left:10px;">
                                <?php echo $college[1]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:12px; padding-left:10px;">
                                <?php echo 'Phone: '.$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
  <hr />
	<!-- End Header -->
<?php
    
		    //$batch=Batches::model()->findByAttributes(array('id'=>$_GET['batch_id'])); 
		    $course_id=$batch->course_id;
		    $course=Courses::model()->findByAttributes(array('id'=>$course_id));
			
			$per = $_GET['percentage'];
			$criteria = new CDbCriteria;
			$criteria->condition = 'is_deleted=:is_deleted AND batch_id=:batch_id AND is_active=:is_active';
			$criteria->params = array(':is_deleted'=>0,':batch_id'=>$batch->id,':is_active'=>1);
			$criteria->order = 'last_name ASC';
			$students = Students::model()->findAll($criteria);
			
			
 if($students){
	?>
    
    <div align="center"><?php echo Yii::t('app','ATTENDANCE PERCENTAGE REPORT'); ?></div>
   
 
        <table style="font-size:12px;" width="500">
        	<tr>
            	<td width="100"><?php echo Yii::t('app','Course');?></td>
                <td>:</td>
                <td><?php echo ucfirst($course->course_name);?></td>
             </tr>
			 <?php if(in_array('batch_id', $student_visible_fields)){ ?>
             <tr>             	
                <td><?php echo Yii::t('app','Class');?></td>
                <td style="width:10px;">:</td>
                <td ><div style="word-break:break-all"><?php echo $batch->name;?></div></td>
            </tr>
            <?php }?>         
        </table>
 <hr />
 <br />

    <!-- END Department details -->
    
    <!-- Overall Attendance Table -->
   
         <table width="900" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#dfdfdf;">
        	<td width="20"><?php echo Yii::t('app','Sl.No');?></td>
            <td width="100"><?php echo Yii::t('app','Course');?></td>
            <?php if(in_array('batch_id', $student_visible_fields)){ ?>
            <td width="100"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
            <?php } ?>
            <td ><?php echo Yii::t('app','Admission No.');?></td>
            <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
            <td  width="100"><?php echo Yii::t('app','Name');?></td>
            <?php }?>
            <td ><?php echo Yii::t('app','Attendance').' %';?></td>
            <td width="70" ><?php echo Yii::t('app','Dates of Absence');?></td>
            <td ><?php echo Yii::t('app','Total Sessions');?></td>
            <td ><?php echo Yii::t('app','Sessions missed');?></td>
            
        </tr>
        
	<?php 
	$k=1;
	foreach($students as $student)
			{	
				$student_details=Students::model()->findByAttributes(array('id'=>$student->id)); 
				if($student_details->admission_date>=$batch->start_date)
				{ 
				$batch_start  = date('Y-m-d',strtotime($student_details->admission_date));
				
				}
				else
				{
				$batch_start  = date('Y-m-d',strtotime($batch->start_date));
				}	
				
				
				$batch_end=date('Y-m-d');	
				$batch_end1 = date('Y-m-d',strtotime($batch->end_date));
				$batch_days = array();
				$batch_range = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end);
				$batch_days = array_merge($batch_days,$batch_range);
			    
				$batch_days_1  = array();
				$batch_range_1 = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end1);  // to find total session
				$batch_days_1  = array_merge($batch_days_1,$batch_range_1);
				
				$days = array();
				$days_1 = array();
				$total_working_days_1 = array();
				$weekArray = array();
				$total_working_days = array();
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
				
				foreach($batch_days as $batch_day)
				{
					$week_number = date('N', strtotime($batch_day));
					if(in_array($week_number,$weekArray)) // If checking if it is a working day
					{
						array_push($days,$batch_day);
					}
				}
				foreach($batch_days_1 as $batch_day_1)
				{
					$week_number = date('N', strtotime($batch_day_1));
					if(in_array($week_number,$weekArray)) // If checking if it is a working day
					{
					array_push($days_1,$batch_day_1);
					}
				}
				$holidays = Holidays::model()->findAll();
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
				foreach($days as $day)
				{
					
					if(!in_array($day,$holiday_arr)) // If checking if it is a working day
					{
						array_push($total_working_days,$day);
					}
				
				}
				foreach($days_1 as $day_1)
				{
				
					if(!in_array($day_1,$holiday_arr)) // If checking if it is a working day
					{
					array_push($total_working_days_1,$day_1);
					}
				}
				
				$leavedays = array();
				/*$criteria = new CDbCriteria;
				$criteria->condition = 'student_id=:x AND date >=:z AND date <=:A';
				$criteria->params[':x'] = $student->id;
				$criteria->params[':z']	= $batch_start;	
				$criteria->params[':A']	= $batch_end;
				$leaves = StudentAttentance::model()->findAll($criteria);*/
				
				$criteria = new CDbCriteria;		
				$criteria->join = 'LEFT JOIN student_leave_types t1 ON t.leave_type_id = t1.id'; 
				$criteria->condition = 't1.is_excluded=:is_excluded AND t.student_id=:x AND t.date >=:z AND t.date <=:A';
				$criteria->params = array(':is_excluded'=>0,':x'=>$student->id,':z'=>$batch_start,':A'=>$batch_end);
				//$attendances    = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$student->id));
				
				$leaves    = StudentAttentance::model()->findAll($criteria);
				
				foreach($leaves as $leave){
					if(!in_array($leave->date,$leavedays)){
						array_push($leavedays,$leave->date);
					}
				}
				$present = count($total_working_days);
				$absent  = count($leavedays);
				$percent = round((($present-$absent)/$present)*100,0);
				
				if($percent <= $per)
				{
					if($j%2==0)
					$class = 'class="odd"';	
					else
					$class = 'class="even"';	
					
					?>
                  
        			<tr <?php echo $class; ?> >
                    <td><?php echo $k; ?></td>
                    <td><?php echo $course->course_name; ?></td>
                    <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                    <td><?php echo $batch->name; ?></td>
                    <?php } ?>
                    <td><?php echo $student->admission_no; ?></td>
                    <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                    <td width="140"><span style="word-break:break-all"><?php echo $student->studentFullName("forStudentProfile"); ?></span></td>
                    <?php } ?>
                   
                    <td><?php echo $percent.' %'; ?></td>
                    <td  width="70">
                   <?php
					if($leaves!=NULL)
					{
						foreach($leaves as $leaves_list)
						{
						
					?>
                       <?php 
					   $date1=date('d-m-y',strtotime($leaves_list->date));
					   echo $date1." ,";
					   ?>
					   <br />
                       <?php
					   //echo $leaves_list->date." ,"; 
                        }
				   }
				   else
				   {
				   echo " - "; 
				   }?>
                   </td>
                   <td class="name"><?php echo count($total_working_days_1); ?></td>
                   <td class="name" ><?php echo $absent; ?></td>
        </tr>
        <?php $j++; $k++;
				}
			} ?>
		</table>
    
    <!-- END Overall Attendance Table -->
   
   <?php
  }
  else{ ?>
  <div align="center">
  <?php echo Yii::t('app','ATTENDANCE PERCENTAGE REPORT'); ?></div>

			
        <table style="font-size:12px;" width="500">
        	<tr>
            	<td><?php echo Yii::t('app','Course');?></td>
                <td>:</td>
                <td><?php echo ucfirst($course->course_name);?></td>
             </tr>
             <tr>
                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                <td style="width:10px;">:</td>
                <td ><div style="word-break:break-all"><?php echo $batch->name;?></div></td>
            </tr>
                          
        </table>
    
   <br />
         <table width="800" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#dfdfdf;">
        	<td width="30"><?php echo Yii::t('app','Sl.No');?></td>
            <td width="100"><?php echo Yii::t('app','Course');?></td>
            <td width="100"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
            <td ><?php echo Yii::t('app','Admission No.');?></td>
            <td  width="130"><?php echo Yii::t('app','Name');?></td>
            <td ><?php echo Yii::t('app','Attendance').' %';?></td>
            <td ><?php echo Yii::t('app','Dates of Absence');?></td>
            <td ><?php echo Yii::t('app','Total Sessions');?></td>
            <td ><?php echo Yii::t('app','Sessions missed');?></td>
            
        </tr>
		<tr><td class="name" align="center" colspan="11"><?php echo Yii::t('app','No Students in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td></tr>
		</table>
		
	<?php	}
  
 ?>
 <div style="page-break-after:always; clear:both"></div>
 <?php
 
  }
   ?>
  <?php
	}
	?>  
<?php /*?><?php
else
	{
    ?>
    	<br /><br />
    	<div style="border:#CCC 1px; width:700px; padding:10px 10px; background:#E1EAEF;">
    		<strong><?php echo Yii::t('app','No data available!'); ?></strong>
        </div>
	<?php
    }
?><?php */?>