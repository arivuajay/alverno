<style>
#othleft-sidebar ul li{
	position:relative;
}
.count{
	position:absolute;
	top:13px;
	right:19px;
	min-width:40px;
	padding:5px 0px !important;
	background-color:#405875;
	color:#FFF !important;
	text-align:center;
	font-size:12px;
	-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
}
</style>
<div id="othleft-sidebar">
<!--<div class="lsearch_bar">
             	<input type="text" name="" class="lsearch_bar_left" value="Search">
                <input type="button" name="" class="sbut">
                <div class="clear"></div>
  </div>-->
          <h1><?php echo Yii::t('app','Manage Students');?></h1>          
        <?php	
			$academic_yr = OnlineRegisterSettings::model()->findByAttributes(array('id'=>2)); 
			$countof_student_pendinglist = RegisteredStudents::model()->findAllByAttributes(array('status'=>0,'is_completed'=>3,'academic_yr'=>$academic_yr->config_value));							
			function t($message, $category = 'cms', $params = array(), $source = null, $language = null) 
			{
				return $message;
			}

			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					array('label'=>''.Yii::t('app','Students List').'<span>'.Yii::t('app','All Students Details').'</span>', 'url'=>array('students/manage') ,'linkOptions'=>array('class'=>'vsd_ico'),
                                   'active'=> ((Yii::app()->controller->id=='students') && (in_array(Yii::app()->controller->action->id,array('manage')))) ? true : false
					    ),                               
					array('label'=>''.Yii::t('app','Create New Student').'<span>'.Yii::t('app','New Admission').'</span>',  'url'=>array('students/create') ,'linkOptions'=>array('class'=>'sl_ico' ),'active'=> ((Yii::app()->controller->action->id=='create' and  Yii::app()->controller->id=='stduents') or Yii::app()->controller->id=='studentPreviousDatas' or Yii::app()->controller->id=='studentAdditionalFields'), 'itemOptions'=>array('id'=>'menu_1') 
					       ),
						    array('label'=>''.Yii::t('app','Manage Log Category').'<span>'.Yii::t('app','Manage Student Log Category').'</span>',  'url'=>array('/students/logCategory') ,'linkOptions'=>array('class'=>'vsd_ico' ),'active'=> (Yii::app()->controller->id=='logCategory'), 'itemOptions'=>array('id'=>'menu_1') 
					       ),
						   	array('label'=>Yii::t('app','Manage Student Category').'<span>'.Yii::t('app','Manage Students Category').'</span>', 'url'=>array('/students/studentCategory'),'linkOptions'=>array('class'=>'sm_ico' ),'active'=> (Yii::app()->controller->id=='studentCategory'),),
						   array('label'=>''.t('<h1>'.Yii::t('app','Manage Guardians').'</h1>')),
			
						array('label'=>''.Yii::t('app','List Guardians').'<span>'.Yii::t('app','All Guardians Details').'</span>', 'url'=>array('guardians/admin'),'active'=> ((Yii::app()->controller->id=='guardians') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false),'linkOptions'=>array('id'=>'menu_2','class'=>'lbook_ico')),
						array('label'=>''.t('<h1>'.Yii::t('app','Online Registration').'</h1>')),
							array('label'=>Yii::t('app','Online Applicants').'<span>'.Yii::t('app','Manage Online Registrations').'</span>', 'url'=>array('/onlineadmission/admin/onlineapplicants'),'linkOptions'=>array('class'=>'sm_ico' ),'active'=> ((Yii::app()->controller->id=='admin') && (in_array(Yii::app()->controller->action->id,array('onlineapplicants','view','profileedit'))) ? true : false),'linkOptions'=>array('id'=>'menu_3','class'=>'bbook_ico')),
							array('label'=>Yii::t('app','Student Approval').'<span class="count">'.count($countof_student_pendinglist).'</span><span>'.Yii::t('app','Approve Online Registrations').'</span>', 'url'=>array('/onlineadmission/admin/approval'),'linkOptions'=>array('class'=>'sm_ico' ),'active'=> ((Yii::app()->controller->id=='admin' && in_array(Yii::app()->controller->action->id,array('approval')))  ? true : false),'linkOptions'=>array('id'=>'menu_3','class'=>'set_dw_ico')),
							array('label'=>Yii::t('app','Waiting List').'<span>'.Yii::t('app','Manage Waiting List').'</span>', 'url'=>array('/onlineadmission/waitinglistStudents/list'),'linkOptions'=>array('class'=>'sm_ico' ),'active'=> ((Yii::app()->controller->id=='waitinglistStudents')  ? true : false),'linkOptions'=>array('id'=>'menu_3','class'=>'sa_ico')),
							array('label'=>''.t('<h1>'.Yii::t('app','Student Leave Management').'</h1>')),
						array('label'=>Yii::t('app','Add Leave Type').'<span>'.Yii::t('app','Manage Leave Type').'</span>', 'url'=>array('/students/studentLeaveTypes'),'linkOptions'=>array('class'=>'abook_ico'),'active'=> (Yii::app()->controller->id=='studentLeaveTypes')),
							
						
						/*array('label'=>t('Create New Guardian'), 'url'=>'#',
							'active'=> ((Yii::app()->controller->id=='guardians') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)                                                                                           
						      ),
							  array('label'=>t('Associate Guardian'), 'url'=>'#',
							'active'=> ((Yii::app()->controller->id=='guardians') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)                                                                                           
						      ),*/
						                                                                                    
					    
					    
					       
					    
					/*array('label'=>''.t('Attendance Management<span>Manage your Dashboard</span>'), 'url'=>'javascript:void(0);','linkOptions'=>array('id'=>'menu_3','class'=>'menu_3'), 'itemOptions'=>array('id'=>'menu_3'),
					       'items'=>array(
						array('label'=>t('Attendance Register'), 'url'=>'#'),
						array('label'=>t('Attendance Report'), 'url'=>'#',
								'active'=> ((Yii::app()->controller->id=='bemenu') && (in_array(Yii::app()->controller->action->id,array('update','view','admin','index'))) ? true : false)),
						
						
					    )),*/
						 
					
					
						//array('label'=>t('Manage Additional Fields'), 'url'=>'#','active'=>Yii::app()->controller->id=='studentCategories' ? true : false),
						
						
						//array('label'=>'Like/Rating', 'url'=>array('/like/admin')),
						//array('label'=>'Survey', 'url'=>array('/survey/admin')),
						     
						
					  
					
					
				),
			)); 
			
			/*echo CHtml::ajaxLink(
	'Students',          // the link body (it will NOT be HTML-encoded.)
	array('/site/explorer'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
	array(
		'update'=>'#explorer_handler'
	)
);?>

        <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'name'=>'name',
						  'id'=>'name_widget',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>'Student Name'),
						  'options'=>
							 array(
								   'showAnim'=>'fold',
								   'select'=>"js:function(student, ui) {
									  $('#id_widget').val(ui.item.id);
									 
											 }"
									),
					
						));
						 ?>
        <?php echo CHtml::hiddenField('student_id','',array('id'=>'id_widget')); ?>
		<?php echo CHtml::ajaxLink('[][][]',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name'));?>
		
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
*/
