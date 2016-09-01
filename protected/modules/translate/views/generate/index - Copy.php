<?php
	$this->breadcrumbs=array(
		Yii::t('app','Settings')=>array('/configurations'),
		Yii::t('app','Translation'),	
	);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Missing Translations')." - ".TranslateModule::translator()->acceptedLanguages[Yii::app()->getLanguage()]?></h1>            
                <table width="719px">
                    <tr>
                        <td>
                            <span style="font-weight:600;"><?php echo Yii::t('app','Language');?> :</span><?php echo TranslateModule::translator()->g_dropdown("lang");?>
                        </td>
                        <td align="right">
                            
                            <?php
                            	$form = $this->beginWidget('CActiveForm', array(
									'method' => 'GET',
								));
							?>
                            <span style="font-weight:600;"><?php echo Yii::t('app','Items');?> :</span>
                            <?php
                                echo CHtml::dropDownList("page_size", $page_size, array(10=>10, 20=>20, 50=>50, 100=>100, 150=>150, 200=>200));
                            ?>
                            <?php $this->endWidget(); ?>
                        </td>
                    </tr>
                </table>
				<?php                                          
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
                <?php
					$form = $this->beginWidget('CActiveForm', array(
						'method' => 'POST',
					));
					echo CHtml::hiddenField("MessageSource[language]", $language);
				?>
                    <div class="formCon">
                        <div class="formConInner">
                            <table width="680px">                	
                                <?php
                                foreach($models as $item){
                                    $item->language	= $language;
                                    echo "<tr style='padding-bottom:10px;'>";
                                    echo "<td style='padding-bottom:10px; width:300px'>".$item->message."</td>";
                                    echo "<td style='padding-bottom:10px;'>".CHtml::textField("MessageSource[items][".$item->id."]", $item->translation, array("style"=>"width:100%;"))."</td>";
                                    echo "</tr>";
                                }
                                ?>                  
                            </table>  
                            <div style="padding:0px 0 0 0px; text-align:left">
                                <input type="submit" value="<?php echo Yii::t('app','Generate Translations');?>" name="yt0" class="formbut" />
                            </div>                      
                        </div>
                    </div>
					<?php                                          
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
                <?php $this->endWidget(); ?>								
            </div>
        </td>
    </tr>    
</table>
<script>
$("#page_size, #lang").change(function(e) {	
	var size	= $("#page_size").val();
	var lan		= $("#lang").val();	
	window.location.href	= "<?php echo Yii::app()->createUrl("/translate/generate/index");?>&page_size=" + size + "&lang=" + lan;
});
</script>