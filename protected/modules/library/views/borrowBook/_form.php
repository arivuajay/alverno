<style type="text/css">
#msg_id
{
	color:#F00;
	text-align:center;
	vertical-align:baseline;
}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'borrow-book-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note"><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>

	<?php echo $form->errorSummary($model); ?>
<div class="formCon">
<div class="formConInner">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21%"><?php echo $form->labelEx($model,'student_admission_no'); ?></td>
    <td width="7%">&nbsp;</td>
    <td width="72%"><?php echo $form->textField($model,'student_admission_no');?>
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'subject'); ?></td>
    <td>&nbsp;</td>
    <td>
    <?php 		
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->select = 'subject';
		$criteria->condition = 'is_deleted=:is_deleted';
		$criteria->params = array(':is_deleted'=>0);
		$criteria->order = 'subject ASC';
		$books = Book::model()->findAll($criteria);
		echo $form->dropDownList($model,'subject',CHtml::listData($books,'subject','subject'),array('prompt'=>Yii::t('app','Select'),'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/library/book/subjects'),
	'update'=>'#book_id',
	'data'=>'js:$(this).serialize()',))); ?>
    
    <?php /*?> <?php echo CHtml::dropDownList('subject','',CHtml::listData(Subjects::model()->findAll(),'id','name'),array('prompt'=>'Select',
'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/library/book/subjects'),
	'update'=>'#book_id',
	'data'=>'js:$(this).serialize()',)));?><?php */?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <?php echo $form->labelEx($model,'book_name'); ?></td>
    <td>&nbsp;</td>
    <td>
	<?php echo $form->dropDownList($model,'book_name',array(),array('empty'=>Yii::t('app','Select'),'id'=>'book_id','ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/library/book/checkSubjects'),
	'update'=>'#msg_id',
	'data'=>array('book_id'=>'js:this.value', 'stud_id'=>'js:$("#BorrowBook_student_admission_no").val()'),))); 
	
	
	//'data'=>array('batch_id'=>'js:this.value', 'date'=>'js:$("#at_date").val()'),?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td><div id='msg_id'> </div></td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'issue_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php //echo $form->textField($model,'admission_date');
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
								'attribute'=>'issue_date',
								// additional javascript options for the date picker plugin
								'options'=>array(
									'showAnim'=>'fold',
									'dateFormat'=>$date,
									'changeMonth'=> true,
									'changeYear'=>true,
									'yearRange'=>'2000:2050'
								),
								'htmlOptions'=>array(
									'style'=>'height:20px;'
								),
							));
							?>
		
		<?php //echo $form->error($model,'issue_date'); ?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'due_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php 
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								//'name'=>'Students[admission_date]',
								'model'=>$model,
								'attribute'=>'due_date',
								// additional javascript options for the date picker plugin
								'options'=>array(
									'showAnim'=>'fold',
									'dateFormat'=>$date,
									'changeMonth'=> true,
									'changeYear'=>true,
									'yearRange'=>'2000:2050'
								),
								'htmlOptions'=>array(
									'style'=>'height:20px;'
								),
							));
		 ?>
		
		<?php //echo $form->error($model,'due_date'); ?></td>
  </tr>

</table>

	<div class="row">
		<?php //echo $form->labelEx($model,'created'); ?>
		<?php echo $form->hiddenField($model,'created',array('value'=>date('Y-m-d'))); ?>
		<?php //echo $form->error($model,'created'); ?>
	</div>
</div>
</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
 <script type="text/javascript">

	$(document).ready(function () {
            //Hide the second level menu
            $('#othleft-sidebar ul li ul').hide();            
            //Show the second level menu if an item inside it active
            $('li.list_active').parent("ul").show();
            
            $('#othleft-sidebar').children('ul').children('li').children('a').click(function () {                    
                
                 if($(this).parent().children('ul').length>0){                  
                    $(this).parent().children('ul').toggle();    
                 }
                 
            });
          
            
        });
    </script>
