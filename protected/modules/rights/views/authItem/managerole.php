<?php $this->breadcrumbs = array(
	//'Rights'=>Rights::getBaseUrl(),
	Yii::t('app', 'Settings')=>array('/configurations'),
	Yii::t('app', 'User Roles'),
	Yii::t('app', 'Manage Roles')=>array('authItem/manageroles'),	
);?>

<h1><?php echo Yii::t('app', 'Manage Roles'); ?></h1>

<div class="formCon">
	<div class="formConInner">
    	<div class="tablebx">
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
            </div> <!-- End div class="pagecon" --> 
        	<table width="96%" border="0" cellspacing="0" cellpadding="0">
                <tr class="tablebx_topbg">
                    <td><?php echo Yii::t('app','Sl. No.');?></td>	
                    <td><?php echo Yii::t('app','User Role');?></td>
					<td><?php echo Yii::t('app','Description');?></td>                 
                    <td><?php echo Yii::t('app','Action');?></td>
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
					foreach($posts as $post)
					{
					?>
						<tr class=<?php echo $cls;?>>
						<td><?php echo $i; ?></td>
						<td><?php echo $post->name; ?></td>
                        <td><?php 
								if($post->description==NULL or $post->description==''){
									echo '--'; 
								}else{
									echo $post->description;
								}								
							?></td>
						<td><?php echo CHtml::link(Yii::t('app','Edit'),array('editrole','rid'=>$post->id)).' | '.CHtml::link(Yii::t('app','Delete'),array('deleterole','rid'=>$post->id),array('confirm' =>Yii::t('app','Are you sure you want to delete this role?'))); ?></td>
                        </tr>
             <?php  $i++;} ?>   
            </table>    
        </div>
    </div>
</div>    