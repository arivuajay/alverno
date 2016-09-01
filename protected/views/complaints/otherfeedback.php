<style type="text/css">
.success{ background:none;}
</style>


<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td width="247" valign="top">

<?php
$leftside = 'mailbox.views.default.left_side';	
	$this->renderPartial($leftside); 
$feedbacks =ComplaintFeedback::model()->findAllByAttributes(array('complaint_id'=>$_REQUEST['id']));
$complaint=Complaints::model()->findByAttributes(array('id'=>$_REQUEST["id"]));
$category=ComplaintCategories::model()->findByAttributes(array('id'=>$complaint->category_id)); 
?>
</td>
<td valign="top">
<div class="cont_right formWrapper">


        <h1><?php echo Yii::t("app",'Complaints');?></h1>
        
 <div class="formCon">
 	<div class="formConInner">       

	<div class="panel-heading">    
		
		<div class="contrht_bttns" style="position:relative; top:-59px; right:11px; float:right;">
            <ul>
                <li>
                    <?php
                        echo CHtml::link("<span>".Yii::t('app','Register a Complaint')."</span>",array('Complaints/create','id'=>Yii::app()->user->id));
                    ?>
                    </li>
                </ul>
         </div>
    </div>
    <div class="people-item"> 
	
	 <?php
	if($complaint->status == 0 )
	{
		echo CHtml::link(Yii::t("app",'Close'),array('complaints/close','id'=>$complaint->id),array('class'=>'formbut','style'=>'padding:9px 15px;float:right;height:15px;margin: -10px -126px 0 0','confirm'=>Yii::t('app','Are you sure you want to close this Complaint ?')));  
	}
	if($complaint->status == 1)
	{
		echo CHtml::link(Yii::t("app",'Reopen'),array('complaints/reopen','id'=>$complaint->id),array('class'=>'formbut','style'=>'padding:9px 15px; float:right;height:15px;margin: -10px -126px 0 0','confirm'=>Yii::t('app','Are you sure you want to reopen this Complaint ?')));  		
	}
?>


<div class="table-responsive">
	<table width="96%" cellspacing="0" cellpadding="0" border="0" class="comment_td_style">
	<tbody>
		<tr>
			<td width="150"><?php echo Yii::t("app",'Category');?></td>
			<td><?php if($category->category)
			{
				echo $category->category;?></td>
      <?php }
	  		else
	  		{
				echo Yii::t("app","Category Deleted");
	  		}
	  ?>
		</tr>
		
		<tr>
			<td><?php echo Yii::t("app",'Subject');?></td>
			<td><?php echo $complaint->subject;?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t("app",'Complaint');?></td>
			<td><?php echo $complaint->complaint;?></td>
		</tr>
	</tbody>
</table>
</div>
<div class="chat_div" style="margin-top:5px;width: 635px;">
<?php

foreach($feedbacks as $feedback)
	{
		if(isset($feedback))
		{
			$profile=Profile::model()->findByAttributes(array('user_id'=>$feedback->uid));?>



<?php
	if($feedback->uid==1)
	{?>

	
	<div class="chat_two">
		<?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?>
        
	<div class="triangle-topleft"></div>
	</div>
    <?php }
	else
	{
		?>
         <div  id="comment"></div>
		<div class="chat_one">
     <?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?>
      <?php
	 echo CHtml::ajaxLink(Yii::t('app','<i class="fa fa-pencil"></i>'), Yii::app()->createUrl('complaints/update',array('id'=>$feedback->id)), array('type' =>'GET','dataType' => 'text',  'update' =>'#comment', 'onclick'=>'$("#comment_dialog").dialog("open"); return false;',),array('title'=>'edit','class'=>'help_class pull-right'));?>
     
     <?php echo CHtml::link(Yii::t('app','<i class="fa fa-trash-o"></i>'),array('delete','id'=>$feedback->id),array('title'=>'delete','class'=>'pull-right','style'=>'margin-right:7px','confirm'=>Yii::t('app','Are you sure you want to delete this comment ?')));?>
     
	<div class="triangle-topright"></div>
	</div>

<?php } ?>


<?php
		}
	}
	?>
    
<?php
	  
$form=$this->beginWidget('CActiveForm', array(
'enableClientValidation'=>true,
'clientOptions'=>array(
	'validateOnSubmit'=>true,
),
));
?>

<div class="clearfix"></div>
<?php

echo $form->textArea($model,'feedback',array('rows'=>3,'class'=>'form-control','style'=>'width:70%;', 'cols'=>15,'placeholder'=>'If any comment enter here')); ?>
 
 
 			<?php echo $form->error($model,'feedback' ); ?><br />

<div class="clearfix"></div>
<br />

<div class="buttons">
	<?php echo CHtml::submitButton(Yii::t("app",'Submit'),array('class'=>'formbut','style'=>'padding:6px 10px; height:34px')); ?>
   
</div>


<?php $this->endWidget(); ?>

    <div class="clearfix"></div>
</div>  
</div> 
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>



                
