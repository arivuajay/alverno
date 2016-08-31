 <?php

	$this->breadcrumbs=array(
	Yii::t('app','Teachers')=>array('employees/index'),
	Yii::t('app','Leave Requests'),
	);
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
    <td width="80" valign="top" id="port-left">
     <?php $this->renderPartial('/employees/left_side');?>
    
    </td>
    <td valign="top">
    
      
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
        
   	
    
        <div style="padding-left:20px;">
        <h1><?php echo Yii::t('app','Leave Request'); ?></h1>
            <div class="lreq_con">
            <?php if($list){?>
             <div class="pagecon">
     			 <?php                                          
				  $this->widget('CLinkPager', array(
				  'currentPage'=>$pages->getCurrentPage(),
				  'itemCount'=>$item_count,
				  'pageSize'=>$page_size,
				  'maxButtonCount'=>5,
				  //'nextPageLabel'=>'My text >',
				  'header'=>'',
					'htmlOptions'=>array('class'=>'yiiPager'),
				));?>	
            </div>
            <div class="clear"></div>
                        
            <?php foreach($list as $model1){ ?>
           
            	<div class="lreq_box <?php if($model1->viewed_by_manager){ echo 'l_read'; } ?>">
                	<div class="lreq_box_inner">
                    	<ul>
                        	<li class="name"><?php 
							$employee=Employees::model()->findByAttributes(array('uid'=>$model1->employee_id));
							echo CHtml::link($employee->concatened, array('view','id'=>$model1->id)); 
							
							?></li>
                            <li><strong><?php echo Yii::t('app','Type'); ?></strong> : <?php 
							$type=EmployeeLeaveTypes::model()->findByAttributes(array('id'=>$model1->employee_leave_types_id));
							echo $type->name; ?></li>
                            <li><strong><?php echo Yii::t('app','Applied Date'); ?></strong> : <?php echo date($date,strtotime($model1->date)); ?></li>
                        </ul>
                        <?php if($model1->approved==1){ ?>
                        <div class="lreq_approved"><?php echo Yii::t('app','Approved'); ?></div>
                        <?php }else if($model1->approved==2){ ?>
                         <div class="lreq_rejected"><?php echo Yii::t('app','Rejected'); ?></div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
				
				 <div class="pagecon">
     				 <?php                                          
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'yiiPager'),
                        ));?>	
                 </div>
                 <div class="clear"></div>
				
				<?php }else{
					$this->renderpartial('_empty');
				}?>
            
            </div>
        </div>
        
      

 </td>
</tr>
    </table>
    
   
    </td>
  </tr>
</table>

