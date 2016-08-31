<?php
$this->breadcrumbs=array( 
 Yii::t('app','Create Class Timings')
);
?>
<div style="background:#FFF;min-height: 1000px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">
                <div style="padding:20px;">
                <!--<div class="searchbx_area">
                <div class="searchbx_cntnt">
                    <ul>
                    <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                    <li><input class="textfieldcntnt"  name="" type="text" /></li>
                    </ul>
                </div>
                
                </div>-->
                
                
                <div class="clear"></div>
                    <div class="emp_right_contner">
                        <div class="emp_tabwrapper">
                        	<?php $this->renderPartial('/batches/tab');?>
                        	<div class="clear"></div>
                            <div class="emp_cntntbx" style="padding-top:10px;">
                                <div  align="right" style="position:relative;" >
                                    <div class="edit_bttns" style="width:223px; top:10px;">
                                        <ul>
                                        <li>
                                        <?php echo CHtml::link('<span>'.Yii::t('app','Time Table').'</span>', array('/courses/weekdays/timetable','id'=>$_REQUEST['id']),array('class'=>'addbttn last'));?>
                                        </li>
                                        <li>
                                        <?php echo CHtml::link('<span>'.Yii::t('app','Class Timings').'</span>', array('/courses/classTiming','id'=>$_REQUEST['id']),array('class'=>'addbttn last'));?>
                                        </li>
                                        
                                        </ul>
                                        <div class="clear"></div>
                                    </div> <!-- END div class="edit_bttns" -->
								</div>
                                <div style="width:100%">
                                    <div>
                                        <h3><?php echo Yii::t('app','Create Class Timings');?></h3>

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
                    <?php echo $form->error($model,'exception'); ?>
                </td>                
            </tr>
           
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
            <tr>
                <td><?php echo $form->checkBox($model,'is_break'); ?>
                <?php echo $form->labelEx($model,'is_break',array('style'=>'display:inline')); ?>
                <?php echo $form->error($model,'is_break'); ?></td>												 
	 		</tr>          
        </table>
    </div>
</div>    

<div style="padding:0px 0 0 0px; text-align:left">
    	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Submit') : Yii::t('app','Save'),array('id'=>'submit_button_form','class'=>'formbut')); ?>
    </div>
<?php $this->endWidget(); ?>
 </div>
                            	</div>
                            </div> <!-- END div class="emp_cntntbx" -->
                        </div> <!-- END div class="emp_tabwrapper" -->
                    </div> <!-- END div class="emp_right_contner" -->
                </div>
            </td>
        </tr>
    </table>
</div>

