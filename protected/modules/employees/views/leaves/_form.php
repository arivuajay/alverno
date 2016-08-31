<div class="form">
<?php 
   $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   
   if($settings!=NULL)
    {
       $date=$settings->dateformat;
	   if ($model->start_date!= NULL )
   	   		$model->start_date=date($settings->displaydate,strtotime($model->start_date));
	   if ($model->end_date!= NULL )
		   $model->end_date=date($settings->displaydate,strtotime($model->end_date));
	   
    }
    else
	{
    	$date = 'd-m-Y';	 
		if ($model->start_date!= NULL )
   	   		$model->start_date=date($settings->displaydate,strtotime($model->start_date));
	   if ($model->end_date!= NULL )
		   $model->end_date=date($settings->displaydate,strtotime($model->end_date));
	}
 ?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
 
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
 
<?php endif; ?>


 <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'leave-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        )); ?>
        
        
        <?php 
        if($form->errorSummary($model)){ 
        ?>
                <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
                    <span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
                </div>
        <?php 
        }
        ?>
        
        <?php echo $form->labelEx($model,'employee_leave_types_id'); ?>
         <?php echo $form->dropDownList($model,'employee_leave_types_id',CHtml::listData(EmployeeLeaveTypes::model()->findAll(),'id','name'),array(
        'style'=>'width:140px;','empty'=>Yii::t('app','Select Leave Type'))); ?>
         <?php echo $form->error($model,'employee_leave_types_id'); ?>
         <?php echo $form->hiddenField($model,'employee_id',array('value'=>Yii::app()->user->id)); ?>
        <br/>
        
        <?php echo $form->labelEx($model,'start_date'); ?>
                        <?php 
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                //'name'=>'Students[date_of_birth]',
                                'attribute'=>'start_date',
                                'model'=>$model,
                                // additional javascript options for the date picker plugin
                                'options'=>array(
                                'showAnim'=>'fold',
                                'dateFormat'=>$date,
                                'changeMonth'=> true,
                                'changeYear'=>true,
                                'yearRange'=>'1900:'
                                ),
                                'htmlOptions'=>array(
                                'style'=>'width:92px;'
                                ),
                                ));
                                ?>
        <?php echo $form->error($model,'start_date'); ?>
        
      <br/>  
        <?php echo $form->labelEx($model,'end_date'); ?>
                        <?php 
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                //'name'=>'Students[date_of_birth]',
                                'attribute'=>'end_date',
                                'model'=>$model,
                                // additional javascript options for the date picker plugin
                                'options'=>array(
                                'showAnim'=>'fold',
                                'dateFormat'=>$date,
                                'changeMonth'=> true,
                                'changeYear'=>true,
                                'yearRange'=>'1900:'
                                ),
                                'htmlOptions'=>array(
                                'style'=>'width:92px;'
                                ),
                                ));
                                ?>
        <?php echo $form->error($model,'end_date'); ?>
        
        
      <br/>  
        
        
        
        
        
        <?php echo $form->labelEx($model,'reason'); ?>
        <?php echo $form->textArea($model,'reason',array('size'=>15,'maxlength'=>1000)); ?>
         <?php echo $form->error($model,'reason'); ?>
        
        
        <br/>
        
        <?php echo CHtml::submitButton(Yii::t('app','Apply'),array('class'=>'formbut')); ?>
        
        
        <?php $this->endWidget(); ?>

</div><!-- form -->