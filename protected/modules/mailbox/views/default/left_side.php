<style>
#othleft-sidebar ul li{
	position:relative;
}
.count{
	position:absolute;
	top:13px;
	right:19px;
	min-width:40px;
	padding:5px 0px !important;
	background-color:#405875;
	color:#FFF !important;
	text-align:center;
	font-size:12px;
	-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
}
</style>
<?php
if(Yii::app()->controller->id=='activityFeed' or Yii::app()->controller->id=='complaints')
{
$mailcount = '('.Mailbox::model()->newMsgs(Yii::app()->user->id).')'; 
}
else
{
$mailcount = '('.Yii::app()->getModule("mailbox")->getNewMsgs(Yii::app()->user->id).')'; 
}
		$criteria = new CDbCriteria;		
		$criteria->join = 'LEFT JOIN users t1 ON t.uid = t1.id';
		$criteria->condition = 't1.status=:status';
		$criteria->params = array(':status'=>1);	
		$unread_msg = Complaints::model()->findAll($criteria);
		
$model = Configurations::model()->findByAttributes(array('id'=>39));?>

	<div id="othleft-sidebar">
        <h1><?php echo Yii::t('app','My Account'); ?></h1>  
        <?php
		
        $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'activateItems'=>true,
        'activeCssClass'=>'list_active',
        'items'=>array(
			
			
			
			// The MailBox Link
			array('label'=>Yii::t('app','Activity Feed').'<span>'.Yii::t('app','Track Activities').'</span>', 'url'=>array('/activityFeed'),
			'active'=> ((Yii::app()->controller->id=='activityFeed') ? true : false),'linkOptions'=>array('class'=>'ddbook_ico')),
			
			
			array('label'=>Yii::t('app','Mailbox').$mailcount.'<span>'.Yii::t('app','All Received Messages').'</span>', 'url'=>array('/mailbox'),
		'active'=> ((Yii::app()->controller->module->id=='mailbox' and  Yii::app()->controller->id!='news') ? true : false),'linkOptions'=>array('class'=>'inbox_ico')),
			
			
			
			array('label'=>Yii::t('app','News').'<span>'.Yii::t('app','All Site News').'</span>', 'url'=>array('/mailbox/news'),
			'active'=> ((Yii::app()->controller->id=='news') ? true : false),'linkOptions'=>array('class'=>'news_ico')),
			
			
			
			//The Events Link
			//'label'=>''.t('Events'), 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'menu_2'),
			array('label'=>''.'<h1>'.Yii::t('app','Events').'</h1>',
			'active'=> ((Yii::app()->controller->module->id=='cal') ? true : false)),
			
			array('label'=>Yii::t('app','Events List').'<span>'.Yii::t('app','All Events').'</span>', 'url'=>array('/dashboard/default/events'),
			'active'=> ((Yii::app()->controller->module->id=='dashboard') ? true : false),'linkOptions'=>array('class'=>'evntlist_ico')),
			
			array('label'=>Yii::t('app','Calendar').'<span>'.Yii::t('app','Schedule Events').'</span>', 'url'=>array('/cal'),
			'active'=> (((Yii::app()->controller->module->id=='cal') and (Yii::app()->controller->id != 'eventsType')) ? true : false),'linkOptions'=>array('class'=>'cal_ico')),
			
			array('label'=>Yii::t('app','Event Types').'<span>'.Yii::t('app','Manage Event Types').'</span>', 'url'=>array('/cal/eventsType'),
			'active'=> ((Yii::app()->controller->id=='eventsType') ? true : false),'linkOptions'=>array('class'=>'evnttype_ico')),
),
        )); 
	if($model->config_value == 1)
		{
		
		$this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'activateItems'=>true,
        'activeCssClass'=>'list_active',
        'items'=>array(
			
        		
			  array('label'=>''.'<h1>'.Yii::t('app','Complaints').'</h1>'), 
			 
			
				 array('label'=>''.Yii::t('app','Category').'<span>'.Yii::t('app','Manage Category').'</span>', 'url'=>array('/complaints/categories') ,'linkOptions'=>array('class'=>'lbook_ico'),'visible'=>Yii::app()->user->checkAccess('Admin'),
									   'active'=> (Yii::app()->controller->id == 'complaints' and Yii::app()->controller->action->id == 'categories') ? true : false
							),        
							array('label'=>''.Yii::t('app','Complaint List').'<span class="count">'.count($unread_msg).'</span><span>'.Yii::t('app','Complaint List').'</span>', 'url'=>array('/complaints/index') ,'linkOptions'=>array('class'=>'mg_ico'),'visible'=>Yii::app()->user->checkAccess('Admin'),
									   'active'=> (Yii::app()->controller->id == 'complaints' and Yii::app()->controller->action->id == 'index' or Yii::app()->controller->action->id == 'read' or Yii::app()->controller->action->id == 'feedbacklist') ? true : false
							),

						array('label'=>''.Yii::t('app','Complaint List').'<span>'.Yii::t('app','Complaint List').'</span>', 'url'=>array('/complaints/feedbacklist') ,'linkOptions'=>array('class'=>'mg_ico'),'visible'=>!Yii::app()->user->checkAccess('Admin'),
                                   'active'=> (Yii::app()->controller->id == 'complaints' and Yii::app()->controller->action->id == 'feedbacklist' or   Yii::app()->controller->action->id == 'feedback') ? true : false
					    ),
						array('label'=>''.Yii::t('app','Register Complaint').'<span>'.Yii::t('app','Register Complaint').'</span>', 'url'=>array('/complaints/create') ,'linkOptions'=>array('class'=>'ne_ico'),'visible'=>!Yii::app()->user->checkAccess('Admin'),
                                   'active'=> (Yii::app()->controller->id == 'complaints' and Yii::app()->controller->action->id == 'create') ? true : false
					    ),			  		
			
	),
        )); 
	}
  ?>      
	</div>
	<script type="text/javascript">
$(document).ready(function () {
	//Hide the second level menu
	$('#othleft-sidebar ul li ul').hide();            
	//Show the second level menu if an item inside it active
	$('li.list_active').parent("ul").show();
	
	$('#othleft-sidebar').children('ul').children('li').children('a').click(function () {                    
	
	if($(this).parent().children('ul').length>0){                  
		$(this).parent().children('ul').toggle();    
	}
	});	
});
</script>