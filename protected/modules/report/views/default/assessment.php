<?php
$this->breadcrumbs=array(
	Yii::t('app','Report')=>array('/report'),
	Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Assessment Report'),
);
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('left_side');?>
 </td>
    <td valign="top"> 
    <div class="cont_right">
    <h1><?php echo Yii::t('app','Assessment Report');?></h1>
	<div class="formCon">
     <div class="formConInner">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="s_search">
        	<tr>
                <td>&nbsp;</td>
                <td style="width:200px;"><strong><?php echo Yii::t('app','Academic Year');?></strong></td>
                <td>&nbsp;</td>
                <td>
				<?php
                $academic_yrs = AcademicYears::model()->findAll("is_deleted =:x", array(':x'=>0));
                $academic_yr_options = CHtml::listData($academic_yrs,'id','name');
                ?>
                <?php
                echo CHtml::dropDownList('yid','',$academic_yr_options,array('prompt'=>Yii::t('app','Select Year'),'style'=>'width:200px;',
                'ajax' => array(
                'type'=>'POST',
                'url'=>CController::createUrl('/report/default/batchlist'),
                'update'=>'#batch',
                'data'=>'js:$(this).serialize()'
                ),'options'=>array($_REQUEST['yid']=>array('selected'=>true))));
                ?>
                
                
                
                
                </td>
			</tr>
            
            <tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
        
            <tr>
                <td>&nbsp;</td>
                <td style="width:100px;"><strong><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></strong></td>
                <td>&nbsp;</td>
                 <?php 
				 
					if($year_id==NULL)
					{
						$current_academic_yr = Configurations::model()->findByPk(35);
						$year_id  = $current_academic_yr->config_value;					
					}
                  $criteria  = new CDbCriteria;
                  $criteria ->condition = 'academic_yr_id =:academic_yr and is_active=:x and is_deleted=:y';
                  $criteria->params = array(':academic_yr'=>$year_id,':x'=>1,':y'=>0);
                  ?>
                <td> 
                <?php 
				
                if($batch_id!=NULL)
                {
                    echo CHtml::dropDownList('batch','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
                    'ajax' => array(
                    'type'=>'POST',
                    'url'=>CController::createUrl('/report/default/batch'),
                    'update'=>'#exam_id',
                    'data'=>'js:$(this).serialize()',),'style'=>'width:200px;','options' => array($batch_id=>array('selected'=>true))));
                }
                else
                {
                    echo CHtml::dropDownList('batch','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),
                    'ajax' => array(
                    'type'=>'POST',
                    'url'=>CController::createUrl('/report/default/batch'),
                    'update'=>'#exam_id',
                    'data'=>'js:$(this).serialize()',),'style'=>'width:200px;'));
                }
                ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td valign="top"><strong><?php echo Yii::t('app','Examination');?></strong></td>
                <td>&nbsp;</td>
                
                <td><?php 
                if($batch_id)
                {
                    $data=ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$batch_id));
                    $data=CHtml::listData($data,'id','name');
                    echo CHtml::activeDropDownList($model_1,'id',$data,array('prompt'=>Yii::t('app','Select Examination'),'id'=>'exam_id','style'=>'width:200px;','options' => array($group_id=>array('selected'=>true))));
                    
                }
                else
                {
                    echo CHtml::activeDropDownList($model_1,'id',array(),array('prompt'=>Yii::t('app','Select Examination'),'id'=>'exam_id','style'=>'width:200px;'));
                }?></td>
            </tr>
            <tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
        </table>
       <div style="margin-top:10px;"><?php echo CHtml::submitButton(Yii::t('app','Search'),array('name'=>'search','class'=>'formbut')); ?></div>                       
       </div>
       </div>
     <br />
  <?php
  if(isset($list) and $list!=NULL)
  {
	  
	$flag='';
	$cls="even";
	 
	?>
     <div class="ea_pdf" style="top:220px;"><?php echo CHtml::link(Yii::t('app', 'Generate PDF'), array('/report/default/assessmentpdf','examid'=>$group_id,'id'=>$batch_id),array('target'=>"_blank",'class'=>'pdf_but')); ?></div>
     <br />
     
    <!-- Batch Assessment Report -->
    <div class="tablebx" style="overflow-x:auto;">
    	<!-- Assessment Table -->
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<!-- Table Headers -->
        	<tr class="tablebx_topbg">
                 <td style="width:90px;"><?php echo Yii::t('app','SL No.');?></td>
                <td style="width:90px;"><?php echo Yii::t('app','Adm No');?></td>
                <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                <td style="width:auto;min-width:100px;"><?php echo Yii::t('app','Name');?></td>
                <?php }?>
                 
                <?php
				foreach($list as $exam) // Creating subject column(s)
				{
                	$subject=Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));
				?>
                	<td style="width:auto; min-width:80px; text-align:center;"><?php if(count($list)>7){ echo @$subject->code; } else { echo @$subject->name; }?></td>
                <?php
				}
				?>
            </tr>
            <!-- End Table Headers -->
            <?php
			$batch_sl = 1;
            $students = Students::model()->findAllByAttributes(array('batch_id'=>$batch_id,'is_deleted'=>0,'is_active'=>1));
			if(isset($students) and $students!=NULL) // Checking if students are present
			{
				foreach($students as $student) // Creating row corresponding to each student.
				{
				?>
					<tr class=<?php echo $cls;?>>
                  <td style="padding-top:10px; padding-bottom:10px;"><?php echo $batch_sl; $batch_sl++;?></td>
						<td>
							<?php echo $student->admission_no; ?>
						</td>
                        <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
						<td>
							<?php echo CHtml::link($student->studentFullName("forStudentProfile"),array('/students/students/view','id'=>$student->id)); ?>
						</td>
                        <?php }?>
						<?php
						foreach($list as $exam) // Creating subject column(s)
						{
						$score = ExamScores::model()->findByAttributes(array('student_id'=>$student->id,'exam_id'=>$exam->id));
						$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
						?>
						
						<td>
						<?php
						if($score->marks!=NULL or $score->remarks!=NULL)
						{
						?>
							<!-- Mark and Remarks Column -->
							<table align="center" width="100%" style="border:none;width:auto; min-width:80px;">
								<tr>
									<td style="border:none;<?php if($score->is_failed == 1){?>color:#F00;<?php }?>">
										<?php 
										 $grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$examgroup->batch_id));
			                                             $t = count($grades);
														 if($examgroup->exam_type == 'Marks') {  
														 echo $score->marks; } 
														  else if($examgroup->exam_type == 'Grades') {
														  	
														   foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $score->marks)
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
														   else if($examgroup->exam_type == 'Marks And Grades'){
															 foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $score->marks)
																	{	
																		$grade_value =  $grade->name;
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																echo $score->marks . " & ".$grade_value ;
																break;
																
																	
																} 
																if($t<=0) 
																	{
																		echo $score->marks." & ".Yii::t('app',"No Grades") ;
																	}
																 } 
										?>
									</td>
								</tr>
								<tr>
									<td style="border:none;<?php if($score->is_failed == 1){?>color:#F00;<?php }?>">
										<?php 
										if($score->remarks!=NULL)
											echo $score->remarks;
										else
											echo '-';
										?>
									</td>
								</tr>
							</table>
							<!-- End Mark and Remarks Column -->
						<?php
						}
						else
						{
							echo '-';
						}
						?>
						</td>
						<?php
						}
						?>
					</tr>
				<?php 
				} // END Creating row corresponding to each student.
  			} // End Checking if students are present
			?>
        	
        </table>
        <!-- End Assessment Table -->
    </div>
    <!-- End Batch Assessment Report -->
    <br />
  
     <?php
	
  }
  ?>  
<div class="clear"></div>
    </div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>