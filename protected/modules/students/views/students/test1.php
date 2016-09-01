<!--Text Field-->
<div>
<?php echo CHtml::activeLabel($model, 'first_name'); ?>
<?php echo CHtml::activeTextField($model,'first_name',array('placeholder'=>$model->getAttributeLabel('first_name'))); ?>
<?php echo CHtml::error($model,'first_name'); ?>
</div>
<!-- Text Area -->
<div>
<?php echo CHtml::activeLabel($model, 'last_name'); ?>
<?php echo CHtml::activeTextArea($model, 'last_name',array('placeholder'=>$model->getAttributeLabel('last_name'))); ?>
<?php echo CHtml::error($model,'last_name'); ?>
</div>
<!--Drop Down-->
<div>
<?php echo CHtml::activeLabel($model, 'batch_id'); ?>
<?php echo CHtml::activeDropDownList($model, 'batch_id',array(1=>'a',2=>'b'),array('prompt'=>Yii::t('app','Select').' '.$model->getAttributeLabel('batch_id'))) ?>
<?php echo CHtml::error($model,'batch_id'); ?>
</div>

<!--Radio Button-->
<div>
<?php echo CHtml::activeLabel($model, 'gender'); ?>
<?php echo CHtml::activeRadioButtonList($model, 'gender',array(1=>'Yes',2=>'No')); ?>
<?php echo CHtml::error($model,'gender'); ?>
</div>

<!--Check box-->
<div>
<?php echo CHtml::activeLabel($model, 'blood_group'); ?>
<?php echo CHtml::activeCheckBoxList($model, 'blood_group',array(1=>'car',2=>'flower')); ?>
<?php echo CHtml::error($model,'blood_group'); ?>
</div>

<!--Date Picker-->
<div>
<?php echo CHtml::activeLabel($model, 'date_of_birth'); ?>
<?php
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
	if($settings!=NULL){
		$date=$settings->dateformat;
	}else{
		$date = 'dd-mm-yy';
	}
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        
		'model'     => $model,
    	'attribute' => 'date_of_birth',
		//'name'=>'date_of_birth',
		// additional javascript options for the date picker plugin
		'options'=>array(
		'showAnim'=>'fold',
		'dateFormat'=>$date,
		'changeMonth'=> true,
		'changeYear'=>true,
		'yearRange'=>'1900:'.(date('Y')+5)
		),
		'htmlOptions'=>array(
		'style'=>'height:16px;',
		'readonly'=>true
		),
	));
?>
<?php echo CHtml::error($model,'date_of_birth'); ?>
</div>