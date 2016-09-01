<style type="text/css">
.formbut_1 button, input[type="submit"] { 
	background: url("images/fbut-bg.png") repeat-x scroll 0 0 rgba(0, 0, 0, 0)  ;
    border: 1px solid #B58530 !important;}
</style>

<div class="formCon" style="width:97%;">
<div class="formConInner">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-groups-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('app', 'are required.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<table>
    	<tr>
        	<td><?php echo $form->labelEx($model,'group_name'); ?></td>
        </tr>
        <tr>
            <td>
				<?php echo $form->textField($model,'group_name',array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'group_name'); ?>
            </td>
        </tr>
        <tr>
			<td>
			<div class="but_12" style="margin-top:10px;">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), array('class'=>'formbut')); ?>
            </div>
            </td>
        </tr>
    </table>
<?php $this->endWidget(); ?>

</div>
</div><!-- form -->