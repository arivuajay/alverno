<?php 
/**
* Ajax Crud Administration
* FinanceFeeCategories * index.php view file
* InfoWebSphere {@link http://libkal.gr/infowebsphere}
* @author  Spiros Kabasakalis <kabasakalis@gmail.com>
* @link http://reverbnation.com/spiroskabasakalis/
* @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
* @since 1.0
* @ver 1.3
* @license The MIT License
*/
?>
<?php
$this->breadcrumbs=array(
Yii::t('app','Fees')=>array('/fees'),
Yii::t('app','Finance Fee Categories'),
);
?>
<?php  
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
	});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('finance-fee-categories-grid', {
	data: $(this).serialize()
	});
	return false;
	});
");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        <?php $this->renderPartial('/default/left_side');?>        
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Fee Categories'); ?> </h1>            
                <?php
                function getBatch($id)
                { 
                    $batch = Batches::model()->findByAttributes(array("id"=>$id));
                    if($batch!=NULL)
                        echo $batch->name;
                }
                ?>
                <?php
				$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
				if(Yii::app()->user->year)
				{
					$year = Yii::app()->user->year;
				}
				else
				{
					$year = $current_academic_yr->config_value;
				}
				$is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
				$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
				$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
				
				$template = '{finance-fee-categories_view}';
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
				{
					$template = $template.'{finance-fee-categories_update}';
				}
				
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
				{
					$template = $template.'{finance-fee-categories_delete}';
				}
				
				if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
				{
				?>
				<div class="right" align="left">
					 <?php echo CHtml::link(Yii::t('app','Create New Fee Category'), array('#'),array('id'=>'add_finance-fee-categories','class'=>'cbut')) ?>
				</div>
				<?php
				}
				?>
                
                <?php
				if($year != $current_academic_yr->config_value and ($is_create->settings_value==0 or $is_edit->settings_value==0 or $is_delete->settings_value==0))
				{	
				?>
                    <div>
                        <div class="yellow_bx" style="background-image:none;width:95%;padding-bottom:45px;">
                            <div class="y_bx_head" style="width:95%;">
                            <?php 
                                echo Yii::t('app','You are not viewing the current active year. ');
                                if($is_create->settings_value==0 and $is_edit->settings_value!=0 and $is_delete->settings_value!=0)
                                { 
                                    echo Yii::t('app','To create a fee category, enable Create option in Previous Academic Year Settings.');
                                }
                                elseif($is_create->settings_value!=0 and $is_edit->settings_value==0 and $is_delete->settings_value!=0)
                                {
                                    echo Yii::t('app','To edit a fee category, enable Edit option in Previous Academic Year Settings.');
                                }
                                elseif($is_create->settings_value!=0 and $is_edit->settings_value!=0 and $is_delete->settings_value==0)
                                {
                                    echo Yii::t('app','To delete a fee category, enable Delete option in Previous Academic Year Settings.');
                                }
                                else
                                {
                                    echo Yii::t('app','To manage the fee categories, enable the required options in Previous Academic Year Settings.');	
                                }
                            ?>
                            </div>
                            <div class="y_bx_list" style="width:95%;">
                                <h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
                            </div>
                        </div>
                    </div>
					<?php	
					}
					?>
                <div id="success_flash" align="center" style=" color:#F00; display:none;">
                	<h4><?php echo Yii::t('app','Selected Fee Category Deleted Successfully!'); ?></h4>                
                </div>
                
                <?php
                //Strings for the delete confirmation dialog.
                $del_con = Yii::t('app', 'Are you sure you want to delete this fee category?');
                $del_cont = Yii::t('app', 'Please note: All data (fee collection, fee particular and student details) associated with this fee category will be deleted.');
                $del_title=Yii::t('app', 'Delete Confirmation');
                $del=Yii::t('app', 'Delete');
                $cancel=Yii::t('app', 'Cancel');
                ?>
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
					'id' => 'finance-fee-categories-grid',
					'dataProvider' => $model->search(),
					/*'filter' => $model,*/
					'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
					'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
					'htmlOptions'=>array('class'=>'grid-view clear'),
					'columns' => array(
						array('name'=>'name',
							'type'=>'raw',
							'value'=>'CHtml::link(CHtml::encode($data->name), Yii::app()->createUrl("fees/financeFeeParticulars/index",array("FinanceFeeParticulars[finance_fee_category_id]"=>$data->id)))'),
						'description',
						array('name'=>'batch_id',
							'type'=>'raw',
							'value'=>'getBatch($data->batch_id)'),
						array(
							   'class' => 'CButtonColumn',
							    'header'=>Yii::t('app','Action'),
				   				'headerHtmlOptions'=>array('style'=>'font-size:12px; font-weight:bold;'),
								'buttons' => array(
												 'finance-fee-categories_delete' => array(
												 'label' => Yii::t('app', 'Delete'), // text label of the button
												  'url' => '$data->id', // a PHP expression for generating the URL of the button
												  'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/cross.png', // image URL of the button.   If not set or false, a text link is used
												  'options' => array("class" => "fan_del", 'title' => Yii::t('app', 'Delete')), // HTML options for the button   tag
												  ),
												 'finance-fee-categories_update' => array(
												 'label' => Yii::t('app', 'Update'), // text label of the button
												 'url' => '$data->id', // a PHP expression for generating the URL of the button
												 'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/pencil.png', // image URL of the button.   If not set or false, a text link is used
												 'options' => array("class" => "fan_update", 'title' => Yii::t('app', 'Update')), // HTML options for the    button tag
													),
												 'finance-fee-categories_view' => array(
												  'label' => Yii::t('app', 'View'), // text label of the button
												  'url' => '$data->id', // a PHP expression for generating the URL of the button
												  'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/properties.png', // image URL of the button.   If not set or false, a text link is used
												  'options' => array("class" => "fan_view", 'title' => Yii::t('app', 'View')), // HTML options for the    button tag
													)
												),
							   'template' => $template,
						),
						array(
							   'class' => 'CButtonColumn',
								'buttons' => array(
																 
																	'add' => array(
																	'label' =>Yii::t('app','Add Particulars'), // text label of the button
																	
																	'url'=>'Yii::app()->createUrl("fees/financeFeeParticulars/index", array("FinanceFeeParticulars[finance_fee_category_id]"=>$data->id))', // a PHP expression for generating the URL of the button
																  
																	)
																),
							   'template' => '{add}',
							   'header'=>Yii::t('app','Manage'),
							   'htmlOptions'=>array('style'=>'width:17%'),
							   'headerHtmlOptions'=>array('style'=>'color:#FF6600')
						),
					),
					'afterAjaxUpdate'=>'js:function(id,data){$.bind_crud()}'
                
                  ));
                
                
                ?>
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>
    
    <script type="text/javascript">
    //document ready
    $(function() {
    
    //declaring the function that will bind behaviors to the gridview buttons,
    //also applied after an ajax update of the gridview.(see 'afterAjaxUpdate' attribute of gridview).
    $. bind_crud= function(){
        
    //VIEW
    
    $('.fan_view').each(function(index) {
    var id = $(this).attr('href');
    $(this).bind('click', function() {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories/returnView",
            data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
            beforeSend : function() {
                $("#finance-fee-categories-grid").addClass("ajax-sending");
            },
            complete : function() {
                $("#finance-fee-categories-grid").removeClass("ajax-sending");
            },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn" : "elastic",
                            "transitionOut" :"elastic",
                            "speedIn"              : 600,
                            "speedOut"         : 200,
                            "overlayShow"  : false,
                            "hideOnContentClick": false
                        });//fancybox
                //  console.log(data);
            } //success
        });//ajax
        return false;
    });
    });
    
    //UPDATE
    
    $('.fan_update').each(function(index) {
    var id = $(this).attr('href');
    $(this).bind('click', function() {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories/returnForm",
            data:{"update_id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
            beforeSend : function() {
                $("#finance-fee-categories-grid").addClass("ajax-sending");
            },
            complete : function() {
                $("#finance-fee-categories-grid").removeClass("ajax-sending");
            },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn"    :  "elastic",
                             "transitionOut"  : "elastic",
                             "speedIn"               : 600,
                             "speedOut"           : 200,
                             "overlayShow"    : false,
                             "hideOnContentClick": false,
                            "afterClose":    function() {
                               var page=$("li.selected  > a").text();
                            $.fn.yiiGridView.update('finance-fee-categories-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories',data:{"FinanceFeeCategories_page":page}});
                            }//onclosed
                        });//fancybox
                //  console.log(data);
            } //success
        });//ajax
        return false;
    });
    });
    
    
    // DELETE
    
    var deletes = new Array();
    var dialogs = new Array();
    $('.fan_del').each(function(index) {
    var id = $(this).attr('href');
    deletes[id] = function() {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories/ajax_delete",
            data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                $("#finance-fee-categories-grid").addClass("ajax-sending");
            },
            complete : function() {
                $("#finance-fee-categories-grid").removeClass("ajax-sending");
            },
            success: function(data) {
                var res = jQuery.parseJSON(data);
                 var page=$("li.selected  > a").text();
                $.fn.yiiGridView.update('finance-fee-categories-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories',data:{"FinanceFeeCategories_page":page}});
            }//success
        });//ajax
    };//end of deletes
    
    dialogs[id] =
                    $('<div></div>')
                    .html('<?php echo  $del_con; ?><br><br><?php echo  $del_cont; ?><br>')
                   .dialog(
                    {
                        autoOpen: false,
                        title: '<?php echo  $del_title; ?>',
                        modal:true,
                        resizable:false,
                        buttons: [
                            {
                                text: "<?php echo  $del; ?>",
                                click: function() {
                                                                  deletes[id]();
                                                                  $(this).dialog("close");
																  $("#success_flash").css("display","block").animate({opacity: 1.0}, 3000).fadeOut("slow");
                                                                  }
                            },
                            {
                               text: "<?php echo $cancel; ?>",
                               click: function() {
                                                                 $(this).dialog("close");
                                                                 }
                            }
                        ]
                    }
            );
    
    $(this).bind('click', function() {
                                                                  dialogs[id].dialog('open');
                                                                   // prevent the default action, e.g., following a link
                                                                  return false;
                                                                 });
    });//each end
    
    }//bind_crud end
    
    //apply   $. bind_crud();
    $. bind_crud();
    
    
    //CREATE 
    
    $('#add_finance-fee-categories ').bind('click', function() {
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories/returnForm",
        data:{"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
            beforeSend : function() {
                $("#finance-fee-categories-grid").addClass("ajax-sending");
            },
            complete : function() {
                $("#finance-fee-categories-grid").removeClass("ajax-sending");
            },
        success: function(data) {
            $.fancybox(data,
                    {    "transitionIn"      : "elastic",
                        "transitionOut"   : "elastic",
                        "speedIn"                : 600,
                        "speedOut"            : 200,
                        "overlayShow"     : false,
                        "hideOnContentClick": false,
                        "afterClose":    function() {
                               var page=$("li.selected  > a").text();
                            $.fn.yiiGridView.update('finance-fee-categories-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCategories',data:{"FinanceFeeCategories_page":page}});
                        } //onclosed function
                    });//fancybox
        } //success
    });//ajax
    return false;
    });//bind
    
    
    })//document ready
    
    
    
    
    </script>
    
    
   