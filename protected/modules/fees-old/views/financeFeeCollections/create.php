<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fee Collections')=>array('/fees'),
	Yii::t('app','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','List FinanceFeeCollections'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Manage FinanceFeeCollections'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Create FinanceFeeCollections');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>