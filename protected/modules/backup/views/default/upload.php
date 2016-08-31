
<?php
                    $this->breadcrumbs=array(
                           Yii::t('app','Settings')=>array('/configurations'),
                            Yii::t('app','Backup'),
                    );?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side'); ?>
        </td>
        <td valign="top">
		<div class="cont_right formWrapper">
            
            <h1><?php echo Yii::t('app',ucfirst($this->action->id)); ?></h1>

                <div class="form">


                <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'install-form',
                        'enableAjaxValidation' => true,
                        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                ));
                ?>
                                <div class="row">
                                <?php echo $form->labelEx($model,'upload_file'); ?>
                                <?php echo $form->fileField($model,'upload_file',array('id'=>'file_backup')); ?>
                                <?php echo $form->error($model,'upload_file'); ?>
                                </div><!-- row -->	
								
								<br />

                <?php
                        echo CHtml::submitButton(Yii::t('app', 'Save'),array('id'=>'uploadbtn','class'=>'formbut'));
                        $this->endWidget();
                ?>
                </div><!-- form -->
			</div>
        </td>
    </tr>
</table>

<script>
  $("#file_backup").change(function () {
        var fileExtension = ['sql'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert('<?php echo Yii::t('app',"Only .sql format are allowed"); ?>');
            $('#file_backup').val('');
        }
    });
        
        
    
</script>
