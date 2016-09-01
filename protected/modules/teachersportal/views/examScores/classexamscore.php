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

<?php  echo $this->renderPartial('/default/leftside');

$tutor  = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));

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
                <li><?php echo CHtml::link('<span>'.Yii::t('app','All Classes').'</span>',array('/teachersportal/exams/allexam'),array('class'=>'addbttn last'));?></li>                
                <li><?php echo CHtml::link('<span>'.Yii::t('app','My Class').'</span>',array('/teachersportal/exams/classexam'),array('class'=>'addbttn last'));?></li>                
    		</ul>
    		<div class="clear"></div>
		</div>
	</div>
		<h3 class="panel-title"><?php echo Yii::t('app', 'Exam Scores '); ?></h3>
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
							$is_classteacher=Batches::model()->findByAttributes(array('id'=>$batch_id,'employee_id'=>$tutor->id));
							$classteacher = Employees::model()->findByAttributes(array('id'=>$is_classteacher->employee_id));
							
							
							if(Yii::app()->controller->action->id=='classexamscore' and $is_classteacher==NULL){ // Redirecting if action ID is classexam and the employee is not classteacher
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
					  
    	
           <div class="edit_bttns" style=" float:right">
        <ul>
        	<?php
			
			if(Yii::app()->controller->action->id=='classexamscore')
			{
				$url = '/teachersportal/exams/classexamresult';				
			}
			if($exam_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Subject List'), array('/teachersportal/exams/classexamresult','bid'=>$batch_id,'exam_group_id'=>$exam_group_id),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			if($exam_group_id!=NULL)
			{
			?>
            <li><span>
            <?php 
				echo CHtml::link(Yii::t('app','View Exam List'), array('/teachersportal/exams/classexams','bid'=>$batch_id),array('id'=>'add_exam-groups','class'=>'addbttn')); 
			
			?></span>
        	</li>
            <?php
			}
			?>
            <li><span>
        	<?php echo CHtml::link(Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"), array('/teachersportal/exams/classexam'),array('id'=>'add_exam-groups','class'=>'addbttn')); ?>
        	</span></li>
        </ul>
        <div class="clear"></div>
    </div>
    
    <?php
	$result_published = ExamGroups::model()->countByAttributes(array('id'=>$exam_group_id,'result_published'=>1));
	$is_teaching_subject = TimetableEntries::model()->countByAttributes(array('subject_id'=>$subject_id->subject_id,'employee_id'=>$tutor->id));
	$score_flag = 0; // If $score_flag == 0, form for entering scores will not be displayed. If $score_flag == 1, form will be displayed.
	if((Yii::app()->controller->action->id=='classexamscore' and ($is_classteacher!=NULL)) or (Yii::app()->controller->action->id=='allexam' and $is_teaching_subject >0))
	{ // Class teacher can enter scores for all subjects in their batch.
		$score_flag = 1; 
	}
	if(Yii::app()->controller->action->id=='allexam' and $is_teaching_subject<=0)
	{
		$score_flag = 0;
	}
	/*echo 'Result Published: '.$result_published.'<br/>';
	echo 'Is Teaching Subject: '.$is_teaching_subject.'<br/>';
	echo 'Score Flag: '.$score_flag.'<br/>';*/
	if($score_flag==1)
	{
	?>
	<!-- Start Enter Exam Scores -->
    
        <?php
		$model=new ExamScores;
        if(isset($batch_id))
		{
			$students=Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$batch_id,':y'=>1,':z'=>0));
			if($students!=NULL)
    		{
				if(Yii::app()->controller->action->id=='classexamscore'){
					$actionUrl = CController::createUrl('/teachersportal/examScores/addscores',array("bid"=>$batch_id,"exam_group_id"=>$exam_group_id,"exam_id"=>$exam_id));
				}				
				$form=$this->beginWidget('CActiveForm', array(
				'id'=>'exam-scores-form',
				'action' => $actionUrl,
				'enableAjaxValidation'=>false,
				));
		?>
        
        
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
				<h3><?php echo Yii::t("app", "Enter Exam Scores here:");?></h3>
    			<?php echo $form->hiddenField($model,'exam_id',array('value'=>$exam_id)); ?>
                <div class="table-responsive">
<table class="table table-bordered mb30">
                    <?php 
					$i=1;
	  				$j=0;
	  				foreach($students as $student){ 
						$checksub = ExamScores::model()->findByAttributes(array('exam_id'=>$exam_id,'student_id'=>$student->id));
						 $exm = Exams::model()->findByAttributes(array('id'=>$exam_id));
                            $sub = Subjects::model()->findByAttributes(array('id'=>$exm->subject_id));
						if($checksub==NULL){ //No score entered for student with student_id '$student->id'.
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
					?>
                    			<tr>
                                	<td><?php 
                                        $name= $student->studentFullName('forTeacherPortal');
                                        echo $name;
                                       // echo ucfirst($student->first_name).' '.ucfirst($student->last_name);?>
                                    </td>
                                    <td>
                                    <?php 
                                        if($sub->elective_group_id!=0)
                                        {
                                            $studentelctive = StudentElectives::model()->findByAttributes(array('student_id'=>$student->id,'elective_group_id'=>$sub->elective_group_id));
                                            if($studentelctive==NULL) 
                                            {
                                            ?>
                                                <?php echo '<i><span style="color:#E26214;">'.Yii::t('app','Elective not assigned').'</span></i>  '.CHtml::link(Yii::t('app','Add now'),array('/teachersportal/course/elective','id'=>$batch_id)); ?>
                                            <?php
											$flag=1;
                                            }
											else
											{
												$flag=0;
												$electiveid = Electives::model()->findByAttributes(array('id'=>$studentelctive->elective_id));
												if($electiveid!=NULL)
												{
													echo ucfirst($electiveid->name);
												}
											}
                                        }
										else
										{
											echo ucfirst($sub->name);
											$is_teaching = EmployeesSubjects::model()->findByAttributes(array('subject_id'=>$sub->id,'employee_id'=>$employee->id));
											if($is_teaching==NULL)
											{
												$flag=1;
											}
										}?>
										<?php echo $form->hiddenField($model,'student_id[]',array('value'=>$student->id,'id'=>$student->id)); ?>
									</td>
                                    <td><?php echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>7,'class'=>'form-control','style'=>'width:200px','id'=>$student->id)); ?>
                                    </td>
                                    <td><?php echo $form->textField($model,'remarks[]',array('size'=>60,'maxlength'=>255,'style'=>'width:200px','class'=>'form-control','id'=>$student->id)); ?></td>
								</tr>
        						
                                <?php 
									echo $form->hiddenField($model,'grading_level_id');
									echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
		  							echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); 
								?>
                    <?php 
							$i++;	
						}
					}
					?>
                    </table>
                  
					<?php 
					if($i==1)
					{
						 echo '<div class="notifications nt_green"><i>'.Yii::t('app','Exam Score Entered For All Students').'</i></div>'; 
						 $allscores = ExamScores::model()->findAllByAttributes(array('exam_id'=>$exam_id));
						 $sum=0;
						 foreach($allscores as $allscore)
						 {
							$sum=$sum+$allscore->marks;
						 }
						 $avg=$sum/count($allscores);
						 echo '<div class="notifications nt_green">'.Yii::t('app','Class Average').' = '.$avg.' marks</div>';
						 /*echo '<div style="padding-left:10px;">';
						 echo CHtml::link('<img src="images/pdf-but.png" />', array('examScores/pdf','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('target'=>"_blank"));
						 echo '</div>';*/
                    }
                    ?>
                </div>
                <div align="left">
					<?php if($i!=1) echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-danger')); ?>
				</div>
                <?php $this->endWidget(); ?>
    	<?php
			}
			else
			{
				echo '<i>'.Yii::t('app','No Students In This').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i>';
		 	}
		?>
        <?php
		}
		?>
       
    <!-- End Enter Exam Scores -->
    <?php
	}
	?>
    <?php
    $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$exam_id));
	if($checkscores!=NULL)
	{?>
    <div>
        <div>
        	<?php
			if($score_flag==1){ // If $score_flag==1, display clear all button
			?>
            <div class="edit_bttns" align="right" style="width:100%">
                <div class="c_cubbut" style="width:140px;">
                    <ul>
                        <li>
                        <?php 
						//if(Yii::app()->controller->action->id=='classexamscore'){
							echo CHtml::link(Yii::t('app','Clear All Scores'), array('/teachersportal/examScores/deleteall',"id"=>$_REQUEST['bid'],"exam_group_id"=>$_REQUEST['exam_group_id'],"exam_id"=>$_REQUEST['exam_id']),array('class'=>'addbttn last','confirm'=>Yii::t('app','Are You Sure? All Scores will be deleted.')));
						//}						
						?>
                        </li>
                    
                    </ul>
                <div class="clear"></div>
                </div>
            </div>
            <?php
			}
			?>
            <!-- Start Score Table -->
            <?php $model=new ExamScores('search');
                  $model->unsetAttributes();  // clear any default values
                  if(isset($exam_id))
                    $model->exam_id=$exam_id;
                  ?>
                  <h3><?php echo Yii::t('app', 'Scores');?></h3>
                  <?php 
                 if($score_flag==0){ // If $score_flag==0, score table without edit option will be displayed
				 
				 	if($exam->exam_type == 'Marks') // Show only Marks
					{
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
                                                                    'header'=>Yii::t('app','Student Name'),
                                                                    'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
                                                                    'name'=> 'firstname',
                                                                    'sortable'=>true,
                                                            );
                                                }
                                                $new_array[]= 'marks';
                                                $new_array[]= array(
                                                                'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
                                                                'name'=> 'remarks',
                                                        );
                                                $new_array[]= array(
                                                                'header'=>Yii::t('app','Status'),
                                                                'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                                'name'=> 'is_failed',
                                                        );
                                                                                                                                                                                               
                                             //   <!-- DYNAMIC FIELD ARRAY END -->  
                                                
						 $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=>$new_array,
						));
					}
					elseif($exam->exam_type == 'Grades') // Show only Grades
					{
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
                                                                    'header'=>Yii::t('app','Student Name'),
                                                                    'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
                                                                    'name'=> 'firstname',
                                                                    'sortable'=>true,
                                                            );
                                                }
                                                $new_array[]= array(
                                                                'header'=>'Grades',
                                                                'value'=>array($model,'getgradinglevelteacher'),
                                                                'name'=> 'grading_level_id',
                                                        );
                                                $new_array[]= array(
											'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
											'name'=> 'remarks',
										);
                                                $new_array[]= array(
                                                                    'header'=>'Status',
                                                                    'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                                    'name'=> 'is_failed',
                                                            );
                                                                                                                                                                                               
                                             //   <!-- DYNAMIC FIELD ARRAY END -->  
						$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=> $new_array,
						));	
					}
					elseif($exam->exam_type == 'Marks Aand Grades') // Show both Marks and Grades
					{
                                            
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
                                                                    'header'=>Yii::t('app','Student Name'),
                                                                    'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
                                                                    'name'=> 'firstname',
                                                                    'sortable'=>true,
                                                            );
                                                }
                                                $new_array[]= 'mark';
                                                $new_array[]= array(
                                                                'header'=>'Grades',
                                                                'value'=>array($model,'getgradinglevelteacher'),
                                                                'name'=> 'grading_level_id',
                                                        );
                                                $new_array[]= array(
											'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
											'name'=> 'remarks',
										);
                                                $new_array[]= array(
                                                                    'header'=>'Status',
                                                                    'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                                    'name'=> 'is_failed',
                                                            );
                                                                                                                                                                                               
                                             //   <!-- DYNAMIC FIELD ARRAY END -->  
						$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=>$new_array,
						));	
					}
                 }
                 elseif($score_flag==1){ // If $score_flag==1, score table with edit option will be displayed
				 	//if(Yii::app()->controller->action->id=='classexamscore'){
							$updateUrl = 'Yii::app()->createUrl("/teachersportal/examScores/classexamupdate", array("id"=>$data->id,"bid"=>'.$batch_id.',"exam_group_id"=>'.$exam_group_id.',"exam_id"=>'.$exam_id.'))';
							$delUrl = 'Yii::app()->createUrl("/teachersportal/examScores/deleteexamscore", array("id"=>$data->id,"bid"=>'.$batch_id.',"exam_group_id"=>'.$exam_group_id.',"exam_id"=>'.$exam_id.'))';
						//}						
					if($exam->exam_type == 'Marks') // Show only Marks
					{
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
											'header'=>Yii::t('app','Student Name'),
											'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
											'name'=> 'firstname',
											'sortable'=>true,
										);
                                                }
                                                $new_array[]= 'marks';
                                                    /*'grading_level_id',*/
                                                    /*array(
                                                            'header'=>'Grades',
                                                            'value'=>array($model,'getgradinglevel'),
                                                            'name'=> 'grading_level_id',
                                                    ),*/
                                                    $new_array[]= array(
                                                            'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
                                                            'name'=> 'remarks',
                                                    );
                                                    $new_array[]= array(
                                                            'header'=>'Status',
                                                            'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                            'name'=> 'is_failed',
                                                    );
                                                    $new_array[]=array(
                                                            'class'=>'CButtonColumn',
                                                            'buttons' => array(
                                                                    'update' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$updateUrl, // a PHP expression for generating the URL of the button
                                                                    ),
                                                                    'delete' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$delUrl, // a PHP expression for generating the URL of the button
                                                                    ),

                                                            ),
                                                            'template'=>'{update} {delete}',
                                                            'afterDelete'=>'function(){window.location.reload();}',
                                                            'header'=>Yii::t('app','Manage'),
                                                            'headerHtmlOptions'=>array('style'=>'font-size:13px;')				
                                                    );
                                                
                                                
                                             //   <!-- DYNAMIC FIELD ARRAY END -->     
                                            
                                            
						$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=>$new_array,
							
						));
					}
					elseif($exam->exam_type == 'Grades') // Show only Grades
					{
                                            
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
											'header'=>Yii::t('app','Student Name'),
											'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
											'name'=> 'firstname',
											'sortable'=>true,
										);
                                                }
                                                $new_array[]= array(
                                                            'header'=>Yii::t('app','Grades'),
                                                            'value'=>array($model,'getgradinglevelteacher'),
                                                            'name'=> 'grading_level_id',
                                                    );
                                                   $new_array[]= array(
                                                            'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
                                                            'name'=> 'remarks',
                                                    );
                                                    $new_array[]= array(
                                                            'header'=>'Status',
                                                            'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                            'name'=> 'is_failed',
                                                    );
                                                    $new_array[]= array(
                                                            'class'=>'CButtonColumn',
                                                            'buttons' => array(
                                                                    'update' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$updateUrl, // a PHP expression for generating the URL of the button
                                                                    ),
                                                                    'delete' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$delUrl, // a PHP expression for generating the URL of the button
                                                                    ),

                                                            ),
                                                            'template'=>'{update} {delete}',
                                                            'afterDelete'=>'function(){window.location.reload();}',
                                                            'header'=>Yii::t('app','Manage'),
                                                            'headerHtmlOptions'=>array('style'=>'font-size:13px;')				
                                                    );
                                                        
						$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=>$new_array,
							
						));
						
					}
					elseif($exam->exam_type == 'Marks And Grades') // Show both Marks and Grades
					{
                                            
                                            //   <!-- DYNAMIC FIELD ARRAY START -->    
                                                $new_array=array();
                                                if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                                {
                                                    $new_array[]=array(
											'header'=>Yii::t('app','Student Name'),
											'value'=>'$data->gridStudentName(forTeacherPortal)',                                                                                        
											'name'=> 'firstname',
											'sortable'=>true,
										);
                                                }
                                                $new_array[]= 'marks';
                                                   
                                                $new_array[]=    array(
                                                            'header'=>Yii::t('app','Grades'),
                                                            'value'=>array($model,'getgradinglevelteacher'),
                                                            'name'=> 'grading_level_id',
                                                    );
                                                    $new_array[]= array(
                                                            'value'=>'$data->remarks ? "$data->remarks" : Yii::t("app","No Remarks")',
                                                            'name'=> 'remarks',
                                                    );
                                                    $new_array[]= array(
                                                            'header'=>'Status',
                                                            'value'=>'$data->is_failed == 1 ? Yii::t("app","Fail") : Yii::t("app","Pass")',
                                                            'name'=> 'is_failed',
                                                    );
                                                    $new_array[]= array(
                                                            'class'=>'CButtonColumn',
                                                            'buttons' => array(
                                                                    'update' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$updateUrl, // a PHP expression for generating the URL of the button
                                                                    ),
                                                                    'delete' => array(
                                                                    'label' => Yii::t('app','Update'), // text label of the button
                                                                    'url'=>$delUrl, // a PHP expression for generating the URL of the button
                                                                    ),

                                                            ),
                                                            'template'=>'{update} {delete}',
                                                            'afterDelete'=>'function(){window.location.reload();}',
                                                            'header'=>Yii::t('app','Manage'),
                                                            'headerHtmlOptions'=>array('style'=>'font-size:13px;')				
                                                    );
                                                        
						$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'exam-scores-grid',
						'dataProvider'=>$model->search(),
						'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
						'columns'=>$new_array,
							
						));
					}
                 }
            ?>
            <!-- End Score Table -->
		</div>
	</div>
    <?php
	} // End $checkscores
	else
	{
	?>
        <div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;margin-top:60px;">
            <div class="y_bx_head"><i>
               <?php echo Yii::t('app','No Scores Added'); ?>
           </i> </div>      
    	</div>
	<?php
	}?>
    <?php 
		   }?>
            
</div> 
</div></div>