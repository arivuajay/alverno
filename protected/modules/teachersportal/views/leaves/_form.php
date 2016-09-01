<div class="panel panel-default">
<div class="panel-heading">
     <h3 class="panel-title"><?php echo Yii::t('app', 'Leave Status'); ?></h3>
</div>
<div class="people-item">
	<div class="table-responsive">
      <table class="table table-hover mb30">
      <thead>
        <tr>
          <th><?php echo Yii::t("app", "Leave Type");?></th>
          <th><?php echo Yii::t("app", "Total");?></th>
          <th><?php echo Yii::t("app", "Taken");?></th>
        </tr>
      </thead>
      <tbody>
        <?php
			foreach($type2 as $type1) {	
				$employee_details = Employees::model()->findByAttributes(array('uid'=>Yii::app()->user->id));						
				$days=0;
				$taken=EmployeeAttendances::model()->findAllByAttributes(array('employee_id'=>$employee_details->id,'employee_leave_type_id'=>$type1->id));
				if($taken){							  
					foreach($taken as $taken1){
						if($taken1->is_half_day == 1){
							$days=$days+.5;
						}else{
							$days=$days+1;
						}
					}	
				}
		?>
        <tr>
          <td><?php echo $type1->name ; ?></td>
          <td><?php echo $type1->max_leave_count ; ?></td>
          <td><?php echo $days; ?></td>
        </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
</div> </div>
 <div class="panel-heading">
     <h3 class="panel-title"><?php echo Yii::t('app', 'Leaves'); ?></h3>
    </div>
   
    <div class="panel panel-default">
<div class="panel-body">
	<div class="clearfix">
    	 <div class="row">
         <div class="cont_right formWrapper usertable">
         	<?php 
   $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));   
   
   if($settings!=NULL)
    {
		if($settings->displaydate!=NULL){
       		$date = $settings->displaydate;
		}else{
			$date = 'd-m-Y';
		}
		if($settings->dateformat!=NULL){
			$datepick = $settings->dateformat;
		}else{
	   		$datepick = 'dd-mm-yy';
		}
	   if ($model->start_date!= NULL )
			$model->start_date=date($settings->displaydate,strtotime($model->start_date));
	   if ($model->end_date!= NULL )
		   $model->end_date=date($settings->displaydate,strtotime($model->end_date));
	   
    }
    else
	{
    	$date = 'd-m-Y';	
		$datepick = 'dd-mm-yy';	 
		 
		if ($model->start_date!= NULL )
   	   		$model->start_date=date($settings->displaydate,strtotime($model->start_date));
	   if ($model->end_date!= NULL )
		   $model->end_date=date($settings->displaydate,strtotime($model->end_date));
	}
	
 ?>
      <?php if(Yii::app()->user->hasFlash('success')): ?>
      <?php
	  Yii::app()->clientScript->registerScript(
			'animateFlashMsg',
			'$(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");',
			CClientScript::POS_READY
		);
	   echo '<div class="alert alert-success" >' .Yii::app()->user->getFlash('success') . "</div>\n"; ?>
      <?php endif; ?>
      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'leave-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onsubmit'=>"available(); return false;"),
		
        )); ?>
      <?php echo $form->hiddenField($model,'date',array('value'=>date('Y-m-d H:i:s'))); ?>
      <?php 
        if($form->errorSummary($model)){ 
        ?>
      <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
        <span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span> </div>
      <?php 
        }
        ?>
         	<div class="col-sm-4">
            	<div class="form-group"> 
					<?php echo $form->labelEx($model,'employee_leave_types_id',array('control-label')); ?> 
                   
					<?php 
					$criteria = new CDbCriteria();
					$criteria->compare('status',1,true);
					$criteria->order = 'name';
					echo $form->dropDownList($model,'employee_leave_types_id',CHtml::listData(EmployeeLeaveTypes::model()->findAll($criteria),'id','name'),array('class'=>'form-control','empty'=>Yii::t('app', 'Select Leave Type'))); ?> 
					<?php echo $form->error($model,'employee_leave_types_id'); ?> 
                    <div id="leave_type_error" style="color:#F00"></div>
					<?php echo $form->hiddenField($model,'employee_id',array('value'=>Yii::app()->user->id)); ?>
                    
                </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group"> 
                	<?php echo $form->labelEx($model,'start_date'); ?>
                    <?php 
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                //'name'=>'Students[date_of_birth]',
                                'attribute'=>'start_date',
                                'model'=>$model,
                                // additional javascript options for the date picker plugin
                                'options'=>array(
                                'showAnim'=>'fold',
                                'dateFormat'=>$datepick,
                                'changeMonth'=> true,
                                'changeYear'=>true,
                                'yearRange'=>'1900:'
                                ),
                                'htmlOptions'=>array(
                                'class'=>'form-control',
								'readonly'=>'readonly'
                                ),
                                ));
                                ?>
            	<?php echo $form->error($model,'start_date'); ?>
            	<div id="start_date_error" style="color:#F00"></div>
                </div>
                </div>
                <div class="col-sm-4">
                <div class="form-group">
                	<?php echo $form->labelEx($model,'end_date'); ?>
            		<?php 
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                //'name'=>'Students[date_of_birth]',
                                'attribute'=>'end_date',
                                'model'=>$model,
                                // additional javascript options for the date picker plugin
                                'options'=>array(
                                'showAnim'=>'fold',
                                'dateFormat'=>$datepick,
                                'changeMonth'=> true,
                                'changeYear'=>true,
                                'yearRange'=>'1900:'
                                ),
                                'htmlOptions'=>array(
                                'class'=>'form-control',
								'readonly'=>'readonly'
                                ),
                                ));
                                ?>
            	<?php echo $form->error($model,'end_date'); ?> 
                <div id="end_date_error" style="color:#F00"></div>
                </div>
                </div>
                <div class="col-sm-12">
                <div class="form-group"><br />
                	<?php echo $form->labelEx($model,'reason',array('control-label')); ?>
					<?php echo $form->textArea($model,'reason',array('size'=>15,'maxlength'=>1000,'class'=>'form-control')); ?>
             		<?php echo $form->error($model,'reason'); ?>
                    <div id="reason_error" style="color:#F00"></div>
                </div>
                </div>
                <div class="col-sm-12">
                <div class="form-group"><br />
                	<?php echo $form->labelEx($model,'is_half_day',array('control-label')); ?>
					<?php echo $form->checkBox($model,'is_half_day',array( 'onChange' => 'javascript:showradio()', 'id'=>'is_half_day')); //?>
             		<?php echo $form->error($model,'is_half_day'); ?>
                </div>
				</div>
				
				<div class="col-sm-12">
				<?php 
					if($model->is_half_day == 1){
						$check_display = 'block';
					}else{
						$check_display = 'none';
					}
				?>
				<div class="form-group" id="halfday" style="display:<?php echo $check_display; ?>"><br/>
					<?php 	echo CHtml::radioButtonList('half_session','1',array('1'=>Yii::t('app', 'Morning Half'),'2'=>Yii::t('app', 'Afternoon Half')),array(
								'labelOptions'=>array('style'=>'display:inline'), // add this code
								'separator'=>' ',
							)); 
					?>
				</div><br/>
                </div>
             
         </div>
         
         </div>
    </div>
 </div>
 <div class="panel-footer">
                <?php echo CHtml::submitButton(Yii::t('app','Apply'),array('class'=>'btn btn-danger')); ?>
             
              </div>  
              <?php $this->endWidget(); ?> 
</div>



<div class="panel-heading">
     <h3 class="panel-title"><?php echo Yii::t('app', 'Leave Request'); ?></h3>
</div>
<div class="people-item">
<div class="table-responsive">

<?php if($list){?>
 <div class="pager" style="margin: 0 20px 10px 0;">
     			 <?php   //var_dump($item_count);exit;                                       
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'pager'),
                        ));?>	
                        </div>


	<table class="table table-hover mb30">
      <thead>
        <tr>
          <th>&nbsp;</th>
         
          <th><?php echo Yii::t("app", "Leave Type");?></th>
          <th><?php echo Yii::t("app", "Applied Date");?></th>
          <th><?php echo Yii::t("app", "Start Date");?></th>
          <th><?php echo Yii::t("app", "End Date");?></th>
          <th><?php echo Yii::t("app", "Status");?></th>
          <th><?php echo Yii::t("app", "Action");?></th>          
        </tr>
      </thead>
      <tbody>
       
    <?php
		foreach($list as $applied1){ 
			$date_arr = '';
			$flag = 0;
			if($applied1->approved == 1){
				$date_arr = Configurations::daterange($applied1->start_date,$applied1->end_date);
				for($i = 0; $i<count($date_arr); $i++){
					if($date_arr[$i] < date('Y-m-d')){
						$flag = 1;
					}
				}
			}
			
			
				
	?>
    
         <tr>
          
          <td><span class="fa fa-file" style="font-size:25px; color:#CCC"></span></td>
         
		  <?php 
				//$employee=Employees::model()->findByAttributes(array('uid'=>$applied1->employee_id));
				//echo CHtml::link($employee->concatened, array('view','id'=>$applied1->id)); 
		  ?>
         
          <td><?php 
				$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$applied1->employee_leave_types_id));
				echo $type->name; ?></td>
                <td><?php echo date($date,strtotime($applied1->date)); ?></td>
                <td><?php echo date($date,strtotime($applied1->start_date)); ?></td>
                <td><?php echo date($date,strtotime($applied1->end_date)); ?></td>
                <td> <?php if($applied1->approved==NULL or $applied1->approved==0){ ?>
        		<span class="label label-warning" ><?php echo Yii::t("app", "Pending");?></span>
       			<?php }else if($applied1->approved==1){ ?>
        		<span class="label label-success" ><?php echo Yii::t("app", "Approved");?></span>
        		<?php }else if($applied1->approved==2){ ?>
        		<span class="label label-danger" ><?php echo Yii::t("app", "Rejected");?></span>
    <?php } ?>
        </td>
        <td>        	
			<?php
				if($flag == 0){
					echo CHtml::link(Yii::t('app','Cancel'),array('cancel','id'=>$applied1->id),array('class'=>'label label-danger','confirm'=>Yii::t('app','Are you sure?'))); 
				}
			?>
            
            
        </td>
        
         </tr>
 
          <?php }?>
      </tbody>
    </table>
     <div class="pager" style="margin: 0 20px 10px 0;">
     			 <?php   //var_dump($item_count);exit;                                       
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'pager'),
                        ));?>	
                        </div>
    
    <?php }else{
				$this->renderpartial('_empty');
		} ?>
</div>
</div>

<script>

function showradio(){
		if(is_half_day.checked==1){
			$('#halfday').show();
		}
		else {
		  $('#halfday').hide();
		}
}


function available()
{
	$('#leave_type_error').html('');
	$('#start_date_error').html('');
	$('#end_date_error').html('');
	$('#reason_error').html('');
	var type = $("#ApplyLeaves_employee_leave_types_id option:selected").text();
	var type_value = $("#ApplyLeaves_employee_leave_types_id").val();
	var start_date = $('#ApplyLeaves_start_date').val();
	var end_date = $('#ApplyLeaves_end_date').val();
	var reason = $('#ApplyLeaves_reason').val();
	
	if(type_value ==''){	
		$('#leave_type_error').html('Select Leave Type');
		return false;
	}else if(start_date ==''){	
		$('#start_date_error').html('Select Start Date');
		return false;
	}else if(end_date ==''){	
		$('#end_date_error').html('Select End Date');
		return false;
	}else if(reason ==''){	
		$('#reason_error').html('Reason cannot be blank');
		return false;
	}else{
		$.ajax(
			{
				type: "POST",
				url: "<?php echo Yii::app()->createUrl('teachersportal/leaves/check');?>",
				data:$('#leave-form').serialize(),
				success: function(result)
				{			
					var is_count = result.split(',').length;
					if(is_count == 2){
						result = result.replace(',', '');
					}			
					if(result == '-1' && is_count == 1)
					{
						alert('<?php echo Yii::t("app", "End Date Must be larger than Start Date");?>');
					}
					/*else if(result == '-2' && is_count == 1)
					{
						alert('<?php //echo Yii::t("app", "Start Date Must be larger than Current Date");?>');
					}*/
					else if(result == '-3' && is_count == 1)
					{
						alert('<?php echo Yii::t("app", "Leave already taken");?>');
					}
					else if(result == '-4' && is_count == 1)
					{
						alert("<?php echo Yii::t("app", "Can't apply leave for holidays");?>");
					}
					else if(result == '-5' && is_count == 1)
					{
						alert('<?php echo Yii::t("app", "Already appied leave date(s) are in the request");?>');
					}
					else if(result == '-7' && is_count == 1)
					{
						alert('<?php echo Yii::t("app", "For Half Day leave Start Date and End must be same.");?>');
					}
					else if (result < 0 && is_count == 2){				
						var r = confirm("<?php echo Yii::t('app', 'No leave left in the selected leave type.If you want to proceed press OK');?>");
						if (r==true)
						{
							document.getElementById("leave-form").submit();
						}
						else
						{
							return false;
						}
					}
					else
					{ 
						document.getElementById("leave-form").submit();
					}
				}
		});
	
		return false;
	}
}


</script>