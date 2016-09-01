<style type="text/css">
	.w_step a.active { text-indent:1px ;
		color:#fff;} 
</style>
<?php
	$steps	= array(
		"step1"=>array(
			'step'=>1,
			'completed'=>false,
		),
		"step2"=>array(
			'step'=>2,
			'completed'=>false,
		),
		"step3"=>array(
			'step'=>3,
			'completed'=>false,
		),
		"finish"=>array(
			'step'=>4,
			'completed'=>false,
		),
		
	);	
	$caction	= Yii::app()->controller->action->id;
	$cstep		= isset($steps[$caction]['step'])?$steps[$caction]['step']:0;
	
	//students table - primary details
	$student_id	= $this->decryptToken((isset($_GET['token']))?$_GET['token']:NULL);
	$student	= Students::model()->findByPk($student_id);
	if($student!=NULL){
		$steps["step1"]["completed"]	= true;
		//students parent
		if($student->parent_id!=0){
			$steps["step2"]["completed"]	= true;
		}
		//students documents
		if($student->is_completed==3){
			$steps["step3"]["completed"]	= true;
		}
		if($student->is_completed==3){
			$steps["finish"]["completed"]	= true;
		}
		
	}
	
?>
<div class="wizard_con">
	<?php
    foreach($steps as $action=>$step){	
		$class	= "";
		$href	= "";
		if($action==$caction)
			$class	.= " current";	
		if($step['completed']){			
			$class	.= " active";
		}		
		if($caction!="finish" and $cstep!=$step['step'] and /*$step['step']!=1 and*/ ($step['completed'] or $steps['step'.($step['step'] - 1)]['completed'])){
			$href	= 'href="'.Yii::app()->createUrl('/onlineadmission/registration/'.$action, array('token'=>$_GET['token'])).'"';
		}
	?>
    <div class="w_step">
    	<a <?php echo $href;?> class="<?php echo $class;?>">
			<?php echo $step['step'];?>
        </a>
    </div>
    <?php
    }
	?>
</div>