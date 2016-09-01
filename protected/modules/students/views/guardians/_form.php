<style type="text/css">
.ui-widget-content a {
    color: #9b9b9b !important;
}

.ui-widget-content{ height:300px;
	overflow:scroll;}

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
<script>
    $(document).ready(function()
    {
        if($('#relation_dropdown').val()=="Others")
        {
            $( "#relation_other" ).show();
        }        
        $('#relation_dropdown').change(function()
        {
            if(this.value=="Others")           
                $( "#relation_other" ).show("slow");            
            else
            $( "#relation_other" ).hide("slow");            
        })
    });
</script>
<?php
	/*$fieldsss	= Guardians::model()->getFields();
	foreach ($fieldsss as $key => $value) {
		# code...
		echo $value->varname."<br />";
	}*/
?>
<?php if(!Yii::app()->controller->action->id=='update') { ?>


<?php } ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'guardians-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php if($form->errorSummary($model)){; ?>
    
    <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
    <span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
    </div>
    <?php } ?>
<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
<p class="note"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?>
<?php
if(Yii::app()->user->hasFlash('errorMessage')): ?>
<span class="flash" style="background:#FFF; padding-left:100px; color:#C00;font-size:14px">
	<?php echo Yii::app()->user->getFlash('errorMessage'); ?>
</span>
<?php endif;
?>	
</p>

<div class="formCon">

<div class="formConInner">

	
<h3><?php echo Yii::t('app','Parent - Personal Details');?></h3>
	
	<?php if(FormFields::model()->isVisible('first_name','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>25,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('last_name','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('relation','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php 
		//for hide relation field - guardian list edit
		if(isset($_REQUEST['sid']) or isset($_REQUEST['s_id']) or Yii::app()->controller->action->id=='create')
		{ ?>
		<?php echo $form->labelEx($model,'relation'); ?>
		<?php } ?>
		 <?php if(isset($_REQUEST['sid']) or isset($_REQUEST['s_id']) or Yii::app()->controller->action->id=='create')
	    { ?>
	    
	    <?php 
	    if(Yii::app()->controller->action->id=='update')
	    {
	        $list= $model->Guard_relations(); 
	        if($model->relation!= "Father" AND $model->relation!='Mother')
	        {
	            $model->relation= "Others";
	            $glist= GuardianList::model()->findByAttributes(array('guardian_id'=>$model->id, 'student_id'=>$_REQUEST['s_id']));
	            if($glist)
	            {
	                $model->relation_other= $glist->relation;
	            }
	        }
	        
	    }else {
	    $list= $model->Guardian_relations(); }
	    
    
    	echo $form->dropDownList($model,'relation',$list,array('id'=>'relation_dropdown','empty'=>Yii::t('app','Select'))); ?>
		<?php echo $form->error($model,'relation'); ?>
		<div id="relation_other" style="display: none">
              <?php echo $form->labelEx($model,'relation_other'); ?>
              <?php echo $form->textField($model,'relation_other',array('size'=>15,'maxlength'=>255)); ?>
              <?php echo $form->error($model,'relation_other'); ?>
          </div>
		  <?php } ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('dob','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model, 'dob'); ?>
		<?php 
			$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL){
				$date=$settings->dateformat;               
		                if($model->dob!=NULL)
		                {
		                   
		                    $model->dob= date($settings->displaydate,  strtotime($model->dob));
		                }
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
                'style'=>'height:15px;',
				'readonly'=>true
                ),
            ));
		?>
		<?php echo $form->error($model,'dob'); ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('education','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model,'education'); ?>
		<?php echo $form->textField($model,'education',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'education'); ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('occupation','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model,'occupation'); ?>
		<?php echo $form->textField($model,'occupation',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'occupation'); ?>
	</div>
	<?php } ?>

	<?php if(FormFields::model()->isVisible('income','Guardians','forAdminRegistration')){ ?>
	<div class="txtfld-col">
		<?php echo $form->labelEx($model,'income'); ?>
		<?php echo $form->textField($model,'income',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'income'); ?>
	</div>
	<?php } ?>

	<!-- dynamic fields -->
    <?php
    $fields     = FormFields::model()->getDynamicFields(2, 1, "forAdminRegistration");
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
<h3><?php echo Yii::t('app','Parent - Contact Details'); ?></h3>

<?php if(FormFields::model()->isVisible('email','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'email'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('mobile_phone','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col">
	<?php echo $form->labelEx($model,'mobile_phone'); ?>
	<?php echo $form->textField($model,'mobile_phone',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'mobile_phone'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('office_phone1','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col">
	<div class="hide">
		<?php echo $form->labelEx($model,'office_phone1'); ?>
		<?php echo $form->textField($model,'office_phone1',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'office_phone1'); ?>
	</div>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('office_phone2','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col">
	<div class="hide">
		<?php echo $form->labelEx($model,'office_phone2'); ?>
		<?php echo $form->textField($model,'office_phone2',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'office_phone2'); ?>
	</div>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('office_address_line1','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col hide">
	<?php echo $form->labelEx($model,'office_address_line1'); ?>
	<?php echo $form->textField($model,'office_address_line1',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'office_address_line1'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('office_address_line2','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col hide">
	<?php echo $form->labelEx($model,'office_address_line2'); ?>
	<?php echo $form->textField($model,'office_address_line2',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'office_address_line2'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('city','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col hide">
	<?php echo $form->labelEx($model,'city'); ?>
	<?php echo $form->textField($model,'city',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'city'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('state','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col hide">
	<?php echo $form->labelEx($model,'state'); ?>
	<?php echo $form->textField($model,'state',array('size'=>15,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'state'); ?>
</div>
<?php } ?>

<?php if(FormFields::model()->isVisible('country_id','Guardians','forAdminRegistration')){ ?>
<div class="txtfld-col hide">
	<?php echo $form->labelEx($model,'country_id'); ?>
	<?php echo $form->dropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array(
									'style'=>'width:130px;','empty'=>Yii::t('app','Select Country')
								)); ?>
	<?php echo $form->error($model,'country_id'); ?>
</div>
<?php } ?>

<!-- dynamic fields -->
<?php
$fields     = FormFields::model()->getDynamicFields(2, 2, "forAdminRegistration");
foreach ($fields as $key => $field) {
    if($field->form_field_type!=NULL){
        $this->renderPartial("application.modules.dynamicform.views.fields.admin-form._field_".$field->form_field_type, array('model'=>$model, 'field'=>$field));                                                
    }                                               
}
?>
<!-- dynamic fields -->

<div class="clear"></div>
<div class="txtfld-col">
	<?php 
		if($model->isNewRecord){
                    
                  $parent_mdl= GuardianList::model()->findAllByAttributes(array('student_id'=>$_REQUEST['id']));
                 if($parent_mdl)
                 {
                     $checked= 'true';
                 }
                // if(!$parent_mdl)
                     {  
                    
			if($check_flag == 1 ){
		?>
				<span style="float:left;"><?php echo $form->checkBox($model,'user_create',array('id'=>'user_create','checked'=>'true')); ?></span>
		<?php
			}
			else{
		?>
				<span style="float:left;"><?php echo $form->checkBox($model,'user_create',array('id'=>'user_create','checked'=>$checked)); ?></span>
		<?php
			}
		?>
                        <?php echo '<h3>'.$form->labelEx($model,Yii::t('app','Don\'t create parent user')).'</h3>'; ?>
                        <?php echo $form->error($model,'user_create'); 
                               } 
		}?>
</div>
<div class="clear"></div>


	<div class="row">
		<?php //echo $form->labelEx($model,'ward_id'); ?>
        <?php 
		if(Yii::app()->controller->action->id == 'create')
		{
		?>
			<?php echo $form->hiddenField($model,'ward_id',array('value'=>$_REQUEST['id'])); ?>
		<?php 
		}
                else if(Yii::app()->controller->action->id == 'update')
		{
		?>
			<?php echo $form->hiddenField($model,'ward_id',array('value'=>$_REQUEST['sid'])); ?>
		<?php 
		}
		else
		{
			echo $form->hiddenField($model,'ward_id',array('value'=>$_REQUEST['std']));
		}
		 ?>
		<?php echo $form->error($model,'ward_id'); ?>
	</div>


	<div class="row">
		<?php //echo $form->labelEx($model,'created_at'); ?>
         <?php  if(Yii::app()->controller->action->id == 'create')
		{
		 echo $form->hiddenField($model,'created_at',array('value'=>date('d-m-Y')));
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
		<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('d-m-Y'))); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>
	<input type="hidden" name="which_btn" id="which_btn" />
	
</div>
</div><!-- form -->
<div class="clear"></div>
<?php
if($guardian_id)
{
	$display_existing = 'display:block;';
	$display_new = 'display:none;';
}
else
{
	$display_existing = 'display:none;';
	$display_new = 'display:block;';
}
?>

<div id="new_guardian" style="padding:0px 0 0 0px; text-align:left; position: relative; <?php echo $display_new; ?>">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Save') : Yii::t('app','Save'),array('class'=>'formbut')); ?>
        <?php if(Yii::app()->controller->action->id=='create'){ ?>
            <span>	
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Save and Continue') : Yii::t('app','Save and Continue'),array('id'=>'cnt_btn','class'=>'formbut')); ?>
            </span> 
		<?php } ?>           
<div style="position:absolute; right:-2px;bottom:13px;">
<?php
//check guardian exist in students table.
//if guardian exist, show emergency contact button
$models= Students::model()->findByPk($_REQUEST['id']);
if(isset($models->parent_id))
{
    echo CHtml::link(Yii::t('app',"Skip"),array('addguardian','id'=>$_REQUEST['id']),array('class'=>'formbut'));
    ?>
        
        <?php
}
?>
</div>
</div>
<div id="existing_guardian" style="padding:0px 0 0 0px; text-align:left; <?php echo $display_existing; ?>">
		<?php 
		
			//echo $guardian_id;
                if(Yii::app()->controller->action->id == 'update')
                {
                    echo CHtml::submitButton(Yii::t('app','Save'),array('submit' =>CController::createUrl('/students/guardians/update',array('id'=>$guardian_id,'sid'=>$_REQUEST['sid'])),'class'=>'formbut')); 
                }
                else
			echo CHtml::submitButton(Yii::t('app','Save'),array('submit' =>CController::createUrl('/students/guardians/update',array('id'=>$guardian_id,'sid'=>$_REQUEST['id'])),'class'=>'formbut')); 
		?>
		
		
</div>
<?php $this->endWidget(); ?>
<?php if($model->same_address == 1){ ?>
	<script type="text/javascript">
		$('#Guardians_same_address').prop('checked',true);
		$('.hide').hide();		
	</script>		
<?php } ?>

<script type="text/javascript">
$('input[type="checkbox"]#Guardians_same_address').change(function(e) {
	var that	= this;
    if($(that).is(':checked')){
		$('.hide').hide();				
	}else{
		$('.hide').show();	
		$('.hide').find('select,input').val('');	
	}
});
$('#which_btn').val('0');
$('#cnt_btn').click(function(ev) {
	$('#which_btn').val('1');
});
</script>

