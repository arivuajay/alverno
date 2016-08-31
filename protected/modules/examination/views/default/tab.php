<?php 
$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['id']));
if($batch!=NULL)
{
?>

    <div class="formCon">
        <div class="formConInner">
            <?php echo Yii::t('app','Course').' : ';?>
            <?php 
			$course = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
            if($course!=NULL)
            {
            	echo $course->course_name; 
            }
			?>
            &nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' : '; ?><?php echo $batch->name; ?>
            <?php
			if(Yii::app()->controller->id=='exams')
			{
				$exam_group = ExamGroups::model()->findByAttributes(array('id'=>$_REQUEST['exam_group_id']));
			?>				
				<br /><br /><?php echo Yii::t('app','Examination').' : '; ?><?php echo ucfirst($exam_group->name); 
				if(Yii::app()->controller->action->id=='update')
				{
					$exam = Exams::model()->findByAttributes(array('id'=>$_REQUEST['sid']));
					$subject = Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
				?>
                	&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::t('app','Subject').' : '; ?><?php echo $subject->name;
                
				}
			}
			?>
            
            <?php
			if((Yii::app()->controller->id=='gradingLevels' and Yii::app()->controller->action->id=='index') or (Yii::app()->controller->id=='exam' and Yii::app()->controller->action->id=='index'))
            {
				$rurl = explode('index.php?r=',Yii::app()->request->getUrl());
				$rurl = explode('&id=',$rurl[1]);
				echo CHtml::ajaxLink(Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('/site/explorer','widget'=>'2','rurl'=>$rurl[0]),array('update'=>'#explorer_handler'),array('id'=>'explorer_change','class'=>'sb_but','style'=>'right:80px;')); 
            }
			else
            {
            	echo CHtml::ajaxLink(Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('/site/explorer','widget'=>'2','rurl'=>'examination/exam'),array('update'=>'#explorer_handler'),array('id'=>'explorer_change','class'=>'sb_but','style'=>'right:80px;'));
            }
			echo CHtml::link('<span>'.Yii::t('app','close').'</span>',array('/examination'),array('class'=>'sb_but_close','style'=>'right:40px;'));
            ?>
            <br>
        </div>
    </div> 

<?php 
}
?>