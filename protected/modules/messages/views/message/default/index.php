<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Messages')=>array('/message'),	
);

?>
<div style="background:#FFF;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" >
            <div style="padding:0px 20px 20px 20px;">
            <div align="right">
            <div style="padding:6px 0px;">
            <?php $form=$this->beginWidget('CActiveForm'); ?>
            	<table width="26%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type="checkbox" name="dontshow" id="checkbox" />
      <label for="checkbox"></label></td>
    <td style="font-size:11px; color:#999"><strong><?php echo Yii::t('app', "Don't show this messages again.");?></strong></td>
    <td><input name="hide" type="submit" class="wel_subbut"  value="<?php echo Yii::t('app', "Hide");?>" /></td>
  </tr>
</table>
<?php $this->endWidget(); ?>
</div>
		
            </div>	
            
              <div class="welcome_Con">
                <h1><?php echo Yii::t('app', "Congratulations, Your Open-School Setup is Complete !");?></h1>
                <p><?php echo Yii::t('app', "Your Open-School System is up and running. If you need live assistance when you're on the application, <br/>do click the chat box at the bottom right of the screen and ask away.");?></p>
                </div>
              <div class="yellow_bx">
                <div class="thakyo_strip"></div>
                <div class="y_bx_head">
                  <?php echo Yii::t('app', "It appears that this is the first time that you are using this Open-School setup. For any new installation we recommend that you configure the following:");?>
                  </div>
                <div class="y_bx_list">
                  <h1><?php echo Yii::t('app', "Create Your School Configurations");?></h1>
                  <p><?php echo Yii::t('app', "Before Creating Timetable, Attendance and Examinations, make sure you completed your school configurations like School name, Logo and School Timings.");?> <br/><?php echo CHtml::link(Yii::t('app', 'Application Configurations'),array('/configurations/create')) ?></p>
                  </div>
                <div class="y_bx_list">
                  <h1><?php echo Yii::t('app', "Add New Course and").' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id");?></h1>
                  <p><?php echo Yii::t('app', "After Creating your School Courses and").Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app',"You will be able to create attendance, Generate Timetable, Create Exams and Collect Fees.");?><br/><?php echo CHtml::link(Yii::t('app', 'Create New Course and').' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"),array('/courses/courses/create')) ?></p>
                  </div>
                <div class="y_bx_list">
                  <h1><?php echo Yii::t('app', "Create New Students");?></h1>
                  <p><?php echo Yii::t('app', "Before Creating Students, make sure you created Student Categories and the Cources and").' '.Yii::app()->getModule('students')->fieldLabel("Students", "batch_id").' '.Yii::t('app',"for enrolling Students.");?><br/><?php echo CHtml::link(Yii::t('app', 'Create New Student'),array('/students/students/create')) ?></p>
                  </div>
                <div class="y_bx_list">
                  <h1><?php echo Yii::t('app', "Create New Teacher");?></h1>
                  <p><?php echo Yii::t('app', "Before Creating Teacher, make sure you created Teacher Categories, Teacher Departments and Teacher Positions.");?><br/><?php echo CHtml::link(Yii::t('app', 'Create New Teacher'),array('/employees/employees/create')) ?></p>
                  </div>
                <div class="y_bx_list">
                  <h1><?php echo Yii::t('app', "Roles and Permissions");?></h1>
                  <p><?php echo Yii::t('app', "By using roles and, you have the ability to control who has access your Open-School installation.");?><br/><?php echo CHtml::link(Yii::t('app', 'User Management'),array('/user/admin')) ?></p>
                  </div>
                
                </div>
            </div>
          </td>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
        <script type="text/javascript">

	$(document).ready(function () {
            //Hide the second level menu
            $('#othleft-sidebar ul li ul').hide();            
            //Show the second level menu if an item inside it active
            $('li.list_active').parent("ul").show();
            
            $('#othleft-sidebar').children('ul').children('li').children('a').click(function () {                    
                
                 if($(this).parent().children('ul').length>0){                  
                    $(this).parent().children('ul').toggle();    
                 }
                 
            });
          
            
        });
    </script>