<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
    <div class="formCon">
    <div class="formConInner">
<table width="63%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Category'),array('style'=>'float:left;')); ?><span class="required">*</span></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'cat_name',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'cat_name'); ?></td>
        <td><?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?></td>
  </tr>

</table>

    </div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->