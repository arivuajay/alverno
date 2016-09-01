<?php
$this->breadcrumbs=array(
	Yii::t('app','Settings')=>array('/configurations'),
	Yii::t('app','Online Registration Settings'),
);?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
<div id="othleft-sidebar">
<?php $this->renderPartial('//configurations/left_side');?>
  </div>
 </td>
 <td valign="top">
<div class="cont_right formWrapper">  
<h1><?php echo Yii::t('app','Online Registration Settings');?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'onlineRegSettings-form',
//'enableAjaxValidation'=>true,
)); ?>
<?php

	Yii::app()->clientScript->registerScript(
	'myHideEffect',
	'$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
	CClientScript::POS_READY
	);
	?>
	<?php
	/* Success Message */
	if(Yii::app()->user->hasFlash('successMessage')): 
	?>
		<div class="flashMessage" style="background:#FFF; color:#C00; padding-left:220px; font-size:13px">
		<?php echo Yii::app()->user->getFlash('successMessage'); ?>
		</div>
	<?php endif;
	 /* End Success Message */
?>
     
<?php 
	$start_admission = RegisteredStudents::model()->findAll();
	if(!$start_admission){
?>	 
        <div class="yellow_box_notice">
        	<?php echo Yii::t('app','Note : Admission Number needs to be set in').' '.CHtml::link(Yii::t('app','School Setup'),array('/configurations/create')); ?>
        </div>
<?php } ?>        
<div class="formCon">

	<div class="formConInner">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	
    		<tr>
        		<td><?php echo $form->labelEx($model,'academic_year'); ?></td>
                <td><?php echo $form->labelEx($model,'status'); ?></td>                
                <td><?php echo $form->labelEx($model,'show_link'); ?></td>
        	</tr>  
        	<tr>            
            	<td>
                	<?php 
						$academic_year = AcademicYears::model()->findAll(array('condition'=>'is_deleted=:is_deleted','params'=>array(':is_deleted'=>0)));
						 $val_yr = OnlineRegisterSettings::model()->findByPk(2);
					?>
                	<?php /*?><?php $data = CHtml::listData($academic_years,'id','name'); ?>
        			<?php
					echo CHtml::dropDownList('academic_year','',$data,array('prompt'=>'Select Year','options'=>array($val_yr->config_value => array('selected'=>true))));  
					?><?php */?>
                   <?php //var_dump($academic_year);exit; ?>
                    <?php echo $form->dropDownList($model,'academic_year',CHtml::listData($academic_year,'id','name'),array('empty'=>Yii::t('app','Select Year'),'options'=>array($val_yr->config_value => array('selected'=>true)))); ?>					
                    <?php echo $form->error($model,'academic_year'); ?>
                </td>
                	<?php 	
						$data=OnlineRegisterSettings::model()->findByAttributes(array('id'=>1));
						
						if($data->config_value!=1)
						{
							$status = 0;
						}
						else
						{
							$status = 1;
						}
											
					 ?>
                		<?php $status = OnlineRegisterSettings::model()->findByPk(1); 
						if($status->config_value==1)
						{
							$model->status = 1;
						}
						else
						{
							$model->status = 0;
						}
						?>
                	<td><?php echo $form->checkBox($model,'status'); ?> 
                    	<?php echo $form->error($model,'status'); ?>
                    </td>
                    <?php 
						$show_link = OnlineRegisterSettings::model()->findByPk(4); 
						if($show_link->config_value == 1)
						{
							$model->show_link = 1;					
						}
						else
						{
							$model->show_link = 0;
						}
				   ?>
                   <td><?php echo $form->checkBox($model,'show_link'); ?></td>
                	
                                                  
        	</tr> 
            <tr>            	
        		<td colspan="3">&nbsp;</td>
            </tr>
           </table>
           
        
	</div>
</div>    <?php echo CHtml::submitButton(Yii::t('app','Apply'),array('class'=>'formbut','name'=>'submit')); ?>
<?php $this->endWidget(); ?>
</div>
 </td>
  </tr>
</table>
<script type="text/javascript">
$( document ).ready(function() {   
	$("#status").change(function(){
		if (!this.checked) {
			var academic_year	= $("#academic_year").val();			
			$.ajax({
				type: "	",
				url: <?php echo CJavaScript::encode(Yii::app()->createUrl('onlineRegisterSettings/clearYear'))?>,
				data: {'academic_year':academic_year},
				success: function(result){
					if(result == 1)
					{						
						location.reload(true);
					}
				}
			});
		}
		
		//var lastName	= $("#RegisteredStudents_last_name").val();	
	});
});
	
</script>
<script type="text/javascript">
$( document ).ready(function() {   
	$("#academic_year").change(function(){
		var academic_year	= $("#academic_year").val();		
		if(academic_year=="")
		{
			//$('#status').attr('checked', false);
			$.ajax({
				type: "POST",
				url: <?php echo CJavaScript::encode(Yii::app()->createUrl('onlineRegisterSettings/clearYear'))?>,
				data: {'academic_year':academic_year},
				success: function(result){					
					if(result == 1)
					{						
						location.reload(true);
					}
				}
			});
			
		}
	});
});	
</script>
