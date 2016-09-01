
<style>
.drop select { width:159px;}
.bttns_addstudent li a.addbttn{
	padding:12px 15px 11px 12px;
	font-size:12px;
	background-color:#09F;
	font-weight:bold;
}
.bttns_addstudent{
	top:0px;
	left:98px;
}
</style>


<?php
$this->breadcrumbs=array(
	Yii::t('app','Students')=>array('index'),
	Yii::t('app','Manage'),
);


?>

<script language="javascript">
function details(id)
{
	
	var rr= document.getElementById("dropwin"+id).style.display;
	
	 if(document.getElementById("dropwin"+id).style.display=="block")
	 {
		 document.getElementById("dropwin"+id).style.display="none"; 
	 }
	 if(  document.getElementById("dropwin"+id).style.display=="none")
	 {
		 document.getElementById("dropwin"+id).style.display="block"; 
	 }
	 //return false;
	

}
</script>

<script language="javascript">
function hide(id)
{
	$(".drop").hide();
	$('#'+id).toggle();	
}
</script>

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<body>
<?php
$users = array("admin","student","parent","teacher");
$subdomain = explode('.com' , $_SERVER['SERVER_NAME']);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
                <h1><?php echo Yii::t('app','Manage Students');?></h1>
                
                 
                <!-- Save Filter, Load Filter, Clear All -->
                <div class="search_btnbx">
                    <!--<div class="listsearchbx">
                    <ul>
                    <li><input class="listsearchbar listsearchtxt" name="" type="text" onblur="clearText(this)" onfocus="clearText(this)" value="Search for Contacts"  /></li>
                    <li><input src="images/list_searchbtn.png" name="" type="image" /></li>
                    </ul>
                    </div>-->
                    <?php $j=0; ?>
                    <div id="jobDialog"></div>
                    <div class="contrht_bttns">
                        <ul>
                            <li>
								<?php echo CHtml::ajaxLink('<span>'.Yii::t('app','Save Filter').'</span>',$this->createUrl('Savedsearches/Create'),array(
                                'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                                'update'=>'#jobDialog',
                                'type' =>'GET','data' => array( 'val1' => Yii::app()->request->getUrl(),'type'=>'1' ),'dataType' => 'text',
                                ),array('id'=>'showJobDialog','class'=>'saveic')); ?>
                            </li>
                            
                            <li><a href="#" class="load_filter" onClick="hide('osload')"><span>
								<?php echo Yii::t('app','Load Filter');?></span></a> 
                                <div id="osload" style="display:none; overflow-y:auto; height:auto; background:#fff; left:-40px; top:40px" class="drop">
                                    <div class="droparrow"></div>
                                    <ul class="loaddrop">
                                        <li style="text-align:center">
                                            <?php $data=Savedsearches::model()->findAllByAttributes(array('user_id'=>Yii::app()->User->id,'type'=>'1'));
                                            if($data!=NULL)
                                            {
                                                foreach ($data as $data1)
                                                {
													
                                                echo '<span style="width:150px; float:left; ">'; echo CHtml::link($data1->name, CHtml::decode($data1->url),array('class'=>'vtip')); echo '</span>';
                                                echo '<span>'; 
                                                echo CHtml::link('<img src="images/cross.png" border="0" />',array('/savedsearches/deletestudent','user_id'=>Yii::app()->User->id,'sid'=>$data1->id),
																 array('confirm'=>Yii::t('app','Are you sure you want to delete this?')));echo '</span>';
                                                }
                                            }
                                            else
                                            {
                                                echo '<span style="color:#d30707;"><i>'.Yii::t('app','No Saved Searches').'</i></span>';
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div> <!-- END div id="load" -->
                            </li>
                            
                            <li><?php echo CHtml::link('<span>'.Yii::t('app','Clear All').'</span>', array('manage')); ?></li>
                            
                        </ul>
                    </div> <!-- END div class="contrht_bttns" -->
                    <div class="bttns_imprtcntact">
                        <ul>
                        	<?php /*?> <li><a class=" import_contact last" href=""><?php echo Yii::t('app','Import Contact');?></a></li><?php */?>
                        </ul>
                    </div> <!-- END div class="bttns_imprtcntact" -->
                    
                     <!-- END div class="bttns_addstudent" -->
                    
                </div> <!-- END div class="search_btnbx" -->
                
                <!-- END Save Filter, Load Filter, Clear All -->
                
                <div class="clear"></div>
                
                <!-- Filters Box -->
                <div class="filtercontner">
                    <div class="filterbxcntnt">
                    	<!-- Filter List -->
                        <div class="filterbxcntnt_inner" style="border-bottom:#ddd solid 1px;">
                            <ul>
                                <li style="font-size:12px"><?php echo Yii::t('app','Filter Your Students:');?></li>
                                
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                'method'=>'get',
                                )); ?>
                                
                                <!-- Name Filter -->
                                <li>
                                    <div onClick="hide('name')" style="cursor:pointer;"><?php echo Yii::t('app','Name');?></div>
                                    <div id="name" style="display:none; width:214px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="name" value="<?php echo isset($_GET['name']) ? CHtml::encode($_GET['name']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Name Filter -->
                                
                                <!-- Admission Number Filter -->
                                <li>
                                    <div onClick="hide('admissionnumber')" style="cursor:pointer;"><?php echo Yii::t('app','Admission number');?></div>
                                    <div id="admissionnumber" style="display:none;width:214px; padding-top:0px; height:33px" class="drop">
                                        <div class="droparrow" style="left:10px;"></div>
                                        <input type="search" placeholder="<?php echo Yii::t('app','search'); ?>" name="admissionnumber" value="<?php echo isset($_GET['admissionnumber']) ? CHtml::encode($_GET['admissionnumber']) : '' ; ?>" />
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Admission Number Filter -->
                                
                                <!-- Batch Filter -->
                                <li>
                                    <div onClick="hide('batch')" style="cursor:pointer;"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></div>
                                    <div id="batch" style="display:none; color:#000; width:480px; height:33px; padding-left:10px; padding-top:0px; left:-200px" class="drop">
                                        <div class="droparrow" style="left:210px;"></div>
                                        <?php
										if(Yii::app()->user->year)
										{
											$year = Yii::app()->user->year;
										}
										else
										{
											$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
											$year = $current_academic_yr->config_value;
										}
                                        $data = CHtml::listData(Courses::model()->findAll('is_deleted=:x AND academic_yr_id=:y',array(':x'=>'0',':y'=>$year),array('order'=>'course_name DESC')),'id','course_name');
                                        echo Yii::t('app','Course');
                                        echo CHtml::dropDownList('cid','',$data,
                                        array('prompt'=>Yii::t('app','Select'),
                                        'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('Students/batch'),
                                        'update'=>'#batch_id',
                                        'data'=>'js:$(this).serialize()'
                                        ))); 
                                        echo '&nbsp;&nbsp;&nbsp;';
                                        echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");
                                        $data1 = CHtml::listData(Batches::model()->findAll('is_active=:x AND is_deleted=:y AND academic_yr_id=:z',array(':x'=>'1',':y'=>0,':z'=>$year),array('order'=>'name DESC')),'id','name');
                                        echo CHtml::activeDropDownList($model,'batch_id',$data1,array('prompt'=>Yii::t('app','Select'),'id'=>'batch_id')); ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Batch Filter -->
                                
                                <!-- Gender Filter -->
                                <li>
                                    <div onClick="hide('gender')" style="cursor:pointer;"><?php echo Yii::t('app','Gender');?></div>
                                    <div id="gender" style="display:none; width:230px; padding-top:0px; height:33px" class="drop">
                                        <div class="droparrow" style="left:10px;"></div>
                                        <?php
                                        echo CHtml::activeDropDownList($model,'gender',array('M' => Yii::t('app','Male'), 'F' => Yii::t('app','Female')),array('prompt'=>Yii::t('app','All'))); 
                                        ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- End Gender Filter -->
                                
                                <!-- Blood Group Filter -->
                                <li>
                                    <div onClick="hide('bloodgroup')" style="cursor:pointer;"><?php echo Yii::t('app','Blood Group');?></div>
                                    <div id="bloodgroup" style="display:none;width:228px; padding-top:0px; height:33px" class="drop" >
                                        <div class="droparrow" style="left:10px;"></div>
                                        <?php echo CHtml::activeDropDownList($model,'blood_group',
                                        array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'),
                                        array('prompt' => Yii::t('app','Select'))); ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Blood Group Filter -->
                                
                                <!-- Nationality Filter -->
                                <li>
                                    <div onClick="hide('nationality')" style="cursor:pointer;"><?php echo Yii::t('app','Country');?></div>
                                    <div id="nationality" style="display:none;width:230px; padding-top:0px; left:-180px; height:33px;" class="drop">
                                        <div class="droparrow" style="left:200px;"></div>
                                        <?php echo CHtml::activeDropDownList($model,'country_id',CHtml::listData(Countries::model()->findAll(),'id','name'),array('prompt'=>Yii::t('app','Select'))); ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Nationality Filter -->
                                
                                <!-- Date of Birth Filter -->
                                <?php
                                $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                                if($settings!=NULL)
                                {
                                    $date=$settings->dateformat;
                                }
                                else
                                    $date = 'dd-mm-yy';	
                                ?>
                                <li>
                                    <div onClick="hide('dob')" style="cursor:pointer;"><?php echo Yii::t('app','Date Of Birth');?></div>
                                    <div id="dob" style="display:none; width:386px; left:-283px; height:33px; padding-top:0px;" class="drop">
                                        <div class="droparrow" style=" left:313px"></div>
                                        <?php echo CHtml::activeDropDownList($model,'dobrange',array('1' => Yii::t('app','less than'), '2' => Yii::t('app','equal to'), '3' => Yii::t('app','greater than')),array('prompt'=>Yii::t('app','Option'))); ?>                            
                                        <?php 
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name'=>'Students[date_of_birth]',
                                            'model'=>$model,
                                            'value'=>$model->date_of_birth,
                                            
                                            'options'=>array(
                                            'showAnim'=>'fold',
                                            'dateFormat'=>$date,
                                            'changeMonth'=> true,
                                            'changeYear'=>true,
                                            'yearRange'=>'1900:'
                                            ),
                                            'htmlOptions'=>array(
											'id' => 'dobtxt',
											'readonly'=>true
                                            ),
                                        ));
                                        ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Date of Birth Filter -->
                                
                                <!-- Admission Date Filter -->
                                <li>
                                    <div onClick="hide('admission')" style="cursor:pointer;"><?php echo Yii::t('app','Admission Date');?></div>
                                    <div id="admission" style="display:none;width:386px; left:-190px;  height:33px; padding-top:0px;" class="drop">
                                        <div class="droparrow" style=" left:200px"></div>
                                        <?php echo CHtml::activeDropDownList($model,'admissionrange',array('1' => Yii::t('app','less than'), '2' => Yii::t('app','equal to'), '3' => Yii::t('app','greater than')),array('prompt'=>Yii::t('app','Option'))); ?>
                                        <?php 
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name'=>'Students[admission_date]',
                                        'model'=>$model,
                                        'value'=>$model->admission_date,
                                        
                                        'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>$date,
                                        'changeMonth'=> true,
                                        'changeYear'=>true,
                                        'yearRange'=>'1900:'
                                        ),
                                        'htmlOptions'=>array(
										'id'=>'admdatetxt'
                                        ),
                                        ));
                                        ?>
                                        <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                 <!-- END Admission Date Filter -->
                                 
                                <!-- Status Filter -->
                                <li>
								
								  
                                <div onClick="hide('status')" style="cursor:pointer;"><?php echo Yii::t('app','Status');?></div>
                                    <div id="status" style="display:none; width:230px; min-height:33px; left:-120px; padding-top:0px;" class="drop">
                                    <div class="droparrow"  style="left:140px"></div>
                                    <?php 
                                    echo CHtml::activeDropDownList($model,'status',array('all'=>Yii::t('app','All'), '1' => Yii::t('app','Active'), '0' => Yii::t('app','Inactive')),array('selected'=>'selected','prompt'=>Yii::t('app','Select Status'))); 
                                    ?>
                                    <input type="submit" value="<?php echo Yii::t('app','Apply'); ?>" />
                                    </div>
                                </li>
                                <!-- END Status Filter -->
                               <div class="ea_pdf" style="top:188px; right:-59px; z-index:1000">
                               
                                <button  type="submit" class="ea_pdf pdf_but" name= "print" formtarget="_blank" style="outline:none;">
                                <?php echo Yii::t('app','Generate PDF')?>
                                </button>
                            </div>
                             
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
									if(isset($_REQUEST['name']) and $_REQUEST['name']!=NULL)
                                    {
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Name'); ?> : <?php echo $_REQUEST['name']?><a href="<?php echo Yii::app()->request->getUrl().'&name='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Name Active Filter -->
                                    
                                    <!-- Admission Number Active Filter -->
                                    <?php 
									if(isset($_REQUEST['admissionnumber']) and $_REQUEST['admissionnumber']!=NULL)
                                    { 
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Admission number'); ?> : <?php echo $_REQUEST['admissionnumber']?><a href="<?php echo Yii::app()->request->getUrl().'&admissionnumber='?>"></a></li>								
									<?php 
									}
									?>
                                     <!-- END Admission Number Active Filter -->
                                     
                                     
                                    <!-- Batch Active Filter -->
                                    <?php 
									if(isset($_REQUEST['Students']['batch_id']) and $_REQUEST['Students']['batch_id']!=NULL)
                                    { 
                                    	$j++;
                                    ?>
                                    	<li><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?> : <?php echo Batches::model()->findByAttributes(array('id'=>$_REQUEST['Students']['batch_id']))->name?><a href="<?php echo Yii::app()->request->getUrl().'&Students[batch_id]='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Batch Active Filter -->
                                    
                                    
                                    <!-- Gender Active Filter -->
                                    <?php 
									if(isset($_REQUEST['Students']['gender']) and $_REQUEST['Students']['gender']!=NULL)
                                    { 
										$j++;
										if($_REQUEST['Students']['gender']=='M')
										$gen=Yii::t('app','Male');
										else
										$gen=Yii::t('app','Female');
                                    ?>
                                    	<li><?php echo Yii::t('app','Gender'); ?> : <?php echo $gen?><a href="<?php echo Yii::app()->request->getUrl().'&Students[gender]='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Gender Active Filter -->
                                    
                                    
                                    <!-- Blood Group Active Filter -->
                                    <?php 
									if(isset($_REQUEST['Students']['blood_group']) and $_REQUEST['Students']['blood_group']!=NULL)
                                    { 
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Blood Group'); ?> : <?php echo $_REQUEST['Students']['blood_group']?><a href="<?php echo Yii::app()->request->getUrl().'&Students[blood_group]='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Blood Group Active Filter -->
                                    
                                    <!-- Nationality Active Filter -->
                                    <?php  if(isset($_REQUEST['Students']['country_id']) and $_REQUEST['Students']['country_id']!=NULL)
                                    {
                                    	$j++; 
									?>
                                    	<li><?php echo Yii::t('app','Country'); ?> : <?php echo Countries::model()->findByAttributes(array('id'=>$_REQUEST['Students']['country_id']))->name?><a href="<?php echo Yii::app()->request->getUrl().'&Students[country_id]='?>"></a></li>
                                    <?php 
									}
									?>
                                    <!-- END Nationality Active Filter -->
                                    
                                    
                                    <!-- Date of Birth Active Filter -->
                                    <?php 
                                    if(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']!=NULL)
                                    {
										if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
										{ 
											$j++;
                            if($_REQUEST['Students']['dobrange']=='1')
                            {
                                    $range = Yii::t('app','less than');
                            }
                            if($_REQUEST['Students']['dobrange']=='2')
                            {
                                    $range = Yii::t('app','equal to');
                            }
                            if($_REQUEST['Students']['dobrange']=='3')
                            {
                                    $range = Yii::t('app','greater than');
                            }?>
											<li><?php echo Yii::t('app','Date Of Birth'); ?> : <?php echo $range.' : '.$_REQUEST['Students']['date_of_birth']?><a href="<?php echo Yii::app()->request->getUrl().'&Students[date_of_birth]='?>"></a></li>
											<?php 
										}
									} 
                                    elseif(isset($_REQUEST['Students']['dobrange']) and $_REQUEST['Students']['dobrange']==NULL)
                                    { 
										if(isset($_REQUEST['Students']['date_of_birth']) and $_REQUEST['Students']['date_of_birth']!=NULL)
										{ 
											$j++;
											$range = Yii::t('app','equal to');  
											?>
											<li><?php echo Yii::t('app','Date Of Birth'); ?> : <?php echo $range.' : '.$_REQUEST['Students']['date_of_birth']?><a href="<?php echo Yii::app()->request->getUrl().'&Students[date_of_birth]='?>"></a></li>
										<?php 
										}
									}
									?>
                                    <!-- END Date of Birth Active Filter -->
                                    
                                    
                                    <!-- Admission Date Active Filter -->
                                    <?php 
                                    if(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']!=NULL)
                                    {
										if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
										{
                            $j++;
                            if($_REQUEST['Students']['admissionrange']=='1')
                            {
                                    $admissionrange = Yii::t('app','less than');
                            }
                            if($_REQUEST['Students']['admissionrange']=='2')
                            {
                                    $admissionrange = Yii::t('app','equal to');
                            }
                            if($_REQUEST['Students']['admissionrange']=='3')
                            {
                                    $admissionrange = Yii::t('app','greater than');
											}
											?>
											<li><?php echo Yii::t('app','Admission Date'); ?> : <?php echo $admissionrange.' : '.$_REQUEST['Students']['admission_date']?><a href="<?php echo Yii::app()->request->getUrl().'&Students[admission_date]='?>"></a></li>
											<?php 
										}
									} 
                                    elseif(isset($_REQUEST['Students']['admissionrange']) and $_REQUEST['Students']['admissionrange']==NULL)
                                    {
                    if(isset($_REQUEST['Students']['admission_date']) and $_REQUEST['Students']['admission_date']!=NULL)
                    { 
                            $j++;
                            $admissionrange = Yii::t('app','equal to'); ?>
                            <li><?php echo Yii::t('app','Admission Date'); ?> : <?php echo $admissionrange.' : '.$_REQUEST['Students']['admission_date']?><a href="<?php echo Yii::app()->request->getUrl().'&Students[admission_date]='?>"></a></li>
										<?php 
										}
									}?> 
                                    <!-- END Admission Date Active Filter -->
                                    
                                    <!-- Status Active Filter -->
                                    <?php  
									if(isset($_REQUEST['Students']['status']) and $_REQUEST['Students']['status']!=NULL)
                                    {
										$j++;
										if($_REQUEST['Students']['status']=='1')
										{
											$status=Yii::t('app','Present');
										}
										elseif($_REQUEST['Students']['status']=='0')
										{
											$status=Yii::t('app','Former');
										}elseif($_REQUEST['Students']['status']=='all')
										{
											$status=Yii::t('app','All');
										}
										?>
										<li><?php echo Yii::t('app','Status'); ?> : <?php echo $status?><a href="<?php echo Yii::app()->request->getUrl().'&Students[status]='?>"></a></li>
                                    <?php 
									}
									?> 
                                    <!-- END Admission Date Active Filter -->
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
                
                <!-- Alphabetic Sort -->
                <div class="list_contner_hdng">
                    <div class="letterNavCon" id="letterNavCon">
                        <ul>
                        <?php 
						if((isset($_REQUEST['val']) and $_REQUEST['val']==NULL) or (!isset($_REQUEST['val'])))
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php echo CHtml::link('All', Yii::app()->request->getUrl().'&val=',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='A')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php echo CHtml::link('A', Yii::app()->request->getUrl().'&val=A',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='B')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('B', Yii::app()->request->getUrl().'&val=B',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='C')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('C', Yii::app()->request->getUrl().'&val=C',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='D')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('D', Yii::app()->request->getUrl().'&val=D',array('class'=>'vtip')); ?>                            
                        </li>
                        
						
						<?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='E')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('E', Yii::app()->request->getUrl().'&val=E',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='F')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        <?php  echo CHtml::link('F', Yii::app()->request->getUrl().'&val=F',array('class'=>'vtip')); ?>                            
                        
                        </li>
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='G')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('G', Yii::app()->request->getUrl().'&val=G',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='H')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('H', Yii::app()->request->getUrl().'&val=H',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='I')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        
                        	<?php  echo CHtml::link('I', Yii::app()->request->getUrl().'&val=I',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='J')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('J', Yii::app()->request->getUrl().'&val=J',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='K')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('K', Yii::app()->request->getUrl().'&val=K',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='L')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('L', Yii::app()->request->getUrl().'&val=L',array('class'=>'vtip')); ?>                            
                        </li>
                        
						<?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='M')
                        {
                        	echo '<li class="ln_active">';
                        }                        
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('M', Yii::app()->request->getUrl().'&val=M',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='N')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('N', Yii::app()->request->getUrl().'&val=N',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='O')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('O', Yii::app()->request->getUrl().'&val=O',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='P')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('P', Yii::app()->request->getUrl().'&val=P',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Q')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Q', Yii::app()->request->getUrl().'&val=Q',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='R')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('R', Yii::app()->request->getUrl().'&val=R',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='S')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('S', Yii::app()->request->getUrl().'&val=S',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='T')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('T', Yii::app()->request->getUrl().'&val=T',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='U')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('U', Yii::app()->request->getUrl().'&val=U',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='V')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('V', Yii::app()->request->getUrl().'&val=V',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='W')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('W', Yii::app()->request->getUrl().'&val=W',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='X')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('X', Yii::app()->request->getUrl().'&val=X',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Y')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Y', Yii::app()->request->getUrl().'&val=Y',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        <?php 
						if(isset($_REQUEST['val']) and $_REQUEST['val']=='Z')
                        {
                        	echo '<li class="ln_active">';
                        }
                        else
                        {
                        	echo '<li>';
                        }
                        ?>
                        	<?php  echo CHtml::link('Z', Yii::app()->request->getUrl().'&val=Z',array('class'=>'vtip')); ?>                            
                        </li>
                        
                        </ul>
                        
                    	<div class="clear"></div>
                    </div><!-- END div class="letterNavCon" -->
                </div> <!-- END div class="list_contner_hdng" -->
                <!-- END Alphabetic Sort -->
                
                <!-- List Content -->                                          
               <div  style="margin-top:46px; position:relative;">
			   <div class="bttns_addstudent">
                        <ul>
                        	<li><?php echo CHtml::link(Yii::t('app','Add Student'), array('create'),array('class'=>'addbttn last')); ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <?php 
					if($list)
                    {
					?>
                    <div class="tablebx">  
                      
                          
                	<?php echo CHtml::Button( Yii::t('app','Delete All'),array('name'=>'submit','class'=>'formbut','id'=>'delete','onclick'=>'return delete_all()'));?>   
                         <div class="clear"></div>   
                         <br>                                  
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tablebx_topbg">
                                <td style="text-align:center"><div class="btn-group mailbox-checkall-buttons">
        	<input type="checkbox" id="ch"  name="ch1" class="chkbox checkall" onClick="checkall()"/> </div></td>
                                <td><?php echo Yii::t('app','Sl. No.');?></td>	
                                <?php
										if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){						
								  ?>
                                	<td><?php echo Yii::t('app','Student Name');?></td>
                                <?php } ?>    
                                <td><?php echo Yii::t('app','Admission No');?></td>
                                <?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile')){?>
                                	<td><?php echo Yii::app()->getModule("students")->labelCourseBatch();?></td>
                                <?php } ?>   
                                <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile')){?> 
                                	<td><?php echo Yii::t('app','Gender');?></td>
                                <?php } ?>    
                                 <td><?php echo Yii::t('app','Action');?></td>
                                <!--<td style="border-right:none;">Task</td>-->
                            </tr>
                            <?php 
                            if(isset($_REQUEST['page']))
                            {
                            	$i=($pages->pageSize*$_REQUEST['page'])-9;
                            }
                            else
                            {
                            	$i=1;
                            }
                            $cls="even";
                            ?>
                            
                            <?php 
							foreach($list as $list_1)
                            {
							?>
                                <tr class=<?php echo $cls;?>>
                                <td style="text-align:center">
                                    <div class="mailbox-item-wrapper">
                                    <label class="checkbox1" for="conv_<?php echo $list_1->id; ?>">
                                    <div class="mailbox-check mailbox-ellipsis">
                                    <input class="checkbox1 " id="conv_<?php echo $list_1->id; ?>" type="checkbox" name="convs" value="<?php echo $list_1->id; ?>" onClick="selectcheck()" />
                                    </div>
                                    </div>
                                </td>
                                <td><?php echo $i; ?></td>
                                <?php
									if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){						
								?> 
                                	<td><?php echo CHtml::link($list_1->studentFullName('forStudentProfile'),array('view','id'=>$list_1->id)) ?></td>
                                <?php } ?>    
                                <td><?php echo $list_1->admission_no ?></td>
                                <?php 
								$batc = Batches::model()->findByAttributes(array('id'=>$list_1->batch_id,'is_active'=>1,'is_deleted'=>0)); 
                                if($batc!=NULL)
                                {
									$cours = Courses::model()->findByAttributes(array('id'=>$batc->course_id)); ?>
                                    <?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile')){?>
										<td><?php echo $cours->course_name.' / '.$batc->name; ?></td> 
                                    <?php } ?>    
                                <?php 
								}
                                else{
								?>
                                	<?php if(FormFields::model()->isVisible('batch_id','Students','forStudentProfile')){?> 
                                		<td>-</td>
                                    <?php } ?>     
								<?php 
								}
								?>
                                <?php if(FormFields::model()->isVisible('gender','Students','forStudentProfile')){?> 
                                    <td>
                                        <?php 
                                        if($list_1->gender=='M')
                                        {
                                            echo Yii::t('app','Male');
                                        }
                                        elseif($list_1->gender=='F')
                                        {
                                            echo Yii::t('app','Female');
                                        }
                                        ?>
                                    </td>
                                <?php } ?>    
                                 <td> <?php
								
								 if($subdomain[0]!='tryopenschool'){
								 echo CHtml::link(Yii::t('app','Delete'),array('students/delete_student','id'=>$list_1->id),array('confirm'=>Yii::t('app','Are you sure you want delete the student ?')));
								 }
								 else
								 {
									 
									 $user=User::model()->findByAttributes(array('id'=>$list_1->uid));
									 if(!in_array($user->username,$users))
									 {
										 echo CHtml::link(Yii::t('app','Delete'),array('students/delete_student','id'=>$list_1->id),array('confirm'=>Yii::t('app','Are you sure you want delete the student ?')));
									 }
								 }
								 ?>   </td>
                                
                                <!--<td style="border-right:none;">Task</td>-->
                                </tr>
								<?php
                                if($cls=="even")
                                {
                                	$cls="odd" ;
                                }
                                else
                                {
                                	$cls="even"; 
                                }
                                $i++;
							} 
							?>
                        </table>
                        
                        <div class="pagecon">
                        <?php                                          
                          $this->widget('CLinkPager', array(
                          'currentPage'=>$pages->getCurrentPage(),
                          'itemCount'=>$item_count,
                          'pageSize'=>$page_size,
                          'maxButtonCount'=>5,
                          //'nextPageLabel'=>'My text >',
                          'header'=>'',
                        'htmlOptions'=>array('class'=>'pages'),
                        ));?>
                        
                        </div> <!-- END div class="pagecon" 2 -->
                        <div class="clear"></div>
                    </div> <!-- END div class="tablebx" -->
                    <?php 
					}
                    else
                    {
                    	echo '<div class="listhdg" align="center">'.Yii::t('app','Nothing Found!!').'</div>';	
                    }?>
                </div> <!-- END div class="list_contner" -->
                <!-- END List Content -->
                <br />
            </div> <!-- END div class="cont_right formWrapper" -->
            <!--</div> 
            </div>-->
        </td>
    </tr>
</table>
</body>
<script>
$('body').click(function() {
	$('#osload').hide();
	$('#name').hide();
	$('#admissionnumber').hide();
	$('#batch').hide();
	$('#cat').hide();
	$('#pos').hide();
	$('#grd').hide();
	$('#gender').hide();
	$('#marital').hide();
	$('#bloodgroup').hide();
	$('#nationality').hide();
	if($("#dobtxt").val().length <=0)
	{
		$('#dob').hide();
	}
	if($("#admdatetxt").val().length <=0)
	{
		$('#admission').hide();
	}
	$('#status').hide();
 
});

$('.filterbxcntnt_inner').click(function(event){
   event.stopPropagation();
});

$('.load_filter').click(function(event){
   event.stopPropagation();
});
function checkall()
{
	if(ch.checked)
	{ 
		$('.checkbox1').prop('checked', true);
	}
	else
	{
		$('.checkbox1').each(function() { //loop through each checkbox
		   this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		});         
	}
}
function selectcheck()
{
	var numberOfChecked = $('.checkbox1:checked').length; //count of all checked checkboxes with class "checkbox1"
	var totalCheckboxes = $('.checkbox1:checkbox').length; //count of all textboxes with class "checkbox1"
	if(numberOfChecked == totalCheckboxes)
		ch.checked=true;
	else
		ch.checked=false;	
}

function delete_all()
{
	var numberOfChecked = $('.checkbox1:checked').length; //count of all checked checkboxes with class "checkbox1"
	var totalCheckboxes = $('.checkbox1:checkbox').length; //count of all textboxes with class "checkbox1"
	var notChecked = $('.checkbox1:not(":checked")').length;//totalCheckboxes - numberOfChecked;
	
	if(numberOfChecked > 0)
	{		
		var favorite = [];
		$.each($("input[name='convs']:checked"), function(){            
			favorite.push($(this).val());
		});
		var r = confirm("<?php echo Yii::t('app','Are you sure ? Do you want to delete this?');?>");
		if(r==true)
		{
			
		window.location='<?php echo Yii::app()->getBaseUrl(true)?>/index.php?r=students/students/delete_all&id='+favorite;
		return true;
		}
		else
		{
		
		return false;
		}
	}else{
		alert("<?php echo Yii::t('app','Please select atleast one Student');?>");
		return false;
	}
}
</script>