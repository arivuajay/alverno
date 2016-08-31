
                <h1><?php echo Yii::t('app','Exam Results');?></h1>
              
                
                <?php
                //if(isset($_REQUEST['flag']) and $_REQUEST['flag']==1)
				$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
				
                if(isset($list) and $list!=NULL)
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
                                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                <td><?php echo Yii::t('app','Course');?></td>
                                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                            	<td><?php echo $details->admission_no; ?></td>
                                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                <td style="padding:10px;"><?php echo CHtml::link($details->studentFullName("forStudentProfile"),array('/students/students/view','id'=>$details->id)); ?></td>
                                <?php } ?>
                                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                <td>
                                	<?php 
									if($course->course_name!=NULL)
										echo $course->course_name;
									else
										echo '-';
									?>
                                </td>
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
					<h3><?php echo Yii::t('app','Result Report');?></h3>
                    <?php
					$examgroups = ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$batch->id)); // Selecting exam groups in the batch of the student
					if($examgroups!=NULL) // If exam groups present
					{
						$i = 1;
						foreach($examgroups as $examgroup) 
						{
						?>
                        	<br />
							<span style="float:left;"><h4><?php echo $i.'. '.ucfirst($examgroup->name); $i++;?></h4></span>
                            <span style="float:right"><?php echo CHtml::link(Yii::t('app', 'Generate PDF'), array('/examination/result/studentexampdf','exam_group_id'=>$examgroup->id,'id'=>$student),array('target'=>"_blank",'class'=>'pdf_but')); ?></span>
                            <!-- Single Exam Table -->
                            <div class="tablebx" style="clear:both"> 
                            	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr class="tablebx_topbg">
                                        <td><?php echo Yii::t('app','Subject');?></td>
                                        <td><?php echo Yii::t('app','Score');?></td>
                                        <td><?php echo Yii::t('app','Remarks');?></td>
                                    </tr>
                                    <?php
									
										$exams = Exams::model()->findAll('exam_group_id=:x',array(':x'=>$examgroup->id)); // Selecting exams(subjects) in an exam group
										if($exams!=NULL)
										{
											foreach($exams as $exam)
											{
												$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
												if($subject!=NULL) // Checking if exam for atleast subject is created.
												{ 
												$score = ExamScores::model()->findByAttributes(array('exam_id'=>$exam->id,'student_id'=>$student,));
												if($score!=NULL)
													{
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
														$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$batch->id),array('order'=>'min_score DESC'));
									
														if(!$grades)
														{
															$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>NULL));	
														}
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
												}
												else // If no exam (subject) details are present
												{
													echo '<tr><td colspan="4" style="padding-top:10px; padding-bottom:10px; text-align:center; "><strong>'.Yii::t('app','No exam created for any subject in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</strong></td></tr>';
												}
											} // END foreach($exams as $exam)
										}
										else //If no exam created
										{
											echo '<tr><td colspan="4" style="padding-top:10px; padding-bottom:10px; text-align:center;"><strong>'.Yii::t('app','No exam created for any subject in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</strong></td></tr>';
										}
									?>
								</table>
                            </div>
                            <!-- END Single Exam Table -->	
						<?php
						
						} // END foreach($examgroups as $examgroup)
					}
					else // If no exam groups present in the batch of the student
					{
						echo '<div class="listhdg" align="center">'.Yii::t('app','No exam details available!').'</div>';	
					}
				
                }else{
					echo '<div class="listhdg" align="center">'.Yii::t('app','Nothing Found!').'</div>';
				}
				
				
				 //END isset($list)
                ?>
                <div class="clear"></div>
         