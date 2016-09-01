<style>
.infored_bx{
	padding:5px 20px 7px 20px;
	background:#e44545;
	color:#fff;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	font-size:15px;
	font-style:italic;
	text-shadow: 1px -1px 2px #862626;
	text-align:left;
}


input.disabled_field
{
	background-color:#EFEFEF !important;
}
</style>
<?php
	echo $this->renderPartial('/default/leftside');
	$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
	// Get unique batch ID from Timetable. Checking if the employee is teaching.
	$criteria=new CDbCriteria;
	$criteria->select= 'id';
	$criteria->distinct = true;
	$criteria->condition='employee_id=:emp_id';
	$criteria->params=array(':emp_id'=>$employee->id);
	$class_teacher = Batches::model()->findAll($criteria);
	$class_count = count($class_teacher);
?>

<div class="pageheader">
      <h2><i class="fa fa-gear"></i> <?php echo Yii::t("app", "Exams");?> <span><?php echo Yii::t("app", "View your exams here");?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t("app", "You are here:");?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
          <li class="active"><?php echo Yii::t("app", "Exams");?></li>
        </ol>
   </div>
</div>
<div class="contentpanel">    
	<div class="panel-heading">
    	<div class="btn-demo" style="position:relative; top:-8px; right:3px; float:right;">
        <div class="edit_bttns">
    		<ul>       
                <li><?php echo CHtml::link('<span>'.Yii::t('app','All Classes').'</span>',array('/teachersportal/exams/allexam','employee_id'=>$employee_id),array('class'=>'addbttn last'));?></li>                
              <?php if($class_count>0){ ?>   
                <li><?php echo CHtml::link('<span>'.Yii::t('app','My Class').'</span>',array('/teachersportal/exams/classexam','employee_id'=>$employee_id),array('class'=>'addbttn last'));?></li>                
			  <?php } ?>     		
            </ul>
    		<div class="clear"></div>
		</div>
	</div>
		<h3 class="panel-title"><?php echo Yii::t('app', 'Exam Scores'); ?></h3>
	</div>
    <div class="people-item">
<div>
<?php
	/*echo "Employee ID: ".$employee_id.'<br/>';
	echo "Batch ID: ".$batch_id.'<br/>';
	echo "Exam Group ID: ".$exam_group_id.'<br/>';
	echo "Exam(Subject) ID: ".$exam_id.'<br/>';*/
	
	$batch=Batches::model()->findByAttributes(array('id'=>$batch_id));
        if($batch!=NULL)
		   { ?>
            <!-- Batch Details Tab -->
            	<div class="table-responsive">
                    	<table class="table table-bordered mb30">
                        	<tr>
                            	<td>
                       				<strong><?php echo Yii::t('app','Course');?>:</strong>
									<?php $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
                                    if($course!=NULL)
                                       {
                                           echo $course->course_name; 
                                       }?>
                               </td>
                               <td>
                                    <strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?>: </strong><?php echo $batch->name; ?>
                        		</td>
                        	</tr>
                            <tr>
							<?php if($exam_group_id!=NULL)
                            { 
								$exam=ExamGroups::model()->findByAttributes(array('id'=>$exam_group_id,'batch_id'=>$batch_id));
							?>
								<td>
									<strong><?php echo Yii::t('app','Exam'); ?>: </strong><?php echo $exam->name; ?>
								</td>
                            <?php 
                            }
							if($exam_id!=NULL)
							{ 
								$subject_id=Exams::model()->findByAttributes(array('id'=>$exam_id));
								$subject = Subjects::model()->findByAttributes(array('id'=>$subject_id->subject_id));
							?>
								<td>
									<strong><?php echo Yii::t('app','Subject'); ?>: </strong><?php echo $subject->name;  ?>
								</td>
							<?php
							}
							?>
                        	</tr>
                            <tr>
                            <?php
							$empid = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$subject_id->subject_id));
							if(count($empid)>0){
								$subject_teacher = Employees::model()->findByAttributes(array('id'=>$empid->employee_id));
							?>
								<td>
                                	<strong><?php echo Yii::t('app','Subject Teacher'); ?>: </strong><?php echo $subject_teacher->first_name.' '.$subject_teacher->last_name; ?>
								</td>
							<?php
							}
							$is_classteacher=Batches::model()->findByAttributes(array('id'=>$batch_id));
							$classteacher = Employees::model()->findByAttributes(array('id'=>$is_classteacher->employee_id));
							if(Yii::app()->controller->action->id=='classexamscore' and $classteacher->id != $employee_id){ // Redirecting if action ID is classexam and the employee is not classteacher
								$this->redirect(array('/teachersportal/exams/index'));
							}
							if(count($classteacher)>0){
							?>
                            	<td>
                                	<strong><?php echo Yii::t('app','Class Teacher'); ?>: </strong><?php echo $classteacher->first_name.' '.$classteacher->last_name; ?>
								</td>
                            <?php
							}
							?>
                            </tr>
                        </table>
                        </div>
					    
    	<?php 
		   }?>
           <div class="edit_bttns" style=" float:right">
        <ul>
        	<?php
			if(Yii::app()->controller->action->id=='allexamscore')
			{
				$url = '/teachersportal/exams/allexamresult';
				
			}			
			if($exam_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Subject List'), array('/teachersportal/exams/allexamresult','bid'=>$_REQUEST['bid'],'exam_group_id'=>$_REQUEST['exam_group_id']),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			if($exam_group_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Exam List'), array('/teachersportal/exams/allexams','bid'=>$_REQUEST['bid']),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			?>
            <li><span>
        	<?php echo CHtml::link(Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"), array('/teachersportal/exams/allexam'),array('id'=>'add_exam-groups','class'=>'addbttn')); ?>
        	</span></li>
        </ul>
        <div class="clear"></div>
    </div>
    
<?php    
if(isset($_REQUEST['bid']))
{
	
	$criteria = new CDbCriteria;
	$criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
	$criteria->params[':is_deleted'] = 0;
	$criteria->params[':is_active'] = 1;
	
	
	$batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['bid'],'result_status'=>0));
	if($batch_students)
	{
		$count = count($batch_students);
		$criteria->condition = $criteria->condition.' AND (';
		$i = 1;
		foreach($batch_students as $batch_student)
		{
			
			$criteria->condition = $criteria->condition.' id=:student'.$i;
			$criteria->params[':student'.$i] = $batch_student->student_id;
			if($i != $count)
			{
				$criteria->condition = $criteria->condition.' OR ';
			}
			$i++;
			
		}
		$criteria->condition = $criteria->condition.')';
	}
	else
	{
		$criteria->condition = $criteria->condition.' AND batch_id=:batch_id';
		$criteria->params[':batch_id'] = $_REQUEST['bid'];
	}

	$posts=Students::model()->findAll($criteria);
	
	
	
	//$posts=Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$_REQUEST['id'],':y'=>1,':z'=>0));
?>
	<?php
	$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
	if(Yii::app()->user->year)
	{
		$year = Yii::app()->user->year;
	}
	else
	{
		$year = $current_academic_yr->config_value;
	}
	$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
	$is_edit = PreviousYearSettings::model()->findByAttributes(array('id'=>3));
	$is_delete = PreviousYearSettings::model()->findByAttributes(array('id'=>4));
	
	
	$template = '';
	if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_edit->settings_value!=0))
	{
		$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$subjectdetails = Exams::model()->findByPk($_REQUEST['exam_id']);
		$is_teaching = TimetableEntries::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id,'is_elective'=>0));
		if($is_teaching!=NULL)
		{
			$template = $template.'{update}';
		}
		else
		{
			$is_assigned = count(EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id)));
			if($is_assigned>0)
			{
				$template = $template.'{update}';
			}
			else
			{
				$template = $template;
			}
		}
		
		
	}
	
	if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
	{
		$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$subjectdetails = Exams::model()->findByPk($_REQUEST['exam_id']);
		$is_teaching = TimetableEntries::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id,'is_elective'=>0));
		if($is_teaching!=NULL)
		{
			$template = $template.'{delete}';
		}
		else
		{
			$is_assigned = count(EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id)));
			if($is_assigned>0)
			{
				$template = $template.'{delete}';
			}
			else
			{
				$template = $template;
			}
		}
		//$template = $template.'{delete}';
	}
	
	
	$insert_score = 0;
	if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
	{
		$insert_score = 1;
	}
	
	?>

	<?php 	
	if($year != $current_academic_yr->config_value and ($is_insert->settings_value==0 or $is_edit->settings_value==0 or $is_delete->settings_value==0))
	{
	?>
		<div>
			<div class="yellow_bx" style="background-image:none;width:680px;padding-bottom:45px;">
				<div class="y_bx_head" style="width:650px;">
				<?php 
					echo Yii::t('app','You are not viewing the current active year. ');
					if($is_insert->settings_value==0 and $is_edit->settings_value!=0 and $is_delete->settings_value!=0)
					{ 
						echo Yii::t('app','To enter the scores, enable Insert option in Previous Academic Year Settings.');
					}
					elseif($is_insert->settings_value!=0 and $is_edit->settings_value==0 and $is_delete->settings_value!=0)
					{
						echo Yii::t('app','To edit the scores, enable Edit option in Previous Academic Year Settings.');
					}
					elseif($is_insert->settings_value!=0 and $is_edit->settings_value!=0 and $is_delete->settings_value==0)
					{
						echo Yii::t('app','To delete the scores, enable Delete option in Previous Academic Year Settings.');
					}
					else
					{
						echo Yii::t('app','To manage the scores, enable the required options in Previous Academic Year Settings.');	
					}
				?>
				</div>
				<div class="y_bx_list" style="width:650px;">
					<h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
				</div>
			</div>
		</div><br/>
	<?php
	}
	?>


    <div class="">
        <div>
			<?php 
            if($posts!=NULL)
            {
            ?>
                
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'exam-scores-form',
                    'enableAjaxValidation'=>false,
                )); ?>
                <?php
                if(Yii::app()->user->hasFlash('success'))
                {
                ?>
                    <div class="infogreen_bx" style="margin:10px 0 10px 10px; width:575px;"><?php echo Yii::app()->user->getFlash('success');?></div>
                <?php
                }
                else if(Yii::app()->user->hasFlash('error'))
                {
                ?>
                    <div class="infored_bx" style="margin:10px 0 10px 10px; width:575px;"><?php echo Yii::app()->user->getFlash('error');?></div>
                <?php
                }
                ?>
                <h3><?php echo Yii::t('app','Enter Exam Scores here:');?></h3>
                <?php echo $form->hiddenField($model,'exam_id',array('value'=>$_REQUEST['examid'])); ?>
                
               <div class="table-responsive">
                    	<table class="table table-bordered mb30">
                        <?php 
                        $i=1;
                        $j=0;
                        foreach($posts as $posts_1)
                        { 
							$sub=NULL;
							$student_elective=NULL;
                            $checksub = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['exam_id'],'student_id'=>$posts_1->id));
                            $exm = Exams::model()->findByAttributes(array('id'=>$_REQUEST['exam_id']));
							if($exm!=NULL)
							{
                            	$sub = Subjects::model()->findByAttributes(array('id'=>$exm->subject_id));
							}
							
							if($sub!=NULL)
							{
								$student_elective = StudentElectives::model()->findByAttributes(array('student_id'=>$posts_1->id, 'elective_group_id'=>$sub->elective_group_id));
							}
							$teachflag=0;
							$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
							$is_teaching = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'employee_id'=>$employee->id));
							if($is_teaching!=NULL)
							{
								$teachflag=1;
							}
							else
							{
								$is_assigned = count(EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'elective_id'=>$student_elective->elective_id,'employee_id'=>$employee->id)));
								if($is_assigned!=NULL)
								{
									$teachflag=1;
								}
							}
                            if(($teachflag==1)and $checksub==NULL and (($sub->elective_group_id==0 and count($sub)!=0) or ($sub->elective_group_id!=0 and count($student_elective)!=0)))
                            {
                                if($j==0)
                                {
                                ?>
                                <thead>
                                    <tr>
                                        <th><?php echo Yii::t('app','Student Name');?></th>
                                        <th><?php echo Yii::t('app','Subject');?></th>
                                        <th><?php echo Yii::t('app','Marks');?></th>
                                        <th><?php echo Yii::t('app','Remarks');?></th>
                                    </tr>
                                    </thead>
                                    <?php 
                                    $j++;
                                }
								
								if($student_elective==NULL){ //add the electives for the unassigned students
									$flag=0;
									$is_teaching = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'employee_id'=>$employee->id));
                                ?>
                                        <?php 
                                        /*if($sub->elective_group_id!=0)
                                        {
                                            $studentelctive = StudentElectives::model()->findByAttributes(array('student_id'=>$posts_1->id,'elective_group_id'=>$sub->elective_group_id));
                                            if($studentelctive==NULL) 
                                            {
                                            ?>
                                                <?php echo '<i><span style="color:#E26214;">'.Yii::t('app','Elective not assigned').'</span></i>'; ?>
                                            <?php
											$flag=1;
                                            }
                                        }*/
										//else
										//{
									if($is_teaching!=NULL)
									{
											?>
											<tr>
                                                                                            
                                    <td height="60">                       
                                        <?php 
                                        $name=  $student->studentFullName('forTeacherPortal');
                                        if($name!="")
                                        {
                                            echo $name;
                                        }
                                        else
                                            echo "-";
                                        //echo $posts_1->first_name.' '.$posts_1->middle_name.' '.$posts_1->last_name;?><br />
                                     </td>
                                     <td>
                                     <?php
											echo ucfirst($sub->name);
											$is_teaching = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'employee_id'=>$employee->id));
											if($is_teaching==NULL)
											{
												$flag=1;
											}
										//}?>
                                        <?php echo $form->hiddenField($model,'student_id[]',array('value'=>$posts_1->id,'id'=>$posts_1->id)); ?>
                                    </td>
                                    <td>
                                        <?php 
										if($insert_score == 1 and $flag==0)
										{
											echo $form->textField($model,'marks[]',array('class'=>'form-control','size'=>3,'maxlength'=>3,'id'=>$posts_1->id,'onclick'=>'alertmessage()'));
										}
										else
										{
											echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>3,'class'=>'form-control','id'=>$posts_1->id,'disabled'=>'disabled'));
										}
										?>
                                    </td>
                                    <td>
										<?php 
										if($insert_score == 1 and $flag==0)
										{
											echo $form->textField($model,'remarks[]',array('class'=>'form-control','size'=>7,'maxlength'=>255,'id'=>$posts_1->id));
										}
										else
										{
											echo $form->textField($model,'remarks[]',array('size'=>30,'maxlength'=>255,'class'=>'form-control','id'=>$posts_1->id,'disabled'=>'disabled'));
										}
										
										?>
									</td>
                                 </tr>
                                 <?php echo $form->hiddenField($model,'grading_level_id'); ?>
                                <?php //echo $form->hiddenField($model,'is_failed'); ?>
                                
                                
                                <?php 
                                echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
                                echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d')));?>  
								<?php
										}
								
								}
								else{
									$flag=0;
									
									//if($student_elective->elective_group_id==$sub->elective_group_id){
                                ?>
                                
                                        <?php 
                                        if($sub->elective_group_id!=0)
                                        {
                                            $studentelctive = StudentElectives::model()->findByAttributes(array('elective_group_id'=>$sub->elective_group_id,'student_id'=>$posts_1->id,'elective_group_id'=>$sub->elective_group_id));
											$electiveid = Electives::model()->findByAttributes(array('id'=>$studentelctive->elective_id));
											$is_teaching = EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'elective_id'=>$electiveid->id,'employee_id'=>$employee->id));
											
                                            if($studentelctive!=NULL and $is_teaching!=NULL) 
                                            {
                                            ?>
                                            <tr>
                                                <td height="60">                       
                                                    <?php echo $posts_1->first_name.' '.$posts_1->middle_name.' '.$posts_1->last_name;?><br />
                                                </td>
                                                <td>
                                                <?php /*?><?php echo '<i><span style="color:#E26214;">'.Yii::t('app','Elective not assigned').'</span></i>'; ?><?php */?>
                                            <?php
												//$flag=1;
                                            //}
											//else
											//{
												
												//$electiveid = Electives::model()->findByAttributes(array('id'=>$studentelctive->elective_id));
												if($electiveid!=NULL)
												{
													echo ucfirst($electiveid->name);
													
												}
												
												//$is_teaching = EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'elective_id'=>$electiveid->id,'employee_id'=>$employee->id));
												/*if($is_teaching==NULL)
												{
													$flag=1;
												}*/
											
											
                                       // }
										?>
                                        <?php echo $form->hiddenField($model,'student_id[]',array('value'=>$posts_1->id,'id'=>$posts_1->id)); ?>
                                    </td>
                                    
                                    <td>
                                        <?php 
										if($insert_score == 1)
										{
											echo $form->textField($model,'marks[]',array('class'=>'form-control','size'=>3,'maxlength'=>3,'id'=>$posts_1->id,'onclick'=>'alertmessage()'));
										}
										/*else
										{
											echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>3,'class'=>'form-control','id'=>$posts_1->id,'disabled'=>'disabled'));
										}*/
										?>
                                    </td>                 
                                    <td>
										<?php 
										if($insert_score == 1)
										{
											echo $form->textField($model,'remarks[]',array('class'=>'form-control','size'=>7,'maxlength'=>255,'id'=>$posts_1->id));
										}
										/*else
										{
											echo $form->textField($model,'remarks[]',array('size'=>30,'maxlength'=>255,'class'=>'form-control','id'=>$posts_1->id,'disabled'=>'disabled'));
										}*/
									
										?>
									</td>
                                </tr>	
                                
                                <?php echo $form->hiddenField($model,'grading_level_id'); ?>
                                <?php //echo $form->hiddenField($model,'is_failed'); ?>
                                
                                
                                <?php 
                                echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
                                echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d')));
									/*}
									else{
									}*/
									}
								}
							}
								
                               
                            $i++; }  // if($checksub==NULL)
                        }// END foreach($posts as $posts_1)
                        ?>
                    </table>
                    
                    <br />
                    <?php 
                    if($i==1 and $checksub!=NULL)
                    {
                    
                        echo '<div class="notifications nt_green">'.'<i>'.Yii::t('app','Exam Score Entered For All Students').'</i></div>'; 
                        $allscores = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
                        $sum=0;
                        foreach($allscores as $allscores1)
                        {
                            $sum=$sum+$allscores1->marks;
                        }
                        $avg=$sum/count($allscores);
						 $avg=substr($avg,0,5);
                        echo '<div class="notifications nt_green">'.Yii::t('app','Class Average').' = '.$avg.'</div>';
                        echo '<div style="padding-left:10px;">';
                        //echo CHtml::link('<img src="images/pdf-but.png" />', array('examScores/pdf','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('target'=>"_blank"));
                        
                        echo '</div>';
                    }
                    ?>
                </div> <!-- END div class="tableinnerlist" -->
            
                <div align="left">
                    <?php 
					if($insert_score == 1)
					{
						if($i!=1)
						{ 
							echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary')); 
						}
					}?>
                </div>
            
            <?php $this->endWidget(); ?>
            <?php 
            }// END if($posts!=NULL)
            else
            {
                echo '<i>'.Yii::t('app','No Students In This').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i>';
            }
            ?>
         </div> <!-- END div class="formConInner" -->
    </div> <!-- END div class="formCon" -->
    <?php
	//}
	?>
    
    <?php
	$checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
	if($checkscores!=NULL)
	{
	?>
        
        
        <?php 
		$model1=new ExamScores('search');
        $model1->unsetAttributes();  // clear any default values
        if(isset($_GET['exam_id']))
        	$model1->exam_id=$_GET['exam_id'];
        ?>
        <h3> <?php echo Yii::t('app','Scores');?></h3>
        <?php
        if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
		{
		?>
        <div style="position:relative">    
            <div class="edit_bttns" style="width:250px; top:-10px; right:-123px;">
                <ul>
                    <li>
                    <?php
						$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
						$subjectdetails = Exams::model()->findByPk($_REQUEST['exam_id']);
						$is_teaching = TimetableEntries::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id,'is_elective'=>0));
						if($is_teaching!=NULL)
						{
							echo CHtml::link('<span>'.Yii::t('app','Clear All Scores').'</span>', array('examScores/deleteall','allexam'=>1,'id'=>$_REQUEST['bid'],'exam_id'=>$_REQUEST['exam_id']),array('class'=>'addbttn last','confirm'=>Yii::t('app','Are you sure you want to delete all scores ?.')));
						}
						else
						{
							$is_assigned = count(EmployeeElectiveSubjects::model()->findByAttributes(array('subject_id'=>$subjectdetails->subject_id,'employee_id'=>$employee->id)));
							if($is_assigned>0)
							{
								echo CHtml::link('<span>'.Yii::t('app','Clear All Scores').'</span>', array('examScores/deleteall','allexam'=>1,'id'=>$_REQUEST['bid'],'exam_id'=>$_REQUEST['exam_id']),array('class'=>'addbttn last','confirm'=>Yii::t('app','Are you sure you want to delete all scores ?.')));
							}
							
						}
					?>
                    <?php /*?><?php echo CHtml::link('<span>'.Yii::t('app','Clear All Scores').'</span>', array('examScores/deleteall','allexam'=>1,'id'=>$_REQUEST['bid'],'exam_id'=>$_REQUEST['exam_id']),array('class'=>'addbttn last','confirm'=>Yii::t('app','Are you sure you want to delete all scores ?.')));?><?php */?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
		}
		?>
        
        <div class="table-responsive">
        <?php
	   $exm = Exams::model()->findByAttributes(array('id'=>$_REQUEST['exam_id']));
	   $examgroups = ExamGroups::model()->findByAttributes(array('id'=>$exm->exam_group_id));  
        
        if($examgroups->exam_type =='Marks') // Marks Only
        {
           $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
            if($checkscores!=NULL)
            {
        
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>array(
                    
                    
                    array(
                        'header'=>Yii::t('app','Student Name'),
                       // 'value'=>array($model,'studentname'),
                        'value'=>'$data->gridStudentName(forTeacherPortal)',  
                        'name'=> 'firstname',
                        'sortable'=>true,
            
                    
                    ),
                    
                    'marks',
					 array(
                        'header'=>Yii::t('app', 'Grades'),
                       'value'=>array($model,'getgradinglevelteacher'),
       					//'value' => $model->getgradinglevel($_REQUEST['id']),
					   
                        'name'=> 'grading_level_id',
                    ),
					
                    'remarks',
                    array(
						'header'=>Yii::t('app', 'Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app', 'Are you sure you want to delete this score ?'),
                        'buttons' => array(
                                                                 
									'update' => array(
									'label' => Yii::t('app', 'update'), // text label of the button
									
									'url'=>'Yii::app()->createUrl("/teachersportal/examScores/update", array("id"=>$data->id,"examid"=>$data->exam_id,"bid"=>$_REQUEST["bid"],"exam_group_id"=>$_REQUEST["exam_group_id"]))', // a PHP expression for generating the URL of the button
								  
									),
									
								),
								'template'=>$template,
								'afterDelete'=>'function(){window.location.reload();}',
								'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
                                                                
                    ),
                    
                ),
            )); 
            }
        }
        else if($examgroups->exam_type =='Grades') // Grades Only
        {
            $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
            if($checkscores!=NULL)
            {
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>array(
                    
                    array(
                        'header'=>Yii::t('app','Student Name'),
                        'value'=>array($model,'studentname'),
                        'name'=> 'firstname',
                        'sortable'=>true,
            
                    
                    ),
                    
                    array(
                        'header'=>Yii::t('app', 'Grades'),
                        'value'=>array($model,'getgradinglevelteacher'),
                        'name'=> 'grading_level_id',
                    ),
                    'remarks',
                    array(
						'header'=>Yii::t('app', 'Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app', 'Are you sure you want to delete this scores ?'),
                        'buttons' => array(
                                                                 
										'update' => array(
										'label' => Yii::t('app', 'update'), // text label of the button
										'url'=>'Yii::app()->createUrl("/teachersportal/examScores/update", array("id"=>$data->id,"examid"=>$data->exam_id,"bid"=>$_REQUEST["bid"],"exam_group_id"=>$_REQUEST["exam_group_id"]))', // a PHP expression for generating the URL of the button
									  
										),
										
									),
						'template'=>$template,
						'afterDelete'=>'function(){window.location.reload();}',
						'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
													
                    ),
                    
                ),
            )); 
            }
        
        }
        else  // Marks and Grades
        {
            $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['exam_id']));
            if($checkscores!=NULL)
            {
        
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>array(
                    
                    
                    array(
                        'header'=>Yii::t('app','Student Name'),
                        'value'=>array($model,'studentname'),
                        'name'=> 'firstname',
                        'sortable'=>true,
            
                    
                    ),
                    
                    'marks',
                    array(
                        'header'=>Yii::t('app','Grades'),
                        'value'=>array($model,'getgradinglevelteacher'),
                        'name'=> 'grading_level_id',
                    ),
                    'remarks',
                    array(
						'header'=>Yii::t('app', 'Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app', 'Are you sure you want to delete this scores ?'),
                        'buttons' => array(
                                                                 
											'update' => array(
											'label' => Yii::t('app', 'update'), // text label of the button
											'url'=>'Yii::app()->createUrl("/teachersportal/examScores/update", array("id"=>$data->id,"examid"=>$data->exam_id,"bid"=>$_REQUEST["bid"],"exam_group_id"=>$_REQUEST["exam_group_id"]))', // a PHP expression for generating the URL of the button
										  
											),
											
										),
						'template'=>$template,
						'afterDelete'=>'function(){window.location.reload();}',
						'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
                                                                
                    ),
                    
                ),
            )); 
            }
        }
       
        echo '</div></div>';
        
        
	}
	else
	{
		echo '<div class="notifications nt_red">'.'<i>'.Yii::t('examination','No Scores Updated').'</i></div>'; 
	}
	?>
       
<?php
} // END if REQUEST['id'] 
else
{
	echo '<div class="notifications nt_red">'.'<i>'.Yii::t('examination','Nothing Found').'</i></div>'; 
}
?>
   
   </div>         
</div> 
