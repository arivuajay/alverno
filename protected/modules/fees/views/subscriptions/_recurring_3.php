<?php
$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
if($settings!=NULL){
	$dateformat	= $settings->dateformat;
}
else
	$dateformat = 'dd-mm-yy';

$timeid	= time();
?>
<table width="100%">
    <tr>
        <td colspan="4"><label><?php echo Yii::t('app','Due Dates'); ?></label></td>
    </tr>
    <tr>
        <td width="25%">
            <?php                        
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$subscription,
				'attribute'=>'due_date['.$timeid++.']',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>$dateformat,
                    'changeMonth'=> true,
                    'changeYear'=>true,
                    'yearRange'=>'1900:'.(date('Y')+5)
                ),
                'htmlOptions'=>array(
                    'style'=>'height:16px;',
                    'readonly'=>true
                ),
            ));
            ?>
        </td>
   
        <td width="25%">
            <?php                        
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$subscription,
				'attribute'=>'due_date['.$timeid++.']',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>$dateformat,
                    'changeMonth'=> true,
                    'changeYear'=>true,
                    'yearRange'=>'1900:'.(date('Y')+5)
                ),
                'htmlOptions'=>array(
                    'style'=>'height:16px;',
                    'readonly'=>true
                ),
            ));
            ?>
        </td>
   
        <td width="25%">
            <?php                        
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$subscription,
				'attribute'=>'due_date['.$timeid++.']',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>$dateformat,
                    'changeMonth'=> true,
                    'changeYear'=>true,
                    'yearRange'=>'1900:'.(date('Y')+5)
                ),
                'htmlOptions'=>array(
                    'style'=>'height:16px;',
                    'readonly'=>true
                ),
            ));
            ?>
        </td>
   
        <td width="25%">
            <?php                        
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$subscription,
				'attribute'=>'due_date['.$timeid++.']',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>$dateformat,
                    'changeMonth'=> true,
                    'changeYear'=>true,
                    'yearRange'=>'1900:'.(date('Y')+5)
                ),
                'htmlOptions'=>array(
                    'style'=>'height:16px;',
                    'readonly'=>true
                ),
            ));
            ?>
        </td>
    </tr>        
</table>