<script language="javascript">
function getday()
{
		
		
		var day=  document.getElementById('day_id').value;
		if(day_id != '')
		{
			window.location= 'index.php?r=/teachersportal/default/daytimetable&department_id='+'&day_id='+day;
		}
}
</script>
<div id="parent_Sect">
	<?php $this->renderPartial('leftside');?> 
	<div class="right_col"  id="req_res123">
    <!--contentArea starts Here--> 
     <div id="parent_rightSect">
        <div class="parentright_innercon">
        <div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-dedent"></i><?php echo Yii::t("app", 'Time Table');?><span><?php echo Yii::t("app", 'View your Time Table here');?> </span></h2>
        </div>
        <div class="col-lg-2">
        
                </div>
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t("app", 'You are here:');?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t("app", 'Time Table');?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
    <div class="contentpanel">
    
<div class="panel-heading">
            <h3 class="panel-title"><?php echo Yii::t('app','Day Wise Time Table'); ?></h3>           
        	</div>
            <div class="people-item">
             <?php $this->renderPartial('/default/employee_tab');?>
             <div> 
              <div class="form-group"> 
					<table style=" font-weight:normal;">
                    <tr>
                   <td>&nbsp;</td>
                                         <td style="width:150px;"><strong><?php echo Yii::t('app','Select Day');?></strong></td>                                            <td>&nbsp;</td>
                                         <td>
					<?php 
					 echo CHtml::dropDownList('day_id','',array('1'=>'Sunday','2'=>'Monday','3'=>'Tuesday','4'=>'Wednesday','5'=>'Thursday','6'=>'Friday','7'=>'Saturday'),array('prompt'=>Yii::t("app",'Select day'),'style'=>'width:190px;','onchange'=>'getday()','class'=>'form-control','id'=>'day_id','options'=>array($_REQUEST['day_id']=>array('selected'=>true))));
					
					  ?> 
                     </td>
                     </tr>
					 </table>  
                     </div>                
                </div>
                <!-- Search Result -->
              <?php 
			  if($_REQUEST['day_id']!=NULL)
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
			  
			  
			  $employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
			  $timetable = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$employee->id,'weekday_id'=>$_REQUEST['day_id']));
			  $current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
			  $ac_year=$current_academic_yr->config_value;
			  if($timetable!=NULL)
			  {
			  	echo CHtml::link(Yii::t('app','Generate PDF'), array('Default/daypdf','department_id'=>$_REQUEST['department_id'],'day_id'=>$_REQUEST['day_id']),array('class'=>'btn btn-danger pull-right','target'=>'_blank'));
			  }
			  ?>
              <div class="cleararea"></div>
              <br />

                    	<div class="table-responsive">
                        	<table width="80%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered mb30">
                            	<tbody>
                          			<tr class="pdtab-h">
                                        <td align="center"><?php echo Yii::t('app','Class Timing');?></td>
                                        <td align="center"><?php echo Yii::t('app','Course');?></td>
                                        <td align="center"><?php echo  Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></td>
                                        <td align="center"><?php echo Yii::t('app','Subject');?></td>
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
							        
										
								    echo '<td style="text-align:center;">'.$class_timing->start_time.'-'.$class_timing->end_time.'</td>';                             echo '<td>'.$course->course_name.'</td>';
								    echo '<td>'.$batch->name.'</td>';
								    echo '<td>'.ucfirst($subject->name).'</td>';
								
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
                            </table>
						</div>
                   
						<div class="atdn_div">
                            
                               
                            <div class="timetable_div">
                            
                                <div class="table-responsive">
								
								</div>
                              
                        	</div> <!-- End timetable div (timetable_div)-->
						</div> <!-- End entire div (atdn_div) -->

				
				
                
			</div>
		</div>
	</div>
	 <div class="clear"></div>
</div>
