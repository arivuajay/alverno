<?php
$this->breadcrumbs=array(
Yii::t('app','Students')=>array('index'),
Yii::t('app','Courses'),
);


?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('profileleft');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
           
                <!--<div class="searchbx_area">
                <div class="searchbx_cntnt">
                <ul>
                <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                <li><input class="textfieldcntnt"  name="" type="text" /></li>
                </ul>
                </div>
                </div>-->
                <h1 style="margin-top:.67em;">
					<?php 
						echo Yii::t('app','Student Profile :').' ';
						if(FormFields::model()->isVisible("fullname", "Students", 'forStudentProfile')){
							echo $model->studentFullName('forStudentProfile');
						} 
					?><br />
				</h1>
                <div class="edit_bttns last">
                    <ul>
                        <li>
                        	<?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('update', 'id'=>$model->id,'status'=>1),array('class'=>' edit ')); ?>
                        </li>
                        <li>
                        	<?php echo CHtml::link('<span>'.Yii::t('app','Students').'</span>', array('students/manage'),array('class'=>'edit last'));?>
                        </li>
                    </ul>
                </div> <!-- END div class="edit_bttns last" -->
                <div class="clear"></div>
                
                <div class="emp_right_contner">
                 	<?php
					// Display Success Flash Messages 
					Yii::app()->clientScript->registerScript(
					   'myHideEffect',
					   '$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
					   CClientScript::POS_READY
					);
					?>
					<?php
					if(Yii::app()->user->hasFlash('successMessage')): 
					?>
					<div class="flashMessage" style="background:#FFF; color:#C00; padding-left:200px; top:150px;">
						<?php echo Yii::app()->user->getFlash('successMessage'); ?>
					</div>
					<?php
					endif;
					// END Display Success Flash Messages
					?>
                    
                    <?php
					// Display Error Flash Messages
					if(Yii::app()->controller->action->id=='document')
					{
					?>
						<?php
						if(Yii::app()->user->hasFlash('errorMessage')): 
						?>
						<div class="flashMessage" style="background:#FFF; color:#C00; padding-left:200px; top:150px;">
							<?php echo Yii::app()->user->getFlash('errorMessage'); ?>
						</div>
						<?php
						endif;
						// END Display Error Flash Messages
					}
                    ?>
                    
                    
                    <div class="emp_tabwrapper">
						<?php $this->renderPartial('tab');?>
                        <div class="clear"></div>
                        <div class="emp_cntntbx">
                            <div class="tableinnerlist">
                            	<table width="100%" cellpadding="0" cellspacing="0">
                                	<tr>
                                    	<th><?php echo Yii::t('app','Sl No');?></th>
                                        <th><?php echo Yii::t('app','Academic Year');?></th>
                                       <?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile')){ ?>
                                        <th> <?php echo Yii::app()->getModule("students")->labelCourseBatch();
										?></th>
                                        <?php } ?>
                                        <th><?php echo Yii::t('app','Status');?></th>
                                        <th><?php echo Yii::t('app','Action');?></th>
                                    </tr>
                                    <?php
                                        $batches = BatchStudents::model()->findAllByAttributes(array('student_id'=>$model->id),array('order'=>'id DESC'));
                                        
                                        $sl_no = 1;
                                        foreach($batches as $batch)
                                        {
                                        ?>
                                    	<tr>
                                        	<td>
                                            	<?php echo $sl_no; ?>
                                            </td>
                                        	<td>
                                            	<?php
                                            	$academic_year = AcademicYears::model()->findByAttributes(array('id'=>$batch->academic_yr_id));
												echo $academic_year->name;
												?>
                                            </td>
                                            <?php
												if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile')){?>
                                            <td>
                                            <?php	
                                            	$batch_name = Batches::model()->findByAttributes(array('id'=>$batch->batch_id,'is_active'=>1));
						if($batch_name->name!="")
                                                {
                                                    echo $batch_name->course123->course_name.' / '.$batch_name->name;
                                                }
                                                else {
                                                echo "-"; }
												?>
                                            </td>
                                            <?php } ?>
                                          <?php /*?>  <td>
                                            	<?php
												if($batch_name->start_date > date("d-m-y")){
													echo 'Starts on : '.date("d-m-y",strtotime($batch_name->start_date));
												}
												else{
												$status = PromoteOptions::model()->findByAttributes(array('option_value'=>$batch->result_status));
												echo $status->option_name;
												}
												?>
                                            </td><?php */?>
                                              <td>
                                            	<?php
												if($batch_date->start_date > date("Y-m-d h:i:sa")){
													
                           echo Yii::t('app','Starts on :').' <span style="color:#0000FF">'.date("d-M-Y",strtotime($batch_date->start_date));?></span><?php
												}
												else{
													$status = PromoteOptions::model()->findByAttributes(array('option_value'=>$batch->result_status));
													if($batch->result_status == 1)
														$status_print = '<span style="color:#006633">'.Yii::t('app',$status->option_name).'</span>';
													if($batch->result_status == -1)
														$status_print = '<span style="color:#FF0000">'.Yii::t('app',$status->option_name).'</span>';
													if($batch->result_status == 0)
														$status_print = '<span style="color:#006633">'.Yii::t('app',$status->option_name).'</span>';	
													if($batch->result_status == 2)
														$status_print = '<span style="color:#0000FF">'.Yii::t('app',$status->option_name).'</span>';
													if($batch->result_status == 3)
														$status_print = '<span style="color:#0000FF">'.Yii::t('app','Previous').'</span>';		
													echo $status_print;
												}
												?>
                                            </td>
                                            <td>
                                                <?php                                            
                                                $student_model= Students::model()->findByPk($_REQUEST['id']);                                               
                                                if($student_model->batch_id!= $batch->batch_id)
                                                {
                                                    echo CHtml::ajaxLink(Yii::t('app','Manage'), Yii::app()->createUrl('students/students/liststatus' ), array('type' =>'GET', 'data' =>array( 'id' => $batch->id),'dataType' => 'text',  'update' =>'#course_status'.$batch->id, 'onclick'=>'$("#course_status_dialog'.$batch->id.'").dialog("open"); return false;',),array('class'=>'course_status'))." | ";
                                                   
                                                    echo CHtml::link(Yii::t('app',"Delete"),array('students/batchdelete','id'=>$batch->id,'sid'=>$_REQUEST['id']),array('confirm'=>Yii::t('app','Are You Sure?')));
                                                }
                                                else
                                                    echo Yii::t('app',"Current").' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
                                                
                                             ?></td>
                                        </tr>
                                        <div  id="course_status<?php echo $batch->id; ?>"></div>
                                    <?php
										$sl_no++;
									}
									?>
                                </table>
                            </div>
                       	</div> <!-- END div class="emp_cntntbx" -->
                        	
                    </div> <!-- END div class="emp_tabwrapper" -->
                </div> <!-- END div class="emp_right_contner" -->
                
            </div> <!-- END div class="cont_right formWrapper" -->
          
        </td>
    </tr>
</table>
<script>
$(".course_status").click(function(e) {
    $('form#course_status_form').remove();
});
</script>
