<div class="col-sm-4">
	<?php echo CHtml::activeLabelEx($model, $field->varname,array('class'=>'control-label')); ?>
	<?php echo CHtml::activeRadioButtonList($model, $field->varname, FormFields::model()->fieldValues($field->id)); ?>
	<?php echo CHtml::error($model,$field->varname); ?>
</div>