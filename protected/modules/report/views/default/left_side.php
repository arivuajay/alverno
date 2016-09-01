<div id="othleft-sidebar">
             <!--<div class="lsearch_bar">
             	<input type="text" value="Search" class="lsearch_bar_left" name="">
                <input type="button" class="sbut" name="">
                <div class="clear"></div>
  </div>-->    <h1><?php echo Yii::t('app','Manage Reports');?></h1>   
                    <?php
			function t($message, $category = 'cms', $params = array(), $source = null, $language = null) 
{
    return $message;
}

			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					
						    
					
						array('label'=>Yii::t('app','Advanced Report').'<span>'.Yii::t('app','Student advanced report').'</span>', 'url'=>array('/report/default/advancedreport'),'linkOptions'=>array('class'=>'abook_ico'),'active'=> (Yii::app()->controller->action->id=='advancedreport')),
		  				 array('label'=>''.'<h1>'.Yii::t('app','Assessment Report').'</h1>'), 
					
						array('label'=>Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Assessment Report').'<span>'.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','wise assessment report').'</span>', 'url'=>array('/report/default/assessment'),'active'=>(Yii::app()->controller->action->id=='assessment' ? true : false),'linkOptions'=>array('class'=>'ar_ico')),
						array('label'=>Yii::t('app','Student Assessment Report').'<span>'.Yii::t('app','Student assessment').'</span>', 'url'=>array('/report/default/studentexam'),'active'=>(Yii::app()->controller->action->id=='studentexam' ? true : false),'linkOptions'=>array('class'=>'sa_ico')),
						array('label'=>''.'<h1>'.Yii::t('app','Attendance Report').'</h1>'),
						
						
						array('label'=>Yii::t('app','Teacher Attendance').'<span>'.Yii::t('app','Teacher attendance report').'</span>', 'url'=>array('/report/default/employeeattendance'),'active'=>(Yii::app()->controller->action->id=='employeeattendance' ? true : false),'linkOptions'=>array('class'=>'sm_ico')),
						array('label'=>Yii::t('app','Student Attendance').'<span>'.Yii::t('app','Student attendance report').'</span>', 'url'=>array('/report/default/studentattendance'),'active'=>(Yii::app()->controller->action->id=='studentattendance' ? true : false),'linkOptions'=>array('class'=>'md_ico')),
						array('label'=>Yii::t('app','Attendance Percentage Reminder').'<span>'.Yii::t('app','Attendance percentage report').'</span>', 'url'=>array('/report/default/reminder'),'active'=>(Yii::app()->controller->action->id=='reminder' or Yii::app()->controller->id=='notification' ? true : false),'linkOptions'=>array('class'=>'aroot_ico')),
						
				),
			)); ?>
		
        
		</div>
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