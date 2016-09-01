<style type="text/css">
.success{ background:none;}
</style>

<?php
 $this->breadcrumbs=array(
	 Yii::t('app','Complaint List')
);
$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
if($settings==NULL)
{
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
}

$feedbacks =ComplaintFeedback::model()->findAllByAttributes(array('complaint_id'=>$_REQUEST['id']));
$complaint=Complaints::model()->findByAttributes(array('id'=>$_REQUEST["id"]));
$category=ComplaintCategories::model()->findByAttributes(array('id'=>$complaint->category_id));
$user=Profile::model()->findByAttributes(array('user_id'=>$complaint->uid));
$roles=Rights::getAssignedRoles($user->user_id);

$user_type="";

foreach($roles as $role)
{
   $user_type="";
       if(sizeof($roles)==1 and $role->name == 'parent')
       {
            $user_type="2";
       }
       if(sizeof($roles)==1 and $role->name == 'student')
       {
           $user_type="1";
       }

}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
<div id="othleft-sidebar">
<?php 
$this->renderPartial('mailbox.views.default.left_side');
?>
</div>
 	</td>
 	<td valign="top">
   
<div class="cont_right formWrapper">  
<h1><?php echo Yii::t('app','Complaint'); ?></h1>


<div class="formCon">
<div class="formConInner">

<?php
				if($complaint->status == 0 )
				{
					echo CHtml::link(Yii::t("app",'Close'),array('complaints/close','id'=>$complaint->id),array('class'=>'formbut pull-right','style'=>'float:right;height:15px;margin: -10px 30px 0 0;','confirm'=>Yii::t('app','Are you sure you want to close this Complaint ?')));  
				}
				if($complaint->status == 1)
				{
					echo CHtml::link(Yii::t("app",'Reopen'),array('complaints/reopen','id'=>$complaint->id),array('class'=>'formbut pull-right','style'=>'float:right;height:15px;margin: -10px 30px 0 0;','confirm'=>Yii::t('app','Are you sure you want to close this Complaint ?')));  
					
				}
				
				
				?> 
<div class="clear"></div>

<table width="96%" cellspacing="0" cellpadding="0" border="0" class="comment_td_style">
	<tbody>
		<tr>
			<th width="150"><?php echo Yii::t("app",'Name');?></th>
                        <?php 
                       
                                    if($user_type==1)
                                    {
                                        
                                        $models= Students::model()->findByAttributes(array('uid'=>$user->user_id));
                                        if($models)
                                        {
                                            if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                    { ?><td>
                                                        <?php $name='';
                                                        $name=  $models->studentFullName('forStudentProfile');
                                                        echo $name; ?>
                                                    </td><?php }
                                        }
                                         
                                    }
                                    else if($user_type==2)
                                    {
                                        
                                        $gmodel= Guardians::model()->findByAttributes(array('uid'=>$user->user_id));
                                        if($gmodel)
                                        {
                                            if(FormFields::model()->isVisible("fullname", "Guardians", "forStudentProfile"))
                                                    { ?><td>
                                                        <?php $cname='';
                                                        $cname=  $gmodel->parentFullName('forStudentProfile');
                                                        echo $cname; ?>
                                                    </td><?php }
                                        }
                                    }
                                    else { ?>
                                    <td><?php echo ucfirst($user->firstname).' '.ucfirst($user->lastname);?> </td> <?php } ?>
		</tr>
		
		<tr>
			<th><?php echo Yii::t("app",'Date');?></th>
			<td><?php echo date($settings->displaydate,strtotime($complaint->date));?></td>
		</tr>
		
		<tr>
			<th><?php echo Yii::t("app",'Category');?></td>
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
			<th><?php echo Yii::t("app",'Subject');?> </th>
			<td><?php echo $complaint->subject;?></td>
		</tr>
		
		<tr>
			<th><?php echo Yii::t("app",'Complaint');?></th>
			<td><?php echo $complaint->complaint;?></td>
		</tr>
	
	</tbody>
</table>

<div class="chat_div" style="margin-top:5px;width: 635px;">
<?php
foreach($feedbacks as $feedback)
	{
		if(isset($feedback))
		{
			$profile=Profile::model()->findByAttributes(array('user_id'=>$feedback->uid));?>

<div class="clear"></div>
<div  id="comment"></div>
<?php
	if($feedback->uid==Yii::app()->user->id)
	{?>

	
	<div class="chat_two">
            
            <?php
            
                $roles=Rights::getAssignedRoles($profile->user_id);

                $feedback_user_type="";

                foreach($roles as $role)
                {
                   $feedback_user_type="";
                       if(sizeof($roles)==1 and $role->name == 'parent')
                       {
                            $feedback_user_type="2";
                       }
                       if(sizeof($roles)==1 and $role->name == 'student')
                       {
                           $feedback_user_type="1";
                       }

                }
                if($feedback_user_type==1)
                {
                    $student_model= Students::model()->findByAttributes(array('uid'=>$profile->user_id));
                    if($student_model)
                    {
                        if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                { ?>
                                    <?php $sname='';
                                    $sname=  $student_model->studentFullName('forStudentProfile');
                                    echo $sname.' : '. ucfirst($feedback->feedback); ?>
                                d><?php }
                    }
                }
                else if($feedback_user_type==2)
                {
                    $guard_model= Guardians::model()->findByAttributes(array('uid'=>$profile->user_id));
                    if($guard_model)
                    {
                        if(FormFields::model()->isVisible("fullname", "Guardians", "forStudentProfile"))
                                { ?><td align="center">
                                    <?php $gname='';
                                    $gname=  $guard_model->parentFullName('forStudentProfile');
                                    echo $gname.' : '. ucfirst($feedback->feedback); ?>
                                </td><?php }
                    }
                }else
                {
                    
                    ?><?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?><?php
                }
                
                
            ?>
            
            
            
            
            
		
        
        <?php echo CHtml::ajaxLink(Yii::t('app','<i class="fa fa-pencil"></i>'), Yii::app()->createUrl('complaints/update',array('id'=>$feedback->id)), array('type' =>'GET','dataType' => 'text',  'update' =>'#comment', 'onclick'=>'$("#comment_dialog").dialog("open"); return false;',),array('title'=>'edit','class'=>'help_class pull-right'));?>
        
        <?php echo CHtml::link(Yii::t('app','<i class="fa fa-trash-o"></i>'),array('delete','id'=>$feedback->id),array('title'=>'delete','class'=>'pull-right','style'=>'margin-right:7px','confirm'=>Yii::t('app','Are you sure you want to delete this comment ?')));?>
       
	<div class="triangle-topleft"></div>
    
	</div>
    
    
    <?php }
	else
	{
		?>
		
    <div class="chat_one">
        
        <?php
                $roles=Rights::getAssignedRoles($profile->user_id);

                $feedback_user_type="";

                foreach($roles as $role)
                {
                   $feedback_user_type="";
                       if(sizeof($roles)==1 and $role->name == 'parent')
                       {
                            $feedback_user_type="2";
                       }
                       if(sizeof($roles)==1 and $role->name == 'student')
                       {
                           $feedback_user_type="1";
                       }

                }
                if($feedback_user_type==1)
                {
                    $lmodel= Students::model()->findByAttributes(array('uid'=>$profile->user_id));
                    if($lmodel)
                    {
                        if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                { ?>
                                    <?php $name='';
                                    $name=  $lmodel->studentFullName('forStudentProfile');
                                    echo $name.' : '. ucfirst($feedback->feedback); ?>
                                d><?php }
                    }
                }
                else if($feedback_user_type==2)
                {
                    $comm_model= Guardians::model()->findByAttributes(array('uid'=>$profile->user_id));
                    if($comm_model)
                    {
                        if(FormFields::model()->isVisible("fullname", "Guardians", "forStudentProfile"))
                                { ?><td align="center">
                                    <?php $name='';
                                    $name=  $comm_model->parentFullName('forStudentProfile');
                                    echo $name.' : '. ucfirst($feedback->feedback); ?>
                                </td><?php }
                    }
                }else
                { ?>
                <?php echo ucfirst($profile->firstname).' '.ucfirst($profile->lastname).' : '. ucfirst($feedback->feedback);?> <?php } ?>
     
     
       
     
	<div class="triangle-topright"></div>
	</div>
	<div class="clear"></div>

<?php } ?>

<?php
		}
	}
$form=$this->beginWidget('CActiveForm', array(
'enableClientValidation'=>true,
'clientOptions'=>array(
	'validateOnSubmit'=>true,
),
));
echo $form->textArea($model,'feedback',array('rows'=>5,'style'=>'width:350px;', 'cols'=>15,'placeholder'=>Yii::t("app",'Enter your feedback here'))); ?>






    			<?php echo $form->error($model,'feedback' ); ?>
<div class="row buttons" style="margin-top:10px;">
	<?php echo CHtml::submitButton(Yii::t("app",'Submit'),array('class'=>'formbut','style'=>'height:32px')); ?>
    
    

                </div>
                </div>
<?php $this->endWidget(); ?>

 </div>
 </div>               


		
 
