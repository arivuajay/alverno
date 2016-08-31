<?php
$this->breadcrumbs=array(
	Yii::t('app','Borrow Books')=>array('/library'),
	Yii::t('app','StudentDetails'),
);
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>
<script language="javascript">
function booklist()
{
	var val=document.getElementById('student_id').value;
	window.location = "index.php?r=library/borrowBook/studentdetails&id="+val;
}

</script>
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
     <h1><?php echo Yii::t('app','View Student Details');?></h1>
     <div class="formCon">
    <div class="formConInner">
<?php echo '<strong>'.Yii::t('app','Select Student ID').'</strong>&nbsp;';
echo CHtml::dropDownList('Book ID',isset($_REQUEST['id'])? $_REQUEST['id'] : '',CHtml::listData(BorrowBook::model()->findAll(array('group'=>'student_id')),'student_id','studentadm'),
				array('prompt'=>Yii::t('app','Select'), 'onchange'=>"javascript:booklist();", 'id'=>'student_id'));
                     
                        if(isset($_REQUEST['id']))
						{
							$book=BorrowBook::model()->findAll('student_id=:t2',array(':t2'=>$_REQUEST['id']));
							$student=Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
							
							if($book!=NULL)
							{
								
						?>
                        </div>
                        </div>
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
<?php foreach($book as $book_1)
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
<td align="center"><?php 
if($author!=NULL)
{
echo CHtml::link($author->author_name,array('/library/authors/authordetails','id'=>$author->auth_id));
}
?></td>
<td align="center"><?php 
						$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($book_1->issue_date));
									echo $date1;
		
								}
								else
								echo $book_1->issue_date;
							?></td>
<td align="center"><?php 
							if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($book_1->due_date));
									echo $date1;
		
								}
								else
								echo $book_1->due_date;
							?></td>
<td align="center">
<?php 
if($book_1->status=='R')
{
	echo Yii::t('app','Yes');
}
else
{
	echo Yii::t('app','No');
}
?>
</td>
</tr>
<?php }
				} 
				else
				{
					echo '<tr><td colspan="5">'.Yii::t('app','No data available').'</td></tr>';
				}
				 ?>
</table>
</div>
</div>
</td>
</tr>
</table>
<?php } ?>
<?php $this->endWidget(); ?>