<script language="javascript">
function hide(id)
{	
	$(".drop").not('#'+id).hide();
	if($('#'+id).is(':visible')){
		$('#'+id).hide();	
	}
	else{
		$('#'+id).show();
	}
}
</script>
<?php
 $this->breadcrumbs=array(
	 Yii::t('app','Complaint List')
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
         <!-- Filters Box -->
                <div class="filtercontner">
                    <div class="filterbxcntnt">
                    	<!-- Filter List -->
                        <div class="filterbxcntnt_inner" style="border-bottom:#ddd solid 1px;">
                            <ul>
                                <li style="font-size:12px"><?php echo Yii::t('app','Filter Your Names:');?></li>
                                
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                'method'=>'get',
                                )); ?>
                                <!-- Name Filter -->
                                <li>
                                    <div onClick="hide('user_name')" style="cursor:pointer;"><?php echo Yii::t('app','Name');?></div>
                                    <div id="user_name" style="display:none; width:203px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="user_name" value="<?php echo isset($_GET['user_name']) ? CHtml::encode($_GET['user_name']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Name Filter -->
                                 <!-- Subject Filter -->
                                <li>
                                    <div onClick="hide('subject')" style="cursor:pointer;"><?php echo Yii::t('app','Subject');?></div>
                                    <div id="subject" style="display:none; width:203px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="subject" value="<?php echo isset($_GET['subject']) ? CHtml::encode($_GET['subject']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Subject Filter -->
                                
                                <!-- status Filter -->
                                <li>
								
								  
                                <div onClick="hide('status')" style="cursor:pointer;"><?php echo Yii::t('app','Status');?></div>
                                    <div id="status" style="display:none; width:248px; min-height:33px; left:-120px; padding-top:0px;" class="drop">
                                    <div class="droparrow"  style="left:140px"></div>
                                    <?php 
                                    echo CHtml::activeDropDownList($model,'status',array('1' => Yii::t('app','Close'), '0' => Yii::t('app','Open')),array('selected'=>'selected','prompt'=>Yii::t('app','All'))); 
                                    ?>
                                    <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END status Filter -->
                                <!-- user type Filter -->
                                <li>
								
								  
                                <div onClick="hide('role_type')" style="cursor:pointer;"><?php echo Yii::t('app','User Type');?></div>
                                    <div id="role_type" style="display:none; width:252px; min-height:33px; left:-120px; padding-top:0px;" class="drop">
                                    <div class="droparrow"  style="left:140px"></div>
                                    <?php 
									 if (Yii::app()->user->isSuperuser or ModuleAccess::model()->check('Home')) {
										   $all_roles=new RAuthItemDataProvider('roles', array( 
										'type'=>2,
										));
                    				$data=$all_roles->fetchData(); }
                                    echo CHtml::dropDownList('role_type','',CHtml::listData($data,'name','name'),array('empty'=>Yii::t('app','Select')));
                                    ?>
                                    <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END user type Filter -->
                                <?php $this->endWidget(); ?>
                                
                            </ul>
                            
                                
                                <div class="clear"></div>
                        </div> <!-- END div class="filterbxcntnt_inner" -->
                        <!-- END Filter List -->
                        
                        
                        
                       
                        <div class="clear"></div>
                        
                        <!-- Active Filter List -->
                        <div class="filterbxcntnt_inner_bot">
                            <div class="filterbxcntnt_left"><strong><?php echo Yii::t('app','Active Filters:');?></strong></div>
                            <div class="clear"></div>
                            <div class="filterbxcntnt_right">
                                <ul>
                        
                        
                       
                                	
                                    <!-- Name Active Filter -->
									<?php 
									if(isset($_REQUEST['user_name']) and $_REQUEST['user_name']!=NULL)
                                    {
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Name'); ?> : <?php echo $_REQUEST['user_name']?><a href="<?php echo Yii::app()->request->getUrl().'&user_name='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Name Active Filter -->
                                     <!-- Subject Active Filter -->
									<?php 
									if(isset($_REQUEST['subject']) and $_REQUEST['subject']!=NULL)
                                    {
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Subject'); ?> : <?php echo $_REQUEST['subject']?><a href="<?php echo Yii::app()->request->getUrl().'&subject='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Subject Active Filter -->
                                    <!-- Status Active Filter -->
                                    <?php  
									if(isset($_REQUEST['Complaints']['status']) and $_REQUEST['Complaints']['status']!=NULL)
                                    {
                                                        $j++;
                                                        if($_REQUEST['Complaints']['status']==1)
                                                        {
                                                                $status=Yii::t('app','Close');
                                                        }
                                                        else
                                                        {
                                                                $status=Yii::t('app','Open');
                                                        }
                                                        ?>
                                                        <li><?php echo Yii::t('app','Status'); ?> : <?php echo $status?><a href="<?php echo Yii::app()->request->getUrl().'&Complaints[status]='?>"></a></li>
                                    <?php 
									}
									?> 
                                    <!-- END status Active Filter -->
                                    <!-- User type Active Filter -->
                                    <?php  
									if(isset($_REQUEST['role_type']) and $_REQUEST['role_type']!=NULL)
                                    {
                                                        $j++;
                                                        
                                                        ?>
                                                        <li><?php echo Yii::t('app','User Type'); ?> : <?php echo $_REQUEST['role_type']?><a href="<?php echo Yii::app()->request->getUrl().'&role_type='?>"></a></li>
                                    <?php 
									}
									?> 
                                    <!-- END User type  Active Filter -->
                                     <?php if($j==0)
                                    {
                                    	echo '<div style="padding-top:4px; font-size:11px;"><i>'.Yii::t('app','No Active Filters').'</i></div>';
                                    }
									?> 
                                    
                                    <div class="clear"></div>
                                </ul>
                            </div> <!-- END div class="filterbxcntnt_right" -->
                            
                            <div class="clear"></div>
                        </div> <!-- END div class="filterbxcntnt_inner_bot" -->
                        <!-- END Active Filter List -->
                    </div> <!-- END div class="filterbxcntnt" -->
                </div> <!-- END div class="filtercontner"-->
                
                <!-- END Filter Box -->
                <div class="clear"></div>
                                    
                                    
                                    
                                
        <?php
        if($complaints){
        ?>              
            <div class="pdtab_Con" style="padding-top:0px;">
           	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="pdtab-h">
                
                <td height="18" align="center"><?php echo Yii::t("app",'Name');?></td>
              <td align="center"><?php echo Yii::t("app",'Subject');?></td>
              <td align="center"><?php echo Yii::t("app",'Status');?></td>
              <td align="center"><?php echo Yii::t("app",'Action');?></td>
            </tr>  
        <?php
			foreach($complaints as $complaint)
                        {
				$user=Profile::model()->findByAttributes(array('user_id'=>$complaint->uid));
                                
                                $roles=Rights::getAssignedRoles($user->user_id);
                                $user_type="";
                                
                                foreach($roles as $role)
                                {
                                   $user_type="";
                                       if(sizeof($roles)==1 and $role->name == 'parent')
                                       {
                                            $user_type="2";
                                       }
                                       if(sizeof($roles)==1 and $role->name == 'student')
                                       {
                                           $user_type="1";
                                       }
                                       
                                }
                                
				
                $person= User::model()->findByAttributes(array('id'=>$complaint->uid));
						if($person->status==1)
						{?>
				<tr><td align="center">
                                    <?php 
                                  //  echo $user_type; exit;
                                    if($user_type==1)
                                    {
                                        $model= Students::model()->findByAttributes(array('uid'=>$user->user_id));
                                        if($model)
                                        {
                                            if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile"))
                                                    { ?>
                                                        <?php $name='';
                                                        $name=  $model->studentFullName('forStudentProfile');
                                                        echo $name; ?>
                                                    <?php }
                                        }
                                    }
                                    else if($user_type==2)
                                    {
                                        $model= Guardians::model()->findByAttributes(array('uid'=>$user->user_id));
                                        if($model)
                                        {
                                            if(FormFields::model()->isVisible("fullname", "Guardians", "forStudentProfile"))
                                                    { ?>
                                                        <?php $name='';
                                                        $name=  $model->parentFullName('forStudentProfile');
                                                        echo $name; ?>
                                                    <?php }
                                        }
                                    }
                                    
                                    
                                    else
                                    { ?>
					<?php 
                                        
                                        echo $user->firstname.' '.$user->lastname; ?>
                                    <?php } ?>
                                    </td>
					<td align="center"><?php echo $complaint->subject;?></td>
					<td align="center"><?php 
					if($complaint->status == 0)
					{
						echo Yii::t("app","Open");
					}
					if($complaint->status == 1)
					{
						echo Yii::t("app","Close");
					}
					?>
					
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
					echo CHtml::link(Yii::t("app",'View'),array('complaints/read','id'=>$complaint->id));?></td>
				</tr>    
				
<?php 
						}
			}
        }
        else{
            echo Yii::t("app","No Complaints");
        }
        ?>
        </table>
        </div>
       
        <div class="pagecon">
			<?php                                          
            $this->widget('CLinkPager', array(
            'currentPage'=>$pages->getCurrentPage(),
            'itemCount'=>$item_count,
            'pageSize'=>$page_size,
            'maxButtonCount'=>5,
            'header'=>'',
            'htmlOptions'=>array('class'=>'pages'),
            ));?>
        </div> <!-- END div class="pagecon"-->
        </div>
        

	</td>
  </tr>
</table>
<script>
$('body').click(function() {
	$('#osload').hide();
	
	$('#status').hide();
 
});

$('.filterbxcntnt_inner').click(function(event){
   event.stopPropagation();
});

$('.load_filter').click(function(event){
   event.stopPropagation();
});
</script>

