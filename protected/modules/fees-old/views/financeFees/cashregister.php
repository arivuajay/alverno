<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fees')=>array('/fees'),
	
);?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
    <h1><?php echo Yii::t('app','Cash register');?></h1>
    <div class="formCon" style="padding:3px;">
    <div class="formConInner" style="padding:3px 10px;">
   <div id="studentname" style="display:block;" >
      <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'name'=>'name',
						  'id'=>'name_widget',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>'Student Name'),
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
		<?php echo CHtml::ajaxLink('[][][]',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name'));?>
        	 <?php echo CHtml::submitButton( Yii::t('app','Search'),array('name'=>'search','class'=>'formbut')); ?>   
     </div>
</div></div>
   

       <?php
	   if(isset($list) and $list!=NULL)
	   {
		   ?>
           <div class="tableinnerlist"> 
   <?php echo Yii::t('app','Fee Details');?>
     
        <br />
           <table width="70%" cellspacing="0" cellpadding="0">
               <tr>
         <th><strong><?php echo Yii::t('app','Sl no.');?></strong></th>
         <th><strong><?php echo Yii::t('app','Student Name');?></strong></th>
         <th><strong><?php echo Yii::t('app','Paticulars');?></strong></th>
          <th><strong><?php echo Yii::t('app','Amount');?></strong></th>
        </tr>
        <?php
		foreach($list as $list_1)
		{
			$collection = FinanceFeeCollections::model()->findAllByAttributes(array('batch_id'=>$list_1->batch_id));
			for($i = 0;$i<count($collection);$i++)
			{
				$particular = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection[$i]->fee_category_id));
				$list  = FinanceFees::model()->findAll("fee_collection_id=:x", array(':x'=>$collection[$i]->id));
			}
			$k=1;
			for($j=0;$j<count($particular);$j++)
			{
				$amount = $amount + $particular[$i]->amount;
				$k++;
			}
		}
		
		?>
        <tr>
        	<td><?php echo $i; ?></td>
            <td><?php echo $list_1->first_name; ?></td>
            <td><?php echo $particular[$i]->name; ?></td>
            <td><?php echo $amount; ?></td>
        </tr>
      </table>
           <?php
	   }
	   ?>
</div>





    
    
    </div>
    </td>
  </tr>
</table>
 <?php $this->endWidget(); ?>