<style type="text/css">
.ui-widget-content{ height:auto !important}
</style>

<div class="formCon">
<div class="formConInner">
    <label><?php echo $timetable->fieldClassSubject ?></label>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-attentance-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Specify Reason') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
		 //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('value'=>$emp_id)); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'date'); ?>
                <?php echo $form->hiddenField($model,'batch_id',array('value'=>$batch_id)); ?>
		<?php echo $form->hiddenField($model,'date',array('value'=>$year.'-'.$month.'-'.$day)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

    <div class="row">
    			<?php echo $form->labelEx($model,'leave_type_id');?>
                <?php echo $form->dropDownList($model,'leave_type_id',CHtml::listData(StudentLeaveTypes::model()->findAllByAttributes(array('status'=>1)),'id','name'),array(
        'style'=>'width:100%;','empty'=>'Select Leave Type')); ?>
        		<?php echo $form->error($model,'leave_type_id'); ?>


    </div>

	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('app','reason')); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
<br />
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php echo $form->hiddenField($model,'timetable_id',array('value' => $timetable->id)); ?>
         <?php echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('/teachersportal/default/addnew','render'=>false)),array('dataType'=>'json','success'=>'js: function(data) {
			 if (data.status == "success")
             {
						$("#td'.$day.$emp_id.'").text("");
						$("#jobDialog123'.$day.$emp_id.'").html("<span class=\"abs\"></span>","");
						$("#jobDialog'.$day.$emp_id.'").dialog("close");
						window.location.reload();
			 }
			 else
			 {
				 var errors = JSON.parse(data.errors);
							  $(".errorMessage").remove();
							  $.each(errors, function(index, value){
							   var id  = index + "_em_";
							   var error = $("<div class=\"errorMessage\" />");
							   error.attr({
								id:id,
							   });
							   error.html(value[0]);
							   error.insertAfter($("#"+ index));
							  });
			 }
			 }'),array('id'=>'closeJobDialog'.$day.$emp_id,'name'=>'save')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->