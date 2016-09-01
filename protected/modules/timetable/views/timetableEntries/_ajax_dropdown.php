<table width="100%" border="0" cellspacing="0" cellpadding="0" id="elective_table"> 
<tr>
<td><?php
	$model = new TimetableEntries;
	 echo CHtml::activeLabel($model,Yii::t('app','employee_id')); ?></td>
<td>
<?php 

	$criteria 				= new CDbCriteria;
	$criteria->join 		= "JOIN `employees_subjects` `es` ON `es`.employee_id = `t`.id";
	$criteria->condition 	= "`es`.subject_id=:x";
	$criteria->params		=	array(':x'=>$subject_id);
	$employee = Employees::model()->findAll($criteria);
	
	$data=CHtml::listData($employee,'id','concatened');
	echo CHtml::activeDropDownList($model,'employee_id',
				$data,
				array('prompt'=>Yii::t('app','Select Teacher'),'style'=>'width:200px;','id'=>'employee_id0'
				));

?>
<div id="error_emp_sub" style="color:#F00"></div>
</td>
</tr>
</table>
