<!--
 * Ajax Crud Administration Form
 * FinanceFeeCollections *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 -->
<div id="finance-fee-collections_form_con" class="client-val-form">
    <?php if ($model->isNewRecord) : ?>    <h3 id="create_header"><?php echo Yii::t('app','Create New Fee Collection');?></h3>
    <?php  elseif (!$model->isNewRecord and strtotime($model->start_date) > time()):  ?>    <h3 id="update_header"><?php echo Yii::t('app','Update');?></h3>
    <?php  elseif (!$model->isNewRecord and strtotime($model->start_date) <= time()):  ?>    <h3 id="update_header"><?php echo Yii::t('app','Notice');?></h3>
    <?php   endif;  ?>
    <?php      $val_error_msg = Yii::t('app','Error.FinanceFeeCollections was not saved.');
    $val_success_message = ($model->isNewRecord) ?
            Yii::t('app','Fee Collection was created successfully.') :
            Yii::t('app','Fee Collection was updated successfully.');
  ?>

    <div id="success-note" class="notification success "
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_success_message;  ?>        </div>
    </div>

    <div id="error-note" class="notification errorshow "
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_error_msg;  ?>        </div>
    </div>
    <?php 
	if($model->isNewRecord or strtotime($model->start_date) > time()){ // Form will be displayed only if it is a new record or fee collection start date is not over.
	?>
	<!-- form -->
    <div id="ajax-form"  class='form'>
<?php   $formId='finance-fee-collections-form';
   $actionUrl =
   ($model->isNewRecord)?CController::createUrl('financeFeeCollections/ajax_create')
                                                                 :CController::createUrl('financeFeeCollections/ajax_update');


    $form=$this->beginWidget('CActiveForm', array(
     'id'=>'finance-fee-collections-form',
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
    <div style="font-weight:bold">'.Yii::t('app','Please correct these errors:').'</div>
    ', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?>    <p class="note"><?php echo Yii::t('app','Fields with').'<span class="required">'.'*'.'</span>'.Yii::t('app',' are required.');?></p>
		
          <div class="row">
            <?php echo $form->labelEx($model,'fee_category_id',array('style'=>'color:#222222')); ?>
             <?php   
			 	$current_academic_yr = Configurations::model()->findByPk(35);
			 	$models = FinanceFeeCategories::model()->findAll("is_master=:x AND academic_yr_id=:y", array(':x'=>1,':y'=>Yii::app()->user->year));
				$data = array();
				foreach ($models as $model_1)
				{
					$posts=Batches::model()->findByPk($model_1->batch_id);
					$data[$model_1->id] = @$model_1->name.'-'.@$posts->name;
				}
	?>
            
            <?php echo $form->dropDownList($model,'fee_category_id',$data,array('empty' =>Yii::t('app','Select Fee Category'))); ?>
        <span id="success-FinanceFeeCollections_fee_category_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'fee_category_id'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'name',array('style'=>'color:#222222')); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255),array('style'=>'float:left')); ?>
        <span id="success-FinanceFeeCollections_name"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'name'); ?>
    </div>
    

        <div class="row">
            <?php echo $form->labelEx($model,'start_date',array('style'=>'color:#222222;')); ?>
            <?php //echo $form->textField($model,'start_date');
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL)
			{
				$date=$settings->dateformat;
				
			if (!$model->isNewRecord)
			{
				$model->start_date=date($settings->displaydate,strtotime($model->start_date));
				$model->end_date=date($settings->displaydate,strtotime($model->end_date));
				$model->due_date=date($settings->displaydate,strtotime($model->due_date));
		
			}
			}
			else
			{
				$date='mm-dd-yy';
			}
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							//'name'=>'publishDate',
							'attribute'=>'start_date',
							'model'=>$model,
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'fold',
								'dateFormat'=>$date, 
								'changeMonth'=> true,
								'changeYear'=>true,
								'yearRange'=>'1900:'.(date('Y')+1),
							),
							'htmlOptions'=>array(
								'style'=>'height:20px;',
								'readonly'=>true
							),
						));
			 ?>
        <span id="success-FinanceFeeCollections_start_date"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'start_date'); ?>
    </div>

        <div class="row">
            <?php echo $form->labelEx($model,'end_date',array('style'=>'color:#222222')); ?>
            <?php //echo $form->textField($model,'end_date');
				
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							//'name'=>'publishDate',
							'attribute'=>'end_date',
							'model'=>$model,
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'fold',
								'dateFormat'=>$date,
								'changeMonth'=> true,
								'changeYear'=>true,
								'yearRange'=>'1900:'.(date('Y')+2),
							),
							'htmlOptions'=>array(
								'style'=>'height:20px;',
								'readonly'=>true
							),
						));
			 ?>
        <span id="success-FinanceFeeCollections_end_date"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'end_date'); ?>
    </div>

        <div class="row">
            <?php echo $form->labelEx($model,'due_date',array('style'=>'color:#222222')); ?>
            <?php //echo $form->textField($model,'due_date');
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							//'name'=>'publishDate',
							'attribute'=>'due_date',
							'model'=>$model,
							// additional javascript options for the date picker plugin
							'options'=>array(
								'showAnim'=>'fold',
								'dateFormat'=>$date, 
								'changeMonth'=> true,
								'changeYear'=>true,
								'yearRange'=>'1900:'.(date('Y')+2),
							),
							'htmlOptions'=>array(
								'style'=>'height:20px;',
								'readonly'=>true
							),
						));
			 ?>
        <span id="success-FinanceFeeCollections_due_date"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'due_date'); ?>
    </div>

      

        <div class="row">
            <?php //echo $form->labelEx($model,'batch_id'); ?>
            <?php echo $form->hiddenField($model,'batch_id'); ?>
        <span id="success-FinanceFeeCollections_batch_id"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'batch_id'); ?>
    </div>

        <div class="row">
            <?php // echo $form->labelEx($model,'is_deleted'); ?>
            <?php echo $form->hiddenField($model,'is_deleted'); ?>
        <span id="success-FinanceFeeCollections_is_deleted"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'is_deleted'); ?>
    </div>

    
    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>

    <?php  if (!$model->isNewRecord): ?>    <input type="hidden" name="update_id"
           value=" <?php echo $model->id; ?>"/>
    <?php endif; ?>
    <div class="row buttons" style="width:30%;">
        <?php   echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Submit') : Yii::t('app','Save'),array('class' =>
        'formbut')); ?>    </div>

  <?php  $this->endWidget(); ?></div>
    <!-- form -->
<?php }
	else{
?>
		<div class="yellow_bx" style="background-image:none;width:400px;padding-bottom:45px;margin-top:20px;margin-right:30px;color:#E26214;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;font-size: 14px;">
        
               <?php echo '<i>'.Yii::t('app','Cannot update because the fee collection has already begun.').'</i>'.'<br/>'; ?>
               <?php echo '<i>'.Yii::t('app','You can either delete this collection or create a new collection.').'</i>';?>
           
    	</div>
<?php
	}
?>
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


