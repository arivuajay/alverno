<div id="parent_Sect">
	<?php $this->renderPartial('/default/leftside');?> 
    <?php    
	$student = Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
   /* $guard = Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));*/
	$exam_groups = ExamGroups::model()->findAllByAttributes(array('batch_id'=>$_REQUEST['id'],'is_published'=>1,'result_published'=>1));
	$model=new ExamGroups('search');
	$model->unsetAttributes();
	$model->batch_id=$_REQUEST['id'];
	//var_dump($model->search());exit;;
    ?>
    
    <div class="pageheader">
      <h2><i class="fa fa-envelope-o"></i> <?php echo Yii::t('app', 'My Course');?> <span><?php echo Yii::t('app', 'View courses here');?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t('app', 'You are here:');?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
         <li class="active"><?php echo Yii::t('app', 'Course');?></li>
        </ol>
      </div>
    </div>
    
   <div class="contentpanel">
<div class="col-sm-9 col-lg-12">
	<div class="panel panel-default">
     <?php $this->renderPartial('changebatch');?>
     
    	<div class="panel-body">
	
            <?php $this->renderPartial('batch');?>
            <div class="edit_bttns" style="top:100px; right:25px">
                <ul>
                    <li>
                    <?php //echo CHtml::link('<span>'.Yii::t('teachersportal','My Courses').'</span>', array('/teachersportal/course'),array('class'=>'addbttn last'));?>
                    </li>
                </ul>
            </div>
            <!-- Examination Area -->
        <div class="table-responsive">   
        <?php
    	 $this->widget('zii.widgets.grid.CGridView', array(
         'id' => 'exam-groups-grid',
         'dataProvider' => $model->search(),
		 'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	     'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
		 
         
         'htmlOptions'=>array('class'=>'grid-view clear'),
          'columns' => array(
          	
		
		
		
		array('header'=>Yii::t('app', 'Name'),
                    'value'=>'$data->name',
                    
                ),
		
		//'exam_type',
		array(
				'header'=>Yii::t('app', 'Assessment Type'),
				'name'=> 'exam_type',),
		
		array('header'=>Yii::t('app', 'Subjects'),
                    'value'=>array($model,'subjectname'),
                    'name'=> 'subject_id',
                ),
                

		array(
            'name'=>'is_published',
            'value'=>'$data->is_published ? Yii::t("app", "Yes") : Yii::t("app", "No")'
        ),
		array(
            'name'=>'result_published',
            'value'=>'$data->result_published ? Yii::t("app", "Yes") : Yii::t("app", "No")'
        ),
		/*array(
            'name'=>'trainee behaviour',
            'value'=>'$data->trainee_behaviour ? "Yes" : "No"'
        ),*/
		
		
		/*
		'exam_date',
		*/
/*
    array(
                   'class' => 'CButtonColumn',
                    'buttons' => array(
                                                     'exam-groups_delete' => array(
                                                     'label' => Yii::t('admin_exam-groups', 'Delete'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/cross.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_del", 'title' => Yii::t('admin_exam-groups', 'Delete')), // HTML options for the button   tag
                                                      ),
                                                     'exam-groups_update' => array(
                                                     'label' => Yii::t('admin_exam-groups', 'Update'), // text label of the button
                                                     'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                     'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/pencil.png', // image URL of the button.   If not set or false, a text link is used
                                                     'options' => array("class" => "fan_update", 'title' => Yii::t('admin_exam-groups', 'Update')), // HTML options for the    button tag
                                                        ),
                                                     'exam-groups_view' => array(
                                                      'label' => Yii::t('admin_exam-groups', 'View'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/properties.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_view", 'title' => Yii::t('admin_exam-groups', 'View')), // HTML options for the    button tag
                                                        ),
														
                                                    ),
                   'template' => '{exam-groups_view}{exam-groups_update}{exam-groups_delete}',
            ),
			array(
                   'class' => 'CButtonColumn',
                    'buttons' => array(
                                                     
														'add' => array(
                                                        'label' => 'Manage This Exam', // text label of the button
														
                                                        'url'=>'Yii::app()->createUrl("/examination/exams/create", array("exam_group_id"=>$data->id,"sid"=>$data->subject_id,"id"=>$_REQUEST["id"]))', // a PHP expression for generating the URL of the button
                                                      
                                                        )
                                                    ),
                   'template' => '{add}',
				   'header'=>'Manage',
				   'htmlOptions'=>array('style'=>'width:17%'),
				   'headerHtmlOptions'=>array('style'=>'color:#FF6600')
            ),*/
    ),
           'afterAjaxUpdate'=>'js:function(id,data){$.bind_crud()}'

                                            ));


   ?> 
         
        </div>    
        <div class="clear"></div>
        </div>    <!-- END Examination Area -->
        </div> <!-- END div class="parentright_innercon" -->
    </div>
    </div> <!-- END div id="parent_rightSect" -->
    
</div> <!-- END div id="parent_Sect" -->
<div class="clear"></div>

<script>
	$(".mcbrow").click(function(){
  		$(".portdtab_Con").toggle();
	});
</script>