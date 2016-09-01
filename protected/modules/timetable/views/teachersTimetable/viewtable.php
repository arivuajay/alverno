<style type="text/css">
	.pdtab_Con {
		margin: 0;
		padding: 8px 0 0;
	}
</style>
<?php
if($_REQUEST['employee_id']!=0)
{
echo CHtml::link(Yii::t('app','Generate PDF'), array('teachersTimetable/fullpdf','department_id'=>$_REQUEST['department_id'],'employee_id'=>$_REQUEST['employee_id'],'day_id'=>$_REQUEST['day_id']),array('class'=>'pdf_but','target'=>'_blank')); 
}
?>
	<div class="pdtab_Con" style="text-align:center">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered mb30">
                    <tbody>
                    	
                        
                            <tr class="pdtab-h" >
                                      
                                        <td style="text-align:center"><strong><?php echo Yii::t('app','Class Timing');?></strong></td>
                                        <td style="text-align:center"><strong><?php echo Yii::t('app','Course');?></strong></td>
                                        <td align="center"><strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></strong></td>
                                        <td align="center"><strong><?php echo Yii::t('app','Subject');?></strong></td>
                                        
                         	</tr>
                         <?php 
							$flag=0;
							$timetable = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$employee_id,'weekday_id'=>$weekday_id)); 
							$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
							$ac_year=$current_academic_yr->config_value;
							
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
                                foreach($timetable as $timetable_1)
							     {
									  
								    $batch=Batches::model()->findByAttributes(array('id'=>$timetable_1->batch_id,'academic_yr_id'=>$current_academic_yr->config_value));
																		
									$class_timing=ClassTimings::model()->findByAttributes(array('id'=>$timetable_1->class_timing_id));
									if($batch!=NULL and $class_timing!=NULL)
									{
								    if($timetable_1->is_elective==0)
									{
								    	$subject=Subjects::model()->findByAttributes(array('id'=>$timetable_1->subject_id));
									}
									else
									{
										$subject=Electives::model()->findByPk($timetable_1->subject_id);
									}
								    $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
								    echo '<tr id="timetablerow'.$timetable_1->id.'">';
								    echo '<td style="text-align:center;">'.$class_timing->start_time.'-'.$class_timing->end_time.'</td>';                           
									echo '<td>'.$course->course_name.'</td>';
								    echo '<td>'.$batch->name.'</td>';
								    echo '<td>'.$subject->name.'</td>';
								
								    echo '</tr>';
									$flag_1=1;
								
							        }
							  }
							  if($flag_1 == 0)
							  {
								   echo '<tr>';
                            	   echo'<td colspan="4">' .'<i>'.Yii::t('app','No Timetable is set for this Teacher!').'</i>'.'</td>';                            
								   echo '</tr>';
							  }
							}
						else // If class timing is NOT set for the employee
                            {
								  
								 echo '<tr>';
								 
                            echo'<td colspan="4">' .'<i>'.Yii::t('app','No Timetable is set for this Teacher!').'</i>'.'</td>';                            echo '</tr>';
                             }
                            ?>
                        
                        
                       
                        
					</tbody>
				</table>                                            
      	
	</div>
    <br /> <br />
<?php /*?><?php
}
else
{
	echo CHtml::link(Yii::t('app','Generate PDF'), array('teachersTimetable/fullpdf','department_id'=>$_REQUEST['department_id'],'employee_id'=>$_REQUEST['employee_id'],'day_id'=>$_REQUEST['day_id']),array('class'=>'cbut','target'=>'_blank')); 
?>
<?php
}
?><?php */?>
