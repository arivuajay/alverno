<style>
.formCon input[type="text"], input[type="password"], textArea, select {padding:6px 3px 6px 3px; width:140px;}
.exp_but { right:4px; top:0px; margin:0px 2px !important;}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with').'&nbsp;';?><span class="required">*</span> <?php echo '&nbsp;'.Yii::t('app','are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
    <br />
<div class="formCon" >
<div class="formConInner">
<table width="60%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Select Hostel')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo CHtml::dropDownList('hostel','',CHtml::listData(Hosteldetails::model()->findAll('is_deleted=:x',array(':x'=>'0')),'id','hostel_name'),array('prompt'=>Yii::t('app','Select'),
'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/hostel/room/allot'),
	'update'=>'#floorid',
	'data'=>'js:$(this).serialize()')));?>
		</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Select Floor')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo CHtml::dropDownList('floor','',array(),array('prompt'=>Yii::t('app','Select'),'id'=>'floorid'));?>
	
		</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>


  <tr> 
    <td><?php echo $form->labelEx($model,'student_id'); ?></td>
    <td>&nbsp;</td>
    <td><div style="position:relative; width:180px" ><?php 
	   if($model->isNewRecord)
	   {
				$this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'name'=>'name',
						  'id'=>'name_widget',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>Yii::t('app','Student Name'),'style'=>'width:131px; padding:5px 3px;'),
						  'options'=>
							 array(
								   'showAnim'=>'fold',
								   'select'=>"js:function(student, ui) {
									  $('#id_widget').val(ui.item.id);
									 
											 }"
									),
					
						));
		
		 }
	     else
			{
				  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'model'=>$model,
						  'name'=>'name',
						  'id'=>'name_widget',
						   'attribute'=>'student_id',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>Yii::t('app','Student Name')),
						  'options'=>
							 array(
								   'showAnim'=>'fold',
								   'select'=>"js:function(student, ui) {
									  $('#id_widget').val(ui.item.id);
									 
											 }"
									),
					
						));
			}
						 ?>
        <?php echo CHtml::hiddenField('student_id','',array('id'=>'id_widget')); ?>
		<?php echo CHtml::ajaxLink('',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name','class'=>'exp_but'));?></div></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'food_preference'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->dropDownList($model,'food_preference',CHtml::listData(FoodInfo::model()->findAll('is_deleted=:x',array(':x'=>0)),'id','food_preference'),array('prompt'=>Yii::t('app','Select'))); ?>
		<?php //echo $form->error($model,'food_preference'); ?></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'desc'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'desc',array('size'=>20,'style'=>'width:132px;')); ?>
		<?php echo $form->error($model,'desc'); ?></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ?  Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>
</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->