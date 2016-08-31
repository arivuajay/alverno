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
if(isset($_REQUEST['id']))
{
	
	$criteria = new CDbCriteria;
	$criteria->condition = 'is_deleted=:is_deleted AND is_active=:is_active';
	$criteria->params[':is_deleted'] = 0;
	$criteria->params[':is_active'] = 1;
	
	
	$batch_students = BatchStudents::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id'],'result_status'=>0));
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
		$criteria->params[':batch_id'] = $_REQUEST['id'];
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
		$template = $template.'{update}';
	}
	
	if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
	{
		$template = $template.'{delete}';
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


    <div class="formCon">
        <div class="formConInner">
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
                <?php echo $form->hiddenField($model,'exam_id',array('value'=>$_REQUEST['examid'])); ?>
                <h3><?php echo Yii::t('app','Enter Exam Scores here:');?></h3>
                <div class="tableinnerlist">
                    <table width="95%" cellspacing="0" cellpadding="0">
                        <?php 
                        $i=1;
                        $j=0;
						
                        foreach($posts as $posts_1)
                        { 
							$sub=NULL;
							$student_elective=NULL;
                            $checksub = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid'],'student_id'=>$posts_1->id));
                            $exm = Exams::model()->findByAttributes(array('id'=>$_REQUEST['examid']));
							if($exm!=NULL)
							{
                            	$sub = Subjects::model()->findByAttributes(array('id'=>$exm->subject_id));
							}
							if($sub!=NULL)
							{
								
								$student_elective = StudentElectives::model()->findByAttributes(array('student_id'=>$posts_1->id, 'elective_group_id'=>$sub->elective_group_id));
							}
							
                            if($checksub==NULL and (($sub->elective_group_id==0 and count($sub)!=0) or ($sub->elective_group_id!=0 and count($student_elective)!=0)))
                            {
                                if($j==0)
                                {
                                ?>
                                
                                    <tr>
                                        <th><?php echo Yii::t('app','Student Name');?></th>
                                        <th><?php echo Yii::t('app','Subject');?></th>
                                        <th><?php echo Yii::t('app','Marks');?></th>
                                        <th><?php echo Yii::t('app','Remarks');?></th>
                                    </tr>
                                    <?php 
                                    $j++;
                                }
								
								if($student_elective==NULL and $sub->elective_group_id==0){
									$flag=0;
                                ?>
                                
								<tr>
                                    <td>
                                        <?php echo $posts_1->studentFullName("forStudentProfile"); ?><br />
                                    </td>
                                    <td>
                                    
                                        <?php 
										echo ucfirst($sub->name);
                                        if($sub->elective_group_id!=0)
                                        {
                                            /*$studentelctive = StudentElectives::model()->findByAttributes(array('student_id'=>$posts_1->id));
                                            if($studentelctive==NULL) 
                                            {*/
                                            ?>
                                                <?php /*?><?php echo '<i><span style="color:#E26214;">'.Yii::t('app','Elective not assigned').'</span></i>  '.CHtml::link(Yii::t('app','Add now'),array('/courses/batches/elective','id'=>$_REQUEST['id'])); ?><?php */?>
                                            <?php
                                           // }
										   $flag=1;
                                        }?>
                                        <?php echo $form->hiddenField($model,'student_id[]',array('value'=>$posts_1->id,'id'=>$posts_1->id)); ?>
                                    </td>
                                    
                                    <td>
                                        <?php 
										if($insert_score == 1 and $flag==0)
										{
											echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>3,'id'=>$posts_1->id,'onclick'=>'alertmessage()'));
										}
										else
										{
											echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>3,'class'=>'disabled_field','id'=>$posts_1->id,'disabled'=>'disabled'));
										}
										?>
                                    </td>                 
                                    <td>
										<?php 
										if($insert_score == 1 and $flag==0)
										{
											echo $form->textField($model,'remarks[]',array('size'=>30,'maxlength'=>255,'id'=>$posts_1->id));
										}
										else
										{
											echo $form->textField($model,'remarks[]',array('size'=>30,'maxlength'=>255,'class'=>'disabled_field','id'=>$posts_1->id,'disabled'=>'disabled'));
										}
										?>
									</td>
                                </tr>	
                                
                                <?php echo $form->hiddenField($model,'grading_level_id'); ?>
                                <?php //echo $form->hiddenField($model,'is_failed'); ?>
                                
                                
                                <?php 
                                echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
                                echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d')));
								} // subject mark form ends here
								else{
									$flag=0;
									//if($student_elective->elective_group_id==$sub->elective_group_id){
                                ?>
                                
                                        <?php 
                                        if($sub->elective_group_id!=0)
                                        {
                                            $studentelctive = StudentElectives::model()->findByAttributes(array('elective_group_id'=>$sub->elective_group_id,'student_id'=>$posts_1->id,'elective_group_id'=>$sub->elective_group_id));
											$electiveid = Electives::model()->findByAttributes(array('id'=>$studentelctive->elective_id));
										?>
										<?php
                                            if($studentelctive!=NULL) 
                                            {
											
                                        ?>
                                        <tr>
                                            <td>                       
                                                <?php echo $posts_1->first_name.' '.$posts_1->middle_name.' '.$posts_1->last_name;?>
                                            </td>
                                            <td>
                                        	<?php
                                                if($electiveid!=NULL)
												{
													echo ucfirst($electiveid->name);
													
												}
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
									
										}
									}
								}
							
								
                               
									
							$i++;} 
                        }// END foreach($posts as $posts_1)
                        ?>
                    </table>
                    
                    <br />
                    <?php 
					
                    if($i==1)
                    {
						
                    
                        echo '<div class="notifications nt_green">'.'<i>'.Yii::t('app','Exam Score Entered For All Students').'</i></div>'; 
                        $allscores = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['examid']));
                        $sum=0;
                        foreach($allscores as $allscores1)
                        {
                            $sum=$sum+$allscores1->marks;
                        }
                        $avg=$sum/count($allscores);
						 $avg=substr($avg,0,5);
                        echo '<div class="notifications nt_green">'.Yii::t('app','Class Average').' = '.$avg.'</div>';
                        echo '<div style="padding-left:10px;">';
                        echo CHtml::link(Yii::t('app', 'Generate PDF'), array('examScores/pdf','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('target'=>"_blank",'class'=>'pdf_but'));
                        
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
							echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); 
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
	$checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
	if($checkscores!=NULL)
	{
	?>
        
        
        <?php 
		$model1=new ExamScores('search');
        $model1->unsetAttributes();  // clear any default values
        if(isset($_GET['examid']))
        	$model1->exam_id=$_GET['examid'];
        ?>
        <h3> <?php echo Yii::t('app','Scores');?></h3>
        <div class="formCon">
            <div class="formConInner">
               <?php                
               if(isset($_REQUEST['examid']) && $_REQUEST['examid']!=NULL)
               {
                   $examId= $_REQUEST['examid'];
                   $exam= Exams::model()->findByAttributes(array('id'=>$examId));
                   if($exam)
                   {
                       $group= ExamGroups::model()->findByPk($exam->exam_group_id);
                       if($group)
                       {
                           echo Yii::t('app','Exam Group')." : ". $group->name."<br><br>";
                       }
                       
                       $sub= Subjects::model()->findByPk($exam->subject_id);
                       if($sub) 
                       {
                           
                           echo Yii::t('app','Subject')." : ". $sub->name;
                       }
                       
                           
                   }
                   
               }
               ?>
            </div>
        </div>
        <?php
        if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_delete->settings_value!=0))
		{
		?>
        <div style="position:relative">    
            <div class="edit_bttns" style="width:250px; top:-10px; right:-123px;">
                <ul>
                    <li>
                    <?php echo CHtml::link('<span>'.Yii::t('app','Clear All Scores').'</span>', array('examScores/deleteall','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('class'=>'addbttn last','confirm'=>Yii::t('app','Are you sure you want to delete all scores ?.')));?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <?php
		}
		?>
        
        
        <?php
	   $exm = Exams::model()->findByAttributes(array('id'=>$_REQUEST['examid']));
	   $examgroups = ExamGroups::model()->findByAttributes(array('id'=>$exm->exam_group_id));  
        
        if($examgroups->exam_type =='Marks') // Marks Only
        {
           $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
            if($checkscores!=NULL)
            {
				$new_array=array();
				if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){
					$new_array[]	= array(
                        'header'=>Yii::t('app','Student Name'),
                        'value'=>array($model,'studentFullName'),
                        'name'=> 'firstname',
                        'sortable'=>true,
                    );
				}
        		$new_array[]	= 'marks';
				$new_array[]	= 'remarks';
				$new_array[]	= array(
						'header'=>Yii::t('app','Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app','Are you sure you want to delete this score ?'),
                        'buttons' => array(
                                                                 
									'update' => array(
									'label' => Yii::t('app','Update'), // text label of the button
									
									'url'=>'Yii::app()->createUrl("/examination/examScores/update", array("sid"=>$data->id,"examid"=>$data->exam_id,"id"=>$_REQUEST["id"]))', // a PHP expression for generating the URL of the button
								  
									),
									
								),
								'template'=>$template,
								'afterDelete'=>'function(){window.location.reload();}',
								'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
                                                                
                    );
				
				
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>$new_array,
            )); 
            }
        }
        else if($examgroups->exam_type =='Grades') // Grades Only
        {
            $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
            if($checkscores!=NULL)
            {
				$new_array=array();
				if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){
					$new_array[]	= array(
                        'header'=>Yii::t('app','Student Name'),
                        'value'=>array($model,'studentFullName'),
                        'name'=> 'firstname',
                        'sortable'=>true,
                    );
				}
				$new_array[]	= array(
                        'header'=>Yii::t('app','Grades'),
                        'value'=>array($model,'getgradinglevel'),
                        'name'=> 'grading_level_id',
                    );
				
				$new_array[]	= 'remarks';
				$new_array[]	= array(
						'header'=>Yii::t('app','Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app','Are you sure you want to delete this scores ?'),
                        'buttons' => array(
                                                                 
										'update' => array(
										'label' => Yii::t('app','Update'), // text label of the button
										
										'url'=>'Yii::app()->createUrl("/courses/examScores/update", array("sid"=>$data->id,"examid"=>$data->exam_id,"id"=>$_REQUEST["id"]))', // a PHP expression for generating the URL of the button
									  
										),
										
									),
						'template'=>$template,
						'afterDelete'=>'function(){window.location.reload();}',
						'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
													
                    );
				
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>$new_array,
            )); 
            }
        
        }
        else  // Marks and Grades
        {
            $checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
            if($checkscores!=NULL)
            {
        		$new_array=array();
				if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){
					$new_array[]	= array(
                        'header'=>Yii::t('app','Student Name'),
                        'value'=>array($model,'studentFullName'),
                        'name'=> 'firstname',
                        'sortable'=>true,
                    );
				}
				$new_array[]	= 'marks';
				$new_array[]	= array(
                        'header'=>Yii::t('app','Grades'),
                        'value'=>array($model,'getgradinglevel'),
                        'name'=> 'grading_level_id',
                    );
				
				$new_array[]	= 'remarks';
				$new_array[]	= array(
						'header'=>Yii::t('app','Action'),
                        'class'=>'CButtonColumn',
						'deleteConfirmation'=>Yii::t('app','Are you sure you want to delete this scores ?'),
                        'buttons' => array(
                                                                 
											'update' => array(
											'label' => Yii::t('app','Update'), // text label of the button
											
											'url'=>'Yii::app()->createUrl("/examination/examScores/update", array("sid"=>$data->id,"examid"=>$data->exam_id,"id"=>$_REQUEST["id"]))', // a PHP expression for generating the URL of the button
										  
											),
											
										),
						'template'=>$template,
						'afterDelete'=>'function(){window.location.reload();}',
						'visible'=>($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and ($is_edit->settings_value!=0 or $is_delete->settings_value!=0)),
                                                                
                    );
                $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'exam-scores-grid',
                'dataProvider'=>$model1->search(),
                'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
                'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
                'columns'=>$new_array,
            )); 
            }
        }
        
        echo '</div></div>';
        
        
	}
	else
	{
		echo '<div class="notifications nt_red">'.'<i>'.Yii::t('app','No Scores Updated').'</i></div>'; 
	}
	?>
       
<?php
} // END if REQUEST['id'] 
else
{
	echo '<div class="notifications nt_red">'.'<i>'.Yii::t('app','Nothing Found').'</i></div>'; 
}
?>
<script>
$('input[type="text"][name="ExamScores[marks][]"]').blur(function(e) {
    if(isNaN($(this).val())){
  $(this).val('');
 }
});
</script>
	
	
	