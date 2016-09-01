<style type="text/css">
.temp_div{ margin-top:15px;}
.temp_image{ top:-9px;}
</style>

<div class="temp_view">
<div class="temp_div">
	<div class="temp_image"></div>
    <h2><strong><?php 
	
	$name=NotificationSettings::model()->findByAttributes(array('id'=>$data->cat_id));
	echo CHtml::link(CHtml::encode(($name->settings_key)?Yii::t('app',$name->settings_key):Yii::t('app','No name')), array('view', 'id'=>$data->id)); ?></strong></h2>
    <div style=" margin: 2px 0 0 8px;
    position: absolute;
    right: 0;
    top: -4px;">			
        <?php echo CHtml::link('', array('update', 'id'=>$data->id),array('class'=>'temp_edit'));?>
        
    </div>
    <div style="margin-top:11px; text-align:justify ; color: #898989 !important;
    ">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><?php echo Yii::t('app', 'Subject');?></strong></td>
    <td width="20"><strong>:</strong></td>
    <td><?php echo $data->subject; ?></td>
  </tr>
  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong><?php echo Yii::t('app', 'Content');?></strong></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>
 
    <div ><?php echo $data->template; ?></div>
    

</div>
<div class="created_box">
<?php 
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
	$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));		
	date_default_timezone_set($timezone->timezone);
	$date = date($settings->displaydate,strtotime($data->created_at));	
	$time = date($settings->timeformat,strtotime($data->created_at));    
?>
<div class="created_box_r"><b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php 
		echo $date.' '.$time;
		//echo CHtml::encode($data->created_at);
	?></div>
</div>

<div class="clear"></div>

</div>
</div>