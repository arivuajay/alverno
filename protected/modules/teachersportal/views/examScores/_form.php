<div class="formCon" >

<div class="formConInner" >

<h3>&nbsp;</h3>

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
	if($_REQUEST['allexam']==1){
		$actionUrl = CController::createUrl('/teachersportal/examScores/classexamupdate',array("id"=>$model->id,"bid"=>$batch_id,"exam_group_id"=>$exam_group_id,"exam_id"=>$exam_id,'allexam'=>1,'employee_id'=>$employee_id));
	}
	else
	{
		$actionUrl = CController::createUrl('/teachersportal/examScores/classexamupdate',array("id"=>$model->id,"bid"=>$batch_id,"exam_group_id"=>$exam_group_id,"exam_id"=>$exam_id,'employee_id'=>$employee_id));
	}
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'exam-scores-form',
	//'action' => $actionUrl,
	'enableAjaxValidation'=>false,
)); ?>

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
                <li><?php echo CHtml::link('<span>'.Yii::t('app','All Classes').'</span>',array('/teachersportal/exams/allexam'),array('class'=>'addbttn last'));?></li>                
              <?php if($class_count>0){ ?>   
                <li><?php echo CHtml::link('<span>'.Yii::t('app','My Class').'</span>',array('/teachersportal/exams/classexam'),array('class'=>'addbttn last'));?></li>                
			  <?php } ?>     		
            </ul>
    		<div class="clear"></div>
		</div>
	</div>
		<h3 class="panel-title"><?php echo Yii::t('app', 'Exam Scores'); ?></h3>
</div>	
<div>
	<table class="table table-bordered mb30">
        
        <thead>
        <tr>
        	<?php 
			$student = Students::model()->findByAttributes(array('id'=>$model->student_id));
			?>
            <th><?php echo Yii::t('app','Student Name');?></th>
            <th><?php echo ucfirst($student->first_name).' '.ucfirst($student->last_name); ?></th>
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

<?php $this->endWidget(); ?>

</div></div><!-- form -->
</div>
</div>