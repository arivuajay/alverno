<?php
$this->breadcrumbs=array(
	Yii::t('app','Finance Fee Particulars')=>array('/fees'),
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

<h1><?php echo Yii::t('app','View Finance Fee Particular');?></h1>

<?php /*?><?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id','student_category_id','student_id','is_deleted',	
		'name',
		'description',
		'amount',
		array('name'=>'category_name','label'=>'Finance Fee Category',),
		array('name'=>'student_category','label'=>'Student Category',),				
		'admission_no',
		array('name'=>'student_name','label'=>'Student Name',),	
		array('name'=>'create_at','label'=>'Created At',),		
		array('name'=>'update_at','label'=>'Updated At',),	
	),
)); ?><?php */?>
<div class="tableinnerlist" style="padding-right:25px; width:350px;">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php echo Yii::t('app','Name');?></td>
    <td><?php echo $model->name; ?></td>
  </tr>
    <tr>
    <td><?php echo Yii::t('app','Description');?></td>
    <td><?php echo $model->description;?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Amount');?></td>
    <td><?php echo $model->amount; ?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Finance Fee Category');?></td>
    <td><?php echo $model->category_name; ?></td>
  </tr>
      <tr>
    <td><?php echo  Yii::t('app','Student Category');?></td>
    <td><?php echo $model->student_category; ?></td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Admission No');?></td>
    <td><?php echo $model->admission_no;
	?></td>
  </tr>
   <tr>
    <td><?php echo Yii::t('app','Student Name');?></td>
    <td><?php echo $model->student_name;
	?></td>
  </tr>
</table>
</div>