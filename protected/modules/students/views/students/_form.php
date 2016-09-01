<style type="text/css">
.formCon input[type="text"], input[type="password"], textArea, select {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 175px !important;
}

.select-style select{ width:135% !important}

.formCon select{background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 78% !important;}
	
	.formCon input[type="text"] {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #C2CFD8;
    border-radius: 2px;
    box-shadow: -1px 1px 2px #D5DBE0 inset;
    padding: 6px 3px;
    width: 175px !important;
}


</style>


<div class="captionWrapper">
    <ul>
        <li><h2 class="cur"><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Details'),array('students/update','id'=>$_REQUEST['id'],'status'=>0)); } else{ echo Yii::t('app','Student Details'); } ?></h2></li>
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Parent Details'),array('guardians/create','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Parent Details'); } ?></h2></li>
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Emergency Contact'),array('guardians/addguardian','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Emergency Contact'); } ?></h2></li>
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Previous Details'),array('studentPreviousDatas/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Previous Details'); }?></h2></li>
        <li><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Documents'),array('studentDocument/create','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Student Documents'); }?></h2></li>
        <li class="last"><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Profile'),array('students/view','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Student Profile'); } ?></h2></li>
    </ul>
</div>
<?php 
if(Yii::app()->controller->action->id=='create') 
{
	$config=Configurations::model()->findByPk(7);
	$adm_no='';
	$adm_no_1 = '';
	if($config->config_value==1)
	{
		$adm_no = Yii::app()->db->createCommand()
				  ->select("MAX(CAST(admission_no AS UNSIGNED)) as `max_adm_no`")
				  ->from('students')				  
				  ->queryRow();
		//var_dump($adm_no);exit;
		//$criteria	= new CDbCriteria;
		//$criteria->select	= "MAX(admission_no) as `max_adm_no`";
		//$adm_no		= Students::model()->find($criteria);
		
		if($adm_no!=NULL){
			$adm_no_1	= $adm_no['max_adm_no'] + 1;
		}
		else{
			$adm_no_1	= 1;
		}
	}
	?>
	
<?php  
}
else
{
	//echo '<br><br>';
	$adm_no	= Students::model()->findByAttributes(array('id' => $_REQUEST['id']));
	$adm_no_1 = $adm_no->admission_no;
}

?>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'students-form',
'enableAjaxValidation'=>false,
'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<?php 
	if($form->errorSummary($model)){
	?>
        <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
        	<span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
        </div>
    <?php 
	}
	?>
    <p class="note"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>
    <div class="formCon" style="background:url(images/yellow-pattern.png); width:100%; border:0px #fac94a solid; color:#000; ">
        <div class="formConInner"  style="padding:5px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right"><?php echo $form->labelEx($model,'admission_no'); ?></td>
                    <td style="padding-left:8px;">
                   <?php  if($config->config_value==1)
	                {
						
						echo $form->textField($model,'admission_no',array('size'=>20,'maxlength'=>255,'value'=>$adm_no_1, 'readonly'=>'readonly')); 
                        echo $form->hiddenField($model,'admission_no',array('value'=>$adm_no_1)); 
						
					}
					else
					{
						
						echo $form->textField($model,'admission_no',array('size'=>20,'maxlength'=>255)); 
						
					}?>
                        <?php echo $form->error($model,'admission_no'); ?>
                    </td>
                    <!--<td><input name="" type="checkbox"  value="" /></td>
                    <td><input name="" type="text" style="width:40px;" /></td>-->
                    <td align="right"><?php echo $form->labelEx($model,'admission_date'); ?></td>
                    <td style="padding-left:8px;">
						<?php 
						
						//echo $form->textField($model,'admission_date');
                        $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                        if($settings!=NULL)
                        {
                            $date=$settings->dateformat;
                        }
                        else
                            $date = 'dd-mm-yy';

                        //set default date
                        if(!(isset($model->admission_date)))
                        {
                            $model->admission_date= date("j M Y");
                        }
                        
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        //'name'=>'Students[admission_date]',
                        'model'=>$model,
                        'attribute'=>'admission_date',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>$date,
                        'changeMonth'=> true,
                        'changeYear'=>true,
                        'yearRange'=>'1900:'.(date('Y')+5)
                        ),
                        'htmlOptions'=>array(
                        'style'=>'height:16px;',
						'readonly'=>true
                        ),
                        ));
                        ?>
                        <?php echo $form->error($model,'admission_date'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="formCon">
        <div class="formConInner">
            
            <h3><?php echo Yii::t('app','Personal Details'); ?> </h3>            
            <?php if(FormFields::model()->isVisible('first_name','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'first_name'); ?>
				<?php echo $form->textField($model,'first_name',array('size'=>30,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'first_name'); ?>
			</div>
            <?php } ?>

            <?php if(FormFields::model()->isVisible('middle_name','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'middle_name'); ?>
				<?php echo $form->textField($model,'middle_name',array('size'=>10,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'middle_name'); ?>
			</div>
			<?php } ?>
            
            <?php if(FormFields::model()->isVisible('last_name','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'last_name'); ?>
				<?php echo $form->textField($model,'last_name',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'last_name'); ?>
			</div>
			<?php } ?>
            <?php if(FormFields::model()->isVisible('national_student_id','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'national_student_id'); ?>
				<?php echo $form->textField($model,'national_student_id',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'national_student_id'); ?>
			</div>
			<?php } ?>
            
            <?php if(FormFields::model()->isVisible('batch_id','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'batch_id'); ?>
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
                    	$models = Batches::model()->findAll("is_deleted=:x AND is_active=:y AND academic_yr_id=:z", array(':x'=>0,':y'=>1,':z'=>$year));
                        $data = array();
                        foreach ($models as $model_1)
                        {
                            //$posts=Batches::model()->findByPk($model_1->id);
                            $data[$model_1->id] = $model_1->course123->course_name.'-'.$model_1->name;
                        }
                        ?>
                        
                        <?php 
						
                        if(isset($_REQUEST['bid']) and $_REQUEST['bid']!=NULL)
                        {
                            echo $form->dropDownList($model,'batch_id',$data,array('options' => array($_REQUEST['bid']=>array('selected'=>true)),
                            'style'=>'width:170px;','empty'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")
                            )); 
                        }
                        else
                        {
                            echo $form->dropDownList($model,'batch_id',$data,array(
                            'style'=>'width:130px ;','empty'=>Yii::t('app','Select').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")
                            )); 
                        }
                        ?>
                       
                        <?php echo $form->error($model,'batch_id'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('date_of_birth','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'date_of_birth'); ?>
				<?php //echo $form->textField($model,'date_of_birth');
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        //'name'=>'Students[date_of_birth]',
                        'attribute'=>'date_of_birth',
                        'model'=>$model,
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>$date,
                        'changeMonth'=> true,
                        'changeYear'=>true,
                        'yearRange'=>'1900:'
                        ),
                        'htmlOptions'=>array(
                        'style'=>'width:92px;',
						'readonly'=>true,
                        ),
                        ));
                        ?>
                        <?php echo $form->error($model,'date_of_birth'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('gender','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'gender'); ?>
				<?php //echo $form->textField($model,'gender',array('size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->dropDownList($model,'gender',array('M' => Yii::t('app','Male'), 'F' => Yii::t('app','Female')),array('empty' => Yii::t('app','Select Gender'))); ?>
                        <?php echo $form->error($model,'gender'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('blood_group','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'blood_group'); ?>
				<?php //echo $form->textField($model,'blood_group',array('size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->dropDownList($model,'blood_group',
                        array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'),
                        array('empty' => Yii::t('app','Unknown'))); ?>
                        <?php echo $form->error($model,'blood_group'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('birth_place','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'birth_place'); ?>
				<?php echo $form->textField($model,'birth_place',array('size'=>10,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'birth_place'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('nationality_id','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'nationality_id'); ?>
				<?php //echo $form->textField($model,'nationality_id'); ?>
                        <?php echo $form->dropDownList($model,'nationality_id',CHtml::listData(Nationality::model()->findAll(),'id','name'),array(
                        'style'=>'width:140px;','empty'=>Yii::t('app','Select Nationality')
                        )); ?>
                        <?php echo $form->error($model,'nationality_id'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('language','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'language'); ?>
				<?php echo $form->textField($model,'language',array('size'=>15,'maxlength'=>255)); ?>
                 <?php echo $form->error($model,'language'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('religion','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'religion'); ?>
				<?php echo $form->textField($model,'religion',array('size'=>10,'maxlength'=>255)); ?>
                 <?php echo $form->error($model,'religion'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('student_category_id','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'student_category_id'); ?>
                <?php echo $form->dropDownList($model,'student_category_id',CHtml::listData(StudentCategories::model()->findAll(array('order'=>'name')),'id','name'),
				array('options' => array('0'=>array('selected'=>true)),
				)); ?>
                <?php echo $form->error($model,'student_category_id'); ?>
			</div>
            <?php } ?>

            <!-- dynamic fields -->
            <?php
            $fields 	= FormFields::model()->getDynamicFields(1, 1, "forAdminRegistration");
			foreach ($fields as $key => $field) {
				if($field->form_field_type!=NULL){
					$this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
				}                                               
			}
			?>
            <!-- dynamic fields -->
            
			<div class="clear"></div>
            
        </div>
    </div>
    
    <div class="formCon" >
        <div class="formConInner">
            <h3><?php echo Yii::t('app','Contact Details'); ?></h3>

            <?php if(FormFields::model()->isVisible('address_line1','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'address_line1'); ?>
				<?php echo $form->textField($model,'address_line1',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'address_line1'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('address_line2','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'address_line2'); ?>
				<?php echo $form->textField($model,'address_line2',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'address_line2'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('city','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'city'); ?>
				<?php echo $form->textField($model,'city',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'city'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('state','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'state'); ?>
				<?php echo $form->textField($model,'state',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'state'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('pin_code','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'pin_code'); ?>
				<?php echo $form->textField($model,'pin_code',array('size'=>15,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'pin_code'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('country_id','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'country_id'); ?>
				<?php //echo $form->textField($model,'country_id'); ?>
                        <?php echo $form->dropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
                        'style'=>'width:140px;','empty'=>Yii::t('app','Select Country')
                        )); ?>
                <?php echo $form->error($model,'country_id'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('phone1','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'phone1'); ?>
				<?php echo $form->textField($model,'phone1',array('size'=>15,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'phone1'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('phone2','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'phone2'); ?>
				<?php echo $form->textField($model,'phone2',array('size'=>15,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'phone2'); ?>
			</div>
            <?php } ?>
            
            <?php if(FormFields::model()->isVisible('email','Students','forAdminRegistration')){ ?>
			<div class="txtfld-col">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>25,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'email'); ?>
			</div>
            <?php } ?>

            <!-- dynamic fields -->
            <?php
            $fields     = FormFields::model()->getDynamicFields(1, 2, "forAdminRegistration");
            foreach ($fields as $key => $field) {
                if($field->form_field_type!=NULL){
                    $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
                }                                               
            }
            ?>
            <!-- dynamic fields -->

            <div class="clear"></div>
        </div>
    </div>
    
    <div class="formCon" style=" background:#EDF1D1 url(images/green-bg.png); border:0px #c4da9b solid; color:#393; ">
        <div class="formConInner" style="padding:10px 10px;">
            <!--<h3>Image Details</h3>-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php /*?><tr>
            <td><?php echo $form->labelEx($model,'photo_file_name'); ?></td>
            <td><?php echo $form->hiddenField($model,'photo_file_name',array('size'=>30,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'photo_file_name'); ?></td>
            <td><?php echo $form->labelEx($model,'photo_content_type'); ?>
            </td>
            <td><?php echo $form->hiddenField($model,'photo_content_type',array('size'=>30,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'photo_content_type'); ?></td>
            </tr><?php */?>
            	<tr>
                    <td>
                    <?php 
                    if($model->photo_data==NULL)
                        echo $form->labelEx($model,'<strong style="color:#000">'.Yii::t('app','Upload Photo').'</strong>');
                        else
                        echo $form->labelEx($model,Yii::t('app','Photo')); 
                    ?>
                    </td>
                  
                     
                    <td>
                        <?php 
                        if($model->isNewRecord)
                        {
                            echo $form->fileField($model,'photo_data'); 
                            echo $form->error($model,'photo_data'); 
                        }
                        else
                        {
                            if($model->photo_file_name==NULL) 
                            {
                                echo $form->fileField($model,'photo_data'); 
                                echo $form->error($model,'photo_data'); 
                            }
                            else
                            {
                                if(Yii::app()->controller->action->id=='update') 
                                {
                                    echo CHtml::link(Yii::t('app','Remove'), array('Students/remove', 'id'=>$model->id,'status'=>$_REQUEST['status']),array('confirm'=>Yii::t('app','Are you sure?'))); 									
									if($model->photo_file_name!=NULL){
										$path = Students::model()->getProfileImagePath($model->id);										
										echo '<img class="imgbrder"  src="'.$path.'" alt="'.$model->photo_file_name.'" width="100" height="100" />';
									}
									                                   
                                }
                                else if(Yii::app()->controller->action->id=='create')
                                {
                                    echo CHtml::hiddenField('photo_file_name',$model->photo_file_name);
                                    echo CHtml::hiddenField('photo_content_type',$model->photo_content_type);
                                    echo CHtml::hiddenField('photo_file_size',$model->photo_file_size);
                                    echo CHtml::hiddenField('photo_data',bin2hex($model->photo_data));
                                    echo '<img class="imgbrder" src="'.$this->createUrl('Students/DisplaySavedImage&id='.$model->primaryKey).'" alt="'.$model->photo_file_name.'" width="100" height="100" />';
                                }
                            }
                        }
                        ?> 
                                                                         
                    </td>
                    
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    
            	</tr>
                <tr>
                	<td>&nbsp;</td>                	
                    <td colspan="3">  
                    	<div id="image_size_error" style="color:#F00;"></div>                
                     <div style="margin-top:10px;"> <?php echo Yii::t('app','Maximum file size is 1MB. Allowed file types are png,gif,jpeg,jpg'); ?></div>                        
                    </td>
                </tr>
            </table>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'class_roll_no'); ?>
                <?php echo $form->hiddenField($model,'class_roll_no',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'class_roll_no'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'immediate_contact_id'); ?>
                <?php echo $form->hiddenField($model,'immediate_contact_id'); ?>
                <?php echo $form->error($model,'immediate_contact_id'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'is_sms_enabled'); ?>
                <?php echo $form->hiddenField($model,'is_sms_enabled'); ?>
                <?php echo $form->error($model,'is_sms_enabled'); ?>
            </div>
            
            
            <div class="row">
				<?php //echo $form->labelEx($model,'status_description'); ?>
                <?php echo $form->hiddenField($model,'status_description',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'status_description'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'is_active'); ?>
                <?php echo $form->hiddenField($model,'is_active'); ?>
                <?php echo $form->error($model,'is_active'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'is_deleted'); ?>
                <?php echo $form->hiddenField($model,'is_deleted'); ?>
                <?php echo $form->error($model,'is_deleted'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'created_at'); ?>
                <?php  if(Yii::app()->controller->action->id == 'create')
                {
                echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
                }
                else
                {
                echo $form->hiddenField($model,'created_at');
                }
                ?>
                <?php echo $form->error($model,'created_at'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'updated_at'); ?>
                <?php echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
                <?php echo $form->error($model,'updated_at'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'has_paid_fees'); ?>
                <?php echo $form->hiddenField($model,'has_paid_fees'); ?>
                <?php echo $form->error($model,'has_paid_fees'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'photo_file_size'); ?>
                <?php echo $form->hiddenField($model,'photo_file_size'); ?>
                <?php echo $form->error($model,'photo_file_size'); ?>
            </div>
            
            <div class="row">
				<?php //echo $form->labelEx($model,'user_id'); ?>
                <?php echo $form->hiddenField($model,'user_id',array('value'=>'1')); ?>
                <?php echo $form->error($model,'user_id'); ?>
            </div>
        </div>
    </div><!-- form -->
    <div class="clear"></div>
    <div style="padding:0px 0 0 0px; text-align:left">
    	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Parent Details') : Yii::t('app','Save'),array('id'=>'submit_button_form','class'=>'formbut')); ?>
    </div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$('#submit_button_form').click(function(ev) {
	var file_size = $('#Students_photo_data')[0].files[0].size;	
	if(file_size>1048576)//File upload size limit to 1mb
	{		   	
		$('#image_size_error').html('<?php echo Yii::t('app','File size is greater than 1MB'); ?>');
		return false;
	}		
});
</script>