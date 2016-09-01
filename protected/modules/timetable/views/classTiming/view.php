<?php
$this->breadcrumbs=array(
	Yii::t('app','Class Timings')=>array('/timetable'),
	$model->name,
);

/**$this->menu=array(
	array('label'=>'List ', 'url'=>array('index')),
	array('label'=>'Create ', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'id'=>$model->)),
	array('label'=>'Delete ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ', 'url'=>array('admin')),
);*/
?>

<h1><?php echo Yii::t('app','View Class Timing');?></h1>


<div class="tableinnerlist" style="padding-right:25px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
    <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
    <td><?php
    $posts=Batches::model()->findByAttributes(array('id'=>$model->batch_id));
	echo $posts->name;
	?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Name');?></td>
    <td><?php
	echo $model->name;
	?></td>
  </tr>
   <tr>
    <td><?php echo Yii::t('app','Start Time');?></td>
    <td><?php
	echo $model->start_time;
	?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Start Time');?></td>
    <td><?php
	echo $model->end_time;
	?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Is Break');?></td>
    <td><?php
	if($model->is_break){echo 'Yes';}else{ echo 'No';}
	?></td>
  </tr>
   
   
  
</table>
</div>
