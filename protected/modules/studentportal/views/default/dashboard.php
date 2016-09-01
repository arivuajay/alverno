<style>
.scrollbox1 {
   overflow: auto;
    width: auto !important;
    height: 440px;
    padding: 0 5px;
}
.scrollbox2 {
   overflow: auto;
    width: auto !important;
    height:376px;
    padding: 0 5px;
}
.scrollbox3 {
   overflow: auto;
    width: auto !important;
    height: 155px;
    padding: 0 5px;
}
.scrollbox4 {
   overflow: auto;
    width: auto !important;
    height:339px;
    padding: 0 5px;
}
.scrollbox5 {
   overflow: auto;
    width: auto !important;
    height:359px;
    padding: 0 5px;
}

button, input[type="submit"]{ border: 0px solid #cbcbcb !important;
    border-radius: 0px !important;
	padding: 12px 6px !important;}
	
.ui-dialog .ui-dialog-titlebar{ padding:0px;
	position:inherit;}
	
.ui-widget-content{ box-shadow:0px;
	padding:0px !important;}
	
.e_pop_bttm{ min-height:40px !important; }

.e_pop_top{ min-height:122px !important}

.ui-widget-header{ border:0px !important;
	background:none !important;}
	
</style>
<script language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/enscroll-0.6.1.min.js"></script>
<?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>1)); ?>
 <?php $this->renderPartial('leftside');?> 
 
 <div class="pageheader">
      <h2><i class="fa fa-home"></i><?php echo Yii::t('app','Dashboard');?><span><?php echo Yii::t('app','View your dashboard here');?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t('app','You are here:');?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
          <li class="active"><?php echo Yii::t('app','Dashboard');?></li>
        </ol>
      </div>
    </div>
    
    
     <div class="contentpanel">
    	<div class="col-sm-9 col-lg-12">
            <div class="row">
            <div class="col-md-6">
            <div class="people-item" style="height:560px; overflow:hidden;">
            <div class="table-responsive">
            <div class="panel-heading">
              <!--<div class="panel-btns">
                <a class="panel-close" href="#">×</a>
                <a class="minimize" href="#">−</a>
              </div>--><!-- panel-btns -->
              <h4 class="panel-title"><i class="fa fa-bullhorn"></i><?php echo Yii::t('app','News');?></h4>
              
            </div>
     		<div class="scrollbox1">
    <?php 
	$newss = DashboardMessage::model()->findAllByAttributes(array('recipient_id'=>Yii::app()->getModule('mailbox')->newsUserId));
	if($newss and $newss!=NULL)
	{ 
		 foreach($newss as $news)
		 { ?>
                    
           <div id="home3" class="tab-pane active">
            <h4 class="dark"><?php echo @Mailbox::model()->findByAttributes(array('conversation_id'=>$news->conversation_id))->subject ;?></h4>
            <p><?php echo $news->text; ?></p>
          </div>
					
					
	<?php }
	}
	else
	{?>
    
    		<div id="home3" class="tab-pane active">
            <h4 class="dark"><?php echo Yii::t('app','No News');?></h4>
            <p>. . . .</p>
          </div>
               
    <?php } ?>
      </div>
          </div>
          
          
                <!-- panel -->
                
            </div>
            </div>
            
            <div class="col-md-6">
            <div class="people-item" style="height:; overflow:hidden;">
            <div class="table-responsive">
            <div class="panel-heading">
              <!--<div class="panel-btns">
                <a class="panel-close" href="#">×</a>
                <a class="minimize" href="#">−</a>
              </div>--><!-- panel-btns -->
              <h4 class="panel-title"><i class="fa fa-calendar"></i><?php echo Yii::t('app','Events');?></h4>
              
            </div>
           
            <ul class="nav nav-tabs nav-dark">
          <li class="active"><a data-toggle="tab" href="#home2"><strong><?php echo Yii::t('app','Today');?></strong></a></li>
          <li><a data-toggle="tab" href="#profile2"><strong><?php echo Yii::t('app','Current Week');?></strong></a></li>
          <li><a data-toggle="tab" href="#about2"><strong><?php echo Yii::t('app','Next Week');?></strong></a></li>
          <li><a data-toggle="tab" href="#contact2"><strong><?php echo Yii::t('app','Next month');?></strong></a></li>
        </ul>
        
        <?php 
		$roles = Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
        foreach($roles as $role)
        {
            $rolename = $role->name;
        }
        
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
        
                <div class="tab-content mb30 scrollbox2" >
          <div id="home2" class="tab-pane active">
         <div class="widget-messaging">
          <ul>
          <?php 
		if($events_sameday and $events_sameday!=NULL)
		{
		foreach($events_sameday as $event_sameday)
		{
			if($settings!=NULL)
			{	
				$time=Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
				date_default_timezone_set($time->timezone);
				$date_1 = date($settings->displaydate,$event_sameday->start);
				$time=date($settings->timeformat,$event_sameday->start);
				
			}
			
			echo '<li>';
			echo '<small class="pull-right">'.$date_1.'&nbsp;&nbsp;  '.$time.'</small>';
			echo CHtml::ajaxLink('<h4 class="sender">'.substr($event_sameday->title,0,25).'</h4>'
				,$this->createUrl('default/view',array('event_id'=>$event_sameday->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_sameday->id,'class'=>'add'));
				echo '<small>'.substr($event_sameday->desc,0,50).'</small>';
				
				echo '</li>';
		}
		}
		else
		{
			echo '<p style="padding:40px; text-align:center;">'.Yii::t('app','No Events Today').'</p>';
		}
		?>
          </ul>
         </div> 
          
          
          </div>
          <div id="profile2" class="tab-pane">
          	 <div class="widget-messaging">
          <ul>
            <?php 
				if($events_sameweek and $events_sameweek!=NULL)
				{
				foreach($events_sameweek as $event_sameweek)
				{
					
					if($settings!=NULL)
					{	
						$time=Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
						date_default_timezone_set($time->timezone);
						
						$date_1 = date($settings->displaydate,$event_sameweek->start);
						$time=date($settings->timeformat,$event_sameweek->start);
					}		
					echo '<li>';
					echo '<small class="pull-right">'.$date_1.'&nbsp;&nbsp;'.$time.'</small>';
					echo CHtml::ajaxLink('<h4 class="sender">'.substr($event_sameweek->title,0,25).'</h4>'
						,$this->createUrl('default/view',array('event_id'=>$event_sameweek->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_sameweek->id,'class'=>'add'));
						echo '<small>'.substr($event_sameweek->desc,0,50).'</small>';
						
						echo '</li>';
				
				
				
				
				
				}
				}
				else
				{
					echo '<p style="padding:40px; text-align:center;">'.Yii::t('app','No Upcoming Events This week').'</p>';
				}
				?>
                </ul></div>
          </div>
          <div id="about2" class="tab-pane">
           <div class="widget-messaging">
          <ul>
            <?php 
				if($events_nextweek and $events_nextweek!=NULL)
				{
				foreach($events_nextweek as $event_nextweek)
				{ 
					if($settings!=NULL)
					{	
						$time=Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
						date_default_timezone_set($time->timezone);
						
						$date_1 = date($settings->displaydate,$event_nextweek->start);
						$time=date($settings->timeformat,$event_nextweek->start);	
					}	
					echo '<li>';
					echo '<small class="pull-right">'.$date_1.'&nbsp;&nbsp;'.$time.'</small>';
					echo CHtml::ajaxLink('<h4 class="sender">'.substr($event_nextweek->title,0,25).'</h4>'
					,$this->createUrl('default/view',array('event_id'=>$event_nextweek->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_nextweek->id,'class'=>'add'));
					echo '<small>'.substr($event_nextweek->desc,0,50).'</small>';
				
				echo '</li>';
				}
				}
				else
				{
					echo '<p style="padding:40px; text-align:center;">'.Yii::t('app','No Upcoming Events Next Week').'</p>';
				}
				?>
                </ul></div>
          </div>
          <div id="contact2" class="tab-pane">
           <div class="widget-messaging">
          <ul>
            <?php 
				if($events_nextmonth and $events_nextmonth!=NULL)
				{
				foreach($events_nextmonth as $event_nextmonth)
				{
					if($settings!=NULL)
					{	
						$time=Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
						date_default_timezone_set($time->timezone);
					
						$date_1 = date($settings->displaydate,$event_nextmonth->start);
						$time=date($settings->timeformat,$event_nextmonth->start);
					}	
					echo '<li>';
					echo '<small class="pull-right">'.$date_1.'&nbsp;&nbsp;'.$time.'</small>';
					echo CHtml::ajaxLink('<h4 class="sender">'.substr($event_nextmonth->title,0,25).'</h4>'
					,$this->createUrl('default/view',array('event_id'=>$event_nextmonth->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$event_nextmonth->id,'class'=>'add'));
					echo '<small>'.substr($event_nextmonth->desc,0,50).'</small>';
					
				}
				}
				else
				{
					echo '<p style="padding:40px; text-align:center;">'.Yii::t('app','No Upcoming Events Next Month').'</p>';
				}
				?>
                </ul></div>
          </div>
        </div>
          
          </div>
         
          
                <!-- panel -->
                
            </div>
            <div id="jobDialog"></div>
            </div>
            
            
            
            
            
             </div>
             <div class="row">
            
            <div class="col-md-4">
            <div class="people-item" style="height:350px; overflow:hidden;">
            <div class="table-responsive">
            <div class="panel-heading">
              <!--<div class="panel-btns">
                <a class="panel-close" href="#">×</a>
                <a class="minimize" href="#">−</a>
              </div>--><!-- panel-btns -->
             


              <h4 class="panel-title"><i class="fa fa-file-text"></i><?php echo Yii::t('app','Attendance');?></h4>
              
            </div>
           <div class="row" style="padding:10px 0px; text-align:center;"><?php echo Yii::t('app','Last 7 days of');?> &nbsp;  <strong><?php echo ' '.date('Y F'); ?></strong></div>
           <div class="table-responsive">
      
  <?php 
  		$student = Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
  		if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
        { 
		
		$criteria = new CDbCriteria;
		$criteria->condition = "batch_id=:x and weekday!=:y";
		$criteria->params = array(':x'=>$student->batch_id,':y'=>0);
		$weekdays = Weekdays::model()->findAll($criteria);  
		
		$annual_holidays = Holidays::model()->findAll();
		$holidays = array();
		foreach($annual_holidays as $annual_holiday){
			$holidays[] = date('Y-m-d',$annual_holiday->start);
		}
		
		$check_weekday = array();
		foreach($weekdays as $weekday){
			$check_weekday[] = $weekday->weekday;
		}
		
		/*if(count($weekdays)!=7)
		{
			$weekdays = Weekdays::model()->findAll("batch_id IS NULL");
		}*/
		?> 
        	<table class="table mb30">
            <thead>
              		<tr>	
                <?php 
				for ($i = 6; $i >= 0; $i--)
				{ ?>
                 <td><?php 
				$weekday_number = date('N', strtotime("-$i days")) + 1; 
				if($weekday_number==8)
				{
					$weekday_number = 1 ;
				}

					$date = date('d', strtotime("-$i days"));
					echo date('D', strtotime("-$i days")).'<br/>';echo $date;
				?>
                 </th>
                 <?php } ?>
                 </tr></thead>
                 <tbody>
              <tr>
                <?php 
				for ($i = 6; $i >= 0; $i--)
				{ 
				$weekday_number = date('N', strtotime("-$i days")) + 1; 
				if($weekday_number==8)
				{
					$weekday_number = 1 ;
				}
				$date = date('Y-m-d', strtotime("-$i days"));
				if(in_array($weekday_number,$check_weekday) and !in_array($date,$holidays)){
					/*if($weekdays[$weekday_number]['weekday']==0)
					{
						 echo '<li></li>';
					}
					else
					{*/
						$attendance = StudentAttentance::model()->findByAttributes(array('date'=>date('Y-m-d', strtotime("-$i days")),'student_id'=>$student->id)); 
						if($attendance and $attendance!=NULL)
						{
							echo '<td><span  class="bg_white_cross"></span></td>';
						}
						else
						{
							echo '<td><span  class="bg_white_tick"></span></td>';
						}
					//}
				}else{
					if(in_array($date,$holidays)){
						echo '<td><span class="holiday-mark" title="Holiday">H</span></td>';
					}else{
						echo '<td><span class="weekend-mark" title="Weekend">W</span></td>';
					}
				}
					
					?>
                <?php }?>
                	
                 </tr>
              
            </tbody>  
                
            </table>
            
            
            <?php 
			
			}
			else
			{
			  echo Yii::t('app','You are not Enrolled in any').' '.Yii::app()->getModule("students")->labelCourseBatch();
			}
			?>
         </div>
          
                <!-- panel -->
                
            </div>
            </div>
            </div>
			
			<div class="col-md-4">
            <div class="people-item" style="height:350px; overflow:hidden;">
            <div class="table-responsive">
            <div class="panel-heading">
              <!--<div class="panel-btns">
                <a href="#" class="panel-close">×</a>
                <a href="#" class="minimize">−</a>
              </div>--><!-- panel-btns -->
              <h4 class="panel-title"><i class="fa fa-list-alt"></i><?php echo Yii::t('app','Examination');?></h4>
              
            </div>
          
  <?php if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
        { 
			$criteria = new CDbCriteria;
			
			$criteria->condition='student_id=:x';
			$criteria->params = array(':x'=>$student->id);
			$criteria->order = 'exam_id DESC';
			$criteria->limit = 10 ;
			$exams = ExamScores::model()->findAll($criteria);
			
			?>
          
            <div class="table-responsive scrollbox3" style="height:200px">
          <table class="table table-invoice">
          <tr>
            <th width="30%"  style="text-align:left" height="35"><?php echo Yii::t('app','Exam');?></th>
            <th  width="30%"  style="text-align:left" height="35"><?php echo Yii::t('app','Subject');?></th>
            <th  width="30%" style="text-align:left"><?php echo Yii::t('app','Mark');?></th>
          </tr>
          
          <?php foreach($exams as $exam)
                                {
                                    $exm=Exams::model()->findByAttributes(array('id'=>$exam->exam_id));
                                    $group=ExamGroups::model()->findByAttributes(array('id'=>$exm->exam_group_id));
									
									 $criteria = new CDbCriteria;
									 $criteria->condition = 'batch_id=:x';
									 $criteria->params = array(':x'=>$group->batch_id);	
									 $criteria->order = 'min_score DESC';
									 $grades = GradingLevels::model()->findAll($criteria);
									
			                        $t = count($grades); 
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
                                            <?php if($group->result_published==1)
                                            { ?>
          <tr>
            <td width="30%" style="text-align:left"><?php echo $group->name ; ?></td>
            <td width="30%" style="text-align:left"><?php echo $subjectname ; ?></td>
            <!--<td width="30%" style="text-align:left"><?php //echo $exam->marks ; ?></td>-->
            <td width="30%" style="text-align:left"><?php 
			if($group->exam_type == 'Marks')
			{
				echo $exam->marks ;
			}
			 else if($group->exam_type == 'Grades') {
				 foreach($grades as $grade)
						{
							
						 if($grade->min_score <= $exam->marks)
							{	
								$grade_value =  $grade->name;
							}
							else
							{
								$t--;
								
								continue;
								
							}
						echo $grade_value ;
						break;
						
						}
						if($t<=0) 
							{
								$glevel = " No Grades" ;
							}
				 }
				 
				 else if($group->exam_type == 'Marks And Grades'){
					 foreach($grades as $grade)
						{
							
						 if($grade->min_score <= $exam->marks)
							{	
								$grade_value =  $grade->name;
							}
							else
							{
								$t--;
								
								continue;
								
							}
						echo $exam->marks . " & ".$grade_value ;
						break;
						
							
						} 
						if($t<=0) 
							{
								echo $exam->marks." & ".Yii::t('app','No Grades');
							}
						 } 
									
			?>
            
            </td>
            
            
          </tr>
          <?php }} ?>
         
          
        </table>
          </div>
   <?php } ?>
          </div>
         
          
                <!-- panel -->
                
            </div>
            </div>
			
            <div class="col-md-4">
            <div class="people-item" style="height:350px; overflow:hidden;">
            <div class="table-responsive">
            <div class="panel-heading">
              <!--<div class="panel-btns">
                <a class="panel-close" href="#">×</a>
                <a class="minimize" href="#">−</a>
              </div>--><!-- panel-btns -->
              <h4 class="panel-title"><i class="fa fa-columns"></i><?php echo Yii::t('app','Time table');?></h4>
              <?php 
		  	$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
			if($settings!=NULL)
			{	
				echo date($settings->displaydate,strtotime(date('Y-m-d')));
											
			}
			else
				echo date('Y-m-d'); 
		  
		 ?>
            </div>
          
            <div class="table-responsive scrollbox4" style="height:200px">
       
            
            <?php 
            		$student = Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id)) ;
					if($student and $student!=NULL)
					{
					?>
				<div class="dash_box4 for_student_box4">
					
					
				
			<?php if($student->batch_id and ($student->batch_id !=NULL or $student->batch_id!=0))
			{ 
			
			$check_entry = TimetableEntries::model()->findAllByAttributes(array('batch_id'=>$student->batch_id));
			
			if($check_entry and $check_entry!=NULL)
			{
				
			$TimetableEntries = TimetableEntries::model()->findAllByAttributes(array('batch_id'=>$student->batch_id,'weekday_id'=>date('N')+1));
			
			
			//var_dump($TimetableEntries);exit;
			if($TimetableEntries and $TimetableEntries!=NULL)
			{
			?>
			<table  border="0" cellspacing="0" cellpadding="0" class="table table-invoice">
			  <tr>
				<th width="50%"><?php echo Yii::t('app','Time');?></th>
				<th width="50%"><?php echo Yii::t('app','Subject');?></th>
			  </tr>
			  <?php foreach($TimetableEntries as $TimetableEntry)
			  { ?>
			  <tr>
				
				<?php 
				
				$ClassTiming= ClassTimings::model()->findByAttributes(array('id'=>$TimetableEntry->class_timing_id)); 
				
				if($ClassTiming and $ClassTiming!=NULL)
				{ 
					if($TimetableEntry->is_elective == 2){	
					
					$subject = Electives::model()->findByAttributes(array('id'=>$TimetableEntry->subject_id));
					$existing_elective = StudentElectives::model()->findByAttributes(array('elective_id'=>$subject->id,'student_id'=>$student->id));
					if($existing_elective!=NULL){
				?>
					<td width="50%"><div class="dash_blue"><?php echo $ClassTiming->start_time.' - '.$ClassTiming->end_time ?></div></td> 
					<td width="50%" style="text-align:left;">
                    <?php
					  if($subject and $subject!=NULL)
					  {
						  echo $subject->name;
					  }
					  else
					  {
						  echo '----';
					  }
					}
					  ?>
                     </td>	
				<?php 
					}else{
				?>
                	<td width="50%"><div class="dash_blue"><?php echo $ClassTiming->start_time.' - '.$ClassTiming->end_time ?></div></td>
                	<td width="50%" style="text-align:left;"><?php $subject = Subjects::model()->findByAttributes(array('id'=>$TimetableEntry->subject_id));
					  if($subject and $subject!=NULL)
					  {
						  echo $subject->name;
					  }
					  else
					  {
						  echo '----';
					  }?>
                     </td>	
                <?php		
					}
				}
				else
				{ ?>
					<td><div class="dash_blue">..</div></td>
				<td>..</td>
				<?php }
				
				?>
				
				
				
			  </tr>
			  <?php } ?>
			  
			  
			</table>
            <div style="text-align:right;"><?php echo CHtml::link(Yii::t('app','More'), array('/studentportal/default/timetable'));?></div>
			<?php }
			else
			{
				echo '<p style="padding:40px 0px; text-align:center;">'.Yii::t('app','No Classes Scheduled for Today').'</p>';
			}}
			else
			{
				echo Yii::t('app','Time Table not available for your').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
			}
			}
			else
			{
				echo Yii::t('app','You are not Enrolled in any').' '.Yii::app()->getModule("students")->labelCourseBatch();
			}
			?>
			
			
				</div>
    
    <?php } ?>

          
          </div>
          </div>
         
          
                <!-- panel -->
                
            </div>
            </div>
       
       
       <div class="col-sm-9 col-lg-12">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                    
                        
                        <!-- pull-right -->
                        <div class="panel-heading">
             
              <h4 class="panel-title"><i class="fa fa-envelope"></i><?php echo Yii::t('app','Mailbox');?></h4>
              
            </div>
                       <div class="scrollbox5"> 
                        <?php 
						$mailbox_messages = new CActiveDataProvider(Mailbox::model()->inbox(Yii::app()->user->Id)); 
						$this->widget('zii.widgets.CListView', array(
						'id'=>'mailbox',
						'dataProvider'=>$mailbox_messages,
						'itemView'=>'_news_list',
						'template'=>'{items}',
						
					)); ?>
											<!-- table-responsive -->
                       </div> 
                    </div><!-- panel-body -->
                </div><!-- panel -->
                
            </div>
      
    </div>

    <script>
     
$('.scrollbox1 .scrollbox2 .scrollbox3 .scrollbox4 .scrollbox5').enscroll({
    showOnHover: true,
    verticalTrackClass: 'track3',
    verticalHandleClass: 'handle3'
}); 
</script>
