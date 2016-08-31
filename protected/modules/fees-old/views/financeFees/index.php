<?php
$this->breadcrumbs=array(
	Yii::t('app','Fees')=>array('/fees'),
	Yii::t('app','Fees Collection'),
	
);?>
<script language="javascript">
function batch()
{
var id = document.getElementById('batch').value;
window.location= 'index.php?r=fees/financeFees/index&batch='+id;	
}
function category()
{
var id_1 = document.getElementById('batch').value;
var id = document.getElementById('category').value;
window.location= 'index.php?r=fees/financeFees/index&batch='+id_1+'&collection='+id;	
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
    <h1><?php echo Yii::t('app','Fees Collection');?></h1>
    <div class="formCon" style="padding:3px;">
    <div class="formConInner" style="padding:3px 10px;">
    <table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

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
$data = CHtml::listData(Batches::model()->findAll("is_active=:x and is_deleted=:y and academic_yr_id =:z", array(':x'=>1,':y'=>0,':z'=>$year)),'id','coursename');
if(isset($_REQUEST['batch']))
{
	$sel= $_REQUEST['batch'];
}
else
{
	$sel='';
}
echo '<span style="font-size:14px; font-weight:bold; color:#666;">'.Yii::t('app','Batch').'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
echo CHtml::dropDownList('id','',$data,array('prompt'=>Yii::t('app','Select'),'onchange'=>'batch()','id'=>'batch','options'=>array($sel=>array('selected'=>true)))); 
echo '</td><td style="padding-top:13px;">';
?>

<?php
$data_1 = array();
if(isset($_REQUEST['batch']))
{
	$data_1 = CHtml::listData(FinanceFeeCollections::model()->findAll("batch_id=:x", array(':x'=>$_REQUEST['batch'])),'id','name');

}
if(isset($_REQUEST['collection']))
	{
		$sel_1= $_REQUEST['collection'];
	}	
	else
	{
	$sel_1 = '';	
	}
echo '<span style="font-size:14px; font-weight:bold; color:#666;">'.Yii::t('app','Collection').' </span>&nbsp;&nbsp;&nbsp;&nbsp;';
echo CHtml::dropDownList('id','',$data_1,array('prompt'=>Yii::t('app','Select'),'onchange'=>'category()','id'=>'category','options'=>array($sel_1=>array('selected'=>true)))); 
echo '<br/><br/>';
?>
<td>
		 </tr>
	</table>
	</div></div>
<?php

$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));

if($year != $current_academic_yr->config_value and $is_insert->settings_value==0)
{	
?>
<div>
	<div class="yellow_bx" style="background-image:none;width:95%;padding-bottom:45px;">
		<div class="y_bx_head" style="width:95%;">
		<?php 
			echo Yii::t('app','You are not viewing the current active year. ');
			echo Yii::t('app','To collect the fees, enable the Insert option in Previous Academic Year Settings.');	
		?>
		</div>
		<div class="y_bx_list" style="width:95%;">
			<h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
		</div>
	</div>
</div> <br />
<?php	
}
?>

<?php if(isset($_REQUEST['batch']) && isset($_REQUEST['collection']))
{ 
	$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
	//$particular = FinanceFeeParticulars::model()->findByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id));
	$particular = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
	$currency=Configurations::model()->findByPk(5);
	if(count($particular)!=0)
	{
		//$amount = 0;
		$list  = FinanceFees::model()->findAll("fee_collection_id=:x", array(':x'=>$_REQUEST['collection']));
		?>
		
	   <div class="tableinnerlist"> 
		<table width="80%" cellspacing="0" cellpadding="0">
			<tr>
			 <th><strong><?php echo Yii::t('app','Sl no.');?></strong></th>
			 <th><strong><?php echo Yii::t('app','Particulars');?></strong></th>
			 <th><strong><?php echo Yii::t('app','Applicable For');?></strong></th>
			  <th><strong><?php echo Yii::t('app','Amount');?></strong></th>
			</tr>
			<?php 
			$i = 1;
				foreach($particular as $particular_1) { ?>
			<tr>
			 <td><?php echo $i; ?></td>
			 <td><?php echo $particular_1->name; ?></td>
			 <td>
				<?php 
					if(($particular_1->student_category_id==NULL or $particular_1->student_category_id==0) and ($particular_1->admission_no==NULL or $particular_1->admission_no==0)) {
						echo Yii::t('app','All'); 
				 }
					elseif(($particular_1->student_category_id!=NULL) and $particular_1->admission_no!==NULL ) {
						$student_category = StudentCategories::model()->findByAttributes(array('id'=>$particular_1->student_category_id));
						echo Yii::t('app','Category:').' '.$student_category->name; 
				 }
					elseif(($particular_1->student_category_id==NULL or  $particular_1->student_category_id==0) and $particular_1->admission_no!=NULL or $purticular_1->admission_no==0){
						echo Yii::t('app','Admission No:').' '.$particular_1->admission_no;
					}
					else{
						echo '-';
					}
				?>
			</td>
			  <td><?php echo $particular_1->amount.' '.$currency->config_value; ?></td>
			</tr>
			<?php  /*$amount = $amount + $particular_1->amount;*/$i++;} ?>
			<?php /*?><tr>
				<td>&nbsp;</td>
				<td style="color:#333333; font-size:16px; text-align:right"><strong><?php echo Yii::t('app','Total');?></strong></td>
				<td style="color:#333333; font-size:16px;"><?php echo $amount;?> </td>
			</tr><?php */?>
			</table> <br />
		   <table width="90%" cellspacing="0" cellpadding="0">
			<tr>
                 <th><strong><?php echo Yii::t('app','Sl no.');?> </strong></th>
                 <th><strong><?php echo Yii::t('app','Admission No');?></strong></th>
                 <th><strong><?php echo Yii::t('app','Student Name');?></strong></th>
                 <th><strong><?php echo Yii::t('app','Fees');?></strong></th>
                 <th><strong><?php echo Yii::t('app','Fees Paid');?></strong></th>
                 <th><strong><?php echo Yii::t('app','Balance');?></strong></th>
                 <?php
                 if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
				 {
				 ?>
                 	<th><strong><?php echo Yii::t('app','Payment');?></strong></th>
                 <?php
				 }
				 ?>
			</tr> 
		   <?php 
		   $i= 1;
		   foreach($list as $list_1) { 
		   $fees=0;
		    $posts=Students::model()->findByAttributes(array('id'=>$list_1->student_id,'is_deleted'=>0));
				if($posts==NULL)
				{
					continue;
				}
		   ?> 
			<tr>
			 <td><?php echo $i; ?></td>
			 <td><?php 
			 echo $posts->admission_no;
			 ?></td>
			 <td><?php echo $posts->first_name.' '.$posts->last_name; ?></td>
			 <td>
				<?php
					$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$posts->admission_no));
					if(count($check_admission_no)>0){ // If any particular is present for this student
						$adm_amount = 0;
						foreach($check_admission_no as $adm_no){
							$adm_amount = $adm_amount + $adm_no->amount;
						}
						$fees = $adm_amount;
						//echo $adm_amount.' '.$currency->config_value;
						$balance = 	$adm_amount - $list_1->fees_paid;
					}
					else{ // If any particular is present for this student category
						$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$posts->student_category_id,'admission_no'=>''));
						if(count($check_student_category)>0){
							$cat_amount = 0;
							foreach($check_student_category as $stu_cat){
								$cat_amount = $cat_amount + $stu_cat->amount;
							}
							$fees = $cat_amount;
							//echo $cat_amount.' '.$currency->config_value;
							$balance = 	$cat_amount - $list_1->fees_paid;		
						}
						else{ //If no particular is present for this student or student category
							$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
							if(count($check_all)>0){
								$all_amount = 0;
								foreach($check_all as $all){
									$all_amount = $all_amount + $all->amount;
								}
								$fees = $all_amount;
								//echo $all_amount.' '.$currency->config_value;
								$balance = 	$all_amount - $list_1->fees_paid;
							}
							else{
								$balance =$list_1->fees_paid;								
								echo '-'; // If no particular is found.
							}
						}
					}
				if($fees)	
					echo $fees.' '.$currency->config_value;
				else
					echo '-';				
				?>
			 </td>
             <td>
             	<?php
				if($list_1->is_paid == 0)
			 	{
					echo $list_1->fees_paid.' '.$currency->config_value;
				}
				else
				{
					echo $list_1->fees_paid.' '.$currency->config_value; 
				}
				?>
             </td>
             <?php 
			 	if($list_1->is_paid == 0 and $list_1->fees_paid > $fees)
				{
				?>
					<td style="color: #F50000">
				<?php                    
				}
				else
				{
				?>
					<td>
				<?php                    	
				}
				if($list_1->is_paid == 0 and $list_1->fees_paid < $fees)
			 	{
             		echo $bal.' '.$currency->config_value;
				}
				elseif($list_1->fees_paid > $fees and $list_1->is_paid == 1 )
			 	{	
             		echo '<font color="#FF0000">'.abs($balance).' '.$currency->config_value.'</font>';
				}
				else
				{
					$bal=abs($balance);	
					echo $bal.' '.$currency->config_value;
					//echo '-';
				}
				?>
             </td>
             <?php
			 if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
			 {
			 ?>
			 <td id="req_res<?php echo $list_1->id;?>"><?php 
			 if($fees != 0)
			{
			 if($list_1->is_paid == 0)
			 {
			 	echo CHtml::ajaxLink(Yii::t('app','Full'), Yii::app()->createUrl('fees/FinanceFees/Payfees' ), array('type' =>'GET','data' =>array( 'val1' => $list_1->id,'fees'=> $fees ),'dataType' => 'text',  'update' =>'#req_res'.$list_1->id,'success'=>'js: function(data) {window.location.reload();}'),array( 'confirm'=>Yii::t('app','Are you sure you want to pay full fees? ')));
				echo ' | ';
				if($list_1->fees_paid > $fees)
				{
					echo CHtml::ajaxLink(Yii::t('app','Edit'), Yii::app()->createUrl('fees/FinanceFees/Editfees' ), array('type' =>'GET','data' =>array( 'id' => $list_1->id ),'dataType' => 'text',  'update' =>'#edit'.$list_1->id, 'onclick'=>'$("#editfees'.$list_1->id.'").dialog("open"); return false;',));
					echo '<div  id="edit'.$list_1->id.'"></div>';
				}
				else
				{
					echo CHtml::ajaxLink(Yii::t('app','Partial'), Yii::app()->createUrl('fees/FinanceFees/Partialfees' ), array('type' =>'GET', 'data' =>array( 'id' => $list_1->id,),'dataType' => 'text',  'update' =>'#partial'.$list_1->id, 'onclick'=>'$("#partialfees'.$list_1->id.'").dialog("open"); return false;',),array('class'=>'partial'));
					echo '<div  id="partial'.$list_1->id.'"></div>';
				}
			 }
			 else
			 {
			 	echo Yii::t('app','Paid');
				echo ' | ';
				echo CHtml::ajaxLink(Yii::t('app','Edit'), Yii::app()->createUrl('fees/FinanceFees/Editfees' ), array('type' =>'GET','data' =>array( 'id' => $list_1->id ),'dataType' => 'text',  'update' =>'#edit'.$list_1->id, 'onclick'=>'$("#editfees'.$list_1->id.'").dialog("open"); return false;',));
					echo '<div  id="edit'.$list_1->id.'"></div>';
				
			 }
			}
			 else
								{
									echo Yii::t('app','Not Required');
								}
			 ?>
             
			  </td>
              <?php
			  }
			  ?>
			
			
			</tr>   
			
		
		<?php $i++; } ?>
	  
		</table>
	</div>
	
	
	<?php }
	?>
<?php } ?>
	  </div>
    </td>
  </tr>
</table>
<script>
$(".partial").click(function(e) {
    $('form#partial-fees-form').remove();
});
</script>
