<?php
$this->breadcrumbs=array(
	Yii::t('app','Students Documents')=>array('index'),
	Yii::t('app','Create'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    	<?php $this->renderPartial('/default/left_side');?>
    </td>
    <td valign="top">
    	<div class="cont_right formWrapper">
            <h1><?php echo Yii::t('app','Student Documents');?></h1>
            <div class="captionWrapper">
                <ul>
                    <li><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Details'),array('students/update','id'=>$_REQUEST['id'],'status'=>0)); } else{ echo Yii::t('app','Student Details'); } ?></h2></li>
                    <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Parent Details'),array('guardians/create','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Parent Details'); } ?> </h2></li>
                    <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Emergency Contact'),array('guardians/addguardian','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Emergency Contact'); } ?></h2></li>
                    <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Previous Details'),array('studentPreviousDatas/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Previous Details'); }?></h2></li>
                    <li><h2 class="cur"><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Documents'),array('studentDocument/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Student Documents'); }?></h2></li>
                    <li class="last"><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Profile'),array('students/view','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Student Profile'); } ?></h2></li>
                </ul>
            </div>
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </td>
  </tr>
</table>