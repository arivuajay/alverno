<?php
$this->breadcrumbs=array(
	Yii::t('app','Student Attentances')=>array('/courses'),
	Yii::t('app','Attendance'),
);
?>
<style>
/*.score_table{
	border-top:1px #CCC solid;
	margin:30px 0px;
	font-size:15px;
	border-right:1px #CCC solid;
	
}
.score_table td,th{
	border-left:1px #CCC solid;
	padding:5px 6px;
	border-bottom:1px #CCC solid;
	width: 150px;
	text-align:center;
}*/

.score_table{
	border-top:1px #C5CED9 solid;
	margin:30px 0px;
	font-size:15px;
	border-right:1px #C5CED9 solid;
}
.score_table td,th{
	border-left:1px #C5CED9 solid;
	padding:5px 9px;
	border-bottom:1px #C5CED9 solid;
	
}
.heading{
	text-align:center;
	font-size:24px;
	font-weight:bold;
}
.exam_head{
	padding-right:10px;
	margin-right:12px;
}
hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}

</style>

<?php

  if(isset($_REQUEST['id']) && isset($_REQUEST['examid']))
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
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; width:300px;  padding-left:10px;">
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
    <div align="center" style="display:block;text-align:center !important;"><?php echo Yii::t('app','EXAM SCORES'); ?></div><br />
     <?php 
	 	$criteria = new CDbCriteria;
        $criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
        $criteria->params[':is_deleted'] = 0;
        $criteria->params[':is_active'] = 1;
                        
        $batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id']));
        if($batch_students){
         	$count = count($batch_students);
            $criteria->condition = $criteria->condition.' AND (';
            $i = 1;
            foreach($batch_students as $batch_student){
            	$criteria->condition = $criteria->condition.' id=:student'.$i;
                $criteria->params[':student'.$i] = $batch_student->student_id;
                if($i != $count){
                	$criteria->condition = $criteria->condition.' OR ';
                }
               $i++;
            }
            $criteria->condition = $criteria->condition.')';
        }else{
            $criteria->condition = $criteria->condition.' AND batch_id=:batch_id';
            $criteria->params[':batch_id'] = $_REQUEST['id'];
        }
        $students=Students::model()->findAll($criteria);
		$scores = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['examid']));	
		$exam = Exams::model()->findByAttributes(array('id'=>$_REQUEST['examid']));
		$exam_group = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
		$sub_name = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
		$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
		
		
	?>
    <!-- Course details -->
 
        <table style="font-size:14px;background:#DCE6F1;padding:10px 10px;border:#C5CED9 1px;">
           
            <tr>
                <td style="width:150px;"><?php echo Yii::t('app','Course');?></td>
                <td style="width:10px;">:</td>
                <td style="width:350px;">
					<?php 
					if($course->course_name!=NULL)
						echo ucfirst($course->course_name);
					else
						echo '-';
					?>
				</td>
                <?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile'))
                                { ?>     
                <td width="150"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
                <td width="10">:</td>
                <td>
					<?php 
					if($batch->name!=NULL)
						echo ucfirst($batch->name);
					else
						echo '-';
					?>
				</td>
                                <?php }
                                else
                                {
                                    ?><td width="150"></td><td  width="10"></td><td></td><?php
                                }
                                ?>
            
            </tr>
            <tr>
            	<td><?php echo Yii::t('app','Total Students');?></td>
                <td>:</td>
                <td>
					<?php 
					if($students!=NULL)
						echo count($students);
					else
						echo '-';
					?>
				</td>
            	<td><?php echo Yii::t('app','Examination');?></td>
                <td>:</td>
                <td width="350">
					<?php 
					if($exam_group->name!=NULL)
						echo ucfirst($exam_group->name);
					else
						echo '-';
					?>
				</td>
            </tr>
            
            <tr>
            	<td><?php echo Yii::t('app','Subject');?></td>
                <td>:</td>
                <td>
					<?php 
					if($sub_name->name!=NULL)
						echo $sub_name->name;
					else
						echo '-';
					?>
				</td>
            	<td><?php echo Yii::t('app','Date');?></td>
                <td>:</td>
                <td>
					<?php 
					if($exam->start_time!=NULL)
					{
						$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
						if($settings!=NULL)
						{	
							$exam->start_time = date($settings->displaydate,strtotime($exam->start_time));
							echo $exam->start_time;
						}
						else
						{
							echo $exam->start_time;
						}
					}
					else
					{
						echo '-';
					}
					?>
				</td>
            </tr>
           
        </table>

    <!-- END Course details -->
	 <!-- Score Table -->

    
    	<table style="font-size:14px;" class="score_table"  width="100%" cellspacing="0" >
        	<tr style="background:#DCE6F1; text-align:center; line-height:10px;">
            	<td style="width:20px;"><?php echo Yii::t('app','Sl No.');?></td>
                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                { ?>
                                <td style="width:290px;"><?php echo Yii::t('app','Name');?></td> <?php } ?>
                <?php if($exam_group->exam_type =='Marks' || $exam_group->exam_type =='Marks And Grades'){ ?>
                <td style="width:100px;"><?php echo Yii::t('app','Score');?></td>
                <?php }if($exam_group->exam_type =='Grades' || $exam_group->exam_type =='Marks And Grades'){ ?>
                <td style="width:100px;"><?php echo Yii::t('app','Grades');?></td>
                <?php } ?>
                <td style="width:235px;"><?php echo Yii::t('app','Remarks');?></td>
                <td style="width:100px;"><?php echo Yii::t('app','Result');?></td>
        	</tr>
            <?php 
			$i = 1;
			foreach($scores as $score)
			 {
			 
			 $student  = Students::model()->findByAttributes(array('id'=>$score->student_id));
                         
                         
                         $name='';
                        $name=  $student->studentFullName('forStudentProfile');
                                
                                    
			 echo "<tr>";
			 	 echo "<td style=width:30>".$i."</td>";
                                 if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                {
				 echo "<td>".$name."</td>";
                                }
				 if($exam_group->exam_type =='Marks' || $exam_group->exam_type =='Marks And Grades'){
				 echo "<td>".number_format($score->marks)."</td>";
				 }
				 if($exam_group->exam_type =='Grades' || $exam_group->exam_type =='Marks And Grades'){
				 echo "<td>".$score->getgradinglevel($score)."</td>";
				 }
				 if($score->remarks!=NULL)
				 {
				 	echo "<td style=width:200>".$score->remarks."</td>";
				 }
				 else
				 {
					 echo "<td align='center'>-</td>";
				 }
				 echo "<td style=width:100>";
					if($score->is_failed=='1'){
						echo Yii::t('app','Failed');
					}
					else{
						echo Yii::t('app','Passed');
					}
				 echo "</td>";
			 echo "</tr>";
			 $i++;
			}
	 		?>
        </table>

    
     <!-- END Score Table -->


<?php  }?>

