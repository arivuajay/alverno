<?php
$this->breadcrumbs=array(
	Yii::t('app','Fees')=>array('/fees'),
	Yii::t('app','Paid Students'),
	
);?>
<script language="javascript">
function batch()
{
var id = document.getElementById('batch').value;
window.location= 'index.php?r=fees/financeFees/paid&batch='+id;	
}
function category()
{
var id_1 = document.getElementById('batch').value;
var id = document.getElementById('category').value;
window.location= 'index.php?r=fees/financeFees/paid&batch='+id_1+'&course='+id;	
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
    <h1><?php echo Yii::t('app','Paid Students');?></h1>
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
if(isset($_REQUEST['course']))
	{
		$sel_1= $_REQUEST['course'];
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
<?php if(isset($_REQUEST['batch']) && isset($_REQUEST['course']))
{ 
$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['course']));
//$particular = FinanceFeeParticulars::model()->findByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id));
$particular = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
$currency=Configurations::model()->findByPk(5);

if(count($particular)!=0)
{
	//$amount = 0;

	$list  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['course'],':y'=>1));
	
	?>

<div class="tableinnerlist"> 
    
        <?php 
		$i = 1;
			foreach($particular as $particular_1) { ?>
       
        <?php  /*$amount = $amount + $particular_1->amount;*/ $i++;} ?>
         <br />
       <table width="90%" cellspacing="0" cellpadding="0">
        <tr>
         <th><strong><?php echo Yii::t('app','Sl no.');?> </strong></th>
         <th><strong><?php echo Yii::t('app','Student Name');?></strong></th>
         <th><strong><?php echo Yii::t('app','Fees');?></strong></th>
         <th><strong><?php echo Yii::t('app','Action');?></strong></th>
        </tr> 
       <?php 
	   if(count($list)>0){
	   $i= 1;
	   foreach($list as $list_1) { ?> 
        <tr>
         <td><?php echo $i; ?></td>
         <td><?php 
		 $posts=Students::model()->findByAttributes(array('id'=>$list_1->student_id));
		 echo $posts->first_name; ?></td>
         <td>
		 	<?php
				/*$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$posts->admission_no));
				if(count($check_admission_no)>0){ // If any particular is present for this student
					$adm_amount = 0;
					foreach($check_admission_no as $adm_no){
						$adm_amount = $adm_amount + $adm_no->amount;
					}
					echo $currency->config_value.' '.$adm_amount;	
				}
				else{ // If any particular is present for this student category
					$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$posts->student_category_id,'admission_no'=>''));
					if(count($check_student_category)>0){
						$cat_amount = 0;
						foreach($check_student_category as $stu_cat){
							$cat_amount = $cat_amount + $stu_cat->amount;
						}
						echo $currency->config_value.' '.$cat_amount;		
					}
					else{ //If no particular is present for this student or student category
						$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
						if(count($check_all)>0){
							$all_amount = 0;
							foreach($check_all as $all){
								$all_amount = $all_amount + $all->amount;
							}
							echo $currency->config_value.' '.$all_amount;
						}
						else{
							echo '-'; // If no particular is found.
						}
					}
				}
				*/
			 echo $currency->config_value.' '.$list_1->fees_paid;
			?>
         </td>
        <td><?php echo CHtml::link(Yii::t('app','Print Receipt'),array('/fees/FinanceFees/printreceipt','batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['course'],'id'=>$posts->id),array('target'=>'_blank')); ?></td> 
        
        
        </tr>   
        
    
    <?php $i++; } 
	   }
	   else{
	   ?>
  		<tr>
          <td colspan="4"><?php echo Yii::t('app','No students paid the fees.');?></td>             
        </tr>
        <?php 
	   }
	   ?>
    </table>
</div>


<?php 
	
}
?>



<?php } ?>

    
    
    </div>
    </td>
  </tr>
</table>
