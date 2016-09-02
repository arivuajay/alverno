<?php
$this->breadcrumbs=array(
	'Student Attentances'=>array('/courses'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List StudentAttentance', 'url'=>array('index')),
//	array('label'=>'Create StudentAttentance', 'url'=>array('create')),
//	array('label'=>'View StudentAttentance', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage StudentAttentance', 'url'=>array('admin')),
//);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog'.$day.$emp_id,
                'options'=>array(
                    'title'=>Yii::t('app','Edit Leave'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
				?>



<?php echo $this->renderPartial('attendance/_form1', array('model'=>$model,'model1'=>$model1,'day' =>$day,'month'=>$month,'year'=>$year,'emp_id'=>$emp_id,'batch_id'=>$batch_id,'timetable' => $timetable));?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>