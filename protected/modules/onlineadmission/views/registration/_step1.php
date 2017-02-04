<style type="text/css">
    .fb_iframe_widget{ width:220px;}
    .col-sm-4{
        height:90px;
    }
</style>
<div class="col-md-12 se_panel_formwrap">
    <div class="wiz_right">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'students-_step1-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <p class="note"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required.'); ?></p>
        <?php //echo $form->errorSummary($model);  ?>
        <h4 class="text-success"><?php echo Yii::t('app', 'Personal Details'); ?></h4>
        <div class="row mb10">
            <?php if (FormFields::model()->isVisible('first_name', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('first_name'))); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('middle_name', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'middle_name', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'middle_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('middle_name'))); ?>
                    <?php echo $form->error($model, 'middle_name'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('last_name', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'last_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('last_name'))); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('national_student_id', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'national_student_id', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'national_student_id', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('national_student_id'))); ?>
                    <?php echo $form->error($model, 'national_student_id'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('batch_id', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'batch_id', array('class' => 'control-label', 'id' => 'batch_label')); ?>
                    <?php
                    $academic_yr = OnlineRegisterSettings::model()->findByAttributes(array('id' => 2));
                    $studentslist = array();
                    $criteria = new CDbCriteria;
                    $criteria->condition = "is_deleted =:x AND is_active=:y AND academic_yr_id=:academic_yr_id";
                    $criteria->params = array(':x' => '0', ':y' => '1', ':academic_yr_id' => $academic_yr->config_value);
                    $batchlists = Batches::model()->findAll($criteria);
                    $data = array();
                    foreach ($batchlists as $batchlist) {
                        $data[$batchlist->id] = ucfirst($batchlist->course123->course_name) . ' - ' . ucfirst($batchlist->name);
                    }
                    if (isset($model->batch_id) and $model->batch_id != NULL) {
                        echo $form->dropDownList($model, 'batch_id', $data, array('options' => array($model->batch_id => array('selected' => true)), 'class' => 'form-control', 'id' => 'batch_id', 'prompt' => Yii::t('app', 'Select') . ' ' . Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")));
                    } else {
                        echo $form->dropDownList($model, 'batch_id', $data, array('class' => 'form-control', 'id' => 'batch_id', 'prompt' => Yii::t('app', 'Select') . ' ' . Yii::app()->getModule('students')->fieldLabel("Students", "batch_id")));
                    }
                    ?>
                    <?php echo $form->error($model, 'batch_id'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('date_of_birth', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'date_of_birth', array('class' => 'control-label')); ?>
                    <?php
                    $settings = UserSettings::model()->findByAttributes(array('user_id' => 1));
                    if ($settings != NULL) {
                        $date = $settings->dateformat;
                    } else {
                        $date = 'dd-mm-yy';
                    }
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'date_of_birth',
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => $date,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'yearRange' => '1900:'
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                            'placeholder' => $model->getAttributeLabel('date_of_birth')
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'date_of_birth'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('birth_place', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'birth_place', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'birth_place', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('birth_place'))); ?>
                    <?php echo $form->error($model, 'birth_place'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('nationality_id', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'nationality_id', array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model, 'nationality_id', CHtml::listData(Nationality::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'prompt' => Yii::t('app', 'Select') . ' ' . $model->getAttributeLabel('nationality_id'))); ?>
                    <?php echo $form->error($model, 'nationality_id'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('language', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'language', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'language', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('language'))); ?>
                    <?php echo $form->error($model, 'language'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('religion', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'religion', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'religion', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('religion'))); ?>
                    <?php echo $form->error($model, 'religion'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('blood_group', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'blood_group', array('class' => 'control-label')); ?><br />
                    <?php
                    echo $form->dropDownList($model, 'blood_group', array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('empty' => Yii::t('app', 'Unknown'), 'class' => 'form-control'));
                    ?>
                    <?php echo $form->error($model, 'blood_group'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('student_category_id', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'student_category_id', array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model, 'student_category_id', CHtml::listData(StudentCategories::model()->findAll(), 'id', 'name'), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'student_category_id'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('gender', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'gender', array('class' => 'control-label')); ?><br />
                    <?php echo $form->radioButtonList($model, 'gender', array('M' => Yii::t('app', 'Male'), 'F' => Yii::t('app', 'Female')), array('separator' => ' ')); ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </div>
            <?php } ?>
            <?php
            $fields = FormFields::model()->getDynamicFields(1, 1, "forOnlineRegistration");
            foreach ($fields as $key => $field) {
                if ($field->form_field_type != NULL) {
                    $this->renderPartial("application.modules.dynamicform.views.fields.online-form._field_" . $field->form_field_type, array('model' => $model, 'field' => $field));
                }
            }
            ?>
        </div>
        <br />
        <h4 class="text-success">SIBLING DETAILS</h4>
        <div class="row mb10">
            <div class="col-sm-4">
                <?php
                if ($model->isNewRecord and $model->is_siblings == NULL) {
                    $model->is_siblings = 'No';
                }
                echo $form->labelEx($model, 'is_siblings', array('class' => 'control-label'));
                ?><br />
                <?php echo $form->radioButtonList($model, 'is_siblings', array('Yes' => Yii::t('app', 'Yes'), 'No' => Yii::t('app', 'No')), array('separator' => ' ', 'class' => 'is_siblings')); ?>
                <?php echo $form->error($model, 'is_siblings'); ?>
            </div>
            <div class="col-sm-4 hide_div">
                <?php echo $form->labelEx($model_1, 'name', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model_1, 'name', array('class' => 'form-control', 'placeholder' => $model_1->getAttributeLabel('name'))); ?>
                <?php echo $form->error($model_1, 'name'); ?>
                <div id="sibling_name_error" style="color:#F00"></div>
            </div>
            <div class="col-sm-4 hide_div">
                <?php echo $form->labelEx($model_1, 'class & section', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model_1, 'class', array('class' => 'form-control', 'placeholder' => $model_1->getAttributeLabel('class & section'))); ?>
                <?php echo $form->error($model_1, 'class'); ?>
                <div id="sibling_class_error" style="color:#F00"></div>
            </div>
        </div>
        <div class="row mb10 hide_div">
            <div class="col-sm-4">
                <?php
                if ($model_1->isNewRecord) {
                    echo $form->labelEx($model_1, 'file_name', array('class' => 'control-label'));
                    echo $form->fileField($model_1, 'file_name');
                    echo $form->error($model_1, 'file_name');
                } else {
                    if ($model_1->file_name == NULL) {
                        echo $form->labelEx($model_1, 'file_name', array('class' => 'control-label'));
                        echo $form->fileField($model_1, 'file_name');
                        echo $form->error($model_1, 'file_name');
                    } else {
                        if (Yii::app()->controller->action->id == 'step1' and isset($_REQUEST['token'])) {
                            echo CHtml::link(Yii::t('students', 'Remove'), array('registration/removeIdCard', 'token' => $this->encryptToken($model->id)), array('confirm' => 'Are you sure?'));
                            if ($model_1->file_name != NULL) {
                                $file_path = RegisteredStudents::model()->getIdCardImagePath($model_1->id);
                                echo '<img class="imgbrder" src="' . $file_path . '" alt="' . $model_1->file_name . '" width="100" height="100" />';
                            }
                        }
                    }
                }
                ?>
                <div id="sibling_id_card_error" style="color:#F00"></div>
            </div>
        </div>
        <br />
        <h4 class="text-success"><?php echo Yii::t('app', 'Contact Details'); ?></h4>
        <div class="row mb10">
            <?php if (FormFields::model()->isVisible('address_line1', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'address_line1', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'address_line1', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address_line1'))); ?>
                    <?php echo $form->error($model, 'address_line1'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('address_line2', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'address_line2', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'address_line2', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address_line2'))); ?>
                    <?php echo $form->error($model, 'address_line2'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('city', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'city', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'city', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('city'))); ?>
                    <?php echo $form->error($model, 'city'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('state', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'state', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'state', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('state'))); ?>
                    <?php echo $form->error($model, 'state'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('pin_code', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'pin_code', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'pin_code', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('pin_code'))); ?>
                    <?php echo $form->error($model, 'pin_code'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('country_id', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model, 'country_id', CHtml::listData(Countries::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'prompt' => Yii::t('app', 'Select') . ' ' . $model->getAttributeLabel('country_id'))); ?>
                    <?php echo $form->error($model, 'country_id'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('phone1', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'phone1', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'phone1', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone1'))); ?>
                    <?php echo $form->error($model, 'phone1'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('phone2', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'phone2', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'phone2', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone2'))); ?>
                    <?php echo $form->error($model, 'phone2'); ?>
                </div>
            <?php } ?>
            <?php if (FormFields::model()->isVisible('email', 'Students', 'forOnlineRegistration')) { ?>
                <div class="col-sm-4">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            <?php } ?>
            <?php
            $fields = FormFields::model()->getDynamicFields(1, 2, "forOnlineRegistration");
            foreach ($fields as $key => $field) {
                if ($field->form_field_type != NULL) {
                    $this->renderPartial("application.modules.dynamicform.views.fields.online-form._field_" . $field->form_field_type, array('model' => $model, 'field' => $field));
                }
            }
            ?>
        </div>
        <br />
        <?php if (FormFields::model()->isVisible('photo_data', 'Students', 'forOnlineRegistration')) { ?>
            <h4 class="text-success"><?php echo Yii::t('app', 'Upload Photo'); ?></h4>
            <div class="row mb10">
                <div class="col-sm-12">
                    <?php
                    if ($model->isNewRecord) {
                        echo $form->fileField($model, 'photo_data');
                        echo $form->error($model, 'photo_data');
                    } else {
                        if ($model->photo_file_name == NULL) {
                            echo $form->fileField($model, 'photo_data');
                            echo $form->error($model, 'photo_data');
                        } else {
                            if (Yii::app()->controller->action->id == 'step1' and isset($_REQUEST['token'])) {
                                echo CHtml::link(Yii::t('app', 'Remove'), array('registration/remove', 'token' => $this->encryptToken($model->id)), array('confirm' => Yii::t('app', 'Are you sure?')));
                                if ($model->photo_file_name != NULL) {
                                    $path = Students::model()->getProfileImagePath($model->id);
                                    echo '<img class="imgbrder" src="' . $path . '" alt="' . $model->photo_file_name . '" width="100" height="100" />';
                                }
                            } else if (Yii::app()->controller->action->id == 'step1') {
                                echo CHtml::hiddenField('photo_file_name', $model->photo_file_name);
                                echo CHtml::hiddenField('photo_content_type', $model->photo_content_type);
                                echo CHtml::hiddenField('photo_file_size', $model->photo_file_size);
                                echo CHtml::hiddenField('photo_data', bin2hex($model->photo_data));
                                echo '<img class="imgbrder" src="' . $this->createUrl('Registration/DisplaySavedImage&id=' . $model->primaryKey) . '" alt="' . $model->photo_file_name . '" width="100" height="100" />';
                            }
                        }
                    }
                    ?>
                    <div class="row mb12">
                        <div id="image_size_error" style="color:#F00;"></div>
                        <div><?php echo Yii::t('app', 'Maximum file size is 1MB. Allowed file types are png,gif,jpeg,jpg'); ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <br />
        <div class="row mb10">
            <div class="col-sm-4">
                <div class="row buttons">
                    <?php echo CHtml::submitButton(Yii::t('app', 'Save') . ' & ' . Yii::t('app', 'Continue'), array('id' => 'submit_button_form', 'class' => "btn btn-success btn-block")); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<script type="text/javascript">
    $('.hide_div').hide();
    $('.is_siblings').click(function (ev) {
        var val = $(this).val();
        if (val == 'Yes') {
            $('.hide_div').show('slow');
        } else {
            $('.hide_div').hide('slow');
            $('#StudentSiblings_name').val('');
            $('#StudentSiblings_class').val('');
            $('#StudentSiblings_file_name').val('');
        }
    });
    $('#submit_button_form').click(function (ev) {
        $('#sibling_name_error').html('');
        $('#sibling_class_error').html('');
        $('#sibling_id_card_error').html('');
        $('#image_size_error').html('');
        var is_sibling = $("input:radio[name='Students[is_siblings]']:checked").val();
        var flag = 0;
        var is_photo = $('#Students_photo_data').val();
        /*if(is_photo == ''){
         $('#image_size_error').html('Cannot be blank');
         return false;
         }*/
        if (is_sibling == 'Yes') {
            var sibling_name = $('#StudentSiblings_name').val();
            var sibling_class = $('#StudentSiblings_class').val();
            var sibling_id_card = $('#StudentSiblings_file_name').val();
            if (sibling_name == '') {
                $('#sibling_name_error').html('Cannot be blank');
                flag = 1;
            }
            if (sibling_class == '') {
                $('#sibling_class_error').html('Cannot be blank');
                flag = 1;
            }
            if (sibling_id_card == '') {
                $('#sibling_id_card_error').html('Cannot be blank');
                flag = 1;
            }
        }
        if (flag == 1) {
            return false;
        }
        var file_size = $('#Students_photo_data')[0].files[0].size;
        if (file_size > 1048576)//File upload size limit to 1mb
        {
            $('#image_size_error').html('<?php echo Yii::t('app', 'File size is greater than 1MB'); ?>');
            return false;
        }
    });
</script>
<?php if ($model->is_siblings == 'Yes') { ?>
    <script> $('.hide_div').show();</script>
<?php } ?>