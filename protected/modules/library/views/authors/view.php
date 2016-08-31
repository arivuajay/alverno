<?php
$this->breadcrumbs=array(
	Yii::t('app','Authors')=>array('/library/index'),
	$model->auth_id,
);

/**$this->menu=array(
	array('label'=>'List ', 'url'=>array('index')),
	array('label'=>'Create ', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'id'=>$model->)),
	array('label'=>'Delete ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ', 'url'=>array('admin')),
);*/
?>
<div style="width:300px;">&nbsp;</div>
<h1><?php echo $model->author_name;?><?php echo Yii::t('app','s Books');?></h1>

<?php
$book=Book::model()->findAll('author=:x and is_deleted=:y',array(':x'=>$model->auth_id,':y'=>0));
if($book!=NULL)
{
	?>
    <div class="pdtab_Con">
    <table width="90%" cellpadding="0" cellspacing="0" border="0" >
<tr class="pdtab-h" width="30%">

<td align="center"><?php echo Yii::t('app','Subject');?></td>
<td align="center"><?php echo Yii::t('app','Book Title');?></td>
<td align="center"><?php echo Yii::t('app','ISBN');?></td>
<td align="center"><?php echo Yii::t('app','Publication');?></td>
</tr>
    <?php
	foreach($book as $book_1)
	{
		$author=Author::model()->findByAttributes(array('auth_id'=>$model->auth_id));		
		$publication=Publication::model()->findByAttributes(array('publication_id'=>$book_1->publisher));
		?>
        <tr>

<td align="center"><?php echo $book_1->subject;?></td>
<td align="center"><?php echo $book_1->title;?></td>
<td align="center"><?php echo $book_1->isbn;?></td>
<td align="center"><?php echo $publication->name;?></td>

</tr>
<?php } ?>
</table>
</div>
</div>
</td>
</tr>
</table>
        <?php
	
}
else
{
	echo Yii::t('app','No Books');
}

?>
