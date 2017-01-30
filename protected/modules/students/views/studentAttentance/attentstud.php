<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Student Attentances') => array('/courses'),
    Yii::t('app', 'Attendance'),
);
?>
<style>
    .attendance_table{
        border-top:1px #C5CED9 solid;
        margin:30px 0px;
        font-size:12px;
        border-right:1px #C5CED9 solid;
    }
    .attendance_table td{
        border-left:1px #C5CED9 solid;
        padding:5px 6px;
        border-bottom:1px #C5CED9 solid;

    }

    hr{ border-bottom:1px solid #C5CED9; border-top:0px solid #fff;}
</style>

<?php

function getweek($date, $month, $year) {
    $date = mktime(0, 0, 0, $month, $date, $year);
    $week = date('w', $date);
    switch ($week) {
        case 0:
            return 'S<br>';
            break;
        case 1:
            return 'M<br>';
            break;
        case 2:
            return 'T<br>';
            break;
        case 3:
            return 'W<br>';
            break;
        case 4:
            return 'T<br>';
            break;
        case 5:
            return 'F<br>';
            break;
        case 6:
            return 'S<br>';
            break;
    }
}
?>

<?php
$model1 = new EmployeeAttendances;
if (isset($_REQUEST['id'])) {

    if (!isset($_REQUEST['mon'])) {
        $mon = date('F');
        $mon_num = date('n');
        $curr_year = date('Y');
    } else {
        $mon = $model1->getMonthname($_REQUEST['mon']);
        $mon_num = $_REQUEST['mon'];
        $curr_year = date('Y');
    }
    $num = cal_days_in_month(CAL_GREGORIAN, $mon_num, $curr_year); // 31
    ?>

    <!-- Header -->

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="first">
    <?php $logo = Logo::model()->findAll(); ?>
    <?php
    if ($logo != NULL) {
        //Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
        echo '<img src="uploadedfiles/school_logo/' . $logo[0]->photo_file_name . '" alt="' . $logo[0]->photo_file_name . '" class="imgbrder" height="100" />';
    }
    ?>
            </td>
            <td align="center" valign="middle" class="first" style="width:300px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="listbxtop_hdng first" style="text-align:left; font-size:22px;   padding-left:10px;">
                <?php $college = Configurations::model()->findAll(); ?>
                <?php echo $college[0]->config_value; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                            <?php echo $college[1]->config_value; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
    <?php echo Yii::t('app', 'Phone:') . ' ' . $college[2]->config_value; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <hr />
    <!-- End Header -->
    <br />
    <div align="center" style="text-align:center; display:block;"><?php echo Yii::t('app', 'STUDENT ATTENDANCE'); ?></div><br />
    <!-- Student details -->

    <table style="font-size:14px; background:#DCE6F1; padding:10px 10px;border:#C5CED9 1px solid;">
    <?php
    $student = Students::model()->findByAttributes(array('id' => $_REQUEST['id']));
    ?>
        <tr>
    <?php
    if (FormFields::model()->isVisible("fullname", "Students", 'forStudentProfile')) {
        ?>
                <td style="width:150px;"><?php echo Yii::t('app', 'Name'); ?></td>
                <td style="width:10px;">:</td>
                <td style="width:350px;"><?php echo $student->studentFullName('forStudentProfile'); ?></td>
            <?php
            } else {
                ?>
                <td style="width:150px;"></td>
                <td style="width:10px;"></td>
                <td style="width:350px;"></td>
                <?php
            }
            ?>

            <td width="150"><?php echo Yii::t('app', 'Admission Number'); ?></td>
            <td style="width:10px;">:</td>
            <td width="350"><?php echo $student->admission_no; ?></td>

            <?php /* ?><td><b>Month</b></td>
              <td style="width:10px;">:</td>
              <td><?php echo $mon.' '.$_REQUEST['year']; ?></td><?php */ ?>
        </tr>

        <tr>
    <?php
    $batch = Batches::model()->findByAttributes(array('id' => $student->batch_id));
    $course = Courses::model()->findByAttributes(array('id' => $batch->course_id));

    //find working days.............
    $batch_start = date('Y-m-d', strtotime($batch->start_date));
    $batch_end = date('Y-m-d', strtotime($batch->end_date));
    $days = array();
    $batch_days = array();
    $batch_range = StudentAttentance::model()->createDateRangeArray($batch_start, $batch_end);
    $batch_days = array_merge($batch_days, $batch_range);

    $weekArray = array();
    $weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x' => $batch->id, ':y' => "0"));
    if (count($weekdays) == 0)
        $weekdays = Weekdays::model()->findAll("batch_id IS NULL AND weekday<>:y", array(':y' => "0"));

    foreach ($weekdays as $weekday) {
        $weekday->weekday = $weekday->weekday - 1;
        if ($weekday->weekday <= 0) {
            $weekday->weekday = 7;
        }
        $weekArray[] = $weekday->weekday;
    }
    foreach ($batch_days as $batch_day) {
        $week_number = date('N', strtotime($batch_day));
        if (in_array($week_number, $weekArray)) { // If checking if it is a working day
            array_push($days, $batch_day);
        }
    }



    //find working days.............
    ?>
            <td><?php echo Yii::t('app', 'Course'); ?></td>
            <td>:</td>
            <td>
            <?php
            if ($course->course_name != NULL)
                echo ucfirst($course->course_name);
            else
                echo '-';
            ?>
            </td>

            <?php if (FormFields::model()->isVisible('batch_id', 'Students', 'forStudentProfile')) { ?>
                <td><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id"); ?></td>
                <td>:</td>
                <td>
                    <?php
                    if ($batch->name != NULL)
                        echo ucfirst($batch->name);
                    else
                        echo '-';
                    ?>
                </td>
            <?php } ?>

        </tr>
        <tr>
            <td><?php echo Yii::t('app', 'Month'); ?></td>
            <td>:</td>
            <td colspan="4"><?php echo $mon . ' ' . $_REQUEST['year']; ?></td>
        </tr>

    </table>

    <!-- END Student details -->

    <!-- Attendance table -->

    <table width="100%" cellspacing="0" cellpadding="0" class="attendance_table">
        <tr style="background:#DCE6F1;">
    <?php
    $holidays = Holidays::model()->findAll();
    $holiday_arr = array();
    foreach ($holidays as $key => $holiday) {
        if (date('Y-m-d', $holiday->start) != date('Y-m-d', $holiday->end)) {
            $date_range = StudentAttentance::model()->createDateRangeArray(date('Y-m-d', $holiday->start), date('Y-m-d', $holiday->end));
            foreach ($date_range as $value) {
                $holiday_arr[$value] = $holiday->id;
            }
        } else {
            $holiday_arr[date('Y-m-d', $holiday->start)] = $holiday->id;
        }
    }

    for ($i = 1; $i <= $num; $i++) {
        echo '<td width="8" align="center">' . getweek($i, $mon_num, $curr_year) . '<span>' . $i . '</span></td>';
    }
    ?>
        </tr>
            <?php
            $posts = Students::model()->findByAttributes(array('id' => $_REQUEST['id']));
            $class = 'class="even"';
            ?>
        <tr align="center" valign="top" <?php echo $class; ?> >
            <?php /* ?> <td class="name"><?php echo $posts->first_name; ?></td><?php */ ?>
            <?php
            $holiday_1 = 0;
            for ($i = 1; $i <= $num; $i++) {
                echo '<td style="height:300px;" align="center" valign="top">';

                $week = date('w', strtotime("{$_REQUEST['year']}-{$mon_num}-{$i}")) + 1;
                $time_table = TimetableEntries::model()->findAll("batch_id = :batch AND weekday_id = :week", array(":batch" => $student->batch_id, ":week" => $week));
                if ($time_table) {
                    foreach ($time_table as $k => $period) {
//                        echo '<span  id="td' . $i . $posts_1->id . '">';
//                        $pno = $k + 1;
//                        echo $this->renderPartial('ajax', array('day' => $i, 'month' => $mon_num, 'year' => $curr_year, 'emp_id' => $posts_1->id, 'days' => $days, 'holiday_arr' => $holiday_arr, 'pno' => $pno, 'period' => $period));
//                        /* echo CHtml::ajaxLink(Yii::t('job','ll'),$this->createUrl('EmployeeAttendances/addnew'),array(
//                          'onclick'=>'$("#jobDialog").dialog("open"); return false;',
//                          'update'=>'#jobDialog','type' =>'GET','data'=>array('day' =>$i,'month'=>$mon_num,'year'=>'2012','emp_id'=>$posts_1->id),
//                          ),array('id'=>'showJobDialog'));
//                          echo '<div id="jobDialog"></div>'; */
//
//                        echo '</span><div  id="jobDialog123' . $i . $posts_1->id . $pno . '"></div>';
//                        echo '<div  id="jobDialogupdate' . $i . $posts_1->id . $pno . '"></div>';



                        $find = StudentAttentance::model()->findByAttributes(array('date' => $_REQUEST['year'] . '-' . $mon_num . '-' . $i, 'student_id' => $student->id,'timetable_id'=>$period->id));


                        $leave_types = StudentLeaveTypes::model()->findByAttributes(array('id' => $find->leave_type_id));

                        $today_day = date('d');
                        $today_month = date('n');
                        $today_year = date('Y');
                        $cell_date = date('Y-m-d', strtotime($_REQUEST['year'] . '-' . $mon_num . '-' . $i));
                        $today_date = date('Y-m-d');
                        if ($cell_date > $today_date) {
                            $cell = "";
                        } else if (array_key_exists($cell_date, $holiday_arr)) {
                            $holiday_1++;
                            $cell = '<div style="background-color:#F00;color:#F00;width:15px;height:15px;display:block;margin-bottom:5px;">---</div>';
                        } else if (!in_array($cell_date, $days) and ! array_key_exists($cell_date, $holiday_arr)) {

                            $cell = '<div style="width:15px; height:15px; background-color:#F2F2F2;color:#F2F2F2;display:block;margin-bottom:5px;">---</div>';
                        } else {
                            $cell = '<div style="background-color:#093;color:#093;width:15px;height:15px;display:block;margin-bottom:5px;">---</div>';
                        }

                        if (count($find) == 0) {
                            echo $cell;
                        } else {
                            echo '<div style="width:13px;height:13px;display:table;margin-bottom:5px;text-align:center;border:1px solid ' . $leave_types->colour_code . ';color:' . $leave_types->colour_code . '">' . $leave_types->label . '</div>';
                        }
                    }
                }else{
                    echo '<div style="width:15px; height:15px;color:#F2F2F2;background-color:#F2F2F2;display:block;margin-bottom:5px;">---</div>';
                }
                echo '</td>';
            }
            ?>
        </tr>
    </table>

    <!-- END Attendance table -->
        <?php } ?>
