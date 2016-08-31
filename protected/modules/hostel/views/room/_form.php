<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'room-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with').'&nbsp;';?><span class="required">*</span> <?php echo '&nbsp;'.Yii::t('app','are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
 
<?php

$floor=Floor::model()->findByAttributes(array('id'=>$_REQUEST['id']));

if($floor!=NULL)
{
	
	$cnt=$floor->no_of_rooms;
	for($i=1;$i<=$cnt;$i++)
	{
		
		?>
     <div class="formCon" style="margin-bottom:8px; border:1px #e6e8e9 solid;">
<div class="formConInner"> 
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo $form->labelEx($model,'room_no'); ?></td>
    <th>&nbsp;</th>
    <td><?php echo $form->textField($model,'room_no[]',array('size'=>20)); ?>
		<?php echo $form->error($model,'room_no'); ?></td>
  
    <td><?php echo $form->labelEx($model,'no_of_bed'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'no_of_bed[]',array('size'=>20)); ?>
		<?php echo $form->error($model,'no_of_bed'); ?></td>
  </tr>
   
</table>
  </div></div>

        <?php //echo $form->labelEx($model,'created'); ?>
		
	
        <?php
	}
?>
<?php
if(isset($_REQUEST['id']) and ($_REQUEST['id']!=NULL) and (isset($_REQUEST['hostel_id']) and ($_REQUEST['hostel_id']!=NULL)))
{
 echo $form->hiddenField($model,'floor',array('value'=>$_REQUEST['id'],'readonly'=>true)); ?>
<?php echo $form->hiddenField($model,'hostel_id',array('value'=>$_REQUEST['hostel_id'],'readonly'=>true)); 

}
?>


 <?php /*?><div class="formCon" style="border:1px #e6e8e9 solid;">
<div class="formConInner">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="9%"><?php //echo $form->labelEx($model,Yii::t('hostel','<strong>Floor</strong>')); ?></td>
    <td width="6%">&nbsp;</td>
    <td width="85%"><?php //echo $form->textField($model,'floor',array('value'=>$_REQUEST['floor_no'],'readonly'=>true)); ?>
    <?php echo $form->hiddenField($model,'hostel_id',array('value'=>$_REQUEST['hostel_id'],'readonly'=>true)); ?>
		<?php //echo $form->error($model,'floor'); ?></td>
    
  </tr>

    </table>
 </div></div>  <?php */?>
<div>
<?php /*?>		<?php echo $form->labelEx($model,'Floor'); ?>
        <?php echo $form->textField($model,'floor',array('size'=>20,'value'=>$floor->floor_no)); ?>
          <?php //echo $form->dropDownList($model,'floor',CHtml::listData(Floor::model()->findAll(),'id','floor_no'),array('prompt'=>'Select')); ?>
		<?php echo $form->error($model,'floor'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Room No'); ?>
		<?php echo $form->textField($model,'room_no',array('size'=>20)); ?>
		<?php echo $form->error($model,'room_no'); ?>
	</div>

	

	<div class="row">
		<?php //echo $form->labelEx($model,'is_full'); ?>
		<?php //echo $form->textField($model,'is_full',array('size'=>60,'maxlength'=>120)); ?>
		<?php //echo $form->error($model,'is_full'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_of_bed'); ?>
		<?php echo $form->textField($model,'no_of_bed',array('size'=>20)); ?>
		<?php echo $form->error($model,'no_of_bed'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'created'); ?>
		<?php echo $form->hiddenField($model,'created',array('value'=>date('Y-m-d'))); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>
<?php */?>
	<div >
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>


<?php }
?>
    <?php $this->endWidget(); ?>
</div><!-- form -->