<style>
.invoice-table td {
	padding-left: 10px !important;
}
.attendance_table table {
	border-collapse: collapse;
}
.attendance_table table tr td, th {
	border: 1px #C5CED9 solid;
	padding: 8px 9px;
	font-size: 13px;
}
.pdtab-h th {
	background: #F0F1F3;
	padding: 15px 5px;
	font-size: 16px;
	font-weight: 600;
	text-align: left;
	line-height: 25px;
}
.invoice_top table tr td {
	font-size: 18px;
	padding: 5px 0;
	font-weight: 600;
}
hr {
	border-bottom: 1px solid #ccc;
	border-top: 0px solid
}

.invoice_table table tr td{ padding:5px;}
</style>
<table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="first">
            <?php
            $logo=Logo::model()->findAll();
            if($logo!=NULL){
                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" height="100" />';
            }
            ?>
        </td>
        <td align="center" valign="middle" class="first" style="width:300px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; padding-left:10px;">
                        <?php $college=Configurations::model()->findAll();?>
                        <?php echo @$college[0]->config_value; ?>
                    </td>
                </tr>
                <tr>
                    <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                        <?php echo @$college[1]->config_value; ?>
                    </td>
                </tr>
                <tr>
                    <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                        <?php echo Yii::t('app','Phone').': '.@$college[2]->config_value; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<hr />
<br />
<div align="center" style="display:none; text-align:center !important; font-size:25px; font-weight:600;"><?php echo Yii::t('app','INVOICE'); ?></div>
<br />


<table width="300" border="0" cellspacing="0" cellpadding="0"> 
    <tr>
        <td width="100" height="25"><?php echo Yii::t("app", "Invoice ID");?> </td>
        <td width="20">:</td>
        <td width="300"><?php echo $invoice->id;?></td>
    </tr>                
    <tr>
        <td height="25"><?php echo Yii::t("app", "Recipient");?> </td>
        <td>:</td>
        <td>
            <?php
                $display_name	= "-";
                if($invoice->uid!=NULL and $invoice->uid!=0){
                    $user	= Profile::model()->findByAttributes(array('user_id'=>$invoice->uid));
                    if($user!=NULL)
                        $display_name	= $user->fullname;
                }
                else if($invoice->table_id!=NULL and $invoice->table_id!=0){
                    if($invoice->user_type==1){	//student
                        $student		= Students::model()->findByPk($invoice->table_id);
                        if($student!=NULL)
                            $display_name	= ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name);
                    }
                }
                //display name
                echo $display_name;
            ?>
        </td>
    </tr>
    <tr>
        <td height="25"><?php echo Yii::t("app", "Invoice Date");?> </td>
        <td>:</td>
        <td>
            <?php
                $settings	= UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                if($settings!=NULL)
                    echo date($settings->displaydate, strtotime($invoice->created_at));
                else
                    echo $invoice->created_at;
            ?>
        </td>
    </tr>
    <tr>
        <td height="25"><?php echo Yii::t("app", "Due Date");?> </td>
        <td>:</td>
        <td>
            <?php
                if($settings!=NULL)
                    echo date($settings->displaydate, strtotime($invoice->due_date));
                else
                    echo $invoice->due_date;
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div style="font-size:26px; padding-top:20px;">
                <?php echo Yii::t("app", "Status");?> : <?php echo ($invoice->is_paid==1)?"<div style='color:#090;'>".Yii::t("app","Paid")."</div>":"<div style='color:#F00'>".Yii::t("app","Unpaid")."</div>";?>
            </div>
        </td>
    </tr>
</table>



<div class="attendance_table">
    <table width="380" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr class="pdtab-h" bgcolor="#F0F1F3">
                <td width="30">#</td>
                <td width="100"><?php echo Yii::t('app','Particular'); ?></td>
                <td><?php echo Yii::t('app','Description'); ?></td>
                <td><?php echo Yii::t('app','Amount'); ?></td>
                <td><?php echo Yii::t('app','Total'); ?></td>
            </tr>
            <?php
            $amount_total	= 0;
            $fine_total		= 0;
            foreach($particulars as $key=>$particular){
            ?>
            <tr>
                <td width="30" ><?php echo $key+1;?></td>
                <td width="100"><?php echo $particular->name;?></td>
                <td width="105"><?php echo ($particular->description!=NULL)?$particular->description:'-';?></td>
                <td width="100" ><?php echo $particular->amount;?></td>
                <td width="100" ><?php echo $particular->amount + $particular->fine_amount;?></td>
            </tr>
            <?php
                $amount_total	+= $particular->amount;
                $fine_total		+= $particular->fine_amount;
            }
            ?>
            <tr>
                <td colspan="3" align="left" style="padding-right:10px;">
                    <div style="font-size:17px; font-weight:600;">
                        <?php echo Yii::t('app','Grand Total');?>
                    </div>
                </td>
				<td><?php echo $amount_total;?></td>
				<td><?php echo $amount_total + $fine_total;?></td>
            </tr>
        </tbody>
    </table>
</div>