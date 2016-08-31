<?php
$this->breadcrumbs=array(
	   Yii::t('app','Settings')=>array('/configurations'),
		Yii::t('app','Backup'),
);
$trans1	= Yii::t('app','View Site');
$trans2 = Yii::t('app','Restore Successfull');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side'); ?>
        </td>
        <td valign="top">
             <div class="cont_right formWrapper">
            <h1> <?php echo Yii::t('app','Manage Database Backups'); ?></h1>
            <div class="edit_bttns" >
                    <ul>
                    	<li> <?php echo CHtml::link('<span>'.Yii::t('app','Create Backup').'</span>', array('default/create'),array('class'=>'addbttn last ')); ?></li>
                    </ul>
                </div> <!-- END div class="edit_bttns" -->
            <?php $this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
               
));
?>
             </div>

        </td>
    </tr>
</table>
