<div class="se_panel">
        <div class="col-md-12 se_header">
        	<?php /*?><div class="col-sm-4 se_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg" ></div><?php */?>
            <?php $logo=Logo::model()->findAll();?>
        	<div class="col-sm-4 se_logo"><?php 
			if($logo!=NULL)
			{
				echo '<img src="'.Yii::app()->request->baseUrl.'/uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" border="0" height="55" />';
			}
			?></div>
            <div class="col-sm-8 se_head"> <h2><?php echo Yii::t('app','Student Enrolment - Student Document'); ?></h2></div>
        </div>
        <div class="row"> 
        <div style="min-height:550px;">           
            <div class="col-md-4">
                  <?php $this->renderPartial('_leftside'); ?>
            </div><!-- col-sm-6 -->
            
            <div class="col-md-8 ">
            	<?php $this->renderPartial('_wizard');?>                
                <?php $this->renderPartial('_formupdate', array('model'=>$model, 'token'=>$token));?>                
            </div><!-- col-sm-6 -->
            </div>
        </div><!-- row -->
        <div class="clearfix"></div>
       <div class="signup-footer">
        
         © <?php echo date('Y'); ?> Open-School. All rights reserved.
        
      </div> 
        
        
    </div>

