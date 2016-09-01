<?php
$student_id=$id;

$model= new GuardianList;
$criteria= new CDbCriteria;
$criteria->condition= 'student_id=:id';
$criteria->params= array(':id'=>$student_id);
$dataprovider= new CActiveDataProvider('GuardianList',array('criteria'=>$criteria));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'guardians-grid',
	'dataProvider'=>$dataprovider,
	//'filter'=>$model,
	'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
	'columns'=>array(
	array('name'=>'guardian_id',
				'header' => Yii::t('app','Name'),
				'type'=>'raw',
				'value' => array($model,'parentname')
            ),
            array(
                'name'=>'relation',
                'header'=>Yii::t('app','Relation'),
                 // 'value'=>'-'
                ),
            array('header'=>Yii::t('app','Email'),
                    'value'=> array($model,'parentemail'),
                ),
            
		
		array(
			'header'=>Yii::t('app','Action'),
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>Yii::t('app','Are you sure you want to delete this guardian?'),
			'htmlOptions' => array('style'=>'width:80px;'),
			 'template' =>$template,
			 'headerHtmlOptions'=>array('style'=>'font-size:12px; font-weight:bold;'),
			 'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0),
			'template' => '{update}{delete}',
                        'buttons' => array(
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("students/guardians/guardiandelete",array("id"=>$data->id))',
                            
                        ),
                            'update' => array(
                            'url' => 'Yii::app()->createUrl("students/guardians/update",array("id"=>$data->guardian_id,"status"=>1,"s_id"=>$data->student_id))',
                            
                        ),
                           
                    ),
		),
	),
)); ?>