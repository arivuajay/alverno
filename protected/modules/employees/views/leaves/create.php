

<div id="parent_Sect">
	<?php $this->renderPartial('/default/leftside');?> 
        
    <div class="right_col"  id="req_res123">                                      
          
        <div id="parent_rightSect">
            <div class="parentright_innercon">
                 <h1><?php echo Yii::t('app','Leaves'); ?></h1>

				
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>     
        	</div>
        </div>
        <div class="clear"></div>
    </div>
</div>
