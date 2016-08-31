<div class="formCon">
<div class="formConInner" style="width:87%">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-attentance-form',
	//'enableAjaxValidation'=>true,
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
		<?php
		 //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'batch_id',array('value'=>$batch_id)); ?>
		<?php echo $form->error($model,'batch_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'date'); ?>
		<?php echo $form->hiddenField($model,'date',array('value'=>$year.'-'.$month.'-'.$day)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'leave_type_id');
		$leave_type=CHtml::listData(StudentLeaveTypes::model()->findAllByAttributes(array('status'=>1)),'id','name');
		?>
		<?php echo $form->dropDownList($model,'leave_type_id',$leave_type,array('empty' => Yii::t('app','Select Leave Type'))); ?>
		<?php echo $form->error($model,'leave_type_id'); ?>
	</div>
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
         <?php echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('StudentAttentance/Addnew','render'=>false)),array('dataType'=>'json','success'=>'js: function(data) {
			 	$(".errorMessage").remove();
						if (data.status == "success")
					{
						$("#td'.$day.$emp_id.'").text("");
						$("#jobDialog123'.$day.$emp_id.'").html("<span class=\"abs\"></span>","");
						$("#jobDialog'.$day.$emp_id.'").dialog("close");
						window.location.reload();
					}else{
						var errors	= JSON.parse(data.errors);						
						$.each(errors, function(index, value){
							var err	= $("<div class=\"errorMessage\" />").text(value[0]);
							err.insertAfter($("#" + index));
						});
					}
                    }'),array('id'=>'closeJobDialog'.$day.$emp_id,'name'=>'save')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->