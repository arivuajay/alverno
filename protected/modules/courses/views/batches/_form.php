<style>
.success  {background-color:#fff !important ;}
</style>

<div >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'batches-form',
	//'enableAjaxValidation'=>true,
)); ?>

	<p><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>
	<?php echo $form->errorSummary($model); ?>
    <?php $daterange=date('Y');
 		 $daterange_1=$daterange+20;?>
    <div style="width:100%" >
    <div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><?php echo $form->labelEx($model,'name'); ?></td>
    <td width="5%">&nbsp;</td>
    <td width="45%"><div><?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?></div></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'start_date'); ?></td>
    <td>&nbsp;</td>
    <td><div>
    <?php
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL)
			{
				$date=$settings->dateformat;
		
		
			}
			else
			$date = 'dd-mm-yy';	
   				
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								//'name'=>'Students[admission_date]',
								'model'=>$model,
								'attribute'=>'start_date',
								// additional javascript options for the date picker plugin
								'options'=>array(
									'showAnim'=>'fold',
									'dateFormat'=>$date,
									'changeMonth'=> true,
									'changeYear'=>true,
									'yearRange'=>'1900:'
								),
								'htmlOptions'=>array(
									'style'=>'height:20px;',
									'readonly'=>'readonly',
								),
							));
    ?>
		<?php echo $form->error($model,'start_date'); ?></div></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'end_date'); ?></td>
    <td>&nbsp;</td>
    <td><div>
    <?php		
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								//'name'=>'Students[admission_date]',
								'model'=>$model,
								'attribute'=>'end_date',
								// additional javascript options for the date picker plugin
								'options'=>array(
									'showAnim'=>'fold',
									'dateFormat'=>$date,
									'changeMonth'=> true,
									'changeYear'=>true,
									'yearRange'=>'1900:'.$daterange_1,
								),
								'htmlOptions'=>array(
									'style'=>'height:20px;',
									'readonly'=>'readonly',
								),
							));
   				
    ?>
		<?php echo $form->error($model,'end_date'); ?></div></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <td><?php echo $form->labelEx($model,'employee_id'); ?></td>
    <td>&nbsp;</td>
     <?php
		$criteria=new CDbCriteria;
		$criteria->condition='is_deleted=:is_del';
		$criteria->params=array(':is_del'=>0);
	?>
    <td><div><?php echo $form->dropDownList($model,'employee_id',CHtml::listData(Employees::model()->findAll($criteria),'id','concatened'),array('empty' => Yii::t('app','Select Class Teacher'))); ?>
		<?php echo $form->error($model,'employee_id'); ?></div></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <?php
	$criteria1 = new CDbCriteria;
	$criteria1->condition = 'course_id=:course_id and is_active=:is_active and is_deleted=:is_deleted';
	$criteria1->params = array(':course_id'=>$val1,':is_active'=>1,':is_deleted'=>0);
	$all_batches = Batches::model()->findAll($criteria1);
	if($model->isNewRecord and $all_batches!=NULL){ ?> 
  <tr>        
      <td colspan="4"><?php echo $form->checkBox($model,'duplicate'); ?><?php echo Yii::t('app','Duplicate Subjects or/and Electives From Another').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?>
	  
	  <span id="click_div" style=" color:#0099FF; cursor:pointer" class="fa fa-exclamation-circle"></span>
	  <p id="open_div" style="display: none; padding:9px; line-height:20px;" class="yb_import">
	  <?php echo Yii::t('app','Select the checkbox to add the subjects, electives and their association with teachers from a different').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','to the new').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'<br>'.Yii::t('app','If unchecked, the system will pick the common subjects created for this particular course.');?>
	  </p>
	  
	  </td>  
  </tr>
 
  <tr class="batch_list_block">
  	<td><?php echo $form->labelEx($model,Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'<span style="color:#F00">*</span>'); ?></td>
    <td>&nbsp;</td>
    <td>
		<?php
			
			echo $form->dropDownList($model,'batch_list',CHtml::listData($all_batches,'id','name')); 
		?>
        <?php echo $form->error($model,'batch_list'); ?>
    </td>
  </tr>
  <tr class="batch_list_block">
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="batch_list_block">
  	<td colspan="4">
    	<?php
			$model->duplicate_options = 1;
			echo $form->radioButtonList($model,'duplicate_options',array('1'=>Yii::t('app','All'), '2'=>Yii::t('app','Subjects'), '3'=>Yii::t('app','Electives')),array('separator'=>'','labelOptions'=>array('style'=>'display:inline'))); 
			echo $form->error($model,'duplicate_options');
		?>
    </td>
  </tr>
<?php } ?>  
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        
        <?php	echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('batches/create','render'=>false)),array('dataType'=>'json','success'=>'js: function(data) {
					if (data.status == "success")
					{
					 $("#jobDialog").dialog("close");
					 
						 window.location.reload();	 
					 
					}
					else{
						$(".errorMessage").remove();
						var errors	= JSON.parse(data.errors);						
						$.each(errors, function(index, value){
							var err	= $("<div class=\"errorMessage\" />").text(value[0]);
							err.insertAfter($("#" + index));
						});
					}
                       
                    }'),array('id'=>'closeJobDialog','name'=>Yii::t('app','Submit'))); ?></td>
    <td>&nbsp;</td>
    
    <td>
	</td>
  </tr>
</table>
</div>
</div>
	<div class="row">
		<?php //echo $form->labelEx($model,'course_id'); 
		?>
		<?php echo $form->hiddenField($model,'course_id',array('value'=>$val1)); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'course_id'); 
		?>
		<?php echo $form->hiddenField($model,'academic_yr_id',array('value'=>$academic_yr_id)); ?>
		<?php echo $form->error($model,'academic_yr_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->hiddenField($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->hiddenField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'employee_id'); ?>
		<?php /*?><?php echo $form->textField($model,'employee_id',array('value'=>1)); ?><?php */?>
        <?php /*?><?php echo $form->dropDownList($model,'employee_id',CHtml::listData(Employees::model()->findAll(),'id','concatened'),array('empty' => 'Assign Class Teacher')); ?>
		<?php echo $form->error($model,'employee_id'); ?><?php */?>
	</div>

	<div class="row buttons">
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
$('.batch_list_block').hide();
$('#Batches_duplicate').change(function(ev){
	if(this.checked == true){
		$('.batch_list_block').show();
	}else{
		$('.batch_list_block').hide();
	}
});


$( "#click_div" ).click(function() {
  $( "#open_div" ).slideToggle( "slow", function() {
    // Animation complete.
  });
})
	
</script>