<style>
.container
{
	background:#FFF;
}
</style>

<?php
	$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
	if(Yii::app()->user->year)
	{
		$year = Yii::app()->user->year;
	}
	else
	{
		$year = $current_academic_yr->config_value;
	}
	$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
	
?>

<div class="formCon">
    <div class="formConInner">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'exam-scores-form',
        'enableAjaxValidation'=>false,
    )); ?>
    
        
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
         <td width="14%">
            <?php echo $form->labelEx($model,'marks'); ?></td>
            <td width="86%">
			<?php 
			if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
			{
				echo $form->textField($model,'marks',array('size'=>3,'maxlength'=>7)); 
			}
			else
			{
				echo $form->textField($model,'marks',array('size'=>3,'maxlength'=>7,'disabled'=>'disabled'));
			}
			?>
            </td>
            <?php echo $form->error($model,'marks'); ?>
            </tr>
        
            <?php echo $form->hiddenField($model,'grading_level_id'); ?>
            <?php echo $form->error($model,'grading_level_id'); ?>
        
    <tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
         <td>
            <?php echo $form->labelEx($model,'remarks'); ?></td>
            <td>
			<?php 
			if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
			{
				echo $form->textField($model,'remarks',array('size'=>30,'maxlength'=>255)); 
			}
			else
			{
				echo $form->textField($model,'remarks',array('size'=>30,'maxlength'=>255,'disabled'=>'disabled')); 
			}
			?>
            </td>
            <?php echo $form->error($model,'remarks'); ?>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
        </table>
    
        <?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
        <?php   
    	if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
		{
		?>
        <div class="left">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
        </div>
    	<?php
		}
		?>
    <?php $this->endWidget(); ?>
    
    </div>
</div><!-- form -->