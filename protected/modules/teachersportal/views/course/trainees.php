
	<?php $this->renderPartial('/default/leftside');?> 
    <?php    
	/*$student=Students::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
    $guard = Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));*/
    ?>
    
    <div class="pageheader">
      <h2><i class="fa fa-envelope-o"></i><?php echo Yii::t('app', 'My Course');?> <span><?php echo Yii::t('app', 'View courses here');?></span></h2>
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
                    <div class="tablebx"> 
                    <br /> 
                        <div class="dataTables_paginate paging_full_numbers">
							<?php 
                              $this->widget('CLinkPager', array(
                              'currentPage'=>$pages->getCurrentPage(),
                              'itemCount'=>$item_count,
                              'pageSize'=>$page_size,
                              'maxButtonCount'=>5,
							  'prevPageLabel'=>'< Prev',                              
							  'prevPageLabel'=>'< Prev',
                              'header'=>'',
                            'htmlOptions'=>array('class'=>'pages'),
                            ));?>
                        </div> <!-- End div class="pagecon" --> 
                         <div class="clearfix"></div>
                         <br />
    	<div class="pdtab_Con">
        <div class="table-responsive">                                  
                        <table width="95%" border="0" cellspacing="0" cellpadding="0" class="table table-hover mb30">
                            <tr class="tablebx_topbg">
                                <th><?php echo Yii::t('app','Sl. No.');?></th>
                                <?php if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                {?>
                              <th><?php echo Yii::t('app','Student Name');?></th>
                                <?php } ?>
                                
                                <?php if(FormFields::model()->isVisible('admission_no','Students','forTeacherPortal'))
                                {?>
                                <th><?php echo Yii::t('app','Admission No');?></th>
                                <?php } ?>
                                
                                <?php if(FormFields::model()->isVisible('batch_id','Students','forTeacherPortal'))
                                {?>
                                <th><?php echo Yii::app()->getModule("students")->labelCourseBatch();?></th>
                                <?php } ?>
                                <?php if(FormFields::model()->isVisible('gender','Students','forTeacherPortal'))
                                {?>
                                <th><?php echo Yii::t('app','Gender');?></th>
                                <?php } ?>
                                 
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
								
							?>
                                <tr class=<?php echo $cls;?>>
                                <td><?php echo $i; ?></td>
                                 <?php if(FormFields::model()->isVisible("fullname", "Students", "forTeacherPortal"))
                                {
                                     $name= "";
                                        if(FormFields::model()->isVisible('first_name','Students','forTeacherPortal'))
                                        {
                                            $name.= ucfirst($list_1->first_name);
                                        }
                                        if(FormFields::model()->isVisible('middle_name','Students','forTeacherPortal'))
                                        {
                                            $name.= " ".ucfirst($list_1->middle_name);
                                        }
                                        if(FormFields::model()->isVisible('last_name','Students','forTeacherPortal'))
                                        {
                                            $name.= " ".ucfirst($list_1->last_name);
                                        }
                                     ?>
                                <td><?php $student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forTeacherPortal');
								if(count($student_visible_fields)==0) 
								{
                                    echo $name;
								}
								else
								{
									echo CHtml::link($name,array('students','student_id'=>$list_1->id),array('class'=>'profile_active'));
								}
                                    //echo $list_1->first_name.'  '.$list_1->middle_name.'  '.$list_1->last_name; ?></td>
                                <?php } ?>
                                <?php if(FormFields::model()->isVisible('admission_no','Students','forTeacherPortal'))
                                {?>
                                
                                <td><?php echo $list_1->admission_no ?></td>
                                <?php } ?>
                                
                                <?php if(FormFields::model()->isVisible('batch_id','Students','forTeacherPortal'))
                                {?>
                                
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
                                <?php } ?>
                                <?php if(FormFields::model()->isVisible('gender','Students','forTeacherPortal'))
                                {?>
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
                                <?php } ?>
                                
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
                        </div>
                        <div class="dataTables_paginate paging_full_numbers">
                        <?php                                          
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
							  'prevPageLabel'=>'< Prev',
                          'prevPageLabel'=>'< Prev',
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
            <!-- END Subjects Grid -->
            
            
            
        
        </div> 
        </div>
        </div>
        </div>
        </div> <!-- END div class="parentright_innercon" -->
    
    <div class="clear"></div>
</div> <!-- END div id="parent_Sect" -->
<div class="clear"></div>

