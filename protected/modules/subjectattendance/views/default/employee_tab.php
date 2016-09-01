 
 <div class="edit_bttns" style="width:350px; top:30px; right:50px;">
            	<ul>
                <li>
 <?php  echo CHtml::ajaxLink('<span>Student Attendance</span>',array('/site/explorer','widget'=>'s_a','rurl'=>'attendance/studentAttentance'),array('update'=>'#explorer_handler'),array('id'=>'explorer_change','class'=>'addbttn','style'=>'right:120px;')); ?>
  </li>
  </ul>
  </div>
  <?php if(Yii::app()->controller->id=='employeeLeaveTypes')
  { 
      echo CHtml::link('<span>'.Yii::t('app','Teacher Attendance').'</span>',array('/attendance/employeeAttendances'),array('class'=>'sb_but','style'=>'right:60px; width:180px; top:30px;'));
  }
  else
  {
	  echo CHtml::link('<span>'.Yii::t('app','Teacher Leave Types').'</span>',array('/attendance/employeeLeaveTypes'),array('class'=>'sb_but','style'=>'right:60px; width:180px; top:30px;'));
  }
  ?>

    
    
            
            <?php echo CHtml::link('<span>close</span>',array('/attendance'),array('class'=>'sb_but_close','style'=>'right:25px;top:30px;'));?>
            

		   