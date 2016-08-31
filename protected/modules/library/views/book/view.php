<?php
$this->breadcrumbs=array(
	Yii::t('app','Books')=>array('/library'),
	Yii::t('app','View'),
);


?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vacate-form',
	'enableAjaxValidation'=>false,
)); ?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
   <?php $this->renderPartial('/settings/library_left');?>
 </td>
    <td valign="top">  
    <div style="padding-left:10px">
    <h1><?php echo Yii::t('app','View Book');?></h1>

<?php
$bookdetails=Book::model()->findByAttributes(array('id'=>$model->id));
$author=Author::model()->findByAttributes(array('auth_id'=>$bookdetails->author));
$publication=Publication::model()->findByAttributes(array('publication_id'=>$bookdetails->publisher));
?>
 <div class="pdtab_Con">
 <table width="100%" cellpadding="0" cellspacing="0" border="0" >
						<tr class="pdtab-h">
						<td align="center"><?php echo Yii::t('app','Book Name');?></td>
                        <td align="center"><?php echo Yii::t('app','ISBN');?></td>
                        <td align="center"><?php echo Yii::t('app','Author');?></td>
                        <td align="center"><?php echo Yii::t('app','Edition');?></td>
                        <td align="center"><?php echo Yii::t('app','Publisher');?></td>
                        <td align="center"><?php echo Yii::t('app','Copies Available');?></td>
                        </tr>
                        <tr>
                          <td align="center"><?php echo $bookdetails->title;?></td>
                   		<td align="center"><?php echo $bookdetails->isbn;?></td>
                    <td align="center"><?php echo $author->author_name;?></td>
                    <td align="center"><?php echo $bookdetails->edition;?></td>
                    <td align="center"><?php echo $publication->name;?></td>
                    <td align="center"><?php echo $bookdetails->copy;?></td>
                        </tr>
                   </table>     

</div>
</div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>