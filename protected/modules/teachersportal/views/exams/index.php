<?php 
$this->pageTitle=Yii::app()->name . ' - '.Yii::t("app", "Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);

?>
<?php echo $this->renderPartial('/default/leftside');?>
<?php 
	$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	// Get unique batch ID from Timetable. Checking if the employee is teaching.
	$criteria=new CDbCriteria;
	$criteria->select= 'batch_id';
	$criteria->distinct = true;
	$criteria->condition='employee_id=:emp_id';
	$criteria->params=array(':emp_id'=>$employee->id);
	$batches_id = TimetableEntries::model()->findAll($criteria);
	$teach_count = count($batches_id);
	//echo 'Employee ID: '.$employee->id.'<br/>Teaching in '.count($batches_id).' batch(es)<br/>';
	
	//Get unique batch ID from Batches. Checking if the employee is a class teacher.
	$criteria=new CDbCriteria;
	$criteria->select= 'id';
	$criteria->distinct = true;
	$criteria->condition='employee_id=:emp_id';
	$criteria->params=array(':emp_id'=>$employee->id);
	$class_teacher = Batches::model()->findAll($criteria);
	$class_count = count($class_teacher);
	//echo 'Class Teacher of '.count($class_teacher).' batch(es)';
?>
<div class="pageheader">
      <h2><i class="fa fa-gear"></i> <?php echo Yii::t("app", "Exams");?> <span><?php echo Yii::t("app", "View your exams here");?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t("app", "You are here:");?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
          <li class="active"><?php echo Yii::t("app", "Exams");?></li>
        </ol>
      </div>
    </div>
    
    
    <div class="contentpanel">    
    	<div class="panel-heading">        
			<h3 class="panel-title"><?php echo Yii::t('app', 'View Examination Details'); ?></h3>
		</div>
        
        <div class="people-item">
       
<div class="cont_right formWrapper usertable" >
<div class="btn-demo" style="position:relative; top:-8px; right:3px; float:right;">
        <div class="edit_bttns">
    		<ul>
            <?php
               if($teach_count > 0 or $class_count > 0){
                     $this->renderPartial('exam_tab',array('teach_count'=>$teach_count,'class_count'=>$class_count,'employee_id'=>$employee->id));
			?>	
            </ul>
    	<div class="clear"></div>  
	</div>
    </div>
            	<div class="right_col"  id="req_res123">
    <!--contentArea starts Here-->     
                 <div id="parent_rightSect">        
                        <br />
                            <div class="yellow_bx">
                                <?php /*?><div class="y_bx_head" style="font-size:14px;">
                                   &nbsp;
                                </div><?php */?>
                                <?php if($teach_count>0)
								{?>
                                    <h5 class="subtitle"><?php echo Yii::t('app','Tutor Classes'); ?></h5>
                                    <p><?php echo Yii::t('app','Displays all classes exams details.'); ?></p>
                                    <?php
									$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
                                    $criteria=new CDbCriteria;
                                    $criteria->select= 'batch_id';
                                    $criteria->distinct = true;
                                    // $criteria->order = 'batch_id ASC'; Uncomment if ID should be retrieved in ascending order
                                    $criteria->condition='employee_id=:emp_id';
                                    $criteria->params=array(':emp_id'=>$employee->id);
                                    $batches_id = TimetableEntries::model()->findAll($criteria);
                                    if(count($batches_id) >= 1){ // List of batches is needed
                                        $flag = 1;
                                    }
                                    elseif(count($batches_id) <= 0){ // If not teaching in any batch
                                        $flag = 0;
                                        
                                    }
									
									if($flag == 0)
									{ // Displaying message
										?>
										<div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;margin-top:60px;">
											<div class="y_bx_head">
											   <?php echo Yii::t('app','No period is assigned to you now!'); ?>
											</div>      
										</div>
										<?php
										}
										if($flag == 1)
										{ // Displaying batches the employee is teaching.
										?>
											<div class="table-responsive">
											   <table class="table table-bordered mb30">
													<thead>
														<tr class="pdtab-h">
															<th align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></th>
															<th align="center"><?php echo Yii::t('app','Class Teacher');?></th>
															<th align="center"><?php echo Yii::t('app','Actions');?></th>
														</tr>
														</thead>
														<tbody>
														<?php 
														foreach($batches_id as $batch_id)
														{
															$batch=Batches::model()->findByAttributes(array('id'=>$batch_id->batch_id,'is_active'=>1,'is_deleted'=>0));
															echo '<tr id="batchrow'.$batch->id.'">';
															/*echo '<td style="text-align:center; padding-left:10px; font-weight:bold;">'.CHtml::link($batch->name, array('/teachersportal/default/employeetimetable','id'=>$batch->id)).'</td>';*/
															echo '<td style="text-align:center; padding-left:10px; font-weight:bold;">'.$batch->coursename.'</td>';
															$teacher = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));					
															echo '<td align="center">';
															if($teacher){
																echo $teacher->first_name.' '.$teacher->last_name;
															}
															else{
																echo '-';
															}
															// Count if any exam timetables are published in a batch.
															$exams_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch->id,'is_published'=>1));
															// Count if any exam results are published in a batch.
															$result_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch->id,'result_published'=>1));
															echo '<td align="center">';
															if($exams_published > 0 or $result_published > 0){
																echo CHtml::link(Yii::t('app','View Examinations'), array('/teachersportal/exams/allexams','bid'=>$batch->id));
															}
															else{
																echo Yii::t('app','No Exam Scheduled');
															}
															echo '</td>';
															
															
															echo '</tr>';
														}
														?>
													</tbody>
												</table>
											</div>
										<?php
										}
                                 }?>
                                <?php if($class_count>0){ ?> 
                                    <h5 class="subtitle"><?php echo Yii::t('app','My Class'); ?></h5>
                                    <p><?php echo Yii::t('app','View the exams for the class(es) that you are in charge.'); ?></p>
                                    
                                    <?php
										$batches_id=Batches::model()->findAll("employee_id=:x AND is_active=:y AND is_deleted=:z", array(':x'=>$employee->id,':y'=>1,':z'=>0));
										if(count($batches_id) >= 1){ // List of batches is needed
											$flag = 2;
										}
										elseif(count($batches_id) <= 0){ // If not teaching in any batch
											$flag = 3;
											
										}
										
										if($flag == 3)
										{ // Displaying message
											?>
											<div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;margin-top:60px;">
												<div class="y_bx_head">
													<?php echo Yii::t('app','No period is assigned to you now!'); ?>
												</div>      
											</div>
											<?php
										}
											if($flag == 2)
											{ // Displaying batches the employee is assigned.
											?>
												<div class="table-responsive">
													<table width="80%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered mb30">
														
														<thead>
															<tr >
																<th ><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></th>
																<th ><?php echo Yii::t('app','Class Teacher');?></th>
																<th ><?php echo Yii::t('app','Actions');?></th>
															</tr>
															</thead>
															<tbody>
															<?php 
															foreach($batches_id as $batch_id)
															{
										
																echo '<tr id="batchrow'.$batch_id->id.'">'; 
																echo '<td style="text-align:center; padding-left:10px; font-weight:bold;">'.$batch_id->coursename.'</td>';
																$teacher = Employees::model()->findByAttributes(array('id'=>$batch_id->employee_id));					
																echo '<td align="center">';
																if($teacher){
																	echo $teacher->first_name.' '.$teacher->last_name;
																}
																else{
																	echo '-';
																}
																// Count if any exam timetables are published in a batch.
																$exams_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'is_published'=>1));
																// Count if any exam results are published in a batch.
																$result_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'result_published'=>1));
																echo '<td align="center">';
																if($exams_published > 0 or $result_published > 0){
																	echo CHtml::link(Yii::t('app','View Examinations'), array('/teachersportal/exams/classexams','bid'=>$batch_id->id));
																}
																else{
																	echo Yii::t('app','No Exam Scheduled');
																}
																echo '</td>';
																
																echo '</tr>';
																}
																?>
															</tbody>
														</table>
													</div>
													<?php
                                                    }
                                                    ?>
																			
													<?php } ?>
                                                     <div class="yb_timetable">&nbsp;</div>    
                                                   
                                                    <div class="yb_teacher_timetable">&nbsp;</div>
                                                     
                                                </div>
                                            </div>
                                        </div>	 
                                    <?php		 
                                        }else{
                                    ?>
                                    </div>   
                                    </div>
                        			<div class="clearfix"></div>
                        
                                    
                                    <div class="clearfix"></div>
                                        <div class="y_bx_head" style=" text-align:center;">
                                         <?php echo Yii::t('app','No exam details are available now!'); ?>    
                                    </div>
                                    
                        <?php } ?>		


             
    </div>
  

