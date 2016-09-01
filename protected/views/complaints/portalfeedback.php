<style type="text/css">
.success{ background:none;}
</style>

<?php
	
	$roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
	if(sizeof($roles)==1 and key($roles) == 'student')
	{
		$this->renderPartial('application.modules.studentportal.views.default.leftside'); 
	}
	if(sizeof($roles)==1 and key($roles) == 'parent')
	{
		$this->renderPartial('application.modules.parentportal.views.default.leftside'); 
	}
	if(sizeof($roles)==1 and key($roles) == 'teacher')
	{
		$this->renderPartial('application.modules.teachersportal.views.default.leftside'); 
	}
	
	

$feedbacks =ComplaintFeedback::model()->findAllByAttributes(array('complaint_id'=>$_REQUEST['id']));
$complaint=Complaints::model()->findByAttributes(array('id'=>$_REQUEST["id"]));
$category=ComplaintCategories::model()->findByAttributes(array('id'=>$complaint->category_id)); 
?>
<div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-money"></i><?php echo Yii::t("app",'Complaints');?><span><?php echo Yii::t("app",'Create Complaints here');?></span></h2>
        </div>
        
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t("app",'You are here:');?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t("app",'Complaints');?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
<div class="contentpanel"> 
	<div class="panel-heading">    
		<h3 class="panel-title"><?php echo Yii::t('app','Complaints');?></h3>
		<div class="btn-demo" style="position:relative; top:-30px; right:3px; float:right;">
			<?php
            	echo CHtml::link(Yii::t('app','Register a Complaint'),array('complaints/create','id'=>Yii::app()->user->id),array('class'=>'btn btn-primary'));
            ?>
			
			<?php
	if($complaint->status == 0 )
	{
		echo CHtml::link(Yii::t("app",'Close'),array('complaints/close','id'=>$complaint->id),array('class'=>'btn btn-danger','confirm'=>Yii::t('app','Are you sure you want to close this Complaint ?'))); 
	}
	if($complaint->status == 1)
	{
		echo CHtml::link(Yii::t("app",'Reopen'),array('complaints/reopen','id'=>$complaint->id),array('class'=>'btn btn-success','confirm'=>Yii::t('app','Are you sure you want to reopen this Complaint ?'))); 		
	}
?> 
         </div>
    </div>
    <div class="people-item"> 

<div class="table-responsive">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="150"><?php echo Yii::t("app",'Category');?></td>
			<td width="30"><strong>:</strong></td>
			<td><?php if($category->category)
			{
				echo $category->category;?></td>
      <?php }
	  		else
	  		{
				echo Yii::t("app","Category Deleted");
	  		}
	  ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo Yii::t("app",'Subject');?></td>
			<td><strong>:</strong></td>
			<td><?php echo $complaint->subject;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo Yii::t("app",'Complaint');?></td>
			<td><strong>:</strong></td>
			<td><?php echo $complaint->complaint;?></td>
		</tr>
	</tbody>
</table>
</div>
<div style="margin-top:20px;">
<?php

foreach($feedbacks as $feedback)
	{
		if(isset($feedback))
		{
			$profile=Profile::model()->findByAttributes(array('user_id'=>$feedback->uid));?>



<?php
	if($feedback->uid!=Yii::app()->user->id)
	{?>

	
	<div class="chat_one">
		<?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?>
	<div class="triangle-topright"></div>
	</div>
    <?php }
	else
	{
		?>
        <div  id="comment"></div>
		
    <div class="chat_two">
     <?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?>
     <?php
	 
                	echo CHtml::ajaxLink(Yii::t('app','<i class="fa fa-pencil"></i>'), Yii::app()->createUrl('Complaints/update',array('id'=>$feedback->id)), array('type' =>'GET','dataType' => 'text',  'update' =>'#comment', 'onclick'=>'$("#comment_dialog").dialog("open"); return false;',),array('title'=>'edit','class'=>'help_class pull-right'));?>
                    
                    <?php echo CHtml::link(Yii::t('app','<i class="fa fa-trash-o"></i>'),array('delete','id'=>$feedback->id),array('title'=>'delete','class'=>'pull-right','style'=>'margin-right:7px','confirm'=>Yii::t('app','Are you sure you want to delete this comment ?')));?>
                    
	<div class="triangle-topleft"></div>
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

echo $form->textArea($model,'feedback',array('rows'=>3,'class'=>'form-control','style'=>'width:50%;', 'cols'=>15,'placeholder'=>'If any comment enter here')); ?>
 
 
 			<?php echo $form->error($model,'feedback' ); ?><br />

<div class="clearfix"></div>
<div class="buttons">
	<?php echo CHtml::submitButton(Yii::t("app",'Submit'),array('class'=>'btn btn-success')); ?>
   
</div>


<?php $this->endWidget(); ?>

    <div class="clearfix"></div>
</div>  
</div> 
 

                

