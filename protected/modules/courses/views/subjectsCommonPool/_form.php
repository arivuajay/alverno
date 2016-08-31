
<div class="form">

<?php

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'subjects-common-pool-form',
	//'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app',' are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
<div style="width:90%" >
    <div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <?php 
			 	if(isset($_GET['val1']) and $_GET['val1'] !='null'){
					$model->course_id = $_GET['val1'];
				}
					
							if(Yii::app()->user->year)
							{
								$year = Yii::app()->user->year;
							}
							
								$academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
								$year = $academic_yr->config_value;
							
							$criteria = new CDbCriteria;							
							$criteria->condition = 'is_deleted = :is_deleted and academic_yr_id = :academic_yr_id';
							$criteria->params = array(':is_deleted'=>0,':academic_yr_id'=>$academic_yr->config_value);
                            echo $form->dropDownList($model,'course_id',CHtml::listData(Courses::model()->findAll($criteria), 'id', 'course_name'),array(
                            'class'=>'form-control','empty'=>Yii::t('app','Select Course'))); 
			
			 	?>
             <?php if(isset($_GET['sub_id']) and Yii::app()->controller->action->id=='addupdate'){
            			 echo $form->hiddenField($model,'id',array('size'=>40,'maxlength'=>255,'value'=>$_GET['sub_id'],''));
			 		}	?>
            </tr>
                <tr>
                <td>&nbsp;</td>
             </tr>
           
            <tr>
                <td width="90%"><?php echo $form->labelEx($model,'subject_name'); ?></td>
            </tr>
            <tr>
           
                <td width="90%"><div><?php 
                
				echo $form->textField($model,'subject_name',array('size'=>20,'maxlength'=>255,'style'=>'width:100%')); ?>
                <?php echo $form->error($model,'subject_name'); ?>
               <?php /*?> <input type="text" name="myTextInput" value="<?= html_entity_decode($model->subject_name, ENT_QUOTES); ?>" /><?php */?>
                </div></td>
             
            </tr>
             <tr>
                <td>&nbsp;</td>
             </tr>
             <tr>
                <td width="90%"><?php echo $form->labelEx($model,'subject_code'); ?></td>
              </tr>
            <tr>
                <td width="90%"><div><?php echo $form->textField($model,'subject_code',array('size'=>20,'maxlength'=>255,'style'=>'width:100%')); ?>
                <?php echo $form->error($model,'subject_code'); ?></div></td>
            </tr>
             <tr>
                <td>&nbsp;</td>
             </tr>
             <tr>
                <td width="90%"><?php echo $form->labelEx($model,'max_weekly_classes'); ?></td>
             </tr>
            <tr>
                <td width="90%"><div><?php echo $form->textField($model,'max_weekly_classes',array('size'=>20,'maxlength'=>255,'style'=>'width:100%')); ?>
                <?php echo $form->error($model,'max_weekly_classes'); ?></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
              <?php if($model->isNewRecord){ ?>
                  <tr>
                    <td> <?php echo $form->checkBox($model,'all_batches'); ?>
                    <?php echo Yii::t('app','All').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></td>                    
                  </tr>
              <?php } ?>
            <tr>
                <td>&nbsp;</td>
            </tr>  
        </table>
  

	<div class="row buttons">
    
    
     <?php	echo CHtml::ajaxSubmitButton(Yii::t('app','Save'),CHtml::normalizeUrl(array('subjectsCommonPool/create','render'=>false)),array('dataType'=>'json','success'=>'js: function(data) {
					if (data.status == "success")
					{
					 $("#jobDialog").dialog("close");
					 if(data.flag==1)
					 {
						 //window.location.href = "'.Yii::app()->request->baseUrl.'/index.php?r=courses/courses/managecourse"; 
						 window.location.reload();
					 }
					}
					else{
						$(".errorMessage").remove();
						var errors	= JSON.parse(data.errors);						
						$.each(errors, function(index, value){
							var err	= $("<div class=\"errorMessage\" />").text(value[0]);
							err.insertAfter($("#" + index));
						});
					}
                       
                    }'),array('id'=>'closeJobDialog','name'=>Yii::t('app','Submit'))); ?>
    
    
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->