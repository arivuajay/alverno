<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fees')=>array('/fees'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','List FinanceFees'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Create FinanceFees'), 'url'=>array('create')),
	array('label'=>Yii::t('app','Update FinanceFees'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete FinanceFees'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('app','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('app','Manage FinanceFees'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','View FinanceFees');?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fee_collection_id',
		'transaction_id',
		'student_id',
		'is_paid',
	),
)); ?>
