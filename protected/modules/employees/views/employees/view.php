<?php
$this->breadcrumbs=array(
	Yii::t('app','Teachers')=>array('index'),
	Yii::t('app','View'),
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
 <?php $this->renderPartial('profileleft');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1 ><?php echo Yii::t('app','Teacher Profile :');?><?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
<div class="edit_bttns">
    <ul>
    <li><?php echo CHtml::link('<span>'.Yii::t('app','Edit').'</span>', array('update', 'id'=>$_REQUEST['id']),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
     <li><?php echo CHtml::link('<span>'.Yii::t('app','Teachers').'</span>', array('employees/manage'),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
    </ul>
    </div>
    
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    <div class="emp_tab_nav">
    <?php $this->renderPartial('tab');?>
   </div>
    <div class="clear"></div>
 <div class="emp_cntntbx">
    <div class="table_listbx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('app','General');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Join Date');?></td>
    <td class="subhdng_nrmal">
		<?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($model->joining_date)
			{
				if($settings!=NULL)
				{	
					$model->joining_date=date($settings->displaydate,strtotime($model->joining_date));
					
				}
				
				echo $model->joining_date;  
			}
		?>
	</td>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Department');?></td>
    <td class="subhdng_nrmal"><?php $dep=EmployeeDepartments::model()->findByAttributes(array('id'=>$model->employee_department_id));
							  if($dep!=NULL)
							  {
							  echo $dep->name;	
							  }
							  ?></td>
  </tr>

  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Category');?></td>
    <td class="subhdng_nrmal"><?php $cat=EmployeeCategories::model()->findByAttributes(array('id'=>$model->employee_category_id));
							  if($cat!=NULL)
							  {
							  echo $cat->name;	
							  }
							  ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Position');?></td>
    <td class="subhdng_nrmal"><?php $pos=EmployeePositions::model()->findByAttributes(array('id'=>$model->employee_position_id));
							  if($pos!=NULL)
							  {
							  echo $pos->name;	
							  }
							  ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Grade');?> </td>
    <td class="subhdng_nrmal"><?php $grd=EmployeeGrades::model()->findByAttributes(array('id'=>$model->employee_grade_id));
							  if($grd!=NULL)
							  {
							  echo $grd->name;	
							  }
							  ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Job Title');?></td>
    <td class="subhdng_nrmal"><?php echo $model->job_title; ?></td>
  </tr>
  <tr>
    
    <td class="listbx_subhdng"><?php echo Yii::t('app','Gender');?></td>
    <td class="subhdng_nrmal"><?php if($model->gender=='M')
										echo Yii::t('app','Male');
									else 
										echo Yii::t('app','Female');	 ?></td>
                                        
    <td class="listbx_subhdng"><?php echo Yii::t('app','Name of Spouse');?></td>
    <td class="subhdng_nrmal"><?php if($model->husband_name){ echo $model->husband_name; }else{ echo '--'; }  ?></td>
  </tr>
  <tr>
    <?php /*?><td class="listbx_subhdng"><?php echo Yii::t('app','Status');?></td>
    <td class="subhdng_nrmal"><?php echo $model->status; ?></td><?php */?>
    <td class="listbx_subhdng"><?php echo Yii::t('app','Qualification');?></td>
    <td class="subhdng_nrmal"><?php echo $model->qualification; ?>
	</td>
	<td class="listbx_subhdng"> <?php echo Yii::t('app','Total Experience');?> </td>
    <td class="subhdng_nrmal">
		<?php 
        if($model->experience_year and !$model->experience_month)
            echo $model->experience_year." ".Yii::t('app','year(s)');
        elseif(!$model->experience_year and $model->experience_month)
            echo ' '.$model->experience_month." ".Yii::t('app','month(s)');
        elseif($model->experience_year and $model->experience_month)
            echo $model->experience_year." ".Yii::t('app','year(s)')." ".Yii::t('app','and')." ".$model->experience_month." ".Yii::t('app','month(s)');
        else
            echo '-';
        ?>
    </td>
  </tr>
  
  <tr class="listbxtop_hdng">
  	 <td class="listbx_subhdng" colspan="4"><?php echo Yii::t('app','Experience Info');?></td>
  </tr>
  <tr>
    <td class="subhdng_nrmal" colspan="4" style="font-size:12px; line-height:18px; padding-right:20px; text-align:justify;"><?php echo $model->experience_detail; ?></td>
  </tr>
  </table>
  <div class="ea_pdf" style="top:4px; right:6px;"><?php echo CHtml::link(Yii::t('app','Generate PDF'), array('Employees/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank','class'=>'pdf_but')); ?></div>
   
 </div>
 
 </div>
</div>
</div>
</div>
    
    </td>
  </tr>
</table>