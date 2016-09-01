<style>
.formCon input[type="text"], input[type="password"], textArea, select {padding:6px 3px 6px 3px; width:140px;}
.exp_but { right:-11px; margin:0px 2px !important;}
.ui-menu .ui-menu-item a{ color:#000 !important;}
.ui-menu .ui-menu-item a:hover{ color:#fff !important;}
.ui-autocomplete{box-shadow: 0 0 6px #d6d6d6;}
</style>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Report')=>array('/report'),
	Yii::t('app','Student Assessment Report'),
);
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side');?>
        </td>
        <td valign="top"> 
            <div class="cont_right">
                <h1><?php echo Yii::t('app','Assessment Report');?></h1>
                <div class="formCon">
                    <div class="formConInner">
                        <table width="90%" border="0" cellspacing="0" cellpadding="0" class="s_search">
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong><?php echo Yii::t('app','Name');?></strong></td>
                                <td>&nbsp;</td>
                                <td> 
                                    <div style="position:relative; width:180px" >
                                    <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                    array(
                                    'name'=>'name',
                                    'id'=>'name_widget',
                                    'source'=>$this->createUrl('/site/autocomplete'),
                                    'htmlOptions'=>array('placeholder'=>Yii::t('app','Student Name')),
                                    'options'=>
                                    array(
                                    'showAnim'=>'fold',
                                    'select'=>"js:function(student, ui) {
                                    $('#id_widget').val(ui.item.id);
                                    
                                    }"
                                    ),
                                    
                                    ));
                                    ?>
                                    <?php echo CHtml::hiddenField('student_id','',array('id'=>'id_widget')); ?>
                                    <?php echo CHtml::ajaxLink('',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name','class'=>'exp_but'));?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    	<div style="margin-top:10px;"><?php echo CHtml::submitButton( Yii::t('app','Search'),array('name'=>'search','class'=>'formbut')); ?></div>
                    </div> <!-- END div class="formConInner" -->
                </div> <!--  END div class="formCon" -->
                <br />
                
                
                <?php
                //if(isset($_REQUEST['flag']) and $_REQUEST['flag']==1)
				if($flag==1)
                {
                	echo '<div class="listhdg" align="center">'.Yii::t('app','Invalid search! Please enter a student name.').'</div>';	
                }
                else
                {
                }
                if(isset($list))
                {
					$details=Students::model()->findByAttributes(array('id'=>$student,'is_deleted'=>0,'is_active'=>1));
					$batch=Batches::model()->findByAttributes(array('id'=>$details->batch_id,'is_deleted'=>0,'is_active'=>1));
					$course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
					?>
					<h3><?php echo Yii::t('app','Student Information');?></h3>
					<div class="tablebx">  
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tablebx_topbg">
                            	<td><?php echo Yii::t('app','Admission No');?></td>
                                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                <td><?php echo Yii::t('app','Student Name');?></td>
                                <?php } ?>
                                <td><?php echo Yii::t('app','Course');?></td>
                                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                            	<td><?php echo $details->admission_no; ?></td>
                                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                <td style="padding:10px;"><?php echo CHtml::link($details->studentFullName("forStudentProfile"),array('/students/students/view','id'=>$details->id)); ?></td>
                                <?php }?>
                                <td>
                                	<?php 
									if($course->course_name!=NULL)
										echo $course->course_name;
									else
										echo '-';
									?>
                                </td>
                                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                <td>
									<?php 
									if($batch->name!=NULL)
										echo $batch->name;
									else
										echo '-';
									?>
								</td>
                                <?php } ?>
                            </tr>
                        </table>
					</div> <!-- END div class="tablebx" Student Information -->
                    <br /><br />
					<h3><?php echo Yii::t('app','Assessment Report');?></h3>
                    <?php
					$examgroups = ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$batch->id)); // Selecting exam groups in the batch of the student
					if($examgroups!=NULL) // If exam groups present
					{
						$i = 1;
						foreach($examgroups as $examgroup) 
						{
							$flag1=0;
						?>
                                    <?php
										$exams = Exams::model()->findAll('exam_group_id=:x',array(':x'=>$examgroup->id)); // Selecting exams(subjects) in an exam group
										if($exams!=NULL)
										{
											
									?>
                                            <br />
                                    <span style="float:left;"><h4><?php echo $i.'. '.ucfirst($examgroup->name); $i++;?></h4></span>
                                    <?php
									
                                    foreach($exams as $exam)
											{
												$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
												if($subject!=NULL) // Checking if exam for atleast subject is created.
												{ 
													$score = ExamScores::model()->findByAttributes(array('exam_id'=>$exam->id,'student_id'=>$student));
													if($score!=NULL)
													{
														$flag1=1;
													}
												}
											}
									?>
                                    <?php 
									if($flag1==1)
									{ ?>
                                    <span style="float:right"><?php echo CHtml::link(Yii::t('app', 'Generate PDF'), array('/report/default/studentexampdf','exam_group_id'=>$examgroup->id,'id'=>$student),array('target'=>"_blank",'class'=>'pdf_but')); ?></span>
                                    <?php
									}
									?>
                                    <!-- Single Exam Table -->
                                    <div class="tablebx" style="clear:both"> 
                                         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr class="tablebx_topbg">
                                                <td><?php echo Yii::t('app','Subject');?></td>
                                                <td><?php echo Yii::t('app','Score');?></td>
                                                <td><?php echo Yii::t('app','Remarks');?></td>
                                            </tr>
                                    <?php
											//$exam_score=0;
											foreach($exams as $exam)
											{
												$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
												if($subject!=NULL) // Checking if exam for atleast subject is created.
												{ 
													$score = ExamScores::model()->findByAttributes(array('exam_id'=>$exam->id,'student_id'=>$student));
													if($score!=NULL)
													{
														//$exam_score=1;
										?>
													<tr>
														<td style="padding-top:10px; padding-bottom:10px;">
														<?php
															if($subject->name!=NULL)
																echo ucfirst($subject->name);
															else
																continue;
														?>
														</td>
														<td>
														<?php
							 							 $grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$score->grading_level_id));
			                                             $t = count($grades);
														 if($examgroup->exam_type == 'Marks') {  
														 echo $score->marks; } 
														  else if($examgroup->exam_type == 'Grades') {
														  	
														   foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $score->marks)
																	{	
																		$grade_value =  $grade->name;
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	} 
																echo $grade_value ;
																break;
																
																}
																if($t<=0) 
																	{
																		$glevel = " No Grades" ;
																	} 
																
																} 
														   else if($examgroup->exam_type == 'Marks And Grades'){
															 foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $score->marks)
																	{	
																		$grade_value =  $grade->name;
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																echo $score->marks . " & ".$grade_value ;
																break;
																
																	
																} 
																if($t<=0) 
																	{
																		echo $score->marks." & ".Yii::t('app',"No Grades") ;
																	}
																 } 
														?>
														</td>
														<td>
														   <?php
														   if($score->remarks!=NULL)
														   {
															   echo $score->remarks;
														   }
														   else
														   {
															   echo '-';
														   }
														   ?>
														</td>
													</tr>
										<?php
													}
													/*else
													{
														$exam_score=0;
													}*/
												}
												else // If no exam (subject) details are present
												{
													echo '<tr><td colspan="4" style="padding-top:10px; padding-bottom:10px; text-align:center; "><strong>'.Yii::t('app','No exam created for any subject in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</strong></td></tr>';
												}
											} // END foreach($exams as $exam)
									?>
                                    </table>
                            	</div>
                                    <?php
										}
										/*else //If no exam created
										{
											echo '<tr><td colspan="4" style="padding-top:10px; padding-bottom:10px; text-align:center;"><strong>'.Yii::t('app','No exam created for any subject in this batch!').'</strong></td></tr>';
										}*/
										/*if($exam_score==0)
										{
											echo '<tr><td colspan="4" style="padding-top:10px; padding-bottom:10px; text-align:center;"><strong>'.Yii::t('app','No mark is entered for the Exam').'</strong></td></tr>';
										}*/
									?>
								
                            <!-- END Single Exam Table -->	
						<?php
						
						} // END foreach($examgroups as $examgroup)
					}
					else // If no exam groups present in the batch of the student
					{
						echo '<div class="listhdg" align="center">'.Yii::t('app','No exam details available!').'</div>';	
					}
				
                } //END isset($list)
                ?>
                <div class="clear"></div>
            </div> <!-- End div class="cont_right" -->
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>