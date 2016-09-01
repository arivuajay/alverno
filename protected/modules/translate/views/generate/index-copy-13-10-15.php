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
                
                <div class="list_contner_hdng">
                    <div class="letterNavCon">
                        <ul>
                            <?php
                                /*if((isset($_GET['val']) and $_GET['val']==NULL) or !isset($_GET['val'])){
                                    echo '<li class="ln_active">'.CHtml::link('All', Yii::app()->request->getUrl().'&val=', array('class'=>' active')).'</li>';
                                }
                                else{
                                    echo '<li>'.CHtml::link('All', Yii::app()->request->getUrl().'&val=', array('class'=>'')).'</li>';
                                }
								
                                foreach (range('A', 'Z') as $char) {
                                    $class	= "";
                                    if(isset($_GET['val']) and strtolower($_GET['val'])==strtolower($char)){
                                        $class	= " ln_active";
                                    }
                                    echo '<li class="'.$class.'">'.CHtml::link($char, Yii::app()->request->getUrl().'&val='.$char, array('class'=>'vtip')).'</li>';
                                }*/
								
								if((isset($_GET['val']) and $_GET['val']==NULL) or !isset($_GET['val'])){
                                    echo '<li class="ln_active">'.CHtml::link('All', 'javascript:void(0);', array('class'=>'alphabet-box active', 'data-alphabet'=>'')).'</li>';
                                }
                                else{
                                    echo '<li>'.CHtml::link('All', 'javascript:void(0);', array('data-alphabet'=>'', 'class'=>'alphabet-box')).'</li>';
                                }
								
                                foreach (range('A', 'Z') as $char) {
                                    if(isset($_GET['val']) and strtolower($_GET['val'])==strtolower($char)){
                                        echo '<li class="ln_active">'.CHtml::link($char, 'javascript:void(0);', array('class'=>'vtip alphabet-box active', 'data-alphabet'=>$char)).'</li>';
                                    }
									else{
										echo '<li>'.CHtml::link($char, 'javascript:void(0);', array('class'=>'vtip alphabet-box', 'data-alphabet'=>$char)).'</li>';
									}
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <br/>
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
	var alpha	= $(".alphabet-box.active").attr('data-alphabet');
	var redirect	= "<?php echo Yii::app()->createUrl("/translate/generate/index");?>&page_size=" + size + "&lang=" + lan;
	if(typeof redirect!="undefined" && redirect!=null && redirect!=""){
		redirect	+= "&val=" + alpha;
	}
	window.location.href	= redirect;
});

$(".alphabet-box").click(function(e) {
    var alpha	= $(this).attr('data-alphabet');
	var size	= $("#page_size").val();
	var lan		= $("#lang").val();
	window.location.href	= "<?php echo Yii::app()->createUrl("/translate/generate/index");?>&page_size=" + size + "&lang=" + lan + "&val=" + alpha;
});
</script>