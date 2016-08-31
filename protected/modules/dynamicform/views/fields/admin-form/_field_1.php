<div class="txtfld-col">
	<?php echo CHtml::activeLabelEx($model, $field->varname); ?>
	<?php echo CHtml::activeTextField($model, $field->varname,array('placeholder'=>$model->getAttributeLabel($field->varname))); ?>
	<?php echo CHtml::error($model, $field->varname); ?>
</div>
