<?php
$this->breadcrumbs=array(
	Yii::t('app','File Categories')=>array('admin'),
	Yii::t('app','View'),
);

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" valign="top" id="port-left">
     <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="inner_new_head">
        <?php echo Yii::t('app','View File Category'); ?>
    </div>
    <div class="inner_new_table">         
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <th> <?php echo Yii::t('app','ID'); ?></th>
        <th> <?php echo Yii::t('app','Category'); ?></th>
        <th> <?php echo Yii::t('app','Created At'); ?></th>
        
        </tr>
        <tr>
        <td><?php echo $model->id; ?></td>
        <td><?php echo $model->category; ?></td>
        <?php
        $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
									
		if($settings!=NULL)
		{	
			$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
			/*$time = new DateTime("@".strtotime($feed->activity_time));
			$time->setTimezone(new DateTimeZone($timezone->timezone));   */
			date_default_timezone_set($timezone->timezone);
			$date = date($settings->displaydate,strtotime($model->created_at));	
			$time = date($settings->timeformat,strtotime($model->created_at));						
		}
		?>									
        <td>
			<?php 
			if($date and $time)
			{
				echo $date.' at '.$time; 
			}
			else
			{
				echo $model->created_at;
			}
			?>
		</td>
        
        </tr>
        </table>
        
    </div>
    </td>
  </tr>
</table>