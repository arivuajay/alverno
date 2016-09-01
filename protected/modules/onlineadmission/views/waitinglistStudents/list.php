<style type="text/css">
.max_student{ border-left: 3px solid #fff;
    margin: 0 3px;
    padding: 6px 0 6px 3px;
    word-break: break-all;}
</style>
<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('students/index'),
	Yii::t('app','Waiting List Students'),
);?>
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
            	<h1><?php echo Yii::t('app','Manage Waiting List'); ?></h1>
                
                <div class="search_btnbx">
                	<div class="contrht_bttns">
						<ul>
							<li>
                 <?php echo CHtml::link('<span>'.Yii::t('app','Clear All Filters').'</span>', array('list')); ?>
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
                                    <div id="name" style="display:none; width:204px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="name" value="<?php echo isset($_GET['name']) ? CHtml::encode($_GET['name']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                 <!-- End Name Filter -->
                                <!-- Admission Number Filter -->
                                <li>
                                    <div onClick="hide('priority')" style="cursor:pointer;"><?php echo Yii::t('app','Priority');?></div>
                                    <div id="priority" style="display:none;width:204px; padding-top:0px; height:33px" class="drop">
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="priority" value="<?php echo isset($_GET['priority']) ? CHtml::encode($_GET['priority']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Admission Number Filter --> 
                                <!-- Batch Filter -->
                                <li>
                                    <div onClick="hide('batch')" style="cursor:pointer;"><?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')){
										echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
									}?></div>
                                    <div id="batch" style="display:none; color:#000; width:518px; height:33px; padding-left:10px; padding-top:0px; left:-200px" class="drop">
                                        <div class="droparrow" style="left:210px;"></div>
                                        <?php
										$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
										if(Yii::app()->user->year)
										{
											$year = Yii::app()->user->year;
										}
										else
										{
											
											$year = $current_academic_yr->config_value;
										}
										$is_active = PreviousYearSettings::model()->findByAttributes(array('id'=>7));
										$is_inactive = PreviousYearSettings::model()->findByAttributes(array('id'=>8));
                                        $data = CHtml::listData(Courses::model()->findAll('is_deleted=:x AND academic_yr_id=:y',array(':x'=>'0',':y'=>$year),array('order'=>'course_name DESC')),'id','course_name');
                                        echo Yii::t('app','Course');
                                        echo CHtml::dropDownList('cid','',$data,
                                        array('prompt'=>Yii::t('app','Select'),
                                        'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('WaitinglistStudents/batch'),
                                        'update'=>'#batch_id',
                                        'data'=>'js:$(this).serialize()'
                                        ))); 
                                        echo '&nbsp;&nbsp;&nbsp;';
                                        echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
                                        $data1 = CHtml::listData(Batches::model()->findAll('is_active=:x AND is_deleted=:y AND academic_yr_id=:z',array(':x'=>'1',':y'=>0,':z'=>$year),array('order'=>'name DESC')),'id','name');
                                        echo CHtml::activeDropDownList($model,'batch_id',$data1,array('prompt'=>Yii::t('app','Select'),'id'=>'batch_id')); ?>
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
			<div class="tableinnerlist">
            	<?php if($waitingListStudents!=NULL)
					{
				?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr> 
                        	<?php
								if(FormFields::model()->isVisible("fullname", "Students", "forOnlineRegistration")){						
							?>                       	
                            	<th width="25%"><?php echo Yii::t('app','Name');?></th>
                            <?php } ?>
                            <?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')){?>    
                            	<th width="25%"><?php echo Yii::app()->getModule("students")->labelCourseBatch();?></th>
                            <?php } ?>    
                            <th width="15%"><?php echo Yii::t('app','Priority');?></th>   
                            
                            <th width="45%" colspan="3"><?php echo Yii::t('app','Actions');?></th>
                                                               
                        </tr>                         
					<?php 					
                        foreach($waitingListStudents as $list)
                        {
							$studentslist = Students::model()->FindByAttributes(array('id'=>$list->student_id));
							$batch = Batches::model()->FindByAttributes(array('id'=>$list->batch_id));	
                    ?>		
                        <tr>
                        	<?php
								if(FormFields::model()->isVisible("fullname", "Students", "forOnlineRegistration")){						
							?>
                        		<td><?php echo CHtml::link($studentslist->studentFullName('forOnlineRegistration'), array('//onlineadmission/admin/view', 'id'=>$studentslist->id)); ?></td>
                            <?php } ?>    
                        	<?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')){?>  
                            	<td><?php echo $batch->course123->course_name.' / '.$batch->name; ?></td>
                            <?php } ?>    
                            <td><?php echo $list->priority; ?></td>
                            <td><?php echo CHtml::link(Yii::t('app','Edit'), array('waitinglistStudents/manage','id'=>$list->student_id)).' | '.CHtml::link(Yii::t('app','Delete'), array('waitinglistStudents/delete','id'=>$list->student_id),array('class'=>'tt-delete','confirm'=>Yii::t('app','Are you sure you want to delete this?'))); ?></td>
                            <td><?php echo CHtml::ajaxLink('<span>'.Yii::t('app','Approve').'</span>',$this->createUrl('admin/approve'),array(
															'onclick'=>'$("#jobDialog'.$studentslist->id.'").dialog("open"); return false;',
															'update'=>'#jobDialog123'.$studentslist->id,'type' =>'GET','data'=>array('id' =>$studentslist->id,'bid'=>$list->batch_id),),array('id'=>'showJobDialog'.$studentslist->id,'class'=>'tt-approved'));
														 ;?></td>
                         <?php /*?><td><?php echo CHtml::link(Yii::t('registration','Make Pending'), array('waitinglistStudents/makepending','id'=>$list->student_id)); ?></td><?php */?>
                        </tr>
                       <div  id="<?php echo 'jobDialog123'.$studentslist->id;?>"></div> 
                    <?php
						}
					?>                                  
					</table>
                   <?php 
                    } 
					else
					{					   
                    ?>	
						<div>
                            <div class="yellow_bx" style="background-image:none;width:600px;padding-bottom:45px;">
                                <div class="y_bx_head" style="width:580px;">
                                <?php 
                                    echo Yii::t('app','Nothing Found!!');
                                ?>
                                </div>
                               
                            </div>
                        </div>
                                             
                   <?php  }  ?>  
                    </div>
                    
				     <div class="pagecon">
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
		</div>	
        </td>
     </tr>
</table>  
<script type="text/javascript">
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
</script>
<script>
$('body').click(function() {
	$('#osload').hide();
	$('#name').hide();
	$('#priority').hide();
	$('#batch').hide();	
	
});

$('.filterbxcntnt_inner').click(function(event){
   event.stopPropagation();
});

$('.load_filter').click(function(event){
   event.stopPropagation();
});
</script>                         