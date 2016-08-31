<div class="txtfld-col">
	<?php echo CHtml::activeLabelEx($model, $field->varname); ?>
	<?php echo CHtml::activeRadioButtonList($model, $field->varname, FormFields::model()->fieldValues($field->id), array('separator'=>' ', 'labelOptions' => array('style' => "display: inline-block" ))); ?>
	<?php echo CHtml::error($model,$field->varname); ?>
</div>