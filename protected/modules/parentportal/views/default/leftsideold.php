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
							echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'"  width="40" height="41" />';
						}
						elseif($student->gender=='M')
						{
							echo '<img  src="images/portal/p-small-male_img.png" alt='.$student->first_name.' />'; 
						}
						elseif($student->gender=='F')
						{
							echo '<img  src="images/portal/p-small-female_img.png" alt='.$student->first_name.' />';
						}
						?>
                <div class="media-body">
                    <h4><?php echo ucfirst($student->last_name.' '.$student->first_name);?></h4>
                   
                </div>
            </div>
          
            <h5 class="sidebartitle actitle">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
              <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-user"></i>'.Yii::t('app','My Account'),array('/studentportal/default/profile'),array('class'=>'profile')); ?> </li>
                <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-cog"></i>'.Yii::t('app','Settings'),array('/user/accountProfile'),array('class'=>'profile')); ?> </li>
                <li> <?php echo CHtml::link('<i class="glyphicon glyphicon-log-out"></i>'.Yii::t('app','Logout'), array('/user/logout'));?> </li>
            </ul>
        </div>
         <h5 class="sidebartitle"><?php echo Yii::t('app','Navigation'); ?></h5>
         <ul class="nav nav-pills nav-stacked nav-bracket">
          <li>
            <?php
			if(Yii::app()->controller->module->id=='portalmailbox' and  Yii::app()->controller->id!='news')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-envelope-o"></i> <span>'.Yii::t('app','Messages').'</span>',array('/portalmailbox'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-envelope-o"></i> <span>'.Yii::t('app','Messages').'</span>',array('/portalmailbox'));
				echo '</li>';
			}
			?>
           </li>
           <li>
            <?php
			if(Yii::app()->controller->id=='news')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-book"></i> <span>'.Yii::t('app','News').'</span>',array('/portalmailbox/news'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-book"></i> <span>'.Yii::t('app','News').'</span>',array('/portalmailbox/news'));
				echo '</li>';
			}
			?>
           </li>
             <li>
            <?php
			if(Yii::app()->controller->action->id=='event')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-pencil-square-o"></i> <span>'.Yii::t('app','Events').'</span>',array('/dashboard/default/event'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-pencil-square-o"></i> <span>'.Yii::t('app','Events').'</span>',array('/dashboard/default/event'));
				echo '</li>';
			}
           
			?>
            </li>
            <li>
            <?php
			if(Yii::app()->controller->action->id=='eventlist')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-calendar"></i> <span>'.Yii::t('app','Calendar').'</span>',array('/parentportal/default/eventlist'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-calendar"></i> <span>'.Yii::t('app','Calendar').'</span>',array('/parentportal/default/eventlist'));
				echo '</li>';
			}
           
			?>
            </li>
             
           <li>
           <?php
		   	if(Yii::app()->controller->id == 'default' and Yii::app()->controller->action->id == 'profile')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-user"></i> <span>'.Yii::t('app','Profile').'</span>',array('/parentportal/default/profile'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-user"></i> <span>'.Yii::t('app','Profile').'</span>',array('/parentportal/default/profile'));
				echo '</li>';
			}
		   ?>
           </li>
           
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='studentprofile' or Yii::app()->controller->action->id=='documentupdate')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-male"></i> <span>'.Yii::t('app','Student Profile').'</span>',array('/parentportal/default/studentprofile'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-male"></i> <span>'.Yii::t('app','Student Profile').'</span>',array('/parentportal/default/studentprofile'));
				echo '</li>';
			}
		   ?>
           </li>
           
           <?php /*?><li>
           <?php
		   	if(Yii::app()->controller->action->id=='step1')
			{
				echo '<li class="active">';
				echo CHtml::link(Yii::t('app','<i class="fa fa-user"></i> <span>Add Student</span>'),array('/onlineadmission/registration/step1'),array("target"=>"_blank"));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link(Yii::t('app','<i class="fa fa-user"></i> <span>Add Student</span>'),array('/onlineadmission/registration/step1'),array("target"=>"_blank"));
				echo '</li>';
			}
		   ?>
           </li><?php */?>
            <li>
           <?php
		   	if(Yii::app()->controller->action->id=='checkStatus')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-desktop"></i> <span>'.Yii::t('app','Online Admission').'</span>',array('/parentportal/default/checkStatus'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-desktop"></i> <span>'.Yii::t('app','Online Admission').'</span>',array('/parentportal/default/checkStatus'));
				echo '</li>';
			}
		   ?>
           </li>
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='course')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-list-alt"></i> <span>'.Yii::t('app','Course').'</span>',array('/parentportal/default/course'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-list-alt"></i> <span>'.Yii::t('app','Course').'</span>',array('/parentportal/default/course'));
				echo '</li>';
			}
		   ?>
           </li>   
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='lognotice')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="glyphicon glyphicon-log-in"></i> <span>'.Yii::t('app','Log').'</span>',array('/parentportal/default/lognotice'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="glyphicon glyphicon-log-in"></i> <span>'.Yii::t('app','Log').'</span>',array('/parentportal/default/lognotice'));
				echo '</li>';
			}
		   ?>
           </li>   
             <li>
           <?php
		   	if(Yii::app()->controller->action->id=='attendance')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-file-text"></i> <span>'.Yii::t('app','Attendance').'</span>',array('/parentportal/default/attendance'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-file-text"></i> <span>'.Yii::t('app','Attendance').'</span>',array('/parentportal/default/attendance'));
				echo '</li>';
			}
		   ?>
           </li>
           
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='fees')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa fa-money"></i> <span>'.Yii::t('app','Fees').'</span>',array('/parentportal/default/fees'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa fa-money"></i> <span>'.Yii::t('app','Fees').'</span>',array('/parentportal/default/fees'));
				echo '</li>';
			}
		   ?>
           </li>    
            
           <li>
           <?php
		   	if(Yii::app()->controller->action->id=='exams')
			{
				echo '<li class="active">';
				echo CHtml::link('<i class="fa fa-pencil"></i> <span>'.Yii::t('app','Exams').'</span>',array('/parentportal/default/exams'));
				echo '</li>';
			}
			else
			{
				echo '<li>';
				echo CHtml::link('<i class="fa fa-pencil"></i> <span>'.Yii::t('app','Exams').'</span>',array('/parentportal/default/exams'));
				echo '</li>';
			}
		   ?>
           </li>                   
           <li>
           <?php
		   		if(Yii::app()->controller->module->id == 'user')
				{
					echo '<li class="active">';
					echo CHtml::link('<i class="fa fa-gear"></i> <span>'.Yii::t('app','Settings').'</span>',array('/user/accountProfile'));
					echo '</li>';
				}
				else
				{
		   			echo CHtml::link('<i class="fa fa-gear"></i> <span>'.Yii::t('app','Settings').'</span>',array('/user/accountProfile'));
				}
		   ?>
           </li> 
           </ul>
</div>
</div>
  