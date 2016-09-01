<style type="text/css">
th{ text-align:center;}
</style>

<?php echo $this->renderPartial('/default/leftside');?>
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
    		</ul>
    		<div class="clear"></div>
		</div>
	</div>
		<h3 class="panel-title"><?php echo Yii::t('app', 'My Class(es) Exam Details'); ?></h3>
	</div>
    <div class="people-item">
	<?php 
	/*If $flag = 1, list of batches will be displayed. 
	 *If $flag = 2, exam schedule page will be displayed.
	 *If $flag = 3, exam result page will be displayed.
	 *If $flag = 0, Employee not teaching in any batch. A message will be displayed.
	*/
    if($_REQUEST['id']!=NULL){
			
	 }
	else{
		// Get batch ID from Batches
		$employee = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		$batches_id=Batches::model()->findAll("employee_id=:x AND is_active=:y AND is_deleted=:z", array(':x'=>$employee->id,':y'=>1,':z'=>0));
		if(count($batches_id) >= 1){ // List of batches is needed
			$flag = 1;
		}
		elseif(count($batches_id) <= 0){ // If not teaching in any batch
			$flag = 0;
			
		}
	}
	
	
	if($flag == 0){ // Displaying message
	?>
    <div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;margin-top:60px;">
        <div class="y_bx_head">
            <?php echo Yii::t('app','No period is assigned to you now!'); ?>
        </div>      
    </div>
    <?php
	}
	if($flag == 1){ // Displaying batches the employee is assigned.
	?>
    	<div class="table-responsive">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered mb30">
                
                <thead>
                    <tr >
                        <th ><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app','Name');?></th>
                        <th ><?php echo Yii::t('app','Class Teacher');?></th>
                        <th ><?php echo Yii::t('app','Actions');?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
					foreach($batches_id as $batch_id)
					{

						echo '<tr id="batchrow'.$batch_id->id.'">'; 
						echo '<td style="text-align:center; padding-left:10px; font-weight:bold;">'.$batch_id->coursename.'</td>';
						$teacher = Employees::model()->findByAttributes(array('id'=>$batch_id->employee_id));					
						echo '<td align="center">';
						if($teacher){
							echo $teacher->first_name.' '.$teacher->last_name;
						}
						else{
							echo '-';
						}
						// Count if any exam timetables are published in a batch.
						$exams_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'is_published'=>1));
						// Count if any exam results are published in a batch.
						$result_published = ExamGroups::model()->countByAttributes(array('batch_id'=>$batch_id->id,'result_published'=>1));
						echo '<td align="center">';
						if($exams_published > 0 or $result_published > 0){
							echo CHtml::link(Yii::t('app','View Examinations'), array('/teachersportal/exams/classexams','bid'=>$batch_id->id,'employee_id'=>$batch_id->employee_id));
						}
						else{
							echo Yii::t('app','No Exam Scheduled');
						}
						echo '</td>';
						
						echo '</tr>';
					}
					?>
                </tbody>
            </table>
		</div>
	<?php
	}
	?>
    </div>
</div>