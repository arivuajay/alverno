<style type="text/css">

.file_name ul{ margin:0px;
	padding:0px;}
.file_name ul li{
		margin:3px 14px;
		float:left}
</style>

<div class="col-md-12 se_panel_formwrap">
    <div class="wiz_right">
    <script>
	function addRow(tableID) 
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if(rowCount < 10)// limit the user from creating fields more than your limits
		{
			var row = table.insertRow(rowCount);
			var colCount = table.rows[0].cells.length;
			for(var i=0; i<colCount; i++) 
			{
				var newcell = row.insertCell(i);
				newcell.innerHTML = "&nbsp;";
			}   
			rowCount++;                     
			for(var j=0; j<2; j++)
			{
				var row = table.insertRow(rowCount);
				var colCount = table.rows[j].cells.length;
				for(var i=0; i<colCount; i++) 
				{
					var newcell = row.insertCell(i);
					newcell.innerHTML = table.rows[j].cells[i].innerHTML;
				}
				rowCount++;
			}
			addDiv("student_id");
			addDiv("file_type");
			addDiv("created_at");
		}
		else
		{			 
			 alert("<?php echo Yii::t('app','Upload limit reached'); ?>");				   
		}
	}
	
	function addDiv(divID)
	{
		var divTag = document.createElement("div");
		divTag.className = "row";
		divTag.innerHTML = document.getElementById(divID).innerHTML;
		document.getElementById("innerDiv").appendChild(divTag);
	}
</script>
<?php 
	$token		= isset($_GET['token'])?$_GET['token']:NULL;
	$student_id	= $this->decryptToken($token);
	
?>

<div class="panel panel-default">
	<div class="panel-heading" style="position:relative;">
    	<div class="clear"></div>
        	<h3 class="panel-title"><?php echo Yii::t('app','Upload Documents'); ?></h3>
            
  </div>
  <?php $documents = StudentDocument::model()->findAllByAttributes(array('student_id'=>$student_id)); 
  		
  ?>
    <?php
			if($documents) // If documents present
			{
				foreach($documents as $document) // Iterating the documents
				{
					$studentDocumentList = StudentDocumentList::model()->findByAttributes(array('id'=>$document->title));
			?>		
                <div class="panel-body document_list">
                <div class="col-sm-8"><h5 class="subtitle"><?php echo ucfirst($studentDocumentList->name);?></h5></div>
                <div class="col-sm-4">
                <span class="btn btn-primary">
				<i class="glyphicon glyphicon-edit"></i>
				<?php echo CHtml::link(Yii::t('app','Edit'), array('registration/documentUpdate','token'=>$this->encryptToken($student_id),'document_id'=>$document->id),array('class'=>''));  ?></span>
                <span class="btn btn-danger">
				<i class="glyphicon glyphicon-trash"></i>
				<?php echo CHtml::link(Yii::t('app','Delete'), array('registration/deletes','token'=>$this->encryptToken($student_id),'document_id'=>$document->id),array('class'=>'','confirm'=>Yii::t('app','Are you sure?')));  ?></span>
                </div>
                </div>
    <?php }}else{ ?>
		
		<div class="panel-body document_list">
    	<div class="col-sm-8"><h5 class="subtitle"><?php echo Yii::t('app','No document(s) uploaded'); ?></h5></div>
        </div>
		
	<?php } ?>
    
</div>


<div class="panel panel-default">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'center-upload-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	
)); ?>
	<div class="form">
    <div class="panel-body">



	<?php 
		if($form->errorSummary($model)){
	?>
        <div class="errorSummary"><?php echo Yii::t('app','Input Error'); ?><br />
        	<span><?php echo Yii::t('app','Please fix the following error(s).'); ?></span>
        </div>
    <?php } ?>
    
  	<p class="note" style="float:left"><?php echo Yii::t('app','Fields with').' <span class="required">*</span> '.Yii::t('app','are required.'); ?></p>
    
    <?php
		$required = StudentDocumentList::model()->findAllByAttributes(array('is_required'=>1)); 
		
	?><br />
  <?php if(isset($required) and $required!=NULL){ ?>  
    <div class="col-sm-12" style="padding:10px 0px; color: #F00">
    	<div class="col-sm-4" style="padding:0px"><?php echo Yii::t('app','These documents are required :').' ';?></div>
        <div class="col-sm-8" style="padding:0px">
        
        <div  class="file_name">
        <ul> 
		<?php
            foreach($required as $required_name)
            {
                echo '<li>'.ucfirst($required_name->name).'&nbsp;&nbsp;&nbsp</li>';
            }
            ?>
            </ul>
            </div>
            </div>
        <div class="col-sm-4"></div>
    </div>
  <?php } ?>      
    
    <?php
	
	Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$(".error1").animate({opacity: 1.0}, 3000).fadeOut("slow");',
	   CClientScript::POS_READY
	);
	?>
	<?php
	if(Yii::app()->user->hasFlash('errorMessage')): 
	?>
	<div class="error1" style="color:#C00; padding-left:200px;">
		<?php echo Yii::app()->user->getFlash('errorMessage'); ?>
	</div>
	<?php
	endif;
		
	?>
 <div class="formCon" style="clear:left;">
        <div class="formConInner" id="innerDiv">
      
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="documentTable">
            	<tr>
                	<td ><?php echo $form->labelEx($model,Yii::t('app','Document Name').'*'); ?></td>
                    <td><?php echo $form->labelEx($model,'file'); ?></td>
                </tr>
          <?php
		  $criteria = new CDbCriteria;
		  $criteria->join = 'LEFT JOIN student_document osd ON osd.title = t.id and osd.student_id = '.$student_id.'';
		  $criteria->addCondition('osd.title IS NULL');
		  ?>       
                <tr>
                	<td>
						 <div style="padding-right:20px;"><?php echo $form->dropDownList($model,'title[]',CHtml::listData(StudentDocumentList::model()->findAll($criteria), 'id', 'name'),array('prompt' => Yii::t('app','Select Document Type'),'class'=>'form-control mb15')); ?>
                         <?php echo $form->error($model,'title'); ?></div>
                    </td>
                    <td>
                    <div style="padding-top:15px;">
						<?php echo $form->fileField($model,'file[]'); ?>
                        <?php echo $form->error($model,'file'); ?>
                        <p style="font-size:11px;"><?php echo '('.Yii::t('app','Only files with these extensions are allowed: jpg, png, pdf, doc, txt.').')'; ?></p>
                    </div>
                    </td>
                    
                </tr>
            </table>
            </div></div>
            <div class="row" style="padding-top:20px;">
                <?php echo $form->hiddenField($model,'document',array('value'=>1)); ?>
                <?php echo $form->error($model,'document'); ?>    
            </div>
			
            <?php /*?><div class="row">
                <?php echo $form->hiddenField($model,'student_id',array('value'=>$_REQUEST['id'])); ?>
                <?php echo $form->error($model,'sid'); ?>    
            </div><?php */?>
			
            <?php /*?><div class="row" id="student_id">
                <?php echo $form->hiddenField($model,'center_id[]',array('value'=>$_REQUEST['id'])); ?>
                <?php echo $form->error($model,'center_id'); ?>
            </div><?php */?>
        
            <div class="row" id="file_type">
                <?php //echo $form->labelEx($model,'file_type'); ?>
                <?php echo $form->hiddenField($model,'file_type[]'); ?>
                <?php echo $form->error($model,'file_type'); ?>
            </div>
        
            <div class="row" id="created_at">
                <?php //echo $form->labelEx($model,'created_at'); ?>
                <?php echo $form->hiddenField($model,'created_at[]'); ?>
                <?php echo $form->error($model,'created_at'); ?>
            </div>
     
    <div >
         <?php     echo CHtml::ajaxLink(Yii::t('app','Add Another'),array('addrow','id'=>$student_id), 
				array (
					
					'type'=>'POST',
					'dataType'=>'json',
					'success'=>'function(html){ jQuery("#innerDiv").append(html);
					 }'
					), 
				array ('class'=>'btn btn-primary')
				); ?>
             <?php //echo CHtml::button('Add Another', array('class'=>'btn btn-primary','id'=>'addAnother','onclick'=>'addRow("documentTable");')); ?>
        <?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'btn btn-success')); ?>
    </div>
    	



</div>
<div class="panel-footer">
      <?php
	  $required = StudentDocumentList::model()->findAllByAttributes(array('is_required'=>1));
	  $count_required = count($required);
	  $id = array();
	  $uploadCount = 0; 
	  foreach($required as $require)
	  {
		  $uploads = StudentDocument::model()->findByAttributes(array('student_id'=>$student_id,'title'=>$require->id));
		  if($uploads)
		  {
		  	$uploadCount++;
		  }
	  }
	  	
	  if($count_required == $uploadCount)
	  { 
	   echo CHtml::Link(Yii::t('app','Finish'),array('registration/finish','token'=>$this->encryptToken($student_id)),array('class'=>'btn btn-orange')); 
	  }
     ?>
     </div>
<!-- form -->
</div><?php $this->endWidget(); ?>
</div>
    </div>
</div>    