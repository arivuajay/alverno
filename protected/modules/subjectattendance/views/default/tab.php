
<?php if(isset($_REQUEST['id']))
{?>
 <h1><?php echo Yii::t('attendance','Manage Attendance'); ?></h1>
 
 
 <?php    $batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
          if($batch!=NULL)
		   {
			   $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
		       if($course!=NULL)
			   {
				   $coursename = $course->course_name; 
				   $batchname = $batch->name;
			   }
			   else
			   {
				   $coursename = ''; 
				   $batchname = '';
			   }
           }?>
          
      

	<div class="c_batch_tbar">
      <div class="edit_bttns" style="width:350px; top:-40px; right:-25px;">
            	<ul>
                <li>
                   <?php echo CHtml::link('<span>'.Yii::t('attendance','Teacher Attendance').'</span>',array('/attendance/employeeAttendances'),array('class'=>'addbttn','style'=>'top:-40px;'));?>
    <?php if(Yii::app()->controller->id=='studentAttentance' and Yii::app()->controller->action->id=='index')
			{
				?>
                </li>
                </ul>
    </div>  
          
            
            <?php
			
			
			echo CHtml::ajaxLink('<span>'.Yii::t('attendance','Change Batch').'</span>',array('/site/explorer','widget'=>'2','rurl'=>'attendance/studentAttentance'),array('update'=>'#explorer_handler'),array('id'=>'explorer_change','class'=>'sb_but','style'=>'right:40px; top:-40px;')); ?>
           
<?php 
			}?>
            
            <?php echo CHtml::link('<span>close</span>',array('/attendance'),array('class'=>'sb_but_close','style'=>'right:0px;top:-40px;'));?>
   
    	<div class="cb_left">
        	<ul>
            	<li><strong><?php echo Yii::app()->getModule("students")->labelCourseBatch().': '; ?></strong> <?php echo $coursename; ?> / <?php echo $batchname; ?></li>
                <li><strong><?php echo Yii::t('Batch','Class Teacher : '); ?></strong> <?php $employee=Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
		    if($employee!=NULL)
		    {
			   echo ucfirst($employee->first_name).' '.ucfirst($employee->middle_name).' '.ucfirst($employee->last_name); 
		    }?></li>
            </ul>
        </div>
        <div class="cb_right" style="width:290px">
        	<div class="status_bx" style="width:290px">
    			<ul>
        			<li><span><?php echo count(Students::model()->findAll("batch_id=:x and is_deleted=:y and is_active=:z", array(':x'=>$_REQUEST['id'],':y'=>0,':z'=>1))); ?></span><?php echo Yii::t('app','Student(s)');?></li>
            		<li><span><?php echo count(Subjects::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']))); ?></span><?php echo Yii::t('attendance','Subject(s)');?></li>
            		<li><span><?php echo count(TimetableEntries::model()->findAll(array('condition'=>'batch_id=:x', 'group'=>'employee_id','params'=>array(':x'=>$_REQUEST['id'])))); ?></span><?php echo Yii::t('app','Teacher(s)');?></li>
        		</ul>
     		<div class="clear"></div>
   			</div>
            
        </div>
        <div class="clear"></div>
    	
    </div>
   
    
<?php }?>
		   