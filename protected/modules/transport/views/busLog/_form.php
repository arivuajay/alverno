<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bus-log-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>
	

	<?php echo $form->errorSummary($model); ?>
    <div class="formCon">
        <div class="formConInner">
            <table width="80%" border="0" cellspacing="0" cellpadding="0">
				<?php 
                if(isset($_REQUEST['vehicle_id']) and $_REQUEST['vehicle_id'] != NULL)
                {
                    $vehicle = VehicleDetails::model()->findByAttributes(array('id'=>$_REQUEST['vehicle_id']));
                }
                ?>
                <tr>
                    <td>
                    <span style="float:left;"><label><?php echo Yii::t('app','Select Vehicle');?></label></span> <span class="required">*</span> 
                    </td>
                    <td>&nbsp;</td>
                    <td>
                    <?php $criteria = new CDbCriteria;
                    $criteria->compare('is_deleted',0); ?>
                    <?php echo $form->dropDownList($model,'vehicle_id',CHtml::listData(VehicleDetails::model()->findAll($criteria),'id','vehicle_code'),array('prompt'=>Yii::t('app','Select')));?>
                    <?php echo $form->error($model,'vehicle_id'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                    <?php echo $form->labelEx($model,'start_time_reading'); ?>
                    </td>
                    <td>&nbsp; 
                    </td>
                    <td>
                    <?php echo $form->textField($model,'start_time_reading',array('size'=>20)); ?>
                    <?php echo $form->error($model,'start_time_reading'); ?>
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
                    <td><?php echo $form->labelEx($model,'end_time_reading'); ?></td>
                    <td>&nbsp;</td>
                    <td>
                    <?php echo $form->textField($model,'end_time_reading',array('size'=>20)); ?> 
                    <?php echo $form->error($model,'end_time_reading'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </div> <!-- END div class="formConInner" -->
    </div> <!-- END div class="formCon" -->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut'));  ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->