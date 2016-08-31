<?php
$this->breadcrumbs=array(
	Yii::t('app','Student Attentances')=>array('/courses'),
	Yii::t('app','Attendance'),
);
?>
<style>
.unpaid_table{
	border-top:1px #C5CED9 solid;
	margin:30px 0px;
	font-size:13px;
	border-right:1px #C5CED9 solid;
}
.unpaid_table td,th{
	border-left:1px #C5CED9 solid;
	padding:5px 6px;
	border-bottom:1px #C5CED9 solid;
	
}
hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}
</style>


<?php

  if(isset($_REQUEST['collection']) && isset($_REQUEST['batch']))
  {
	?>
    <!-- Header -->
   
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="first">
                           <?php $logo=Logo::model()->findAll();?>
                            <?php
                            if($logo!=NULL)
                            {
                                //Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
                            }
                            ?>
                </td>
                <td align="center" valign="middle" class="first" style="width:300px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; padding-left:10px;">
                                <?php $college=Configurations::model()->findAll(); ?>
                                <?php echo $college[0]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo $college[1]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo 'Phone: '.$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <hr />
    <br />
    <!-- End Header -->
    <div align="center" style="text-align:center; display:block"><?php echo Yii::t('app','LIST OF STUDENTS WITH PENDING FEES'); ?></div><br />
    <!-- Fees and course details -->
    <table style="font-size:13px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
            <?php 
				  $batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
                  $course_name = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
                  $collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
				  $category = FinanceFeeCategories::model()->findByAttributes(array('id'=>$collection->fee_category_id));
                  $particulars = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
				  $currency=Configurations::model()->findByPk(5);	
            ?>
            <tr>
                <td style="width:100px;"><?php echo Yii::t('app','Course'); ?></td>
                <td style="width:10px;">:</td>
                <td style="width:250px;"><?php echo $course_name->course_name; ?></td>
            
                <td><?php echo Yii::t('app','Batch'); ?></td>
                <td style="width:10px;">:</td>
                <td width="245"><?php echo $batch->name; ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('app','Fee Collection'); ?></td>
                <td>:</td>
                <td><?php echo $collection->name; ?></td>
                <td><?php echo Yii::t('app','Fee Category'); ?></td>
                <td>:</td>
                <td><?php echo $category->name; ?></td>
            </tr>
            <?php 
            $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL)
			{	
				$collection->start_date=date($settings->displaydate,strtotime($collection->start_date));
				$collection->end_date=date($settings->displaydate,strtotime($collection->end_date));
				$collection->due_date=date($settings->displaydate,strtotime($collection->due_date));		
			}
			?>
            <tr>
                <td><?php echo Yii::t('app','Start Date'); ?></td>
                <td>:</td>
                <td><?php echo $collection->start_date; ?></td>
                <td><?php echo Yii::t('app','End Date'); ?></td>
                <td>:</td>
                <td><?php echo $collection->end_date; ?></td>
            </tr>
            <tr>
                <td><?php echo Yii::t('app','Due Date'); ?></td>
                <td>:</td>
                <td><?php echo $collection->due_date; ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
           
        </table>
    
    <!-- END fees and course details -->
    <!-- Particulars Table -->

    
    	<table style="font-size:14px;" class="unpaid_table"  width="100%" cellspacing="0" >
        	<tr style="background:#DCE6F1; text-align:center; line-height:10px;">
                <td style="width:30px; padding-top:10px;"><?php echo Yii::t('app','Sl no.');?></td>
                <td style="width:230px; padding-top:10px;"><?php echo Yii::t('app','Particulars');?></td>
                <td style="width:250px; padding-top:10px;"><?php echo Yii::t('app','Applicable For');?></td>
                <td style="width:140px; padding-top:10px;"><?php echo Yii::t('app','Amount');?></td>
        	</tr>
			<?php 
			$i = 1;
			foreach($particulars as $particular) { 
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $particular->name; ?></td>
                    <td>
                    <?php 
                    if($particular->student_category_id==NULL and $particular->admission_no==NULL){
                    echo Yii::t('app','All'); 
                    }
                    elseif($particular->student_category_id!=NULL and $particular->admission_no==NULL){
                    $student_category = StudentCategories::model()->findByAttributes(array('id'=>$particular->student_category_id));
                    echo Yii::t('app','Category').' : '.$student_category->name; 
                    }
                    elseif($particular->student_category_id==NULL and $particular->admission_no!=NULL){
                    echo Yii::t('app','Admission No').' : '.$particular->admission_no;
                    }
                    else{
                    echo '-';
                    }
                    ?>
                    </td>
                    <td><?php echo $particular->amount.' '.$currency->config_value; ?></td>
                </tr>
            <?php  
			$i++;} 
			?>
        </table>    
    
    <!-- Particulars Table End -->
<!-- Students List Table -->
<table width="100%" cellspacing="0" class="unpaid_table">
    <tr style="background:#DCE6F1; text-align:center; line-height:10px;">
        <td style="width:30px; padding-top:10px;"><?php echo Yii::t('app','Sl no.');?></td>
        <td style="padding-top:10px;"><?php echo Yii::t('app','Admission No');?></td>
        <td style="width:225px; padding-top:10px;"><?php echo Yii::t('app','Name of the student');?></td>
        <td style="width:70px; padding-top:10px;"><?php echo Yii::t('app','Fees');?></td>
        <td style="width:100px; padding-top:10px;"><?php echo Yii::t('app','Fees Paid');?></td>
        <td style="width:100px; padding-top:10px;"><?php echo Yii::t('app','Balance');?></td>
    </tr>
<?php 
	
	$amount = 0;
	//$j=0;
	foreach($particulars as $particular)
	 {
	 
	 $amount = $amount + $particular->amount;
	}
	
	$list  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));

	/*if($j%2==0)
		$class = 'class="odd"';	
	else
		$class = 'class="even"';	*/
		
		
	$k = 1;
	
	foreach($list as $list_1)
	{
		$student=Students::model()->findByAttributes(array('id'=>$list_1->student_id,'is_deleted'=>0));
		if($student==NULL)
		{
			continue;
		}
			echo "<tr>";
			echo "<td>".$k."</td>";
			echo "<td>".$student->admission_no."</td>";
			echo "<td style='padding-left:20px'>".$student->first_name.' '.$student->last_name."</td>";
			echo "<td>";
			
				$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
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
                    $check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(
																array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
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
                            echo '-'; // If no particular is found.
							$fees=0;
							$balance=$list_1->fees_paid;
                        }
                    }
                }
            if($fees)	
                echo ' '.$fees.' '.$currency->config_value;
            else
                echo '-';
				
			echo "</td>";
			echo "<td>";
			
            if($list_1->is_paid == 0)
            {
                echo $list_1->fees_paid.' '.$currency->config_value;
            }
            else
            {
                echo $fees.' '.$currency->config_value; 
            }
            
         	echo "</td>";
			if($list_1->is_paid == 0 and $list_1->fees_paid > $fees)
			{
				echo "<td style='color: #F50000'>";
			}
           	else
			{
				echo "<td>";
			}
            if($list_1->is_paid == 0)
            {	
                echo $balance.' '.$currency->config_value;
            }
            else
            {
                echo '-';
            }
            echo "</td>";
		echo "</tr>";
		$k++;
	 
	 }	
	 ?>
</table>
<!--Students List Table End -->
<?php /*$j++;*/ }?>

