<script>
$(document).ready(function() {
	

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

<div id="othleft-sidebar">
<!--<div class="lsearch_bar">
             	<input type="text" value="Search" class="lsearch_bar_left" name="">
                <input type="button" class="sbut" name="">
                <div class="clear"></div>
  </div>-->
<!--<a href="#enroll_process" id="enroll_p" class="menu_0">Set grading levels<span>Manage your Dashboard</span></a>-->
             <h1><?php echo Yii::t('app','Exam Management');?></h1>       
                    <?php
			function t($message, $category = 'cms', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
          
		  
		  
		  if(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)
		  {
			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					array('label'=>''.Yii::t('app','Set grading levels').'<span>'.Yii::t('app','Grading Levels for the').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</span>', 'url'=>array('/examination/gradingLevels','id'=>$_REQUEST['id'],) ,'linkOptions'=>array('id'=>'enroll_p','class'=>'gs_ico'),
                                   'active'=> ((Yii::app()->controller->id=='gradingLevels') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),
						                                
					
					
						array('label'=>Yii::t('app','Select').' '.Yii::app()->getModule("students")->labelCourseBatch().'<span>'.Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','and exam').'</span>', 'url'=>array('/examination/exam','id'=>$_REQUEST['id']),'linkOptions'=>array('class'=>'ne_ico'),'active'=> ((Yii::app()->controller->id=='exam') && (in_array(Yii::app()->controller->action->id,array('index'))) or (Yii::app()->controller->id=='exams') )  ? true : false),
						
						
						/*array('label'=>t('Connect Exams<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('/exam&id=3'),
							'active'=> ((Yii::app()->controller->id=='beterm') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false),'linkOptions'=>array('class'=>'messgnew_ico')),
		 
						array('label'=>''.t('Additional Exams<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('#') ,'linkOptions'=>array('class'=>'messgnew_ico'),
                                   'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ), 
							array('label'=>''.t('Exam Wise Report<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('#') ,'linkOptions'=>array('class'=>'messgnew_ico'),
                                   'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),
						array('label'=>''.t('Subject wise Report<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('#') ,'linkOptions'=>array('class'=>'messgnew_ico'),
                                   'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),
						array('label'=>''.t('Grouped exam Reports<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('#') ,'linkOptions'=>array('class'=>'messgnew_ico'),
                                   'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),
						array('label'=>''.t('Archived Student Reports<span>Lorem ipsum dolor sit amet,</span>'), 'url'=>array('#') ,'linkOptions'=>array('class'=>'messgnew_ico'),
                                   'active'=> ((Yii::app()->controller->id=='besite') && (in_array(Yii::app()->controller->action->id,array('index')))) ? true : false
					    ),*/
					
						
					
					
				),
			));?>
			
            <?php 

		  }
		  else
		  {
			?>
<ul>
<li>
<?php echo CHtml::ajaxLink(Yii::t('app','Set grading levels').'<span>'.Yii::t('app','Grading Levels for the').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</span>',array('/site/explorer','widget'=>'2','rurl'=>'examination/gradingLevels'),array('update'=>'#explorer_handler'),array('id'=>'explorer_gradingLevels','class'=>'gs_ico')); ?>
</li>



<li>
<?php echo CHtml::ajaxLink(Yii::t('app','Select').' '.Yii::app()->getModule("students")->labelCourseBatch().'<span>'.Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','and exam').'</span>',array('/site/explorer','widget'=>'2','rurl'=>'examination/exam'),array('update'=>'#explorer_handler'),array('id'=>'explorer_exam','class'=>'ne_ico')); ?>

</li>

</ul>

		 <?php  } 
		 //echo CHtml::ajaxLink('Explorer',array('/site/explorer'),array('update'=>'#explorer_handler'));
		 ?>
		  
		    <h1><?php echo Yii::t('app','Exam Results');?></h1>     
                <ul>
                 <li class="<?php if(Yii::app()->controller->id=='result') { echo "list_active"; } ?>" ><?php echo CHtml::link(Yii::t('app','Results').'<span>'.Yii::t('app','Search Results').'</span>',array('result/index'),array('class'=>'sbook_ico','active'=>(Yii::app()->controller->id=='result')));
?>
                    </li>  
                </ul>
                
                <h1><?php echo Yii::t('app','Grade Book');?></h1>     
                <ul>
                 <li class="<?php if(Yii::app()->controller->action->id=='gradebook') { echo "list_active"; } ?>"><?php echo CHtml::link(Yii::t('app','Grade book').'<span>'.Yii::t('app','View Grade book').'</span>',array('exam/gradebook'),array('class'=>'lbook_ico','active'=>(Yii::app()->controller->id=='exam')));
?>
                    </li>  
                </ul>
		</div>
        
    
    
    <div id="ajax-updated-region">
<?php //echo CHtml::link("name", array('/site/manage', 'xxx' => '', 'yyy' => '')); ?>
<?php //echo CHtml::link("number", array('/site/manage', 'xxx' => '', 'zzz' => '')); ?>
</div>
   

<!--<div id="enroll_process" style="display:none">

<script language="javascript">
function batch()
{
	var id= document.getElementById('batchdrop').value;
	window.location ='index.php?r=batches/batchstudents&id='+id;
}
</script>-->
<?php /*?><?php $data = CHtml::listData(Courses::model()->findAll(array('order'=>'course_name DESC')),'id','course_name');

echo 'Course';
echo CHtml::dropDownList('cid','',$data,
array('prompt'=>'-Select-',
'ajax' => array(
'type'=>'POST',
'url'=>CController::createUrl('Weekdays/batch'),
'update'=>'#batchdrop',
'data'=>'js:$(this).serialize()',
))); 
echo '&nbsp;&nbsp;&nbsp;';
echo 'Batch';

$data1 = CHtml::listData(Batches::model()->findAll(array('order'=>'name DESC')),'id','name');
 ?>
        
		<?php echo CHtml::dropDownList('batch_id','batch_id',$data1,array('empty'=>'-Select-','onchange'=>'batch()','id'=>'batchdrop')); ?><?php */?>

        <!--</div>-->
       
