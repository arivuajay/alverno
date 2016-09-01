<div class="pageheader">
  <h2><i class="glyphicon glyphicon-bookmark"></i> <?php echo Yii::t('app','Center');?> <span><?php echo Yii::t('app','View');?></span></h2>
  <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app','You are here:');?></span>
    <ol class="breadcrumb">
      <li></li><?php echo Yii::t('app','Center'); ?></li>
      <li class="active"><?php echo Yii::t('app','View');?></li>
    </ol>
  </div>
</div>
<div class="contentpanel">
  <div class="col-sm-9 col-lg-12">
    <div class="panel panel-default">
    	<?php $this->renderPartial('/center/tab');?>
      <div class="panel-heading" style="position:relative; height:60px;">
        <div class="btn-demo file_up" style="position:relative; top:-8px; right:3px; float:right;">
		<?php 
		$inactive_center = Center::model()->findByPk($id);
		if($inactive_center->status == 0){
				echo CHtml::Link(Yii::t('app','Activate'),array('/center/activate','id'=>$inactive_center->id),array('class'=>'btn btn-success'));
		}?>
		<?php echo CHtml::Link(Yii::t('app','Edit Upload Documents'),array('centerUploads/create','id'=>$id),array('class'=>'btn btn-success'));?></div>
        
        <!-- panel-btns -->
        <div class="clear"></div>
       <!-- <h3 class="panel-title">Centers </h3>-->
      </div>
      <div class="panel-body">
    
        <div class="table-responsive">
          <table class="table table-hover mb30">
            <tbody>
            <tr>
               <td>#</td> 
                <td><?php echo Yii::t('app','Name'); ?></td>
                <td><?php echo Yii::t('app','Type'); ?></td>
                <td></td> 
              </tr>
            <?php $documents = centerUploads::model()->findAllByAttributes(array('center_id'=>$_REQUEST['id'])); ?>
    <?php
			if($documents) // If documents present
			{
				$i =1;
				foreach($documents as $document) // Iterating the documents
				{
			?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $document->title;?></td><td><?php echo $document->file_type;?></td>
             	 <td> <?php echo CHtml::link(Yii::t('app','Download'), array('/centerUploads/download','id'=>$document->id,'center_id'=>$_REQUEST['id']),array('class'=>'btn btn-primary')); ?></td>
              </tr>
              <?php $i++; }} ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

   