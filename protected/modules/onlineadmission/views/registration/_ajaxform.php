<?php $time = time(); ?>
      
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="documentTable">
            	<tr>
                	<td><?php echo CHtml::activeLabel($model,Yii::t('app','Document Name')); ?></td>
                    <td><?php echo CHtml::activeLabel($model,'file'); ?></td>
                   
                </tr>                
			<?php
				/*$token		= isset($_GET['token'])?$_GET['token']:NULL;
				$student_id	= $this->decryptToken($token);*/
				$criteria = new CDbCriteria;
				$criteria->join = 'LEFT JOIN student_document osd ON osd.title = t.id and osd.student_id = '.$_REQUEST['id'];
				$criteria->addCondition('osd.title IS NULL');
				//echo "ghjgjhg";exit;
				
            ?>      
                <tr>
                	<td width="30%">                   
						 <div style="padding-right:20px;"><?php echo CHtml::activeDropDownList($model,'title[]',CHtml::listData(StudentDocumentList::model()->findAll($criteria), 'id', 'name'),array('prompt' => Yii::t('app','Select Document Type'),'class'=>'form-control mb15','id'=>$time)); ?>
                         <?php echo CHtml::error($model,'title'); ?></div>
                    </td>
                    <td >
                    	<div style="padding-top:15px;">
						<?php echo CHtml::activeFileField($model,'file[]'); ?>
                        <?php echo CHtml::error($model,'file'); ?>
                        <p style="font-size:11px;"><?php echo Yii::t('app','(Only files with these extensions are allowed: jpg, png, pdf, doc, txt.)'); ?></p>
                        </div>
                    </td>
                   
                </tr>
            </table>
             <?php /*?><div class="row" id="student_id">
                <?php echo CHtml::activeHiddenField($model,'center_id[]',array('value'=>$_REQUEST['id'])); ?>
                <?php echo CHtml::error($model,'center_id'); ?>
            </div><?php */?>
        
            <div class="row" id="file_type">
                <?php //echo $form->labelEx($model,'file_type'); ?>
                <?php echo CHtml::activeHiddenField($model,'file_type[]'); ?>
                <?php echo CHtml::error($model,'file_type'); ?>
            </div>
        
            <div class="row" id="created_at">
                <?php //echo $form->labelEx($model,'created_at'); ?>
                <?php echo CHtml::activeHiddenField($model,'created_at[]'); ?>
                <?php echo CHtml::error($model,'created_at'); ?>
            </div>
 <script>
 $("select#<?php echo $time; ?>").chosen({width:"286px"});
 </script>