        <div id="parent_Sect">
			<?php 
				echo $this->renderPartial('application.modules.studentportal.views.default.leftside'); 				
			?>
            <div class="pageheader">
              <div class="col-lg-8">
                <h2><i class="fa fa-file-text"></i><?php echo Yii::t('app','Library'); ?><span><?php echo Yii::t('app','View Library');?> </span></h2>
              </div>
              <div class="col-lg-2"> </div>
              <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app','You are here:');?></span>
                <ol class="breadcrumb">
                  <li class="active"><?php echo Yii::t('app','Book List');?></li>
                </ol>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="contentpanel">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo Yii::t('app','Book List'); ?></h3>
                  <div style="position:relative; top:-20px; right:3px; float:right;" class="btn-demo">
                    <div class="edit_bttns">
                      <ul>
                        <li> <?php echo CHtml::link(Yii::t('app','Search Books'),array('/library/book/booksearch'),array('class'=>'com_but')); ?> </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="but_right_con"> </div>
                  <?php
                    $bookdetails=Book::model()->findAll('is_deleted=:x',array(':x'=>0));?>
                  <div class="table-responsive">
                    <table class="table table-hover mb30">
                      <tr>
                        <th><?php echo Yii::t('app','ISBN');?></th>
                        <th><?php echo Yii::t('app','Book Name');?></th>
                        <th><?php echo Yii::t('app','Author');?></th>
                        <th><?php echo Yii::t('app','Edition');?></th>
                        <th><?php echo Yii::t('app','Publisher');?></th>
                        <th><?php echo Yii::t('app','Copies Available');?></th>
                        <th><?php echo Yii::t('app','Total Copies');?></th>
                      </tr>
                      <?php
                                            if($bookdetails!=NULL)
                                            {
                                            ?>
                      <?php foreach($bookdetails as $book)
                                                {
                                                    $author=Author::model()->findByAttributes(array('auth_id'=>$book->author));
                                                    $publication=Publication::model()->findByAttributes(array('publication_id'=>$book->publisher));
                                                    $available_copies = $book->copy - $book->copy_taken;
                                                ?>
                      <tr>
                        <td><?php echo $book->isbn;?></td>
                        <td><?php echo $book->title;?></td>
                        <td><?php 
                                                        if($author!=NULL)
                                                        {
                                                            echo CHtml::link(ucfirst($author->author_name), array('/library/authors/authordetails','id'=>$author->auth_id));
                                                        }
                                                        ?></td>
                        <td><?php echo $book->edition;?></td>
                        <td><?php 
                                                        if($publication!=NULL)
                                                        {
                                                            echo $publication->name;
                                                        }
                                                        ?></td>
                        <td><?php echo $available_copies;?></td>
                        <td><?php echo $book->copy; ?></td>
                      </tr>
                      <?php
                                                }
                                            }  // END if($bookdetails!=NULL)
                                            else
                                            {
                                                echo '<tr><td align="center" colspan="7">'.Yii::t('app','No data available').'</td></tr>';
                                            }
                                            ?>
                    </table>
                  </div>
                </div>
                
                <!-- END div class="profile_details" --> 
              </div>
  				<!-- END div class="parentright_innercon" -->
  
      		<div class="clear"></div>
    	</div> <!-- END div id="parent_rightSect" -->
	<div class="clear"></div> 
</div> <!-- END div id="parent_Sect" -->
	
