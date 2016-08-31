<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'finance-fees-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with'); ?><span class="required">*</span> <?php echo Yii::t('app','are required.') ;?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fee_collection_id'); ?>
		<?php echo $form->textField($model,'fee_collection_id'); ?>
		<?php echo $form->error($model,'fee_collection_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_paid'); ?>
		<?php echo $form->textField($model,'is_paid'); ?>
		<?php echo $form->error($model,'is_paid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->