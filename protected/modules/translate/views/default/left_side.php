<div id="othleft-sidebar">
	<h1><?php echo Yii::t('app','General Settings'); ?></h1>
	<?php
		$this->widget(
			'zii.widgets.CMenu',
			array(
				'encodeLabel'=>false,
				'activateItems'=>true,
				'activeCssClass'=>'list_active',
				'items'=>array(			
					array(
						'label'=>Yii::t('app','Translate').'<span>'.Yii::t('app','Generate Translations').'</span>',
						'url'=>array('/translate/generate/index'),
						'linkOptions'=>array(
							'class'=>'sm_ico',
							'active'=> (Yii::app()->controller->id=='generate') ? true : false
						)
					),                            
					array(
						'label'=>''.Yii::t('app','Manage Translation').'<span>'.Yii::t('app','Manage Translation').'</span>',
						'url'=>array('/translate/edit'),
						'linkOptions'=>array(
							'class'=>'gs_ico'
						),
						'itemOptions'=>array(
							'id'=>'menu_1'
						),
						'active'=> (Yii::app()->controller->id=='edit' and Yii::app()->controller->action->id=='admin') ? true : false, 
					),
					/*array(
						'label'=>Yii::t('app','One By One Translation').'<span>'.Yii::t('app','One By One Translation').'</span>',
						'url'=>array('/translate/edit/missing'),
						'linkOptions'=>array(
							'class'=>'sm_ico'
						)
					),*/
				),
			)
		);
	?>
</div>