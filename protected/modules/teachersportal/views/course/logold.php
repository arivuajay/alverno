<script>
//var x = location.search;
function getval()
{var x=$("#flag_id").is(":checked");
if(x==true)
{
	$('#expire_date').show();
}
else
{
	$('#expire_date').hide();
}
  

}

</script>


<div id="parent_Sect">
	<?php $this->renderPartial('/default/leftside');?> 
   
     <div class="pageheader">
      <h2><i class="fa fa-envelope-o"></i> <?php echo Yii::t('app', 'My Course');?> <span><?php echo Yii::t('app', 'View courses here');?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t('app', 'You are here:');?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
         <li class="active"><?php echo Yii::t('app', 'Course');?></li>
        </ol>
      </div>
    </div>
    
   <div class="contentpanel">
<div class="col-sm-9 col-lg-12">

           <?php $this->renderPartial('changebatch');?>
<div class="panel-body panel panel-default">
    <div id="parent_rightSect">
        <div class="parentright_innercon">
        	<?php $this->renderPartial('batch');?>
            <div class="edit_bttns" style="top:100px; right:25px">
                <ul>
                    <li>
                    <?php //echo CHtml::link('<span>'.Yii::t('studentportal','My Courses').'</span>', array('/studentportal/course'),array('class'=>'addbttn last'));?>
                    </li>
                </ul>
            </div>
            
            <div class="list_contner" >
                    
                    <h3 ><?php echo Yii::t('app','Student Profile :');?> <?php echo ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name); ?></h3><br />
                
                 <!-- END div class="edit_bttns last" -->
                
                <div class="clear"></div>
                <div class="emp_right_contner">
                    <div class="emp_tabwrapper">
						
                        
                        <div class="emp_cntntbx">
                        	<div class="formCon">
                            	<div class="formConInner">
                               
                                <?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'log-form',
									'enableAjaxValidation'=>true,
									'enableClientValidation'=>true,
								)); ?>
                                
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                        <td width="83%"><?php 
										if(isset($_REQUEST['cid']) and ($_REQUEST['cid']!=NULL))
										{
											
											$sel = $_REQUEST['cid'];
										}
										else
										{
											$sel ='';
										}
										$data_1 = CHtml::listData(LogCategory::model()->findAllByAttributes(array('editable'=>1)),'id','name');
										
										
										echo $form->dropDownList($model1,'category_id',$data_1,array('class'=>'form-control','style'=>'width:200px;','prompt'=>Yii::t('app','Select Category'),'id'=>'category','options'=>array($sel=>array('selected'=>true)),'submit'=>array('/teachersportal/course/log','student_id'=>$_REQUEST['student_id'])));
										
										  ?>
                                        <?php echo $form->error($model1,'category_id'); ?>
                                        </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                      <tr>
                                        <td width="83%"><?php echo $form->textArea($model1,'comment',array('class'=>'form-control','id'=>'comment_text'));?>
                                         <?php echo $form->error($model1,'comment'); ?></td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        
                                        
                                         <?php
										if(isset($_REQUEST['cid']) and ($_REQUEST['cid']!=NULL))
										{
											$flag = LogCategory::model()->findbyPk($_REQUEST['cid']);
											if($flag->flag!=NULL)
											{
										?>
                                        <tr>
                                        <td>
                                        <?php echo $form->checkBox($model1,'flag',array('style'=>'','id'=>'flag_id','onClick'=>'getval()'));?>
                                                    <?php echo $form->error($model1,'flag'); ?><?php echo Yii::t('app','Add Flag'); ?></td>
                                        </tr>
                                         <tr><td>&nbsp;</td></tr>
                                         <?php }} ?>
                                         
                                          <tr id="expire_date" style="display:none;">
                                        
                                        <td><?php echo Yii::t('app','Expiration Date');?>
                                        <?php 
										
										$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                                		if($settings!=NULL)
                               			$date=$settings->dateformat;
                                		 else
                                   		 $date = 'dd-mm-yy';	
										 
										$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name'=>'LogComment[expiry_date]',
                                            'model'=>$model1,
                                            'value'=>$model1->expiry_date,
                                            
                                            'options'=>array(
                                            'showAnim'=>'fold',
                                            'dateFormat'=>$date,
                                            'changeMonth'=> true,
                                            'changeYear'=>true,
                                            'yearRange'=>'1900:'
                                            ),
                                            'htmlOptions'=>array(
											'id' => 'dobtxt',
											'readonly'=>true
                                            ),
                                        ));?>
                                                  </td>
                                        </tr>
                                         <tr><td>&nbsp;</td></tr>
                                        
                                        
                                        
                                        <?php
                                        	$notice=Configurations::model()->findByPk(36);
											if($notice->config_value)
											{
                                        ?>
                                         <tr>
                                         <td>
                                        <?php echo $form->checkBox($model1,'notice',array('style'=>'','id'=>''));?> <?php echo Yii::t('app','Notification');?>
                                         <?php echo $form->error($model1,'notice'); ?></td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        
                                        <?php } ?>
                                        <tr>
                                        <td >
                                        <?php echo $form->hiddenField($model1,'student_id',array('value'=>$_REQUEST['student_id']));?>
                       					<?php 
					   
										echo CHtml::ajaxSubmitButton(Yii::t('app','Submit'),
										CHtml::normalizeUrl(array('logcomment/create')),
										 array('dataType'=>'json', 'type'=>'post','success'=>'js: function(data) {
											 
											
											if (data.status == "error")
											{
												
												$.each(data.error, function(key, val) {
													
													$("#"+key+"_em_").html(String(val)).show();
												});
												
											}
											else
											{
												
												$("#outer_div").prepend(data.content).show();
												$("#comment_text").val("");
												
											}
											    
										}'),array('id'=>'cmnt_button'.'_'.time(),'name'=>'','class'=>'btn btn-primary','style'=>'')); 
							
										?>
	
                                        
                                        
                                        </td>
                                      </tr>
                                    </table>
								 <?php $this->endWidget(); ?>
                                </div>
                                
                            </div>
                            	
						<?php
					$this->widget('application.extensions.yiinfinite-scroll.YiinfiniteScroller', array(
						'contentSelector' => '#outer_div',
						'itemSelector' => 'div.individual_feed',
						//'navigationLinkText' => false,
						'loadingText' => Yii::t('app', 'Loading...'),
						'donetext' => Yii::t('app', 'No more feeds to show..!'),
						'pages' => $pages,
					));
					
					
				?>
                        </div> <!-- END div class="emp_cntntbx" -->
                    </div> <!-- END div class="emp_tabwrapper" -->
                </div>       
                    
                    
                    
                    
                    
            </div>
           
            
        </div> <!-- END div class="parentright_innercon" -->
    </div> <!-- END div id="parent_rightSect" -->
    <div class="clear"></div>
</div>
 <!-- END div id="parent_Sect" -->
<div class="clear"></div>

<div class="panel-body panel panel-default">
<div id="outer_div">
                            <?php 
							$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
                            foreach($comments as $comment)
							{	
								if($comment->visible_t){
								$user_com=Profile::model()->findByAttributes(array('user_id'=>$comment->created_by));
								
							?>
                            
								<br />
                            	<div class="log_comment_box" id="delete_div_<?php echo $comment->id; ?>" >
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
                                   <smal class="text-muted"l><?php echo date($settings->displaydate,strtotime($comment->date)).' '.date($settings->timeformat,strtotime($comment->date));?></small>
                                   <div class="pull-right">
                                    
                                    <?php 
									
									if($comment->category->editable){
        								echo  CHtml::ajaxSubmitButton(Yii::t('app', 'Delete'),CHtml::normalizeUrl(array("logcomment/deletecomment","id"=>$comment->id, "style"=>'margin-left:10px;')),
                                		array(
										'beforeSend'=>'function(){
                                       		   
                                    		}',
                                   			 'success'=>'function(result){
													$( "#delete_div_'.$comment->id.'").remove();
											}'
									
                                ),array('confirm'=>Yii::t('app', "Delete Your Post!"),'id'=>'deletecomment_'.$comment->id,"name"=>'yt_'.$comment->id,'class'=>'btn btn-danger')); 
								?>
                                
                                
                                
                                 <?php 
        							echo  CHtml::ajaxSubmitButton(Yii::t('app', 'Edit'),
                                			CHtml::normalizeUrl(array("logcomment/editcomment","id"=>$comment->id)),
                                	array(
											'beforeSend'=>'function(){
											  
											}',
											'success'=>'function(result){
												$( "#delete_div_'.$comment->id.'").html(result);
											}'
									
                                	),array('confirm'=>Yii::t('app', "Edit Your Post!"),'id'=>'editcomment_'.$comment->id.'_'.time(),"name"=>'yt_'.$comment->id.'_'.time(),'class'=>'btn btn-warning')); 
									}
									?>
                                   </div>
                                   
                                </div>
                               
							<?php 	
							} } 
							?>
							</div>
                            </div>