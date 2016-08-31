<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fee Collections')=>array('/fees'),
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

<h1><?php echo Yii::t('app','View Finance Fee Collection');?> </h1>
<?php /*?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'start_date',
		'end_date',
		'due_date',
		'fee_category_id',
		'batch_id',
		'is_deleted',
	),
)); ?><?php */?>
<div class="tableinnerlist" style="padding-right:25px; width:350px;">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php echo Yii::t('app','Name');?></td>
    <td><?php echo $model->name; ?></td>
  </tr>
    <tr>
    <td><?php echo Yii::t('app','start Date');?></td>
    <td><?php
		$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->start_date));
									
		
								}
	echo $date1;
	?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','End Date');?></td>
    <td><?php
			if($settings!=NULL)
								{	
									$date2=date($settings->displaydate,strtotime($model->end_date));
									
		
								} 
			echo $date2; ?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Due Date');?></td>
    <td><?php
			if($settings!=NULL)
								{	
									$date2=date($settings->displaydate,strtotime($model->due_date));
									
		
								} 
			echo $date2; ?></td>
  </tr>
      <tr>
    <td><?php echo  Yii::t('app','Fee Category');?></td>
    <td><?php 
	$ss = FinanceFeeCategories::model()->findByAttributes(array('id'=>$model->fee_category_id));
	echo $ss->name; ?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Batch Name');?></td>
    <td><?php
    $posts=Batches::model()->findByAttributes(array('id'=>$model->batch_id));
	echo $posts->name;
	?></td>
  </tr>
</table>
</div>

