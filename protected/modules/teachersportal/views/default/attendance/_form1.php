<style type="text/css">
.ui-widget-content{ height:auto !important}
</style>
<div class="formCon">
<div class="formConInner">
    <label><?php echo $timetable->fieldClassSubject ?></label>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-attentance-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('app','Specify Reason') ?></p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo  CHtml::hiddenField('id',$_REQUEST['id']); ?>

	<div class="row">
		<?php
		 //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('value'=>$emp_id)); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class=
             "row">
		<?php //echo $form->labelEx($model,'date'); ?>
                <?php echo $form->hiddenField($model,'batch_id',array('value'=>$batch_id)); ?>
		<?php echo $form->hiddenField($model,'date',array('value'=>$year.'-'.$month.'-'.$day)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

    <div class="row">
    			<?php $leave_types = CHtml::listData(StudentLeaveTypes::model()->findAllByAttributes(array('status'=>1)),'id','name');?>
    			<?php echo $form->labelEx($model,'leave_type_id'); ?>
                <?php
				echo $form->dropDownList($model,'leave_type_id',$leave_types,array('options' => array($model->id=>array('selected'=>true)),
        'style'=>'width:100%;','empty'=>'Select Leave Type')); ?>
        		<?php echo $form->error($model,'leave_type_id'); ?>


    </div>
	<div id="leave" style="color:#F00"></div>
	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('app','reason')); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
    <div id="msg" style="color:#F00"></div>
	<br />
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php echo $form->hiddenField($model,'timetable_id',array('value' => $timetable->id)); ?>
         <?php echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('/teachersportal/default/EditLeave','render'=>false)),array('dataType'=>'json','success'=>'js: function(data) {
			 		if (data.status == "success")
                	{
						$("#td'.$day.$emp_id.'").text("");
						$("#jobDialog123'.$day.$emp_id.'").html("<span class=\"abs\"></span>","");
						$("#jobDialog'.$day.$emp_id.'").dialog("close"); window.location.reload();
					}
					else
					{
						if(data.reason=="")
						{
							$("#msg").html("'.Yii::t("app","Reason cannot be blank").'");
						}
						if(data.leave_type=="")
						{
							$("#leave").html("'.Yii::t("app","Leave type cannot be blank").'");
						}
					}
                    }'),array('id'=>'closeJobDialog'.$day.$emp_id,'name'=>'save')); ?>

     <?php echo CHtml::ajaxSubmitButton(Yii::t('app','Delete'),CHtml::normalizeUrl(array('/teachersportal/default/DeleteLeave','render'=>false)),array('success'=>'js: function(data) {
		                $("#td'.$day.$emp_id.'").text(" ");
		                $("#jobDialog'.$day.$emp_id.'").dialog("close"); window.location.reload();
                    }'),array('confirm'=>Yii::t('app', 'Are you sure, You want to delete this reason ?'),'id'=>'closeJobDialog1'.$day.$emp_id,'name'=>'delete')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->