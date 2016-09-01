

<div id="othleft-sidebar">
  <h1><?php echo Yii::t('app','Manage User Roles');?></h1>
                    
        <?php 
			
			
			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					
                     array('label'=>''.Yii::t('app','Manage User Roles').'<span>'.Yii::t('app','Delete existing user roles').'</span>',  'url'=>array('/rights/authItem/manageroles'),'active'=> ((Yii::app()->controller->id=='authItem') && (in_array(Yii::app()->controller->action->id,array('manageroles','editrole'))? true : false)),'linkOptions'=>array('class'=>'gs_ico' ), 'itemOptions'=>array('id'=>'menu_1'),
					 ),
					                                      
					array('label'=>''.Yii::t('app','Create User Role').'<span>'.Yii::t('app','Create a new user role').'</span>',  'url'=>array('/rights/authItem/assignrole'),'active'=> ((Yii::app()->controller->id=='authItem') && (in_array(Yii::app()->controller->action->id,array('assignrole'))? true : false)),'linkOptions'=>array('class'=>'gs_ico' ), 'itemOptions'=>array('id'=>'menu_1'),
					),
					
					/*array('label'=>''.Yii::t('app','Manage Accesses').'<span>'.Yii::t('app','Revoke access of users').'</span>',  'url'=>array('/rights/authItem/access'),'active'=> ((Yii::app()->controller->id=='authItem') && (in_array(Yii::app()->controller->action->id,array('access'))? true : false)),'linkOptions'=>array('class'=>'gs_ico' ), 'itemOptions'=>array('id'=>'menu_1'),
					),*/
			),
			)); ?>

</div>