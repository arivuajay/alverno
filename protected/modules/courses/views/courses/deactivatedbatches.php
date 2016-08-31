<style>
#jobDialog123
{
		height:auto;
}	
.del_err{ text-align:center; color:#F60;}	
</style>

<?php
$this->breadcrumbs=array(
Yii::t('app',$this->module->id),
);
?>
<?php 
$posts = Courses::model()->findAll("is_deleted =:x", array(':x'=>0));
$current_academic_yr = Configurations::model()->findByPk(35);
$academic_yrs = AcademicYears::model()->findAll();
if($posts!=NULL)
{
?>
<script>
	function rowdelete(id)
	{
		$(".del_err").html("<?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','successfully deleted!'); ?>");
		$(".del_err").fadeOut(7000);
		$("#batchrow"+id).fadeOut("slow");
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side');?>        
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Deactivated').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></h1>
                <?php 
				if(Yii::app()->user->year)
				{
					$year = Yii::app()->user->year;
				}
				else
				{
					$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
					$year = $current_academic_yr->config_value;
				}
				
				$is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
				$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
				$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
				
                $posts=Courses::model()->findAll("is_deleted =:x and academic_yr_id =:y", array(':x'=>0,':y'=>$year));
                ?>
                
                
                <div class="mcb_Con">
                    <!--<div class="mcbrow hd_bg">
                    <ul>
                    <li class="col1">Course Name</li>
                    <li class="col2">Edit</li>
                    <li class="col3">Delete</li>
                    <li class="col4">Add Batch</li>
                    <li class="col5">View Batch</li>
                    </ul>
                    <div class="clear"></div>
                    </div>-->
                    
                    
                    <?php
					if($posts)
					{ 
					?>
                    
                    	 <?php 				
						if($year != $current_academic_yr->config_value and ($is_create->settings_value==0 or $is_edit->settings_value==0 or $is_delete->settings_value==0))
						{
						?>
							<div>
								<div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
									<div class="y_bx_head" style="width:650px;">
									<?php 
										echo Yii::t('app','You are not viewing the current active year. ');
										if($is_create->settings_value==0 and $is_edit->settings_value!=0 and $is_delete->settings_value!=0)
										{ 
											echo Yii::t('app','To add a new').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app',"enable Create option in Previous Academic Year Settings.");
										}
										elseif($is_create->settings_value!=0 and $is_edit->settings_value==0 and $is_delete->settings_value!=0)
										{
											echo Yii::t('app','To edit a course or').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','enable Edit option in Previous Academic Year Settings.');
										}
										elseif($is_create->settings_value!=0 and $is_edit->settings_value!=0 and $is_delete->settings_value==0)
										{
											echo Yii::t('app','To delete a course or').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','enable Delete option in Previous Academic Year Settings.');
										}
										else
										{
											echo Yii::t('app','To manage courses and').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','enable the required options in Previous Academic Year Settings.');	
										}
									?>
									</div>
									<div class="y_bx_list" style="width:650px;">
										<h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
									</div>
								</div>
							</div><br />
						<?php
						}	?>
                        <div class="pdtab_Con" style="padding-top:0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
							 <tbody><!--class="cbtablebx_topbg"  class="sub_act"-->
								<tr class="pdtab-h">
									<td align="center"><?php echo Yii::t('app','Course Name');?></td>
									<td align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></td>
									<td align="center"><?php echo Yii::t('app','Start Date');?></td>
									<td align="center"><?php echo Yii::t('app','End Date');?></td>
                                    <?php
									  if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and 
																			($is_create->settings_value!=0 or $is_edit->settings_value!=0 or $is_delete->settings_value!=0)))
										{
									?>
									<td align="center"><?php echo Yii::t('app','Actions');?></td>
                                    <?php
										}
										?>
								</tr>
								<?php 
								foreach($posts as $posts_1)
                                {
									$batches=Batches::model()->findAllByAttributes(array('course_id'=>$posts_1->id,'is_active'=>0,'is_deleted'=>0));
									if($batches){	
										foreach($batches as $batch_1)
										{
											echo '<tr id="batchrow'.$batch_1->id.'">';
											echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.$posts_1->course_name.'</td>';
											echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.$batch_1->name.'</td>';
											$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
											if($settings!=NULL)
											{	
												$date1=date($settings->displaydate,strtotime($batch_1->start_date));
												$date2=date($settings->displaydate,strtotime($batch_1->end_date));									
											}														
											echo '<td align="center">'.$date1.'</td>';
											echo '<td align="center">'.$date2.'</td>';
											if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and 
																($is_create->settings_value!=0 or $is_edit->settings_value!=0 or $is_delete->settings_value!=0)))
											{										
											echo '<td align="center"  class="sub_act">'; ?> 
											<?php 
											if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
											{
											  echo ''.CHtml::ajaxLink(Yii::t('app','Delete'), $this->createUrl('batches/remove'), array('success'=>'rowdelete('.$batch_1->id.')','type' =>'GET',
																	'data' => array( 'val1' =>$batch_1->id ),'dataType' => 'text'),
																	 array('confirm'=>Yii::t('app','Are you sure you want to delete this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'?'.''.
																	 Yii::t('app','Note: All details (students, timetable, fees, exam) related to this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','will be deleted.')));
											}
											
											?> 
											<?php 
											if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
											{
												echo '  '.CHtml::link(Yii::t('app','Activate'), array('batches/activate','id'=>$batch_1->id) ,
												array('confirm'=>Yii::t('app','Are you sure you want to activate this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'?')).'</td>';
											}
											}
											echo '</tr>';
											echo '<div id="jobDialog123"></div>';
										}
										
									}
								
									?>								
                           
						<?php 
								} // END $posts as $posts_1
						?>
                    </tbody>
					</table>
                    </div></br>
					<?php 
						$batches=Batches::model()->findAllByAttributes(array('is_active'=>0,'is_deleted'=>0,'academic_yr_id'=>$year));
						if($batches==NULL){
							echo Yii::t('app','No deactivated').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.'!';
						}
					?>
                    <div class="del_err"></div>						
					<div id='check'></div>
                    <?php
					} // END if $posts
					
					else
					{
					?>
                    <div>
                        <div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
                        <div class="y_bx_head" style="width:650px;">
                        	<?php
							if(!$current_academic_yr->config_value)
							{
								echo Yii::t('app','It appears that this is the first time that you are using this Open-School Setup. For any new installation we recommend that you configure the following:');
							}
							else
							{
								echo Yii::t('app','It appears that no courses or').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','are created for current academic year.');
							}
							?>
                        </div>
                        <?php
                        if(!$current_academic_yr->config_value)
                        {
                        ?>
                            <div class="y_bx_list" style="width:650px;">
                            <h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/academicYears/create')) ?></h1>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="y_bx_list" style="width:650px;">
                        	<h1><?php echo CHtml::link(Yii::t('app','Add New Course').' &amp; '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('courses/create')) ?></h1>
						</div>
                        </div>
                    </div>
                    
					<?php	
					}
                   	?>
                
                </div> <!-- END div class="mcb_Con" -->
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>
<?php 
    } ////
    
    else
    { ?>
    <link rel="stylesheet" type="text/css" href="/openschool/css/style.css" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('left_side');?>
    
    </td>
    <td valign="top">
    <div style="padding:20px 20px">
    <div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
    	
            <div class="y_bx_head" style="width:650px;">
                <?php
				if(!$current_academic_yr->config_value or !$academic_yrs)
				{
					echo Yii::t('app','It appears that this is the first time that you are using this Open-School Setup. For any new installation we recommend that you configure the following:');
				}
				else
				{
					echo Yii::t('app','It appears that no courses or').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','are created for current academic year.');
				}
				?>
            </div>
            <?php
            if(!$academic_yrs)
            {
            ?>
            <div class="y_bx_list" style="width:650px;">
                <h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/academicYears/create')) ?></h1>
            </div>
            <?php
            }
			elseif(!$current_academic_yr->config_value)
			{
            ?>
            <div class="y_bx_list" style="width:650px;">
                <h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/configurations/create')) ?></h1>
            </div>
            <?php
			}
			?>

            <div class="y_bx_list" style="width:650px;">
                <h1><?php echo CHtml::link(Yii::t('app','Add New Course').' &amp; '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('courses/create')) ?></h1>
			</div>
            
       
    </div>
    
    </div>
    
    
    </td>
    </tr>
</table>

<?php } ?>
<script>
$(".add").click(function(e) {
    $('form#batches-form').remove();
});
</script>
<script>
$(".edit").click(function(e) {
    $('form#courses-form').remove();
});
</script>