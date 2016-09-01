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
	padding:10px 3px 10px 3px;
	border-bottom:1px #C5CED9 solid;
	width:auto;
	/*min-width:30px;*/
	font-size:10px;
	text-align:center;
}

.table_area table{ border-collapse:collapse;}

.table_area table tr td{ border:1px solid #C5CED9;
	padding:10px;}
	
.table_area table tr th{ border:1px solid #C5CED9;
	padding:15px 10px;
	background:#DCE6F1;}



hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}
</style>
<?php
	$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	$timetable = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$employee->id,'weekday_id'=>$_REQUEST['day_id']));
	$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
	$ac_year=$current_academic_yr->config_value;
	if($timetable!=NULL)
	{
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
                                    echo '<img height="100" src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
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
        <br />

        <div class="table_area">
		<table width="80%" border="0" cellspacing="0" cellpadding="0">
                            	<tbody>
                          			<tr class="pdtab-h">
                                        <th align="center"><?php echo Yii::t('app','Class Timing');?></th>
                                        <th align="center"><?php echo Yii::t('app','Course');?></th>
                                        <th align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></th>
                                        <th align="center"><?php echo Yii::t('app','Subject');?></th>
                         			</tr>
                                    <?php 
									
                          											
								foreach($timetable as $timetable_1) // check acadamic year
							       {
											 
							  		$batch=Batches::model()->findAllByAttributes(array('id'=>$timetable_1->batch_id,academic_yr_id=>$current_academic_yr->config_value));
									if($batch != NULL)
									 {
									 	$flag=1;
									 }
							
						          }
								  
						if($timetable!=NULL and $flag==1) // If class timing is set for the day and check acadamic year
                            { 
							  $flag_1=0;
							  foreach($timetable as $timetable_1) // check acadamic year
							      {
											   
								  $batch=Batches::model()->findByAttributes(array('id'=>$timetable_1->batch_id,'academic_yr_id'=>$current_academic_yr->config_value));
								  $class_timing=ClassTimings::model()->findByAttributes(array('id'=>$timetable_1->class_timing_id)); 
								  if($timetable_1->is_elective==0)
								  {	
									$subject=Subjects::model()->findByAttributes(array('id'=>$timetable_1->subject_id));
								  }
								  else if($timetable_1->is_elective==2)
								  {
									  $subject=Electives::model()->findByAttributes(array('id'=>$timetable_1->subject_id));
								  }
								  $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
								  
								  $is_substitute = TeacherSubstitution::model()->findByAttributes(array('leave_requested_emp_id'=>$employee->id,'time_table_entry_id'=>$timetable_1->id));
								  
								  $is_assigned = TeacherSubstitution::model()->findByAttributes(array('substitute_emp_id'=>$employee->id,'date_leave'=>$date_between[$_REQUEST['day_id']-1],'batch'=>$batch->id));		
								  
								    if($batch!=NULL and $class_timing!=NULL and $subject!=NULL and $course!=NULL and !$is_substitute and !in_array($is_substitute->date_leave,$date_between))
									{
							        
										
								    echo '<tr><td style="text-align:center;" width="200">'.$class_timing->start_time.'-'.$class_timing->end_time.'</td>';                             echo '<td width="200">'.$course->course_name.'</td>';
								    echo '<td width="260">'.$batch->name.'</td>';
								    echo '<td width="250">'.ucfirst($subject->name).'</td>';
								
								    echo '</tr>';
									$flag_1=1;    
									 }
										
								  }
								 if($flag_1 == 0) // check batch,classtiming,subject,course are not avilable
								 {
								   echo '<tr>';
								 
                                   echo'<td colspan="4" align="center">' .'<i>'.Yii::t('app','No Timetable is set for you!').'</i>'.'</td>';                   echo '</tr>';
								 }
							}
						else // If class timing is NOT set for the employee
                            {
								  
								 echo '<tr>';
								 
                            echo'<td colspan="4" align="center">' .'<i>'.Yii::t('app','No Timetable is set for you!').'</i>'.'</td>';                            echo '</tr>';
                            }
									?>
                  </tbody>
		</table>
        </div>
        
<?php
	}
?>
 
