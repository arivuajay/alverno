<?php
$this->breadcrumbs=array(	
	Yii::t('app','Holidays'),
);
?>
<?php $this->beginContent('//layouts/main'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('//configurations/_leftside_links');?>
        </td>
        <td valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" width="75%">
                        <div class="cont_right formWrapper" style="padding-left:20px; position:relative;">
                        <h1><?php echo Yii::t('app','Annual Holidays');?></h1>                        
                        <div id="calendar" style="width:100%; padding-top:5px"><?php  echo $content; ?></div>
                            <div style="width:100%;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td valign="top" width="1%"><img src="images/paperbtm_left.png" width="14" height="14" /></td>
                                        <td width="100%" class="paperbtm_mid">&nbsp;</td>
                                        <td valign="top" align="right" width="1%"><img src="images/paperbtm_right.png" width="14" height="14" /></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
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
<br />
<br />
<br />
<?php $this->endContent(); ?>