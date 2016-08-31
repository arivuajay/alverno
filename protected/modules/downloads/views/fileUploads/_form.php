<style>
.required{
	color:#F00;
}

</style>
<div class="inner_new_form">
<div class="form">
<div class="inner_new_formCon">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-uploads-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<h3 class="note"><?php echo Yii::t('app','Fields with').'<span class="required" >*</span>'.Yii::t('app','are required.');?></h3>

	<?php echo $form->errorSummary($model); ?>

	<div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'title'); ?></td>
    <td width="80%"><?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?></td>
  </tr>
</table>

	</div>

	<div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'category'); ?></td>
    <td width="80%"><?php echo $form->dropDownList($model,'category',CHtml::listData(FileCategory::model()->findAll(),'id','category'),array('prompt'=>Yii::t('app','Select category'))); ?>
		<?php echo $form->error($model,'category'); ?></td>
  </tr>
</table>

		
        
	</div>

	<div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'placeholder'); ?></td>
    <td width="80%"><?php
			$all_roles	=	new RAuthItemDataProvider('roles', array( 
				'type'=>2,
			));
			$data		= $all_roles->fetchData();			
			echo $form->dropDownList($model,'placeholder',CHtml::listData($data,'name','name'),array('prompt'=>Yii::t('app','Public')));
        ?>
		<?php echo $form->error($model,'placeholder'); ?></td>
  </tr>
</table>

		
        
	</div>
    
    
    <div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'course'); ?></td>
    <td width="80%"> <?php
		$current_academic_yr = Configurations::model()->findByPk(35);
        $data 		= CHtml::listData(Courses::model()->findAll('is_deleted=:x AND academic_yr_id=:y',array(':x'=>'0',':y'=>$current_academic_yr->config_value),array('order'=>'course_name DESC')),'id','course_name');
		echo $form->dropDownList($model,'course',$data,
		array('prompt'=>Yii::t('app','Select'),
		'ajax' => array(
		'type'=>'POST',
		'url'=>CController::createUrl('fileUploads/batch'),
		'update'=>'#batch_id',
		'data'=>'js:$(this).serialize()'
		))); 
		?>
		<?php echo $form->error($model,'course'); ?></td>
  </tr>
</table>

		
       
	</div>

	<div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'batch'); ?></td>
    <td width="80%"><?php 
			$data1	=	CHtml::listData(Batches::model()->findAll('is_active=:x AND is_deleted=:y AND academic_yr_id=:z',array(':x'=>'1',':y'=>0,':z'=>$current_academic_yr->config_value),array('order'=>'name DESC')),'id','name');
			echo CHtml::activeDropDownList($model,'batch',$data1,array('prompt'=>Yii::t('app','Select'),'id'=>'batch_id'));
		 ?>
		<?php echo $form->error($model,'batch'); ?></td>
  </tr>
</table>

		
		
	</div>


	<div class="inner_new_formCon_row">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"><?php echo $form->labelEx($model,'file'); ?></td>
    <td width="80%"> <?php
			if(!$model->isNewRecord and $model->file!=NULL and file_exists('uploads/shared/'.$model->id.'/'.$model->file)){
				echo $model->file;
		?>
        <?php echo CHtml::link(Yii::t('app','Remove'),array('removefile','id'=>$model->id),array('confirm'=>Yii::t('app','Are you sure you want to remove this file ?')));?>
        <?php
			}
			else{
		?>		
        <?php echo $form->fileField($model,'file',array('rows'=>6, 'cols'=>50))."<br />".'('.Yii::t('app','Only files with these extensions are allowed: jpg, jpeg, png, gif, pdf, mp4, doc, txt, ppt, docx'); ?>
		<?php echo $form->error($model,'file'); ?>
        <?php 
			}
		?></td>
  </tr>
</table>

		
       
	</div>

	<div class="inner_new_formCon_row row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>	
</div><!-- form -->
</div>