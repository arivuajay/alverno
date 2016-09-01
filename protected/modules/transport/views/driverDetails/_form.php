<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'driver-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<p><?php echo Yii::t('app','Fields with');?><span class="required">*</span><?php echo Yii::t('app','are required.');?></p>

<?php echo $form->errorSummary($model); ?>
<br />
    
<div class="formCon">
	<div class="formConInner">
        <table width="80%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <label> <?php echo Yii::t('app','First Name');?><span class="required"> *</span></label>
                    
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'first_name',array('size'=>20)); ?>
                    <?php echo $form->error($model,'first_name'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->labelEx($model,'last_name'); ?> 
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'last_name',array('size'=>20)); ?>
                    <?php echo $form->error($model,'last_name'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->labelEx($model,'address'); ?> 
                    
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'address',array('size'=>20)); ?>
                    <?php echo $form->error($model,'address'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
             <tr>
                <td>
                    <label>  <?php echo Yii::t('app','Phone Number');?><span class="required"> *</span></label>
                    
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'phn_no',array('size'=>20)); ?>
                    <?php echo $form->error($model,'phn_no'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                  <?php echo $form->labelEx($model,'dob'); ?> 
                  
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php //echo $form->textField($model,'admission_date');
                    $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                    if($settings!=NULL)
                    {
                        $date=$settings->dateformat;
            
            
                    }
                    else
                    $date = 'dd-mm-yy';	
                    $msg = 'changed';
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    //'name'=>'Students[admission_date]',
                                    'model'=>$model,
                                    'id'=>'dateob',
                                    'attribute'=>'dob',
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>$date,
                                        'changeMonth'=> true,
                                        'changeYear'=>true,
                                        'yearRange'=>'1900:',
                                        'onSelect'=>'js:function(){
                                                        var dob = new Date($("#dateob").val());
                                                        var dob_day = dob.getDate();
                                                        var dob_mnth = dob.getMonth();
                                                        var dob_yr = dob.getFullYear();
                                                        var crrnt_day = (new Date).getDate();
                                                        var crrnt_mnth = (new Date).getMonth();
                                                        var crrnt_yr = (new Date).getFullYear();
                                                        var age;
                                                        if((crrnt_mnth > dob_mnth) && (crrnt_day > dob_day)){
                                                            age = crrnt_yr - dob_yr;
                                                            $("#age").val(age);
                                                        }
                                                        else{
                                                            age = (crrnt_yr - dob_yr) - 1;
                                                            $("#age").val(age);
                                                        }
                                                    }' //Calculating and setting age
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;',
                                        
                                    ),
                                ));
             ?>
                    <?php echo $form->error($model,'dob'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
             <tr>
                <td>
                      <?php echo $form->labelEx($model,'age'); ?> 
                     
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'age',array('size'=>20,'id'=>'age')); ?>
                    <?php echo $form->error($model,'age'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
             <tr>
                <td>
                      <?php echo $form->labelEx($model,'license_no'); ?> 
                    
                </td>
                <td>&nbsp;
                </td>
                <td>
                    <?php echo $form->textField($model,'license_no',array('size'=>20)); ?>
                    <?php echo $form->error($model,'license_no'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
             <tr>
                <td>
                    <?php echo $form->labelEx($model,'expiry_date'); ?> 
                    
                </td>
                <td>&nbsp;
                </td>
                <td>
                <?php
                $daterange=date('Y');
               $daterange_1=$daterange+20;
                ?>
                    <?php //echo $form->textField($model,'admission_date');
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    //'name'=>'Students[admission_date]',
                                    'model'=>$model,
                                    'attribute'=>'expiry_date',
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>$date,
                                        'changeMonth'=> true,
                                        'changeYear'=>true,
                                        'yearRange'=>'1900:'.$daterange_1,
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;',
										'readonly'=>true
                                    ),
                                ));
             ?>
                    <?php echo $form->error($model,'expiry_date'); ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
                <td>&nbsp;
                </td>
            </tr>
        </table>
	</div>
</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->