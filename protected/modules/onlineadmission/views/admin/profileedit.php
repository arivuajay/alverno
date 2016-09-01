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

<?php
$this->breadcrumbs=array(
	Yii::t('app','Edit Students'),
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
           <div class="cont_right formWrapper">
           		<h1>
					<?php echo Yii::t('app','Edit Student Profile').' : '; ?>
                    <?php echo ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name); ?>
                </h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'registraion-form',
				'enableAjaxValidation'=>false,
				'htmlOptions'=>array('enctype'=>'multipart/form-data'),
			)); ?>
           
        <p class="note"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>
        
        <div class="formCon">
        	<div class="formConInner">
                <h3><?php echo Yii::t('app','Personal Details'); ?></h3>
                <?php if(FormFields::model()->isVisible('first_name','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'first_name'); ?>
                    <?php echo $form->textField($model,'first_name',array('size'=>30,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'first_name'); ?>
                </div>
                <?php } ?>
    
                <?php if(FormFields::model()->isVisible('middle_name','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'middle_name'); ?>
                    <?php echo $form->textField($model,'middle_name',array('size'=>10,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'middle_name'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('last_name','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'last_name'); ?>
                    <?php echo $form->textField($model,'last_name',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'last_name'); ?>
                </div>
                <?php } ?>
                <?php if(FormFields::model()->isVisible('national_student_id','Students','forOnlineRegistration')){ ?>
                    <div class="txtfld-col">
                        <?php echo $form->labelEx($model,'national_student_id'); ?>
                        <?php echo $form->textField($model,'national_student_id',array('size'=>25,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'national_student_id'); ?>
                    </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('batch_id','Students','forOnlineRegistration')){ ?>
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
                            $batch_details = Batches::model()->findAll("is_deleted=:x AND is_active=:y AND academic_yr_id=:z", array(':x'=>0,':y'=>1,':z'=>$year));
                            $data = array();
                            foreach ($batch_details as $batch_detail)
                            {
                                //$posts=Batches::model()->findByPk($model_1->id);
                                $data[$batch_detail->id] = $batch_detail->course123->course_name.'-'.$batch_detail->name;
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
                
                <?php if(FormFields::model()->isVisible('date_of_birth','Students','forOnlineRegistration')){ ?>
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
                
                <?php if(FormFields::model()->isVisible('gender','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'gender'); ?>
                    <?php //echo $form->textField($model,'gender',array('size'=>60,'maxlength'=>255)); ?>
                            <?php echo $form->dropDownList($model,'gender',array('M' => Yii::t('app','Male'), 'F' => Yii::t('app','Female')),array('empty' => Yii::t('app','Select Gender'))); ?>
                            <?php echo $form->error($model,'gender'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('blood_group','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'blood_group'); ?>
                    <?php //echo $form->textField($model,'blood_group',array('size'=>60,'maxlength'=>255)); ?>
                            <?php echo $form->dropDownList($model,'blood_group',
                            array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'),
                            array('empty' => Yii::t('app','Unknown'))); ?>
                            <?php echo $form->error($model,'blood_group'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('birth_place','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'birth_place'); ?>
                    <?php echo $form->textField($model,'birth_place',array('size'=>10,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'birth_place'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('nationality_id','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'nationality_id'); ?>
                    <?php //echo $form->textField($model,'nationality_id'); ?>
                            <?php echo $form->dropDownList($model,'nationality_id',CHtml::listData(Nationality::model()->findAll(),'id','name'),array(
                            'style'=>'width:140px;','empty'=>Yii::t('app','Select Nationality')
                            )); ?>
                            <?php echo $form->error($model,'nationality_id'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('language','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'language'); ?>
                    <?php echo $form->textField($model,'language',array('size'=>15,'maxlength'=>255)); ?>
                     <?php echo $form->error($model,'language'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('religion','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'religion'); ?>
                    <?php echo $form->textField($model,'religion',array('size'=>10,'maxlength'=>255)); ?>
                     <?php echo $form->error($model,'religion'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('student_category_id','Students','forOnlineRegistration')){ ?>
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
                $fields 	= FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
                foreach ($fields as $key => $field) {
                    if($field->form_field_type!=NULL){
                        $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
                    }                                               
                }
                ?>
                <div class="clear"></div>
			</div> <!-- END div class="formConInner" -->
        </div> <!-- END div class="formCon" -->
        
        <div class="formCon">
        	<div class="formConInner">
                <h3><?php echo Yii::t('app','Contact Details'); ?></h3>
    
                <?php if(FormFields::model()->isVisible('address_line1','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'address_line1'); ?>
                    <?php echo $form->textField($model,'address_line1',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'address_line1'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('address_line2','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'address_line2'); ?>
                    <?php echo $form->textField($model,'address_line2',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'address_line2'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('city','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'city'); ?>
                    <?php echo $form->textField($model,'city',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'city'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('state','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'state'); ?>
                    <?php echo $form->textField($model,'state',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'state'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('pin_code','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'pin_code'); ?>
                    <?php echo $form->textField($model,'pin_code',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'pin_code'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('country_id','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'country_id'); ?>
                    <?php //echo $form->textField($model,'country_id'); ?>
                            <?php echo $form->dropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
                            'style'=>'width:140px;','empty'=>Yii::t('app','Select Country')
                            )); ?>
                    <?php echo $form->error($model,'country_id'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('phone1','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'phone1'); ?>
                    <?php echo $form->textField($model,'phone1',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'phone1'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('phone2','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'phone2'); ?>
                    <?php echo $form->textField($model,'phone2',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'phone2'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('email','Students','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model,'email'); ?>
                    <?php echo $form->textField($model,'email',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
                <?php } ?>
    
                <!-- dynamic fields -->
                <?php
                $fields     = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
                foreach ($fields as $key => $field) {
                    if($field->form_field_type!=NULL){
                        $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
                    }                                               
                }
                ?>
                <!-- dynamic fields -->
    
                <div class="clear"></div>
            </div> <!-- END div class="formConInner" -->
        </div>
        
<!-- Image Start -->
<div class="formCon" style=" background:#EDF1D1 url(images/green-bg.png); border:0px #c4da9b solid; color:#393; ">
        <div class="formConInner" style="padding:10px 10px;">
            <!--<h3>Image Details</h3>-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
           
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
                                if(Yii::app()->controller->action->id=='profileedit') 
                                {
                                    echo CHtml::link(Yii::t('app','Remove'), array('admin/remove', 'id'=>$model->id),array('confirm'=>Yii::t('app','Are you sure?'))); 
									
									if($model->photo_file_name!=NULL) 
                            		{
										$path = Students::model()->getProfileImagePath($model->id);										
                                    	echo '<img class="imgbrder" src="'.$path.'" alt="'.$model->photo_file_name.'" width="100" height="100" />';	
									}
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
                         <?php echo Yii::t('app','Maximum file size is 1MB. Allowed file type is png,gif,jpeg,jpg'); ?>                        
                    </td>
                 </tr>
            </table>
          </div>
          </div>  
<!-- Image End -->             
        
        
        
         <!-- END div class="formCon" -->
        
       
        <?php 
		if($model_1!=NULL)
		{
		?>
        <div class="formCon">
            <div class="formConInner">                            
            <h3><?php echo Yii::t('app','Parent - Personal Details');?></h3>
                
                <?php if(FormFields::model()->isVisible('first_name','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'first_name'); ?>
                    <?php echo $form->textField($model_1,'first_name',array('size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'first_name'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('last_name','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'last_name'); ?>
                    <?php echo $form->textField($model_1,'last_name',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'last_name'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('relation','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                	<?php echo $form->labelEx($model_1,'relation'); ?>
                    <?php echo $form->textField($model_1,'relation',array('size'=>25,'maxlength'=>255)); ?>
					<?php echo $form->error($model_1,'relation'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('dob','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1, 'dob'); ?>
                    <?php 
                        $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                        if($settings!=NULL){
                            $date=$settings->dateformat;               
                                    if($model_1->dob!=NULL)
                                    {
                                       
                                        $model_1->dob= date($settings->displaydate,  strtotime($model_1->dob));
                                    }
                        }else{
                            $date = 'dd-mm-yy';	
                        }
                            
                         $this->widget('zii.widgets.jui.CJuiDatePicker', array(                        
                            'model'=>$model_1,
                            'attribute'=>'dob',
                            // additional javascript options for the date picker plugin
                            'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>$date,
                            'changeMonth'=> true,
                            'changeYear'=>true,
                            'yearRange'=>'1900:'.(date('Y')+5)
                            ),
                            'htmlOptions'=>array(
                            'style'=>'height:15px;',
                            'readonly'=>true
                            ),
                        ));
                    ?>
                    <?php echo $form->error($model_1,'dob'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('education','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'education'); ?>
                    <?php echo $form->textField($model_1,'education',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'education'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('occupation','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'occupation'); ?>
                    <?php echo $form->textField($model_1,'occupation',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'occupation'); ?>
                </div>
                <?php } ?>
            
                <?php if(FormFields::model()->isVisible('income','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'income'); ?>
                    <?php echo $form->textField($model_1,'income',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'income'); ?>
                </div>
                <?php } ?>
            
                <!-- dynamic fields -->
                <?php
                $fields     = FormFields::model()->getDynamicFields(2, 1, "forOnlineRegistration");
                foreach ($fields as $key => $field) {
                    if($field->form_field_type!=NULL){
                        $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model_1, 'field'=>$field));                                                
                    }                                               
                }
                ?>
                <!-- dynamic fields -->
            
                <div class="clear"></div>
            </div> <!-- END div class="formConInner" -->
        </div> <!-- END div class="formCon" -->
        
        
        
        
        <div class="formCon">
        	<div class="formConInner">
                <h3><?php echo Yii::t('app','Parent - Contact Details'); ?></h3>
                
                <?php if(FormFields::model()->isVisible('email','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'email'); ?>
                    <?php echo $form->textField($model_1,'email',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'email'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <?php echo $form->labelEx($model_1,'mobile_phone'); ?>
                    <?php echo $form->textField($model_1,'mobile_phone',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'mobile_phone'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <div class="hide">
                        <?php echo $form->labelEx($model_1,'office_phone1'); ?>
                        <?php echo $form->textField($model_1,'office_phone1',array('size'=>15,'maxlength'=>255)); ?>
                        <?php echo $form->error($model_1,'office_phone1'); ?>
                    </div>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col">
                    <div class="hide">
                        <?php echo $form->labelEx($model_1,'office_phone2'); ?>
                        <?php echo $form->textField($model_1,'office_phone2',array('size'=>15,'maxlength'=>255)); ?>
                        <?php echo $form->error($model_1,'office_phone2'); ?>
                    </div>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col hide">
                    <?php echo $form->labelEx($model_1,'office_address_line1'); ?>
                    <?php echo $form->textField($model_1,'office_address_line1',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'office_address_line1'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col hide">
                    <?php echo $form->labelEx($model_1,'office_address_line2'); ?>
                    <?php echo $form->textField($model_1,'office_address_line2',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'office_address_line2'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('city','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col hide">
                    <?php echo $form->labelEx($model_1,'city'); ?>
                    <?php echo $form->textField($model_1,'city',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'city'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('state','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col hide">
                    <?php echo $form->labelEx($model_1,'state'); ?>
                    <?php echo $form->textField($model_1,'state',array('size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model_1,'state'); ?>
                </div>
                <?php } ?>
                
                <?php if(FormFields::model()->isVisible('country_id','Guardians','forOnlineRegistration')){ ?>
                <div class="txtfld-col hide">
                    <?php echo $form->labelEx($model_1,'country_id'); ?>
                    <?php echo $form->dropDownList($model_1,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
                                                    'style'=>'width:130px;','empty'=>Yii::t('app','Select Country')
                                                )); ?>
                    <?php echo $form->error($model_1,'country_id'); ?>
                </div>
                <?php } ?>
                
                <!-- dynamic fields -->
                <?php
                $fields     = FormFields::model()->getDynamicFields(2, 2, "forOnlineRegistration");
                foreach ($fields as $key => $field) {
                    if($field->form_field_type!=NULL){
                        $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model_1, 'field'=>$field));                                                
                    }                                               
                }
                ?>
                <!-- dynamic fields -->
                
                
                
                <div class="clear"></div>
                 
                </div> <!-- END div class="formConInner" -->
        </div> <!-- END div class="formCon" -->

		<?php
		}
		?>
        


    	<div class="clear"></div>
    	<div class="clear"></div>
       
        <div style="padding:0px 0 0 0px; text-align:left">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Register') : Yii::t('app','Save'),array('id'=>'submit_button_form','class'=>'formbut')); ?>
        <?php $this->endWidget(); ?>
        </div> <!-- END div class="cont_right formWrapper" -->
    <div class="clear"></div>
</div> <!-- END div class="loginboxWrapper" -->
                </h1>
            </div>
            
         </td>
      </tr>
</table>

<script type="text/javascript">
$('#submit_button_form').click(function(ev) {
	var file_size = $('#Students_photo_data')[0].files[0].size;	
	if(file_size>1048576)//File upload size limit to 1mb
	{		   	
		$('#image_size_error').html('<?php echo Yii::t('app','File size is greater than 1MB'); ?>');
		$('#Students_photo_data').focus();
		return false;
	}		
});
</script>                