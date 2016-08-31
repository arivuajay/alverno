<style type="text/css">
	.pdtab_Con {
		margin: 0;
		padding: 8px 0 0;
	}
</style>
	<div class="pdtab_Con" style="text-align:center">
    <?php
	$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
	if($lists)
    { 
	
	?>                    
    <span style="float:right"><?php echo CHtml::link(Yii::t('app', 'Generate PDF'), array('/examination/result/resultpdf','lists'=>$lists,'search_id'=>$search_id,'course'=>$course,'batch'=>$batch,'group'=>$group,'exam'=>$exam),array('target'=>"_blank",'class'=>'pdf_but')); ?></span>
    <?php
	}
	?>
    	<h3><?php echo Yii::t('app','Exam Results');?></h3>
         <div class="pagecon">
                        <?php                                          
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'pages'),
                        ));?>
                        </div> <!-- END div class="pagecon" 2 -->
                        <div class="clear"></div>
                  
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered mb30">
                    <tbody>
                    	
                        
                            <tr class="pdtab-h" >
                                      <td style="text-align:center"><strong><?php echo Yii::t('app','Sl No');?></strong></td>
                                      <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                        <td style="text-align:center"><strong><?php echo Yii::t('app','Student Name');?></strong></td>
                                        <?php
									  }
										?>
                                        <td style="text-align:center"><strong><?php echo Yii::t('app','Exam Group');?></strong></td>
                                        <td style="text-align:center"><strong><?php echo Yii::t('app','Exam');?></strong></td>
                                        <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                        <td align="center"><strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></strong></td>
                                        <?php } ?>
                                        <td align="center"><strong><?php echo Yii::t('app','Mark');?></strong></td>
                             </tr>
                         
						<?php
                        if($lists)
                        {
							 
                            if(isset($_REQUEST['page']))
                            {
                            	$j=($pages->pageSize*$_REQUEST['page'])-9;
                            }
                            else
                            {
                            	$j=1;
                            }
                           
							$elective= array();
							foreach($lists as $list)
							{?>
                            
                                <?php
								
								$student = Students::model()->findByAttributes(array('id'=>$list->student_id));
								$exam    = Exams::model()->findByAttributes(array('id'=>$list->exam_id));
								$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
								$group   = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
								$batch   = Batches::model()->findByAttributes(array('id'=>$student->batch_id));
								?>
                                <tr>
                                <td><?php echo $j;?></td>
                                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                    <td><?php echo $student->studentFullName("forStudentProfile"); ?></td>
                                    <?php } ?>
                                    <td>
                                    <?php echo $group->name;?>
                                    </td>
                                    <td>
                                    <?php
									if($subject->elective_group_id==0)
								     {
									 ?>
                                    <?php echo $subject->name;?>
                                    <?php
									 }
									 else
									 {
									$elective_group   = ElectiveGroups::model()->findByAttributes(array('id'=>$subject->elective_group_id));
									$elective         = Electives::model()->findByAttributes(array('elective_group_id'=>$elective_group->id,'batch_id'=>$batch->id));?>
                                    
                                       <?php echo "Elective/".$elective->name;?>
                                   
									
							<?php	 }
									 ?>
                                    </td>
                                    <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                    <td>
                                    <?php echo $batch->name;?>
                                    </td>
                                    <?php } ?>
                                    <td>
                                    <?php 
									if($list->marks!=NULL)
									{
										
										//$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$batch->id,'order'=>'min_score DESC'));
										$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$batch->id),array('order'=>'min_score DESC'));
										//var_dump($grades);exit;
										if(!$grades)
										{
											$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>NULL));	
										}
										$t = count($grades);
										 if($group->exam_type == 'Marks') {  
														 echo $list->marks; } 
								    	
									
									    else if($group->exam_type == 'Grades') {
														  	
									   foreach($grades as $grade)
											{
												if($grade->min_score<=$list->marks)
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
										 else if($group->exam_type == 'Marks And Grades'){
															 foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $list->marks)
																	{	
																		$grade_value =  $grade->name;
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																echo $list->marks . " & ".$grade_value ;
																break;
																
																	
																} 
																if($t<=0) 
																	{
																		echo $list->marks." & ".Yii::t('app',"No Grades") ;
																	}
																 } 
									}
									?>
                                    </td>
                                    
                                </tr>
						<?php 	
								
							  $j++;
				            }
						}
						else
						{?>
                        <tr> 
                        <td colspan="5"><strong><?php echo Yii::t('app',' NO RESULTS');?></strong></td>
                        </tr>
                     <?php }	
					?>
                   </tbody>
				</table>  
               
	</div>
    <br /> <br />
    
