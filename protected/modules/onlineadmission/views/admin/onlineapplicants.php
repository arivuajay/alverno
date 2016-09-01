
<style type="text/css">
.online_but {
    top: 50px;
    position: absolute;
    right: -21px;
}
.list_contner_hdng{ margin:8px;}

.max_student{ border-left: 3px solid #fff;
    margin: 0 3px;
    padding: 6px 0 6px 3px;
    word-break: break-all;}
	
.online_status{
	margin-top:0px;
	position: absolute;
    right: 181px;
    top: 50px;}

</style>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('students/index'),
	Yii::t('app','Online Applicants'),
);
?>
<script language="javascript">
function details(id)
{
	
	var rr= document.getElementById("dropwin"+id).style.display;
	
	 if(document.getElementById("dropwin"+id).style.display=="block")
	 {
		 document.getElementById("dropwin"+id).style.display="none"; 
	 }
	 if(  document.getElementById("dropwin"+id).style.display=="none")
	 {
		 document.getElementById("dropwin"+id).style.display="block"; 
	 }
	 //return false;
	

}
</script>

<script language="javascript">
function hide(id)
{	
	$(".drop").hide();
	$('#'+id).toggle();	
}
</script>

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
            	<h1><?php echo Yii::t('app','Online Registered Profiles'); ?></h1>
                
                <div class="search_btnbx">
                	<div class="contrht_bttns">
						<ul>
							<li>
                <?php echo CHtml::link('<span>'.Yii::t('app','Clear All Filters').'</span>', array('onlineapplicants')); ?>
                
                			</li>
                         </ul>
                         
                      </div>
                
                <!-- Filters Box -->
                <div class="filtercontner">
                    <div class="filterbxcntnt">
                    	<!-- Filter List -->
                        <div class="filterbxcntnt_inner" style="border-bottom:#ddd solid 1px;">
                            <ul>
                                <li style="font-size:12px"><?php echo Yii::t('app','Filter Your Students:');?></li>
                                
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                'method'=>'get',
                                )); ?>
                                
                                <!-- Name Filter -->
                                <li>
                                    <div onClick="hide('name')" style="cursor:pointer;"><?php echo Yii::t('app','Name');?></div>
                                    <div id="name" style="display:none; width:219px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="name" value="<?php echo isset($_GET['name']) ? CHtml::encode($_GET['name']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                 <!-- End Name Filter -->
                                <!-- Admission Number Filter -->
                                <li>
                                    <div onClick="hide('registrationnumber')" style="cursor:pointer;"><?php echo Yii::t('app','Application Id');?></div>
                                    <div id="registrationnumber" style="display:none;width:219px; padding-top:0px; height:33px" class="drop">
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="registrationnumber" value="<?php echo isset($_GET['registrationnumber']) ? CHtml::encode($_GET['registrationnumber']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>                                
                                <!-- End Admission Number Filter -->                                
                                <!-- Status Filter -->
                                <li>
                                <div onClick="hide('status')" style="cursor:pointer;"><?php echo Yii::t('app','Status');?></div>
                                    <div id="status" style="display:none; width:249px; min-height:33px; left:-120px; padding-top:0px;" class="drop">
                                    <div class="droparrow"  style="left:140px"></div>
                                    <?php 
                                    echo CHtml::activeDropDownList($model,'status',array('pending' => Yii::t('app','Pending'), '1' => Yii::t('app','Approved'), '-1'=> Yii::t('app','Disapproved'), '-3'=> Yii::t('app','Waiting List')),array('prompt'=>Yii::t('app','All'))); 
                                    ?>
                                    <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Status Filter -->
                                <!-- Batch Filter -->
                                <li>
                                    <div onClick="hide('batch')" style="cursor:pointer;"><?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration'))
									{
									 echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
									}?></div>
                                    <div id="batch" style="display:none; color:#000; width:518px; height:33px; padding-left:10px; padding-top:0px; left:-200px" class="drop">
                                        <div class="droparrow" style="left:210px;"></div>
                                        <?php
										/*$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
										if(Yii::app()->user->year)
										{
											$year = Yii::app()->user->year;
										}
										else
										{
											
											$year = $current_academic_yr->config_value;
										}*/
										$current_academic_yr = OnlineRegisterSettings::model()->findByPk(2);
										$is_active = PreviousYearSettings::model()->findByAttributes(array('id'=>7));
										$is_inactive = PreviousYearSettings::model()->findByAttributes(array('id'=>8));
                                        $data = CHtml::listData(Courses::model()->findAll('is_deleted=:x AND academic_yr_id=:y',array(':x'=>'0',':y'=>$current_academic_yr->config_value),array('order'=>'course_name DESC')),'id','course_name');
                                        echo Yii::t('app','Course');
                                        echo CHtml::dropDownList('cid','',$data,
                                        array('prompt'=>Yii::t('app','Select'),
                                        'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('Students/batch'),
                                        'update'=>'#batch_id',
                                        'data'=>'js:$(this).serialize()'
                                        ))); 
                                        echo '&nbsp;&nbsp;&nbsp;';
                                        echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
                                        $data1 = CHtml::listData(Batches::model()->findAll('is_active=:x AND is_deleted=:y AND academic_yr_id=:z',array(':x'=>'1',':y'=>0,':z'=>$current_academic_yr->config_value),array('order'=>'name DESC')),'id','name');
                                        echo CHtml::activeDropDownList($model,'batch_id',$data1,array('prompt'=> Yii::t('app','Select'),'id'=>'batch_id')); ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Batch Filter -->
                                 <?php $this->endWidget(); ?>
                             </ul>
                          </div>
                     </div>
                   </div><!-- Filter Box Ends --> 
                   
                   <!-- END Filter Box -->
                <div class="clear"></div>
                
                <!-- Alphabetic Sort -->
                    <div class="list_contner_hdng">
                    <div class="letterNavCon" id="letterNavCon">
                        <ul>
                        <?php 
						if((isset($_REQUEST['val']) and $_REQUEST['val']==NULL) or (!isset($_REQUEST['val'])))
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php echo CHtml::link('All', Yii::app()->request->getUrl().'&val=',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='A')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php echo CHtml::link('A', Yii::app()->request->getUrl().'&val=A',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='B')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('B', Yii::app()->request->getUrl().'&val=B',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='C')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('C', Yii::app()->request->getUrl().'&val=C',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='D')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('D', Yii::app()->request->getUrl().'&val=D',array('class'=>'vtip')); ?>                            
                        </li>
                        
						
						<?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='E')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('E', Yii::app()->request->getUrl().'&val=E',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='F')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        <?php  echo CHtml::link('F', Yii::app()->request->getUrl().'&val=F',array('class'=>'vtip')); ?>                            
                        
                        </li>
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='G')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('G', Yii::app()->request->getUrl().'&val=G',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='H')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('H', Yii::app()->request->getUrl().'&val=H',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='I')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        
                        	<?php  echo CHtml::link('I', Yii::app()->request->getUrl().'&val=I',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='J')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('J', Yii::app()->request->getUrl().'&val=J',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='K')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('K', Yii::app()->request->getUrl().'&val=K',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='L')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('L', Yii::app()->request->getUrl().'&val=L',array('class'=>'vtip')); ?>                            
                        </li>
                        
						<?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='M')
                        {
                        	echo '<li class="ln_active">';
                        }                        
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('M', Yii::app()->request->getUrl().'&val=M',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='N')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('N', Yii::app()->request->getUrl().'&val=N',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='O')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('O', Yii::app()->request->getUrl().'&val=O',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='P')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('P', Yii::app()->request->getUrl().'&val=P',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Q')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Q', Yii::app()->request->getUrl().'&val=Q',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='R')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('R', Yii::app()->request->getUrl().'&val=R',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='S')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('S', Yii::app()->request->getUrl().'&val=S',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='T')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('T', Yii::app()->request->getUrl().'&val=T',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='U')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('U', Yii::app()->request->getUrl().'&val=U',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='V')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('V', Yii::app()->request->getUrl().'&val=V',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='W')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('W', Yii::app()->request->getUrl().'&val=W',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='X')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('X', Yii::app()->request->getUrl().'&val=X',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Y')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Y', Yii::app()->request->getUrl().'&val=Y',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Z')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Z', Yii::app()->request->getUrl().'&val=Z',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        </ul>
                        
                    	<div class="clear"></div>
                    </div><!-- END div class="letterNavCon" -->
                </div> <!-- END div class="list_contner_hdng" -->
                <!-- END Alphabetic Sort --> 
                <br />
                
                
                
                	<?php
					Yii::app()->clientScript->registerScript(
					'myHideEffect',
					'$(".flashMessage").animate({opacity: 1.0}, 3000).fadeOut("slow");',
					CClientScript::POS_READY
					);
					?>
                	<?php
					/* Success Message */
					if(Yii::app()->user->hasFlash('successMessage')): 
					?>
						<div class="flashMessage" style="background:#FFF; color:#C00; padding-left:200px; font-size:16px">
						<?php echo Yii::app()->user->getFlash('successMessage'); ?>
						</div>
					<?php endif;
					 /* End Success Message */
					?>
                
                    <div class="a_feed_cntnr" id="a_feed_cntnr">
                    
                    	<?php 
						
						if($students)
						{
							//Display the selected academic yr
							$selected_academic_yr = OnlineRegisterSettings::model()->findByAttributes(array('id'=>2));
								if($selected_academic_yr->config_value != NULL){
									$yr_name = AcademicYears::model()->findByAttributes(array('id'=>$selected_academic_yr->config_value));
									if($yr_name){
							?>
										<center><div class="online_academic_yr"><?php echo Yii::t('app','Academic Year').' - '.ucfirst($yr_name->name); ?></div></center>
							<?php
									}
								}
							foreach($students as $student)
							{
							?>
							<div class="individual_feed">
								<div class="a_feed_online">
									<?php
									if($student->gender == 'M')
									{
										$gender_class = "a_boy";
									}
									else
									{
										$gender_class = "a_girl";
									}
									?>
									<div class=<?php echo $gender_class; ?>></div>
									<div class="a_feed_innercntnt">
										<div class="a_feed_inner_arrow"></div>
											<h1><strong>                                            	
												<?php
													if(FormFields::model()->isVisible("fullname", "Students", "forOnlineRegistration")){
														if($student->studentFullName('forOnlineRegistration')!=''){
															$std_name = $student->studentFullName('forOnlineRegistration');
														}else{
															echo '-';
														}
													}else{
														$std_name = '-';
													}
													echo CHtml::link($std_name, array('view', 'id'=>$student->id)); 
												?>
                                                </strong></h1>
											
											<div  class="online_time">
												<?php
												$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
												if($settings!=NULL)
												{	
													$student->registration_date = date($settings->displaydate,strtotime($student->registration_date));
													$timezone = Timezone::model()->findByAttributes(array('id'=>$settings->timezone));
													date_default_timezone_set($timezone->timezone);
													$time = date($settings->timeformat,strtotime($student->created_at));		
						
												}
												
												?>
												<p style="float:right;"><?php echo Yii::t('app','at'); ?> <strong><?php echo $time; ?></strong>  - <strong><?php echo $student->registration_date; ?></strong></p>
												<br />
												<?php
												// Setting class for status label
												$status_data = '';
												if($student->status == -1)
												{
													$status_class = 'tag_disapproved';
													$status_data = Yii::t('app','Disapproved');
												}
												elseif($student->status == 0)
												{
													$status_class = 'tag_pending';
													$status_data = Yii::t('app','Pending');
												}
												elseif($student->status == 1)
												{
													$status_class = 'tag_approved';
													$status_data = Yii::t('app','Approved');
												}
												elseif($student->status == -3)
												{
													$status_class = 'tag_waiting';
													$status_data = Yii::t('app','Waiting List');
												}
												?>
												<div class="online_status" ><div class="<?php echo $status_class; ?>"><?php echo $status_data; ?></div></div>
											</div> <!-- END div  class="online_time" -->
											<table class="reg_bx" width="100%" border="0" cellspacing="0" cellpadding="0">
												<?php /*?><tr>
													<td width="8%"><p><?php echo Yii::t('registration','Course'); ?></p></td>
													<td width="3%">:</td>
													<td>
														<?php
														$course = Courses::model()->findByAttributes(array('id'=>$student->course_id));
														echo ucfirst($course->course_name);														
														?>
													</td>
												</tr><?php */?>
                                                <tr>
													<td width="15%"><p><?php echo Yii::t('app','App ID'); ?></p></td>
													<td>:</td>
													<td><?php echo $student->registration_id; ?></td>
												</tr>
												<tr>
													<td><p><?php echo Yii::t('app','Email'); ?></p></td>
													<td>:</td>
													<td><?php echo $student->email; ?></td>
												</tr>
                                                <?php if(FormFields::model()->isVisible('phone1','Students','forOnlineRegistration')){ ?>
												<tr>
													<td><p><?php echo Yii::t('app','Phone'); ?></p></td>
													<td>:</td>
													<td><?php echo $student->phone1;?>
                                              </td>
												</tr>
                                                <?php } ?>
                                            <?php if($student->status != 1 and $student->batch_id and FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')) { ?>    
                                                <tr>
                                                	<td><p><?php echo Yii::app()->getModule("students")->labelCourseBatch(); ?></p></td>
                                                    <td>:</td>
													<?php 
													
                                                    	$batc = Batches::model()->findByAttributes(array('id'=>$student->batch_id)); 
													
                                                    if($batc!=NULL)
                                                    {
                                                        $cours = Courses::model()->findByAttributes(array('id'=>$batc->course_id)); ?>
                                                        <td><?php echo $cours->course_name.' / '.$batc->name; ?></td> 
                                                    
                                                    <?php 
                                                    }
                                                    ?>                                                                                                
                                                </tr>
                                            <?php } ?>    
											</table>
											
											<div class="online_but">
												<ul class="tt-wrapper">
													<li>
													<?php
													if($student->status == 1)
													{ 
														echo CHtml::link('<span>'.Yii::t('app','Approved').'</span>', array('#'),array('class'=>'tt-approved-disabled','onclick'=>'return false;'));
													}
													else
													{
														/*echo CHtml::ajaxLink('ll',$this->createUrl('approve'),array(
																'onclick'=>'$("#jobDialog'.$student->id.'").dialog("open"); return false;',
																'update'=>'#jobDialog123-student','complete'=>'function(){check('.$student->id.');}','type' =>'GET','data'=>array('id' =>$student->id),),array('id'=>'showJobDialog'.$student->id,'class'=>'tt-approved'));*/
																
														echo CHtml::ajaxLink('<span>'.Yii::t('app','Approve').'</span>',$this->createUrl('admin/approve'),array(
															'onclick'=>'$("#jobDialog'.$student->id.'").dialog("open"); return false;',
															'update'=>'#jobDialog123'.$student->id,'type' =>'GET','data'=>array('id' =>$student->id,'bid' => $student->batch_id),),array('id'=>'showJobDialog'.$student->id,'class'=>'tt-approved'));
																
													}
													?>
													</li>
                                                    <?php
													if($student->status != 1 and $student->status != -3)
													{
													?>
                                                        <li>
                                                        <?php 
                                                        if($student->status == -1)
                                                        {
                                                            
                                                            echo CHtml::link('<span>'.Yii::t('app','Disapproved').'</span>', array('#'),array('class'=>'tt-disapproved-disabled','onclick'=>'return false;')); 
                                                        }
                                                        else
                                                        {																												
                                                            echo CHtml::link('<span>'.Yii::t('app','Disapprove').'</span>', array('disapprove','id'=>$student->id,'flag'=>1),array('class'=>'tt-disapproved','confirm'=>Yii::t('app','Are you sure you want to disapprove this?'))); 
                                                        }
                                                        
                                                        ?>
                                                        </li>
                                                    <?php 
														}
													?>
                                                    <?php if($student->status != 1){ ?>
                                                        <li>
                                                            <?php echo CHtml::link('<span>'.Yii::t('app','Delete').'</span>', array('delete','id'=>$student->id,'flag'=>1),array('class'=>'tt-delete','confirm'=>Yii::t('app','Are you sure you want to delete this?'))); ?>
                                                        </li>
													<?php } ?>                                                    
                                                    <?php 
														if($student->status==0)
														{
													?>
                                                    <li>
                                                    	<?php echo CHtml::link('<span>'.Yii::t('app','Waiting List').'</span>', array('WaitinglistStudents/create','id'=>$student->id),array('class'=>'tt-waiting',)); ?>
                                                    </li>
                                                    <?php
														}
													?>
													<!--<li><a href="#" class="tt-download"><span>Download</span></a></li>-->
												</ul>
											</div> <!-- END div class="online_but" -->
								</div> <!-- END div class="a_feed_innercntnt" -->
								</div> <!-- END div class="a_feed_online" -->
							</div> <!-- END div class="individual_feed" -->
							<div  id="<?php echo 'jobDialog123'.$student->id;?>"></div>
							<?php
							}
							?>
                       <div class="pagecon" style="height:17px;">
							<?php     							                                 
                              $this->widget('CLinkPager', array(
                              'currentPage'=>$pages->getCurrentPage(),
                              'itemCount'=>$item_count,
                              'pageSize'=>10,
                              'maxButtonCount'=>5,
                              //'nextPageLabel'=>'My text >',
                              'header'=>'',
                            'htmlOptions'=>array('class'=>'pages',"style"=>"margin:0px;"),
                            ));?>
                        </div>                           
                            
                            
                            <div id="jobDialog123-student"></div>
                            <?php
						}
						else
						{
						?>
                        	<div>
                                <div class="yellow_bx" style="background-image:none;width:600px;padding-bottom:45px;">
                                    <div class="y_bx_head" style="width:580px;">
                                    <?php 
                                        echo Yii::t('app','No Online Applicants');
                                    ?>
                                    </div>
                                   
                                </div>
                            </div>
                        <?php
						}
						?>                    
                    </div> <!-- END div class="a_feed_cntnr" -->            
                            
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>            
<?php /*?><script type="text/javascript">
function check(studentId){
	$("[name=batch]").unbind('change');
	$("[name=batch]").change(function(){
		var batchId	= $(this).val();
		$.ajax({
			type: "POST",
			url: <?php echo CJavaScript::encode(Yii::app()->createUrl('students/registration/chechclassavailability'))?>,
			data: {'batchId':batchId},
			success: function(result){
				 if(result!='nil')
				 {
					$(".newstatus:last-child").show();
					var finalResult = result.split("+");
					$(".newstatus:last-child").text(finalResult[0]);					
					$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[1]+"</span>");
					$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[2]+"</span>");
				 }
				 else
				 {
					 $(".newstatus:last-child").hide();
				 }
				
			}
		});	
	});
	checkclassavailability(studentId);	
}

function checkclassavailability(studentId){
	var batchId	= $("[name=batch]:last").val();
	
	$.ajax({
		type: "POST",
		url: <?php echo CJavaScript::encode(Yii::app()->createUrl('students/registration/chechclassavailability'))?>,
		data: {'batchId':batchId},
		success: function(result){
			 if(result!='nil')
			 {
				$(".newstatus:last-child").show();
				var finalResult = result.split("+");
				$(".newstatus:last-child").text(finalResult[0]);					
				$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[1]+"</span>");
				$(".newstatus:last-child").append("<span class='max_student'>"+finalResult[2]+"</span>");
			 }
			 else
			 {
				 $(".newstatus:last-child").hide();
			 }
		}
	});	
}
</script><?php */?>
<script>
$('body').click(function() {
	$('#osload').hide();
	$('#name').hide();
	$('#registrationnumber').hide();		
	$('#status').hide();
	$('#batch').hide();
 
});

$('.filterbxcntnt_inner').click(function(event){
   event.stopPropagation();
});

$('.load_filter').click(function(event){
   event.stopPropagation();
});
</script>   