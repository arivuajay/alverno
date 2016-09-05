<!-- Begin Coda Stylesheets -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/coda-slider-2.0.css" type="text/css" media="screen" />
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/portal/fullcalendar/fullcalendar.js'></script>
<script language="javascript">
	function showsearch()
	{
		if ($("#seachdiv").is(':hidden'))
		{
			$("#seachdiv").show();
		}
		else
		{
			$("#seachdiv").hide();
		}
	}

	function getstudent() // Function to see student profile
	{
		var studentid = document.getElementById('studentid').value;
		var yearid = document.getElementById('yearid').value;
		if(studentid!='' && yearid!='')
		{
			window.location= 'index.php?r=parentportal/default/AbsenceDetails&id='+studentid+'&yid='+yearid;
		}
		else
		{
			window.location= 'index.php?r=parentportal/default/AbsenceDetails';
		}
	}

	function getyear()
	{
		var studentid = document.getElementById('studentid').value;
		var yearid = document.getElementById('yearid').value;
		if(yearid!='')
		{
			window.location= 'index.php?r=parentportal/default/AbsenceDetails&id='+studentid+'&yid='+yearid;
		}
		else
		{
			window.location= 'index.php?r=parentportal/default/AbsenceDetails';
		}
	}

</script>

<?php Yii::app()->clientScript->registerCoreScript('jquery');?>



<?php $this->renderPartial('leftside');?>
    <?php
    $cal ='{
    title: "'.Yii::t('app','All Day Event').'",
    start: new Date(y, m, 1)
    },';
    $m='';
    $d='';
    $y='';

    $guardian = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	$students = Students::model()->findAllByAttributes(array('parent_id'=>$guardian->id));
	if(count($students)==1) // Single Student
	{
		$attendances = StudentAttentance::model()->findAll('student_id=:x group by date',array(':x'=>$students[0]->id));
	}
	elseif(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL) // If Student ID is set
	{
		$attendances = StudentAttentance::model()->findAll('student_id=:x group by date',array(':x'=>$_REQUEST['id']));

	}
	elseif(count($students)>1) // Multiple Student
	{
    	$attendances = StudentAttentance::model()->findAll('student_id=:x group by date',array(':x'=>$students[0]->id));
	}
    foreach($attendances as $attendance)
    {
		$m=date('m',strtotime($attendance['date']))-1;
		$d=date('d',strtotime($attendance['date']));
		$y=date('Y',strtotime($attendance['date']));
		$cal .= "{
		title: '".'<div align="center" title="Reason: '.$attendance->reason.'"><img src="images/portal/atend_cross.png" width="26" border="0"  height="25" /></div>'."',
		start: new Date('".$y."', '".$m."', '".$d."')
		},";

    }

	$all_holidays = Holidays::model()->findAll();

	$holiday_arr=array();
	foreach($all_holidays as $key=>$holiday)
	{
		if(date('Y-m-d',$holiday->start)!=date('Y-m-d',$holiday->end))
		{
			$date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d',$holiday->start),date('Y-m-d',$holiday->end));
			foreach ($date_range as $value) {

				$m=date('m',strtotime($value))-1;
				$d=date('d',strtotime($value));
				$y=date('Y',strtotime($value));
				$cal .= "{
				title: '".'<div align="center" title="Reason: '.$holiday->title.'"><img src="images/portal/holiday.png" width="40" border="0"  height="40" /></div>'."',
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
				title: '".'<div align="center" title="Reason: '.$holiday->title.'"><img src="images/portal/holiday.png" width="40" border="0"  height="40" /></div>'."',
				start: new Date('".$y."', '".$m."', '".$d."')
				},";
		}
	}
    ?>

<div class="pageheader">
    <div class="col-lg-8">
     <h2><i class="fa fa-file-text"></i> <?php echo Yii::t('app','Attendance'); ?> <span><?php echo Yii::t('app','View your attendance here'); ?></span></h2>
    </div>

      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->

          <li class="active"><?php echo Yii::t('app','Attendance'); ?></li>
        </ol>
      </div>

     <div class="clearfix"></div>

    </div>
<script type='text/javascript'>
$.noConflict();
jQuery( document ).ready(function( $ ) {
        $(document).ready(function(){
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
			dayNames:["sun","mon","tue","wed","thu","fri","sat"],
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
        });
        </script>

        <script type="text/javascript">
        $(document).ready(function(){
			$("#shbar").click(function(){
			$('#tpanel').toggle();
			});
        });
        </script>
        <div class="contentpanel">

		<div class="people-item">

			<?php
                if(count($students)>1)
				{
					 $student_list = CHtml::listData($students,'id','studentnameforparentportal');
					 $acadyear = AcademicYears::model()->findAllByAttributes(array('status'=>1));
					 $yearlist = CHtml::listData($acadyear,'id','name');
				?>
                	<div class="col-lg-3">
                        <?php
						if($_REQUEST['yid']!=NULL)
							$yearid = $_REQUEST['yid'];
						else
							$yearid = $acadyear[0]->id;
						if($_REQUEST['id']!=NULL)
							$stdid = $_REQUEST['id'];
						else
							$stdid = $students[0]->id;
                        echo Yii::t('app','Academic Year').CHtml::dropDownList('yid','',$yearlist,array('prompt'=>Yii::t('app','Select Year'),'id'=>'yearid','style'=>'width:auto;display: inline; margin-left: 7px;','class'=>'form-control input-sm mb14','options'=>array($yearid=>array('selected'=>true)),'onchange'=>'getyear();'));
                        ?>
                    </div> <!-- END div class="student_dropdown" -->
                	<div class="col-lg-5">
                        <?php
                        echo Yii::t('app','Viewing Attendance of ').CHtml::dropDownList('sid','',$student_list,array('prompt'=>Yii::t('app','Select'),'id'=>'studentid','style'=>'width:auto;display: inline; margin-left: 7px;','class'=>'form-control input-sm mb14','options'=>array($stdid=>array('selected'=>true)),'onchange'=>'getstudent();'));
                        ?>
                    </div> <!-- END div class="student_dropdown" -->
                <?php
				}
				?>
		<div class="clearfix"></div>
		</div>

<?php

			if($_REQUEST['id']!=NULL && $_REQUEST['yid']!=NULL)
			{
				$yeardetails = AcademicYears::model()->findByPk($_REQUEST['yid']);
				$strtyear = date('Y',strtotime($yeardetails->start));
				$endyear = date('Y',strtotime($yeardetails->end));
			}
			else
			{
				$acadyear = AcademicYears::model()->findByAttributes(array('status'=>1));
				$strtyear = date('Y',strtotime($acadyear->start));
			}
				$studentdetails = Students::model()->findByPk($_REQUEST['id']);
				$batch = Batches::model()->findByPk($studentdetails->batch_id);
						?>



                            <!-- Yearly PDF -->
                            <?php if($_REQUEST['yid']!=NULL)
							{
							?>

							<div class="panel-heading">
              <!-- panel-btns -->
			  <div class="col-lg-6">
              <h3 class="panel-title">
			  <?php echo Yii::t('app','Yearly Student Attendance Report');?></h3>
			  </div>

			  <div class="col-lg-6">
			  <?php echo CHtml::link(Yii::t('app','Back'), array('/parentportal/default/attendance','id'=>$_REQUEST['id'],'yid'=>$_REQUEST['yid']),array('class'=>'btn btn-danger pull-right','style'=>'')); ?>

								<?php echo CHtml::link(Yii::t('app','Generate PDF'), array('/parentportal/default/AttendancePdf','id'=>$_REQUEST['id'],'yid'=>$_REQUEST['yid']),array('target'=>"_blank",'class'=>'btn btn-danger pull-right','style'=>'margin-right:10px')); ?>
				</div>
				<div class="clearfix"></div>

			  </div>




                            <?php
							}
							else
							{
							?>

							<div class="panel-heading">
              <!-- panel-btns -->
			  <div class="col-lg-6">
              <h3 class="panel-title">
			  <?php echo Yii::t('app','Yearly Student Attendance Report');?></h3>
			  </div>

			  <div class="col-lg-6">
			 <?php echo CHtml::link(Yii::t('app','Back'), array('/parentportal/default/attendance'),array('class'=>'btn btn-danger pull-right','style'=>'')); ?>

								<?php echo CHtml::link(Yii::t('app','Generate PDF'), array('/parentportal/default/AttendancePdf','id'=>$_REQUEST['id']
								),array('target'=>"_blank",'class'=>'btn btn-danger pull-right','style'=>'margin-right:10px')); ?>
				</div>
				<div class="clearfix"></div>

			  </div>
                            <?php
							}
							?>
                            <div class="people-item">
                            <!-- END Yearly PDF -->
                            <!-- Yearly Report Table -->
                            <div class="table-responsive">
                            	<table class="table table-hover mb30">
                                    <tr>
                                        <?php /*?><th><?php echo Yii::t('app','Sl No');?></th><?php */?>
                                        <th><?php echo Yii::t('app','Adm No');?></th>
                                        <?php
											if(FormFields::model()->isVisible("fullname", "Students", "forParentPortal")){
										?>
                                        	<th><?php echo Yii::t('app','Name');?></th>
                                        <?php } ?>
                                        <th><?php echo Yii::t('app','Working Days');?></th>
                                        <th><?php echo Yii::t('app','Leaves');?></th>
                                    </tr>
                                    <?php
									$yearly_sl = 1;
									//foreach($students as $student) // Displaying each employee row.
									//{
									?>
                                    <tr>
                                    	<?php /*?><td style="padding-top:10px; padding-bottom:10px;"><?php echo $yearly_sl; $yearly_sl++;?></td><?php */?>
                                        <td><?php echo $studentdetails->admission_no; ?></td>
                                        <?php
											if(FormFields::model()->isVisible("fullname", "Students", "forParentPortal")){
										?>
                                            <td>
                                                <?php echo $studentdetails->studentFullName('forParentPortal');?>
                                            </td>
                                        <?php } ?>
                                        <td>
											<?php
														$admindetails = User::model()->findByAttributes(array('username'=>'admin'));
														$uid = $admindetails->id;
														$holidaycount = 0;
														$holidaydetails = Holidays::model()->findAllByAttributes(array('user_id'=>$uid));
														$required_year = $strtyear;

														foreach($holidaydetails as $holidaydetail)
														{
															$startyear = date('Y',$holidaydetail->start);
															$endyear = date('Y',$holidaydetail->end);
															if($required_year==$startyear or $required_year==$endyear)
															{
																$holidaycount++;
															}

														}
                                                        $weekdetails = Weekdays::model()->findAllByAttributes(array('batch_id'=>$studentdetails->batch_id));
                                                        $weekdays = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
                                                      	$holidays = array();
													    $index=0;
                                                        foreach($weekdetails as $key=>$value)
                                                        {
                                                            if($value->weekday==0)
                                                            {
                                                                $holidays[$index] = $weekdays[$key];
                                                                $index++;
                                                            }
                                                        }
                                                        $batchdetails = Batches::model()->findByAttributes(array('name'=>$batch->name));
                                                        $batchstartyear = date('Y',strtotime($batchdetails->start_date));
                                                        $batchendyear = date('Y',strtotime($batchdetails->end_date));
                                                        if($required_year==$batchstartyear or $required_year==$batchendyear)
                                                        {
                                                           /* $datetime1 = new DateTime($batchdetails->start_date);
                                                            $datetime2 = new DateTime($batchdetails->end_date);
                                                            $interval = $datetime1->diff($datetime2);
                                                            $days = $interval->format('%a');*/
															$date11 = strtotime($batchdetails->start_date);
															$date22 = strtotime($batchdetails->end_date);
															$diff = $date22 - $date11;
															$days = floor($diff/(60*60*24)) + 1;
                                                            $dayscount = 0;
                                                            $counter = 0;

                                                            foreach($holidays as $holiday)
                                                            {
                                                                $dayscount += Batches::model()->Daycount($holiday, strtotime(date('d-m-Y',strtotime($batchdetails->start_date))),
                                                                    strtotime(date('d-m-Y',strtotime($batchdetails->end_date))), $counter);
                                                            }

                                                            echo $workingday = $days-($dayscount+$holidaycount);
                                                        }
                                                        else
                                                        {
                                                            echo "0";
                                                        }
                                            ?>
                						</td>
                                         <!-- Yearly Attendance column -->
                                        <td>
                                        	<?php
											$attendances = StudentAttentance::model()->findAllByAttributes(array('student_id'=>$studentdetails->id));
											$required_year = $strtyear;
											//$joining_year = date('Y',strtotime($employee->joining_date));
											//if($required_year >= $joining_year)
											//{
											$leaves = 0;
											foreach($attendances as $attendance)
											{
												$attendance_year = date('Y',strtotime($attendance->date));
												if($attendance_year == $required_year)
												{
													$exist_leave = StudentLeaveTypes::model()->findByAttributes(array('id'=>$attendance->leave_type_id,'is_excluded'=>0,'status'=>1));
													if($exist_leave!=NULL)
													{
														$leaves++;
													}
												}
											}
											echo $leaves;
											//}
											//else
											//{
											//	echo 'No data';
											//}
											?>
                                        </td>
                                        <!-- End Yearly Attendance column -->
                                    </tr>
                                    <?php /*?><?php
									}
									?><?php */?>
								</table>
                            </div>
                            <h3 class="panel-title"><?php echo Yii::t('app','Individual Student Attendance Report');?></h3><br />

                            <div class="table-responsive">
                                    <table class="table table-hover mb30">
                                        <tr>
                                            <th><?php echo Yii::t('app','Sl No');?></th>
                                            <th><?php echo Yii::t('app','Leave Type');?></th>
                                            <th><?php echo Yii::t('app','Leave Date');?></th>
                                            <th><?php echo Yii::t('app','Time Table');?></th>
                                            <th><?php echo Yii::t('app','Reason');?></th>
                                        </tr>
                                        <?php
										$studleaves = StudentAttentance::model()->findAll('student_id=:x ORDER BY date ASC',array(':x'=>$studentdetails->id));
										if($studleaves!=NULL)
										{
											$individual_sl = 1;
											foreach($studleaves as $studleave) // Displaying each leave row.
											{
												$exist_leave = StudentLeaveTypes::model()->findByAttributes(array('id'=>$studleave->leave_type_id,'status'=>1));
												//if($exist_leave!=NULL)
												//{
											?>
											<tr>
												<td style="padding-top:10px; padding-bottom:10px;"><?php echo $individual_sl; $individual_sl++;?></td>
                                                <td>
                                                	<?php
														if($exist_leave!=NULL)
														{
															echo $exist_leave->name;
														}
														else
															echo "-";
													?>
                                                </td>
												 <!-- Individual Attendance row -->
												<td>
													<?php
													$settings=UserSettings::model()->findByAttributes(array('user_id'=>$admindetails->id));
													if($settings!=NULL)
													{
														$studleave->date = date($settings->displaydate,strtotime($studleave->date));
													}
													echo $studleave->date;
													?>
												</td>
												<td>
													<?php
													if($studleave->timetable_id!=NULL)
													{
														echo $studleave->timetable->fieldClassSubject;
													}
													else
													{
														echo '-';
													}
													?>
												</td>
												<td>
													<?php
													if($studleave->reason!=NULL)
													{
														echo $studleave->reason;
													}
													else
													{
														echo '-';
													}
													?>
												</td>
												<!-- End Individual Attendance row -->
											</tr>
											<?php
												//}
											}
										}
										else
										{
										?>
                                        	<tr>
                                            	<td colspan="3" style="padding-top:10px; padding-bottom:10px;" align="center">
                                                	<strong><?php echo Yii::t('app','No leaves taken!'); ?></strong>

    </td>
                                            </tr>
                                        <?php
										}
										?>
                                    </table>
                                </div>
                            </div>
                            <!-- END Yearly Report Table -->
						<?php

			//}
		?>
</div>
</div>