<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fees')=>array('/fees'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','List FinanceFees'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Create FinanceFees'), 'url'=>array('create')),
	array('label'=>Yii::t('app','View FinanceFees'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Manage FinanceFees'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Update FinanceFees');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>