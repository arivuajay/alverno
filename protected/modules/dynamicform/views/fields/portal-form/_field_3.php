<div class="col-sm-6 clearfix sp_col">
  <div class="col-sm-6">
	<?php echo CHtml::activeLabelEx($model, $field->varname,array('class'=>'control-label')); ?>
    </div>
    <div class="col-sm-6">
	<?php echo CHtml::activeDropDownList($model, $field->varname, FormFields::model()->fieldValues($field->id), array('prompt'=>Yii::t('app','Select').' '.$model->getAttributeLabel($field->varname),'class'=>'form-control')) ?>
	<?php echo CHtml::error($model, $field->varname); ?>
 </div>
</div>