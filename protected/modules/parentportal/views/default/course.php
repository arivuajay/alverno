<script>
	function getstudent() // Function to see student profile
	{
		var studentid = document.getElementById('studentid').value;
		if(studentid!='')
		{
			window.location= 'index.php?r=parentportal/default/course&id='+studentid;	
		}
		else
		{
			window.location= 'index.php?r=parentportal/default/course';
		}
	}
</script>

<div id="parent_Sect">
	<?php $this->renderPartial('leftside');?> 
    <?php
		$user=User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
		$guardian = Guardians::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$students = Students::model()->findAllByAttributes(array('parent_id'=>$guardian->id));
		if(count($students)==1) // Single Student 
		{
			$student = Students::model()->findByAttributes(array('id'=>$students[0]->id));
		}
		elseif(isset($_REQUEST['id']) and $_REQUEST['id']!=NULL) // If Student ID is set
		{
			$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			
		}
		elseif(count($students)>1) // Multiple Student
		{
			$student = Students::model()->findByAttributes(array('id'=>$students[0]->id));
		}
		//$res=FinanceFees::model()->findAll(array('condition'=>'student_id=:vwid AND is_paid=:vpid','params'=>array(':vwid'=>$student->id, ':vpid'=>0)));
    ?>
    
    <div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-male"></i><?php echo Yii::t('app','Course'); ?> <span><?php echo Yii::t('app','View course details here'); ?></span></h2>
        </div>
        <div class="col-lg-2">
        
       <?php
			if(count($students)>1) // Show drop down only if more than 1 student present
			{
				$student_list = CHtml::listData($students,'id','studentnameforparentportal');
			?>
				<div class="student_dropdown" style="top:15px;">
					<?php
					echo CHtml::dropDownList('sid','',$student_list,array('id'=>'studentid','class'=>'form-control input-sm mb14','options'=>array($_REQUEST['id']=>array('selected'=>true)),'onchange'=>'getstudent();'));
					?>
				</div> <!-- END div class="student_dropdown" -->
			<?php
			}
			?>
            </div>
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t('app','Course'); ?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
    
    
    <div class="contentpanel">
        <!--<div class="col-sm-9 col-lg-12">-->
        <div>        
            <div class="people-item">
              <div class="media">
              <a class="pull-left" href="#">
					<?php
                     if($student->photo_file_name!=NULL)
                     { 
					 	$path = Students::model()->getProfileImagePath($student->id);
                        echo '<img class="thumbnail media-object"  src="'.$path.'" width="100" height="103" />';
                    }
                    elseif($student->gender=='M')
                    {
                        echo '<img  src="images/portal/prof-img_male.png" alt='.$student->first_name.' width="100" height="103" />'; 
                    }
                    elseif($student->gender=='F')
                    {
                        echo '<img  src="images/portal/prof-img_female.png" alt='.$student->first_name.' width="100" height="103" />';
                    }
                    ?>
                    </a>
                <!-- END div class="prof_img" -->
                
               <div class="media-body">
                  <h4 class="person-name"><?php echo $student->studentFullName('forParentPortal');?></h4>
                  <?php if(FormFields::model()->isVisible('batch_id','Students','forParentPortal')){?>
                      <div class="text-muted"><strong><?php echo Yii::t('app','Course').' :';?> </strong>
                                <?php 
                                $batch = Batches::model()->findByPk($student->batch_id);
                                echo $batch->course123->course_name;
                                ?></div>
                      <div class="text-muted"> <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' :';?></strong> <?php echo $batch->name;?></div>
                  <?php } ?>    
                  <div class="text-muted"><strong><?php echo Yii::t('app','Admission No').' :';?></strong> <?php echo $student->admission_no; ?></div>
                  
                </div>
                </div> 
            </div> <!-- END div class="profile_top" -->
          
            <div class="panel-heading">
              <!-- panel-btns -->
              <h3 class="panel-title"><?php echo Yii::t('app','Courses');?></h3>
            </div>
            <div class="people-item">
                        
              <div class="table-responsive">
            
                <table class="table table-hover mb30">
                    <tr>
                        <th><?php echo Yii::t('app','Sl No');?></th>
                        <th><?php echo Yii::t('app','Academic Year');?></th>
                        <?php if(FormFields::model()->isVisible('batch_id','Students','forParentPortal')){?>
                        	<th><?php echo Yii::app()->getModule("students")->labelCourseBatch();?></th>
                        <?php } ?>    
                        <th><?php echo Yii::t('app','Status');?></th>
                    </tr>
                    <?php
                    $batches = BatchStudents::model()->findAllByAttributes(array('student_id'=>$student->id));
                    $sl_no = 1;
                    foreach($batches as $batch)
                    {
                    ?>
                        <tr>
                            <td>
                                <?php echo $sl_no; ?>
                            </td>
                            <td>
                                <?php
                                $academic_year = AcademicYears::model()->findByAttributes(array('id'=>$batch->academic_yr_id));
                                echo $academic_year->name;
                                ?>
                            </td>
                            <?php if(FormFields::model()->isVisible('batch_id','Students','forParentPortal')){?>
                                <td>
                                    <?php
                                    $batch_name = Batches::model()->findByAttributes(array('id'=>$batch->batch_id));
                                    echo $batch_name->course123->course_name.' / '.$batch_name->name;
                                    ?>
                                </td>
                            <?php } ?>    
                            <td>
                                <?php
                                $status = PromoteOptions::model()->findByAttributes(array('option_value'=>$batch->result_status));
								if($status!=NULL)
								{
                                	echo Yii::t('app', $status->option_name);
								}
								else
								{
									echo "-";
								}
                                ?>
                            </td>
                        </tr>
                    <?php
                        $sl_no++;
                    }
                    ?>
                </table>
                
            </div> <!-- END div class="profile_details" -->
        </div> <!-- END div class="parentright_innercon" -->
    </div> <!-- END div id="parent_rightSect" -->
    <div class="clear"></div>
 <!-- END div id="parent_Sect" -->

