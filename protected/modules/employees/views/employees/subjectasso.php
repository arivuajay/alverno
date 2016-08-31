<?php
$this->breadcrumbs=array(
	Yii::t('app','Teachers')=>array('index'),
	Yii::t('app','Subject Association'),
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
 <?php $this->renderPartial('profileleft');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1 ><?php echo Yii::t('app','Teacher Profile :');?><?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
<div class="edit_bttns">
    <ul>
    <li><?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('update', 'id'=>$_REQUEST['id']),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
     <li><?php echo CHtml::link('<span>'.Yii::t('app','Teachers').'</span>', array('employees/manage'),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
    </ul>
    </div>
    
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    <div class="emp_tab_nav">
    <?php $this->renderPartial('tab');?>
   </div>
    <div class="clear"></div>
 <div class="emp_cntntbx"><h3><?php echo Yii::t('app','Subject Association');?></h3>
    
<?php
	$flag=0;
	$is_sub=0;
	$is_ele=0;
	$employee_subs = EmployeesSubjects::model()->findAllByAttributes(array('employee_id'=>$_REQUEST['id']));
	if($employee_subs!=NULL)
	{
		$flag=1;
		$is_sub =1;
		$is_ele=1;
?>   
	<h4><?php echo Yii::t('app','Subject');?></h4>
    <div class="table_listbx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <th><?php echo Yii::t('app','Name');?></th>
    <th><?php echo Yii::t('app','Course');?></th>
    <th><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></th>
  </tr>
  <?php
  		foreach($employee_subs as $employee_sub)
		{
  			$subjectname = Subjects::model()->findByPk($employee_sub->subject_id);
			$batchdetails = Batches::model()->findByPk($subjectname->batch_id);
			$coursedetails = Courses::model()->findByPk($batchdetails->course_id);
   ?>
   			<tr>
            	<td align="center"><?php echo $subjectname->name;?></td>
                <td align="center"><?php echo $coursedetails->course_name;?></td>
                <td align="center"><?php echo $batchdetails->name;?></td>
            </tr>
   <?php
		}
  ?>
  </table>
  </div>
  <br />
  <br />
  <?php
	}
	else
	{
		$is_sub = 0;
	}
  ?>

  <?php
	$employee_elecs = EmployeeElectiveSubjects::model()->findAllByAttributes(array('employee_id'=>$_REQUEST['id']));
	if($employee_elecs!=NULL)
	{
		$flag=1;
		$is_ele=1;
?>   
	<h4><?php echo Yii::t('app','Electives');?></h4> 
  <div class="table_listbx">   
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <th><?php echo Yii::t('app','Elective Name');?></th>
    <th><?php echo Yii::t('app','Elective Group');?></th>
    <th><?php echo Yii::t('app','Course');?></th>
    <th><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></th>
  </tr>
  <?php
  		foreach($employee_elecs as $employee_elec)
		{
  			$electivename = Electives::model()->findByPk($employee_elec->elective_id);
			$electivegroupname = ElectiveGroups::model()->findByPk($electivename->elective_group_id);
			$batchdetails = Batches::model()->findByPk($electivegroupname->batch_id);
			$coursedetails = Courses::model()->findByPk($batchdetails->course_id);
   ?>
   			<tr>
            	<td align="center"><?php echo $electivename->name;?></td>
                <td align="center"><?php echo $electivegroupname->name;?></td>
                <td align="center"><?php echo $coursedetails->course_name;?></td>
                <td align="center"><?php echo $batchdetails->name;?></td>
            </tr>
   <?php
		}
  ?>
  </table></div>
  <?php
	}
	else
	{
		$is_ele = 0;
	}
  ?>
  
 <?php
 	if($flag==1)
	{
  ?>  
 <div class="ea_pdf" style="top:23px; right:6px;"><?php echo CHtml::link(Yii::t('app','Generate PDF'), array('Employees/subjectassopdf','id'=>$_REQUEST['id']),array('target'=>'_blank','class'=>'pdf_but')); ?></div>
 <?php
	}
	if($is_sub==0 and $is_ele==0)
	{
  ?>
		<div  align="center" class="notifications nt_red"><?php echo Yii::t('app','No Subject and Electives are Assigned for the Teacher');?></div>
  <?php
	}
  ?>
 </div>
</div>
</div>
</div>
    
    </td>
  </tr>
</table>