<style>
.tableinnerlist {
	padding: 0px;
	margin: 0px;
}
.tableinnerlist table {
	border-left: 1px #b9c7d0 solid;
	border-top: 1px #b9c7d0 solid;
}
.tableinnerlist td {
	border-right: 1px #b9c7d0 solid;
	border-bottom: 1px #b9c7d0 solid;
	padding: 4px 10px;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
}
.tableinnerlist th {
	border-right: 1px #b9c7d0 solid;
	border-bottom: 1px #b9c7d0 solid;
	padding: 4px 10px;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
}
</style>
<?php
	$student=Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
	$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
	//var_dump($collection->attributes);
	$category = FinanceFeeCategories::model()->findByAttributes(array('id'=>$collection->fee_category_id));
	//$particulars = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));	
	$batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
	$currency=Configurations::model()->findByPk(5);
	$list_1  = FinanceFees::model()->findByAttributes(array('fee_collection_id'=>$_REQUEST['collection'],'student_id'=>$_REQUEST['id'],'is_paid'=>0));
	$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
	$balance=0;
	$fees=0;
	 $check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
     if(count($check_admission_no)>0){ // If any particular is present for this student
      	$adm_amount = 0;
        foreach($check_admission_no as $adm_no){
         	$adm_amount = $adm_amount + $adm_no->amount;
        }
        //$fees = $adm_amount;
                    //echo $adm_amount.' '.$currency->config_value;
        $balance = 	$adm_amount - $list_1->fees_paid;
     }else{ // If any particular is present for this student category
            $check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,
																						'admission_no'=>''));
             if(count($check_student_category)>0){
             	$cat_amount = 0;
                foreach($check_student_category as $stu_cat){
                	$cat_amount = $cat_amount + $stu_cat->amount;
                }
                      //  $fees = $cat_amount;
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
                           // $fees = $all_amount;
                            //echo $all_amount.' '.$currency->config_value;
                            $balance = 	$all_amount - $list_1->fees_paid;
                    }
                    else{
                            $balance=0; // If no particular is found.
                    }
              }
    }
	/*if(count($check_all)>0){
		$all_amount = 0;
				foreach($check_all as $all){
					$all_amount = $all_amount + $all->amount;
				}
				//$fees = $all_amount;
				$balance = 	$all_amount - $list_1->fees_paid;*/
	//}
	$fees=$list_1->fees_paid;
	?>

<table width="700" border="1" bgcolor="#f9feff">
  <tr>
    <td><div style="padding:10px 20px;">
        <table width="700" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150"><?php $logo=Logo::model()->findAll();?>
              <?php
                if($logo!=NULL)
				{
					Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
				}
                ?></td>
            <td width="300" valign="middle"><h1 style="font-size:20px; text-align:left;">
                <?php $college=Configurations::model()->findByPk(1); ?>
                <?php echo $college->config_value ; ?></h1>
              <?php $college=Configurations::model()->findByPk(2); ?>
              <strong><?php echo $college->config_value ; ?></strong><br />
              <?php $college=Configurations::model()->findByPk(3); ?>
              <strong><?php echo ''.$college->config_value ; ?></strong></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td width="650" style="border-bottom:#ccc 1px solid; padding:10px 20px;"><table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="550" style="padding:10px 0px;"><strong><?php echo Yii::t('app','Reciept No'); ?></strong> : <?php echo $receipt_no;?></td>
          <td><strong><?php echo Yii::t('app','Date'); ?></strong> :
            <?php 
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
					if($settings!=NULL)
					{	
					$date1=date($settings->displaydate,time());
					echo $date1;		
					}
					else
					echo date('d/m/Y');
					?></td>
        </tr>
        <tr>
          <td style="padding:5px 0px;"><strong><?php echo Yii::t('app','Name'); ?></strong> :
            <?php  echo $student->first_name.' '.$student->last_name; ?></td>
          <td style="padding:5px 0px;"><strong><?php echo Yii::t('app','Admission Number'); ?> </strong>: <?php echo $student->admission_no; ?></td>
        </tr>
        <tr>
          <td style="padding:5px 0px;"><strong><?php echo Yii::t('app','Course'); ?> </strong> : <?php echo $batch->course123->course_name; ?></td>
          <td style="padding:5px 0px;"><strong><?php echo Yii::t('app','Batch'); ?></strong> : <?php echo $batch->name; ?></td>
        </tr>
        <tr>
          <td style=" padding:10px 0px;"><strong><?php echo Yii::t('app','Address'); ?></strong> : <?php echo $student->address_line1.' , '.$student->city.' , '.$student->state;?></td>
        </tr>
        <tr>
          <td><strong><?php echo Yii::t('app','Fee Category'); ?></strong> : <?php echo $category->name; ?></td>
          <td></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="650" style="padding:10px 0px;"><div style="padding:20px 20px;" class="tableinnerlist">
        <table width="760" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('app','Sl no.'); ?></strong></th>
            <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('app','Particulars'); ?></strong></th>
            <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('app','Amount'); ?></strong></th>
          </tr>
          <?php /*?><?php 
            $i = 1;
            foreach($particulars as $particular) {
				
			?>
            <tr>
                <td style="border-left:#cad4dc 1px solid;"><?php echo $i; ?></td>
                <td><?php echo $particular->name.'-'.$particular->student_category_id; ?></td>
                <td><?php echo $particular->amount.'-'.$particular->admission_no; ?></td>
            </tr>
            <?php
            $amount = $amount + $particular->amount;
            $i++;}
            ?><?php */?>
          <?php
		  	
            $check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
			if($check_admission_no!=NULL){
				$particulars = $check_admission_no;
			}
			elseif($student->student_category_id!=NULL){
				$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
				if($check_student_category!=NULL){
					$particulars = $check_student_category;
				}
				else{
					$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
					if($check_all!=NULL){
						$particulars = $check_all;
						
					}
					else{
					?>
          <tr>
            <td style="border-left:#cad4dc 1px solid; text-align:center;" colspan="3"><?php echo Yii::t('app','No Fees Particular Details Available!'); ?></td>
          </tr>
          <?php
					}
				}
			}
			else{
					$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
					if($check_all!=NULL){
						$particulars = $check_all;
						
					}
					else{
					?>
          <tr>
            <td style="border-left:#cad4dc 1px solid; text-align:center;" colspan="3"><?php echo Yii::t('app','No Fees Particular Details Available!'); ?></td>
          </tr>
          <?php
					}
				}
			
			
			if($particulars!=NULL){
				$i=1;
				$amount = 0;
				foreach($particulars as $particular){
			?>
          <tr>
            <td style="border-left:#cad4dc 1px solid;"><?php echo $i; ?></td>
            <td><?php echo $particular->name; ?></td>
            <td><?php echo number_format($particular->amount,2).' '.$currency->config_value; ?></td>
          </tr>
          <?php
				$amount = $amount + $particular->amount;
				$i++;
				}
			}
			?>
          <tr>
            <td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
            <td style="color:#333333; font-size:16px; text-align:right; background:#e4eaed;"><strong><?php echo Yii::t('app','Grand Total'); ?></strong></td>
            <td style="color:#333333; font-size:16px; background:#e4eaed;"><?php echo number_format($amount,2).' '.$currency->config_value;?></td>
          </tr>
          <tr>
          	<td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
            <td>Fees Paid</td>
            <td><?php echo $fees.' '.$currency->config_value; ?></td>
          </tr>
          <tr>
          	<td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
            <td>Balance</td>
            <td><?php echo abs($balance).' '.$currency->config_value; ?></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><div>
        <table width="750" border="0" cellspacing="0" cellpadding="0" style="padding:30px 0px;">
          <tr>
            <td width="20"></td>
            <td width="200" align="left"><?php echo 'Month: '.date('F',strtotime($collection->start_date));?></td>
            <td width="200">&nbsp;</td>
            <td width="280" align="left"><?php echo Yii::t('app','Signature'); ?>:</td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
