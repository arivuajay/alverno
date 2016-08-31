<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<style>
.partial_fee_heading
{
	font-size:12px;
	font-weight:bold;
}
.formConInner table
{
	color:#666666;	
}
</style>
<script>
function new_1(id)
{
	var val = document.getElementById('fees_paid').value;
	if(val==NULL)
	{
		$(".fees_err").html("<?php echo Yii::t('app','Amount cannot be null');?>");
		return false;
	}
	else if(!isNaN(val))
	{
		$(".fees_err").html("");
	}
	else
	{
		$(".fees_err").html("<?php echo Yii::t('app','Amount must be an integer');?>");
		return false;
		//alert('failed');
	}
	
	
}

</script>
<?php 
if(Yii::app()->controller->action->id=='Partialfees')
{
	$title = Yii::t('app','Partial Fee Payment');
}
elseif(Yii::app()->controller->action->id=='Editfees')
{
	$title = Yii::t('app','Edit Fee Payment');
}
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'partialfees'.$model->id,
                'options'=>array(
                    'title'=>$title,
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
$id = $model->id;				
				?>
<div style="padding:10px 20px 10px 20px;">
    <div class="formCon">
        <div class="formConInner" style="width:auto">
        	<table>
            	<tr>
                	<td class="partial_fee_heading">
                    	<?php echo Yii::t('app','Name :'); ?>
                    </td>
                    <td width="200px;">
                    	<?php 
							$student = Students::model()->findByAttributes(array('id'=>$model->student_id,'is_deleted'=>0));
							echo ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name); 
						?>
                    </td>
                    <td class="partial_fee_heading">
                    	<?php echo Yii::t('app','Admission No').' :'; ?>
                    </td>
                    <td>
                    	<?php
							echo $student->admission_no; 
						?>
                    </td>
                </tr>
                <tr>
                	<td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                	<td class="partial_fee_heading">
                    	<?php echo Yii::t('app','Fees :'); ?>
                    </td>
                    <td align="left">
                    	<?php
						$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$model->fee_collection_id));
						$currency=Configurations::model()->findByPk(5);
						$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
						if(count($check_admission_no)>0){ // If any particular is present for this student
							$adm_amount = 0;
							foreach($check_admission_no as $adm_no){
								$adm_amount = $adm_amount + $adm_no->amount;
							}
							$fees = $adm_amount;
							//echo $adm_amount.' '.$currency->config_value;
							$balance = 	$adm_amount - $model->fees_paid;
						}
						else{ // If any particular is present for this student category
							$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
							if(count($check_student_category)>0){
								$cat_amount = 0;
								foreach($check_student_category as $stu_cat){
									$cat_amount = $cat_amount + $stu_cat->amount;
								}
								$fees = $cat_amount;
								//echo $cat_amount.' '.$currency->config_value;
								$balance = 	$cat_amount - $model->fees_paid;		
							}
							else{ //If no particular is present for this student or student category
								$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
								if(count($check_all)>0){
									$all_amount = 0;
									foreach($check_all as $all){
										$all_amount = $all_amount + $all->amount;
									}
									$fees = $all_amount;
									//echo $all_amount.' '.$currency->config_value;
									$balance = 	$all_amount - $model->fees_paid;
								}
								else{
									echo '-'; // If no particular is found.
								}
							}
						}
					if($fees)	
						echo $fees.' '.$currency->config_value;
					else
						echo '-';				
					?>
                    </td>
                    <td class="partial_fee_heading">
                    	<?php echo Yii::t('app','Fees Paid :'); ?>
                    </td>
                    <td align="left">
                    	<?php echo $model->fees_paid.' '.$currency->config_value;?>
                    </td>
                </tr>
                <tr>
                	<td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                	<td class="partial_fee_heading">
                    	<?php echo Yii::t('app','Balance To Pay :'); ?>
                    </td>
                    <?php
                    if($model->is_paid == 0 and $model->fees_paid > $fees)
					{
						echo '<td align="left" style="color: #F50000">';
					}
					else
					{
						echo '<td  align="left">';
					}
					?>                    	
					<?php echo $balance.' '.$currency->config_value;?>
                    </td>
                </tr>
                
            </table>
        
        
        </div>
    </div>
    <div class="formCon">
        <div class="formConInner" style="width:50%; height:auto;">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'partial-fees-form',
            'enableAjaxValidation'=>false,
        )); ?>
        
            <?php echo $form->errorSummary($model); ?>
        
            <div class="row">
                <?php echo $form->hiddenField($model,'id',array('value'=>$model->id)); ?>
                <?php echo $form->error($model,'id'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->hiddenField($model,'fee_collection_id',array('value'=>$model->fee_collection_id)); ?>
                <?php echo $form->error($model,'fee_collection_id'); ?>
            </div>
            
            <div class="row">
                <?php echo $form->hiddenField($model,'student_id',array('value'=>$model->student_id)); ?>
                <?php echo $form->error($model,'student_id'); ?>
            </div>
        
            <div class="row">
                <?php echo $form->labelEx($model,'fees_paid'); ?>
                <?php 
					if(Yii::app()->controller->action->id=='Partialfees')
					{
						echo $form->textField($model,'fees_paid',array('value'=>'','size'=>60,'maxlength'=>120,'onblur'=>'new_1('.count($model).');')); 
					}
					elseif(Yii::app()->controller->action->id=='Editfees')
					{
						echo $form->textField($model,'fees_paid',array('size'=>60,'maxlength'=>120,'onblur'=>'new_1('.count($model).');')); 
					}
				?>
                <div class="amount_err">
                </div>
                <?php /*?><?php echo $form->error($model,'fees_paid'); ?><?php */?>
                </div>
            <br />
            <div class="row buttons">
                 <?php 
				 if(Yii::app()->controller->action->id=='Partialfees')
				 {
					 echo CHtml::ajaxSubmitButton(Yii::t('app','Pay'),CHtml::normalizeUrl(array('FinanceFees/Partialfees')),array('dataType'=>'json','success'=>'js: 				
					 function(data) { 
					  				$(".errorMessage").remove();									
									if(data.status == "success")
									{
										$("#partialfees'.$id.'").dialog("close");
										window.location.reload();
									   
									}
									else if(data.status=="error")
									{
										var errors	= JSON.parse(data.errors);
										
										 $.each(errors, function(index, value){
											var err	= $("<div class=\"errorMessage\" />").text(value[0]);
											err.insertAfter($("#" + index));
										});										
										 
										  
									}
									  //window.location.reload();
								}'),array('id'=>'closeDialog'.$model->id,'name'=>'save')); 
				 }
				 elseif(Yii::app()->controller->action->id=='Editfees')
				 {
					echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('FinanceFees/Editfees')),array('dataType'=>'json','success'=>'js: 				
					 function(data) {
						 			$(".errorMessage").remove();
									if(data.status == "success")
									{
										$("#partialfees'.$id.'").dialog("close");
										window.location.reload();
									   
									}
									else if(data.status=="error")
									{
										var errors	= JSON.parse(data.errors);	
										$.each(errors, function(index, value){
											var err	= $("<div class=\"errorMessage\" />").text(value[0]);
											err.insertAfter($("#" + index));
										});											
										 
										  
									}
								}'),array('id'=>'closeDialog'.$model->id,'name'=>'save'));  
				 }
				?>
            </div>
        
        <?php $this->endWidget(); ?>
        </div>
    </div><!-- form -->

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
