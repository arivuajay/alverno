<?php
$this->breadcrumbs=array(
 Yii::t('app','Settings')=>array('/configurations'),
 Yii::t('app','Create Common Class Timings')
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
<div id="othleft-sidebar">
<?php $this->renderPartial('//configurations/left_side');?>
  </div>
 </td>
 <td valign="top">
<div class="cont_right formWrapper">  
<h1><?php echo Yii::t('app','Create Common Class Timings'); ?></h1>
<div class="edit_bttns " style="top:20px; right:20px;">
    <ul>
        <li><?php echo CHtml::link('<span>'.Yii::t('app','View Common Class Timings').'</span>', array('/commonClassTimings')); ?></li>
    </ul>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'common-class-timing-form',
'enableAjaxValidation'=>false
)); ?>

<div class="formCon">
	<div class="formConInner">
           
    	<table width="50%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td valign="bottom" width="33%"><?php echo $form->labelEx($model,'name'); ?></td>
                <td>&nbsp;</td>
                <td valign="bottom" width="33%"><?php echo $form->labelEx($model,'start_time'); ?></td>
                <td>&nbsp;</td>
                <td valign="bottom" width="33%"><?php echo $form->labelEx($model,'end_time'); ?></td>
            </tr>
            <tr>
            	<td valign="top">
					<?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'name'); ?>
                </td>
                <td>&nbsp;</td>
                <td valign="top">
					<?php 
						$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
						if($settings!=NULL){
							$time=$settings->timeformat;
							if(!$model->isNewRecord){
								$model->start_time=date($settings->timeformat,strtotime($model->start_time));
								$model->end_time=date($settings->timeformat,strtotime($model->end_time));					
							}					
						}
						if($time=='h:i A'){
							$this->widget('application.extensions.jui_timepicker.JTimePicker', array(
									'model'=>$model,
									'attribute'=>'start_time',
									'name'=>'ClassTimings[start_time]',
									'options'=>array(
									'showPeriod'=>true,
									'showPeriodLabels'=> true,
									'showCloseButton'=> true,    
									'closeButtonText'=> 'Done',     
									'showNowButton'=> true,        
									'nowButtonText'=> 'Now',        
									'showDeselectButton'=> true,   
									'deselectButtonText'=> 'Deselect' 
								),	      
   							)); 
						}
						else if($time=='H:i'){
							$this->widget('application.extensions.jui_timepicker.JTimePicker', array(
									'model'=>$model,
									'attribute'=>'start_time',
									'name'=>'ClassTimings[start_time]',
									'options'=>array(
									'showPeriod'=>false,  
									'closeButtonText'=> 'Done',     
									'showNowButton'=> true,           
         						),	      
   							));
						}
    				?> 
                    <?php echo $form->error($model,'start_time'); ?>
                </td>
                <td>&nbsp;</td>
                <td valign="top">
                	<?php
						if($time=='h:i A'){
							$this->widget('application.extensions.jui_timepicker.JTimePicker', array(
									'model'=>$model,
									'attribute'=>'end_time',
									'name'=>'ClassTimings[end_time]',
									'options'=>array(
									'showPeriod'=>true,
									'showPeriodLabels'=> true,
									'showCloseButton'=> true,    
									'closeButtonText'=> 'Done',     
									'showNowButton'=> true,        
									'nowButtonText'=> 'Now',        
									'showDeselectButton'=> true,   
									'deselectButtonText'=> 'Deselect'
	 
         						),
	 
     
   							));
		   				}		   
		  				else if($time=='H:i'){		   
							$this->widget('application.extensions.jui_timepicker.JTimePicker', array(
									'model'=>$model,
									'attribute'=>'end_time',
									'name'=>'ClassTimings[end_time]',
									'options'=>array(
									'showPeriod'=>false,
									//'showPeriodLabels'=> false,
									//'showCloseButton'=> true,       
									'closeButtonText'=> 'Done',     
									'showNowButton'=> true,        
									'nowButtonText'=> 'Now',        
									//'showDeselectButton'=> true,   
									//'deselectButtonText'=> 'Deselect' ,
									//'hours'=>array(
									//'starts' => 0,
									//'ends'=> 23, ),
         						),	      
   							));
		   				}
    				?> 
                    <?php echo $form->error($model,'end_time'); ?>
                </td>                
            </tr>
			<tr>
                                <td></td>
				<td colspan="2"><?php echo $form->error($model,'exception'); ?>&nbsp;</td>
			</tr>
            <tr>
                <td><?php echo $form->checkBox($model,'is_break'); ?>
                <?php echo $form->labelEx($model,'is_break',array('style'=>'display:inline')); ?>
                <?php echo $form->error($model,'is_break'); ?></td>
				<td></td>
				
				 <?php
		$is_batch = Batches::model()->findAll();
		if($model->isNewRecord and $is_batch!=NULL){ ?>
		
				<td><?php echo $form->checkBox($model,'all_batches'); ?>
                <?php echo $form->labelEx($model,'all_batches',array('style'=>'display:inline')); ?>
                <?php echo $form->error($model,'all_batches'); ?></td>
            
			
     <?php } ?> 
	 </tr>          
        </table>
            
    </div>
</div>    

<div style="padding:0px 0 0 0px; text-align:left">
    	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Submit') : Yii::t('app','Save'),array('id'=>'submit_button_form','class'=>'formbut')); ?>
    </div>
<?php $this->endWidget(); ?>

