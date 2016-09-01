<style type="text/css">
	.newstatus{ background-color: #93c0d6;
    color: #fff;
    float: left;
    font-size: 12px;
    font-weight: bold;
    margin-right: 5px;
    padding: 5px 10px;}
					
	.loading_app{ background-image:url(images/loading_app.gif);
		height:30px;
		float:left;
		width:30px;
		margin-left:10px;
		display:none}
		
</style>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Student Attentances')=>array('/courses'),
	Yii::t('app','Create'),
);
?>
 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog'.$model->id,
                'options'=>array(
                    'title'=>Yii::t('app','Student Approval'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500',
                    'height'=>'auto',
                ),
                ));
				?>
<div style="padding:10px 20px 10px 20px; overflow:hidden">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-approval-form',
	//'enableAjaxValidation'=>true,
	)); ?>
    <div class="formCon">	
		<div class="formConInner" style="width:100%; height:auto;">
			
            <?php echo $form->errorSummary($model); ?>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if(FormFields::model()->isVisible("fullname", "Students", "forOnlineRegistration"))
                { ?>
            	<tr>
                    
                    <td><strong><?php echo Yii::t('app','Full Name'); ?></strong></td>
                    <td style="padding-left:8px;">
                   	<?php 
                        if(FormFields::model()->isVisible("fullname", "Students", "forOnlineRegistration"))
                        {
                               $name='';
                               $name=  $model->studentFullName('forOnlineRegistration');
                        }
                        echo $name;
                        //echo $model->first_name.' '.$model->middle_name.' '.$model->last_name;?>
                    </td>
				</tr>
                <?php } ?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr> 
                <tr>
                    <td><strong><?php echo Yii::t('app','Registration ID'); ?></strong></td>
                    <td style="padding-left:8px;">
                   	<?php echo $model->registration_id;?>
                    </td>
				</tr>
                <?php if(FormFields::model()->isVisible('date_of_birth','Students','forOnlineRegistration')){ ?>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr> 
                
                    <tr>
                        <td><strong><?php echo Yii::t('app','Date of Birth'); ?></strong></td>
                        <td style="padding-left:8px;">
                        <?php
                        $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                        if($settings!=NULL)
                        {	
                            $dob = date($settings->displaydate,strtotime($model->date_of_birth));
                        }
                        else
                        {
                            $dob = $model->date_of_birth;
                        }
                        echo $dob;
                        ?>
                        </td>
                    </tr>
                <?php } ?>    
               
                <?php /*?><?php
                $if_year = StudentCalculatedYear::model()->findAll();
				if(count($if_year)>0)
				{
				?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr> 
                <tr>
                    <td><strong><?php echo Yii::t('registration','Calculated Year'); ?></strong></td>
                    <td style="padding-left:8px;">
                    <?php
					
					$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
					if(Yii::app()->user->year)
					{
						$yr = Yii::app()->user->year;
						
					}
					else
					{
						$yr = $current_academic_yr->config_value;
					}
					
					$start_year = AcademicYears::model()->findByAttributes(array('id'=>$yr));
					$start_year = date('Y',strtotime($start_year->start));
					
					$from = new DateTime($model->date_of_birth);
					$cut_off = $start_year.'-6-30';
					$to = new DateTime($cut_off);
					$age = $from->diff($to)->y;
					$criteria = new CDbCriteria;
					//$criteria->condition='(:age BETWEEN max_age AND min_age)';
					$criteria->condition= 'min_age <= :age and max_age >= :age';
					$criteria->params = array(':age'=>$age);
					$year = StudentCalculatedYear::model()->find($criteria);
					
					if($year)
					{
						echo $year->year;
					}
					else
					{
						echo 'Not Eligible';
					}					
					?>
                    </td>
				</tr>
                <?php
				}
				?><?php */?>
                
               <?php /*?> <tr>
                    <td><strong><?php echo Yii::t('registration','Course'); ?></strong></td>
                    <td style="padding-left:8px;">
                   	<?php 
						$course = Courses::model()->findByAttributes(array('id'=>$model->course_id));						 
						 
						if($course)
						{
							echo $course->course_name; 
						}
						else
						{
							echo '-';
						}
					?>
                    </td>
				</tr><?php */?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>  
                
                <?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration'))
                { ?>
            	<tr>
                    <td><strong><?php echo Yii::app()->getModule("students")->labelCourseBatch(); ?></strong></td>
                    <td style="padding-left:8px;">
                    <?php					
					$current_academic_yr = OnlineRegisterSettings::model()->findByPk(2);   
                        	$batches = Batches::model()->findAll("is_deleted=:x AND academic_yr_id=:y AND is_active=:z", array(':x'=>'0',':y'=>$current_academic_yr->config_value,':z'=>1));
                        	$data = array();
                        	foreach ($batches as $batch)
                        	{                            
                            	$data[$batch->id] = $batch->course123->course_name.' / '.$batch->name;
                        	}
                        ?>
							
							<?php 
							if(isset($model->batch_id) and $model->batch_id!=NULL and $model->batch_id!=0)
							{
								echo CHtml::dropdownlist('batch', '', $data, array('id'=>'batch-'.microtime(),'empty'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),'options' => array($_REQUEST['bid']=>array('selected'=>true)),));
							}
							else
							{
								echo CHtml::dropdownlist('batch', '', $data, array('id'=>'batch-'.microtime(),'empty'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")));
							}
								
					?>
                    </td>
                    <td></td>
                </tr><?php } ?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <?php /*?><tr>
                	<td colspan="2">
                    <div class="newstatus"></div>                    
                    </td>
                </tr><?php */?> 
                            
            </table>
        </div> <!-- END div class="formConInner" -->
    </div> <!-- END div class="formCon" -->
    <?php
	$registered_guardian = Guardians::model()->findByAttributes(array('id'=>$model->parent_id));
	$criteria=new CDbCriteria;
	$criteria->join = 'JOIN guardian_list t2 ON t.id = t2.guardian_id JOIN students t1 ON t1.id = t2.student_id'; 	
	$criteria->condition = 't1.type=:type and t.email=:email';
	$criteria->params = array(':type'=>0,':email'=>$registered_guardian->email);
	$existing_guardian = Guardians::model()->find($criteria);	
	//$existing_guardian = Guardians::model()->findByAttributes(array('email'=>$registered_guardian->email));
	
	if($existing_guardian)
	{
		$siblings = Students::model()->findAllByAttributes(array('parent_id'=>$existing_guardian->id,'type'=>0));
	?>
    <?php echo Yii::t('app','Guardian already exists in the database').'.'.Yii::t('app','Guardian can login using their existing account').'.'; ?>
    <div class="formCon">	
		<div class="formConInner">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if(FormFields::model()->isVisible("fullname", "Guardians", "forOnlineRegistration"))
                { ?>    
                <tr>
                    <td><strong><?php echo Yii::t('app','Guardian Name'); ?></strong></td>
                    <td style="padding-left:8px;">
                    <?php 
                    $gname='';
                    $gname= $existing_guardian->parentFullName('forOnlineRegistration');                    
                    echo CHtml::link($gname, array('/students/guardians/view', 'id'=>$existing_guardian->id),array('target'=>'_blank','style'=>'color:#f60 !important'));
                            //echo CHtml::link(ucfirst($existing_guardian->first_name).' '.ucfirst($existing_guardian->last_name), array('/students/guardians/view', 'id'=>$existing_guardian->id),array('target'=>'_blank','style'=>'color:#f60 !important'));
                    ?>
                    </td>
                </tr><?php } ?>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr> 
                <tr>
                    <td><strong><?php echo Yii::t('app','Guardian Email'); ?></strong></td>
                    <td style="padding-left:8px;"><?php echo $existing_guardian->email; ?></td>
				</tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <?php
				if($siblings)
				{
				?> 
                <tr>
                    <td><strong><?php echo Yii::t('app','Siblings'); ?></strong></td>
                    <td style="padding-left:8px;">
                    	<?php
						foreach($siblings as $sibling)
						{
                                                    if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                    {
                                                        $sname='';
                                                        $sname=  $sibling->studentFullName('forStudentProfile');
							echo CHtml::link($sname, array('/students/students/view', 'id'=>$sibling->id),array('target'=>'_blank','style'=>'color:#f60 !important')).'<br/>';
                                                    }
						}
						?>
					</td>
				</tr>
                <?php
				}
				?>
			</table>                
        </div>
	</div>
    <?php
	} elseif($registered_guardian) {		
	?>
    <div class="formCon">	
		<div class="formConInner">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><strong><?php echo Yii::t('app','Guardian Name'); ?></strong></td>
                    <td style="padding-left:8px;">
						<?php 
							echo CHtml::link(ucfirst($registered_guardian->first_name).' '.ucfirst($registered_guardian->last_name), array('/onlineadmission/admin/view', 'id'=>$model->id),array('target'=>'_blank','style'=>'color:#f60 !important'));
						?>
                    </td>
				</tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr> 
                <tr>
                    <td><strong><?php echo Yii::t('app','Guardian Email'); ?></strong></td>
                    <td style="padding-left:8px;"><?php echo $registered_guardian->email; ?></td>
				</tr>
                
			</table>                
        </div>
	</div>
    
    <?php
	}
	?>
    <div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>
    <div class="row buttons">
    <div style="float:left">
	 <?php echo CHtml::ajaxSubmitButton(Yii::t('app','Approve'),CHtml::normalizeUrl(array('approve')),array('dataType'=>'json','timeout'=>'90000' ,'beforeSend' => 'function(){
            $(".loading_app").show();
        }','success'=>'js: function(data) { 
                    if (data.status == "success")
                    {
                        $("#jobDialog'.$model->id.'").dialog("close");
                        window.location.reload();
                    }
                }'),array('id'=>'closeJobDialog'.$model->id,'name'=>'approve','class'=>'gifloadimage')); ?>
                </div>
                <div class="loading_app"></div>
    </div>
    

    <?php $this->endWidget(); ?>
</div>

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
<script type="text/javascript">
/*check();
$("#batch").unbind('change');
$("#batch").change(check);
function check(){
	var batchId	= $("#batch").val();			
	$.ajax({
		type: "POST",
		url: <?php //echo CJavaScript::encode(Yii::app()->createUrl('students/registration/chechclassavailability'))?>,
		data: {'batchId':batchId},
		success: function(result){
			window.setTimeout(function(){
				$( document ).find("#newstatus").text(result);
			}, 200);			
		}
	});	
}*/
</script>

