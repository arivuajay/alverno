<link href="<?php echo Yii::app()->request->baseUrl;?>/css/tabulous.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl;?>/css/portal/portal_dashboard.css" rel="stylesheet" type="text/css" />

<script src="<?php echo Yii::app()->request->baseUrl;?>/js/tab/tabulous.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/js/tab/dash_tab.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/js/scroll/perfect-scrollbar.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/js/scroll/jquery.mousewheel.js"></script>

 <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('.Default').perfectScrollbar();
      });
    </script>
<?php $this->breadcrumbs = array(
	Yii::t('app', 'Dashboard'),
);?>    
   




 

<div class="white_space" >

	
        	


<?php 
        $roles = Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
        foreach($roles as $role)
        {
            $rolename = $role->name;
        }
		
		if($rolename == 'parent')
		{ ?> <div class="dash_child">
    	<h4><?php echo Yii::t('app','Children'); ?></h4>
        <div class="children_area">
    	<ul> <?php
			$parent = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->Id)) ;
			$wards = Students::model()->findAllByAttributes(array('parent_id'=>$parent->id)) ;
			foreach($wards as $ward)
			{
				echo '<li>'.CHtml::link($ward->first_name, array('/dashboard','id'=>$ward->uid)).'</li>';
				$check_uid[] = $ward->uid;
			}
			?> 
			</ul>
    </div>
    <div class="clear"></div>
        
    </div>
			<?php
			
			if(in_array($_REQUEST['id'], $check_uid))
			{
				$student_user_id = $_REQUEST['id'];
			}
		}
		elseif($rolename == 'student')
		{
			$student_user_id = Yii::app()->user->Id ;
		}
		

?>

 
    
<div class="clear"></div>
	<div class="dash_box1 for_admin_box1">
    	<div class="dash_subhed news"><?php echo Yii::t('app','News'); ?></div>
        	<div class="mousescroll Default news_boxnew" style="margin-top:10px; height:216px;">
    <ul>
    <?php 
	$newss = DashboardMessage::model()->findAllByAttributes(array('recipient_id'=>Yii::app()->getModule('mailbox')->newsUserId));
	if($newss and $newss!=NULL)
	{ 
		 foreach($newss as $news)
		 { ?>
		 
					<li>
					<h3><?php echo @Mailbox::model()->findByAttributes(array('conversation_id'=>$news->conversation_id))->subject ;?></h3>
					<?php echo $news->text; ?>
					</li>
					
					
	<?php }
	}
	else
	{?>
    
                <li>
                <h3><?php echo Yii::t('app','No News'); ?></h3>
                <p>. . . .</p>
                </li>
    <?php } ?>
        	</ul>
            </div>
            <div class="dash_bottom">
            	<ul style="float:right !important;">
                	<li></li>
                    <li><div class="dash_eye"></div><?php echo CHtml::link(Yii::t('app','View'), array('/mailbox/news'));?></li>
                    <?php  
					if(Yii::app()->user->checkAccess('Admin'))
                        { 
					?>
                    <li><div class="dash_create"></div><?php echo CHtml::link(Yii::t('app','Create'), array('/news/create'));?></li>
                    <?php
						}
					?>
                </ul>
            </div>
    </div>
    
    <div class="dash_box2 for_admin_box2">
    	<div class="dash_subhed events"><?php echo Yii::t('app','Events'); ?></div>
        
        <div class="events_box">
        	
        
        <div id="tabs4" class="tabs4 ">
		<ul id="tm23">
			<li><a href="#tabs-1" title=""><?php echo Yii::t('app','Today'); ?></a></li>
			<li><a href="#tabs-2" title=""><?php echo Yii::t('app','Current Week'); ?></a></li>
			<li><a href="#tabs-3" title=""><?php echo Yii::t('app','Next Week'); ?></a></li>
            <li><a href="#tabs-4" title=""><?php echo Yii::t('app','Next month'); ?></a></li>
		</ul>

		<div id="tabs_container" class="mousescroll Default">
			
        <?php 
		
        
        $criteria = new CDbCriteria;
		$criteria->order = 'start DESC';
			if($rolename!= 'Admin')
			{
			
			$criteria->condition = 'placeholder = :default or placeholder=:placeholder';
			$criteria->params[':placeholder'] = $rolename;
			$criteria->params[':default'] = '0';
			}
		$events = Events::model()->findAll($criteria);
		
		if($events and $events!=NULL)
		{
		foreach($events as $event)
        {
			
			
			$today              = strtotime("00:00:00");
			$next_monday = strtotime('Next Monday', $today);
			$second_next_monday = strtotime('+1 week',$next_monday);
			$next_month = strtotime('+1 month',$today);
			$next_month_start = strtotime('first day of this month',$next_month);
			$next_month_end = strtotime('first day of next month',$next_month);
			
			
			
			
			if(date("Y-m-d",$event->start) == date('Y-m-d') )
			{
			$events_sameday[] = $event ; 
			}
			elseif($event->start >= $today and $event->start < $next_monday)
			{
			$events_sameweek[] = $event ; 
			}
			elseif($event->start >= $next_monday and $event->start < $second_next_monday)
			{
			$events_nextweek[] = $event ; 	
			}
			elseif($event->start >= $next_month_start and $event->start < $next_month_end)
			{
			$events_nextmonth[] = $event ; 	
			}
		
			
		}
	
		
		}
		
		
		?>



		<div id="tabs-1">
        <?php 
		if($events_sameday and $events_sameday!=NULL)
		{
		foreach($events_sameday as $event_sameday)
		{
			
			echo CHtml::ajaxLink('<h3>'.substr($event_sameday->title,0,25).'</h3>
				<h5>'.substr($event_sameday->desc,0,50).'</h5>
				<h4 class="tab_date">'.date("Y-m-d",$event_sameday->start).'</h4>',$this->createUrl('default/view',array('event_id'=>$event_sameday->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_sameday->id,'class'=>'add'));
		}
		}
		else
		{
			echo '<p class="mail_dashnew_error">'.Yii::t('app','No Events Today').'</p>';
		}
		?>
			   
		</div>

		<div id="tabs-2">
			    <?php 
		if($events_sameweek and $events_sameweek!=NULL)
		{
		foreach($events_sameweek as $event_sameweek)
		{
			
			echo CHtml::ajaxLink('<h3>'.substr($event_sameweek->title,0,25).'</h3>
				<h5>'.substr($event_sameweek->desc,0,50).'</h5>
				<h4 class="tab_date">'.date("Y-m-d",$event_sameweek->start).'</h4>',$this->createUrl('default/view',array('event_id'=>$event_sameweek->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_sameweek->id));
		}
		}
		else
		{
			echo '<p class="mail_dashnew_error">'.Yii::t('app','No Upcoming Events This week').'</p>';
		}
		?>
	
		</div>
        
       

		<div id="tabs-3">
			    <?php 
		if($events_nextweek and $events_nextweek!=NULL)
		{
		foreach($events_nextweek as $event_nextweek)
		{ 
		
			echo CHtml::ajaxLink('<h3>'.substr($event_nextweek->title,0,25).'</h3>
				<h5>'.substr($event_nextweek->desc,0,50).'</h5>
				<h4 class="tab_date">'.date("Y-m-d",$event_nextweek->start).'</h4>',$this->createUrl('default/view',array('event_id'=>$event_nextweek->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_nextweek->id));
		}
		}
		else
		{
			echo '<p class="mail_dashnew_error">'.Yii::t('app','No Upcoming Events Next Week').'</p>';
		}
		?>
		</div>
        
        
        
        <div id="tabs-4">
        
			    <?php 
		if($events_nextmonth and $events_nextmonth!=NULL)
		{
		foreach($events_nextmonth as $event_nextmonth)
		{
			
			echo CHtml::ajaxLink('<h3>'.substr($event_nextmonth->title,0,25).'</h3>
				<h5>'.substr($event_nextmonth->desc,0,50).'</h5>
				<h4 class="tab_date">'.date("Y-m-d",$event_nextmonth->start).'</h4>',$this->createUrl('default/view',array('event_id'=>$event_nextmonth->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_nextmonth->id));
		}
		}
		else
		{
			echo '<p class="mail_dashnew_error">'.Yii::t('app','No Upcoming Events Next Month').'</p>';
		}
		?>
		</div>

		</div>
		
	</div>

</div>
<div class="dash_bottom">
            	<ul>
                	<li></li>
                    <li><div class="dash_eye"></div><?php echo CHtml::link(Yii::t('app','View'), array('default/events'));?></li>
                     <?php  
					if(Yii::app()->user->checkAccess('Admin'))
                        { 
					?>
                    <li><div class="dash_create"></div><?php echo CHtml::link(Yii::t('app','Create'), array('/cal'));?></li>
                    <?php
						}
					?>
                </ul>
            </div>
 
    </div>
    
    <!------------to do list starting----------------->
    
    <!--<div class="dash_box3">
    	<div class="dash_subhed todo">To Do List</div>
        
        <div class="mousescroll Default">
        
        <div class="dash_chek">
	
<ul>
<li><input type="checkbox" name="option1" value="Milk"> Prepare for annual meet<br></li>
<li><input type="checkbox" name="option2" value="Butter" checked>Meet Finance Manager<br></li>
<li><input type="checkbox" name="option3" value="Cheese"> Deside on database management<br></li>
<li><input type="checkbox" name="option3" value="Cheese">Meet Finance Manager<br></li>

</ul>

</div>
</div>


<div class="dash_bottom">
            	<ul>
                                    <li><div class="dash_eye"></div><a href="#">View</a></li>
                    <li><div class="dash_create"></div><a href="#">Create</a></li>
                    <li><div class="dash_sub"></div><a href="#">Set Reminder</a></li>
                    
                </ul>
            </div>
</div>-->

<!------------to do list ending----------------->
    
    <?php 
	if(($rolename=='student' or $rolename=='parent') and isset($student_user_id))
	{
		
		$student = Students::model()->findByAttributes(array('uid'=>$student_user_id)) ;
		if($student and $student!=NULL)
		{
		?>
    <div class="dash_box4 for_student_box4">
    	<div class="dash_subhed time_table"><?php echo Yii::t('app','Timetable'); ?>
        	<div class="subhed_date"><?php echo date('Y-m-d') ;?></div>
        </div>
        
        <div  class="mousescroll Default">
        <div class="time_table_dash">
       
	
<?php if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
{ 

$check_entry = TimetableEntries::model()->findAllByAttributes(array('batch_id'=>$student->batch_id));

if($check_entry and $check_entry!=NULL)
{
	
$TimetableEntries = TimetableEntries::model()->findAllByAttributes(array('batch_id'=>$student->batch_id,'weekday_id'=>date('N')+1));
if($TimetableEntries and $TimetableEntries!=NULL)
{
?>
<table width="316" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="10% "><?php echo Yii::t('app','Time'); ?></th>
    <th><?php echo Yii::t('app','Subject'); ?></th>
  </tr>
  <?php foreach($TimetableEntries as $TimetableEntry)
  { ?>
  <tr>
    
    <?php 
	
	$ClassTiming= ClassTimings::model()->findByAttributes(array('id'=>$TimetableEntry->class_timing_id)); 
	
	if($ClassTiming and $ClassTiming!=NULL)
	{ ?>
		<td><div class="dash_blue"><?php echo $ClassTiming->start_time.' - '.$ClassTiming->end_time ?></div></td>
    <td><?php $subject = Subjects::model()->findByAttributes(array('id'=>$TimetableEntry->subject_id));
			  if($subject and $subject!=NULL)
			  {
				  echo $subject->name;
			  }
			  else
			  {
				  echo '----';
			  }?></td>
	<?php }
	else
	{ ?>
		<td><div class="dash_blue">..</div></td>
    <td>..</td>
	<?php }
	
	?>
    
    
    
  </tr>
  <?php } ?>
  
  
</table>
<?php }
else
{
	echo Yii::t('app','No classes scheduled for today');
}}
else
{
	echo Yii::t('app','Time Table not available for your').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
}
}
else
{
	//echo Yii::t('app','You are not Enrolled in any Course/Batch');
	echo Yii::t('app','You are not Enrolled in any').' '.Yii::app()->getModule("students")->labelCourseBatch();
}
?>
</div>

</div>

<div class="dash_bottom">
            	<ul>
                <li></li>
                                    <li><div class="more"></div><?php echo CHtml::link(Yii::t('app','More'), array('/studentportal/default/timetable'));?></li>
                    
                    
                </ul>
            </div>
    </div>
    
    <?php }} ?>
    
    
    
    
    <!------------assignment starting----------------->
    
    
    <!--<div class="dash_box5">
    	<div class="dash_subhed assignment">Assignment</div>
        
       <div  class="mousescroll Default">
        
        <div class="dash_chek assign">
	
<ul>
<li><input type="checkbox" name="option1" value="Milk"> Prepare for annual meet<br></li>
<li><input type="checkbox" name="option2" value="Butter" checked>Meet Finance Manager<br></li>
<li><input type="checkbox" name="option3" value="Cheese"> Deside on database management<br></li>
<li><input type="checkbox" name="option3" value="Cheese">Meet Finance Manager<br></li>
<li><input type="checkbox" name="option1" value="Milk"> Prepare for annual meet<br></li>
<li><input type="checkbox" name="option2" value="Butter" checked>Meet Finance Manager<br></li>
<li><input type="checkbox" name="option3" value="Cheese"> Deside on database management<br></li>
<li><input type="checkbox" name="option3" value="Cheese">Meet Finance Manager<br></li>
</ul>

</div>
</div>


<div class="dash_bottom">
            	<ul>
                                    <li><div class="dash_eye"></div><a href="#">View</a></li>
                    <li><div class="dash_create"></div><a href="#">Create</a></li>
                    <li><div class="dash_sub"></div><a href="#">Set Reminder</a></li>
                    
                </ul>
            </div>
    </div>-->
    
    
    <!------------assignment ending----------------->
    <?php 
	if(($rolename=='student' or $rolename=='parent') and isset($student_user_id))
	{ 
	if($student and $student!=NULL)
	{
	
	?>
    <div class="dash_box5">
    	<div class="dash_subhed attendance"><?php echo Yii::t('app','Attendance'); ?></div>
        <div class="attendance_date"><?php echo Yii::t('app','Last 7 days'); ?></div>
        
        <?php if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
        { 
		
		$weekdays = Weekdays::model()->findAllByAttributes(array('batch_id'=>$student->batch_id)); 
		
		if(count($weekdays)!=7)
		{
			$weekdays = Weekdays::model()->findAll("batch_id IS NULL");
		}
		?> 
        	<div class="att_listbox">
            	
                <?php 
				for ($i = 6; $i >= 0; $i--)
				{ ?>
                <ul>
                <li>
				
				<?php 
				$weekday_number = date('N', strtotime("-$i days")); 
				if($weekday_number==7)
				{
					$weekday_number =0 ;
				}
				
				$date = date('Y-m-d', strtotime("-$i days")); ?> 
                
				<?php echo $date ;echo date('D', strtotime("-$i days")); ?>
                
                </li>
                
                <?php if($weekdays[$weekday_number]['weekday']==0)
				{
					 echo '<li></li>';
                }
				else
				{
					$attendance = StudentAttentance::model()->findByAttributes(array('date'=>date('Y-m-d', strtotime("-$i days")),'student_id'=>$student->id)); 
					if($attendance and $attendance!=NULL)
					{
						echo '<li class="bg_white_cross"></li>';
					}
					else
					{
						echo '<li class="bg_white_tick"></li>';
					}
				}
					
					?></ul>
                <?php }?>
                	
                   
                
            </div>
            
            <?php 
			
			}
			else
			{
			  //echo Yii::t('app','You are not Enrolled in any Course/Batch');
			  echo Yii::t('app','You are not Enrolled in any').' '.Yii::app()->getModule("students")->labelCourseBatch();
			}
			?>
            <div class="clear"></div>
            	<div class="att_bottom">
            	<ul>
                
                	<!--<li><div class="dash_submit"></div><a href="#">Submit Attendance</a></li>-->
                                    <li><div class="dash_eye"></div><?php echo CHtml::link(Yii::t('app','View Attendance'), array('/studentportal/default/attendance'));?></li>
                   
                   <!-- <li><div class="dash_leave"></div><a href="#">Leave Applicatione</a></li>-->
                    
                </ul>
                
            </div>
            
            
        
    </div>
    
    <?php }} ?>
    
    
    <!------------class exam starting----------------->
    
    <?php 
	if(($rolename=='student' or $rolename=='parent') and isset($student_user_id))
	{ 
	if($student and $student!=NULL)
	{?>
    <div class="dash_box6 for_student_exam">
    	<div class="dash_subhed class_exams"><?php echo Yii::t('app','Class Exams'); ?></div>
        <div class="mousescroll Default">
       
	 <?php if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
        { 
		$criteria = new CDbCriteria;
		
		$criteria->condition='student_id=:x';
		$criteria->params = array(':x'=>$student->id);
		$criteria->order = 'exam_id DESC';
		$criteria->limit = 10 ;
		$exams = ExamScores::model()->findAll($criteria);
		
		?>

<table width="254" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th  height="35"><?php echo Yii::t('app','Exam'); ?></th>
    <th  height="35"><?php echo Yii::t('app','Subject'); ?></th>
    <th><?php echo Yii::t('app','Mark'); ?></th>
  </tr>
  
  <?php foreach($exams as $exam)
						{
							$exm=Exams::model()->findByAttributes(array('id'=>$exam->exam_id));
							$group=ExamGroups::model()->findByAttributes(array('id'=>$exm->exam_group_id));
							$sub=Subjects::model()->findByAttributes(array('id'=>$exm->subject_id));
							if($sub->elective_group_id!=0 and $sub->elective_group_id!=NULL)
									{
										
										$student_elective = StudentElectives::model()->findByAttributes(array('student_id'=>$student->id));
										if($student_elective!=NULL)
										{
											$electname = Electives::model()->findByAttributes(array('id'=>$student_elective->elective_id,'elective_group_id'=>$sub->elective_group_id));
											if($electname!=NULL)
											{
												$subjectname = $electname->name;
											}
										}
									
										
									}
									else
									{
										$subjectname = $sub->name;
									} ?>
                                    <?php if($group->is_published==1)
									{ ?>
  <tr>
    <td><?php echo $group->name ; ?></td>
    <td><?php echo $subjectname ; ?></td>
    <td><?php echo $exam->marks ; ?></td>
  </tr>
  <?php }} ?>
 
  
</table>

 <?php 
			
			}
			else
			{
			
			  echo Yii::t('app','You are not enrolled in any').' '.Yii::app()->getModule("students")->labelCourseBatch();
			}
			?>

</div>

<div class="dash_bottom">
            	<ul>
                	<li></li>
                    <li><div class="dash_eye"></div><?php echo CHtml::link(Yii::t('app','View Results'), array('/studentportal/default/exams'));?></li>
                    <!--<li><div class="dash_sub"></div><a href="#">Take exam</a></li>-->
                </ul>
            </div>
    </div> 
    <?php }} ?>
    
    <!------------class exam ending----------------->
    
    <?php $mailbox_messages = new CActiveDataProvider(News::model()->inbox(Yii::app()->user->Id)); 
	
	
	?>
    <div class="dash_box7">
    	<div class="dash_subhed_mail mail_list"><?php echo Yii::t('app','Mailbox'); ?></div>
        
        
<div class="mousescroll Default ps-container mail_dashnew ">
	<ul>
           
        <?php $this->widget('zii.widgets.CListView', array(
    'id'=>'mailbox',
    'dataProvider'=>$mailbox_messages,
    'itemView'=>'_news_list',
	'template'=>'{items}',
	
)); ?>
</ul>
        </div>
       
    </div>
    
    <div class="clear"></div>
    <div id="jobDialog"></div>

</div>