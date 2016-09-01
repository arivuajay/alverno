 
 <style>
.sp_col{
	border-bottom:1px #eee solid;
	padding-bottom:8px;
}
</style>
 <?php $this->renderPartial('leftside'); ?>
    <div class="pageheader">
      <h2><i class="fa fa-calendar"></i> <?php echo Yii::t('app','Profile'); ?> <span><?php echo Yii::t('app','View your profile here'); ?></span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
        <ol class="breadcrumb">
          <!--<li><a href="index.html">Home</a></li>-->
          <li class="active"><?php echo Yii::t('app','Profile'); ?></li>
        </ol>
      </div>
    </div>

     <div class="contentpanel" class="form-control">
	 	<div class="panel panel-default">
            <div class="panel-heading">                   
            <h3 class="panel-title"><?php echo Yii::t('app','Edit Profile'); ?></h3>
            </div>
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'guardians-form',
                    'enableAjaxValidation'=>false,
            )); ?>

<div class="panel-body">
				 <?php if(FormFields::model()->isVisible('dob','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                        <?php echo CHtml::activeLabelEx($model, 'dob',array('class'=>'control-label')); ?>
                        </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                        <?php
                        $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
                        if($settings!=NULL){
                            $date = $settings->dateformat;
                            $model->dob = date($settings->displaydate,strtotime($model->dob));
                        }else{
                            $date = 'dd-mm-yy';
                        }
                                 $this->widget('zii.widgets.jui.CJuiDatePicker', array(                        
                                        'model'=>$model,
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
                                        'class'=>'form-control',
                                        'style'=>'height:26px;border-radius: 3px;
                                                padding: 10px;
                                                width:200px;
                                            height: auto;
                                            font-size: 13px;',
                                            
                                        'readonly'=>true
                                        ),
                                        ));
                                        ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
				<?php
                 }
                ?>
                <?php if(FormFields::model()->isVisible('education','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                        <?php echo CHtml::activeLabelEx($model, 'education',array('class'=>'control-label')); ?>
                         </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                       
                       <?php echo $form->textField($model,'education',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'education'); ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
				<?php
                 }
                ?>
                  <?php if(FormFields::model()->isVisible('occupation','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                         <?php echo CHtml::activeLabelEx($model, 'occupation',array('class'=>'control-label')); ?>
                         </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                       
                      <?php echo $form->textField($model,'occupation',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'occupation'); ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
				<?php
                 }
                ?>
                  <?php if(FormFields::model()->isVisible('income','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'income',array('class'=>'control-label')); ?>
                       </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                       
                     <?php echo $form->textField($model,'income',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'income'); ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
				<?php
                 }
                ?>
                <?php
            $fields     = FormFields::model()->getDynamicFields(2, 1, "forParentPortal");
			if($fields)
			{
            foreach ($fields as $key => $field) {
                if($field->form_field_type!=NULL){
                    $this->renderPartial("application.modules.dynamicform.views.fields.portal-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
                }                                               
            }
			}
            ?>
            <?php if(FormFields::model()->isVisible('email','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'email',array('class'=>'control-label')); ?>
                       </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                       
                    <?php echo $form->textField($model,'email',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'email'); ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forParentPortal')){?>
                    <!--repeated div starts-->
                    <div class="col-sm-6 clearfix sp_col">
                        <!--left div starts-->
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'mobile_phone',array('class'=>'control-label')); ?>
                       </div>
                        <!--right div starts-->
                        <div class="col-sm-6">
                       
                    <?php echo $form->textField($model,'mobile_phone',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'mobile_phone'); ?>
                        </div>
                    </div>
                    <!--repeated div ends-->
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('office_phone1','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'office_phone1',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                   <?php echo $form->textField($model,'office_phone1',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'office_phone1'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('office_phone2','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'office_phone2',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                   <?php echo $form->textField($model,'office_phone2',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'office_phone2'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
            <?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'office_address_line1',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                   <?php echo $form->textField($model,'office_address_line1',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'office_address_line1'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'office_address_line2',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                   <?php echo $form->textField($model,'office_address_line2',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'office_address_line2'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
              <?php if(FormFields::model()->isVisible('city','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'city',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                   <?php echo $form->textField($model,'city',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'city'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('state','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'state',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                  <?php echo $form->textField($model,'state',array('size'=>15,'maxlength'=>255,'class'=>'form-control','style'=>'width:200px;')); ?>
			<?php echo $form->error($model,'state'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            ?>
             <?php if(FormFields::model()->isVisible('country_id','Guardians','forParentPortal')){?>
                    
                    <div class="col-sm-6 clearfix sp_col">
                      
                        <div class="col-sm-6">
                          <?php echo CHtml::activeLabelEx($model, 'country_id',array('class'=>'control-label')); ?>
                       </div>
                      
                        <div class="col-sm-6">
                       
                 <?php echo $form->dropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
										'style'=>'width:130px;','class'=>'form-control','empty'=>Yii::t('app','Select Country')
									)); ?>
			<?php echo $form->error($model,'country_id'); ?>
                        </div>
                    </div>
                   
			<?php
             }
            
            $fields_1     = FormFields::model()->getDynamicFields(2, 2, "forParentPortal");
			if($fields_1)
			{
            foreach ($fields_1 as $key => $field) {
                if($field->form_field_type!=NULL){
                    $this->renderPartial("application.modules.dynamicform.views.fields.portal-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
                }                                               
            }
			}
            ?>
	  <div class="clearfix"></div>
</div>
         <div class="panel-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),array('class'=>'btn btn-danger')); ?>
	</div>
<div class="clear"></div>
<?php $this->endWidget(); ?>
  </div>
  </div>