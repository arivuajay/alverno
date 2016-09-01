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
                <h1><?php echo Yii::t('app','Translations')." - ".TranslateModule::translator()->acceptedLanguages[Yii::app()->getLanguage()]?></h1>            
                <table width="719px">
                    <tr>
                        <td>
                            <span style="font-weight:600; margin:0px 0px -10px 2px; display:block;"><?php echo Yii::t('app','Language');?> :</span>
                            <br />
							<?php echo TranslateModule::translator()->g_dropdown("lang");?>
                        </td>
                        <td>
                        	<span style="font-weight:600; margin:0px 0px -10px 2px; display:block;"><?php echo Yii::t('app','Filter by');?> :</span>
                            <br />
                            <?php
                                echo CHtml::dropDownList("filter_by", $filter_by, array(1=>Yii::t("app", "All"), 2=>Yii::t("app", "Completed Translations"), 3=>Yii::t("app", "Missing Translations")));
                            ?>
                        </td>
                        <td align="rigsht">                            
                            <?php
                            	$form = $this->beginWidget('CActiveForm', array(
									'method' => 'GET',
								));
							?>
                            <span style="font-weight:600; margin:0px 0px -10px 2px; display:block;"><?php echo Yii::t('app','Items');?> :</span>
                            <br />
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
                if(count($models)==0){
				?>
                	<div class="formCon">
                        <div class="formConInner">                             
                            <div style="padding:0px 0 0 0px; text-align:left">
                                <?php echo Yii::t('app','No data found !!');?>
                            </div>                      
                        </div>
                    </div>
                <?php
				}
				else{
				?>
					<?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'method' => 'POST',
                        ));
                        echo CHtml::hiddenField("MessageSource[language]", $language);
                    ?>
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
                        <div>
                        	<a>** Please read Instructions before translation.</a> <a style="text-decoration:underline;" href="javascript:void(0);" id="read_t_instructions">Click here to read the instructions</a>.
                        </div>
                        <br />
                        <div class="formCon" style="display:none;" id="t_instructions">
                            <div class="formConInner">
                            	<h3 style="margin:0px; color:#396">You need these Instructions before translating the application.</h3>
                                <ol style="margin:10px 0px 0px; padding:0px 30px 0px 10px; line-height:17px; text-align:justify;">
                                	<li>Hello , WELCOME to OS Translate module. OS tranlate module helps you to translate the full application to your own language. The application will be using ENGLISH as default language. We can help you change it to your own language. Please read the following instrctions carefully.</li>
                                	<li>In the below table we are listed the labels used in our application. You can filter it from the above "<?php echo Yii::t('app','Filter by');?>" dropdown.</li>
                                    <li>Each label have a textbox in the right side. You can give your translation there.</li>
                                    <li>Please do not translate the words inside the labels that are look like {word} and :word. They are actually using for background label generations. Don't forget this !!</li>
                                    <li>After you put tranaltion texts in the textboxes corresponding to the labels you needed, click on the "<?php echo Yii::t('app','Generate Translations');?>" button given at the bottom of the current page. </li>
                                    <li>Repeat steps 2-5 to complete all the translations.</li>
                                    <li>If you found any labels that are not yet translated, please do the 6th step. :-)</li>
                                </ol>
                                <br />
                                <br />
                                <a href="javascript:void(0);" id="hide_t_instructions">Hide this box</a>
                            </div>
                        </div>
                        <div class="formCon">
                            <div class="formConInner">
                                <table width="680px">
                                    <tr>
                                        <td colspan="2">
                                            <h4 style="margin:0px; color:#396"><?php echo Yii::t('app', "Number of items in this page")." : ".count($models);?></h4>
                                            <br/><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:5px;">
                                            <h3 style="margin:0px; color:#09C"><?php echo Yii::t('app', "Label in Application");?></h3>
                                        </td>
                                        <td style="padding-bottom:5px;">
                                            <h3 style="margin:0px; color:#09C"><?php echo Yii::t('app', "Your Translation");?></h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom:20px;" colspan="2">
                                        </td>
                                    </tr>            	
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
                <?php
				}
				?>							
            </div>
        </td>
    </tr>    
</table>
<script>
$("#lang, #filter_by, #page_size").change(function(e) {
	var lan		= $("#lang").val();
	var filter	= $("#filter_by").val();
	var size	= $("#page_size").val();	
	var alpha	= $(".alphabet-box.active").attr('data-alphabet');
	var redirect	= "<?php echo Yii::app()->createUrl("/translate/generate/index");?>&lang=" + lan + "&filter_by=" + filter + "&page_size=" + size;
	if(typeof alpha!="undefined" && alpha!=null && alpha!=""){
		redirect	+= "&val=" + alpha;
	}
	window.location.href	= redirect;
});

$(".alphabet-box").click(function(e) {
	var lan		= $("#lang").val();
	var filter	= $("#filter_by").val();
	var size	= $("#page_size").val();
	var alpha	= $(this).attr('data-alphabet');
	window.location.href	= "<?php echo Yii::app()->createUrl("/translate/generate/index");?>&lang=" + lan + "&filter_by=" + filter + "&page_size=" + size + "&val=" + alpha;
});

$("#read_t_instructions").click(function(e) {
    $("#t_instructions").slideDown();
});

$("#hide_t_instructions").click(function(e) {
    $("#t_instructions").slideUp();
});
</script>