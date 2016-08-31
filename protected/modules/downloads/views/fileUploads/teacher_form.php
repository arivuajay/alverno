<style>
.required{
	color:#4a535e;
}
.required span{
	color:#F00;
}

.note span{
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

	<h5 class="note"><?php echo Yii::t('app', 'Fields with');?> <span class="required" >*</span> <?php echo Yii::t('app', 'are required.');?></h5>

	<?php echo $form->errorSummary($model); ?>
    
<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'title'); ?> </label>
    
    <div class="col-sm-6">
	<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?> </div>
  

	</div>

	<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'category'); ?></label>
    
    
    <div class="col-sm-6"> <?php echo $form->dropDownList($model,'category',CHtml::listData(FileCategory::model()->findAll(),'id','category'),array('prompt'=>Yii::t('app', 'Select category'),'class'=>'form-control')); ?>
		<?php echo $form->error($model,'category'); ?></div></div>
        
        
		
     <div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'placeholder'); ?></label>
    
   <div class="col-sm-6">  <?php
			$all_roles	=	new RAuthItemDataProvider('roles', array( 
				'type'=>2,
			));
			$data		= $all_roles->fetchData();			
			echo $form->dropDownList($model,'placeholder',CHtml::listData($data,'name','name'),array('prompt'=>Yii::t('app', 'Public') ,'class'=>'form-control'));
        ?>
		<?php echo $form->error($model,'placeholder'); ?></div></div>
        
        
    
    
	<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'course'); ?></label>
    
    
	 <div class="col-sm-6"> <?php
		
	 	$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
		if(Yii::app()->user->year)
		{
		 $year = Yii::app()->user->year;
		}
		else
		{
		 $year = $current_academic_yr->config_value;
		}	

        $data 		= CHtml::listData(Courses::model()->findAll('is_deleted=:x AND academic_yr_id=:y',array(':x'=>'0',':y'=>$year),array('order'=>'course_name DESC')),'id','course_name');
		echo $form->dropDownList($model,'course',$data,
		array('prompt'=>Yii::t('app', 'Select'),'class'=>'form-control',
		'ajax' => array(
		'type'=>'POST',
		'url'=>CController::createUrl('fileUploads/batch'),
		'update'=>'#batch_id',
		'data'=>'js:$(this).serialize()'
		))); 
		?>
		<?php echo $form->error($model,'course'); ?>
        </div></div>
        
        
        
        
 

		
       
	<div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'batch'); ?></label>
    
    <div class="col-sm-6"> <?php 
			$data1	=	CHtml::listData(Batches::model()->findAll('is_active=:x AND is_deleted=:y ',array(':x'=>'1',':y'=>0),array('order'=>'name DESC')),'id','name');
			echo CHtml::activeDropDownList($model,'batch',$data1,array('prompt'=>Yii::t('app', 'Select'),'class'=>'form-control','id'=>'batch_id'));
		 ?>
		<?php echo $form->error($model,'batch'); ?> </div></div>
  
  
  
  
		
		
	
    <div class="form-group">
	<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'file'); ?></label>
    
    <div class="col-sm-6"><?php
			if(!$model->isNewRecord and $model->file!=NULL and file_exists('uploads/shared/'.$model->id.'/'.$model->file)){
				echo $model->file;
		?>
        <?php echo CHtml::link(Yii::t('app','Remove'),array('removefile','id'=>$model->id),array('confirm'=>Yii::t('app','Are you sure you want to remove this file ?')));?>
        <?php
			}
			else{
		?>		
		<?php echo $form->fileField($model,'file',array('rows'=>6, 'cols'=>50)).'('. Yii::t('app','Only files with these extensions are allowed: jpg, jpeg, png, gif, pdf, mp4, doc, txt, ppt, docx').')'; ?>
		<?php echo $form->error($model,'file'); ?>
        <?php 
			}
		?></div></div>
        
        
        <div class="form-group">
	<label class="col-sm-3 control-label"></label>
    
    <div class="col-sm-6">		
		
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-danger')); ?>
        </div></div>
        
        
		
       
	</div>

	<div class="inner_new_formCon_row row buttons">
		
	</div>

<?php $this->endWidget(); ?>
</div>	
</div><!-- form -->
</div>