<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transportation-form',
	'enableAjaxValidation'=>false,
)); ?>

<p><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
    <div class="formCon" >
<div class="formConInner">
<table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <?php echo $form->labelEx($model,'student_id'); ?>
                 
            </td>
            <td>&nbsp;
            </td>
            <td><div style="position:relative; width:180px" >
             <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'name'=>'name',
						  'id'=>'name_widget',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>Yii::t('app','Student Name'),'required'=>'required'),
						  'options'=>
							 array(
								   'showAnim'=>'fold',
								   'select'=>"js:function(student, ui) {
									  $('#id_widget').val(ui.item.id);
									 
											 }"
									),
					
						));
						 ?>
        <?php echo CHtml::hiddenField('student_id','',array('id'=>'id_widget')); ?>
		<?php echo CHtml::ajaxLink('',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name','class'=>'exp_but'));?></div></td>
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
                <?php echo $form->labelEx($model,Yii::t('app','Route')); ?>
                
            </td>
            <td>&nbsp;
            </td>
            <td>
			<?php
            
            
             //if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)
                        {
			           
							  echo CHtml::dropDownList('route','',CHtml::listData(RouteDetails::model()->findAll(),'id','route_name'),array('required'=>'required','prompt'=>   Yii::t('app','Select'),
			 'ajax' => array(
			'type'=>'POST',
			'url'=>CController::createUrl('/transport/transportation/routes'),
			'update'=>'#stop_id',
			'data'=>'js:$(this).serialize()',)));
						}
			?>
                
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
                  <?php echo $form->labelEx($model,'stop_id'); ?>
				 
            </td>
            <td>&nbsp;
            </td>
            <td>
                 <?php echo CHtml::activeDropDownList($model,'stop_id',array(),array('required'=>'required','prompt'=>Yii::t('app','Select'),'id'=>'stop_id')); ?>
                <?php //echo $form->error($model,'no_of_stops'); ?>
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
        </table>
		</div>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Allot') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>
    <script type="text/javascript">
		    $(document ).ready(function() {   
			$("#stop_id").change(function(){
				var Id	= $("#stop_id").val();	
					  if(stop_id=='')
					  {
						$(".formbut").show(); 
					  }
					  else
					  {
						  else
		  {
			 $.ajax({
				type: "POST",
				url: <?php echo CJavaScript::encode(Yii::app()->createUrl('transport/Transportation/create'))?>,
				data: {'batchId':batchId},
				success: function(result){	
					  }
	</script>

<?php $this->endWidget(); ?>

</div><!-- form -->