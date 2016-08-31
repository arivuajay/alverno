<?php
$this->breadcrumbs=array(
	Yii::t('app','Fees')=>array('index'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('left_side');?>
    
    </td>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
<div class="cont_right formWrapper">
			<h1><?php echo Yii::t('app','Accounting Dashboard'); ?></h1>
            
            <div class="edit_bttns" style="width:175px; top:15px;">
    		<div class="clear"></div>
    		</div>
				<div class="yellow_bx yb_fees">
                	<div class="y_bx_head">
                    	<?php echo Yii::t('app','Before Collecting the Fees make sure you follow the following instructions'); ?>
                    </div>
                	<div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Fee Category'); ?></h1>
                        <p><?php echo Yii::t('app','Create/Edit fee Category for collecting the fees. Enter your category name, Description and Batches affecting the fee category'); ?></p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Add Particular'); ?></h1>
                        <p><?php echo Yii::t('app','Add/Edit Fee Particulars associated with each fee category'); ?></p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Create Fee Collection'); ?></h1>
                        <p><?php echo Yii::t('app','Start a fee collection with the fee category, Start date, End date and the Due date'); ?></p>
                    </div>
                    <div class="y_bx_list timetable_list">
                    	<h1><?php echo Yii::t('app','Collect Fees'); ?></h1>
                        <p><?php echo Yii::t('app','Record Fee collection by batch wise or view fee details from the student profile'); ?></p>
                    </div>
    			</div>
		<div class="clear"></div>
		</div></td>
        
      </tr>
    </table>

    </td>
  </tr>
</table>