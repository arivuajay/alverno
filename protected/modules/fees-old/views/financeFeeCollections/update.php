<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fee Collections')=>array('/fees'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','List FinanceFeeCollections'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Create FinanceFeeCollections'), 'url'=>array('create')),
	array('label'=>Yii::t('app','View FinanceFeeCollections'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Manage FinanceFeeCollections'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Update FinanceFeeCollections'); ?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>