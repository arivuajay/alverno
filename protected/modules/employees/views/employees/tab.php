<style>
.emp_tab_nav li a{
	padding: 8px 5px 0px;
}
.emp_tab_nav li{padding: 0 2px;}
</style>
<ul style="width:698px;">
    <li>
		<?php 
		if(Yii::app()->controller->action->id=='view')
			echo CHtml::link(Yii::t('app','Profile'), array('/employees/employees/view', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Profile'), array('/employees/employees/view', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    <li>
		<?php 
		if(Yii::app()->controller->action->id=='address')
			echo CHtml::link(Yii::t('app','Address'), array('/employees/employees/address', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Address'), array('/employees/employees/address', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    <li>
		<?php 
		if(Yii::app()->controller->action->id=='contact')
			echo CHtml::link(Yii::t('app','Contact'), array('/employees/employees/contact', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Contact'), array('/employees/employees/contact', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    <li>
		<?php 
		if(Yii::app()->controller->action->id=='addinfo')
			echo CHtml::link(Yii::t('app','Additional Info'), array('/employees/employees/addinfo', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Additional Info'), array('/employees/employees/addinfo', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    <?php $model = Configurations::model()->findByAttributes(array('id'=>38));
		if($model->config_value == 1)
		{ ?>
     <li> 
        <?php    
	          if(Yii::app()->controller->action->id=='achievements' or Yii::app()->controller->action->id=='update')
	          {
		      	echo CHtml::link(Yii::t('app','Achievements'), array('/employees/employees/achievements', 'id'=>$_REQUEST['id']),array('class'=>'active'));
			  }
			  else
			  {
	          	echo CHtml::link(Yii::t('app','Achievements'), array('/employees/employees/achievements', 'id'=>$_REQUEST['id']));
			  }
	    ?>
   <?php } ?>
		</li>
     <li>
     <li>
		<?php 
		if(Yii::app()->controller->action->id=='log')
			echo CHtml::link(Yii::t('app','Log'), array('/employees/employees/log', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Log'), array('/employees/employees/log', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
     <li>
		<?php 
		if(Yii::app()->controller->id=='employeeDocument' or Yii::app()->controller->action->id == 'document')
			echo CHtml::link(Yii::t('app','Documents'), array('/employees/employees/document', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Documents'), array('/employees/employees/document', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    <li>
		<?php 
		if(Yii::app()->controller->id=='employees' && Yii::app()->controller->action->id == 'attendance')
			echo CHtml::link(Yii::t('app','Attendance'), array('/employees/employees/attendance', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Attendance'), array('/employees/employees/attendance', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
    
    <li>
		<?php 
		if(Yii::app()->controller->id=='employees' && Yii::app()->controller->action->id=='subjectasso')
			echo CHtml::link(Yii::t('app','Subject Association'), array('/employees/employees/subjectasso', 'id'=>$_REQUEST['id']),array('class'=>'active'));
		else
			echo CHtml::link(Yii::t('app','Subject Association'), array('/employees/employees/subjectasso', 'id'=>$_REQUEST['id']),array('class'=>''));
		?>
    </li>
</ul>