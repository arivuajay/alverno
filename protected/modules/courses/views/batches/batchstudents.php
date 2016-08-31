<style>
.container {
	background:#FFF;
}
</style>
<?php
$batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
$this->breadcrumbs=array(
	Yii::t('app','Courses') =>array('/courses'),
	$batch->name,
);
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery');

//IMPORTANT about Fancybox.You can use the newest 2.0 version or the old one
//If you use the new one,as below,you can use it for free only for your personal non-commercial site.For more info see
//If you decide to switch back to fancybox 1 you must do a search and replace in index view file for "beforeClose" and replace with 
//"onClosed"
// http://fancyapps.com/fancybox/#license
// FancyBox2
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
// FancyBox
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
// Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.css','screen');
//JQueryUI (for delete confirmation  dialog)
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/js/jquery-ui-1.8.12.custom.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/css/dark-hive/jquery-ui-1.8.12.custom.css','screen');
///JSON2JS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');


//jqueryform js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/jquery.form.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/form_ajax_binding.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/client_val_form.css','screen');  ?>
<?php
Yii::app()->clientScript->registerScript(
	'myHideEffect',
	'$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
	CClientScript::POS_READY
);
?>
<?php 
$batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); 
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
$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
$is_inactive = PreviousYearSettings::model()->findByAttributes(array('id'=>8));
$is_active = PreviousYearSettings::model()->findByAttributes(array('id'=>7));
?>

<div style="background:#FFF;">
  <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td valign="top"><?php 
					if($batch!=NULL)
                    {
                    ?>
          <div style="padding:20px;">
            <div class="clear"></div>
            <div class="emp_right_contner">
              <div class="emp_tabwrapper">
                <?php $this->renderPartial('tab');?>
                <div class="clear"></div>
                <div class="emp_cntntbx" style="padding-top:10px;">
                  <?php
                                        if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
                                        {
                                        ?>
                  <div class="c_subbutCon" align="right" style="width:100%; height:40px; position:relative">
                    <div class="edit_bttns" style="top:0px; right:-6px">
                      <ul><?php
					if(ModuleAccess::model()->check('Students'))
					{ ?>
                        <li> <?php echo CHtml::link('<span>'.Yii::t('app','Add Student').'</span>', array('/students/students/create','bid'=>$_REQUEST['id']),array('class'=>'addbttn last'));?> </li>
			  <?php } ?>
                      </ul>
                      <div class="clear"></div>
                    </div>
                    <!-- END div class="edit_bttns" --> 
                  </div>
                  <!-- END div class="c_subbutCon" -->
                  <?php
                                        }
                                        ?>
                  <?php if(Yii::app()->user->hasFlash('success')):?>
                  <div class="info" style="color:#C30; width:800px; height:30px"> <?php echo Yii::app()->user->getFlash('success'); ?> </div>
                  <?php endif; ?>
                  <div class="table_listbx">
                    <?php
                                            if(isset($_REQUEST['id']))
                                            {
												
												/*$criteria = new CDbCriteria;
												$criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
												$criteria->params[':is_deleted'] = 0;
												$criteria->params[':is_active'] = 1;
												
												
												$batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id'],'result_status'=>0, 'status'=>1));
												if($batch_students)
												{
													$count = count($batch_students);
													$criteria->condition = $criteria->condition.' AND (';
													$i = 1;
													foreach($batch_students as $batch_student)
													{
														
														$criteria->condition = $criteria->condition.' id=:student'.$i;
														$criteria->params[':student'.$i] = $batch_student->student_id;
														if($i != $count)
														{
															$criteria->condition = $criteria->condition.' OR ';
														}
														$i++;
														
													}
													$criteria->condition = $criteria->condition.')';
												}
												else
												{
													$criteria->condition = $criteria->condition.' AND batch_id=:batch_id';
													$criteria->params[':batch_id'] = $_REQUEST['id'];
												}*/
												
												
												$posts=Yii::app()->getModule('students')->studentsOfBatch($_REQUEST['id']);
												//$posts=Students::model()->findAll("batch_id=:x and is_deleted=:y and is_active=:z", array(':x'=>$_REQUEST['id'],':y'=>'0',':z'=>'1'));
												if($posts!=NULL)
												{
												?>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr class="listbxtop_hdng">
                        <td ><?php echo Yii::t('app','Sl no.');?></td>
                        <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                { ?>
                                <td ><?php echo Yii::t('app','Student Name');?></td> <?php } ?>
                        <td ><?php echo Yii::t('app','Admission Number');?></td>
                        <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile'))
                                { ?>
                                <td ><?php echo Yii::t('app','Gender');?></td> <?php } ?>
                        <td ><?php echo Yii::t('app','Status');?></td>
                        <?php
							if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_insert->settings_value!=0 or $is_inactive->settings_value!=0))){
						?>
                        <td ><?php echo Yii::t('app','Actions');?></td>
                        <?php
							} ?>
                      </tr>
                      <?php
                       $i=0;
                      foreach($posts as $posts_1){
							$i++;
							echo '<tr>';
							echo '<td>'.$i.'</td>';	
                                                        if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                        {
                                                            $name='';
                                                            $name=  $posts_1->studentFullName('forStudentProfile');
							echo '<td>'.CHtml::link($name, array('/students/students/view', 'id'=>$posts_1->id)).'</td>';
                                                        }
							echo '<td>'.$posts_1->admission_no.'</td>';?>
                      <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile'))
                                { ?>
                            <td><?php
									if($posts_1->gender=='M'){
										echo Yii::t('app','Male');
									}elseif($posts_1->gender=='F'){
										echo Yii::t('app','Female');
									}?>
                            </td>
                                <?php } ?>
                        	<td><?php
									$this_batch = BatchStudents::model()->findByAttributes(array('student_id'=>$posts_1->id,'batch_id'=>$_REQUEST['id']));
									if($this_batch->status == 1){
										echo Yii::t('app','In Progress');
									}else{
										$status = PromoteOptions::model()->findByAttributes(array('option_value'=>$this_batch->result_status));
										echo $status->option_name;
									}
								?>
                            </td>
                        	<?php
							   if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_insert->settings_value!=0 or $is_inactive->settings_value!=0))){
							?>
                        	<td>
                             <div style="position:absolute;">
                            	<div  id="<?php echo $i; ?>" class="act_but"> <?php echo Yii::t('app','Actions');?> </div>
                            	<div class="act_drop" id="<?php echo $i.'x'; ?>">
                                <div class="but_bg_outer"> </div>
                                <div class="but_bg"><div  id="<?php echo $i; ?>" class="act_but_hover"> <?php echo Yii::t('app','Actions');?> </div></div>
                                <ul>
									<?php 
                                    if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
                                    {
                                    ?>
                                    <li class="add"> 
										<?php echo CHtml::link(Yii::t('app','Add Leave').'<span>'.Yii::t('app','Add leave for this student').'</span>', 
                                            array('#'),array('class'=>'addevnt','name' => $posts_1->id,'id'=>'add_leave')) ?> 
                                    </li>
                                <?php } ?>
                                <?php /*?><li class="add">
								<?php echo CHtml::link(Yii::t('app','Add Elective').'<span>'.Yii::t('app','for add leave').'</span>', 
										array('#'),array('class'=>'addevntelect','name' => $posts_1->id,'id'=>'add_elective')) ?>
								</li><?php */?>
                                <?php if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_inactive->settings_value!=0)){ ?>											
                                			<li class="delete"> 
											<?php echo CHtml::link(Yii::t('app','Make Inactive').'<span>'.Yii::t('app','Make this student inactive').'</span>', 
											array('/students/students/inactive', 'sid'=>$posts_1->id,'id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure you want to deactivate this student?'))) ?> 
                                            </li>
                                <?php
																			}
																			?>
                                <!--<li class="edit"><a href="#">Edit Leave<span>for add leave</span></a></li>
                                                                            <li class="delete"><a href="#">Delete Leave<span>for add leave</span></a></li>
                                                                            <li class="add"><a href="#">Add Fees<span>for add leave</span></a></li>
                                                                            <li class="add"><a href="#">Add Report<span>for add leave</span></a></li>-->
                              </ul>
                            </div>
                            <div class="clear"></div>
                            <div id="<?php echo $posts_1->id ?>"></div>
                          </div></td>
                        <?php
																}
																?>
                      </tr>
                      <?php 
														} // END foreach($posts as $posts_1)
                                                        ?>
                    </table>
                    <?php    	
												} // END if $posts!=NULL
												else
												{
													echo '<br><div class="notifications nt_red" style="padding-top:10px">'.'<i>'.Yii::t('app','There are no active students in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</i></div>'; 
													
												}
												
                                            } // END if isset($_REQUEST['id'])
                                            ?>
                  </div>
                  <!-- END div class="table_listbx" --> 
                  <br />
                  <h3><?php echo Yii::t('app','Inactive Students');?></h3>
                  <?php
                                        if(isset($_REQUEST['id']))
                                        {
											
											$criteria = new CDbCriteria;
											$criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
											$criteria->params[':is_deleted'] = 0;
											$criteria->params[':is_active'] = 0;
											
											
											$batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id']));
											if($batch_students)
											{
												$count = count($batch_students);
												$criteria->condition = $criteria->condition.' AND (';
												$i = 1;
												foreach($batch_students as $batch_student)
												{
													
													$criteria->condition = $criteria->condition.' id=:student'.$i;
													$criteria->params[':student'.$i] = $batch_student->student_id;
													if($i != $count)
													{
														$criteria->condition = $criteria->condition.' OR ';
													}
													$i++;
													
												}
												$criteria->condition = $criteria->condition.')';
											}
											else
											{
												$criteria->condition = $criteria->condition.' AND batch_id=:batch_id';
												$criteria->params[':batch_id'] = $_REQUEST['id'];
											}											
											
											$posts=Yii::app()->getModule('students')->studentsOfBatch($_REQUEST['id'],0);
											
											//$posts=Students::model()->findAll("batch_id=:x and is_deleted=:y and is_active=:z", array(':x'=>$_REQUEST['id'],':y'=>'0',':z'=>'0'));
											if($posts!=NULL)
											{
											?>
                  <div class="table_listbx">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr >
                        <td class="listbx_subhdng"><?php echo Yii::t('app','Sl no.');?></td>
                        <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                { ?>
                                <td class="listbx_subhdng"><?php echo Yii::t('app','Student Name');?></td> <?php } ?>
                        <td class="listbx_subhdng"><?php echo Yii::t('app','Admission Number');?></td>
                        <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile'))
                        { ?>
                        <td class="listbx_subhdng"><?php echo Yii::t('app','Gender');?></td>
                        <?php } ?>
                        <?php
															if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_active->settings_value!=0 or $is_delete->settings_value!=0)))
															{
															?>
                        <td class="listbx_subhdng"><?php echo Yii::t('app','Actions');?></td>
                        <?php
															}
															?>
                      </tr>
                      <?php
                                                        $j=$i;
                                                        $i=0;
                                                        foreach($posts as $posts_1)
                                                        {
                                                            $i++;
                                                            $j++;
                                                            echo '<tr>';
                                                                    echo '<td>'.$i.'</td>';	
                                                                    if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                                    {
                                                                        $name='';
                                                                        $name=  $posts_1->studentFullName('forStudentProfile');
                                                                        echo '<td>'.CHtml::link($name, array('/students/students/view', 'id'=>$posts_1->id)).'</td>';
                                                                    }
                                                                    echo '<td>'.$posts_1->admission_no.'</td>';?>
                      <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile'))
                                { ?>
                        <td><?php
                                                                    if($posts_1->gender=='M')
                                                                    {
                                                                      echo Yii::t('app','Male');
                                                                    }
                                                                    elseif($posts_1->gender=='F')
                                                                    {
                                                                      echo Yii::t('app','Female');
                                                                    }
																	?>
                                </td> <?php } ?>
                        <?php
							if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_active->settings_value!=0 or $is_delete->settings_value!=0))){
						?>
                        <td ><div style="position:absolute;">
                            <div  id="<?php echo $j; ?>" class="act_but"> <?php echo Yii::t('app','Actions');?> </div>
                            <div class="act_drop" id="<?php echo $j.'x'; ?>">
                              <div class="but_bg_outer"></div>
                              <div class="but_bg">
                                <div  id="<?php echo $j; ?>" class="act_but_hover"> <?php echo Yii::t('app','Actions');?> </div>
                              </div>
                              <ul>
                                <?php
									if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_active->settings_value!=0)){
								?>
                                	<li class="edit">
                                        <?php echo CHtml::link(Yii::t('app','Make Active').'<span>'.Yii::t('app','Make this student active').'</span>', 
										array('/students/students/active', 'sid'=>$posts_1->id,'id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure you want to make this student active?'))) ?> 
                                    </li>
                                <?php } ?>
                                <?php
									if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0)){
								?>
                                		<li class="delete"> 
											<?php echo CHtml::link(Yii::t('app','Delete').'<span>'.Yii::t('app','for deleting').'</span>', 
											array('/students/students/deletes', 'sid'=>$posts_1->id,'id'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are you sure you want to delete this student?'))) ?> 
                                        </li>
                                <?php } ?>
                              </ul>
                            </div>
                            <div class="clear"></div>
                            <div id="<?php echo $posts_1->id ?>"></div>
                          </div></td>
                        <?php }	?>
                      </tr>
                      <?php } // END foreach($posts as $posts_1) ?>
                    </table>
                  </div>
                  <!-- END div class="table_listbx" -->
                  <?php    	
					} // END if $posts!=NULL
					else{
						echo '<br><div class="notifications nt_red" style="padding-top:10px">'.'<i>'.Yii::t('app','There are no inactive students in this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!'.'</i></div>';       
					}
               } // END if isset($_REQUEST['id'])
             ?>
                </div>
                <!-- END div class="emp_cntntbx" --> 
              </div>
              <!-- END div class="emp_tabwrapper" --> 
            </div>
            <!-- END div class="emp_right_contner" --> 
          </div>
          <?php    	
                    }
                    else
                    {
						echo '<div class="emp_right" style="padding-left:20px; padding-top:50px;">';
							echo '<div class="notifications nt_red">'.'<i>'.Yii::t('app','Nothing Found!!').'</i></div>'; 
						echo '</div>';
                    }
                    ?></td>
      </tr>
    </tbody>
  </table>
</div>
<script>
//CREATE 

$('.addevnt').bind('click', function() {var id = $(this).attr('name');
	$.ajax({
		type: "POST",
		url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=students/studentLeave/returnForm",
		data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
			beforeSend : function() {
				$("#"+$(this).attr('name')).addClass("ajax-sending");
			},
			complete : function() {
				$("#"+$(this).attr('name')).removeClass("ajax-sending");
			},
		success: function(data) {
			$.fancybox(data,
					{    "transitionIn"      : "elastic",
						"transitionOut"   : "elastic",
						"speedIn"                : 600,
						"speedOut"            : 200,
						"overlayShow"     : false,
						"hideOnContentClick": false,
						"afterClose":    function() {window.location.reload();} //onclosed function
					});//fancybox
		} //success
	});//ajax
	return false;
});//bind



/*//CREATE 


 $('.addevntelect').bind('click', function() {var id = $(this).attr('name');
	$.ajax({
		type: "POST",
	   url: "<?php //echo Yii::app()->request->baseUrl;?>/index.php?r=courses/electiveGroups/returnForm",
		data:{"batch_id":<?php //echo $_GET['id'];?>,"YII_CSRF_TOKEN":"<?php //echo Yii::app()->request->csrfToken;?>"},
			beforeSend : function() {
				$("#"+$(this).attr('name')).addClass("ajax-sending");
			},
			complete : function() {
				$("#"+$(this).attr('name')).removeClass("ajax-sending");
			},
		success: function(data) {
			$.fancybox(data,
					{    "transitionIn"      : "elastic",
						"transitionOut"   : "elastic",
						"speedIn"                : 600,
						"speedOut"            : 200,
						"overlayShow"     : false,
						"hideOnContentClick": false,
						"afterClose":    function() {window.location.reload();} //onclosed function
					});//fancybox
		} //success
	});//ajax
	return false;
});//bind*/


</script> 
