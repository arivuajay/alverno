<?php
$this->breadcrumbs=array(
	Yii::t('app','Apply Leaves')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','List ApplyLeaves'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Create ApplyLeaves'), 'url'=>array('create')),
	array('label'=>Yii::t('app','View ApplyLeaves'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Manage ApplyLeaves'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Update ApplyLeaves'); ?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>