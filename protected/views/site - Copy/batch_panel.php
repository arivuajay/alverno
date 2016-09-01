<script>
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
	 $("#batchrow"+id).fadeOut("slow");
}

</script>

<!--<script type="text/javascript">
	$(document).ready(function() {
		$('#search_fld').focus(function(){
			$(this).val('');
		});
	});
</script>-->

<?php 
$academic_yrs = AcademicYears::model()->findAll();
$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
if(Yii::app()->user->year)
{
	$year = Yii::app()->user->year;
}
else
{
	$year = $current_academic_yr->config_value;
}
$posts=Courses::model()->findAll("is_deleted =:x AND academic_yr_id =:y", array(':x'=>0,':y'=>$year));
$num=Batches::model()->findAll("is_deleted =:x AND is_active =:z AND academic_yr_id =:y", array(':x'=>0,':y'=>$year,':z'=>1));
?>
<div class="">
    <h2 class="title"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></h2>
    <h2 class="caption"><?php echo count($num).' '.Yii::t('app','Records'); ?></h2>
    <?php /*?><div class="sd_search_area">
    <input name="" type="text" id="search_fld" class="sd_search" value="Search Here" />
    <input name="" type="button" class="sd_but" /> 
    <div class="clear"></div>
    </div><?php */?>
    
    
    <?php 
	if($posts!=NULL)
    {
	?>
        <div >
            <div class="clear"></div>
            <br />
            <?php 
            //$posts=Courses::model()->findAll("is_deleted =:x", array(':x'=>0));            
            ?>
            <div class="mcb_Con" style="width:510px;">            
            <?php 
			foreach($posts as $posts_1)
            { 
			?> 
				<?php
                //$course = Courses::model()->findByAttributes(array('id'=>$posts_1->id,'is_deleted'=>0));
                $batch = Batches::model()->findAll("course_id=:x AND is_deleted=:y AND is_active =:z", array(':x'=>$posts_1->id,':y'=>0,':z'=>1));
                ?>
                <div class="mcbrow" id="jobDialog1" style="width:510px;">
                    <ul>
                        <li class="gtcol1" onclick="details('<?php echo $posts_1->id;?>');" style="cursor:pointer;width:85%; padding:8px 0px 8px 10px;">
							<?php echo $posts_1->course_name; ?>
                            <span><?php echo count($batch).' - '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></span>
                        </li>
                        <li class="col5">
                        	<a href="#" id="openbutton<?php echo $posts_1->id;?>" onclick="details('<?php echo $posts_1->id;?>');" class="open"></a>
                        </li>
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
                                <td align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '. Yii::t('app','Name'); ?></td>
                                <td align="center"><?php echo Yii::t('app','No.of Students'); ?></td>
                                <td align="center"><?php echo Yii::t('app','Start Date'); ?></td>
                                <td align="center"><?php echo Yii::t('app','End Date'); ?></td>                            
                            </tr>
                            <?php 
                            foreach($batch as $batch_1)
                            {
								echo '<tr id="batchrow'.$batch_1->id.'">';
									if((isset($_REQUEST['widget']) and $_REQUEST['widget']!='sub_att') and isset($_REQUEST['rurl']) and $_REQUEST['rurl']!=NULL)
									{
										echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.CHtml::link($batch_1->name, array($_REQUEST['rurl'],'id'=>$batch_1->id)).'</td>';
									
									 }else if((isset($_REQUEST['widget']) and $_REQUEST['widget']=='sub_att') and (isset($_REQUEST['rurl']) and $_REQUEST['rurl']!=NULL)){ 
                           echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.CHtml::link($batch_1->name, array('/attendance/subjectAttendance/batchwise','id'=>$batch_1->id)).'</td>';
                           
                              }else{
								  
										echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">'.CHtml::link($batch_1->name, array('courses/batches/batchstudents','id'=>$batch_1->id)).'</td>';									
									}
									//no of students
									$batch_students 		= BatchStudents::model()->findAllByAttributes(array('batch_id'=>$batch_1->id));
									$criteria				= new CDbCriteria;
									$criteria->condition 	= 'is_deleted=:is_deleted AND is_active=:is_active';
									$criteria->params[':is_deleted'] = 0;
									$criteria->params[':is_active'] = 1;
									if($batch_students)
									{
										$count = count($batch_students);
										$criteria->condition = $criteria->condition.' AND (';
										$i = 1;
										foreach($batch_students as $batch_student)
										{
											
											$criteria->condition 				= $criteria->condition.' id=:student'.$i;
											$criteria->params[':student'.$i] 	= $batch_student->student_id;
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
										$criteria->condition 			= $criteria->condition.' AND batch_id=:batch_id';
										$criteria->params[':batch_id'] 	= $batch_1->id;
									}
									$posts=Students::model()->findAll($criteria);
									echo '<td align="center">'.count($posts).'</td>';
									//echo '<td align="center">'.count(Students::model()->findAllByAttributes(array('batch_id'=>$batch_1->id,'is_deleted'=>0))).'</td>';
									echo '<td align="center">'.date('d-M-Y',strtotime($batch_1->start_date)).'</td>';
									echo '<td align="center">'.date('d-M-Y',strtotime($batch_1->end_date)).'</td>';
								echo '</tr>';
                            
                            }
                            ?>
                        </tbody>
                    </table>
                </div> <!-- END div class="pdtab_Con" -->
            <?php 
			}
			?>        
            
            </div>
        </div>
    <?php 
	} // END if $posts!=NULL
    else
    { 
	?>
        <!--<link rel="stylesheet" type="text/css" href="/openschool/css/style.css" />-->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="247" valign="top">
                	<?php //$this->renderPartial('left_side');?>            
                </td>
                <td valign="top">
                    <div style="padding:20px 20px">
                        <div class="yellow_bx" style="background-image:none;width:450px;padding-bottom:45px;">
                        	<div class="y_bx_head" style="width:450px;">
							<?php 
                            if(!$current_academic_yr->config_value or !$academic_yrs)
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
							if(!$academic_yrs)
							{
							?>
							<div class="y_bx_list" style="width:650px;">
								<h1><?php echo CHtml::link(Yii::t('app','Setup Academic Year'),array('/academicyears/create')) ?></h1>
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
                                <h1><?php echo CHtml::link(Yii::t('app','Add New Course').' &amp; '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('courses/courses/create')); ?></h1>
                            </div>
                       
                        </div>
                    </div>        
                </td>
            </tr>
        </table>
    
    <?php 
	}
	?>

</div> <!-- END div class="panel-wrapper" -->