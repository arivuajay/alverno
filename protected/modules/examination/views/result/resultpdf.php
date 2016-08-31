<style>
.assessment_table{
	margin:30px 0px;
	font-size:8px;
	text-align:center;
	width:100;
	/*max-width:600px;*/
	border-top:1px #C5CED9 solid;
	border-right:1px #C5CED9 solid;
}
.assessment_table td{
	border-left:1px #C5CED9 solid;
	padding:10px;
	border-bottom:1px #C5CED9 solid;
	width:auto;
	font-size:13px;
	
}

.assessment_table th{
	font-size:13px;
	padding:10px;
	border-left:1px #C5CED9 solid;
	border-bottom:1px #C5CED9 solid;
}

hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}

</style>
<?php
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
if(isset($search_id) and $search_id=='1')
		{
			$flag = 0;
			
			if($course==0 and $search_id=='1' and $batch==0 and $group==0 and $exam==0)
			{   
			    
			    $flag=1;
				$criteria  = new CDbCriteria;
				
				$criteria->join		= ' JOIN `exams` `ee` ON `ee`.`id`=`t`.`exam_id`';
				$criteria->join		.= 'LEFT JOIN `exam_groups` `eg` ON `eg`.`id`=`ee`.`exam_group_id`';
				$criteria->condition="`eg`.is_published =:is_published";
	        	$criteria->params=array(':is_published'=>1);
				//$criteria->group = 'id';
				$criteria->order = 'student_id DESC';
				
				
				$lists=ExamScores::model()->findAll($criteria);
				
			}
			elseif($search_id=='1' and $course!=0 and $batch==0 and $group==0 and $exam==0)
			{ 
			
				$flag=1;
				$course = $course;
				$batch_id  = array();
				$batches  = Batches::model()->findAllByAttributes(array('course_id'=>$course));
				foreach($batches as $batch)
				{
					$batch_id[] = $batch->id;
				}
				
				$criteria_3  = new CDbCriteria;
				$criteria_3->addInCondition('batch_id',$batch_id);
				$students = Students::model()->findAll($criteria_3);
				
				$student_id = array();
				foreach($students as $student)
				{
				    $student_id[]= 	$student->id;
				}
				
				$criteria_1  = new CDbCriteria;
				$criteria_1->join		= ' JOIN `exams` `ee` ON `ee`.`id`=`t`.`exam_id`';
				$criteria_1->join		.= 'LEFT JOIN `exam_groups` `eg` ON `eg`.`id`=`ee`.`exam_group_id`';
				$criteria_1->condition="`eg`.is_published =:is_published";
	        	$criteria_1->params=array(':is_published'=>1);
				$criteria_1->addInCondition('student_id',$student_id);
				//$criteria_1->group = 'id';
				$criteria->order = 'student_id DESC';
				
				
				$lists=ExamScores::model()->findAll($criteria_1);
				
				
			}
			elseif($search_id=='1' and $batch!=0 and $group==0 and $exam==0)
			{ 
			   
				$flag=1;
				$batch = $batch;
				$students = Students::model()->findAllByAttributes(array('batch_id'=>$batch));
				
				$student_id = array();
				foreach($students as $student)
				{
				    $student_id[]= 	$student->id;
				}
				
				$criteria_1  = new CDbCriteria;
				$criteria_1->join		= ' JOIN `exams` `ee` ON `ee`.`id`=`t`.`exam_id`';
				$criteria_1->join		.= 'LEFT JOIN `exam_groups` `eg` ON `eg`.`id`=`ee`.`exam_group_id`';
				$criteria_1->condition="`eg`.is_published =:is_published";
	        	$criteria_1->params=array(':is_published'=>1);
				$criteria_1->addInCondition('student_id',$student_id);
				//$criteria_1->group = 'id';
				$criteria->order = 'student_id DESC';
				$lists=ExamScores::model()->findAll($criteria_1);
				
				
			}
			elseif($search_id =='1' and $batch!=0 and $group!=0 and $exam==0)
			{  
			    
			   
				$flag=1;
				$batch = $batch;
				$group = $group;
				
				$criteria_2  = new CDbCriteria;
				
				$criteria_2->join		= ' JOIN `subjects` `ss` ON `ss`.`id`=`t`.`subject_id`';
				$criteria_2->condition="`ss`.batch_id =:batch_id and exam_group_id = :exam_group_id";
				$criteria_2->params=array(':batch_id'=>$batch,':exam_group_id'=>$group);
				
				$exams = Exams::model()->findAll($criteria_2);
				
				$exams_id = array();
				foreach($exams as $exam)
				{
				    $exams_id[]= 	$exam->id;
				}
				$criteria_1  = new CDbCriteria;
				$criteria_1->join		= ' JOIN `exams` `ee` ON `ee`.`id`=`t`.`exam_id`';
				$criteria_1->join		.= 'LEFT JOIN `exam_groups` `eg` ON `eg`.`id`=`ee`.`exam_group_id`';
				$criteria_1->condition="`eg`.is_published =:is_published";
	        	$criteria_1->params=array(':is_published'=>1);
				
				$criteria_1->addInCondition('exam_id',$exams_id);
				//$criteria_1->group = 'id';
				$criteria_1->order = 'student_id DESC';
				$lists=ExamScores::model()->findAll($criteria_1);
				
				
			}
			elseif($search_id=='1' and $batch!=0 and $group!=0 and $exam!=0 and $course!=0)
			{  
			    
				$flag=1;
				
				$exams = Exams::model()->findAllByAttributes(array('exam_group_id'=>$group,'subject_id'=>$exam));
				
				$exams_id = array();
				foreach($exams as $exam)
				{
				    $exams_id[]= 	$exam->id;
				}
				
				$criteria_1  = new CDbCriteria;
				$criteria_1->join		= ' JOIN `exams` `ee` ON `ee`.`id`=`t`.`exam_id`';
				$criteria_1->join		.= 'LEFT JOIN `exam_groups` `eg` ON `eg`.`id`=`ee`.`exam_group_id`';
				$criteria_1->condition="`eg`.is_published =:is_published";
	        	$criteria_1->params=array(':is_published'=>1);
				$criteria_1->addInCondition('exam_id',$exams_id);
				//$criteria_1->group = 'id';
				$criteria_1->order = 'student_id DESC';
				
				$lists=ExamScores::model()->findAll($criteria_1);
				
				
			}
		}

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
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" height="100" />';
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
                                <?php echo Yii::t('app','Phone: ').$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <hr />
    <br />
	<!-- End Header -->

	<?php
    if(isset($lists))
    {  
	
   ?>
   
    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app','EXAM RESULT REPORT'); ?></div><br />
    
    <!-- Single Exam Table -->
       <?php echo Yii::t('app','Exam Results');?><
       <table width="100%" cellspacing="0" cellpadding="0" class="assessment_table">
                    <tbody>
                    	<tr class="tablebx_topbg" style="background-color:#DCE6F1;" >
                                      	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>                                      
                                        <td style="text-align:center"><?php echo Yii::t('app','Student Name');?></td>
                                        <?php } ?>
                                        <td style="text-align:center"><?php echo Yii::t('app','Exam Group');?></td>
                                        <td style="text-align:center"><?php echo Yii::t('app','Exam');?></td>
                                        <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                                        <td align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></td>
                                        <?php } ?>
                                        <td align="center"><?php echo Yii::t('app','Mark');?></td>
                                        
                         	</tr>
                         
						<?php
                        if($lists)
                        {
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
                                	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                    <td width="150"><?php echo $student->studentFullName("forStudentProfile"); ?></td>
                                    <?php } ?>
                                    <td width="130">
                                    <?php echo $group->name;?>
                                    </td>
                                    <td width="100">
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
                                    <td width="100">
                                    <?php echo $batch->name;?>
                                    </td>
                                    <?php } ?>
                                   
                                    <td width="60">
                                    <?php 
									if($list->marks!=NULL)
									{
										
										$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$batch->id),array('order'=>'min_score DESC'));
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
												
											 if($grade->min_score <= $list->marks)
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
              
 
    <!-- END Single Exam Table -->
   
   <?php
    }
    ?>
    
    
    
