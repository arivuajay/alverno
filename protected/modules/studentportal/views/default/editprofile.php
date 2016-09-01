<style>
form .form-group{
	margin-bottom:15px !important;
}
</style>
	<?php $this->renderPartial('leftside');?> 
    <?php    
	
    $guard = Guardians::model()->findByAttributes(array('id'=>$model->parent_id));
    $settings=UserSettings::model()->findByAttributes(array('user_id'=>1));

    $student_visible_fields  = FormFields::model()->getVisibleFields('Students', 'forStudentPortal');
    ?>
<div class="pageheader">
  <div class="col-lg-8">
    <h2><i class="fa fa-user"></i><?php echo Yii::t('app','Profile');?><span><?php echo Yii::t('app','View your profile here'); ?> <?php echo CHtml::link('<span>'.Yii::t('user','view Profile').'</span>',array('profile'),array('class'=>'addbttn last'));?></span></h2>
  </div>
  <div class="col-lg-2">
    <?php if(count($students)==1 or (isset($_REQUEST['id']) and $_REQUEST['id']!=NULL)) // Show drop down only if more than 1 student present
        {
        echo CHtml::dropDownList('sid','',$student_list,array('prompt'=>Yii::t('app','Select Student'),'id'=>'studentid','class'=>'form-control input-sm mb14','style'=>'width:auto;','options'=>array($_REQUEST['id']=>array('selected'=>true)),'onchange'=>'getstudent();'));}
        ?>
  </div>
  <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app','You are here:'); ?></span>
    <ol class="breadcrumb">
      <!--<li><a href="index.html">Home</a></li>-->
      
      <li class="active"><?php echo Yii::t('app','Profile'); ?></li>
    </ol>
  </div>
  <div class="clearfix"></div>
</div>    
 <div class="contentpanel">
  <div>
    <div class="people-item clearfix">
    	
    	<div class="media clearfix"><a href="#" class="pull-left">
                	<?php
                     if($model->photo_file_name!=NULL)
                     { 
					 	$path = Students::model()->getProfileImagePath($model->id);
                        echo '<img  src="'.$path.'" alt="'.$model->photo_file_name.'" width="100" height="103" class="thumbnail media-object" />';
                    }
                    elseif($model->gender=='M')
                    {
                        echo '<img  src="images/portal/prof-img_male.png" alt='.$model->first_name.' width="100" height="103" class="thumbnail media-object" />'; 
                    }
                    elseif($model->gender=='F')
                    {
                        echo '<img  src="images/portal/prof-img_female.png" alt='.$model->first_name.' width="100" height="103" class="thumbnail media-object" />';
                    }
                    ?>
               </a>
                <div class="media-body">
                	<?php
                  if(FormFields::model()->isVisible("fullname", "Students", "forStudentPortal")){
                  ?>
                  <h4 class="person-name"><?php echo $model->studentFullName("forStudentPortal");?></h4>
                  <?php
                  }
                  ?>
                	
                    <?php if(in_array('batch_id', $student_visible_fields)){ ?>    
                    <div class="text-muted"><?php echo '<strong>'.Yii::t('app','Course').'</strong>';?>
                        <?php 
                        $batch = Batches::model()->findByPk($model->batch_id);
                        echo ': '.$batch->course123->course_name;
                        ?>
                    </div>
                    <div class="text-muted"><?php echo '<strong>'.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</strong>';?>
                    <?php echo ': '.$batch->name;?></div>
                    <?php } ?>
                    <div class="text-muted"><?php echo '<strong>'.Yii::t('app','Admission No').' :</strong>';?>
                    <?php echo ': '.$model->admission_no; ?></div>
               </div>
               <div class="edit_bttns pull-right">
                <ul>
                    <li>
                        <?php echo CHtml::link('<span>'.Yii::t('app','View Profile').'</span>',array('profile'),array('class'=>'addbttn last'));?>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            </div>
            
    </div>
    </div>
   
    <div class="panel panel-default">
  	<div class="panel-heading"> 
      <!-- panel-btns -->
      <h3 class="panel-title"><?php echo Yii::t('app','Edit Profile');?></h3>
      
    </div>
    <div class="panel-body">
    	<?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'students-form',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                )); ?>
         <h4><?php echo Yii::t('app','Personal Details'); ?></h4>    
    	<div class="row">
          <?php if(in_array('first_name', $student_visible_fields)){ ?>
        	  <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'first_name',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'first_name',array('class'=>'form-control','size'=>30,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'first_name'); ?>
                </div>
            </div>
          <?php } ?>

          <?php if(in_array('middle_name', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'middle_name',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'middle_name',array('class'=>'form-control','size'=>10,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'middle_name'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('last_name', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'last_name',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'last_name',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'last_name'); ?>
                </div>
            </div>
          <?php } ?>
          <?php if(in_array('national_student_id', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'national_student_id',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'national_student_id',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'national_student_id'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('date_of_birth', $student_visible_fields)){ ?>
        	  <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'date_of_birth',array('class'=>'control-label')); ?>
                  <?php 									
        					$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
        					if($settings!=NULL)
        					{
        						
        						$date = $settings->dateformat;
        						$model->date_of_birth=date($settings->displaydate,strtotime($model->date_of_birth));
        					}
        					else
        					{
        						$date = 'dd-mm-yy';
        					}
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
        					'class'=>'form-control'
        					),
        					));
        		
        					?>
        					<?php echo $form->error($model,'date_of_birth'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('gender', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'gender',array('class'=>'control-label')); ?>
                     <?php echo $form->dropDownList($model,'gender',array('M' => Yii::t('app','Male'), 'F' => Yii::t('app','Female')),array('class'=>'form-control mb15','empty' => Yii::t('app','Select Gender'))); ?>
                     <?php echo $form->error($model,'gender'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('blood_group', $student_visible_fields)){ ?>
             <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'blood_group',array('class'=>'control-label')); ?>
                    <?php echo $form->dropDownList($model,'blood_group',
                                    array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'),
                                    array('class'=>'form-control mb15','empty' => Yii::t('app','Unknown'))); ?>
                    <?php echo $form->error($model,'blood_group'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('birth_place', $student_visible_fields)){ ?>
        	  <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'birth_place',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'birth_place',array('class'=>'form-control','size'=>10,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'birth_place'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('nationality_id', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'nationality_id',array('class'=>'control-label')); ?>
                     <?php echo $form->dropDownList($model,'nationality_id',CHtml::listData(Nationality::model()->findAll(),'id','name'),array(
                                    'class'=>'form-control mb15','empty'=>Yii::t('app','Select Nationality')
                                    )); ?>
                     <?php echo $form->error($model,'nationality_id'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('language', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'language',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'language',array('class'=>'form-control','size'=>15,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'language'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('religion', $student_visible_fields)){ ?>
         	  <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'religion',array('class'=>'control-label')); ?>
                     <?php echo $form->textField($model,'religion',array('class'=>'form-control','size'=>10,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'religion'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('student_category_id', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'student_category_id',array('class'=>'control-label')); ?>
                    <?php 
										$category = StudentCategories::model()->findByAttributes(array('id'=>$model->student_category_id));
										 echo $form->textField($model,'student_category_name',array('class'=>'form-control','size'=>25,'maxlength'=>255,'disabled'=>true,'value'=>$category->name)); 
									?>
                    <?php echo $form->hiddenField($model,'student_category_id'); ?>
                </div>
            </div>
          <?php } ?>
          
          <!-- dynamic fields -->
          <?php
          $fields   = FormFields::model()->getDynamicFields(1, 1, "forStudentPortal");
          foreach ($fields as $key => $field) {
            if($field->form_field_type!=NULL){
              $this->renderPartial("application.modules.dynamicform.views.fields.student-portal-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
            }                                               
          }
          ?>
          <!-- dynamic fields -->

         </div>
          <h4>Contact Details</h4>
          <div class="row">          
          <?php if(in_array('address_line1', $student_visible_fields)){ ?>
          	<div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'address_line1',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'address_line1',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                     <?php echo $form->error($model,'address_line1'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('address_line2', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'address_line2',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'address_line2',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'address_line2'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('city', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'city',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'city',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'city'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('state', $student_visible_fields)){ ?>
          	<div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'state',array('class'=>'control-label')); ?>
                    <?php echo $form->textField($model,'state',array('class'=>'form-control','size'=>25,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'state'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('pin_code', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'pin_code',array('class'=>'control-label')); ?>
                     <?php echo $form->textField($model,'pin_code',array('class'=>'form-control','size'=>15,'maxlength'=>255)); ?>
                      <?php echo $form->error($model,'pin_code'); ?>
                </div>
            </div>
          <?php } ?>
          
          <?php if(in_array('country_id', $student_visible_fields)){ ?>
            <div class="col-sm-4">
            	<div class="form-group">
                	<?php echo $form->labelEx($model,'country_id',array('class'=>'control-label')); ?>
                     <?php //echo $form->textField($model,'country_id'); ?>
                                    <?php echo $form->dropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
                                    'class'=>'form-control mb15','empty'=>Yii::t('app','Select Country')
                                    )); ?>
                                    <?php echo $form->error($model,'country_id'); ?>
                </div>
            </div>
          <?php } ?>
          
            <?php if(in_array('phone1', $student_visible_fields)){ ?>
           		<div class="col-sm-4">
                    <div class="form-group">
                  	<?php echo $form->labelEx($model,'phone1',array('class'=>'control-label')); ?>
                       <?php echo $form->textField($model,'phone1',array('class'=>'form-control','size'=>15,'maxlength'=>255)); ?>
                      <?php echo $form->error($model,'phone1'); ?>
                  </div>
              </div>
            <?php } ?>
          
            <?php if(in_array('phone2', $student_visible_fields)){ ?>
              <div class="col-sm-4">
                  <div class="form-group">
                  	<?php echo $form->labelEx($model,'phone2',array('class'=>'control-label')); ?>
                       <?php echo $form->textField($model,'phone2',array('class'=>'form-control','size'=>15,'maxlength'=>255)); ?>
                         <?php echo $form->error($model,'phone2'); ?>
                  </div>
              </div>
            <?php } ?>
          
            <?php if(in_array('email', $student_visible_fields)){ ?>
              <div class="col-sm-4">
                  <div class="form-group">
                  	<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
                      <?php echo $form->textField($model,'email',array('class'=>'form-control','size'=>25,'maxlength'=>255,'disabled'=>true)); ?>
                       <?php echo $form->error($model,'email'); ?>
                  </div>
              </div>
            <?php } ?>

            <!-- dynamic fields -->
            <?php
            $fields   = FormFields::model()->getDynamicFields(1, 2, "forStudentPortal");
            foreach ($fields as $key => $field) {
              if($field->form_field_type!=NULL){
                $this->renderPartial("application.modules.dynamicform.views.fields.student-portal-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
              }                                               
            }
            ?>
            <!-- dynamic fields -->

           </div>
      </div>
      <div class="panel-footer">
      	<?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'btn btn-primary')); ?>
      </div>
</div> 
</div>
 <?php $this->endWidget(); ?> 
    
