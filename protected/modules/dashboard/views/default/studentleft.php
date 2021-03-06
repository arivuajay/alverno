<div class="leftpanel">
    
    <div class="logopanel">
        <h1><span></span>
        	 <?php $logo=Logo::model()->findAll();?>
                <?php
                if($logo!=NULL)
                {
					//echo $logo[0]->photo_file_name;
					//Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
					echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" border="0" height="55" />';
                }
                ?>
        <span></span></h1>
    </div><!-- logopanel -->
        
    <div class="leftpanelinner">    
        
        <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">   
            <div class="media userlogged">
                <?php 
                        //$user=User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                        $student=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
                        //$guard=Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
                        ?>
            	<?php
						 if($student->photo_file_name!=NULL)
						 { 
						 	$path = Students::model()->getProfileImagePath($student->id);
							echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" class="media-object" />';
						}
						elseif($student->gender=='M')
						{
							echo '<img  src="images/portal/p-small-male_img.png" alt='.$student->first_name.' class="media-object" />'; 
						}
						elseif($student->gender=='F')
						{
							echo '<img  src="images/portal/p-small-female_img.png" alt='.$student->first_name.' class="media-object"  />';
						}
						?>
                <div class="media-body">
                    <h4><?php echo ucfirst($student->last_name.' '.$student->first_name);?></h4>
                    
                </div>
            </div>
          
            <h5 class="sidebartitle actitle">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
              <li><?php echo CHtml::link(Yii::t('studentportal','<i class="glyphicon glyphicon-user"></i> My Profile'),array('/studentportal/default/profile'),array('class'=>'profile')); ?></li>
                <li><?php echo CHtml::link(Yii::t('studentportal','<i class="glyphicon glyphicon-cog"></i> Account Settings'),array('/user/accountprofile'),array('class'=>'profile')); ?></li>
                <li><?php echo CHtml::link('<i class="glyphicon glyphicon-log-out"></i> Log Out', array('/user/logout'));?></li>
            </ul>
        </div>
      
      <h5 class="sidebartitle">Navigation</h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">
           
           <?php 
			if(Yii::app()->controller->module->id=='studentportal' and  Yii::app()->controller->action->id =='dashboard')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-home"></i> <span>Dashboard</span>'),array('/studentportal/default/dashboard'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-home"></i> <span>Dashboard</span>'),array('/studentportal/default/dashboard'));
				echo '</li>';
			}
			?>
            <?php 
			if(Yii::app()->controller->module->id=='mailbox' and  Yii::app()->controller->id!='news')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-envelope-o"></i> <span>Messages</span>'),array('/portalmailbox'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-envelope-o"></i> <span>Messages</span>'),array('/portalmailbox'));
				echo '</li>';
			}
			?>
           
           
            <?php
			if(Yii::app()->controller->id=='news')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-book"></i> <span>News</span>'),array('/portalmailbox/news'));
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-book"></i> <span>News</span>'),array('/portalmailbox/news'));
				echo '</li>';
			}
			?>
          
          <?php
			if(Yii::app()->controller->action->id=='events')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-pencil-square-o"></i> <span>Events</span>'),array('/dashboard/default/events'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-pencil-square-o"></i> <span>Events</span>'),array('/dashboard/default/events'));
				echo '</li>';
			}
           
			?>
          
            <?php
			if(Yii::app()->controller->action->id=='eventlist')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-calendar"></i> <span>Calendar</span>'),array('/studentportal/default/eventlist'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-calendar"></i> <span>Calendar</span>'),array('/studentportal/default/eventlist'));
				echo '</li>';
			}
           
			?>
           
           <?php
		   		if(Yii::app()->controller->module->id=='portaldownloads' || Yii::app()->controller->id=='students' || Yii::app()->controller->action->id=='authordetails')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-arrow-circle-o-down"></i> <span>Downloads</span>'),array('/portaldownloads/students'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-arrow-circle-o-down"></i> <span>Downloads</span>'),array('/portaldownloads/students'));
				echo '</li>';
			}
		   ?>
          
           <?php
		   	if(Yii::app()->controller->action->id=='profile')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-user"></i> <span>Profile</span>'),array('/studentportal/default/profile'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-user"></i> <span>Profile</span>'),array('/studentportal/default/profile'));
				echo '</li>';
			}
		   ?>
          
          
          
           <?php
		   	if(Yii::app()->controller->action->id=='attendance')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-file-text"></i> <span>Attendance</span>'),array('/studentportal/default/attendance'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-file-text"></i> <span>Attendance</span>'),array('/studentportal/default/attendance'));
				echo '</li>';
			}
		   ?>
          
           <?php
		   	if(Yii::app()->controller->action->id=='timetable')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-dedent"></i> <span>TimeTable</span>'),array('/studentportal/default/timetable'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-dedent"></i> <span>TimeTable</span>'),array('/studentportal/default/timetable'),array('class'=>'timetable'));
				echo '</li>';
			}
		   ?>
          
           <?php
		   	if(Yii::app()->controller->action->id=='fees')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-money"></i> <span>Fees</span>'),array('/studentportal/default/fees'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-money"></i> <span>Fees</span>'),array('/studentportal/default/fees'));
				echo '</li>';
			}
		   ?>
           
           <?php
		   	if(Yii::app()->controller->action->id=='exams')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-pencil"></i> <span>Exams</span>'),array('/studentportal/default/exams'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('studentportal','<i class="fa fa-pencil"></i> <span>Exams</span>'),array('/studentportal/default/exams'));
				echo '</li>';
			}
		   ?>
          
          
         
         
           
           <?php
		   		if(Yii::app()->controller->module->id == 'user')
				{
					echo '<li class="active">';
					echo CHtml::link(Yii::t('studentportal','<i class="fa fa-gear"></i> <span>Settings</span>'),array('/user/accountprofile'));
					echo '</li>';
				}
				else
				{
					echo '<li>';
		   			echo CHtml::link(Yii::t('studentportal','<i class="fa fa-gear"></i> <span>Settings</span>'),array('/user/accountprofile'));
					echo '</li>';
				}
		   ?>     
             
            </ul>

    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->






  <div id="parent_leftSect">
       
        	
      
        </div>