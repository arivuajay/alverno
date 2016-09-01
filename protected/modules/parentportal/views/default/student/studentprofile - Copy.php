<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic' rel='stylesheet' type='text/css'>

<script>
	function getstudent() // Function to see student profile
	{
		var studentid = document.getElementById('studentid').value;
		if(studentid!='')
		{
			window.location= 'index.php?r=parentportal/default/studentprofile&id='+studentid;	
		}
		else
		{
			window.location= 'index.php?r=parentportal/default/studentprofile';
		}
	}
</script>
<?php $this->renderPartial('leftside');?>

	<?php
    $guardian = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $students = Students::model()->findAllByAttributes(array('parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
    $student_list = CHtml::listData($students,'id','studentname');
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
    ?>
			
    <div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-male"></i><?php echo Yii::t('app','Student Profile'); ?> <span><?php echo Yii::t('app','View your profile here'); ?></span></h2>
        </div>
        <div class="col-lg-2">
        
        <?php if(count($students)==1 or (isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)) // Show drop down only if more than 1 student present
        {
        echo CHtml::dropDownList('sid','',$student_list,array('prompt'=>Yii::t('app','Select Student'),'id'=>'studentid','class'=>'form-control input-sm mb14','style'=>'width:auto;','options'=>array($_REQUEST['id']=>array('selected'=>true)),'onchange'=>'getstudent();'));}
        ?>
        </div>
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t('app','Student Profile'); ?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
     <?php
			if(count($students)==1 or (isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)) // Single Student 
			{
				if(count($students)>1) 
				{
			
				$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id'],'parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
				} 
				else
				{
					$student = Students::model()->findByAttributes(array('parent_id'=>$guardian->id,'is_active'=>'1','is_deleted'=>'0'));
						
				}
				 
			?> 
                <div class="contentpanel">
                    <!--<div class="col-sm-9 col-lg-12">-->
                     <div>   	
                        <div class="people-item">
                          <div class="media">
                            <a href="#" class="pull-left">
                                <?php
                                 if($student->photo_file_name!=NULL)
                                 { 
								 	$path = Students::model()->getProfileImagePath($student->id);
                                    echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" width="100" height="103" class="thumbnail media-object" />';
                                }
                                elseif($student->gender=='M')
                                {
                                    echo '<img  src="images/portal/prof-img_male.png" alt='.$student->first_name.' width="100" height="103" class="thumbnail media-object" />'; 
                                }
                                elseif($student->gender=='F')
                                {
                                    echo '<img  src="images/portal/prof-img_female.png" alt='.$student->first_name.' width="100" height="103" class="thumbnail media-object" />';
                                }
                                ?>
                              
                            </a>
                            <div class="media-body">
                              <h4 class="person-name"><?php echo ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);?></h4>
                              <div class="text-muted"><strong><?php echo Yii::t('app','Course :');?> </strong>
                                        <?php 
                                        $batch = Batches::model()->findByPk($student->batch_id);
                                        echo $batch->course123->course_name;
                                        ?></div>
                              <div class="text-muted"> <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' :';?></strong> <?php echo $batch->name;?></div>
                              <div class="text-muted"><strong><?php echo Yii::t('app','Admission No').' :';?></strong> <?php echo $student->admission_no; ?></div>
                              
                            </div>
                          </div>
                        </div>
                        <div class="panel-heading">
                          <!-- panel-btns -->
                          <h3 class="panel-title"><?php echo Yii::t('app','Student Details'); ?></h3>
                        </div>
                        <div class="people-item">
                        
                        <div class="table-responsive">
                      
                      
                      <?php
                                Yii::app()->clientScript->registerScript(
                                   'myHideEffect',
                                   '$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
                                   CClientScript::POS_READY
                                );
                                
                                if(Yii::app()->user->hasFlash('successMessage')): 
                                ?>
                                <div class="flashMessage" style="color:#C00; padding-left:300px;">
                                    <?php echo Yii::app()->user->getFlash('successMessage'); ?>
                                </div>
                                <?php
                                endif;
                                
                                if(Yii::app()->user->hasFlash('errorMessage')): 
                                ?>
                                <div class="flashMessage" style="color:#C00; padding-left:300px;">
                                    <?php echo Yii::app()->user->getFlash('errorMessage'); ?>
                                </div>
                                <?php
                                endif;
                                ?>
                               <table class="table table-hover mb30">
                                    <thead>
                                        <tr>
                                        	<?php if(FormFields::model()->isVisible('admission_date','Students','forParentPortal')){?>
                                            <td ><strong><?php echo Yii::t('app','Admission Date');?></strong></td>
                                            <td>
                                                <?php 
                                                if($settings!=NULL)
                                                {	
                                                    $date1=date($settings->displaydate,strtotime($student->admission_date));
                                                    echo $date1;
                                                }
                                                else
                                                {
                                                    echo $student->admission_date;
                                                }
                                                ?>
                                            </td>
                                         <?php } ?>   
                                            <td><strong><?php echo Yii::t('app','City');?></strong></td>
                                            <td><?php echo $student->city; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong><?php echo Yii::t('app','Date of Birth');?></strong></td>
                                            <td>
                                                <?php 
                                                if($settings!=NULL)
                                                {
                                                $date1=date($settings->displaydate,strtotime($student->date_of_birth));
                                                echo $date1;
                                                }
                                                else
                                                {
                                                    echo $student->date_of_birth;
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td> <strong><?php echo Yii::t('app','Birth Place');?></strong></td>
                                            <td><?php echo $student->birth_place; ?></td>
                                            <td><strong><?php echo Yii::t('app','Blood Group');?></strong></td>
                                            <td><?php echo $student->blood_group; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong><?php echo Yii::t('app','State');?></strong></td>
                                            <td><?php echo $student->state; ?></td>
                                            <td><strong><?php echo Yii::t('app','Country');?></strong></td>
                                            <td>
                                                <?php 
                                                $count = Countries::model()->findByAttributes(array('id'=>$student->country_id));
                                                if(count($count)!=0)
                                                echo $count->name;
                                                ?>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong><?php echo Yii::t('app','Nationality');?></strong></td>
                                        <td>
                                            <?php 
                                            $natio_id=Nationality::model()->findByAttributes(array('id'=>$student->nationality_id));
                                            echo $natio_id->name; 
                                            ?>
                                        </td>
                                        <td><strong><?php echo Yii::t('app','Gender');?></strong></td>
                                        <td>
                                            <?php 
                                            if($student->gender=='M')
                                            echo Yii::t('app','Male');
                                            else 
                                            echo Yii::t('app','Female'); 
                                            ?>
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong><?php echo Yii::t('app','Pin Code');?>  </strong></td>
                                        <td><?php echo $student->pin_code; ?></td>
                                        <td colspan="2">&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong><?php echo Yii::t('app','Address Line 1');?>  </strong></td>
                                        <td><?php echo $student->address_line1; ?></td>
                                        <td><strong><?php echo Yii::t('app','Address Line 2');?></strong></td>
                                        <td><?php echo $student->address_line2; ?></td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong><?php echo Yii::t('app','Phone 1');?></strong></td>
                                        <td><?php echo $student->phone1; ?></td>
                                        <td><strong><?php echo Yii::t('app','Phone 2');?></strong></td>
                                        <td><?php echo $student->phone2; ?></td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong><?php echo Yii::t('app','Language');?></strong></td>
                                        <td><?php echo $student->language; ?></td>
                                        <td><strong><?php echo Yii::t('app','Email');?></strong></td>
                                        <td><?php echo $student->email; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong><?php echo Yii::t('app','Category');?></strong></td>
                                            <td>
                                                <?php 
                                                $cat =StudentCategories::model()->findByAttributes(array('id'=>$student->student_category_id));
                                                if($cat!=NULL)
                                                echo $cat->name; 
                                                ?>
                                            </td>
                                            <td><strong><?php echo Yii::t('app','Religion');?></strong></td>
                                            <td><?php echo $student->religion; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong><?php echo Yii::t('app','Emergency Contact');?></strong></td>
                                            <td>
                                                <?php 
                                                    echo ucfirst($guardian->first_name).' '.ucfirst($guardian->last_name);
                                                ?>
                                            </td>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                      </div>
                      </div>
      
                      
					  
					  <div class="panel-heading">
                          <!-- panel-btns -->
                          <h3 class="panel-title"><?php echo Yii::t('app','Guardian Details');?></h3>
                        </div>
<?php
$guardian_details = GuardianList::model()->findAllByAttributes(array('student_id'=>$student->id));
if($guardian_details)
{	
?>	
	<div class="people-item">
		
<?php        
		foreach($guardian_details as $guardian_detail)
		{
			$guardians = Guardians::model()->findAllByAttributes(array('id'=>$guardian_detail->guardian_id));
			foreach($guardians as $guardian)
			{
?>                
					<div class="table-responsive" style="padding:10px;
                    border:1px solid #eee;
                    margin-bottom:20px;
                    border-radius:5px">	
                                
							<h4 class="person-name"><?php echo $guardian->first_name.' '.$guardian->last_name;?></h4>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover mb30">
	<tr>
		<td><strong><?php echo Yii::t('app','Relation');?></strong></td>
		<td><?php if($guardian->relation!=NULL)
					{
						echo $guardian->relation;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Date Of Birth');?></strong></td>
		<td><?php 
				if($guardian->dob==0000-00-00)
				{
				echo '-';
				}
				else
				{
					if($settings!=NULL)
					{
					$date1=date($settings->displaydate,strtotime($guardian->dob));
					echo $date1;
					}
					
                                               
				}
				?></td>
	</tr>
	
    <tr>
		<td><strong><?php echo Yii::t('app','Education');?></strong></td>
		<td><?php if($guardian->education!=NULL)
					{
						echo $guardian->education;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Occupation');?></strong></td>
		<td><?php if($guardian->occupation!=NULL)
					{
						echo $guardian->occupation;
					}
					else
					{
						echo '-';
					}
			?></td>
	</tr>
    
      <tr>
		<td><strong><?php echo Yii::t('app','Income');?></strong></td>
		<td><?php if($guardian->income!=NULL)
					{
						echo $guardian->income;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Email');?></strong></td>
		<td><?php if($guardian->email!=NULL)
					{
						echo $guardian->email;
					}
					else
					{
						echo '-';
					}
			?></td>
	</tr>
    
     <tr>
		<td><strong><?php echo Yii::t('app','Mobile Phone');?></strong></td>
		<td><?php if($guardian->mobile_phone!=NULL)
					{
						echo $guardian->mobile_phone;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Office Phone 1');?></strong></td>
		<td><?php if($guardian->office_phone1!=NULL)
					{
						echo $guardian->office_phone1;
					}
					else
					{
						echo '-';
					}
			?></td>
	</tr>
    
     <tr>
		<td><strong><?php echo Yii::t('app','Office Phone 2');?></strong></td>
		<td><?php if($guardian->office_phone2!=NULL)
					{
						echo $guardian->office_phone2;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Office Address Line 1');?></strong></td>
		<td><?php if($guardian->office_address_line1!=NULL)
					{
						echo $guardian->office_address_line1;
					}
					else
					{
						echo '-';
					}
			?></td>
	</tr>
    
      <tr>
		<td><strong><?php echo Yii::t('app','Office Address Line 2');?></strong></td>
		<td><?php if($guardian->office_address_line2!=NULL)
					{
						echo $guardian->office_address_line2;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','city');?></strong></td>
		<td><?php if($guardian->city!=NULL)
					{
						echo $guardian->city;
					}
					else
					{
						echo '-';
					}
			?></td>
	</tr>
    
     <tr>
		<td><strong><?php echo Yii::t('app','state');?></strong></td>
		<td><?php if($guardian->state!=NULL)
					{
						echo $guardian->state;
					}
					else
					{
						echo '-';
					}
			?></td>
        <td><strong><?php echo Yii::t('app','Country');?></strong></td>
		<td><?php if($guardian->country_id!=NULL)
					{
						 $count = Countries::model()->findByAttributes(array('id'=>$guardian->country_id));
								if(count($count)!=0)
								 echo $count->name;
					}
					else
					{
						echo '-';
					}
            ?></td>
	</tr>
	
	
</table>     
<?php
		}
?>		
		</div>
<?php        
	}
?>
		
	</div>        
<?php	
}
?>
					  <div class="panel-heading">
                        <!-- Document Area -->
                          <h3 class="panel-title"><?php echo Yii::t('app','Documents'); ?></h3>
                        </div>
                        <div class="people-item">
                             <div class="table-responsive">
                                
                                 <?php
                                $documents = StudentDocument::model()->findAllByAttributes(array('student_id'=>$student->id)); // Retrieving documents of student with id $_REQUEST['id'];
                                ?>   
                               
                                     <table class="table table-hover mb30">
                                        <tbody>
                                        <?php
                                        if($documents) // If documents present
                                        {
                                            foreach($documents as $document) // Iterating the documents
                                            {
                                        ?>
                                                <tr>
                                                    <td width="90%"><?php echo ucfirst($document->title);?></td>
                                                    <td width="10%">
                                                        <?php
                                                        $status_data="";
                                                        // Setting class for status label
                                                        if($document->is_approved == -1)
                                                        {
                                                            $class = 'tag_disapproved';
                                                            $status_data=Yii::t('app',"Disapproved");
                                                        }
                                                        elseif($document->is_approved == 0)
                                                        {
                                                            $class = 'tag_pending';
                                                            $status_data=Yii::t('app',"Pending");
                                                        }
                                                        elseif($document->is_approved == 1)
                                                        {
                                                            $class = 'tag_approved';
                                                            $status_data=Yii::t('app',"Approved");
                                                        }
                                                        echo '<div style="width:127px">';
                                                        echo '<div class="'.$class.'">'.$status_data.'</div>';
                                                        echo '</div>';
                                                        ?>
                                                    </td>
                                                    <td width="10%">
                                                        <ul class="tt-wrapper">
                                                            <li>
                                                                <?php 
                                                                if($document->is_approved == 1)
                                                                {
                                                                echo CHtml::link('<span>'.Yii::t('app','You cannot edit an approved document').'</span>', array('documentupdate','id'=>$document->student_id,'document_id'=>$document->id),array('class'=>'tt-edit-disabled','onclick'=>'return false;')); 
                                                                }
                                                                else
                                                                {
                                                                    echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('documentupdate','id'=>$document->student_id,'document_id'=>$document->id),array('class'=>'tt-edit')); 
                                                                }
                                                                ?>
                                                            </li>
                                                            <li>
                                                             <?php 
                                                             echo CHtml::link('<span>'.Yii::t('app','Download').'</span>', array('download','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-download')); 
                                                             ?>
                                                            </li>
                                                            <li>
                                                                <?php 
                                                                if($document->is_approved == 1)
                                                                {
                                                                    echo CHtml::link('<span>'.Yii::t('app','You cannot delete an approved document.').'</span>', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-delete-disabled','onclick'=>'return false;')); 
                                                                }
                                                                else
                                                                {
                                                                    echo CHtml::link('<span>'.Yii::t('app','Delete').'</span>', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'tt-delete','confirm'=>Yii::t('app','Are you sure you want to delete this?'))); 
                                                                }
                                                                ?>
                                                            </li>
                                                        </ul>                                                
                                                    </td>
                                                    <?php /*?><td width="10%">
                                                    <!--<a class="dcumnt_dnld" href="#"></a>-->
                                                    <?php echo CHtml::link('dd', array('deletes','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'document_delet','style'=>'text-indent:-99999px;','confirm'=>'Are you sure you want to delete this?')); ?>
                                                   
                                                    </td>
                                                    <td width="10%">
                                                     <?php echo CHtml::link('d', array('download','id'=>$document->id,'student_id'=>$document->student_id),array('class'=>'dcumnt_dnld','style'=>'text-indent:-99999px;')); ?>
                                                    </td><?php */?>
                                                    
                                      </tr>
                                        <?php	
                                            }
                                            
                                        }
                                        else // If no documents present
                                        {
                                        ?>
                                            <tr>
                                                <td colspan="2" style="text-align:center;"><?php echo Yii::t('app','No document(s) uploaded'); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                             </div>
                             
                             <h5 class="subtitle mb5"><?php echo Yii::t('app','Upload Documents'); ?></h5>
                             
                             <div class="form-group">
                                <?php
                                if($documents==NULL) 
                                {
                                    $document = new studentDocument;
                                }
                                  echo $this->renderPartial('student/documentform', array('model'=>$document,'sid'=>$student->id)); 
                                ?>
                            </div>
                             
                          </div>
                
                    </div>
                </div>
    
    
   
                
                
            <?php
			
			} // END Single Student
			elseif(count($students)>1 and !isset($_REQUEST['id'])) // More than one Student. Display List
			{
			?>
             <div class="contentpanel">
                   <!-- <div class="col-sm-9 col-lg-12">-->
                   <div>
                       		<?php
								foreach($students as $student)
								{
								?>
                            <div class="people-item">
                              <div class="media">
                                <a href="#" class="pull-left">
                                 
                                  <?php
                            if($student->photo_file_name!=NULL)
                            { 
								$path = Students::model()->getProfileImagePath($student->id);
                            	echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" class="thumbnail media-object" />';
                            }
                            elseif($student->gender=='M')
                            {
                                echo '<img  src="images/portal/s_profile_m_icon.png" class="thumbnail media-object" alt='.$student->first_name.' />'; 
                            }
                            elseif($student->gender=='F')
                            {
                                echo '<img  src="images/portal/s_profile_fmicon.png" class="thumbnail media-object" alt='.$student->first_name.' />';
                            }
                            ?>
                                </a>
                                <div class="media-body">
                                  <h4 class="person-name"> <?php echo CHtml::link(ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name), array('/parentportal/default/studentprofile', 'id'=>$student->id));?></h4>
                                  <div class="text-muted"><?php
								
								if($student->batch_id!=0 and $student->batch_id!=NULL)
								{
									$batch = Batches::model()->findByPk($student->batch_id);
								}
								else if ($student->batch_id==0)
								{
									
									$criteria = new CDbCriteria();
									$criteria->condition  = "student_id =:sid";
									$criteria->params = array(':sid'=>$student->id);
									$criteria->order = "id DESC";
									$criteria->limit = 1;
									
									$last = BatchStudents::model()->findAll($criteria);
									$batch = Batches::model()->findByPk($last[0]->batch_id);
								?>Alumni<?php	
								}

								?></div>
                                  <div class="text-muted"><?php echo Yii::t('app','Course :');?> <?php 
                                        echo $batch->course123->course_name;
                                        ?></div>
                                  <div class="text-muted"><?php echo Yii::t('app','Batch :');?> <?php echo $batch->name;?></div>
                                  <div class="text-muted"><?php echo Yii::t('app','Admission No').' :';?> <?php echo $student->admission_no; ?></div>
                                </div>
                              </div>
                            </div>
                             <?php
                } // END foreach($students as $student)
                ?>
                    <?php                
			} // END More than one student. End Display List
			elseif(count($students)<=0) // No Student
			{
			?>
            	<div class="yellow_bx" style="background-image:none;width:750px;padding-bottom:45px;">
                    <div class="y_bx_head">
                        <?php echo Yii::t('app','No student details are available now!'); ?>
                    </div>      
                </div>
            <?php
			} // END No Student
			?>        
                           </div>
                         </div>
                    
				