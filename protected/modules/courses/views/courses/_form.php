<div class="formCon">

<div class="formConInner">

<div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courses-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app',' are required.');?></p>

	<?php /*?><?php echo $form->errorSummary($model); ?><?php */?>
    <h3><?php echo Yii::t('app','Course'); ?></h3>
<table width="60%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td><?php echo $form->labelEx($model,'course_name'); ?></td>
    <td><?php echo $form->textField($model,'course_name',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'course_name'); ?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'code'); ?></td>
    <td><?php echo $form->textField($model,'code',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'code'); ?></td>
  </tr>
   <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
 
</table>
<?php $daterange=date('Y')+20;
 	  $daterange_1=date('Y')-30;
	
		  ?>
	<div class="row">
		<?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->hiddenField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
   
		<?php //echo $form->labelEx($model,'created_at'); ?>
   <?php     if(Yii::app()->controller->action->id == 'create')
	{
		 echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d'))); 
	}
	else
	{
		 echo $form->hiddenField($model,'created_at'); 
	}
		 ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

   
    
    <!-- Batch Form Ends -->
	<div style="padding:0px 0 0 0px; text-align:left">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Save') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->