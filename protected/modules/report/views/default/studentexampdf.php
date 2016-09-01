<style>
.assessment_table{
	margin:30px 0px;
	font-size:8px;
	text-align:center;
	width:auto;
	/*max-width:600px;*/
	border-top:1px #C5CED9 solid;
	border-right:1px #C5CED9 solid;
}
.assessment_table td{
	border-left:1px #C5CED9 solid;
	padding-top:10px; 
	padding-bottom:10px;
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
if(isset($_REQUEST['exam_group_id']))
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
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
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
    if(isset($_REQUEST['id']))
    {  
   ?>
   
    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app','STUDENT ASSESSMENT REPORT'); ?></div><br />
    <?php $student=Students::model()->findByAttributes(array('id'=>$_REQUEST['id'],'is_deleted'=>0,'is_active'=>1)); ?>
    <!-- Batch details -->
    <table style="font-size:13px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
        	<tr>
            	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
            	<td style="width:150px;"><?php echo Yii::t('app','Student Name');?></td>
                <td style="width:10px;">:</td>
                <td style="width:200px;"><?php echo $student->studentFullName("forStudentProfile");?></td>
                
                <td><?php echo Yii::t('app','Admission Number');?></td>
                <td style="width:10px;">:</td>
                <td><?php echo $student->admission_no;?></td>
                <?php } 
				else{
				?>
                <td style="width:150px;"><?php echo Yii::t('app','Admission Number');?></td>
                <td style="width:10px;">:</td>
                <td style="width:200px;"><?php echo $student->admission_no;?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td>&nbsp;</td>
                <?php }?>
            </tr>
            <tr>
            	<?php 
				$batch = Batches::model()->findByAttributes(array('id'=>$student->batch_id));
				$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
				?>
                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                <td><?php echo Yii::t('app','Course');?></td>
                <td>:</td>
                <td >
					<?php 
					if($course->course_name!=NULL)
						echo ucfirst($course->course_name);
					else
						echo '-';
					?>
				</td>
                
                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                <td>:</td>
                <td>
					<?php 
					if($batch->name!=NULL)
						echo ucfirst($batch->name);
					else
						echo '-';
					?>
				</td>
            	<?php } ?>
            </tr>
            <tr>
            	<td><?php echo Yii::t('app','Examination');?></td>
                <td>:</td>
                <td>
                	<?php
					$exam = ExamGroups::model()->findByAttributes(array('id'=>$_REQUEST['exam_group_id']));
					if($exam->name!=NULL)
						echo ucfirst($exam->name);
					else
						echo '-';
					?>
				</td>
            	<td width="150"><?php echo Yii::t('app','Exam Date');?></td>
                <td>:</td>
                <td width="175">
                	<?php
					if($exam->name!=NULL)
					{
						$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
						if($settings!=NULL)
						{	
							$exam->exam_date=date($settings->displaydate,strtotime($exam->exam_date));	
						}
						echo $exam->exam_date;
					}
					else
						echo '-';
					?>
				</td>
            </tr>
        </table>
  
    <!-- END Batch details -->
    
    <!-- Single Exam Table -->
         <table width="100%" cellspacing="0" cellpadding="0" class="assessment_table">
            <tr class="tablebx_topbg" style="background-color:#DCE6F1;">
                <td style="width:150px;"><?php echo Yii::t('app','Subject');?></td>
                <?php
					$examgrp = ExamGroups::model()->findByAttributes(array('id'=>$_REQUEST['exam_group_id']));
					if($examgrp->exam_type!=Grades)
					{
					?>
                <td style="width:130px;"><?php echo Yii::t('app','Mark');?></td>
                <?php
					}
					if($examgrp->exam_type!=Marks)
					{
					?>
               
                <td style="width:130px;"><?php echo Yii::t('app','Grade');?></td>
                <?php
					}
					?>
               
                <td style="width:150px;"><?php echo Yii::t('app','Remarks');?></td>
            </tr>
            <?php
			
			$exams = Exams::model()->findAll('exam_group_id=:x',array(':x'=>$_REQUEST['exam_group_id'])); // Selecting exams(subjects) in an exam group
			if($exams!=NULL)
			{
				foreach($exams as $exam)
				{
					$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
					
					if($subject!=NULL) // Checking if exam for atleast subject is created.
					{ 
					$score = ExamScores::model()->findByAttributes(array('exam_id'=>$exam->id,'student_id'=>$student->id));
					
					if($score!=NULL)
					{
			?>
						<tr>
                       
							<td>
							<?php
								if($subject->name!=NULL)
									echo ucfirst($subject->name);
								else
									continue;
									?>
							</td>
						
							
                            <?php
							if($examgrp->exam_type!=Grades)
					            {
							  ?>
							<td style="padding-top:10px; padding-bottom:10px;">
							<?php
							
								                           
								
								
								if($score->marks!=NULL)
								{
									echo $score->marks;
								}
								else
								{
									echo '-';
								}
								
							?>
							</td>
                            <?php
								}
							 if($examgrp->exam_type!=Marks)
					               {
								?>	   
							<td style="width:100px;">
							<?php
							
								if($score->marks!=NULL) // Calculate grade only if mark is present
								{
									$grade = GradingLevels::model()->findByAttributes(array('id'=>$exam->grading_level_id)); //Calculating Grade               
								 
									
									 if($grade->name!=NULL)
									 {
										echo $grade->name;
									 }
									 else //No grading levels for $exam
									 {
										$grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>NULL));
										$i = count($grades);
										foreach($grades as $grade)
										{
											if($grade->min_score <= $score->marks)
											{
												echo $grade->name;
												break;
											}
											else
											{
												$i--;
												continue;
											}
										}
										if($i<=0){
											echo 'No Grades';
										        }
										
									  }
								  
								} // END $score->marks!=NULL
								else // If no marks is present, grade is nil
								{
									echo '-';
								}
								
							?>
							</td>
                            <?php
								   }
								   ?>
							<td style="width:150px;">
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
					}}
					else // If no exam (subject) details are present
					{
						
						echo '<tr><td colspan="4" style="text-align:center; ">'.Yii::t('app','No exam created for any subject in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</td></tr>';
					}
					
				} // END foreach($exams as $exam)
			}
			else //If no exam created
			{
				echo '<tr><td colspan="4" style="text-align:center; ">'.Yii::t('app','No exam created for any subject in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</td></tr>';
			}
		?>
        </table>
 
    <!-- END Single Exam Table -->
   
   <?php
    }
    ?>
    
    
    
<?php
}
else
{
	
	echo '<td align="center" colspan="5"><strong>'.Yii::t('app','No Data Available!').'</strong></td></tr>';
}
?>