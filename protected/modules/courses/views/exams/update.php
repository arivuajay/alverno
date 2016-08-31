<?php
$this->breadcrumbs=array(
	Yii::t('app','Exams')=>array('/courses'),
	Yii::t('app','Update'),
);
?>
<style>
.container
{
	background:#FFF;
}

.ui-datepicker-title select{ float:none !important;}

</style>
<div style="background:#FFF;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">
                <div style="padding:20px;">
                <!--<div class="searchbx_area">
                <div class="searchbx_cntnt">
                <ul>
                <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                <li><input class="textfieldcntnt"  name="" type="text" /></li>
                </ul>
                </div>
                
                </div>-->
                
                <div class="clear"></div>
                    <div class="emp_right_contner">
                        <div class="emp_tabwrapper">
							<?php $this->renderPartial('/batches/tab');?>                            
                            <div class="clear"></div>
                            <h1><?php echo Yii::t('app','Update Exam');?></h1>
                            <div class="emp_cntntbx" style="padding-top:5px;">
                            	<?php
									echo $this->renderPartial('_form1', array('model'=>$model));
								?>
                        	</div> <!-- END div class="emp_cntntbx" -->
                        </div> <!-- END div class="emp_tabwrapper" -->
                    </div> <!-- END div class="emp_right_contner" -->
                </div>
            </td>
        </tr>
    </table>
</div>