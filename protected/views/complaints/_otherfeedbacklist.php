<style type="text/css">
.pdtab_Con table td{ padding:8px 4px;}
</style>

<?php
$this->breadcrumbs=array(
	'Complaints'=>array('complaints/feedbacklist'),
	'List',
);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
<div id="othleft-sidebar">
<?php 
	$leftside = 'mailbox.views.default.left_side';	
	$this->renderPartial($leftside);
?>
</div>
 	</td>
 	<td valign="top">
<div class="cont_right formWrapper">  
<h1><?php echo Yii::t('app','Complaint List'); ?></h1>


<div class="contrht_bttns" style="right: 17px;top: 15px">
                        <ul>
                            <li>
								<?php
    echo CHtml::link(Yii::t('app','<span>Register a Complaint</span>'),array('Complaints/create',),array('class'=>'btn btn-primary'));
?>
							</li>
                        </ul>
                    </div>

 		
   
    
<?php
$complaints=Complaints::model()->findAllByAttributes(array('uid'=>Yii::app()->user->id),array('order'=>'id DESC'));
$settings=UserSettings::model()->findByAttributes(array('user_id'=>1));
if($complaints)
{
?>
		<div class="pdtab_Con" style="padding-top:0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                       <tr class="pdtab-h">
                            <td><?php echo Yii::t('app','Subject'); ?></td>
                            <td><?php echo Yii::t('app','Date'); ?></td>
                            <td><?php echo Yii::t('app','status'); ?></td>
                            <td align="center"><?php echo Yii::t("app",'Action');?></td>
                        </tr>
                        <?php
					foreach($complaints as $complaint)
					{
						?>
					   <tr> 
						<td><?php echo ucfirst($complaint->subject);?></td>
						<td><?php echo date($settings->displaydate,strtotime($complaint->date));?></td>
						<td><?php 
									if($complaint->status == 0)
									{
										echo "Open";
									}
									if($complaint->status == 1)
									{
										echo  "Close";
									}?>
										</td>
               
                <td style="text-align:center"><?php
                if($complaint->status == 0 )
				{
					echo CHtml::link(Yii::t("app",'Close'),array('complaints/close','id'=>$complaint->id),array('confirm'=>Yii::t('app','Are you sure you want to close this Complaint ?')));  
				}
				if($complaint->status == 1)
				{
					echo CHtml::link(Yii::t("app",'Reopen'),array('complaints/reopen','id'=>$complaint->id),array('confirm'=>Yii::t('app','Are you sure you want to reopen this Complaint ?')));  
					
				}
				
				echo " | "; 
               	echo CHtml::link(Yii::t("app",'View'),array('complaints/feedback','id'=>$complaint->id,));?></td>
            </tr>    
						               
					<?php                    
						
					}
					}
					else
					{
						echo Yii::t("app","You have No Complaint And Feedbacks");
					}
					?>
           </table>
</div>
		</td>
	</tr>
</table>





