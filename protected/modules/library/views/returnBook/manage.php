<?php
$this->breadcrumbs=array(
	Yii::t('app','Borrow Books')=>array('/library'),
	Yii::t('app','Student Details'),
);

$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'borrow-book-form',
	'enableAjaxValidation'=>false,
)); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
        	<?php $this->renderPartial('/settings/library_left');?>
        </td>
        <td valign="top">
            <div class="cont_right">  
                <h1><?php echo Yii::t('app','Return Book Details');?></h1>
                <div class="formCon">
                    <div class="formConInner">
						<?php
                        echo '<strong>'.Yii::t('app','Student Admission No').' </strong>';
                        $data = Students::model()->findAll(array(
                        'join' => 'JOIN borrow_book ON t.id 	 = borrow_book.student_id',
                        'condition' => 'borrow_book.status =:x',
                        'distinct'=>true,
                        'params' => array(':x'=>'C'),
                        )) ;
                        
                        echo CHtml::dropDownList('BookID','',CHtml::listData($data,'id','admission_no'),array('prompt'=>Yii::t('app','Select'),'options'=>array($_REQUEST['id']=>array('selected'=>true)),'id'=>'book_id','submit'=>array('/library/ReturnBook/manage')));
                        ?>
                    </div> <!-- END div class="formConInner" -->
				</div> <!-- END div class="formCon" -->
                <?php
				$current_academic_yr = Configurations::model()->findByAttributes(array('id'=>35));
				if(Yii::app()->user->year)
				{
					$year = Yii::app()->user->year;
				}
				else
				{
					$year = $current_academic_yr->config_value;
				}
				$is_insert = PreviousYearSettings::model()->findByAttributes(array('id'=>2));
				if($year != $current_academic_yr->config_value and $is_insert->settings_value==0)
				{
				?>
                	<div>
                        <div class="yellow_bx" style="background-image:none;width:95%;padding-bottom:45px;">
                            <div class="y_bx_head" style="width:95%;">
                            <?php 
                                echo Yii::t('app','You are not viewing the current active year. ');
                                echo Yii::t('app','To return the book, enable the Insert option in Previous Academic Year Settings.');	
                            ?>
                            </div>
                            <div class="y_bx_list" style="width:95%;">
                                <h1><?php echo CHtml::link(Yii::t('app','Previous Academic Year Settings'),array('/previousYearSettings/create')) ?></h1>
                            </div>
                        </div>
					</div> <br />
                <?php
				}
				?>
                <?php 
                if(isset($_REQUEST['id']))
                {
					$book=BorrowBook::model()->findAll('student_id=:t2',array(':t2'=>$_REQUEST['id']));
					$student=Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
                ?>
                    <div class="pdtab_Con" style="padding:0px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                            <tr class="pdtab-h">
                            	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                <td align="center"><?php echo Yii::t('app','Student Name');?></td>
                                <?php } ?>
                                <td align="center"><?php echo Yii::t('app','ISBN');?></td>
                                <td align="center"><?php echo Yii::t('app','Book Name');?></td>
                                <td align="center"><?php echo Yii::t('app','Author');?></td>
                                <td align="center"><?php echo Yii::t('app','Issue Date');?></td>
                                <td align="center"><?php echo Yii::t('app','Due Date');?></td>
                                <td align="center"><?php echo Yii::t('app','Is returned');?></td>
                            </tr>
                        
                        <?php 
                        if($book!=NULL)
                        {
							foreach($book as $book_1)
                        	{
								$bookdetails=Book::model()->findByAttributes(array('id'=>$book_1->book_id));
								$author=Author::model()->findByAttributes(array('auth_id'=>$bookdetails->author));
								$publication=Publication::model()->findByAttributes(array('publication_id'=>$bookdetails->publisher));
								?>
								<tr>
                                	<?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
                                    <td align="center"><?php echo $student->studentFullName("forStudentProfile");?></td>
                                    <?php } ?>
                                    <td align="center"><?php echo $bookdetails->isbn;?></td>
                                    <td align="center"><?php echo $bookdetails->title;?></td>
                                    <td align="center">
									<?php 
                                    if($author!=NULL)
                                    {
                                    	echo CHtml::link($author->author_name,array('/library/authors/authordetails','id'=>$author->auth_id));
                                    }
                                    ?>
                                    </td>
                                    <td align="center">
									<?php 
									$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
											if($settings!=NULL)
											{	
												$date1=date($settings->displaydate,strtotime($book_1->issue_date));
												echo $date1;
					
											}
											else
											echo $book_1->issue_date;
										?>
									</td>
                                    <td align="center">
									<?php 
									if($settings!=NULL)
										{	
											$date1=date($settings->displaydate,strtotime($book_1->due_date));
											echo $date1;
				
										}
										else
											echo $book_1->due_date;
									?>
                                    </td>
                                    <td align="center">
                                    <?php 
                                    if($book_1->status=='R')
                                    {
                                    	echo 'Yes';
                                    }
                                    else
                                    {
										if(($year == $current_academic_yr->config_value) or ($year != $current_academic_yr->config_value and $is_insert->settings_value!=0))
										{
                                    		echo CHtml::link(Yii::t('app','Return Book'),array('/library/ReturnBook/create','id'=>$book_1->student_id),array('confirm'=>Yii::t('app','Are you sure?')));
										}
										else
										{
											echo Yii::t('app','Not Returned');
										}
                                    }
                                    ?>
                                    </td>
								</tr> 
							<?php 
							} // END foreach($book as $book_1)
						} 
						else
						{
							echo '<tr><td align="center" colspan="7">'.Yii::t('app','No data available').'</td></tr>';
						}
						?>
                        </table>
                    </div> <!-- END div class="pdtab_Con" -->
                <?php 
                } 
                ?>
            </div> <!-- END div class="cont_right" -->
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>