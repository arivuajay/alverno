<style type="text/css">
.formCon input[type="text"], input[type="password"], textArea, select{ width:144px;}
</style>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.maskedinput-1.3.js" type="text/javascript"></script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stop-details-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="pdtab_Con formCon" style="padding:0px; text-align:center;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
        $route=RouteDetails::model()->findByAttributes(array('id'=>$_REQUEST['id']));
        if($route!=NULL)
        {
			$cnt	=	count($model);
			
			if($cnt>0)
			{
			?>
                <tr class="pdtab-h">
                	<td><label><?php echo Yii::t('app','Sl No'); ?></label></td>
                    <td><?php echo $form->labelEx($model[0],Yii::t('app','stop_name')); ?></td>
                    <td><?php echo $form->labelEx($model[0],Yii::t('app','fare')); ?></td>
                    <td><?php echo $form->labelEx($model[0],Yii::t('app','Morning Arrival')); ?></td>
                    <td><?php echo $form->labelEx($model[0],Yii::t('app','Evening Arrival')); ?></td>
                </tr>
                <?php
                
                for($i=0;$i<$cnt;$i++)
                {
                ?>
                <tr>
                	<td><?php echo ($i+1); ?></td>
                    <td>
                        <?php echo CHtml::hiddenField('StopDetails['.$i.'][id]',$model[$i]->id); ?>
                        <?php echo CHtml::textField('StopDetails['.$i.'][stop_name]',$model[$i]->stop_name,array('style'=>'border:none;')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('StopDetails['.$i.'][fare]',$model[$i]->fare,array('style'=>'border:none;')); ?>
                    </td>
                
                    <td>
                        <?php echo CHtml::textField('StopDetails['.$i.'][arrival_mrng]',$model[$i]->arrival_mrng,array('style'=>'border:none;')); ?>
                    </td>
                
                    <td>
                        <?php echo CHtml::textField('StopDetails['.$i.'][arrival_evng]',$model[$i]->arrival_evng,array('style'=>'border:none;')); ?>
                    </td>
                </tr>
                <?php 
                } 
			}
        } 
        ?>
    </table>
</div><br />
<div class="row buttons">
<?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'formbut')); ?>
</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->