<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
 <div style="background:#fff; min-height:800px;">  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
		<div style="padding:20px; position:relative;">
			<h1><?php echo Yii::t('app','Attendance Management'); ?></h1>
            <div class="edit_bttns" style="width:350px; top:30px; right:-15px;">
            	<ul>
                <li>
           <?php  echo CHtml::ajaxLink('<span>'.Yii::t('app','Student Attendance').'</span>',array('/site/explorer','widget'=>'sub_att','rurl'=>'attendance/studentAttentance'),array('update'=>'#explorer_handler'),array('id'=>'explorer_change','class'=>'addbttn')); ?>
           		</li> 
                 <li>
                 <?php echo CHtml::link('<span>'.Yii::t('app','Employee Attendance').'</span>',array('/attendance/employeeAttendances'),array('class'=>'addbttn'));?>
                 </li>
                 </ul>
           </div> 
            
				<div class="yellow_bx yb_attendance">
                	<div class="y_bx_head">
                    	<?php echo Yii::t('app','Before recording the Attendance, make sure you follow the following instructions'); ?>
                    </div>
                	<div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Set Weekdays'); ?></h1>
                        <p>
                        <?php echo Yii::t('app','Set the weekdays, where the specific').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','has classes, You can use the school default or custom weekdays.'); ?>
						</p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Set Class Timings'); ?></h1>
                        <p>
                        <?php echo Yii::t('attendance','Create class timings for each').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Enter each period start time and end time,Add break timings etc.'); ?>
						</p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('attendance','Subjects & Subject Allocation'); ?></h1>
                        <p>
                        <?php echo Yii::t('attendance','Add existing subjects to the').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','or create a new subject. Associate each subject with the teacher.'); ?>
						</p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('attendance','Create Timetable'); ?></h1>
                        <p><?php echo Yii::t('attendance','Assigning each timing/period from the dropdown.'); ?></p>
                    </div>
    			</div>
		<div class="clear"></div>
		</div>
		</td>
       </tr>
     </table>
    </td>
   </tr>
</table>
</div>
