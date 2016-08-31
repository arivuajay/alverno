<style>
	#jobDialog123
	{
		height:auto;
	}
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
	function detail_manage(id)
	{
	
		var rr= document.getElementById("dropwindemo"+id).style.display;
		if(document.getElementById("dropwindemo"+id).style.display=="block")
		{
			document.getElementById("dropwindemo"+id).style.display="none"; 
			$("#openbutton"+id).removeClass('open');
			$("#openbutton"+id).addClass('view');
		}
		else if(  document.getElementById("dropwindemo"+id).style.display=="none")
		{
			document.getElementById("dropwindemo"+id).style.display="block"; 
			$("#openbutton"+id).removeClass('view');
			$("#openbutton"+id).addClass('open');
		}
	}
	
	function details(id)
	{
		var rr= document.getElementById("dropwin"+id).style.display;
		if(document.getElementById("dropwin"+id).style.display=="block")
		{
			document.getElementById("dropwin"+id).style.display="none"; 
			$("#openbutton"+id).removeClass('open');
			$("#openbutton"+id).addClass('view');
		}
		else if(  document.getElementById("dropwin"+id).style.display=="none")
		{
			document.getElementById("dropwin"+id).style.display="block"; 
			$("#openbutton"+id).removeClass('view');
			$("#openbutton"+id).addClass('open');
		}
	}
	function rowdelete(id)
	{
		$(".del_err").html("<?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','successfully deleted!'); ?>");		
		$("#batchrow"+id).fadeOut("slow");
		$(".del_err").fadeOut("slow");
	}
	
	function getyear()
	{
		var year_id = document.getElementById('yid').value;
		if(year_id != '' && year_id != '0') 	
		{
			window.location= 'index.php?r=courses/courses/allcourses&yid='+year_id;
		}
		else if(year_id == '')
		{
			window.location= 'index.php?r=courses/courses/allcourses';
		}
		else
		{
			return false;
		}
	}
	
	
	
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side');?>        
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Manage all Courses and').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></h1>
                <?php 
                
                ?>
                <div id="jobDialog">
                    <div id="jobDialog1">
                    	<?php $this->renderPartial('_flash');?>                
                    </div>
                </div>
                
                <!-- Academic Year Drop Down -->
                <div class="formCon">
     				<div class="formConInner">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="s_search">
              			<tr>
                        	<td>&nbsp;</td>
                            <td style="width:100px;"><strong><?php echo Yii::t('app','Academic Year');?></strong></td>
                            <td>&nbsp;</td>
                            <td>
								<?php
								
								if(isset($_REQUEST['yid']) and $_REQUEST['yid']!='')
								{
									$year = $_REQUEST['yid'];
								}
								else if(Yii::app()->user->year)
								{
									$year = Yii::app()->user->year;
								}
								elseif($current_academic_yr->config_value)
								{
									$year = $current_academic_yr->config_value;
								}								
								
                                $academic_yrs = AcademicYears::model()->findAll("is_deleted =:x", array(':x'=>0));
                                $academic_yr_options = CHtml::listData($academic_yrs,'id','name');
								echo CHtml::dropDownList('yid','',$academic_yr_options,array('prompt'=>Yii::t('app','Select'),'style'=>'width:190px;','onchange'=>'getyear()','options'=>array($year=>array('selected'=>true))));
                                ?>
                        	</td>
                    	</tr>
					</table>
                	</div>
				</div>
				<!-- END Academic Year Drop Down -->
                
                
                <div id="course">
                </div>
                
                
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
					$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
					$is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
					$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
					$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
					
					$posts=Courses::model()->findAll("is_deleted =:x and academic_yr_id =:y", array(':x'=>0,':y'=>$year));
					
					
					if($posts)
					{ 
					?>
                    	
                    <?php
						foreach($posts as $posts_1)
						{
						?>
						<div class="mcbrow" id="jobDialog1">
							<ul>
								<li class="gtcol1" onclick="details('<?php echo $posts_1->id;?>');" style="cursor:pointer;">
									<?php echo $posts_1->course_name; ?>
									<?php
									$course=Courses::model()->findByAttributes(array('id'=>$posts_1->id,'is_deleted'=>0));
									$batch=Batches::model()->findAll("course_id=:x AND is_deleted=:y AND is_active=:z AND academic_yr_id=:a", array(':x'=>$posts_1->id,':y'=>0,':z'=>1,':a'=>$course->academic_yr_id));
									?>
									<span><?php echo count($batch).' - '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></span>
								</li>
                                 <?php
								if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
								{
								?>
								<li class="col2">
									<?php echo CHtml::ajaxLink(Yii::t('app','Edit'),$this->createUrl('courses/Edit'),array(
									'onclick'=>'$("#jobDialog11").dialog("open"); return false;',
									'update'=>'#jobDialog1','type' =>'GET','data' => array( 'val1' =>$posts_1->id ),'dataType' => 'text'),array('id'=>'showJobDialog123'.$posts_1->id, 'class'=>'edit')); ?>
								</li>
                                 <?php
								}else{
								?>
								<li class="col2">									
								</li>								
                                <?php
								}if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
								{
								?>
								<li class="col3">
									<?php echo CHtml::link(Yii::t('app','Delete'),array('deactivate','id'=>$posts_1->id),array('confirm'=>Yii::t('app','Are you sure you want to delete this Course?  Note: All details (batches, students, timetable, fees, exam) related to this course will be deleted.'),'class'=>'delete'));?>
								</li>
                                 <?php
								}else{
								?>
                                    <li class="col3">									
                                    </li>
                                <?php
								}
								if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
								{
								?>
								<li class="col4">
									<?php echo CHtml::ajaxLink(Yii::t('app','Add').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),$this->createUrl('batches/Addnew'),array(
									'onclick'=>'$("#jobDialog").dialog("open"); return false;',
									'update'=>'#jobDialog','type' =>'GET','data' => array( 'val1' =>$posts_1->id, 'academic_yr_id' => $posts_1->academic_yr_id ),'dataType' => 'text',),
												array('id'=>'showJobDialog1'.$posts_1->id,'class'=>'add')); ?>                                    
								</li>
                                <?php
								}else{
								?>
                                	 <li class="col4">									
                                    </li>
                                <?php
								}
								?>
								<a href="#" id="openbutton<?php echo $posts_1->id;?>" onclick="details('<?php echo $posts_1->id;?>');" class="view">
									<li class="col5"><span class="dwnbg">&nbsp;</span></li>
								</a>
							</ul>
							
							<div class="clear"></div>
						</div> <!-- END div class="mcbrow" id="jobDialog1" -->
						
						
						<!-- Batch Details -->
						
						<!--class="cbtablebx"-->
						
						<div class="pdtab_Con" id="dropwin<?php echo $posts_1->id; ?>" style="display: none; padding:0px 0px 10px 0px; ">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<!--class="cbtablebx_topbg"  class="sub_act"-->
									<tr class="pdtab-h">
										<td align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app', 'Name');?></td>
										<td align="center"><?php echo Yii::t('app','Class Teacher');?></td>
										<td align="center"><?php echo Yii::t('app','Start Date');?></td>
										<td align="center"><?php echo Yii::t('app','End Date');?></td>
										<td align="center"><?php echo Yii::t('app','Actions');?></td>
									</tr>
									<?php 
                                                                        if($batch)
                                                                        {
                                                                            foreach($batch as $batch_1)
                                                                            {
                                                                                    echo '<tr id="batchrow'.$batch_1->id.'">';
                                                                                    echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.CHtml::link($batch_1->name, array('batches/batchstudents','id'=>$batch_1->id)).'</td>';
                                                                                    $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                                                                                    if($settings!=NULL)
                                                                                    {	
                                                                                            $date1=date($settings->displaydate,strtotime($batch_1->start_date));
                                                                                            $date2=date($settings->displaydate,strtotime($batch_1->end_date));									
                                                                                    }
                                                                                    $teacher = Employees::model()->findByAttributes(array('id'=>$batch_1->employee_id));					
                                                                                    echo '<td align="center">';
                                                                                            if($teacher)
                                                                                            {
                                                                                            echo $teacher->first_name.' '.$teacher->last_name;
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            echo '-';
                                                                                            }
                                                                                    echo '</td>';					
                                                                                    echo '<td align="center">'.$date1.'</td>';
                                                                                    echo '<td align="center">'.$date2.'</td>';
                                                                                    if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_create->settings_value!=0 or $is_edit->settings_value!=0 or $is_delete->settings_value!=0)))
                                                                                    {

                                                                                    echo '<td align="center"  class="sub_act">'; ?> 
                                                                                    <?php 
                                                                                    if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
                                                                                    {
                                                                                             ?> 

                                                                                    <?php echo CHtml::ajaxLink(Yii::t('app','Edit'),$this->createUrl('batches/addupdate'),array(
                                                                                    'onclick'=>'$("#jobDialog123").dialog("open"); return false;',
                                                                                    'update'=>'#jobDialog123','type' =>'GET','data' => array( 'val1' =>$batch_1->id,'course_id'=>$posts_1->id ),'dataType' => 'text'),array('id'=>'showJobDialog12'.$batch_1->id,'class'=>'add')); 
                                                                                    }
                                                                                    if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
                                                                                    {
                                                                                    echo CHtml::ajaxLink(Yii::t('app','Delete'), $this->createUrl('batches/remove'), array('success'=>'rowdelete('.$batch_1->id.')','type' =>'GET',
                                                                                                                                    'data' => array( 'val1' =>$batch_1->id ),'dataType' => 'text'),
                                                                                                                                    array('confirm'=>Yii::t('app','Are you sure?').Yii::t('app','Note: All details (students, timetable, fees, exam) related to this').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','will be deleted.')));
                                                                                    }
                                                                                    ?> 
                                                                                    <?php 
                                                                                    if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
                                                                                    {	
                                                                                            if(ModuleAccess::model()->check('Students')){
                                                                                    ?> <?php echo '  '.CHtml::link(Yii::t('app','Add Student'), array('/students/students/create','bid'=>$batch_1->id)).'</td>';
                                                                                            }
                                                                                    }
                                                                                    }
                                                                                    echo '</tr>';
                                                                                    echo '<div id="jobDialog123"></div>';
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            ?><tr><td colspan="5"><center>No Results</center></td></tr><?php
                                                                        }
									?>
								</tbody>
							</table>
                            <div class="del_err">
                            </div>
						</div>
						
						<!-- END Batch details div class="pdtab_Con" -->
						<div id='check'></div>
						<?php 
						} // END $posts as $posts_1
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
								echo Yii::t('app','It appears that no courses or batches are created for current academic year.');
							}
							?>
                        </div>
                        <?php
                        if(!$current_academic_yr->config_value)
                        {
                        ?>
                            <div class="y_bx_list" style="width:650px;">
                            <h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/academicyears/create')) ?></h1>
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
				if(!$academic_yrs)
				{
					echo Yii::t('app','It appears that this is the first time that you are using this Open-School Setup. For any new installation we recommend that you configure the following:');
				}
				?>
            </div>
            <?php
            if(!$academic_yrs)
            {
            ?>
            <div class="y_bx_list" style="width:650px;">
                <h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/academicyears/create')) ?></h1>
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
