

<?php
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Attendance',
);


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <div class="emp_cont_left">
   <?php $this->renderPartial('profileleft');?>
    
    </div>
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
    
    <h1 style="margin-top:.67em;"><?php echo Yii::t('students','Student Profile : ');?><?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
        
    <div class="edit_bttns last">
    <ul>
    <li>
    <?php echo CHtml::link('<span>'.Yii::t('students','Edit').'</span>', array('/students/students/update', 'id'=>$model->id),array('class'=>' edit ')); ?>
    </li>
     <li>
    <?php echo CHtml::link('<span>'.Yii::t('students','Students').'</span>', array('/students/students/manage'),array('class'=>'edit last'));?>
    </li>
    </ul>
    </div>    
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
     <?php $this->renderPartial('application.modules.students.views.students.tab');?>
    <div class="clear"></div>
    <div class="emp_cntntbx" >
    
    
        <?php

function getweek($date,$month,$year)
{
$date = mktime(0, 0, 0,$month,$date,$year); 
$week = date('w', $date); 
switch($week) {
case 0: 
return 'S';
break;
case 1: 
return 'M';
break;
case 2: 
return 'Tu';
break;
case 3: 
return 'W';
break;
case 4: 
return 'Th';
break;
case 5: 
return 'F';
break;
case 6: 
return 'S';
break;
}
}
?>


<?php 

$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
if(Yii::app()->user->year)
{
	$year = Yii::app()->user->year;
}
else
{
	$year = $current_academic_yr->config_value;
}
$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
//echo $current_academic_yr->config_value.$year;

if($year != $current_academic_yr->config_value and ($is_insert->settings_value==0 or $is_edit->settings_value==0 or $is_delete->settings_value==0))
{
?>
	<div>
        <div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
            <div class="y_bx_head" style="width:650px;">
            <?php 
				echo Yii::t('settings','You are not viewing the current active year. ');
				if($is_insert->settings_value==0 and $is_edit->settings_value!=0 and $is_delete->settings_value!=0)
				{ 
					echo Yii::t('settings','To mark the attendance, enable Create option in Previous Academic Year Settings.');
				}
				elseif($is_insert->settings_value!=0 and $is_edit->settings_value==0 and $is_delete->settings_value!=0)
				{
					echo Yii::t('settings','To edit the attendance, enable Edit option in Previous Academic Year Settings.');
				}
				elseif($is_insert->settings_value!=0 and $is_edit->settings_value!=0 and $is_delete->settings_value==0)
				{
					echo Yii::t('settings','To delete the attendance, enable Delete option in Previous Academic Year Settings.');
				}
				else
				{
					echo Yii::t('settings','To manage the attendance, enable the required options in Previous Academic Year Settings.');	
				}
            ?>
            </div>
            <div class="y_bx_list" style="width:650px;">
                <h1><?php echo CHtml::link(Yii::t('settings','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
            </div>
        </div>
    </div>
<?php
}
?>




<div style="position:relative">

<?php
$subjects=Subjects::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['id']));

//echo CHtml::dropDownList('batch_id','',CHtml::listData(Subjects::model()->findAll("batch_id=:x",array(':x'=>$_REQUEST['id'])), 'id', 'name'), array('empty'=>'Select Type'));

$model = new EmployeeAttendances;
  if(isset($_REQUEST['id']))
  {

	if(!isset($_REQUEST['mon']))
	{
		$mon = date('F');
		$mon_num = date('n');
		$curr_year = date('Y');
	}
	else
	{
		$mon = $model->getMonthname($_REQUEST['mon']);
		$mon_num = $_REQUEST['mon'];
		$curr_year = $_REQUEST['year'];
		
	}
	$num = cal_days_in_month(CAL_GREGORIAN, $mon_num, $curr_year); // 31
	?>
	<?php
		$studentdetails=Students::model()->findByPk($_REQUEST['id']);
		$batch=Batches::model()->findByPk($studentdetails->batch_id);
		$begin = date('Y-m',strtotime($batch->start_date)); 
		$end = date('Y-m',strtotime($batch->end_date));
		$curr_mon_yr = date("Y-m",strtotime($curr_year."-".$mon_num));
	?>
	<div align="center" class="atnd_tnav" style="top:30px;">
	<?php 
	if($curr_mon_yr > $begin)
	{   
		echo CHtml::link('<div class="atnd_arow_l"><img src="images/atnd_arrow-l.png" width="7" border="0"  height="13" /></div>',
				array('students/attentance', 'mon'=>date("m",strtotime($curr_year."-".$mon_num."-01 -1 months")),'year'=>date("Y",strtotime($curr_year."-".$mon_num."-01 -1 months")),
					'id'=>$_REQUEST['id'])); 
	}
		echo $mon.'&nbsp;&nbsp;&nbsp; '.$curr_year; 
	if($curr_mon_yr < $end)
	 {  
		echo CHtml::link('<div class="atnd_arow_r"><img src="images/atnd_arrow.png" width="7" border="0"  height="13" /></div>',
		 array('students/attentance', 'mon'=>date("m",strtotime($curr_year."-".$mon_num."-01 +1 months")),'year'=>date("Y",strtotime($curr_year."-".$mon_num."-01 +1 months")),
		'id'=>$_REQUEST['id']));
	 }
	
	/*echo CHtml::link('<div class="atnd_arow_l"><img src="images/atnd_arrow-l.png" width="7" border="0"  height="13" /></div>', array('attentance', 'mon'=>date("m",strtotime($curr_year."-".$mon_num."-01 -1 months")),'year'=>date("Y",strtotime($curr_year."-".$mon_num."-01 -1 months")),'id'=>$_REQUEST['id'])); 
	 echo $mon.'&nbsp;&nbsp;&nbsp; '.$curr_year; echo CHtml::link('<div class="atnd_arow_r"><img src="images/atnd_arrow.png" width="7" border="0"  height="13" /></div>', array('attentance', 'mon'=>date("m",strtotime($curr_year."-".$mon_num."-01 +1 months")),'year'=>date("Y",strtotime($curr_year."-".$mon_num."-01 +1 months")),'id'=>$_REQUEST['id']));*/?></div>
<br /><br /><br />
<div class="atnd_Con"  style="overflow-x:scroll;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
   
    <?php
    for($i=1;$i<=$num;$i++)
    {
        echo '<th>'.getweek($i,$mon_num,$curr_year).'<span>'.$i.'</span></th>';
    }
    ?>
</tr>
<?php 
	$batch=Batches::model()->findByAttributes(array('id'=>$studentdetails->batch_id)); 
	 /********************** GET BATCH DAYS *********************/
	
	$batch_start = date('Y-m-d',strtotime($batch->start_date));
	$batch_end = date('Y-m-d',strtotime($batch->end_date));
	
	/*$temp_begin = date('Y-m',strtotime($batch->start_date));
	$temp_end = date('Y-m',strtotime($batch->end_date));*/
	$days = array();
	$batch_days = array();
	$batch_range = StudentAttentance::model()->createDateRangeArray($batch_start,$batch_end);
	$batch_days = array_merge($batch_days,$batch_range);
	
	
	
	/********** End Subject range ***********/                            
	$weekArray = array();
	$weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x'=>$batch->id,':y'=>"0"));
	//echo count($weekdays);
	//echo $batch->id;
	if(count($weekdays)==0)
	{
	?>
		<span style="color:#F00; font-weight:bold">*<?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Weekdays not set. System default weekdays will be selected.'); ?></span>
		<?php	
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
	//var_dump($weekArray);
	
	foreach($batch_days as $batch_day)
	{
		$week_number = date('N', strtotime($batch_day));
					
		//echo $day.'='.$week_number.'<br/>';
		if(in_array($week_number,$weekArray)) // If checking if it is a working day
		{
			array_push($days,$batch_day);
		}
	}
$posts=Students::model()->findAll("id=:x", array(':x'=>$_REQUEST['id']));
$j=0;
foreach($posts as $posts_1)
{
	if($j%2==0)
	$class = 'class="odd"';	
	else
	$class = 'class="even"';	
	
 ?>
<tr <?php echo $class; ?> >
    
    <?php
    for($i=1;$i<=$num;$i++)
    {
       echo '<td class="abs"><span  id="td'.$i.$posts_1->id.'">';
		echo  $this->renderPartial('ajax',array('day'=>$i,'month'=>$mon_num,'year'=>$curr_year,'emp_id'=>$posts_1->id,'days'=>$days,'holiday_arr'=>$holiday_arr));
		/*echo CHtml::ajaxLink(Yii::t('job','ll'),$this->createUrl('EmployeeAttendances/addnew'),array(
        'onclick'=>'$("#jobDialog").dialog("open"); return false;',
        'update'=>'#jobDialog','type' =>'GET','data'=>array('day' =>$i,'month'=>$mon_num,'year'=>'2012','emp_id'=>$posts_1->id),
        ),array('id'=>'showJobDialog'));
		echo '<div id="jobDialog"></div>';*/
		
		echo '</span><div  id="jobDialog123'.$i.$posts_1->id.'"></div></td>';
		echo '</span><div  id="jobDialogupdate'.$i.$posts_1->id.'"></div></td>';
    }
    ?>
</tr>
<?php $j++; }?>
</table>
<?php } ?>
</div>
<div class="ea_pdf" style="top:2px; right:-8px; ">
<?php /*?> <?php echo CHtml::link('<img src="images/pdf-but.png" border="0">', array('/courses/StudentAttentance/pdf1','id'=>$_REQUEST['id']),array('target'=>'_blank')); ?><?php */?>
 
 <?php
 
 if($_REQUEST['mon']&&$_REQUEST['year']){
  echo CHtml::link('<img src="images/pdf-but.png" border="0">', array('/students/StudentAttentance/pdf1','mon'=>$_REQUEST['mon'],'year'=>$_REQUEST['year'],'id'=>$_REQUEST['id']),array('target'=>'_blank')); 
	}
	else{
		 echo CHtml::link('<img src="images/pdf-but.png" border="0">', array('/students/StudentAttentance/pdf1','mon'=>date("m"),'year'=>date("Y"),'id'=>$_REQUEST['id']),array('target'=>'_blank')); 
		
	}
 
 ?>
 
 
 </div>
 
</div>
    </div>
    </div>
    
    </div>
    </div>
   
    </td>
  </tr>
</table>
<script>
$('.abs').click(function(e) {
    $('form#student-attentance-form').remove();
});
</script>
