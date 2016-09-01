<style type="text/css">
.items input[type="text"]{ width:130px !important;}
</style>
<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

function getVisible($data){  //check for visibilty of update/delete buttons for 4 default users
	$subdomain = explode('.tryopenschool.com' , $_SERVER['SERVER_NAME']);
	if($subdomain[0])
	{
		if($subdomain[0]!='tryopenschool.com' and $subdomain[0]!='www')
		{
			return 'true';
			
		}
		else
		{
			
			return '($data->username != admin && $data->username != news && $data->username != student && $data->username != parent && $data->username != teacher)';
		}
	}
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<script>
jQuery(document).ready(function () {
    //hide a div after 3 seconds
    setTimeout( "jQuery('.del_msg').hide();",3000 );
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
<div id="othleft-sidebar">
<?php $this->renderPartial('//configurations/left_side');?>
  </div>
 </td>
 <td valign="top">
<div class="cont_right formWrapper">
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

    <div class="edit_bttns" style="top:15px; right:20px">
    <ul>
    <li><?php echo '<span>'.CHtml::link('<span>'.Yii::t('user','Create User').'</span>',array('/user/admin/create'),array('class'=>'addbttn last')).'</span>';?></li>
    </ul>
    <div class="clear"></div>
    </div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
	'columns'=>array(
		/*array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),*/
		array(
		'header'=>Yii::t('app','Name'),
			'name' => 'username',
			'type'=>'raw',
			'value' => array($model,'name'),
		),
		array(
			'header'=>Yii::t('app','Role'),
			'type'=>'raw',
			'value' => array($model,'role'),
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		array(
            'name'=>'lastvisit_at',
            'value'=>array($model,'lastvisit'),
        ),
		//'lastvisit_at',
		/*array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{view}{delete}',
                    'buttons'=>array(
						'update'=>array(
								'visible'=>getVisible($data),
						),
						'view'=>array(
								'visible'=>'true',
						),
						'delete'=>array(
								'visible'=>getVisible($data),
						),
					)
		),
		
	),
)); ?>
</div>
 </td>
  </tr>
</table>