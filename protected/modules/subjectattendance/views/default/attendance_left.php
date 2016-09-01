<div align="left" id="othleft-sidebar">
<!--<div class="lsearch_bar">
             	<input type="text" value="Search" class="lsearch_bar_left" name="">
                <input type="button" class="sbut" name="">
                <div class="clear"></div>
  </div>-->
<h1>Attendance Register</h1>
 <ul>
 <li><?php echo CHtml::link('Teacher Register<span>Teacher Attendance Register</span>',array('#'),array('class'=>'sbook_ico'));
?>
</li>
 <li><?php echo CHtml::link('Student Register<span>Student Attendance Register</span>',array('#'),array('class'=>'lbook_ico'));
?>
</li>
<h1>Attendance Reports</h1>
 <li>
<?php echo CHtml::link('Teacher Attendance<span>Teacher Attendance Report</span>',array('#'),array('class'=>'abook_ico'));
?>
<?php echo CHtml::link('Student Attendance<span>Student Attendance Report</span>',array('#'),array('class'=>'abook_ico'));
?>
</li>
 <h1>Teacher Attendance Settings</h1>
 <li>
<?php echo CHtml::link('Add Leave Type<span>Manage Teacher Leave Type</span>',array('#'),array('class'=>'abook_ico'));
?>
</li>

</ul>

</div>