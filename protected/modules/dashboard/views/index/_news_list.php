   
    <?php 
	if($index%2)
	$class='mail_blue';
	else
	$class='mail_orange';
	
	echo CHtml::link('<li class="'.$class.'"><h3>'.$data->subject.'</h3>
               '.$data->text.'
                <div class="mail_box_view"> </div>
                 </li>
                 <div class="clear"></div>', array('/mailbox/message/view','id'=>$data->conversation_id));?>
               
                 
    
  
   
   
   





