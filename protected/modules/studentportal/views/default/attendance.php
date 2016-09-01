
	<!-- Begin Coda Stylesheets -->

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/coda-slider-2.0.css" type="text/css" media="screen" />
  
 <?php //echo Yii::app()->user->agency_id ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery');?>

<!--<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/js/portal/fullcalendar/dbfullcalendar.css' />
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/js/portal/fullcalendar/fullcalendar.print.css' media='print' />-->
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/portal/fullcalendar/fullcalendar.js'></script>

      <?php $this->renderPartial('leftside');?> 
      <div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-file-text"></i><?php echo Yii::t('app','Attendance'); ?><span><?php echo Yii::t('app','View Attendance'); ?> </span></h2>
        </div>
        <div class="col-lg-2">
        
                </div>
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t('app','Calender'); ?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
      <div class="contentpanel">
<?php $studentdetails=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	  $acadyear = AcademicYears::model()->findAllByAttributes(array('status'=>1));
	  $yearid = date('Y',strtotime($acadyear[0]->start));
	  //$studyear = date('Y',strtotime($studentdetails->admission_date));?>     
      <div class="panel-heading">
                          <!-- panel-btns -->
                          <h3 class="panel-title"><?php echo Yii::t('app','Calendar'); ?></h3>
                          <?php echo CHtml::link(Yii::t('app','View Absence Details'), array('Default/AbsenceDetails','yid'=>$yearid,'id'=>$studentdetails->id),array('class'=>'btn btn-danger pull-right','style'=>'margin-top:-25px;'));?>
                        </div>
    	<div class="people-item">
<?php

$cal ='{
					title: "'.Yii::t('app','All Day Event').'",
					start: new Date(y, m, 1)
				},';
$m='';
$d='';
$y='';
//$result=TaskAssignToPatients::model()->findAll(('status=:t1 OR status=:t2 OR status=:t3 OR status=:t4 OR  status=:t5 OR status IS NULL group by target_date'),array(':t1'=>'C',':t2'=>'S',':t3'=>'A',':t4'=>'E',':t5'=>'R'));
$student=StudentAttentance::model()->findAll('student_id=:x group by date',array(':x'=>$studentdetails->id));

foreach($student as $student_1)
{
		$m=date('m',strtotime($student_1['date']))-1;
		$d=date('d',strtotime($student_1['date']));
		$y=date('Y',strtotime($student_1['date']));
		
		$leave_types = StudentLeaveTypes::model()->findByAttributes(array('id'=>$student_1->leave_type_id));
		if($leave_types!=NULL)
		{
$cal .= "{
					title: '".'<div align="center" title="'.Yii::t('app','Reason:').$student_1->reason.'"><span class="abs1" style="color:'.$leave_types->colour_code.';text-align:center;padding-top:1px;font-size:15px">'.$leave_types->label.'</span>'.'</div>'."',
					start: new Date('".$y."', '".$m."', '".$d."')
				},";
		}
		else
		{
			$cal .= "{
				title: '".'<div align="center" title="'.Yii::t('app','Reason:').$holiday->title.'"><img src="images/portal/atend_cross.png" width="40" border="0"  height="40" /></div>'."',
				start: new Date('".$y."', '".$m."', '".$d."')
				},";
		}

}

$holidays = Holidays::model()->findAll();
	
	$holiday_arr=array();
	foreach($holidays as $key=>$holiday)
	{
		if(date('Y-m-d',$holiday->start)!=date('Y-m-d',$holiday->end))
		{
			$date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d',$holiday->start),date('Y-m-d',$holiday->end));
			foreach ($date_range as $value) {
				
				$m=date('m',strtotime($value))-1;
				$d=date('d',strtotime($value));
				$y=date('Y',strtotime($value));
				$cal .= "{
				title: '".'<div align="center" title="'.Yii::t('app','Reason:').$holiday->title.'"><img src="images/portal/holiday.png" width="40" border="0"  height="40" /></div>'."',
				start: new Date('".$y."', '".$m."', '".$d."')
				},";
				
				
			}
		}
		else
		{
			
				$m=date('m',strtotime(date('Y-m-d',$holiday->start)))-1;
				$d=date('d',strtotime(date('Y-m-d',$holiday->start)));
				$y=date('Y',strtotime(date('Y-m-d',$holiday->start)));
				$cal .= "{
				title: '".'<div align="center" title="'.Yii::t('app','Reason:').$holiday->title.'"><img src="images/portal/holiday.png" width="40" border="0"  height="40" /></div>'."',
				start: new Date('".$y."', '".$m."', '".$d."')
				},";	
		}
	}

?>

                              
                
                 
                 
                 <div   id="req_res123">
                           
                          
                                            
                                    
<script type='text/javascript'>


	$(document).ready(function() {
	
		var date = new Date();
		
		var d = date.getDate();
		
		var m = date.getMonth();
		var y = date.getFullYear();
	
		
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			selectable: false,
			selectHelper: true,
			dayNames:["<?php echo Yii::t('app','sun'); ?>","<?php echo Yii::t('app','mon'); ?>","<?php echo Yii::t('app','tue'); ?>","<?php echo Yii::t('app','wed'); ?>","<?php echo Yii::t('app','thu'); ?>","<?php echo Yii::t('app','fri'); ?>","<?php echo Yii::t('app','sat'); ?>"],
			select: function(start, end, allDay) {
				var title = prompt('<?php echo Yii::t('app','Event Title:'); ?>');
				if (title) {
					calendar.fullCalendar('renderEvent',
					{
							title: title,
							start: start,
							end: end,
							allDay: allDay
					},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			editable: false,
			events: [ <?php echo $cal; ?>]
		});
		
	});
	

</script>

<script type="text/javascript">

$(document).ready(function(){
	
	 $("#shbar").click(function(){
		 
       $('#tpanel').toggle();
	 
	
        });

     
});
</script>
 
<script language="javascript">
function showsearch()
{
	if ($("#seachdiv").is(':hidden')){
	$("#seachdiv").show();
	}
	else{
		$("#seachdiv").hide();
	}
}
</script>
 
    <div id="req_res">
    
    
<div id='calendar' style="padding-right:20px;"></div>


</div>
</div>
