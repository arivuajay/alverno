<?php
$this->breadcrumbs=array(
	'Apply Leaves'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ApplyLeaves', 'url'=>array('index')),
	array('label'=>'Create ApplyLeaves', 'url'=>array('create')),
	array('label'=>'View ApplyLeaves', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ApplyLeaves', 'url'=>array('admin')),
);
?>

<h1>Update ApplyLeaves <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>