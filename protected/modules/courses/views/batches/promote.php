<style>
.errorSummary{
	margin-top:50px;
}
</style>
 <?php
$this->breadcrumbs=array(
	Yii::t('app','Courses')=>array('/courses'),
	Yii::t('app','Promote'),
);
?>
<?php $batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); ?>
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
	$is_create = PreviousYearSettings::model()->findByAttributes(array('id'=>1));
?>
          
<div style="background:#FFF; min-height:800px;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td  valign="top">
                <?php 
				if($batch!=NULL)
                {
                ?>
                    <div style="padding:20px;">
                        <h1><?php echo Yii::t('app','Manage').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></h1>
                        <!--<div class="searchbx_area">
                        <div class="searchbx_cntnt">
                        <ul>
                        <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                        <li><input class="textfieldcntnt"  name="" type="text" /></li>
                        </ul>
                        </div>
                        
                        </div>-->
                        
                        
                        
                        <!--<div class="edit_bttns">
                        <ul>
                        <li>
                        <a href="#" class=" edit last">Edit</a>    </li>
                        </ul>
                        </div>-->
                        
                        
                        <div class="clear"></div>
                        <div class="emp_right_contner">
                            <div class="emp_tabwrapper">
								<?php $this->renderPartial('tab');?>
                                <div style="position:relative;">
                                	<?php
									if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_create->settings_value!=0))
									{
									?>
                                	<div class="edit_bttns" style="top:12px; right:20px;">
                                        <ul>
                                            <li>
                                            <?php echo CHtml::ajaxLink('<span>'.Yii::t('app','Add New').' '. Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</span>',$this->createUrl('batches/Addnew'),array('onclick'=>'$("#jobDialog").dialog("open"); return false;','update'=>'#jobDialog','type' =>'GET','data' => array( 'val1' =>$batch->course_id ),'dataType' => 'text'),array('id'=>'showJobDialog1','class'=>'addbttn last')); ?>
                                            </li>
                                        </ul>
                                        <div class="clear"></div>
                                    </div>
                                    <?php
									}
									?>
                                </div>
                                <?php $this->beginWidget('CActiveForm') ?>
                                
                                <?php
                                /* Error Message */
                                if(Yii::app()->user->hasFlash('errorMessage')): 
                                ?>
                                    <br/>
                                    <div class="errorSummary">
                                    <?php echo Yii::app()->user->getFlash('errorMessage'); ?>
                                    </div>
                                <?php endif;
                                /* End Error Message */
                                ?>
                                
                            	<h1><?php echo Yii::t('app','Promote').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></h1>
                                
                                <div class="formCon" style="margin-bottom:10px; position:relative;margin-top:10px;">
                                    <div class="formConInner">
                                         <!-- END div class="edit_bttns" -->
                                        <table width="98%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
												<td><strong><?php echo Yii::t('app','Select Action'); ?></strong></td>
                                                <td>
													<?php 
                                                    $actions = PromoteOptions::model()->findAll(array('condition'=>'option_value <> "In Progress"'));
													$options = CHtml::listData($actions,'option_value','option_name');
                                                    echo CHtml::dropDownList('action', (isset($_POST['action']))?$_POST['action']:'', $options,array('id'=>'action_drop','prompt'=>Yii::t('app','Select'))); 
                                                    ?>
                                                </td>
                                                <td><strong><?php echo Yii::t('app','Select Academic Year'); ?></strong></td>
                                                <td>
													<?php
                                                    $years = AcademicYears::model()->findAll("is_deleted=:x ORDER BY id DESC", array(':x'=>0));
                                                    $data =  CHtml::listData($years,'id','name');
                                                    echo CHtml::dropDownList('year',(isset($_POST['year']))?$_POST['year']:'',$data,array('prompt'=>Yii::t('app','Select'),
                                                    'ajax' => array(
                                                    'type'=>'POST',
                                                    'url'=>CController::createUrl('batches/academicbatches'),
                                                    'update'=>'#batch_id',
                                                    'data'=>array('year'=>'js:this.value','id'=>$_REQUEST['id'])),
													'disabled'=>(isset($_POST['action']) and ($_POST['action']==-1 or $_POST['action']==1))?false:true,
													'style'=>'width:270px;',
													'id'=>'year_drop',
													'options' => array($batch_id=>array('selected'=>true))));
                                                    ?>
                                                </td>
                                                <td><strong><?php echo Yii::t('app','Select').' '. Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></strong></td>
                                                <td>
													<?php 
                                                    $data1 = CHtml::listData(Batches::model()->findAll(array('order'=>'name ASC', 'condition'=>'is_deleted=0')),'id','coursename');
                                                    echo CHtml::dropDownList('batch_id',(isset($_POST['batch_id']))?$_POST['batch_id']:'',$data1,array('prompt'=>Yii::t('app','Select'),'id'=>'batch_id','disabled'=>(isset($_POST['action']) and ($_POST['action']==-1 or $_POST['action']==1))?false:true,)); 
													
                                                    ?>
                                                </td>
                                                
                                                
                                                <td>&nbsp;</td>
                                                <td>
                                                	<?php echo CHtml::submitButton(Yii::t('app','Save'),array('name'=>'promote','id'=>'1','class'=>'add','confirm'=>Yii::t('app','Are you sure you want to save?'),'class'=>'formbut')); ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div> <!-- END div class="formConInner" -->
                                    
                                </div> <!-- END div class="formCon" -->
                                
                                
                                <!--<div class="c_subbutCon" align="right" style="width:100%">
                                <div class="c_cubbut" style="width:120px;">
                                <ul>
                                <li>
                                <?php /*?><?php echo CHtml::link('Add Student', array('/students/students/create'),array('class'=>'addbttn last'));?><?php */?>
                                </li>
                                </ul>
                                <div class="clear"></div>
                                </div>
                                </div>-->
                                
                                <div class="table_listbx1" >
									<?php
                                    if(isset($_REQUEST['id']))
                                    {
                                        $posts = Yii::app()->getModule('students')->studentsOfBatch($_REQUEST['id']);
										if($posts!=NULL)
										{
										?>
                                            <div class="pdtab_Con" style="padding-top:0px;">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tr class="pdtab-h">
                                                        <td >&nbsp;</td>
                                                        <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                        { ?>
                                                        <td style="padding-left:20px;"><?php echo Yii::t('app','Student Name');?></td><?php } ?>
                                                        <td style="padding-left:20px;"><?php echo Yii::t('app','Admission Number');?></td>  
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="padding:8px 0 8px 20px;" >
                                                        <?php $posts1=CHtml::listData($posts, 'id', 'Fullnames');?>
                                                        <?php
                                                        echo CHtml::checkBoxList('sid','',$posts1, array('id'=>'1','template' => '{input}{label}</td></tr><tr><td width="10%" style="padding:0 0 10px 20px;" class="rbr">','checkAll' => Yii::t('app','All'))); ?>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>
										<?php    	
										} // END if $posts!=NULL
										else
										{
											echo '<br><div class="notifications nt_red" style="padding-top:10px"><i>'.Yii::t('app','No Active Students In This').' ',Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").'</i></div>'; 
										}
                                    
                                    } // END isset($_REQUEST['id'])
                                    ?>
                                    
                                    <?php $this->endWidget(); ?>
                                    <div id="jobDialog"></div>
                                
                                </div> <!-- END div class="table_listbx1" -->
                            </div> <!-- END div class="emp_tabwrapper" -->
                        </div> <!-- END div class="emp_right_contner" -->
                    </div>
                
                <?php    	
                } // END if($batch!=NULL)
                else
                {
					echo '<div class="emp_right" style="padding-left:20px; padding-top:50px;">';
					echo '<div class="notifications nt_red">'.'<i>'.Yii::t('app','Nothing Found!').'</i></div>'; 
					echo '</div>';
                }
                ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
$("#action_drop").change(function(){
	if($(this).val()!="" && $(this).val()==2){
		$("#year_drop").prop("disabled", true);
		$("#batch_id").prop("disabled", true);		
	}
	else{
		$("#year_drop").prop("disabled", false);
		$("#batch_id").prop("disabled", false);
	}
	
});
</script>
