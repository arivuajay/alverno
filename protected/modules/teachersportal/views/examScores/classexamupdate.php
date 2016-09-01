<?php
	echo $this->renderPartial('/default/leftside');
	$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	// Get unique batch ID from Timetable. Checking if the employee is teaching.
	$criteria=new CDbCriteria;
	$criteria->select= 'id';
	$criteria->distinct = true;
	$criteria->condition='employee_id=:emp_id';
	$criteria->params=array(':emp_id'=>$employee->id);
	$class_teacher = Batches::model()->findAll($criteria);
	$class_count = count($class_teacher);
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
    	<div class="btn-demo" style="position:relative; top:-8px; right:3px; float:right;">
        <div class="edit_bttns">
    		<ul>       
                <li><?php echo CHtml::link('<span>'.Yii::t('app','All Classes').'</span>',array('/teachersportal/exams/allexam','employee_id'=>$employee_id),array('class'=>'addbttn last'));?></li>                
              <?php if($class_count>0){ ?>  
                <li><?php echo CHtml::link('<span>'.Yii::t('app','My Class').'</span>',array('/teachersportal/exams/classexam','employee_id'=>$employee_id),array('class'=>'addbttn last'));?></li>                
    		  <?php } ?>
            </ul>
    		<div class="clear"></div>
		</div>
	</div>
		<h3 class="panel-title"><?php echo Yii::t('app', 'Update Exam Scores'); ?></h3>
	</div>
    <div class="people-item">
<div>
<?php
	$tutor  = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	/*echo "Employee ID: ".$employee_id.'<br/>';
	echo "Batch ID: ".$batch_id.'<br/>';
	echo "Exam Group ID: ".$exam_group_id.'<br/>';
	echo "Exam(Subject) ID: ".$exam_id.'<br/>';
	echo "Student ID: ".$_REQUEST['id'].'<br/>';*/
	$batch=Batches::model()->findByAttributes(array('id'=>$batch_id));
        if($batch!=NULL)
		   { ?>
               <div class="formCon"> <!-- Batch Details Tab -->
					<div class="formConInner">
                    	<table class="table table-bordered mb30">
                        	<tr>
                            	<td>
                       				<strong><?php echo Yii::t('app','Course'); ?>:</strong>
									<?php $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
                                    if($course!=NULL)
                                       {
                                           echo $course->course_name; 
                                       }?>
                               </td>
                               <td>
                                    <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?>: </strong><?php echo $batch->name; ?>
                        		</td>
                        	</tr>
                            <tr>
							<?php if($exam_group_id!=NULL)
                            { 
								$exam=ExamGroups::model()->findByAttributes(array('id'=>$exam_group_id,'batch_id'=>$batch_id));
							?>
								<td>
									<strong><?php echo Yii::t('examination','Exam'); ?>: </strong><?php echo $exam->name; ?>
								</td>
                            <?php 
                            }
							if($exam_id!=NULL)
							{ 
								$subject_id=Exams::model()->findByAttributes(array('id'=>$exam_id));
								$subject = Subjects::model()->findByAttributes(array('id'=>$subject_id->subject_id));
							?>
								<td>
									<strong><?php echo Yii::t('app','Subject'); ?>: </strong><?php echo $subject->name;  ?>
								</td>
							<?php
							}
							?>
                        	</tr>
                            <tr>
                            <?php
							$empid = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$subject_id->subject_id));
							if(count($empid)>0){
								$subject_teacher = Employees::model()->findByAttributes(array('id'=>$empid->employee_id));
							?>
								<td>
                                	<strong><?php echo Yii::t('app','Subject Teacher'); ?>: </strong><?php echo $subject_teacher->first_name.' '.$subject_teacher->last_name; ?>
								</td>
							<?php
							}
							$is_classteacher=Batches::model()->findByAttributes(array('id'=>$batch_id,'employee_id'=>$tutor->id));
							$classteacher = Employees::model()->findByAttributes(array('id'=>$is_classteacher->employee_id));
							if(Yii::app()->controller->action->id=='classexamupdate' and $classteacher==NULL){ // Redirecting if action ID is classexam and the employee is not classteacher
								$this->redirect(array('/teachersportal/exams/index'));
							}
							if(count($classteacher)>0){
							?>
                            	<td>
                                	<strong><?php echo Yii::t('app','Class Teacher'); ?>: </strong><?php echo $classteacher->first_name.' '.$classteacher->last_name; ?>
								</td>
                            <?php
							}
							?>
                            </tr>
                        </table>
					</div>
          	</div>    
    	<?php 
		   }?>
           <div class="edit_bttns" style=" float:right">
        <ul>
        	<?php
			if(isset($_REQUEST['allexam']) and $_REQUEST['allexam']=='1')
			{
				$url_subject_list = '/teachersportal/exams/allexamresult';
				$url_exam_list = '/teachersportal/exams/allexams';
				$url_change_batch = '/teachersportal/exams/allexam';				
			}
			else
			{
				$url_subject_list = '/teachersportal/exams/classexamresult';
				$url_exam_list = '/teachersportal/exams/classexams';
				$url_change_batch = '/teachersportal/exams/classexam';
				
			}
			if($exam_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Subject List'), array($url_subject_list,'bid'=>$batch_id,'exam_group_id'=>$exam_group_id,'employee_id'=>$employee_id),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			if($exam_group_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Exam List'), array($url_exam_list,'bid'=>$batch_id,'employee_id'=>$employee_id),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			?>
            <li><span>
        	<?php echo CHtml::link(Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"), array($url_change_batch,'employee_id'=>$employee_id),array('id'=>'add_exam-groups','class'=>'addbttn')); ?>
        	</span></li>
        </ul>
        <div class="clear"></div>
    </div>
    
    <?php
	$result_published = ExamGroups::model()->countByAttributes(array('id'=>$exam_group_id,'result_published'=>1));
	$is_teaching_subject = TimetableEntries::model()->countByAttributes(array('subject_id'=>$subject_id->subject_id,'employee_id'=>$employee_id));
	$score_flag = 0; // If $score_flag == 0, form for editing scores will not be displayed. If $score_flag == 1, form will be displayed.
	if((Yii::app()->controller->action->id=='classexam' or Yii::app()->controller->action->id=='classexamupdate')  and ($is_classteacher!=NULL) or (Yii::app()->controller->action->id=='classexamupdate' and $_REQUEST['allexam']==1))
	{ // Class teacher and subject teacher can edit scores for all subjects in their batch.
		$score_flag = 1; 
	}
	if(Yii::app()->controller->action->id=='allexamscore' and $is_teaching_subject<=0)
	{
		$score_flag = 0;
	}
	/*echo 'Result Published: '.$result_published.'<br/>';
	echo 'Is Teaching Subject: '.$is_teaching_subject.'<br/>';
	echo 'Score Flag: '.$score_flag.'<br/>';*/
	if($score_flag==1)
	{
	?>
	<!-- Start Edit Exam Scores -->
    
	<?php 
	//$model = ExamScores::model()->findByAttributes(array('id'=>$_REQUEST['id']));
    //$this->renderPartial('_form', array('model'=>$model,'batch_id'=>$batch_id,'exam_group_id'=>$exam_group_id,'exam_id'=>$exam_id,'employee_id'=>$employee_id)); // Rendering edit form

	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'exam-scores-form',
	//'action' => $actionUrl,
	'enableAjaxValidation'=>false,
)); ?>
<div>
	<table class="table table-bordered mb30">
        
        <thead>
            
        <tr>
        	<?php 
			$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
			?>
            <th><?php echo Yii::t('app','Student Name');?></th>
            <th><?php 
            $name="";
            $name=  $student->studentFullName('forTeacherPortal');
                    if($name!="")
                    {
                        echo $name;
                    }
                    else
                        echo "-";
            //echo ucfirst($student->first_name).' '.ucfirst($student->last_name); ?></th>
        </tr>
        </thead>
       
        <tr>
            <td><?php echo $form->labelEx($model,'marks'); ?></td>
            <td><?php echo $form->textField($model,'marks',array('size'=>7,'maxlength'=>7,'class'=>'form-control','style'=>'width:200px;')); ?></td>
            <?php echo $form->error($model,'marks'); ?>
		</tr>
		<?php echo $form->hiddenField($model,'grading_level_id'); ?>
        <?php echo $form->error($model,'grading_level_id'); ?>
		
        <tr>
         <td><?php echo $form->labelEx($model,'remarks'); ?></td>
         <td><?php echo $form->textField($model,'remarks',array('size'=>60,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?></td>
            <?php echo $form->error($model,'remarks'); ?>
        </tr>
    </table>

	<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
		

	<div class="row buttons" style="padding-top:0px; padding-left:10px;">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),array('class'=>'btn btn-danger')); ?>
	</div>
</div> 
<?php $this->endWidget(); ?>

    
    <!-- End Edit Exam Scores -->
    <?php
	}
	?>
    
</div> 
</div>
</div>