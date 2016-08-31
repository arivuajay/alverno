<?php
$this->breadcrumbs=array(
	Yii::t('app','File Categories')=>array('admin'),
	Yii::t('app','Update'),
);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" valign="top" id="port-left">
     <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="inner_new_head">
    <?php echo Yii::t('app','Update File Category'); ?>
    </div>
    
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </td>
  </tr>
</table>


