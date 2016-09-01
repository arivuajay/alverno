<?php
$this->breadcrumbs=array(
	Yii::t('app','Notify')=>array('/notifications/default/sendmail'),
	Yii::t('app','SMS Contact Groups'),
);
?>
<style>
.contact_box.selected{
	background-color:#FEC42C;
}
.extra_options{
	margin-top:10px;
	margin-bottom:10px;
	display:none;
}

.client-val-form{ padding-right:20px;}

.client-val-form input{
/*     background: url("../images/bg-form-field.gif") repeat-x scroll left top #FFFFFF;*/
    border: 1px solid #D5D5D5;
    border-radius: 4px 4px 4px 4px;
    color: #333333;
    font-size: 13px;
    padding: 6px;
    width: 100%;
      display: block;
}

</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top" id="port-left">    
        	<?php $this->renderPartial('/default/left_side');?>    
        </td>
        <td valign="top">        
        	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                    <td width="75%" valign="top">
                    	<div style="padding-left:20px;" class="sms-block">
    						<h1><?php echo Yii::t('app','Contact Groups');?></h1>
                            <div style="position:relative;">
                                <div class="contrht_bttns" style="right:9px;">
                                    <ul>
                                        <li>
                                            <?php echo CHtml::link('<span>'.Yii::t('app','Create a group').'</span>', array('#'),array('class'=>'saveic', 'id'=>'add_contact-groups'));?>
                                        </li>
                                	</ul>
                                </div>
                            </div>           
                            
                            <!--extra options-->
                            <div class="extra_options_con" id="extra_options">
                            <ul>
                            <li>
                                <a href="javascript:void(0);" id="delete_groups"><?php echo Yii::t('app', 'Delete');?></a>
                            </li>
                            </ul>
                            </div>
                            <!--extra options-->
                            <div class="clear"></div>
                                             
							<?php
                            foreach($contactgroups as $contactgroup){
								$this->renderPartial('_view', array('data'=>$contactgroup));						
							}
							
							if(count($contactgroups)==0){
							?>
							<div style="padding-top:10px" class="notifications nt_red"><i><?php echo Yii::t('app','No groups found');?></i></div>
							<?php
							}
							?>
                            <div class="clear"></div>
                            <?php
							//pagination
							$this->widget('CLinkPager', array(
								'currentPage'=>$pages->getCurrentPage(),
								'itemCount'=>$item_count,
								'pageSize'=>$page_size,
								'maxButtonCount'=>5,
								//'nextPageLabel'=>'My text >',
								'header'=>'',
								'htmlOptions'=>array('class'=>'pages'),
							));
							?>  
                            
                            <div class="clear"></div>
                                                     
                        </div>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</table>
<div id="contact-groups-grid">
</div>
<script>
$('.contact_box').click(function(e) {	
	if($(this).hasClass('selected'))
    	$(this).removeClass('selected');
	else
		$(this).addClass('selected');	
});

$('#add_contact-groups ').bind('click', function() {
	$.ajax({
		type: "POST",
		url: "<?php echo Yii::app()->createUrl('/sms/contactgroups/returnForm');?>",
		data:{"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
		beforeSend : function() {
			$("#contact-groups-grid").addClass("ajax-sending");
		},
		complete : function() {
			$("#contact-groups-grid").removeClass("ajax-sending");
		},
		success: function(data) {			
			$.fancybox(data,
			{ 
				"transitionIn"      : "elastic",
				"transitionOut"   : "elastic",
				"speedIn"                : 600,
				"speedOut"            : 200,
				"overlayShow"     : false,
				"hideOnContentClick": false,
				"afterClose":    function() {
					window.location.reload();
				} //onclosed function
			});//fancybox
		} //success
	});//ajax
	return false;
});


$('#delete_groups').click(function(e) {   
	var groupIds	= [];
    $('.contact_box').each(function(index, element) {
		if($(element).hasClass('selected')){
        	groupIds.push($(element).attr('data-group-id'));
		}
    });
	
	if(groupIds.length==0){
		alert('<?php echo Yii::t('app', 'Select groups first');?>');
	}
	else{
		if(confirm('<?php echo Yii::t('app', 'Are you sure ?');?>')){
			//ajax
			$.ajax({
				type:"POST",
				url:"<?php echo Yii::app()->createUrl('/sms/contactgroups/deletegroups');?>",
				data:{groups:groupIds},
				success: function(){
					document.location.reload();
				},
				error:function(){
					document.location.reload();
				}
			});	
		}
	}
});
</script>