
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.maskedinput-1.3.js" type="text/javascript"></script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'stop-details-form',
'enableAjaxValidation'=>false,
)); ?>

	<p style="padding-left:20px;"><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>


<?php echo $form->errorSummary($model); ?>
<?php
$route=RouteDetails::model()->findByAttributes(array('id'=>$_REQUEST['id']));
if($route!=NULL)
{
?>
    <div class="formCon">
        <div class="formConInner">
			<?php
            if(isset($_REQUEST['stops']))
            {
                $cnt=$_REQUEST['stops'];
            }
            else
            {
                $cnt=$route->no_of_stops;
            }
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                <?php echo $form->labelEx($model,'route_id'); ?> 
                
                </td>
                <td>&nbsp;
                </td>
                <td>
                <?php 
				$route = RouteDetails::model()->findByAttributes(array('id'=>$_REQUEST['id']));
				echo $form->textField($model,'route_id',array('value'=>$route->route_name,'disabled'=>'disabled'));
				echo $form->hiddenField($model,'route_id',array('value'=>$_REQUEST['id'])); ?>
                <?php echo $form->error($model,'route_id'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            
            <?php
            for($i=0;$i<$cnt;$i++)
            {
            ?>
            <tr>
            	<td colspan="3" width="50"><h3><?php echo Yii::t('app','#Stop').' : '.($i+1);?></h3></td>
            </tr>
        
            <tr>
                <td>
                <?php echo $form->labelEx($model,'stop_name',array('style'=>'float:left;')); ?>
                </td>
                <td>&nbsp;
                </td>
                <td>
                <?php echo $form->textField($model,'stop_name[]',array('size'=>20)); ?>
                <?php echo $form->error($model,'stop_name'); ?>
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
                 <?php echo $form->labelEx($model,'fare',array('style'=>'float:left;')); ?>
                </td>
                <td>&nbsp;
                </td>
                <td>
                <?php echo $form->textField($model,'fare[]',array('size'=>20)); ?>
                <?php echo $form->error($model,'fare'); ?>
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
                <?php echo $form->labelEx($model,'arrival_mrng',array('style'=>'float:left;')); ?>
                </td>
                <td>&nbsp;
                </td>
                <td>
                 <?php //echo $form->textField($model,'arrival_mrng[]',array('size'=>20)); ?>
                 <?php 
                    /*$this->widget('ext.timepicker.timepicker', array(
                         'model'=>$model,
                         'name'=>'arrival_mrng',
                         'select'=> 'time',
                         'options'=>array(
                            'dateFormat'=>'',
                            'timeFormat'=>'hh:mm',
                        ),
                    ));*/
                ?>
                <?php
                
                $this->widget('application.extensions.jui_timepicker.JTimePicker', array(
                 'model'=>$model,
                 'id'=>'arrival_mrng'.$i,
                 'attribute'=>'arrival_mrng[]',
                 'name'=>'arrival_mrng[]',
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
                
                ?>
                
                
                
                <?php echo $form->error($model,'arrival_mrng'); ?>
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
                <?php echo $form->labelEx($model,'arrival_evng',array('style'=>'float:left;')); ?>
                </td>
                <td>&nbsp;
                </td>
                <td>
                <?php
                /*$this->widget('application.extensions.timepicker.timepicker', array(
                    'model'=>$model,
                    'name'=>'arrival_evng',
                    'select'=> 'time',
                    'options'=>array(
                        'dateFormat'=>'',
                        'timeFormat'=>'hh:mm',
                    ),
                ));*/
                ?>
                <?php //echo $form->textField($model,'arrival_evng[]',array('size'=>20)); ?>
                <?php
                
                $this->widget('application.extensions.jui_timepicker.JTimePicker', array(
                 'model'=>$model,
                 'id'=>'arrival_evng'.$i,
                 'attribute'=>'arrival_evng['.$i.']',
                 'name'=>'arrival_evng['.$i.']',
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
                
                ?>
                <?php echo $form->error($model,'arrival_evng'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <?php 
            }
            ?> 
            
        </table>
        </div> <!-- END div class="formConInner" -->
    </div> <!-- END div class="formCon" -->

<?php 
}
?>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->