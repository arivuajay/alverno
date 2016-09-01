<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-details-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>
    <?php echo $form->errorSummary($model); ?>
     <div class="formCon" >
<div class="formConInner">
    <table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
               <?php echo $form->labelEx($model,'vehicle_no'); ?>
               
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'vehicle_no',array('size'=>20)); ?>
                <?php echo $form->error($model,'vehicle_no'); ?>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                 <?php echo $form->labelEx($model,'vehicle_code'); ?>
				
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'vehicle_code',array('size'=>20)); ?>
                <?php echo $form->error($model,'vehicle_code'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
               <?php echo $form->labelEx($model,'no_of_seats'); ?>
                
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'no_of_seats',array('size'=>20)); ?>
                <?php echo $form->error($model,'no_of_seats'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                 <?php echo $form->labelEx($model,Yii::t('app','Maximum allowed')); ?>
				 
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'maximum_capacity',array('size'=>20)); ?>
                <?php echo $form->error($model,'maximum_capacity'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
         <tr>
            <td>
                <?php echo $form->labelEx($model,'vehicle_type'); ?>
				
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->dropDownList($model,'vehicle_type',array('1'=>Yii::t('app','Contract'),'2'=>Yii::t('app','Ownership')),array('prompt'=>Yii::t('app','Select'))); ?>
                <?php echo $form->error($model,'vehicle_type'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
         <tr>
            <td>
                 <?php echo $form->labelEx($model,'address'); ?>
				
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'address',array('size'=>20)); ?>
                <?php echo $form->error($model,'address'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
         <tr>
            <td>
                <?php echo $form->labelEx($model,'city'); ?>
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'city',array('size'=>20)); ?>
                <?php echo $form->error($model,'city'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
         <tr>
            <td>
               <?php echo $form->labelEx($model,'state'); ?>
                
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'state',array('size'=>20)); ?>
                <?php echo $form->error($model,'state'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
         <tr>
            <td>
                 <?php echo $form->labelEx($model,'phone'); ?>
				 
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'phone',array('size'=>20)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model,'insurance'); ?>
				
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'insurance',array('size'=>20)); ?>
                <?php echo $form->error($model,'insurance'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model,'tax_remitted'); ?>
                
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'tax_remitted',array('size'=>20)); ?>
                <?php echo $form->error($model,'tax_remitted'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                 <?php echo $form->labelEx($model,'permit'); ?>
				
            </td>
            <td>&nbsp;
            </td>
            <td>
                <?php echo $form->textField($model,'permit',array('size'=>20)); ?>
                <?php echo $form->error($model,'permit'); ?>
            </td>
        </tr>
         <tr>
        	<td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
            <td>&nbsp;
            </td>
        </tr>
    </table>
    </div>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<!-- form -->