<style type="text/css">
.tableinnerlist td{ background-color:#fff;
padding:5px 0}

.tableinnerlist th{ background-color:#fff;
padding:5px}

.tablebx td{ padding:5px 0;
	line-height: 30px;}
</style>


<?php
$this->breadcrumbs=array(
	Yii::t('app','Report')=>array('/report'),
	Yii::t('app','Attendance Percentage Reminder'),
);
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('left_side');?>
        </td>
        <td valign="top">
        	 <!-- div class="cont_right" --> 
            <div class="cont_right">
                <h1><?php echo Yii::t('app','Attendance Percentage Reminder');?></h1>
                <?php
					Yii::app()->clientScript->registerScript(
					'myHideEffect',
					'$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
					CClientScript::POS_READY
					);
					?>
                	<?php
					/* Success Message */
					if(Yii::app()->user->hasFlash('message')): 
					?>
						<div class="flashMessage" style="background:#FFF; color:#C00; padding-left:220px; font-size:13px">
						<?php echo Yii::app()->user->getFlash('message'); ?>
						</div>
					<?php endif;
					 /* End Success Message */
					?>
                  
                 <div class="formCon">
                    <div class="formConInner">
					<?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'student-form',
                    'method'=>'get',
                    'enableAjaxValidation'=>false,
                    )); ?>
                        <table width="90%" border="0" cellspacing="0" cellpadding="0" class="s_search">
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?><span class="required">*</span></strong></td>
                                <td>&nbsp;</td>
                                <td>
                                <?php
						$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
						if(Yii::app()->user->year)
						{
							$year = Yii::app()->user->year;
							//echo Yii::app()->user->year;
						}
						else
						{
							$year = $current_academic_yr->config_value;
						}
						$models = Batches::model()->findAll("is_deleted=:x AND is_active=:z AND academic_yr_id=:y", array(':x'=>'0',':y'=>$year,':z'=>'1'));
						$data   = array();
                        foreach ($models as $model_1)
                        {
                            $data[$model_1->id] = $model_1->course123->course_name.'-'.$model_1->name;
                        }
						
							$static = array('All' => Yii::t('app','All'));
							echo CHtml::dropDownList('batch_id','',$static + $data,array('required'=>'required','prompt'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),'style'=>'width:190px;','options'=>array($_REQUEST['batch_id']=>array('selected'=>true))));
							
			?>	     </tr>
            		 <tr>
                                	<td colspan="4">&nbsp;</td>
                     </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong><?php echo Yii::t('app','Percentage');?><span class="required">*</span></strong></td>
                        <td>&nbsp;</td>
                        <td><?php echo CHtml::textField('percentage',$_REQUEST['percentage'],array('required'=>'required')); ?>&nbsp %</td>
                    
                    </tr>
                    </table>
                    <?php echo CHtml::hiddenField('search_button','',array('name'=>'search_button')); ?>
                    <div style="margin-top:10px;"><?php echo CHtml::submitButton( Yii::t('app','Search'),array('name'=>'','class'=>'formbut')); ?></div>
                    <?php
					if($batches){
						$flag1=0;
						foreach($batches as $batch)
			            {
						$course_id=$batch->course_id;
						$course=Courses::model()->findByAttributes(array('id'=>$course_id));
						
						$per = $_GET['percentage'];
						
						$batch_start  = date('Y-m-d',strtotime($batch->start_date));
						$batch_end    =date('Y-m-d');	
							
						$batch_days = array();
						$batch_range = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end);
						$batch_days = array_merge($batch_days,$batch_range);
						
						
						
						$criteria = new CDbCriteria;
						$criteria->condition = 'is_deleted=:is_deleted AND batch_id=:batch_id AND is_active=:active';
						$criteria->params = array(':is_deleted'=>0,':batch_id'=>$batch->id,':active'=>1);
						$criteria->order = 'last_name ASC';
						
						$students = Students::model()->findAll($criteria);
						
						if($students){ 
						    $flag1=1;
							$url_params	= array('/report/default/percentpdf');
							
							if(isset($batch->id)){
							$url_params['batch_id']	= $_GET['batch_id'];
							$url_params['percentage']	= $_GET['percentage'];
							
			                       
								   }?>
                          	<?php  } ?>
                        
						<?php	}
					}
					?>
                    <?php $this->endWidget();?>
                    
               </div> 
               </div>  
        <div id="outer_div">
      
        <?php 
		if($batches){ ?>
        
	   <div  style="clear:both">
    
     <div class="pdtab_Con" style="padding-top:0px;">
	 <table width="100%" cellspacing="0" cellpadding="0">
        <tr class="pdtab-h">
            <td>&nbsp;</td>
            <td align="center"><?php echo Yii::t('app','Sl No');?></td>             
            <td align="center"><?php echo Yii::t('app','Course');?></td>
            <?php if(in_array('batch_id', $student_visible_fields)){ ?>
            <td align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></td>
            <?php }?>
            <td align="center"><?php echo Yii::t('app','Admission No.');?></td>
            <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
           	<td align="center"><?php echo Yii::t('app','Name');?></td>
           	<?php } ?>
            <td align="center"><?php echo Yii::t('app','Attendance').' %';?></td>
         
            <td align="center"><?php echo Yii::t('app','Dates of Absence');?></td>
            <td align="center"><?php echo Yii::t('app','Total Sessions');?></td>
            <td align="center"><?php echo Yii::t('app','Sessions missed');?></td>
           
        </tr>
        <?php
		    $flag=0;
			if($flag1==1)
			{ ?>
				 <div class="ea_pdf" style="top:111px;">
								<?php echo CHtml::link(Yii::t('app','Generate PDF'),$url_params,array('target'=>"_blank",'class'=>'pdf_but')); ?>
							</div>
	<?php	}
	        $i=1;
			foreach($batches as $batch)
			{
			$course_id=$batch->course_id;
		    $course=Courses::model()->findByAttributes(array('id'=>$course_id));
			
			$per = $_GET['percentage'];
			
			
			
			$criteria = new CDbCriteria;
			$criteria->condition = 'is_deleted=:is_deleted AND batch_id=:batch_id AND is_active=:active';
			$criteria->params = array(':is_deleted'=>0,':batch_id'=>$batch->id,':active'=>1);
			$criteria->order = 'last_name ASC';
			
			$students = Students::model()->findAll($criteria);
			
			
		if($students){ 
		?>     
	
	<?php
	$k=1;
		
	 foreach($students as $student)
			{
				
		    $student_details=Students::model()->findByAttributes(array('id'=>$student->id)); 
			if($student_details->admission_date>=$batch->start_date)
			{ 
				$batch_start  = date('Y-m-d',strtotime($student_details->admission_date));
			
			}
			else
			{
				$batch_start  = date('Y-m-d',strtotime($batch->start_date));
			}	
			
		
			
			$batch_end    = date('Y-m-d');
			$batch_end1  = date('Y-m-d',strtotime($batch->end_date));	
			
			$batch_days = array();
			$batch_range = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end);
			$batch_days = array_merge($batch_days,$batch_range);
			
			$batch_days_1  = array();
			$batch_range_1 = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end1);  // to find total session
			$batch_days_1  = array_merge($batch_days_1,$batch_range_1);
			
			$days = array();
			$days_1 = array();
			$weekArray = array();
			$total_working_days = array();
			$total_working_days_1 = array();
			$weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x'=>$batch->id,':y'=>"0"));
			if(count($weekdays)==0)
			{
				
				$weekdays = Weekdays::model()->findAll("batch_id IS NULL AND weekday<>:y",array(':y'=>"0"));
			}
			
			foreach($weekdays as $weekday)
			{
				
				$weekday->weekday = $weekday->weekday - 1;
				if($weekday->weekday <= 0)
				{
					$weekday->weekday = 7;
				}
				$weekArray[] = $weekday->weekday;
			}
			
			foreach($batch_days as $batch_day)
			{
				$week_number = date('N', strtotime($batch_day));
				if(in_array($week_number,$weekArray)) // If checking if it is a working day
				{
					array_push($days,$batch_day);
				}
			}
			
			foreach($batch_days_1 as $batch_day_1)
			{
				$week_number = date('N', strtotime($batch_day_1));
				if(in_array($week_number,$weekArray)) // If checking if it is a working day
				{
					array_push($days_1,$batch_day_1);
				}
			}
			
			$holidays = Holidays::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
			$holiday_arr=array();
			foreach($holidays as $key=>$holiday)
			{
				if(date('Y-m-d',$holiday->start)!=date('Y-m-d',$holiday->end))
				{
					$date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d',$holiday->start),date('Y-m-d',$holiday->end));
					foreach ($date_range as $value) {
						$holiday_arr[] = date('Y-m-d',$date_range);
					}
				}
				else
				{
					$holiday_arr[] = date('Y-m-d',$holiday->start);
				}
			}
			foreach($days as $day)
			{
				
				if(!in_array($day,$holiday_arr)) // If checking if it is a working day
				{
					array_push($total_working_days,$day);
				}
			}
			
			foreach($days_1 as $day_1)
			{
				
				if(!in_array($day_1,$holiday_arr)) // If checking if it is a working day
				{
					array_push($total_working_days_1,$day_1);
				}
			}
			  
				$leavedays = array();
				/*$criteria = new CDbCriteria;
				$criteria->condition = 'student_id=:x';
				$criteria->params[':x'] = $student->id;
				
				$criteria->params[':z']	= $batch_start;	
				$criteria->params[':A']	= $batch_end;
				$leaves = StudentAttentance::model()->findAll($criteria);*/
				
				$criteria = new CDbCriteria;		
				$criteria->join = 'LEFT JOIN student_leave_types t1 ON t.leave_type_id = t1.id'; 
				$criteria->condition = 't1.is_excluded=:is_excluded AND t.student_id=:x AND t.date >=:z AND t.date <=:A';
				$criteria->params = array(':is_excluded'=>0,':x'=>$student->id,':z'=>$batch_start,':A'=>$batch_end);
				//$attendances    = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$student->id));
				
				$leaves    = StudentAttentance::model()->findAll($criteria);
				
				foreach($leaves as $leave){
					if(!in_array($leave->date,$leavedays)){
						array_push($leavedays,$leave->date);
					}
				}
				
				
				
				$present = count($total_working_days);
				$absent  = count($leavedays);
				$percent = round((($present-$absent)/$present)*100,0);
				
				if($percent <= $per)
				{   $flag=1;
					if($j%2==0)
					$class = 'class="odd"';	
					else
					$class = 'class="even"';	
				
					?>
                    
        			<tr <?php echo $class; ?> >
                     <td align="center" width="40">
                        <div class="mailbox-item-wrapper">
                            <label class="checkbox1" for="conv_<?php echo $student->id; ?>">
                            <div class="mailbox-check mailbox-ellipsis">
                           	 <input class="checkbox1 " id="conv_<?php echo $student->id; ?>" type="checkbox" name="convs" value="<?php echo $student->id; ?>" onclick="selectcheck()" checked="checked"/>
                            </div>
                        </div>
                    </td>
                    <td class="name" align="center"><?php echo $i; ?></td>
                    <td align="center" class="name" ><?php echo $course->course_name; ?></td>
                    <?php if(in_array('batch_id', $student_visible_fields)){ ?>
                    <td align="center" class="name"><?php echo $batch->name; ?></td>
                    <?php } ?>
                    <td align="center" class="name" ><?php echo $student->admission_no; ?></td>
                    <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
            		<td align="center" class="name" width="100"><?php echo $student->studentFullName("forStudentProfile"); ?></td>
                    <?php } ?>
                     <td align="center" class="name" ><?php echo $percent.' %'; ?></td>
                     
                     <td align="center" class="name" width="65">
                    <?php
					if($leaves!=NULL)
					{
						foreach($leaves as $leaves_list)
						{
						
					?>
                       <?php 
					  $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($leaves_list->date));
									echo $date1;
		
								}
								else
								echo $leaves_list->date; 
					   //$date1=date('d-m-y',strtotime($leaves_list->date));
					   //echo $date1." ,";
					   
                        }
				   }
				   else
				   {
				   echo " - "; 
				   }?>
                   </td>
                   <td align="center" class="name"><?php echo count($total_working_days_1); ?></td>
                   <td align="center" class="name" ><?php echo $absent; ?></td>
                    
                  
                    
                   
        </tr>
        <?php $j++; $k++;$i++;
				}
				
			} 	?>
		
        
		<?php }
		    } 
            if($flag==0)
            {?>
            <tr>
            <td align="center" class="name" colspan="11"><?php echo Yii::t('app','No Results');?></td>
            </tr>
            <?php
			}
			?>
            </table>
			<br />

			<div align="right">
      
         <?php //echo CHtml::link('Next',array('class'=>'formbut','style'=>'margin-left:15px;','id'=>'next', 'onclick'=>'return add_all()'));?>
         <?php echo CHtml::submitButton( Yii::t('app','Next'),array('name'=>'submit','class'=>'formbut','id'=>'next', 'onclick'=>'return add_all()'));?>
		 </div>
            			</div>
            		</div>
			<?php	}
            ?>
          </div>
        
		</td>   
          
	</tr>
</table>
<div id="jobDialog"></div>

 <script>
 function checkall()
{
	if(ch.checked)
	{ 
		$('.checkbox1').prop('checked', true);
	}
	else
	{
		$('.checkbox1').each(function() { //loop through each checkbox
		   this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		});         
	}
}
function add_all()
{  
	var numberOfChecked = $('.checkbox1:checked').length; //count of all checked checkboxes with class "checkbox1"
	var totalCheckboxes = $('.checkbox1:checkbox').length; //count of all textboxes with class "checkbox1"
	var notChecked = $('.checkbox1:not(":checked")').length;//totalCheckboxes - numberOfChecked;
	
	if(numberOfChecked > 0)
	{	
		var favorite = [];
		$.each($("input[name='convs']:checked"), function(){            
			favorite.push($(this).val());
		});
		window.location='<?php echo Yii::app()->getBaseUrl(true)?>/index.php?r=report/notification/index&student_id='+favorite;
		return true;
	}else{
		alert("<?php echo Yii::t('app','Please select atleast one Student');?>");
		return false;
	}
}
 

function detailsPopup(sid)//type means : Add to cart or Spread Over 3 Months or Spread Over 6 Months
{
	var student_id = sid;
	
	$.ajax({
		type: "POST",
		url: <?php echo CJavaScript::encode(Yii::app()->createUrl('report/default/detailsPopup'))?>,
		data: {'student_id':sid},
		success: function(result){	
			$('#jobDialog').html(result);							
		}	
	});
	return false;
		
}

</script>