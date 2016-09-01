<style type="text/css">
.formCon input[type="text"], input[type="password"], textArea, select {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 175px !important;
}

.select-style select{ width:135% !important}

.formCon select{background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 78% !important;}
	
	.formCon input[type="text"] {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 175px !important;
}


</style>
<div class="captionWrapper">
  <ul>
    	<li><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Details'),array('students/update','id'=>$_REQUEST['id'],'status'=>0)); } else{ echo Yii::t('app','Student Details'); } ?></h2></li>
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Parent Details'),array('guardians/create','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Parent Details'); } ?></h2></li>
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Emergency Contact'),array('guardians/addguardian','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Emergency Contact'); } ?></h2></li>
        <li><h2 class="cur" ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Previous Details'),array('studentPreviousDatas/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Previous Details'); }?></h2></li>
        <li><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Documents'),array('studentDocument/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Student Documents'); }?></h2></li>
        <li class="last"><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Profile'),array('students/view','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Student Profile'); } ?></h2></li>
    </ul>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-previous-datas-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php if($form->errorSummary($model)){; ?>
    
    <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
    <span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
    </div>
    <?php } ?>
    <p class="note"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>
<div class="formCon" >
    <div class="formConInner">
    	<h3><?php echo Yii::t('app','Institution Details'); ?> </h3>
		<?php if(FormFields::model()->isVisible('institution','StudentPreviousDatas','forAdminRegistration')){ ?>
        <div class="txtfld-col">
            <?php echo $form->labelEx($model,'institution'); ?>
            <?php echo $form->textField($model,'institution',array('size'=>25,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'institution'); ?>
        </div>
        <?php } ?>
        
        <?php if(FormFields::model()->isVisible('year','StudentPreviousDatas','forAdminRegistration')){ ?>
        <div class="txtfld-col">
            <?php echo $form->labelEx($model,'year'); ?>
            <?php echo $form->dropDownList($model,'year',$model->getYears(),array('prompt'=>Yii::t('app','Select'))); ?>
            <?php echo $form->error($model,'year'); ?>
        </div>
        <?php } ?>
        
        <?php if(FormFields::model()->isVisible('course','StudentPreviousDatas','forAdminRegistration')){ ?>
        <div class="txtfld-col">
            <?php echo $form->labelEx($model,'course'); ?>
            <?php echo $form->textField($model,'course',array('size'=>25,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'course'); ?>
        </div>
        <?php } ?>
        
        <?php if(FormFields::model()->isVisible('total_mark','StudentPreviousDatas','forAdminRegistration')){ ?>
        <div class="txtfld-col">
            <?php echo $form->labelEx($model,'total_mark'); ?>
            <?php echo $form->textField($model,'total_mark',array('size'=>25,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'total_mark'); ?>
        </div>
        <?php } ?>
        
        <!-- dynamic fields -->
		<?php
        $fields 	= FormFields::model()->getDynamicFields(4, 1, "forAdminRegistration");
        foreach ($fields as $key => $field) {
            if($field->form_field_type!=NULL){
                $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
            }                                               
        }
        ?>
        <!-- dynamic fields -->
        
        <div class="clear"></div>
    </div>
</div>
	<div class="row">
		<?php //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('value'=>$_REQUEST['id'])); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div style="padding:0px 0 0 0px;text-align:left;">
    <?php //echo CHtml::link('Save And Add Another', array('students/create'),array('class'=>'formbut','style'=>'padding:8px 20px')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Student Documents') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
        <?php 
			if(Yii::app()->controller->action->id=='update'){
				echo '&nbsp;&nbsp;'.CHtml::button(Yii::t('app','Remove'), array('submit' => array('StudentPreviousDatas/delete','id'=>$_REQUEST['pid'],'sid'=>$_REQUEST['id']),'class'=>'formbut','confirm'=>Yii::t('app','Are you sure?')));
			}
		?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->