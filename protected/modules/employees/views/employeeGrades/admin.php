<?php
$this->breadcrumbs=array(
	Yii::t('app','Teacher Grades')=>array('admin'),
	Yii::t('app','Manage'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grades-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/employees/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Manage Teacher Grades');?></h1>
                <?php
				$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
				if(Yii::app()->user->year)
				{
					$year = Yii::app()->user->year;
				}
				else
				{
					$year = $current_academic_yr->config_value;
				}
				$is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
				$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
				$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
				
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
				{
				?>
                <div class="edit_bttns " style="top:20px; right:20px;">
                    <ul>
                    	<li><?php echo CHtml::link('<span>'.Yii::t('app','Add Grade').'</span>', array('create'),array('class'=>'addbttn last ')); ?></li>
                    </ul>
                </div>
                <?php
				}
				?>
                
                
                <?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
                <div class="search-form" style="display:none">
					<?php $this->renderPartial('_search',array(
                    'model'=>$model,
                    )); ?>
                </div><!-- search-form -->
                
                <?php 				
				if($year != $current_academic_yr->config_value and ($is_create->settings_value==0 or $is_edit->settings_value==0 or $is_delete->settings_value==0))
				{
				?>
					<div>
						<div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
							<div class="y_bx_head" style="width:650px;">
							<?php 
								echo Yii::t('app','You are not viewing the current active year. ');
								if($is_create->settings_value==0 and $is_edit->settings_value!=0 and $is_delete->settings_value!=0)
								{ 
									echo Yii::t('app','To add a new grade, enable Create option in Previous Academic Year Settings.');
								}
								elseif($is_create->settings_value!=0 and $is_edit->settings_value==0 and $is_delete->settings_value!=0)
								{
									echo Yii::t('app','To edit the grade, enable Edit option in Previous Academic Year Settings.');
								}
								elseif($is_create->settings_value!=0 and $is_edit->settings_value!=0 and $is_delete->settings_value==0)
								{
									echo Yii::t('app','To delete the grade, enable Delete option in Previous Academic Year Settings.');
								}
								else
								{
									echo Yii::t('app','To manage Teacher grades, enable the required options in Previous Academic Year Settings.');	
								}
							?>
							</div>
							<div class="y_bx_list" style="width:650px;">
								<h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
							</div>
						</div>
					</div><br />
				<?php
				}
				
				$template = '';
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
				{
					$template = $template.'{update}';
				}
				
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
				{
					$template = $template.'{delete}';
				}
				?>
                
                <?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'employee-grades-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
					'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
					'columns'=>array(
					
					'name',
					'max_hours_day',
					'max_hours_week',
					array(
						'class'=>'CButtonColumn',
						'header'=>Yii::t('app','Action'),
						'template' => $template,
						'headerHtmlOptions'=>array('style'=>'font-size:12px; font-weight:bold;'),
						'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
						),
					),
                )); ?>
            </div>
        </td>
    </tr>
</table>