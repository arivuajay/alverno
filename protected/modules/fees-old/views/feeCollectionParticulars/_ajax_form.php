<script language="javascript">
function admission_1(){
	$('#admission').show();
	$('#category').hide();
}

function student_1(){
	$('#category').show();
	$('#admission').hide();
}
function all_1()
{
	$('#category').hide();
	$('#admission').hide();
}

</script>
<div id="fee-collection-particulars_form_con" class="client-val-form">
    <?php if ($model->isNewRecord) : ?>    <h3 id="create_header"><?php echoYii::t('app','Create New fee Collection Particular');?></h3>
    <?php  elseif (!$model->isNewRecord):  ?>    <h3 id="update_header"><?php echoYii::t('app','Update : ');?></h3>
    <?php   endif;  ?>
    <?php      $val_error_msg =Yii::t('app','Error.fee Collection Particulars was not saved.');
    $val_success_message = ($model->isNewRecord) ?
           Yii::t('app','fee Collection Particular was created successfully.') :Yii::t('app','fee Collection Particular was updated successfully.');
  ?>

    <div id="success-note" class="notification success png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_success_message;  ?>        </div>
    </div>

    <div id="error-note" class="notification errorshow png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_error_msg;  ?>        </div>
    </div>

    <div id="ajax-form"  class='form'>
<?php   $formId='fee-collection-particulars-form';
   $actionUrl =
   ($model->isNewRecord)?CController::createUrl('feeCollectionParticulars/ajax_create')
                                                                 :CController::createUrl('feeCollectionParticulars/ajax_update');


    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'fee-collection-particulars-form',
    //  'htmlOptions' => array('enctype' => 'multipart/form-data'),
         'action' => $actionUrl,
    // 'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
     'focus'=>array($model,'name'),
     'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
     'clientOptions'=>array('validateOnSubmit'=>true,
                                        'validateOnType'=>false,
                                        'afterValidate'=>'$js_afterValidate',
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
    <?php echo $form->errorSummary($model, '
    <div style="font-weight:bold">Please correct these errors:</div>
    ', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?>    <p class="note">Fields with <span class="required">*</span> are required.</p>


    <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <span id="success-feeCollectionParticulars_name"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'name'); ?>
    </div>

        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <span id="success-feeCollectionParticulars_description"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'description'); ?>
    </div>
     <div class="row">
   
    <input type="radio" name="all" value="all" id="all" checked="checked" onclick="all_1();"/> <?php echoYii::t('app','All'); ?><br />
    
    <input type="radio" name="all" value="admission" id="admi" onclick="admission_1();" /><?php echoYii::t('app','Admission No'); ?><br />
  
      <input type="radio" name="all" value="student" id="stu" onclick="student_1();"  /><?php echoYii::t('app','Student Category'); ?> <br />
	
    </div>

       

   
	<div class="row" >
		<?php
		 //echo $form->labelEx($model,'finance_fee_collection_id'); ?>
		<?php echo $form->hiddenField($model,'finance_fee_collection_id',array('value'=>$_REQUEST['id'])); ?>
        <span id="success-feeCollectionParticulars_finance_fee_collection_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'finance_fee_collection_id'); ?>
    </div>

       <div class="row" id="category" style="display:none;">
		<?php echo $form->labelEx($model,'student_category_id'); ?>
		<?php 
		$data = CHtml::listData(StudentCategories::model()->findAll(), 'id', 'name');
		echo $form->dropDownlist($model,'student_category_id',$data,array('empty'=>'Select')); ?>
        <span id="success-feeCollectionParticulars_student_category_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'student_category_id'); ?>
    </div>

       <div class="row" id="admission" style="display:none;">
		<?php echo $form->labelEx($model,'admission_no'); ?>
		<?php echo $form->textField($model,'admission_no',array('size'=>60,'maxlength'=>255)); ?>
        <span id="success-feeCollectionParticulars_admission_no"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'admission_no'); ?>
    </div>
     <div class="row">
            <?php echo $form->labelEx($model,'amount'); ?>
            <?php echo $form->textField($model,'amount',array('size'=>12,'maxlength'=>12)); ?>
        <span id="success-feeCollectionParticulars_amount"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'amount'); ?>
    </div>

       	<div class="row" style="display:none;">
            <?php echo $form->labelEx($model,'student_id'); ?>
            <?php echo $form->textField($model,'student_id'); ?>
        <span id="success-feeCollectionParticulars_student_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'student_id'); ?>
    </div>

        <div class="row">
            	<?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->hiddenField($model,'is_deleted'); ?>
        <span id="success-feeCollectionParticulars_is_deleted"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'is_deleted'); ?>
    </div>

        <div class="row">
           	<?php //echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d H:i:s'))); ?>
        <span id="success-feeCollectionParticulars_created_at"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'created_at'); ?>
    </div>

        <div class="row">
            <?php //echo $form->labelEx($model,'updated_at'); ?>
            <?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d H:i:s'))); ?>
        <span id="success-feeCollectionParticulars_updated_at"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'updated_at'); ?>
    </div>

    
    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>

    <?php  if (!$model->isNewRecord): ?>    <input type="hidden" name="update_id"
           value=" <?php echo $model->id; ?>"/>
    <?php endif; ?>
    <div class="row buttons" style="width:30%;">
        <?php   echo CHtml::submitButton($model->isNewRecord ?Yii::t('app','Submit') :Yii::t('app','Save'),array('class' =>
        'formbut')); ?>    </div>

  <?php  $this->endWidget(); ?></div>
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


