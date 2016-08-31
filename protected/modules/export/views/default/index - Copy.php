<style>
#workarea{
	min-height:200px;
	border:1px solid #888;
	margin-top:10px;
	padding:15px;
	overflow:hidden;
	display:none;
	background-color:#FFF;
	position:relative;
}
.dragarrow{
	position:absolute;
	width:34px;
	height:74px;
	top:110px;
	left:330px;
	background:#000 url(images/drag-arrow.jpg) no-repeat;
}
#alColumns{
	width:43%;
	min-height:190px;
	border:2px solid #e8b325;
	float:left;
	-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}

#reqColumns{
	width:43%;
	min-height:190px;
	border:2px solid #e8b325;
	float:right;
	-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}

.model-attr{
	border:0px solid #DDD;
	padding:10px;
	margin:10px;
	background-color:#e8b325;
	color:#033;
	font-weight:600;
	font-weight:bold;
	text-align:center;
	-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}
.drop-hover{
	background-color:#f1f1f1;
}
</style>
<?php
$this->breadcrumbs=array(
	Yii::t('app', $this->module->id),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">        
        	<?php $this->renderPartial('left_side');?>        
        </td>
        <td valign="top">
		<div class="cont_right ">
            <h1><?php echo Yii::t('app', 'Export Database'); ?></h1>
    
            <div class="form">
                <?php echo CHtml::beginForm('','post',array()); ?>
                    <div>
                        <div class="inner_new_formCon">
                            <h3><?php echo Yii::t('app','Fields with').'<span class="required">*</span>'.Yii::t('app','are required.');?></h3>
                            <br>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                <tr>
                                <td colspan="2">
                                <div id="exportmsg">
                                <?php
                                if(Yii::app()->user->hasFlash('exporterror')){
									echo '<span style="display: block; margin-bottom: 10px; color:#F00;">'.Yii::app()->user->getFlash('exporterror')."</span>";
								}
								?>
                                </div>
                                </td>
                                </tr>
                                <tr id="render_after">
                                <td valign="middle"><label for="FileCategory_category" class="required"><?php echo Yii::t('app','Model');?> <span class="required">*</span></label></td>
                                <td>
                                <?php echo CHtml::dropDownList('model', '', $modelsArray);?>						
                                </td>
                                </tr>
                                <tr>
                                <td colspan="2">
                                <div id="workarea">
                                	<div class="dragarrow"></div>                                    
                                	<table width="100%">
                                        <tr>
                                            <td  width="56%"><?php echo Yii::t('app','Remaining');?> ( <span id="attrRemaining">0</span> )</td>
                                            <td><?php echo Yii::t('app','Selected');?> ( <span id="attrSelected">0</span> )</td>
                                        </tr>
                                         <tr>
                                        	<td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>                         	
                                    <div id="alColumns"></div>
                                    <div id="reqColumns"></div>
                                </div>
                                </td>
                                </tr>
                                <tr>
                                <td valign="middle">&nbsp;</td>
                                <td style="padding-top:10px;">
                                <?php echo CHtml::Button(Yii::t('app', 'Next'), array('id'=>'setupattrs','class'=>'formbut'));?>
                                <?php echo CHtml::submitButton(Yii::t('app', 'Export Database'), array('name'=>'export-database', 'id'=>'exportattrs','class'=>'formbut', 'style'=>'display:none;'));?>
                                </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row buttons">
                            </div>
                        </div>
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
			</div> 
        </td>
    </tr>
</table>

<script type="text/javascript">
$( document ).ready(function(e) {
	if($('#workarea').is(':visible')){
		populate_attributes();
	}    
});

$('#setupattrs').click(function(){
	if(!$('#workarea').is(':visible')){
		$('#workarea').slideDown(function(){
			populate_attributes();
		});
	}
	else{
		populate_attributes();
	}
	$(this).remove();	
});

$('#model').change(function(e) {
	if($('#workarea').is(':visible'))
    	populate_attributes();
});

$('#exportattrs').click(function(){
	if( ! $('.attr-input-hidden').length){
		$('#exportmsg').html('<span style="display: block; margin-bottom: 10px; color:#F00;">Choose columns to export !!</span>');
	}
	else{
		var confirm_msg	= "<?php echo Yii::t('app','Export model');?> '" + $('#model option:selected').text() + "'<?php echo Yii::t('app',' with attributes');?> ";
		var cols	=	$('#reqColumns .model-attr');
		cols.each(function(index, element) {
            confirm_msg	+= $(element).attr("data-label") ;
			if(index < (cols.length - 1))
				confirm_msg	+= ", ";
        });
		confirm_msg	+= "?";
		if ( confirm( confirm_msg ) ){
			return true;
		}
	}
	return false;
});

$( "#reqColumns" ).droppable({
	hoverClass: "drop-hover",
	drop: function( event, ui ) {		
		if(!ui.draggable.hasClass('req-columns')){			
			var attr		= ui.draggable.attr('data-attr'),
				label		= ui.draggable.attr('data-label');
				
			var	attr_bx		= $('<div />'),
				attr_lbl	= $('<span />'),
				attr_input	= $('<input />');
			attr_bx.attr({class:'model-attr req-columns', 'data-attr':attr, 'data-label':label});
			attr_lbl.text(label);
			attr_input.attr({name:'reqColumns[]', class:'attr-input-hidden', type:'hidden', value:attr});
			attr_bx.append(attr_input).append(attr_lbl);
			$(this).append(attr_bx);
			ui.draggable.remove();

			//setting count
			set_total_attrs();
			
			$('#exportattrs').show();		
		}
	}
});
$('#alColumns').droppable({
	hoverClass: "drop-hover",
	drop: function( event, ui ) {
		if(ui.draggable.hasClass('req-columns')){
			ui.draggable.remove();
			
			var attr		= ui.draggable.attr('data-attr'),
				label		= ui.draggable.attr('data-label');
				
			var	attr_bx		= $('<div />');
			attr_bx.attr({class:'model-attr', 'data-attr':attr, 'data-label':label});
			attr_bx.text(label);
			attr_bx.draggable({revert:true});
			$(this).append(attr_bx);
			
			
			
			//setting count
			set_total_attrs();
			
			if(!$('.attr-input-hidden').length){
				$('#exportattrs').hide();
			}
		}
	}
});
$('#reqColumns').sortable({revert:true});

function set_total_attrs(){	
	$('#attrRemaining').text($('#alColumns').find('.model-attr').length);
	$('#attrSelected').text($('#reqColumns').find('.attr-input-hidden').length);
}

function populate_attributes(){
	$('html, body').animate({scrollTop:$('#content').position().top}, 'slow');
	
	$('#alColumns, #reqColumns').html('');
	$('#exportattrs').hide();
	
	var loading	= $('<img />');
	loading.attr({ class:'', src:'<?php echo Yii::app()->baseurl;?>/images/loading.gif'});
	loading.css({margin:'58px auto 0 112px', width:'100px'})
	$('#alColumns').append(loading);
	
	//removing extra fields
	$(".extra_fields").remove();
	
	$.ajax({
		url:'<?php echo Yii::app()->createUrl('/export/default/attributes');?>',
		data:{model:$('#model').val()},
		dataType:"json",
		success:function(response){
			$('#alColumns').html('');
			if(response.result=="success"){
				var total_attrs=0;
				for(var key in response.data){
					var attribute	=	response.data[key];
					var newelem	= $('<div />');
					newelem.draggable({revert:true});
					newelem.attr({class:'model-attr', 'data-attr':key, 'data-label':attribute});
					newelem.text(attribute);
					$('#alColumns').append(newelem);
					total_attrs++;
				}
				
				//render file content if available
				if(response.render){
					$(response.render).insertAfter('tr#render_after');
				}
				
				//setting count
				set_total_attrs();
			}
		}		
	});
}
</script>