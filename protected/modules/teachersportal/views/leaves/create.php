<?php echo $this->renderPartial('application.modules.teachersportal.views.default.leftside'); ?>
<div class="pageheader">
  <h2><i class="fa fa-gear"></i> <?php echo Yii::t("app", "Settings");?> <span><?php echo Yii::t("app", "Your settings here");?></span></h2>
  <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t("app", "You are here:");?></span>
    <ol class="breadcrumb">
      <!--<li><a href="index.html">Home</a></li>-->
      <li class="active"><?php echo Yii::t("app", "Settings");?></li>
    </ol>
  </div>
</div>
<div class="contentpanel"  id="req_res123">
   
  
        <?php echo $this->renderPartial('_form', array('model'=>$model,'type2'=>$type,'list'=>$list,
		'pages' => $pages,
		'item_count'=>$item_count,
		'page_size'=>$page_size,)); ?> </div>
   
  </div>

