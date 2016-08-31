<?php
$this->breadcrumbs=array(
	Yii::t('app','Return Books')=>array('/library'),
	Yii::t('app','View'),
);

/*$this->menu=array(
	array('label'=>'List ReturnBook', 'url'=>array('index')),
	array('label'=>'Create ReturnBook', 'url'=>array('create')),
	array('label'=>'Update ReturnBook', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReturnBook', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReturnBook', 'url'=>array('admin')),
);*/
$student_visible_fields   = FormFields::model()->getVisibleFields('Students', 'forStudentProfile');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">

 <?php $this->renderPartial('/settings/library_left');?>
 </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1><?php echo Yii::t('app','View ReturnBook'); ?></h1>


<?php


$borrow=BorrowBook::model()->findByAttributes(array('id'=>$model->borrow_book_id));
$book=Book::model()->findByAttributes(array('id'=>$borrow->book_id));
$student=Students::model()->findByAttributes(array('id'=>$borrow->student_id));
?>
<div class="pdtab_Con">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr class="pdtab-h">
 <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
 <td align="center"><?php echo Yii::t('app','Student Name'); ?></td>
 <?php } ?>
 <td align="center"><?php echo Yii::t('app','Book'); ?></td>
 <td align="center"><?php echo Yii::t('app','Issued Date'); ?></td>
 <td align="center"><?php echo Yii::t('app','Return date'); ?></td>
 <td align="center"><?php echo Yii::t('app','Status'); ?></td>

 </tr>
 <tr>
 <?php if(FormFields::model()->isVisible("fullname", "Students", "forStudentProfile")){ ?>
 <td align="center"><?php echo $student->studentFullName("forStudentProfile");?></td>
 <?php } ?>
 <td align="center"><?php echo $book->title;?></td>
 <td align="center"><?php 
 			$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->issue_date));
									
		
								}
								else
								{
									$date1 = $model->issue_date;
									
								}
								echo $date1;
                     ?>
 </td>
 <td align="center"><?php 
 					if($settings!=NULL)
								{	
									$date2=date($settings->displaydate,strtotime($model->return_date));
									
		
								}
								else
								{
									$date2 = $model->return_date;
								}
								echo $date2;
					?>
   </td>
  <td align="center"><?php 
  if($model->return_date > $borrow->due_date)
  {
	  echo Yii::t('app','Due date expired');
	 // echo Yii::t('app','Due date expired'. ' | '. CHtml::link('Pay Fine',array('/library/ReturnBook/fine','id'=>$borrow->student_id)));
	 
  }
  else
  {
	 echo Yii::t('app','No fine');
	 
	  
  }
  
  ?></td>
 
 </tr>
 </table>
</div>
</div>
</td>
</tr>
</table>


