
<div id="parent_Sect">
	<?php $this->renderPartial('/default/leftside');?> 
    <?php    
	/*$student=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $guard = Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));*/
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
<?php  $this->renderPartial('changebatch');?>
<div class="panel-body">
    <div id="parent_rightSect">
        <div class="parentright_innercon">
        	<?php $this->renderPartial('batch');?>
            <div class="edit_bttns" style="top:100px; right:25px">
                <ul>
                    <li>
                    <?php //echo CHtml::link('<span>'.Yii::t('studentportal','My Courses').'</span>', array('/studentportal/course'),array('class'=>'addbttn last'));?>
                    </li>
                </ul>
            </div>
            
         	
            <!-- Subjects Grid -->
            <div class="list_contner">
                    <div class="clear"></div>
                    <?php 
					if($list)
                    {
						
					?>
                    <br />
                    <div class="tablebx">  
                        <div class="pager" style="margin: 0 20px 10px 0;">
							<?php 
                              $this->widget('CLinkPager', array(
                              'currentPage'=>$pages->getCurrentPage(),
                              'itemCount'=>$item_count,
                              'pageSize'=>$page_size,
                              'maxButtonCount'=>5,
							  'prevPageLabel'=>'< Prev',
                              //'nextPageLabel'=>'My text >',
                              'header'=>'',
                            'htmlOptions'=>array('class'=>'pages'),
                            ));?>
                        </div> <!-- End div class="pagecon" --> 
                        <div class="clear"></div>
                          <div class="table-responsive">                                    
                        <table class="table table-hover mb30" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tablebx_topbg">
                                <th><?php echo Yii::t('app','Sl. No.');?></th>	
                                <th><?php echo Yii::t('app','Student Name');?></th>
                                <th><?php echo Yii::t('app','Admission No');?></th>
                                <th><?php echo Yii::app()->getModule("students")->labelCourseBatch();?></th>
                                <th><?php echo Yii::t('app','Gender');?></th>
                                <th><?php echo Yii::t('app','Log');?></th>
                                <!--<td style="border-right:none;">Task</td>-->
                            </tr>
                            <?php 
                            if(isset($_REQUEST['page']))
                            {
                            	$i=($pages->pageSize*$_REQUEST['page'])-9;
                            }
                            else
                            {
                            	$i=1;
                            }
                            $cls="even";
                            ?>
                            
                            <?php 
							foreach($list as $list_1)
                            {
								$flags = LogComment::model()->findAll('user_id=:x and flag=:y',array(':x'=>$list_1->id,':y'=>1));
							?>
                                <tr class=<?php echo $cls;?>>
                                <td><?php echo $i; ?></td>
                                <td><?php echo CHtml::link($list_1->first_name.'  '.$list_1->middle_name.'  '.$list_1->last_name,array('log','student_id'=>$list_1->id,'id'=>$_REQUEST['id']),array('class'=>'')); ?></td>
                                <td><?php echo $list_1->admission_no ?></td>
                                <?php 
								$batc = Batches::model()->findByAttributes(array('id'=>$list_1->batch_id)); 
                                if($batc!=NULL)
                                {
									$cours = Courses::model()->findByAttributes(array('id'=>$batc->course_id)); ?>
									<td><?php echo $cours->course_name.' / '.$batc->name; ?></td> 
                                <?php 
								}
                                else{
								?> 
                                	<td>-</td> 
								<?php 
								}
								?>
                                
                                <td>
									<?php 
                                    if($list_1->gender=='M')
                                    {
                                    	echo Yii::t('app', 'Male');
                                    }
                                    elseif($list_1->gender=='F')
                                    {
                                    	echo Yii::t('app', 'Female');
                                    }
                                    ?>
                                </td>
                                <td><?php echo CHtml::ajaxLink(count($flags),$this->createUrl('/teachersportal/course/logdetails',array('id'=>$list_1->id)),array('update'=>'#jobDialog'),array('id'=>'showJobDialog1'.$list_1->id,'class'=>'add')); 
	
	
	?>
                                <!--<td style="border-right:none;">Task</td>-->
                                </tr>
								<?php
                                if($cls=="even")
                                {
                                	$cls="odd" ;
                                }
                                else
                                {
                                	$cls="even"; 
                                }
                                $i++;
							} 
							?>
                        </table>
                         <div id="jobDialog"></div>
                        </div>
                        <div class="pager" style="margin: 0 20px 10px 0;">
                        <?php                                          
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
						  'prevPageLabel'=>'< Prev',
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'pages'),
                        ));?>
                        </div> <!-- END div class="pagecon" 2 -->
                        <div class="clear"></div>
                    </div> <!-- END div class="tablebx" -->
                    <?php 
					}
                    else
                    {
                    	echo '<div class="listhdg" align="center">'.Yii::t('app','Nothing Found!!').'</div>';	
                    }?>
                </div> 
        </div>
        </div>
        </div>
        </div>
            <!-- END Subjects Grid -->
            
            
            
        </div> <!-- END div class="parentright_innercon" -->
    </div> <!-- END div id="parent_rightSect" -->
    <div class="clear"></div>
</div> <!-- END div id="parent_Sect" -->
<div class="clear"></div>

