<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic' rel='stylesheet' type='text/css'>

<style>
	.guard_search
	{
		position:relative;
		width:auto;
		padding-left:5px;
		padding-right:27px;
	}
	
	.radio_bx
	{
		margin:0px;
		padding:0px;
	}
	
	input[type="radio"] {
    display:none;
	}

	input[type="radio"] + label {
		font-family: 'Open Sans', sans-serif;
		font-size:15px;
		font-weight:600;
		color:#be8b05;
		padding:10px 0px 10px 0px;
	}
	
	input[type="radio"] + label span {
		display:inline-block;
		width:22px;
		height:22px;
		margin:-1px 4px 0 0;
		vertical-align:middle;
		background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/radio_btn_css3.png) -48px top no-repeat;
		cursor:pointer;
		padding-left:10px;
	}
	
	input[type="radio"]:checked + label span {
		background:url(<?php echo Yii::app()->request->baseUrl; ?>/images/radio_btn_css3.png) 0px top no-repeat;
	}
	div#show {
    padding:10px;
   
  
	}
	.formConInner {
    padding: 15px;
    position: relative;
   
	}

 	.formCon
	{
		margin-bottom:20px;
	}



</style>

<script>
	/*jQuery.fn.reset = function () {
	  $(this).each (function() { this.reset(); });
	}*/
	function getmode()
	{
		var guardian_mode =$('input[name=guardian]:checked').val();
		//alert(guardian_mode);
		if(guardian_mode == 1)
		{
			$( "#search" ).show("slow");
			//$( "#new_guardian").hide();	
			//$( "#existing_guardian").show();	
		}
		else
		{
		
			var ward_id = $( "#Guardians_ward_id" ).val();
			$( "#search" ).hide("slow",function(){
				window.location= "index.php?r=students/guardians/create&id="+ward_id;
			});
			/*$( "#search" ).hide("slow");
			$('#guardians-form').find("input[type=text],textarea,select").val("");	
			$( "#new_guardian").show();
			$( "#existing_guardian").hide();	*/
		}
		
	}
</script>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Guardians')=>array('admin'),
	Yii::t('app','Create'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    	<?php $this->renderPartial('/default/left_side');?>
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
        <h1><?php echo Yii::t('app','New Admission');?></h1>
        <div class="captionWrapper">
        <ul>
           
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Details'),array('students/update','id'=>$_REQUEST['id'],'status'=>0)); } else{ echo Yii::t('app','Student Details'); } ?></h2></li>
        <li><h2 class="cur" ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Parent Details'),array('guardians/create','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Parent Details'); } ?></h2></li>            
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Emergency Contact'),array('guardians/addguardian','id'=>$_REQUEST['id'])); } else { echo Yii::t('app','Emergency Contact'); } ?></h2></li>        
        <li><h2 ><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Previous Details'),array('studentPreviousDatas/create','id'=>$_REQUEST['id'])); }else { echo Yii::t('app','Previous Details'); }?></h2></li>        
        <li><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Documents'),array('studentDocument/create','id'=>$_REQUEST['id'])); }else { echo Yii::t('app','Student Documents'); }?></h2></li>        
        <li class="last"><h2><?php if(isset($_REQUEST['id'])){ echo CHtml::link(Yii::t('app','Student Profile'),array('students/view','id'=>$_REQUEST['id'])); } else{ echo Yii::t('app','Student Profile'); } ?></h2></li>
        </ul>
        </div>
        <!-- Radio Box -->
        <div class="formCon_existng_g">
        
       	<div class="formConInner" style="padding:0px; width:auto;">
        <div style="padding:15px 15px 15px 15px;">
        	<?php 
			if($radio_flag == 1)
			{
				$radio1 = true;
				$radio2 = false;
				$style = 'display:block;';
				
				
			}
			else
			{
				$radio1 = false;
				$radio2 = true;
				$style = 'display:none;';
			}
			
		   
			// Already Existing Guardian Radio Button
			echo CHtml::radioButton('guardian', $radio1, array(
			'checked' =>true,
			'id'=>'guardian1',
			'value' => '1',
			'labelOptions'=>array('style'=>'display:inline;padding-right:20px;'), 
			'onchange'=>'getmode();',
			)); ?><label for="guardian1"><span></span><?php echo Yii::t('app','Already Existing Parent'); ?></label>

			<!-- END Already Existing Guardian Radio Button -->
			  </div>
			
        </div> <!-- END div class="formCon_existng_g" -->
        
        
			<!-- END Search Guardian -->
        
        </div>
    
        	<!-- Search Guardian -->
			<?php 
			$form=$this->beginWidget('CActiveForm', array(
			'id'=>'guardians-search-form',
			'enableAjaxValidation'=>false,
			)); 
			?>
          
			<div class="formCon" id="search" style=" <?php echo $style; ?>; margin-bottom:0px; margin-top:0px;">
				<div class="formConInner">
					<?php echo Yii::t('app','Search'); ?>
					<span class="guard_search">
						<?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						'name'=>'student_name',
						'id'=>'name_widget',
						'source'=>$this->createUrl('/site/autocomplete'),
						'htmlOptions'=>array('placeholder'=>Yii::t('app','Sibilings')),
						'options'=>
						array(
						'showAnim'=>'fold',
						'select'=>"js:function(student, ui) {
						$('#id_widget').val(ui.item.id);
						
						}"
						),
						
						));
						?>
						<?php echo CHtml::hiddenField('student_id','',array('id'=>'id_widget')); ?> 
                         <span class="or_img"></span>                   
					</span>
                   
					
					<span class="guard_search">
						<?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						'name'=>'parent_name',
						'id'=>'parent_name_widget',
						'source'=>$this->createUrl('/site/parentautocomplete'),
						'htmlOptions'=>array('placeholder'=>Yii::t('app','Parent')),
						'options'=>
						array(
						'showAnim'=>'fold',
						'select'=>"js:function(parent, ui) {
						$('#guardian_id').val(ui.item.id);
						
						}"
						),
						
						));
						?>
						<?php echo CHtml::hiddenField('guardian_id','',array('id'=>'guardian_id')); ?> 
                         <span class="or_img"></span>                       
					</span>
					
					<span class="guard_search" style="padding-right:10px;">
						<?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						'name'=>'parent_email',
						'id'=>'parent_email_widget',
						'source'=>$this->createUrl('/site/parentemailcomplete'),
						'htmlOptions'=>array('placeholder'=>Yii::t('app','Parent Email')),
						'options'=>
						array(
						'showAnim'=>'fold',
						'select'=>"js:function(parentemail, ui) {
						$('#guardian_mail').val(ui.item.id);
						
						}"
						),
						
						));
						?>
						<?php echo CHtml::hiddenField('guardian_mail','',array('id'=>'guardian_mail')); ?>                    
					</span>
                    <div class="clear"></div>
					<div style="margin-top:10px; margin-left:49px;"><?php echo CHtml::button(Yii::t('app','Select'), array('submit' => array('guardians/create','id'=>$_REQUEST['id']),'class'=>'formbut')); ?></div>
				</div>
			</div>
			<?php $this->endWidget(); ?>
           
        
        <div class="formCon_existng_g">
            <div class="formConInner">
            	<div class="tableinnerlist">
                       <!-- <input type="radio" id="r1" name="rr" />
                        <label for="r1"><span></span>Already Existing Guardian</label>-->
   					
					<?php
					// New Guardian Radio Button
                    echo CHtml::radioButton('guardian',$radio2, array(
                        'value' => '0', 'uncheckValue' => null,
						'id'=>'guardian2',
                        'labelOptions'=>array('style'=>'display:inline;padding-right:20px;'), 
                        'onchange'=>'getmode();',
                    ));?><label for="guardian2"><span></span><?php echo Yii::t('app','New Parent'); ?></label>
                  	<!-- END New Guardian Radio Button -->
        		</div>
            </div>
		</div>
        <!-- END Radio Box -->
       
        
        <?php 
        
        if(Yii::app()->controller->action->id == 'update')
        {
            $this->renderPartial('guardian_list',array('id'=>$_REQUEST['sid']));
        }
        else
        {
            $this->renderPartial('guardian_list',array('id'=>$_REQUEST['id']));
        } ?>
        
        
         <?php
        if($guardian_id)
        {
			//echo $guardian_id;
        	echo $this->renderPartial('_form', array('model'=>$model,'check_flag'=>$check_flag,'guardian_id'=>$guardian_id));  
        }
		else
		{
			echo $this->renderPartial('_form', array('model'=>$model,'check_flag'=>$check_flag)); 
		}
         ?>
 	</div>
    </td>
  </tr>
</table>