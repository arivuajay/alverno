<style type="text/css">
a{ margin:0 2px;}
</style>

<div class="pull-right">

  			<?php if(Yii::app()->controller->action->id=='attendance' or Yii::app()->controller->action->id=='studentattendance')
  			{ 
     			echo CHtml::link('<span>'.Yii::t("app",'View My Attendance').'</span>',array('/teachersportal/default/employeeattendance'),array('class'=>'btn btn-primary pull-right')); 
			}?>
		
        
        
        
 			<?php  
			
				if(Yii::app()->controller->action->id=='attendance' or Yii::app()->controller->action->id=='employeeattendance' or Yii::app()->controller->action->id=='tpAttendance' or Yii::app()->controller->action->id=='tpBatches')
				{ 
					$model = AttendanceSettings::model()->findByAttributes(array('config_key'=>'type'));
					if($model->config_value == 1)
						$link = CHtml::link('<span>'.Yii::t("app",'Manage Student Attendance').'</span>', array('/teachersportal/default/studentattendance'),array('class'=>'btn btn-primary pull-right'));
					else
						$link = CHtml::link('<span>'.Yii::t("app",'Manage Student Attendance').'</span>', array('/attendance/subjectAttendance/tpBatches'),array('class'=>'btn btn-primary pull-right'));
						
					echo $link; 
				}
			?>
		
        
        
        
        	<?php if(count($is_classteacher)>1 and Yii::app()->controller->action->id=='studentattendance' and isset($_REQUEST['id'])){
						echo CHtml::link('<span>'.Yii::t("app",'Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</span>',array('/teachersportal/default/studentattendance'),array('class'=>'btn btn-primary pull-right'));	
			}?>
       
       
       
       
  			<?php 
			if(Yii::app()->controller->action->id=='timetable' or Yii::app()->controller->action->id=='studenttimetable' or Yii::app()->controller->action->id=='employeetimetable' )
  			{ 
     			echo CHtml::link('<span>'.Yii::t("app",'View Day Timetable').'</span>',array('/teachersportal/default/daytimetable'),array('class'=>'btn btn-primary pull-right')); 
			}?>
		
        
        
        
        
  			<?php 
			if(Yii::app()->controller->action->id=='daytimetable' or Yii::app()->controller->action->id=='timetable' or Yii::app()->controller->action->id=='studenttimetable')
  			{ 
     			echo CHtml::link('<span>'.Yii::t("app",'View My Timetable').'</span>',array('/teachersportal/default/employeetimetable'),array('class'=>'btn btn-primary pull-right')); 
			}?>
		
        
        
        
        
        	<?php if($is_classteacher!=NULL){
					if(Yii::app()->controller->action->id=='daytimetable' or Yii::app()->controller->action->id=='timetable' or Yii::app()->controller->action->id=='employeetimetable' )
					{ 
						echo CHtml::link('<span>'.Yii::t("app",'View Class Timetable').'</span>',array('/teachersportal/default/studenttimetable'),array('class'=>'btn btn-primary pull-right')); 
					}
                } ?>
        
        
        
        
        
        	<?php if(count($is_classteacher)>1 and Yii::app()->controller->action->id=='studenttimetable' and isset($_REQUEST['id'])){
						echo CHtml::link(Yii::t("app",'Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('/teachersportal/default/employeetimetable'),array('class'=>'btn btn-primary pull-right'));	
			}?>
        
        
        
        
        	<?php
				$criteria=new CDbCriteria;
				$criteria->select= 'batch_id';
				$criteria->distinct = true;
				// $criteria->order = 'batch_id ASC'; Uncomment if ID should be retrieved in ascending order
				$criteria->condition='employee_id=:emp_id';
				$criteria->params=array(':emp_id'=>$employee->id);
				$batches_id = TimetableEntries::model()->findAll($criteria); 
				if(count($batches_id) > 1){
					if(Yii::app()->controller->action->id=='employeetimetable' and isset($_REQUEST['id'])){
							echo CHtml::link(Yii::t("app",'Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('/teachersportal/default/employeetimetable'),array('class'=>'btn btn-primary pull-right'));	
					}
				}?>
        
        
        
        
        <?php /*?><li>
        	<?php if(Yii::app()->controller->action->id=='examination')
  			{ 
     			echo CHtml::link('<span>View Exam Timetable</span>',array('/teachersportal/default/exams')); 
			}?>
        </li>
        <li>
        	<?php if(Yii::app()->controller->action->id=='examination')
  			{ 
     			echo CHtml::link('<span>View Exam Results</span>',array('/teachersportal/default/exams')); 
			}?>
        </li><?php */?>


</div>

 
