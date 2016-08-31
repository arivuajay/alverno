<div id="othleft-sidebar">
	<?php
    $this->widget('zii.widgets.CMenu',array(
		'encodeLabel'=>false,
		'activateItems'=>true,
		'activeCssClass'=>'list_active',
		'items'=>array(
			array(
				'label'=>''.'<h1>'.Yii::t('app','Manage Fees').'</h1>'
			),
			array(
				'label'=>Yii::t('app','Dashboard').'<span>'.Yii::t('app','Fees dashboard').'</span>',
				'url'=>array('/fees/dashboard'),
				'linkOptions'=>array('class'=>'lbook_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='dashboard' or Yii::app()->controller->id=='view')))
			),
			array(
				'label'=>Yii::t('app','Create Fees').'<span>'.Yii::t('app','Create Fees').'</span>',
				'url'=>array('/fees/create'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='create' or Yii::app()->controller->id=='subscriptions')))
			),
			array(
				'label'=>Yii::t('app','Manage Invoices').' <span>'.Yii::t('app','Manage Generated Invoices').'</span>',
				'url'=>array('/fees/invoices'),
				'linkOptions'=>array('class'=>'mg_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and Yii::app()->controller->id=='invoices'))
			),
			array(
				'label'=>''.'<h1>'.Yii::t('app','Payment Types').'</h1>'
			),	
			array(
				'label'=>Yii::t('app','Create Payment Type').'<span>'.Yii::t('app','Create a Payment Type').'</span>',
				'url'=>array('/fees/paymentTypes/create'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='paymentTypes' and Yii::app()->controller->action->id=='create')))
			),
			array(
				'label'=>Yii::t('app','Manage Payment Types').'<span>'.Yii::t('app','Manage all Payment Types').'</span>',
				'url'=>array('/fees/paymentTypes/admin'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='paymentTypes' and (Yii::app()->controller->action->id=='admin' or Yii::app()->controller->action->id=='update'))))
			),
			array(
				'label'=>''.'<h1>'.Yii::t('app','Tax Settings').'</h1>'
			),	
			array(
				'label'=>Yii::t('app','Create Tax').'<span>'.Yii::t('app','Create a new Tax value').'</span>',
				'url'=>array('/fees/taxes/create'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='taxes' and Yii::app()->controller->action->id=='create')))
			),
			array(
				'label'=>Yii::t('app','Manage Tax').'<span>'.Yii::t('app','Manage all Tax values').'</span>',
				'url'=>array('/fees/taxes/admin'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='taxes' and (Yii::app()->controller->action->id=='admin' or Yii::app()->controller->action->id=='update'))))
			),
			array(
				'label'=>''.'<h1>'.Yii::t('app','Payment Gateway').'</h1>'
			),
			array(
				'label'=>Yii::t('app','Settings').'<span>'.Yii::t('app','Gateway settings').'</span>',
				'url'=>array('/fees/gateways/settings'),
				'linkOptions'=>array('class'=>'cf_ico'),
				'active'=> ((isset(Yii::app()->controller->module->id) and Yii::app()->controller->module->id=="fees" and (Yii::app()->controller->id=='gateways' and Yii::app()->controller->action->id=='settings')))
			),
		),
    ));
    ?>
</div>