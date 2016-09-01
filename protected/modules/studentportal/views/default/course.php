
	<?php $this->renderPartial('leftside');?> 
    <?php    
	$student=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $guard = Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
    $student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentPortal');
    ?>
  <div class="pageheader">
        <div class="col-lg-8">
        <h2><i class="fa fa-paste"></i><?php echo Yii::t('app','Courses');?><span><?php echo Yii::t('app','View your profile here'); ?></span></h2>
        </div>
        
    
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
                <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>-->
                
                <li class="active"><?php echo Yii::t('app','Courses'); ?></li>
            </ol>
        </div>
    
        <div class="clearfix"></div>
    
    </div>
    <div class="contentpanel">
    	<!--<div class="col-sm-9 col-lg-12">-->
        <div>
        	<div class="people-item">
      <div class="media"> <a href="#" class="pull-left">
        <?php
                     if($student->photo_file_name!=NULL)
                     {
						$path = Students::model()->getProfileImagePath($student->id);	  
                        echo '<img  src="'.$path.'" alt="'.$student->photo_file_name.'" width="100" height="103" />';
                    }
                    elseif($student->gender=='M')
                    {
                        echo '<img  src="images/portal/prof-img_male.png" alt='.$student->first_name.' width="100" height="103" />'; 
                    }
                    elseif($student->gender=='F')
                    {
                        echo '<img  src="images/portal/prof-img_female.png" alt='.$student->first_name.' width="100" height="103" />';
                    }
                    ?></a>
        
        <div class="media-body">
          <?php
          if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
          ?>
          <h4 class="person-name"><?php echo $student->studentFullName("forStudentPortal");?></h4>
          <?php
          }
          ?>
          <?php if(in_array('batch_id', $student_visible_fields)){ ?>      
          <div class="text-muted"><strong><?php echo Yii::t('app','Course').' :';?></strong>
            <?php 
              $batch = Batches::model()->findByPk($student->batch_id);
              echo $batch->course123->course_name;
            ?>
          </div>          
          <div class="text-muted"> <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' :';?></strong> <?php echo $batch->name;?></div>
          <?php } ?>
          <div class="text-muted"><strong><?php echo Yii::t('app','Admission No').' :';?></strong> <?php echo $student->admission_no; ?></div>
          
        </div>

      </div>
      </div>
    </div>
    	<div class="panel-heading"> 
      <!-- panel-btns -->
      <h3 class="panel-title"><?php echo Yii::t('app','Profile Details'); ?></h3>
    </div>
    <div class="people-item">
    	<div class="table-responsive">
        	<table  class="table table-hover mb30">
                        <tr>
                            <th><?php echo Yii::t('app','Sl No');?></th>
                            <th><?php echo Yii::t('app','Academic Year');?></th>
                            <?php if(in_array('batch_id', $student_visible_fields)){ ?>
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
                                <?php if(in_array('batch_id', $student_visible_fields)){ ?>
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
                                    echo Yii::t('app',$status->option_name);
                                    ?>
                                </td>
                            </tr>
                        <?php
                            $sl_no++;
                        }
                        ?>
                    </table>
        </div>
    </div>
        </div>
    </div>  
 

