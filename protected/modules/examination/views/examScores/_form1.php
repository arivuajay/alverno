<style type="text/css">
.mark_err{ color:#F00;}
</style>
<div class="formCon" >

<div class="formConInner" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exam-scores-form',
	'enableAjaxValidation'=>false,
)); ?>

	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	 <td>
		<?php echo $form->labelEx($model,'marks'); ?></td>
		<td><?php echo $form->textField($model,'marks',array('size'=>7,'maxlength'=>3)); ?>
        
        <div class="mark_err"></div>
		<?php echo $form->error($model,'marks'); ?>
        </td>
        </tr>
		<?php echo $form->hiddenField($model,'grading_level_id'); ?>
		<?php echo $form->error($model,'grading_level_id'); ?>
            <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
       
    </tr>
	 
	<tr>

	 <td>
		<?php echo $form->labelEx($model,'remarks'); ?></td>
		<td><?php echo $form->textField($model,'remarks',array('size'=>60,'maxlength'=>255)); ?></td>
		<?php echo $form->error($model,'remarks'); ?>
	</tr>
  
    </table>
	 
	<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
		

	<div class="row buttons" style="padding-top:10px; padding-left:85px;">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
$('input[type="text"][name="ExamScores[marks]"]').blur(function(e) {
    if(isNaN($(this).val())){
		$(".mark_err").html("Mark must be an integer");
  //$(this).val('');
 }
});
</script>
</div></div><!-- form -->