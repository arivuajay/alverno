<?php
$this->breadcrumbs=array(
	'Apply Leaves',
);

$this->menu=array(
	array('label'=>'Create ApplyLeaves', 'url'=>array('create')),
	array('label'=>'Manage ApplyLeaves', 'url'=>array('admin')),
);
?>

<h1>Apply Leaves</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
