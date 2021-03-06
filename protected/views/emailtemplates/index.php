<style type="text/css">
 p.red_er{ position:relative;
 color:red;
 top:-50px;
 float:right;
 right:30px;}
</style>
<script>

$('document').ready(function() {
$('#employee_head').click(function(){
$('#employee_body').toggle();
$('#student_body').hide();
$('#parent_body').hide();

});
$('#student_head').click(function(){
$('#student_body').toggle();
$('#employee_body').hide();
$('#parent_body').hide();

});
$('#parent_head').click(function(){
$('#parent_body').toggle();
$('#employee_body').hide();
$('#student_body').hide();
});

$('#general_head').click(function(){
$('#general_body').toggle();
$('#parent_body').hide();
$('#employee_body').hide();
$('#student_body').hide();
});

});


</script>
<?php
$this->breadcrumbs=array(
	Yii::t('app','Notify')=>array('notifications/default/sendmail'),
	Yii::t('app', 'Email Templates'),
);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top" id="port-left">    
        	<?php $this->renderPartial('left_side');?>    
        </td>
        <td valign="top"> 
        
        	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                    <td width="75%" valign="top">
                    <h1 style="margin-left:10px;"><?php echo Yii::t('app','Email Templates');?></h1>
                    <p class="red_er">*<?php echo Yii::t('app', 'Please do not remove the content within the');?> {{ }}</p>
                    <div style="position:relative;">
                            <div class="contrht_bttns" style="right: 9px;">
								
                            </div>
                            </div>
                            <div class="tempCon" style=" margin:10px; width:97%;" id="parent_head">
                            	<h4><strong><?php echo Yii::t('app', 'Parent');?></strong><span><?php echo Yii::t('app', 'Email Templates to Parents');?></span></h4>
                            </div>
                           
                           
                    	<div style=" margin:10px;display:none; width:97%" class="sms-block formCon" id="parent_body">
    						
							<?php
                            foreach($templates as $template){
								
								if($template->user_type==1)
								{
									
									$this->renderPartial('_view', array('data'=>$template));	
								}						
							}
							
							if(count($templates)==0){
							?>
							<div style="padding-top:10px" class="notifications nt_red"><i><?php echo Yii::t('app','No templates found');?></i></div>
							<?php
							}
							
							
							?>  
                           <div class="clear"></div>
                            
                            <div class="clear"></div>
                        </div> 
                            
                             <div class="tempCon" style=" margin:10px; width:97%; " id="student_head">
                            	<h4><strong><?php echo Yii::t('app', 'Student');?></strong><span><?php echo Yii::t('app', 'Email Templates to Students');?></span></h4>
                            </div>
                            <div style=" margin:10px; width:97%;display:none;" class="sms-block formCon" id="student_body">
                            <?php
                            foreach($templates as $template){
								if($template->user_type==2)
								{
									$this->renderPartial('_view', array('data'=>$template));	
								}
							}
							
							if(count($templates)==0){
							?>
							<div style="padding-top:10px" class="notifications nt_red"><i><?php echo Yii::t('app','No templates found');?></i></div>
							<?php
							}
							
							
							?>  
                             <div class="clear"></div>
                            
                            <div class="clear"></div>
                        </div> 
                             <div class="tempCon" style=" margin:10px; width:97%; " id="employee_head">
                            	<h4><strong><?php echo Yii::t('app', 'Teacher');?></strong><span><?php echo Yii::t('app', 'Email Templates to Teacher');?></span></h4>
                            </div>
                            <div style=" margin:10px; width:97%;display:none" class="sms-block formCon" id="employee_body">
                            <?php
                            foreach($templates as $template){
								
								if($template->user_type==3)
								{
									$this->renderPartial('_view', array('data'=>$template));	
								}						
							}
							
							if(count($templates)==0){
							?>
							<div style="padding-top:10px" class="notifications nt_red"><i><?php echo Yii::t('app','No templates found');?></i></div>
							<?php
							}
							
							
							?>  
                            <div class="clear"></div>
                            
                            <div class="clear"></div>
                        </div> 
                        
                        <div class="tempCon" style=" margin:10px; width:97%; " id="general_head">
                            	<h4><strong><?php echo Yii::t('app', 'General');?></strong><span><?php echo Yii::t('app', 'Email Templates to General Users');?></span></h4>
                            </div>
                            <div style=" margin:10px; width:97%;display:none" class="sms-block formCon" id="general_body">
                            <?php
                            foreach($templates as $template){
								
								if($template->user_type==0)
								{
									$this->renderPartial('_view', array('data'=>$template));	
								}						
							}
							
							if(count($templates)==0){
							?>
							<div style="padding-top:10px" class="notifications nt_red"><i><?php echo Yii::t('app','No templates found');?></i></div>
							<?php
							}
							
							
							?>  
                            <div class="clear"></div>
                            
                            <div class="clear"></div>
                        </div>   
                            
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</table>


  <div class="clear"></div>