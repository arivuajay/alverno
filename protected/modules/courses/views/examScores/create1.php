<?php
$this->breadcrumbs=array(
	Yii::t('app','Exam Scores')=>array('/courses'),
	Yii::t('app','Create'),
);
?>
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
    
    
        
    <div class="edit_bttns">
    <ul>
    <?php /*?><li>
    <a class=" edit last" href="#">Edit</a>    </li><?php */?>
    </ul>
    </div>
    
    
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    
     <?php $this->renderPartial('/batches/tab');?>
        
    <div class="clear"></div>
    <div class="emp_cntntbx">

	<h1><?php echo Yii::t('app','Exams');?></h1>
<?php echo $this->renderPartial('_form2', array('model'=>$model)); ?>

</div></div></div></div>
    </td>
  </tr>
</table>
</div>