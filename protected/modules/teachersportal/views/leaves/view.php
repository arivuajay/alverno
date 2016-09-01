
<div id="parent_Sect">
	<?php $this->renderPartial('/default/leftside');?> 
        
    <div class="right_col"  id="req_res123">                                      
          
        <div id="parent_rightSect">
            <div class="parentright_innercon">
                 <h1><?php echo Yii::t('teachersportal','Leaves'); ?></h1>

				
               <?php

	$this->breadcrumbs=array($this->module->id);
	$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
   
   if($settings!=NULL)
   {
      $date=$settings->displaydate;
	   
   }
   else
   {
    	$date = 'd-m-Y';	 
	}
	
 ?>

      
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
        	
        	<div style="padding-left:20px;">
           
        	<div class="lreq_details">
            	<div class="lreq_top">
                	<h1><?php 
					$employee=Employees::model()->findByAttributes(array('uid'=>$model->employee_id));
					echo $employee->concatened;
					
					?></h1>
                    <h2>Type : <?php 
							$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$model->employee_leave_types_id));
							echo $type->name; ?></h2>
                    <div class="lreq_date"><strong>Start Date</strong> : <?php echo date($date,strtotime($model->start_date)); ?>&nbsp;&nbsp;&nbsp;&nbsp;<strong>End Date</strong> : <?php echo date($date,strtotime($model->end_date)); ?></div>
                </div>
                <div class="lreq_mid">
                	<?php echo $model->reason; ?>.
                </div>
                <div class="lreq_bottom">
                	
                    
                   <?php 
				   if($model->approved==1){
					   $class1='lreq_but approved';
					   $class2='lreq_but';
				   }
				   else if($model->approved==2){
					   $class2='lreq_but rejected';
					   $class1='lreq_but';
				   }
				   else{
					   $class1='lreq_but';
					   $class2='lreq_but';
				   }
				   
					
					?>

                	<div class="clear"></div>
                </div>
            </div>
            </div>
        </td>
     </tr>
    </table>
    
   
  

 
        	</div>
        </div>
        <div class="clear"></div>
    </div>
</div>















 