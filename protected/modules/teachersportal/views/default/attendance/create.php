<?php
$this->breadcrumbs=array(
	'Student Attentances'=>array('/courses'),
	'Create',
);

?>
 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog'.$day.$emp_id,
                'options'=>array(
                    'title'=>Yii::t('',''),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
					'title'=>Yii::t('app', 'Mark Attentance')
                ),
                ));
				?>
<div style="padding:10px">
<?php /*?><h1><?php echo Yii::t('Attendance','Mark Attentance'); ?></h1><?php */?>

<?php

echo $this->renderPartial('attendance/_form', array('model'=>$model,'model1'=>$model1,'day' =>$day,'month'=>$month,'year'=>$year,'emp_id'=>$emp_id,'batch_id'=>$batch_id,'timetable' => $timetable)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
</div>