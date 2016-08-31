
<style type="text/css">

h2.sub_hed_div{ background-color: #efeeda;
    color: #52514f;
    font-size: 13px;
    font-weight: 100;
    padding: 10px;
	border: 1px solid #eae9d3;}

</style>

 <?php

	$this->breadcrumbs=array(Yii::t('app','Teachers'));
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   
   if($settings!=NULL)
   {
      $date=$settings->displaydate;
	   
   }
   else
   {
    	$date = 'dd-mm-yy';	 
	}
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" valign="top" id="port-left">
     <?php $this->renderPartial('/employees/left_side');?>
    
    </td>
    <td valign="top">
    	
      
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
        	
        	<div style="padding-left:20px;">
            <h1><?php echo Yii::t('app','Leave Request'); ?></h1>
        	<div class="lreq_details">
            	<div class="lreq_top">
                	<h1><?php 
					$employee=Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
					
					echo $employee->concatened;
					
					?></h1>
                    <h2><?php echo Yii::t('app','Type:')." "?> <?php 
							$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$model->employee_leave_types_id));
							echo $type->name; ?></h2>
                            <?php if($model->is_half_day){ ?>
                    <div class="lreq_date"><strong><?php echo Yii::t('app','Date');?></strong> : <?php echo date($date,strtotime($model->start_date)); ?>								&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo Yii::t('app','Half Day'); ?></strong>&nbsp;&nbsp;<?php if($model->half==1){echo Yii::t('app','(Morning Half)');}else{echo Yii::t('app','(Afternoon Half)'); } ?></div>
                    <?php }else{ ?>
                    <div class="lreq_date"><strong><?php echo Yii::t('app','Start Date'); ?></strong> : <?php echo date($date,strtotime($model->start_date)); ?>								&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo Yii::t('app','End Date'); ?></strong> : <?php echo date($date,strtotime($model->end_date)); ?></div>
                    <?php } ?>
                </div>
                <div class="lreq_mid">
                	<?php echo $model->reason; ?>.
                </div>
                <div class="lreq_bottom">
                	
                    
                   <?php 
				   if($model->approved==1){
					   $class1='lreq_but approved';
					   $class2='lreq_but';
				   }
				   elseif($model->approved==2){
					   $class2='lreq_but rejected';
					   $class1='lreq_but';
				   }
				   else{
					   $class1='lreq_but';
					   $class2='lreq_but';
				   }											   					
			?>
                <?php if(isset($date_employee_substitute) and $date_employee_substitute!=NULL){ ?>    
                			<div class="warning_msg">Assigned as a substitute on <?php echo $date_employee_substitute; ?></div>
                <?php } ?>    
                    <div id="approve1">                    	
                    	<?php
							if($model->approved == 1){
						?>		
								<a href="javascript:void();" class="<?php echo $class1; ?>" onclick="return false" ><?php echo Yii::t('app','Approved'); ?></a> 
						<?php	
                            }else{
								echo CHtml::link(Yii::t('app','Approve'), array('approve','id'=>$model->id),array('class'=>$class1)); 
							}
						?>
                    </div>
                    <div id="approve2">
						<a href="javascript:void();" id="approve_button" class="<?php echo $class1; ?>" onclick="return false" ><?php echo Yii::t('app','Approve'); ?></a>
                    </div>    
                    
                    <?php
						if($model->approved == 2){
					?>		
							<a href="javascript:void();" class="<?php echo $class2; ?>" onclick="return false" ><?php echo Yii::t('app','Rejected'); ?></a> 
                   <?php         
						}else{
							echo CHtml::link(Yii::t('app','Reject'), array('reject','id'=>$model->id),array('class'=>$class2));
						}
					?>
					
                	<div class="clear"></div>
                </div>
                
<?php
	$flag = 0;
	if($model->approved!=1)
	{
		echo CHtml::beginForm(); 	
?>				

                <div id="substitution_div">
                	<h2 class="sub_hed_div"><span class="fa fa-dot-circle-o"></span> <?php echo Yii::t('app','The teacher, who has requested for leave have class on the respective day(s). You can select suitable replacement from the following teachers.'); ?> </h2>
                	<input type="hidden" name="leave_requested_emp_id" value="<?php echo $employee->id; ?>" />
                	<?php
												
						for($i = 0; $i<count($date_between); $i++)
						{							
							$timestamp = strtotime($date_between[$i]);	
							$day = date('D', $timestamp);																				
							$getDay = ApplyLeaves::model()->getDay($day);
							$is_class = TimetableEntries::model()->findAllByAttributes(array('employee_id'=>$employee->id,'weekday_id'=>$getDay));
							
							if($is_class)
							{
								$flag = 1;	
																				
					?>                					
					<div class="leave_btm_area">                    	
						<div class="leave_btm_area_inner">                        
							<h2><span class="fa fa-calendar"></span>&nbsp; <?php echo Yii::t('app','Date').' : '; ?> <?php echo date($date,strtotime($date_between[$i])) ;?></h2>
							
							<?php	
														
							for($j = 0; $j < count($batch_array); $j++)
							{
								$batch_name = Batches::model()->findByAttributes(array('id'=>$batch_array[$j]));
								if($batch_name)
								{								
									$time_table_entries = TimetableEntries::model()->findAllByAttributes(array('weekday_id'=>$getDay,'employee_id'=>$employee->id,'batch_id'=>$batch_array[$j]));
									
									if($time_table_entries)
									{
										$is_emp_substitute = TeacherSubstitution::model()->findByAttributes(array('substitute_emp_id'=>$employee->id,'date_leave'=>$date_between[$i]));
										if($is_emp_substitute)
										{
					?>
                    	                 	<div class="assign_sub"><?php echo Yii::t('app','Assigned as a substitute'); ?></div>
                    <?php
										}
					?>					
                                        <table width="92%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2"> <h3><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' :'; ?> <?php echo $batch_name->name; ?> <span style="float:right; color:#ccc;" class="fa fa-angle-double-down"></span></h3></td>
                                            </tr>	
                    <?php										
										foreach($time_table_entries as $time_table_entrie)
										{
											$time = ClassTimings::model()->findByAttributes(array('id'=>$time_table_entrie->class_timing_id,'batch_id'=>$batch_array[$j]));	
											
											if($time)
											{
												$emp_list = ApplyLeaves::model()->getEmployees($time_table_entrie->batch_id,$employee->id);																																		
												if($emp_list)
												{
													$available_employees = array(); 
													for($k = 0; $k < count($emp_list); $k++)
													{
														$is_employee = ApplyLeaves::model()->getAvailableEmp($emp_list[$k],$time->id,$batch_name->id,$time_table_entrie->weekday_id,$date_between[$i]);
														if((!in_array($is_employee,$available_employees)) and ($is_employee!=0))
														{
															$available_employees[] = $is_employee;
														}														
													}
													$data = array();
													if(count($available_employees)>0)
													{														
														for($l = 0; $l < count($available_employees); $l++)
														{
															$employee_details = Employees::model()->findByAttributes(array('id'=>$available_employees[$l]));
															$data[$employee_details->id] = $employee_details->first_name.' '.$employee_details->last_name;
														}
													}																										
														
																																				
					?>
                                                        <tr>
                                                            <td><?php echo $time->start_time.' - '.$time->end_time; ?></td>
                                                            <td><?php echo CHtml::dropDownList('substitute_employee_id[]','',$data,array('prompt'=>Yii::t('app','Select Employee'))); ?></td>
                                                        </tr>
                                                        <tr>
                                                        	<td><input type="hidden" name="time_table_entry_id[]" value="<?php echo $time_table_entrie->id; ?>" /></td>
                                                            <td><input type="hidden" name="leave_date[]" value="<?php echo $date_between[$i]; ?>" /></td>
                                                            
                                                        </tr>  
                                                                                                                              											
                    <?php						
																	
												}
											}
											
										}
					?>
                    						</table>
                    <?php													
									}
								}
							}
					?>							
						</div>					
					</div> 	
                    <input type="hidden" name="leave_request_id" value="<?php echo $model->id; ?>"	 />			
                    <?php
								
						  }
						 
						}
						 echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'formbut','submit'=>Yii::app()->createUrl('employees/leaves/addSubstitute')));
						
					?>
                    
                </div>	
                
<?php
		echo CHtml::endForm(); 
	}
?>  
   			
            </div>
            </div>
        </td>
     </tr>
    </table>
    
   
    </td>
  </tr>
</table>

<script type="text/javascript">
$( document ).ready(function() {		
	var flag = <?php echo $flag; ?>;
	if(flag == 0)
	{
		$("#approve2").hide();
	}
	if(flag == 1)
	{
		$("#approve1").hide();
	}
	$("#substitution_div").hide();
	$("#approve_button").click(function(){
        $("#substitution_div").slideToggle("slow");
    });
});
</script>	

