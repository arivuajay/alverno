




<?php $user_com=Profile::model()->findByAttributes(array('user_id'=>$comment->created_by));

	$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));?>



<div class="log_comment_box" id="delete_div_<?php echo $comment->id;?>">
	 <h4 class=" pull-right label label-success"><?php echo $comment->category->name;?></h4>
       <h3><?php echo $user_com->fullname; ?><span>
                                <?php   $roles=Yii::app()->authManager->getRoles($comment->created_by);
										foreach ($roles as $role)
										{
											echo $role->name;
										}
										?></span></h3>
       
       <div class="clear"></div>
       <p><?php echo $comment->comment;?></p>
       
       <smal class="text-muted"><?php echo date($settings->displaydate,strtotime($comment->date)).' '.date($settings->timeformat,strtotime($comment->date));?></smal>
        <div class="pull-right">
       <?php 
	   if($comment->category->editable){
        								echo  CHtml::ajaxSubmitButton('Delete',CHtml::normalizeUrl(array("logcomment/deletecomment","id"=>$comment->id, "style"=>'margin-left:10px;')),
                                		array(
										'beforeSend'=>'function(){
                                       		
                                    		}',
                                   			 'success'=>'function(result){
													$( "#delete_div_'.$comment->id.'").remove();
											}'
									
                                ),array('confirm'=>"Delete Your Post!",'id'=>'deletecomment_'.$comment->id,"name"=>'yt_'.$comment->id,'class'=>'btn btn-danger')); 
								?>
                                
                                 
                                 
                                 
                                 <?php 
        							echo  CHtml::ajaxSubmitButton('Edit',
                                			CHtml::normalizeUrl(array("logcomment/editcomment","id"=>$comment->id)),
                                	array(
											'beforeSend'=>'function(){
											     
											}',
											'success'=>'function(result){
												$( "#delete_div_'.$comment->id.'").html(result);
											}'
									
                                	),array('confirm'=>"Edit Your Post!",'id'=>'editcomment_'.$comment->id.'_'.time(),"name"=>'yt_'.$comment->id.'_'.time(),'class'=>'btn btn-warning')); 
	   }
	   ?>
        </li>
                                </ul>
                                    </div>
       </div>













			
		
    
        
        