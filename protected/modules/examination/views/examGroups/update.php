<?php
$this->breadcrumbs=array(
	Yii::t('app','Exam Groups')=> array('/examination'),
	Yii::t('app',$model->id) => array('view','id'=>$model->id),
	Yii::t('app','Update'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
<?php $this->renderPartial('//assesments/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">

<h1><?php echo Yii::t('app','Update ExamGroups');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
    </td>
  </tr>
</table>