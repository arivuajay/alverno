<script>
	function removeFile() 
	{	
		if(document.getElementById("new_file").style.display == "none")
		{
			document.getElementById("existing_file").style.display = "none";
			document.getElementById("new_file").style.display = "block";
			document.getElementById("new_file_field").value = "1";
		}
		
		return false;
	}
</script>
<?php 
	$token		= isset($_GET['token'])?$_GET['token']:NULL;
	$student_id	= $this->decryptToken($token);
	
?>
<?php $time = time(); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'center-document-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'action'=>CController::createUrl('/onlineadmission/registration/documentUpdate',array('document_id'=>$model->id,'token'=>$_REQUEST['token']))
)); ?>
<div class="panel panel-default wiz_right" style="margin:30px 20px 0 0">
	<div class="panel-heading" style="position:relative;">
    	
        <div class="col-sm-8"><h3 class="panel-title"><?php echo Yii::t('app','Document Name'); ?></h3></div>
        <div class="col-sm-4">
        	 <?php echo CHtml::link(Yii::t('app','Document List'), array('registration/step3', 'token'=>$_REQUEST['token']),array('class'=>' btn btn-success pull-right')); ?>
        </div>
        <div class="clearfix "></div>
        	
            
  </div>
<div class="panel-body">


	<?php 
		if($form->errorSummary($model)){
	?>
        <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
        	<span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
        </div>
    <?php 
		}
		//var_dump($model->attributes);exit;
	?>
    
  	<p class="note" style="float:left"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>
    
    
    <?php
	Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$(".error").animate({opacity: 1.0}, 3000).fadeOut("slow");',
	   CClientScript::POS_READY
	);
	if(Yii::app()->user->hasFlash('errorMessage')): 
	?>
        <div class="error1" style="color:#C00; padding-left:200px; ">
            <?php echo Yii::app()->user->getFlash('errorMessage'); ?>
        </div>
	<?php
	endif;
	?>

    <div class="formCon" style="clear:left;">
        <div class="formConInner" id="innerDiv">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="documentTable">
            	<tr>
                	<td width="40%"><?php echo $form->labelEx($model,Yii::t('app','Document Name')); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;<?php //echo $form->labelEx($model,Yii::t('students','file')); ?></td>
                </tr>
             
                <tr>
                	<td>
                    <div  ></a></div>
						<?php //echo $form->textField($model,'title',array('size'=>25,'maxlength'=>225,'class'=>'form-control')); ?>
                        <?php 
						$criteria = new CDbCriteria;
						$criteria->join = 'LEFT JOIN student_document osd ON osd.title = t.id and osd.title<>'.$model->title.' and osd.student_id = '.$student_id.'';
						$criteria->addCondition('osd.title IS NULL');
						echo CHtml::activeDropDownList($model,'title',CHtml::listData(StudentDocumentList::model()->findAll($criteria), 'id', 'name'),array('prompt' => Yii::t('app','Select Document Type'),'class'=>'form-control mb15','id'=>$time)); ?>
                        <?php echo $form->error($model,'title'); ?>
                    </td>
                    <td id="existing_file">
                    	<?php 
						if($model->file!=NULL and $model->file_type!=NULL)
						{
						?>
                        <div class="btn-demo" style="margin:10px 10px 5px;">
                        	 <?php echo CHtml::link('<span>'.Yii::t('app','View').'</span>', array('registration/download','id'=>$model->id,'token'=>$_REQUEST['token']),array('class'=>'btn btn-primary')); ?>
                             
                             
                             <?php echo CHtml::link('<span>'.Yii::t('app','Remove').'</span>', array('#'),array('class'=>'btn btn-danger','onclick'=>'return removeFile();')); ?>
                             
                        </div>
                        
                      <?php
						}
						?>
                    </td>
                    <td id="new_file" style="display:none; padding-left:20px;">
						<?php echo $form->fileField($model,'file'); ?>
                        <?php echo $form->error($model,'file'); ?>
                        <?php echo $form->hiddenField($model,'new_file_field',array('value'=>0,'id'=>'new_file_field')); ?>
                    </td>
                </tr>
            </table>
			
           
        
            <div class="row" id="file_type">
                <?php //echo $form->labelEx($model,'file_type'); ?>
                <?php echo $form->hiddenField($model,'file_type'); ?>
                <?php echo $form->error($model,'file_type'); ?>
            </div>
        
            <div class="row" id="created_at">
                <?php //echo $form->labelEx($model,'created_at'); ?>
                <?php echo $form->hiddenField($model,'created_at'); ?>
                <?php echo $form->error($model,'created_at'); ?>
            </div>
        </div>
    </div>
    



</div>
<div class="panel-footer">
             
             
        <?php //echo CHtml::button('Add Another', array('class'=>'formbut','id'=>'addAnother','onclick'=>'addRow("documentTable");')); ?>
        <?php echo CHtml::submitButton(Yii::t('app','Update'),array('class'=>'btn btn-orange')); ?>
              
                          </div><!-- form --><?php $this->endWidget(); ?>
						  </div>