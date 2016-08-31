<?php 
/**
 * Ajax Crud Administration
 * feeCollectionParticulars * index.php view file
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 * @license The MIT License
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
<?php $this->renderPartial('//assesments/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<?php
 $this->breadcrumbs=array(
	Yii::t('app','Manage Fee Collection Particulars')=>array('fees'),
);
?>
<?php  
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('fee-collection-particulars-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('app','feeCollectionParticulars');?> </h1>
<br />


<div class="right">
  <!--  <input id="add_fee-collection-particulars" type="button" style="display:block; clear: both;"
           value="Create feeCollectionParticulars" class="client-val-form button">-->
   <?php echo CHtml::link(Yii::t('app','Create feeCollectionParticulars'), array('#'),array('id'=>'add_fee-collection-particulars','class'=>'cbut')) ?>
</div>

<?php
//Strings for the delete confirmation dialog.
$del_con = Yii::t('admin_fee-collection-particulars', 'Are you sure you want to delete this fee-collection-particulars?');
$del_title=Yii::t('admin_fee-collection-particulars', 'Delete Confirmation');
 $del=Yii::t('admin_fee-collection-particulars', 'Delete');
 $cancel=Yii::t('admin_fee-collection-particulars', 'Cancel');
   ?>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
         'id' => 'fee-collection-particulars-grid',
         'dataProvider' => $model->search(),
        /* 'filter' => $model,*/
		  'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	     'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
         'htmlOptions'=>array('class'=>'grid-view clear'),
          'columns' => array(
          		
		'name',
		'description',
		'amount',
		'finance_fee_collection_id',
		'student_category_id',
		/*
		'admission_no',
		'student_id',
		'is_deleted',
		'created_at',
		'updated_at',
		*/

    array(
                   'class' => 'CButtonColumn',
                    'buttons' => array(
                                                     'fee-collection-particulars_delete' => array(
                                                     'label' => Yii::t('admin_fee-collection-particulars', 'Delete'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/cross.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_del", 'title' => Yii::t('admin_fee-collection-particulars', 'Delete')), // HTML options for the button   tag
                                                      ),
                                                     'fee-collection-particulars_update' => array(
                                                     'label' => Yii::t('admin_fee-collection-particulars', 'Update'), // text label of the button
                                                     'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                     'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/pencil.png', // image URL of the button.   If not set or false, a text link is used
                                                     'options' => array("class" => "fan_update", 'title' => Yii::t('admin_fee-collection-particulars', 'Update')), // HTML options for the    button tag
                                                        ),
                                                     'fee-collection-particulars_view' => array(
                                                      'label' => Yii::t('admin_fee-collection-particulars', 'View'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/properties.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_view", 'title' => Yii::t('admin_fee-collection-particulars', 'View')), // HTML options for the    button tag
                                                        )
                                                    ),
                   'template' => '{fee-collection-particulars_view}{fee-collection-particulars_update}{fee-collection-particulars_delete}',
            ),
    ),
           'afterAjaxUpdate'=>'js:function(id,data){$.bind_crud()}'

                                            ));


   ?>
<script type="text/javascript">alert(1);
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
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars/returnView",
                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#fee-collection-particulars-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#fee-collection-particulars-grid").removeClass("ajax-sending");
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
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars/returnForm",
                data:{"update_id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#fee-collection-particulars-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#fee-collection-particulars-grid").removeClass("ajax-sending");
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
                                $.fn.yiiGridView.update('fee-collection-particulars-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars/index&feeCollectionParticulars[finance_fee_collection_id]=<?php echo $_REQUEST['feeCollectionParticulars']['finance_fee_collection_id'] ?>',data:{"feeCollectionParticulars_page":page}});
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
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars/ajax_delete",
                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                    beforeSend : function() {
                    $("#fee-collection-particulars-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#fee-collection-particulars-grid").removeClass("ajax-sending");
                },
                success: function(data) {
                    var res = jQuery.parseJSON(data);
                     var page=$("li.selected  > a").text();
                    $.fn.yiiGridView.update('fee-collection-particulars-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars',data:{"feeCollectionParticulars_page":page}});
                }//success
            });//ajax
        };//end of deletes

        dialogs[id] =
                        $('<div style="text-align:center;"></div>')
                        .html('<?php echo  $del_con; ?><br><br>' + '<h2 style="color:#999999">ID: ' + id + '</h2>')
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

    $('#add_fee-collection-particulars ').bind('click', function() {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars/returnForm",
            data:{"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>","id":"<?php echo $_REQUEST['feeCollectionParticulars']['finance_fee_collection_id'] ?>"},
                beforeSend : function() {
                    $("#fee-collection-particulars-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#fee-collection-particulars-grid").removeClass("ajax-sending");
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
                                $.fn.yiiGridView.update('fee-collection-particulars-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/feeCollectionParticulars&feeCollectionParticulars[finance_fee_collection_id]=<?php echo $_REQUEST['feeCollectionParticulars']['finance_fee_collection_id'] ?>',data:{"feeCollectionParticulars_page":page}});
                            } //onclosed function
                        });//fancybox
            } //success
        });//ajax
        return false;
    });//bind


})//document ready
    
</script>
</div>
    </td>
  </tr>
</table>
