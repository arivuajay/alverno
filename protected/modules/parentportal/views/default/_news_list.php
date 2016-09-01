<div class="widget-messaging ">
<ul>
             
            
    <?php 
	if($index%2)
	$class='mail_blue';
	else
	$class='mail_orange';
	
	$settings = UserSettings::model()->findByAttributes(array('user_id'=>1));
	if($settings!=NULL){ 
		$date1 = date($settings->displaydate.' H:i a',$data->modified);
	}else{
		$date1 = date("Y-m-d H:i a",$data->modified);
	}
	
	echo '<li><small class="pull-right">'.$date1.'</small>'.CHtml::link('<h4  class="sender">'.$data->subject.'</h4>', array('/portalmailbox/message/view','id'=>$data->conversation_id)).'<small>
               '.$data->text.'
                </small></li>';?>
</ul>  
</div>
               
                 
    
  
   
   
   





