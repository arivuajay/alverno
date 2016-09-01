


<?php echo CHtml::beginForm(); ?>
	<?php $this->renderPartial('test1',array('model'=>$model)); ?>
    <?php echo CHtml::submitButton('Login'); ?>
<?php echo CHtml::endForm(); ?>