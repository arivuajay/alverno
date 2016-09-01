<?php
$this->breadcrumbs=array(
	Yii::t('app','Student')=>array('students/view','id'=>$student_id),
	$model->title,
	Yii::t('app','Update'),
);

/*$this->menu=array(
	array('label'=>'List StudentDocument', 'url'=>array('index')),
	array('label'=>'Create StudentDocument', 'url'=>array('create')),
	array('label'=>'View StudentDocument', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StudentDocument', 'url'=>array('admin')),
);*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/students/profileleft');?>
        </td>
        <td valign="top">
        	<div class="cont_right formWrapper">
            	 <h1 style="margin-top:.67em;">
					<?php 
					$student = Students::model()->findByAttributes(array('id'=>$student_id));
					echo Yii::t('app','Student Profile :');?> <?php echo ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name); ?><br />
                </h1>
				<div class="clear"></div>
                <div class="emp_right_contner">
					<div class="emp_tabwrapper">
						<?php $this->renderPartial('tab');?>
                        <div class="clear"></div>
                        
                        <div class="emp_cntntbx">
                        	<div class="edit_bttns last">
                                <ul>
                                    <li>
                                        <?php echo CHtml::link('<span>'.Yii::t('app','Document List').'</span>', array('students/document', 'id'=>$student_id),array('class'=>' edit ')); ?>
                                    </li>
                                </ul>
                        	</div> <!-- END div class="edit_bttns last" -->
                        	<?php echo $this->renderPartial('_formupdate', array('model'=>$model)); ?>
                        </div> <!-- END div class="emp_cntntbx" -->
					</div> <!-- END div class="emp_tabwrapper" -->			
                </div> <!-- END div class="emp_right_contner" -->
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
	</tr>
</table>



