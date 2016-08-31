<?php
$this->breadcrumbs=array(
	Yii::t('app','Borrow Books')=>array('/library'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app','Update'),
);

$this->menu=array(
	array('label'=>'List BorrowBook', 'url'=>array('index')),
	array('label'=>'Create BorrowBook', 'url'=>array('create')),
	array('label'=>'View BorrowBook', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BorrowBook', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Update BorrowBook');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>