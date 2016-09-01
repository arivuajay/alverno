
	<?php $this->renderPartial('/default/leftside');?> 
   
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
    
    
    <div class="clearfix"></div>
    <div class="contentpanel">
		<!--<div class="col-sm-9 col-lg-12">-->
        <div>
			<div class="panel panel-default">
			<div class="panel-body">
    <div id="parent_rightSect">
    	<div class="pdtab_Con">
        <div class="table-responsive">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-hover mb30">
                                <tbody>
                                <!--class="cbtablebx_topbg"  class="sub_act"-->
                                <tr>
                                    <th align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app', 'Name');?></th>
                                    <th align="center"><?php echo Yii::t('app', 'Program Coordinator');?></th>
                                    <th align="center"><?php echo Yii::t('app', 'Start Date');?></th>
                                    <th align="center"><?php echo Yii::t('app', 'End Date');?></th>
                                    
                                </tr>
                                
   <?php    
	
    
	$courses=array();
	foreach($batches_id as $batch_id)
	{
		$batch=Batches::model()->findByAttributes(array('id'=>$batch_id));
		//$courses[] = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
	
		$course_coordinator = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
								?>
                                    <tr id="batchrow1" >
                                        <td style="text-align:left; padding-left:10px; font-weight:bold;">
                                            <?php echo CHtml::link(ucfirst($batch->name),array('subjects','id'=>$batch->id),array('class'=>'profile_active'));?>
                                        </td>
                                        <td><?php echo ucfirst($course_coordinator->first_name).' '.ucfirst($course_coordinator->last_name);?></td>
                                        <?php 
										$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
										if($settings!=NULL)
												{	
													$batch_start_date = date($settings->displaydate,strtotime($batch->start_date));
													$batch_end_date = date($settings->displaydate,strtotime($batch->end_date));
													
												}?>
                                        <td><?php echo $batch_start_date; ?></td>
                                        <td><?php echo $batch_end_date; ?></td>
                                        
                                    </tr>
                               <?php
	                        }
	                        ?>
                                
                                </tbody>
                            </table>
                        
                            </div>
                            </div>
                        </div><!-- table-responsive -->
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
                
            </div>
    
      
      
      
      
    </div><!-- contentpanel -->
   
   
    
    
    
   