<div class="leftpanel">
	<div class="logopanel">
        <h1><span></span>
        
        
          <?php $logo=Logo::model()->findAll();?>
          <?php
                if($logo!=NULL)
                {
					//echo $logo[0]->photo_file_name;
					//Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
					echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" border="0" height="55" class="img-responsive" />';
                }
                ?>
          <!--<img src="images/portal/logo.png" width="190" height="32" />--> 
           <span></span></h1>
    </div><!-- logopanel -->
       
         <div class="leftpanelinner"> 
          <?php 
                    $teacher=Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));                   
                    ?>
                    
                    <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">   
            <div class="media userlogged">
                         
              <?php
					 if($teacher->photo_data!=NULL)
					 { 
						echo '<img  src="'.$this->createUrl('/employees/Employees/DisplaySavedImage&id='.$teacher->primaryKey).'" alt="'.$teacher->photo_file_name.'"  width="40" height="41" />';
					}
					elseif($teacher->gender=='M')
					{
						echo '<img  src="images/portal/p-small-male_img.png" alt='.$teacher->first_name.' />'; 
					}
					elseif($teacher->gender=='F')
					{
						echo '<img  src="images/portal/p-small-female_img.png" alt='.$teacher->first_name.' />';
					}
					?>
                <div class="media-body">
                    <h4><?php echo ucfirst($teacher->last_name.' '.$teacher->first_name);?></h4>
                    
                </div>
            </div>
          
            <h5 class="sidebartitle actitle">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
            <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-user"></i> '.Yii::t('app','My Account'),array('/teachersportal/default/profile'),array('class'=>'profile')); ?> </li>
                <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-cog"></i> '.Yii::t('app','Settings'),array('/user/accountProfile'),array('class'=>'profile')); ?> </li>
                <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-log-out"></i>'.Yii::t('app','Logout'), array('/user/logout'));?> </li>
            </ul>
            </div>
               
       
        	<h5 class="sidebartitle"><?php echo Yii::t('app','Navigation');?></h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
            
            <?php
			if(Yii::app()->controller->module->id=='portalmailbox' and  Yii::app()->controller->id!='news')
			
			{	echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-envelope-o"></i> <span>'.Yii::t('app','Messages').'</span>',array('/portalmailbox'),array('class'=>'mssg_active'));
				echo '</li>';
			}
			else
			{	echo '<li>';
				echo CHtml::link('<i class="fa fa-envelope-o"></i> <span>'.Yii::t('app','Messages').'</span>',array('/portalmailbox'),array('class'=>'mssg'));
				echo '</li>';
			}
			?>
           
           
           
           
            <?php
			if(Yii::app()->controller->id=='news')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-book"></i> <span>'.Yii::t('app','News').'</span>',array('/portalmailbox/news'),array('class'=>'news_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-book"></i> <span>'.Yii::t('app','News').'</span>',array('/portalmailbox/news'),array('class'=>'news'));
				echo '</li>';
			}
			?>
          
            <?php
			if(Yii::app()->controller->id=='leaves')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-check-square"></i> <span>'.Yii::t('app','Leaves').'</span>',array('/teachersportal/leaves/create'),array('class'=>'news_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-check-square"></i> <span>'.Yii::t('app','Leaves').'</span>',array('/teachersportal/leaves/create'),array('class'=>'news'));
				echo '</li>';
			}
			?>
           
           
           <?php /*?> <?php
			if(Yii::app()->controller->action->id=='payslip')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('app','<i class="fa fa-credit-card"></i> <span>Payslip</span>'),array('/teachersportal/default/payslip'),array('class'=>'news_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('app','<i class="fa fa-credit-card"></i> <span>Payslip</span>'),array('/teachersportal/default/payslip'),array('class'=>'news'));
				echo '</li>';
			}
			?><?php */?>
           
           
           
           
           
            <?php
			if(Yii::app()->controller->action->id=='event')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-pencil-square-o"></i> <span>'.Yii::t('app','Events').'</span>',array('/dashboard/default/event'),array('class'=>'attendance_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-pencil-square-o"></i> <span>'.Yii::t('app','Events').'</span>',array('/dashboard/default/event'),array('class'=>'attendance'));
				echo '</li>';
			}
           ?>
            
             <?php
			if(Yii::app()->controller->id=='course')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-list-alt"></i> <span>'.Yii::t('app','My Courses').'</span>',array('/teachersportal/course'),array('class'=>'attendance_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-list-alt"></i> <span>'.Yii::t('app','My Courses').'</span>',array('/teachersportal/course'),array('class'=>'attendance'));
				echo '</li>';
			}
           ?>
            
            
            
            
            <?php
			if(Yii::app()->controller->action->id=='eventlist')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-calendar"></i> <span>'.Yii::t('app','Calendar').'</span>',array('/teachersportal/default/eventlist'),array('class'=>'attendance_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-calendar"></i> <span>'.Yii::t('app','Calendar').'</span>',array('/teachersportal/default/eventlist'),array('class'=>'attendance'));
				echo '</li>';
			}
           
			?>
           
           
           
           
           
           <?php
		   	if(Yii::app()->controller->id=='teachers' and Yii::app()->controller->module->id=='downloads')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-arrow-circle-o-down"></i> <span>'.Yii::t('app', 'Downloads').'</span>',array('/downloads/teachers'),array('class'=>'library_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-arrow-circle-o-down"></i> <span>'.Yii::t('app', 'Downloads').'</span>',array('/downloads/teachers'),array('class'=>'library'));
				echo '</li>';
			}
		   ?>
           
           <?php
		   	if(Yii::app()->controller->id=='default' and Yii::app()->controller->action->id=='achievements')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('app','<i class="fa fa-shield"></i> <span>Rewards & Achievements</span>'),array('/teachersportal/default/achievements'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('app','<i class="fa fa-shield"></i> <span>Rewards & Achievements</span>'),array('/teachersportal/default/achievements'));
				echo '</li>';
			}
		   ?>
           
           
           
           
           
           <?php
		   	if(Yii::app()->controller->action->id=='profile' and Yii::app()->controller->id=='default')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-user"></i> <span>'.Yii::t('app','Profile').'</span>',array('/teachersportal/default/profile'),array('class'=>'profile_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-user"></i> <span>'.Yii::t('app','Profile').'</span>',array('/teachersportal/default/profile'),array('class'=>'profile'));
				echo '</li>';
			}
		   ?>
           
           
           
           
           
           <?php
		   	if(Yii::app()->controller->action->id=='attendance' or Yii::app()->controller->action->id=='employeeattendance' or Yii::app()->controller->action->id=='studentattendance' or Yii::app()->controller->action->id=='tpBatches' or Yii::app()->controller->action->id=='tpAttendance')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-file-text"></i> <span>'.Yii::t('app','Attendance').'</span>',array('/teachersportal/default/attendance'),array('class'=>'attendance_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-file-text"></i> <span>'.Yii::t('app','Attendance').'</span>',array('/teachersportal/default/attendance'),array('class'=>'attendance'));
				echo '</li>';
			}
		   ?>
           
           
           
           
           
           <?php
		   	if(Yii::app()->controller->action->id=='timetable' or Yii::app()->controller->action->id=='employeetimetable'  or Yii::app()->controller->action->id=='studenttimetable')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-dedent"></i> <span>'.Yii::t('app','TimeTable').'</span>',array('/teachersportal/default/timetable'),array('class'=>'attendance_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-dedent"></i> <span>'.Yii::t('app','TimeTable').'</span>',array('/teachersportal/default/timetable'),array('class'=>'attendance'));
				echo '</li>';
			}
		   ?>
           
           
           
           
           <?php
		   
		   	if(Yii::app()->controller->id == 'exams' or Yii::app()->controller->id == 'examScores')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-pencil"></i> <span>'.Yii::t('app','Exams').'</span>',array('/teachersportal/exams/index'),array('class'=>'exams_active'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-pencil"></i> <span>'.Yii::t('app','Exams').'</span>',array('/teachersportal/exams/index'),array('class'=>'exams'));
				echo '</li>';
			}
		   ?>
         
         
         
         
           <?php
		   		if(Yii::app()->controller->module->id == 'user')
				{
					echo '<li class="active">';
					echo CHtml::link('<i class="fa fa-gear"></i> <span>'.Yii::t('app','Settings').'</span>',array('/user/accountProfile'),array('class'=>'settings_active'));
					echo '</li>';
				}
				else
				{
					echo '<li>';
		   			echo CHtml::link('<i class="fa fa-gear"></i> <span>'.Yii::t('app','Settings').'</span>',array('/user/accountProfile'),array('class'=>'settings'));
					echo '</li>';
				}
		   ?>
                             
              
            </ul>
       
       </div><!-- leftpanelinner -->
</div><!-- leftpanel -->