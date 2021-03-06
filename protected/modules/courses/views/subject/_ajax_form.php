<!--
 * Ajax Crud Administration Form
 * Subjects *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 -->
 <style type="text/css">
.ui-dialog {
	background: #fff !important;
	color: #000;
}
</style>
 <?php

if (!$model->isNewRecord)
{
  $criteria = new CDbCriteria;
  $criteria->condition='batch_id=:bat_id';
	$criteria->params=array(':bat_id'=>$model->batch_id);
	$criteria->compare('is_deleted',0); 
}
  
  $data = CHtml::listData(SubjectName::model()->findAll(),'id','name') ?>
 <?php $data1 = CHtml::listData(Subjects::model()->findAll($criteria),'id','name') ?>
<div id="subjects_form_con" class="client-val-form" style="width:350px">
  <?php if ($model->isNewRecord) : ?>
  <h3 id="create_header"> <?php echo Yii::t('app','Add New Subject');?></h3>
  <?php  elseif (!$model->isNewRecord):  ?>
  <h3 id="update_header"><?php echo Yii::t('app','Update Subject : ').$model->name;?></h3>
  <?php   endif;  ?>
  <?php $val_error_msg = Yii::t('app','Error.Subjects was not saved.');
    $val_success_message = ($model->isNewRecord) ?
            Yii::t('app','Subject was added successfully.') :
            Yii::t('app','Subject  was updated successfully.');
  ?>
  <div id="success-note" class="notification success "
         style="display:none;"> <a href="#" class="close"> <img src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
    <div>
      <?php   echo $val_success_message;  ?>
    </div>
  </div>
  <div id="error-note" class="notification errorshow "
         style="display:none;"> <a href="#" class="close"> <img src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
    <div>
      <?php   echo $val_error_msg;  ?>
    </div>
  </div>
  <div id="ajax-form"  class='form'>
    <?php   $formId='subjects-form';
   $actionUrl =
   ($model->isNewRecord)?CController::createUrl('subject/ajax_create')
                                                                 :CController::createUrl('subject/ajax_update');


    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'subjects-form',
    //  'htmlOptions' => array('enctype' => 'multipart/form-data'),
         'action' => $actionUrl,
    	'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
     'focus'=>array($model,'name'),
     'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
     'clientOptions'=>array('validateOnSubmit'=>true,
                                        'validateOnType'=>true,
                                        //'afterValidate'=>'js_afterValidate',
                                        'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidate' => 'js:function(form,data,hasError){ $.js_afterValidate(form,data,hasError);  }',
                                         'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                                                                                                 $.js_afterValidateAttribute(form, attribute, data, hasError);
                                                                                                                            }'
                                                                             ),
));

     ?>
   <?php /*?> <?php echo $form->errorSummary($model, '
    <div style="font-weight:bold">Please correct these errors:</div>
    ', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?><?php */?>
    <p class="note"><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required'); ?>.</p>
    <?php
	if(isset($batch_id) and $batch_id==0)
	{
	?>
    <div class="row"> <?php echo $form->labelEx($model,'batch_id', array('style'=>'color:#000000')); ?>
      <?php 
			$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
            if(Yii::app()->user->year)
			{
				$yr = Yii::app()->user->year;
				//echo Yii::app()->user->year;
			}
			else
			{
				$yr = $current_academic_yr->config_value;
			}
			 $criteria  = new CDbCriteria;
		     $criteria ->compare('is_deleted',0);
			 $criteria->condition = 'is_active=:is_active AND academic_yr_id=:yr';
			 $criteria->params = array(':is_active'=>1,':yr'=>$yr);  
			echo $form->dropDownList($model, 'batch_id', CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>Yii::t('app','Select')));
			?>
      <!--<span id="success-Subjects_name" class="hid input-notification-success  success png_bg right" style="float:right; margin:8px 122px 0px 0px;"></span>-->
      <div> <small></small> </div>
      <?php echo $form->error($model,'batch_id'); ?> </div>
    <?php
	}
	?>
    <div class="row"> <?php echo $form->labelEx($model,'name', array('style'=>'color:#000000')); ?> <?php echo $form->textField($model,'name',array('maxlength'=>'100')); ?>
      <?php /*?><?php if($model->name==NULL)
			{
				echo $form->dropDownList($model,'name',$data,array('prompt'=>'Select'));
			}
			else
			{   
			    echo $form->dropDownList($model,'name',$data1,array('options' => array($model->name=>array('selected'=>true))));
				echo '<br>New Name';
				echo $form->textField($model,'name');
			} ?><?php */?>
      <?php //echo $form->textField($model,'name'); ?>
      <!--<span id="success-Subjects_name"
              class="hid input-notification-success  success png_bg right" style="float:right; margin:8px 122px 0px 0px;"></span>-->
      <div> <small></small> </div>
      <?php echo $form->error($model,'name'); ?> </div>
    <div class="row"> <?php echo $form->labelEx($model,'code', array('style'=>'color:#000000')); ?> <?php echo $form->textField($model,'code',array('maxlength'=>'50')); ?> 
      <!--<span id="success-Subjects_name" class="hid input-notification-success  success png_bg right" style="float:right; margin:8px 122px 0px 0px;"></span>-->
      <div> <small></small> </div>
      <?php echo $form->error($model,'code'); ?> </div>
    <div class="row">
      <?php /*?><table width="60%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php echo $form->checkBox($model,'no_exams');?></td>
                <td><?php echo $form->labelEx($model,Yii::t('app','no_exams')); ?></td>
                <td><?php echo $form->error($model,'no_exams'); ?></td>
              </tr>
            </table><?php */?>
    </div>
    <div class="row" > <?php echo $form->labelEx($model,'max_weekly_classes',array('style'=>'color:#000000')); ?> <?php echo $form->textField($model,'max_weekly_classes',array('maxlength'=>'3')); ?> 
      <!--<span id="success-Subjects_max_weekly_classes"
              class="hid input-notification-success  success png_bg right" ></span>-->
      <div> <small></small> </div>
      <?php echo $form->error($model,'max_weekly_classes'); ?> </div>
    <div class="row">
      <?php /*?><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php echo $form->checkBox($model,'elective_group_id'); ?></td>
                <td><?php echo $form->labelEx($model,Yii::t('app','Elective Group')); ?></td>
                <td><?php echo $form->error($model,'elective_group_id'); ?></td>
              </tr>
            </table><?php */?>
    </div>
    <div class="row">
      <?php //echo $form->labelEx($model,'is_deleted'); ?>
      <?php echo $form->hiddenField($model,'is_deleted'); ?> <span id="success-Subjects_is_deleted"
              class="hid input-notification-success  success png_bg right"></span>
      <div> <small></small> </div>
      <?php echo $form->error($model,'is_deleted'); ?> </div>
    <div class="row">
      <?php  if($model->created_at == NULL)
			  {
				   //echo $form->labelEx($model,'created_at'); 
				   echo $form->hiddenField($model,'created_at',array('value'=>date('d-m-Y')));
				   if(!isset($batch_id))
				   {
				   	echo $form->hiddenField($model,'batch_id',array('value'=>$_POST['batch_id']));
				   }
			  }
			  else
			  {
				  //echo $form->labelEx($model,'updated_at');
				  echo $form->hiddenField($model,'updated_at',array('value'=>date('d-m-Y'))); 
			  }
			  
		  ?>
      <span id="success-Subjects_created_at"
              class="hid input-notification-success  success png_bg right"></span>
      <div> <small></small> </div>
      <?php echo $form->error($model,'created_at'); ?> </div>
    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>
    <?php  if (!$model->isNewRecord): ?>
    <input type="hidden" name="update_id"
           value=" <?php echo $model->id; ?>"/>
    <?php endif; ?>
    <div class="row buttons" style="width:30%">
      <?php   echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Submit') : Yii::t('app','Save'),array('class' =>
        'formbut')); ?>
    </div>
    <?php  $this->endWidget(); ?>
  </div>
  <!-- form --> 
  
</div>
<script type="text/javascript">

    //Close button:

    $(".close").click(
            function () {
                $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                    $(this).slideUp(600);
                });
                return false;
            }
    );


</script> 
