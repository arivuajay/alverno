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
    	
		<h3 class="panel-title"><?php echo Yii::t('app', 'My Class Exam Details'); ?></h3>
	</div>
    <div class="people-item">
    <div class="btn-demo" style="position:relative; top:-8px; right:3px; float:right;">
        <div class="edit_bttns">
    		<ul>       
                <li><?php echo CHtml::link('<span>'.Yii::t('app','All Classes').'</span>',array('/teachersportal/exams/allexam'),array('class'=>'addbttn last'));?></li>                
                <li><?php echo CHtml::link('<span>'.Yii::t('app','My Class').'</span>',array('/teachersportal/exams/classexam'),array('class'=>'addbttn last'));?></li>                
    		</ul>
    		<div class="clear"></div>
		</div>
	</div>
    <br />
<div class="table-responsive">
	<?php
		/*echo 'Employee ID:'.$employee_id.'<br/>';
		echo 'Action ID:'.Yii::app()->controller->action->id.'<br/>';
		echo 'Batch ID:'.$batch_id.'<br/>';*/
	$batch=Batches::model()->findByAttributes(array('id'=>$batch_id));
        if($batch!=NULL)
		   { ?>
              
                   <div class="table-responsive">
                    	<table class="table table-bordered mb30">
                        	<tr>
                            	<td>      
                   <strong> <?php echo Yii::t('app','Course'); ?>:</strong>
                        <?php $course=Courses::model()->findByAttributes(array('id'=>$batch->course_id));
                        if($course!=NULL)
                           {
                               echo $course->course_name; 
                           }?></td>
                           <td> <strong> <?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?>: </strong><?php echo $batch->name; ?>
                    <?php if($exam_group_id!=NULL){ 
					$exam=ExamGroups::model()->findByAttributes(array('id'=>$exam_group_id,'batch_id'=>$batch_id));
					?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong> <?php echo Yii::t('app','Exam'); ?>: </strong><?php echo $exam->name; 
					}?></td>
                             </tr>
                             
                         </table>
              </div>
               
    <?php 
		   }?>
    <div class="edit_bttns" style=" float: right;">
        <ul>
        	<?php			
				$url = '/teachersportal/exams/classexams';
				$scheduleUrlExp = 'Yii::app()->createUrl("/teachersportal/exams/classexamschedule",array("bid"=>$data->batch_id,"exam_group_id"=>$data->id))';
				$resultUrlExp = 'Yii::app()->createUrl("/teachersportal/exams/classexamresult",array("bid"=>$data->batch_id,"exam_group_id"=>$data->id))';			
			?>
            <li><span>
        	<?php echo CHtml::link('<span>'.Yii::t('app','Change').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</span>', array('/teachersportal/exams/classexam'),array('id'=>'add_exam-groups','class'=>'addbttn')); ?>
        	</span></li>
        </ul>
        <div class="clear"></div>
    </div>
    <?php
    if($exam_group_id==NULL){ // If $exam_group_id == NULL, list of exams will be displayed
		$criteria=new CDbCriteria(array('condition'=>'batch_id='.$batch_id.' AND is_published = 1'));
		$dataProvider=new CActiveDataProvider('ExamGroups', array('criteria'=>$criteria));
		$this->widget('zii.widgets.grid.CGridView', array(
			 'id' => 'exam-groups-grid',
			 'dataProvider' => $dataProvider,
			 'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
			 'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
			 
			 'htmlOptions'=>array('class'=>'grid-view clear'),
			  'columns' => array(	
			
			'name',
			
			'exam_type',
			/*array(
				'name'=>'is_published',
				'value'=>'$data->is_published ? "Yes" : "No"'
			),*/
			
			array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->is_published ? Yii::t("app", "View Schedule") : Yii::t("app", "Not scheduled")',
			'urlExpression'=>'$data->is_published ? '.$scheduleUrlExp.' : "#"',
			'header'=>Yii::t('app','Is Published'),
			'headerHtmlOptions'=>array('style'=>'color:#FF6600')
			),
			array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->result_published ? Yii::t("app", "View Results") : ($data->is_published ? Yii::t("app", "Enter Scores") : Yii::t("app", "No Results Published"))',
			'urlExpression'=>'$data->result_published ? '.$resultUrlExp.' : ($data->is_published ? '.$resultUrlExp.' : "#")',
			'header'=>Yii::t('app','Result Published'),
			'headerHtmlOptions'=>array('style'=>'color:#FF6600')
			),
			
		),
			   'afterAjaxUpdate'=>'js:function(id,data){$.bind_crud()}'
	   ));
	}
	else{ //If $exam_group_id != NULL, details of the selected exam will be displayed
		//echo '<br/>Exam Group ID: '.$exam_group_id.'<br/>';
			
			$checkgroup = Exams::model()->findByAttributes(array('exam_group_id'=>$_REQUEST['exam_group_id']));
			if($checkgroup!=NULL)
			{?>
			<div >
			<div >
			<?php $model1=new Exams('search');
				  $model1->unsetAttributes();  // clear any default values
				  if(isset($_GET['exam_group_id']))
					$model1->exam_group_id=$_GET['exam_group_id'];
				 
				 
				  ?>
				  <h3> <?php echo Yii::t('app','Scheduled Subjects'); ?></h3>
				  <?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'exams-grid',
			'dataProvider'=>$model1->search(),
			'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
			'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
			
			'columns'=>array(
				
				array(
					'name'=>'subject_id',
					'value'=>array($model1,'subjectname')
				
				),
				'start_time',
				'end_time',
				'maximum_marks',
				'minimum_marks',
			),
		)); echo '</div></div>';}
		else
		{
			echo '<div class="notifications nt_red"><i>'.Yii::t('app','Nothing Scheduled').'</i></div>'; 
			}
	}
   ?>
 
</div>
</div>
</div>