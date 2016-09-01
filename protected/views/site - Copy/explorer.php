	 <!-- Begin Coda Stylesheets -->

   
    <?php

Yii::app()->clientScript->registerScript('ajax-link-handler-main', "
$('#main_tab_students').live('click', function(event){
        $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
					    $('#user_panel_handler').hide();
						$('#batch_panel_handler').hide();
                        $('#student_panel_handler').html(data).show();
						
						
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler-main-teacher', "
$('#main_tab_teachers').live('click', function(event){
        $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
					    $('#student_panel_handler').hide();
						$('#batch_panel_handler').hide();
                        $('#user_panel_handler').html(data).show();
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler-main-batch', "
$('#main_tab_batches').live('click', function(event){
        $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
					    $('#student_panel_handler').hide();
						$('#user_panel_handler').hide();
                        $('#batch_panel_handler').html(data).show();
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler', "
$('#filter_action a').live('click', function(event){
        $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
                        $('#student_panel_handler').html(data);
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler-user', "
$('#userfilter_action a').live('click', function(event){
        $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
                        $('#user_panel_handler').html(data);
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler2', "
$('#loaddrop_link a').live('click', function(event){
	   $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
                        $('#student_panel_handler').html(data);
						
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler2-user', "
$('#userloaddrop_link a').live('click', function(event){
	   $.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
                        $('#user_panel_handler').html(data);
						
                }
        });
        event.preventDefault();
});
");





Yii::app()->clientScript->registerScript('ajax-link-handler1', "
$('#student_div a').live('click', function(event){
	$.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
					var label = data.split('@#$`')[0];
					var id = data.split('@#$`')[1];
					
                        $('#name_widget').val(label);
						$('#id_widget').val(id);
						$('#explorer_handler').html('');
						
						
						
                }
        });
        event.preventDefault();
});
");

Yii::app()->clientScript->registerScript('ajax-link-handler1-user', "
$('#user_div a').live('click', function(event){
	$.ajax({
                'type':'get',
                'url':$(this).attr('href'),
                'dataType': 'html',
                'success':function(data){
					var label = data.split('@#$`')[0];
					var id = data.split('@#$`')[1];
					
                        $('#name_widget').val(label);
						$('#id_widget').val(id);
						$('#explorer_handler').html('');
						
						
						
                }
        });
        event.preventDefault();
});
");

?>
<?php
	$setup_stu	=	false;
	$setup_emp	=	false;
	$setup_cou	=	false;
	$setup_fee	=	false;
	$setup_tim	=	false;
	$setup_lib	=	false;
	$setup_hos	=	false;
	$setup_tra	=	false;
	$setups		=	0;
	$exp_stu	=	Students::model()->findAll();
	$exp_emp	=	Employees::model()->findAll();
	$exp_cou	=	Courses::model()->findAll();
	$exp_fee	=	FeeCategories::model()->findAll();
	$exp_tim	=	TimetableEntries::model()->findAll();
	Yii::app()->getModule('library');
	$exp_lib	=	Book::model()->findAll();
	Yii::app()->getModule('hostel');
	$exp_hos	=	Hosteldetails::model()->findAll();
	Yii::app()->getModule('transport');
	$exp_tra	=	RouteDetails::model()->findAll();
	if(count($exp_stu)){
		$setup_stu	=	true;
		$setups++;
	}
	if(count($exp_emp)){
		$setup_emp	=	true;
		$setups++;
	}
	if(count($exp_cou)){
		$setup_cou	=	true;
		$setups++;
	}
	if(count($exp_fee)){
		$setup_fee	=	true;
		$setups++;
	}
	if(count($exp_tim)){
		$setup_tim	=	true;
		$setups++;
	}
	if(count($exp_lib)){
		$setup_lib	=	true;
		$setups++;
	}
	if(count($exp_hos)){
		$setup_hos	=	true;
		$setups++;
	}
	if(count($exp_tra)){
		$setup_tra	=	true;
		$setups++;
	}
	$percent	=	ceil(($setups/8)*100);
?>

<div class="site_drrop">
	<div class="sd_left">
   	  <div class="sd_left_loader">
      	<p><?php echo Yii::t('app','Set Up :')?> <span><?php echo $percent.'%'?></span> <?php echo Yii::t('app','Setup Completed')?></p>
        <div class="loader_bg">
        	<div style="width:<?php echo $percent.'%'?>; height:7px; background:none repeat scroll 0 0 #fdc93e; border:1px solid #fdc93e;"></div>
        </div>
      </div>
        <div class="sd_nav">
        <ul><?php
        	if(ModuleAccess::model()->check('Students')){ ?><li <?php if($setup_stu==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Students'), array('/students')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Employees')){ ?><li <?php if($setup_emp==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Teachers'), array('/employees')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Courses')){ ?><li <?php if($setup_cou==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Courses'), array('/courses')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Fees')){ ?><li <?php if($setup_fee==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Fees'), array('/fees')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Timetable')){ ?><li <?php if($setup_tim==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Timetable'), array('/timetable')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Library')){ ?><li <?php if($setup_lib==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Library'), array('/library')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Hostel')){ ?><li <?php if($setup_hos==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Hostel'), array('/hostel')); ?></li><?php } ?>
   <?php  	if(ModuleAccess::model()->check('Transport')){ ?><li <?php if($setup_tra==true){?>class="completed"<?php }?>><?php echo CHtml::link(Yii::t('app','Transport'), array('/transport')); ?></li><?php } ?>
        </ul>
        </div>
    </div>
    <div class="sd_right">
    <div class="sd_but_con">
        	<ul>
            	<li style="padding:0px 0 0 10px;"><a href="#" class="cancel_but"></a></li>
            	<!--<li><input name="" type="button" class="sdbtm_but" value="Select" /></li>-->
            </ul>
        </div>
    	<!-- Coda Sliders-->
        
        <div class="">
        <div class="" id="main_tab" >
        
        <?php 
		if((!isset($_REQUEST['widget'])) or (isset($_REQUEST['widget']) and $_REQUEST['widget']!=NULL and ($_REQUEST['widget']=='1' or $_REQUEST['widget']=='s_a' or $_REQUEST['widget']=='sub_att'))) 
		{
		echo CHtml::link(Yii::t('app','Students'),array('/site/manage','val' =>'A'),array('id'=>'main_tab_students'));
		}
		?>
        
         <?php 
		 if(!isset($_REQUEST['widget']))
	     {
		 echo CHtml::link(Yii::t('app','Teachers'),array('/site/emanage','val' =>'A'),array('id'=>'main_tab_teachers'));
		 }
		 ?>
         
         <?php 
		 if((!isset($_REQUEST['widget'])) or (isset($_REQUEST['widget']) and $_REQUEST['widget']!=NULL and $_REQUEST['widget']!=1))
		 { 
		 echo CHtml::link(Yii::t('app','Batches'),array('/site/bmanage'),array('id'=>'main_tab_batches'));
		 }
		 ?>
        </div>
	<div class="" id="">
    
        
        <?php if((!isset($_REQUEST['widget'])) or (isset($_REQUEST['widget']) and $_REQUEST['widget']!=NULL and ($_REQUEST['widget']=='1' or $_REQUEST['widget']=='s_a' or $_REQUEST['widget']=='sub_att'))) 
		{	
		?>
    <div class="" id="student_panel_handler" >
    <?php 
	    $model=new Students;
		$criteria = new CDbCriteria;
		$criteria->order = 'first_name ASC';
		$_REQUEST['val'] = 'A';
		$criteria->condition='first_name LIKE :match AND is_deleted=:is_del';
		$criteria->params = array(':match' => $_REQUEST['val'].'%',':is_del'=>0);
		$total = Students::model()->count($criteria);
		$posts = Students::model()->findAll($criteria);
		
		?>
		<?php  $this->renderPartial('student_panel',array('model'=>$model,'list'=>$posts,
			
			'item_count'=>$total,'name'=>'','ad'=>'','bat'=>'',
			
			)
		);
	 ?>
        
    </div>
			<?php	} ?>
    
    
    
		<div class="" id="user_panel_handler">
			
		</div>
        
		<div class=""  id="batch_panel_handler">
        <?php if(isset($_REQUEST['widget']) and $_REQUEST['widget']!=NULL and $_REQUEST['widget']==2)
		{ 
		?>
		
        
        <?php  $this->renderPartial('batch_panel',array()) ; ?>
			
		
  <?php 		
		}?></div>
        
	</div><!-- .coda-slider -->
    <div class="clear"></div>
</div>
    	
        
    </div>
</div>

<script>
$(document).ready(function() {

		
  $(".site_drrop").animate({
    top: "50px",
    left: "105px",
  }, 200 );

$(".cancel_but").click(function(){
	$(".body_overlay").hide();
  $(".site_drrop").animate({
    top: "-580px",
    left: "105px",
  }, 200 );
});

});
</script>

<!--small drop-->
 <script>
$(document).ready(function() {
$(".sd_action_but").click(function(){
	
            	if ($(".sd_actions").is(':hidden')){
                	$(".sd_actions").show();
					$(".sd_action_but").addClass("sd_action_but_active");

				}
            	else{
                	$(".sd_actions").hide();
					$(".sd_action_but").removeClass("sd_action_but_active");
            	}
            return false;
       			 });
				  $('.sd_actions').click(function(e) {
            		e.stopPropagation();
					
        			});
        		$(document).click(function() {
					if (!$(".sd_actions").is(':hidden')){
            		$('.sd_actions').hide();
					$(".sd_action_but").removeClass("sd_action_but_active");
					}
        			});	
                
});
</script>
<script>
$(document).ready(function() {
	$("#exptxtsrh").keyup(function(){
		var text = $("#exptxtsrh").val();
		if ($("#exptxtsrh").val()==''){$("#expli").hide("slide", { direction: "left" }, 100);return;}
		if ($("#expli").is(':hidden')){
                	//$("#expli").show();
					$('#espname').html(text);
					$("#expli").show("slide", { direction: "left" }, 100);

					$('#espname').html(text);
				}
            	else{
                	$('#espname').html(text);
            	}
		
		 });
});
</script> 




     

