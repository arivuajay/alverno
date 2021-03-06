<style>
.formCon input[type="text"], input[type="password"], textArea, select {padding:6px 3px 6px 3px; width:140px;}
.exp_but { right:68px; margin:0px 2px !important;}
</style>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Rooms')=>array('/hostel'),
	Yii::t('app','Room Search'),
);?>
 <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('/settings/hostel_left');?>
 </td>
    <td valign="top"> 
    <div class="cont_right">
     <h1><?php echo Yii::t('app','Search Rooms');?></h1>
     <div class="formCon">
     <div class="formConInner">
     <table width="60%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Select Hostel')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo CHtml::dropDownList('hostel','',CHtml::listData(Hosteldetails::model()->findAll('is_deleted=:x',array(':x'=>'0')),'id','hostel_name'),array('prompt'=>Yii::t('app','Select'),
'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/hostel/room/allot'),
	'update'=>'#floorid',
	'data'=>'js:$(this).serialize()')));?>
		</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Select Floor')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo CHtml::dropDownList('floor','',array(),array('prompt'=>Yii::t('app','Select'),'id'=>'floorid','ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('/hostel/room/room'),
	'update'=>'#roomid',
	'data'=>'js:$(this).serialize()')));?>
	
		</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><?php echo $form->labelEx($model,Yii::t('app','Select Room No')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo CHtml::dropDownList('room_no','',array(),array('prompt'=>Yii::t('app','Select'),'id'=>'roomid',)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo Yii::t('app','Name');?></td>
    <td>&nbsp;</td>
    <td><div style="position:relative;">
		<?php 
		$this->widget('zii.widgets.jui.CJuiAutoComplete',
						array(
						  'name'=>'name',
						  'id'=>'name_widget',
						  'source'=>$this->createUrl('/site/autocomplete'),
						  'htmlOptions'=>array('placeholder'=>Yii::t('app','Student Name'),'style'=>'width:132px;padding:5px 3px;'),
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
		<?php echo CHtml::ajaxLink('',array('/site/explorer','widget'=>'1'),array('update'=>'#explorer_handler'),array('id'=>'explorer_student_name','class'=>'exp_but'));?>
	</div></td>
  </tr>
          
          <tr>
            	<td><div style="position:relative;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td></td>
    <td> </td>
    <td></td>
  </tr>
</table>

                
       </div></td>
                <!-- <input type="text" name="studentname"  style="width:130px;"/>-->
            	<td>&nbsp;</td>
           		 <td><?php //echo CHtml::activeDropDownList($model,'floor',CHtml::listData(Floor::model()->findAll(),'id','floor_no'),array('prompt'=>'Select')); ?></td>
           		 <td>&nbsp;</td>
            	<td> </td>
            	<td width="5%">&nbsp;</td>
          </tr>
          <tr>
            	<td><div style="margin-top:10px;"><?php echo CHtml::submitButton( Yii::t('app','Search'),array('name'=>'search','class'=>'formbut')); ?></div> </td>
          </tr>
       </table>
        </div>
            </div>
       <?php
			if(isset($list))
			{
		?>
             <h3><?php echo Yii::t('app','Search Results');?></h3>
             
        <?php
		?>					<div class="pdtab_Con" style="padding:0px;">
                    		<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr class="pdtab-h">
                                                                    <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                                        { ?>
									<td align="center"><?php echo Yii::t('app','Student name');?></td>
                                                                        <?php } ?>
                                     <td align="center"><?php echo Yii::t('app','Hostel');?></td>
                                    <td align="center"><?php echo Yii::t('app','Floor');?></td>
                                    <td align="center"><?php echo Yii::t('app','Room No.');?></td>
									<td align="center"><?php echo Yii::t('app','Bed No.');?></td>
									
								</tr>
               		 			<?php
								
									if($list==NULL)
									{
									echo '<tr><td align="center" colspan="5"><strong>'.Yii::t('app','No such student is using the hostel facility.').'</strong></td></tr>';
									}
									else
									{
										foreach($list as $list_1)
										{
											
											$student=Students::model()->findByAttributes(array('id'=>$list_1->student_id));
											$room=Room::model()->findByAttributes(array('id'=>$list_1->room_no));
											$floordetails=Floor::model()->findByAttributes(array('id'=>$room->floor));
											$hostel=Hosteldetails::model()->findByAttributes(array('id'=>$room->hostel_id));
								?>
                				<tr>
                                                    <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                    { ?>
                					<td align="center"><?php if($student!=NULL){ 
                                                            $name='';
                                                            $name=  $student->studentFullName('forStudentProfile');
                                                            echo $name;
                                                           // echo $student->last_name.' '.$student->first_name; 
                                                           } else
                                                            
                                                    { echo Yii::t('app','Not allotted'); }?></td><?php } ?>
                                   <td align="center"><?php echo $hostel->hostel_name;?></td>
                                    <td align="center"><?php echo $floordetails->floor_no;?></td>
                					<td align="center"><?php echo  $room->room_no;?></td>
                                    <td align="center"><?php echo $list_1->bed_no;?></td>
               						
               				 </tr>
                  			 <?php
										
										
									}
							}
							?>
                			</table>
                			<?php
				}
			
			?>
            </div>
            </div>
           
            </td>
            </tr>
            </table>
    <?php $this->endWidget(); ?>