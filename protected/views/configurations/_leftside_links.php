<div id="othleft-sidebar">
    <h1><?php echo Yii::t('app','General Settings'); ?></h1>
    <?php
        $this->widget('zii.widgets.CMenu',array(
            'encodeLabel'=>false,
            'activateItems'=>true,
            'activeCssClass'=>'list_active',
            'items'=>array(
				array(
					'label'=>''.Yii::t('app','Manage Academic Years').'<span>'.Yii::t('app','Manage All Academic Years').'</span>',
					'url'=>array('/academicYears/admin'),
					'active'=> ((Yii::app()->controller->id=='academicYears') && (in_array(Yii::app()->controller->action->id,array('create','index','admin'))? true : false)),				
					'linkOptions'=>array('class'=>'gs_ico' ), 
					'itemOptions'=>array('id'=>'menu_1'),
				),
				array(
					'label'=>'<h1>'.Yii::t('app','User Settings').'</h1>'
				),
				array(
					'label'=>Yii::t('app','Create New User').'<span>'.Yii::t('app','Add New User Details').'</span>',
					'url'=>array('/user/admin/create'),
					'visible'=>Yii::app()->user->checkAccess("Admin"),
					'active'=> ((Yii::app()->controller->id=='admin' and Yii::app()->controller->action->id=='create') ? true : false),
					'linkOptions'=>array('class'=>'sl_ico' )
				),
				array(
					'label'=>Yii::t('app','Manage Users').'<span>'.Yii::t('app','Manage All Users').'</span>',
					'url'=>array('/user/admin'),
					'visible'=>Yii::app()->user->checkAccess("Admin"),
					
					'active'=> ((Yii::app()->controller->id=='admin' and Yii::app()->controller->action->id!='create') ? true : false),
					'linkOptions'=>array('class'=>'sm_ico' )
				),
				array(
					'label'=>Yii::t('app','Change Password').'<span>'.Yii::t('app','Manage All Users').'</span>',
					'url'=>array('/user/profile/changepassword'),
					'linkOptions'=>array('class'=>'cp_ico' )
				),
				array(
					'label'=>'<h1>'.Yii::t('app','Courses and Batches').'</h1>'
				),
				array(
					'label'=>Yii::t('app','List Courses and Batches').'<span>'.Yii::t('app','All Courses and Batches Details').'</span>',
					'url'=>array('/courses/courses/managecourse'),
					'linkOptions'=>array('class'=>'lbook_ico' )
				),
				array(
					'label'=>Yii::t('app','Create Courses').'<span>'.Yii::t('app','Add New Course Details').'</span>',
					'url'=>array('/courses/courses/create'),
					'active'=> ((Yii::app()->controller->id=='courses') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false),
					'linkOptions'=>array('class'=>'ne_ico' )
				),
            ),
        ));
    ?>
</div>