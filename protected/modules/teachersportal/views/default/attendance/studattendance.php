<style type="text/css">
    .table-responsive {
        border: 1px solid #ddd;
        margin-bottom: 15px;
        overflow-x: scroll;
        overflow-y: hidden;
        width: 100%;
    }
</style>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<div id="parent_Sect">
    <?php $this->renderPartial('leftside'); ?>
    <div class="right_col"  id="req_res123">
        <!--contentArea starts Here-->
        <div id="parent_rightSect">
            <div class="parentright_innercon">
                <div class="pageheader">
                    <div class="col-lg-8">
                        <h2><i class="fa fa-file-text"></i><?php echo Yii::t('app', 'Attendance'); ?><span><?php echo Yii::t('app', 'View your attendance here'); ?> </span></h2>
                    </div>
                    <div class="col-lg-2"> </div>
                    <div class="breadcrumb-wrapper"> <span class="label"><?php echo Yii::t('app', 'You are here:'); ?></span>
                        <ol class="breadcrumb">
                            <!--<li><a href="index.html">Home</a></li>-->

                            <li class="active"><?php echo Yii::t('app', 'Attendance'); ?></li>
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="contentpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo Yii::t('app', 'Mark Student Attendance'); ?></h3>
                    </div>
                    <div class="people-item">
                        <?php $this->renderPartial('/default/employee_tab'); ?>
                        <?php
                        //If $list_flag = 1, table of batches will be displayed. If $list_flag = 0, attendance table will be displayed.
                        if ($_REQUEST['id'] != NULL) {
                            $list_flag = 0;
                        } else {
                            $employee = Employees::model()->findByAttributes(array('uid' => Yii::app()->user->id));
                            $batch = Batches::model()->findAll("employee_id=:x AND is_active=:y AND is_deleted=:z", array(':x' => $employee->id, ':y' => 1, ':z' => 0));
                            if (count($batch) > 1) {
                                $list_flag = 1;
                            } else {
                                $list_flag = 0;
                                $_REQUEST['id'] = $batch[0]->id;
                            }
                        }
                        ?>
                        <?php if ($list_flag == 1) { ?>
                            <div class="cleararea"></div>
                            <div class="table-responsive">
                                <table width="80%" border="0" cellspacing="0" cellpadding="0" class="table mb30">
                                    <thead>
                                        <!--class="cbtablebx_topbg"  class="sub_act"-->
                                        <tr class="pdtab-h">
                                            <th align="center"><?php echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id") . ' ' . Yii::t('app', 'Name'); ?></th>
                                            <th align="center"><?php echo Yii::t('app', 'Class Teacher'); ?></th>
                                            <th align="center"><?php echo Yii::t('app', 'Start Date'); ?></th>
                                            <th align="center"><?php echo Yii::t('app', 'End Date'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($batch as $batch_1) {
                                            $model = AttendanceSettings::model()->findByAttributes(array('config_key' => 'type'));
                                            if ($model->config_value == 1)
                                                $link = CHtml::link($batch_1->name, array('/teachersportal/default/studentattendance', 'id' => $batch_1->id));
                                            else
                                                $link = CHtml::link($batch_1->name, array('/attendance/subjectAttendance/tpAttendance', 'id' => $batch_1->id));

                                            echo '<tr id="batchrow' . $batch_1->id . '">';
                                            echo '<td style="text-align:left; padding-left:10px; font-weight:bold;">' . $link . '</td>';
                                            $settings = UserSettings::model()->findByAttributes(array('id' => 1));
                                            if ($settings != NULL) {
                                                $date1 = date($settings->displaydate, strtotime($batch_1->start_date));
                                                $date2 = date($settings->displaydate, strtotime($batch_1->end_date));
                                            }
                                            $teacher = Employees::model()->findByAttributes(array('id' => $batch_1->employee_id));
                                            echo '<td align="center">';
                                            if ($teacher) {
                                                echo $teacher->first_name . ' ' . $teacher->last_name;
                                            } else {
                                                echo '-';
                                            }
                                            echo '</td>';
                                            echo '<td align="center">' . $date1 . '</td>';
                                            echo '<td align="center">' . $date2 . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        if ($list_flag == 0 or isset($_REQUEST['id'])) {

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

                            $model = new EmployeeAttendances;
                            if (!isset($_REQUEST['mon'])) {
                                $mon = date('F');
                                $mon_num = date('n');
                                $curr_year = date('Y');
                            } else {
                                $mon = $model->getMonthname($_REQUEST['mon']);
                                $mon_num = $_REQUEST['mon'];
                                $curr_year = $_REQUEST['year'];
                            }
                            $num = cal_days_in_month(CAL_GREGORIAN, $mon_num, $curr_year);
                            ?>
                            <div class="atdn_div">
                                <div class="name_div">
                                    <?php
                                    $batch_name = Batches::model()->findByAttributes(array('id' => $_REQUEST['id']));
                                    $course_name = Courses::model()->findByAttributes(array('id' => $batch_name->course_id));
                                    echo Yii::t('app', 'Course Name') . ':' . $course_name->course_name . '<br/>';
                                    echo Yii::app()->getModule('students')->fieldLabel("Students", "batch_id") . ' ' . Yii::t('app', 'Name') . ':' . $batch_name->name;
                                    ?>
                                </div>
                                <div align="center" class="atnd_tnav">
                                    <?php
                                    echo CHtml::link('<div class="atnd_arow_l"><img src="images/atnd_arrow-l.png" width="7" border="0"  height="13" /></div>', array('studentattendance', 'mon' => date("m", strtotime($curr_year . "-" . $mon_num . "-01 -1 months")), 'year' => date("Y", strtotime($curr_year . "-" . $mon_num . "-01 -1 months")), 'id' => $_REQUEST['id']));
                                    echo $mon . '&nbsp;&nbsp;&nbsp; ' . $curr_year;

                                    echo CHtml::link('<div class="atnd_arow_r"><img src="images/atnd_arrow.png" width="7" border="0"  height="13" /></div>', array('studentattendance', 'mon' => date("m", strtotime($curr_year . "-" . $mon_num . "-01 +1 months")), 'year' => date("Y", strtotime($curr_year . "-" . $mon_num . "-01 +1 months")), 'id' => $_REQUEST['id']));
                                    ?>
                                </div>
                                <!-- End top navigation div -->
                                <div class="table-responsive">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table mb30">
                                        <tr>
                                            <th><?php echo Yii::t('app', 'Name'); ?></th>
                                            <?php
                                            for ($i = 1; $i <= $num; $i++) {
                                                echo '<th>' . getweek($i, $mon_num, $curr_year) . '<span>' . $i . '</span></th>';
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        /////////////////
                                        $selected_batch = Batches::model()->findByAttributes(array('id' => $_REQUEST['id']));
                                        $batch_start = date('Y-m-d', strtotime($selected_batch->start_date));
                                        $batch_end = date('Y-m-d', strtotime($selected_batch->end_date));

                                        $days = array();
                                        $batch_days = array();
                                        $batch_range = StudentAttentance::model()->createDateRangeArray($batch_start, $batch_end);
                                        $batch_days = array_merge($batch_days, $batch_range);

                                        $weekArray = array();
                                        $weekdays = Weekdays::model()->findAll("batch_id=:x AND weekday<>:y", array(':x' => $selected_batch->id, ':y' => "0"));

                                        if (count($weekdays) == 0) {
                                            $weekdays = Weekdays::model()->findAll("batch_id IS NULL AND weekday<>:y", array(':y' => "0"));
                                        }

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

                                        ///////////////
                                        $posts = Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z ", array(':x' => $_REQUEST['id'], ':y' => 1, ':z' => 0), array('order' => 'first_name'));
                                        foreach ($posts as $posts_1) {
                                            echo '<tr>';
                                            echo '<td class="name">' . $posts_1->studentFullName('forTeacherPortal') . '</td>';
                                            for ($i = 1; $i <= $num; $i++) {
                                                echo '<td>';
                                                $week = date('w', strtotime("{$curr_year}-{$mon_num}-{$i}")) + 1;
                                                $time_table = TimetableEntries::model()->findAll("batch_id = :batch AND weekday_id = :week", array(":batch" => $posts_1->batch_id, ":week" => $week));
                                                if ($time_table) {
                                                    foreach ($time_table as $k => $period) {
                                                        echo '<span  id="td' . $i . $posts_1->id . '">';
                                                        $pno = $k + 1;
                                                        echo $this->renderPartial('attendance/ajax', array('day' => $i, 'month' => $mon_num, 'year' => $curr_year, 'emp_id' => $posts_1->id, 'batch_id' => $_REQUEST['id'], 'days' => $days, 'pno' => $pno, 'period' => $period));
                                                        echo '</span><div  id="jobDialog123' . $i . $posts_1->id . $pno . '"></div>';
                                                        echo '<div  id="jobDialogupdate' . $i . $posts_1->id . $pno . '"></div>';
                                                    }
                                                }
                                                echo '</td>';
                                            }

//										for($i=1;$i<=$num;$i++)
//										{
//											echo '<td><span  id="td'.$i.$posts_1->id.'">';
//											echo  $this->renderPartial('attendance/ajax',array('day'=>$i,'month'=>$mon_num,'year'=>$curr_year,'emp_id'=>$posts_1->id,'batch_id'=>$_REQUEST['id'], 'days'=>$days));
//											echo '</span><div  id="jobDialog123'.$i.$posts_1->id.'"></div></td>';
//											echo '</span><div  id="jobDialogupdate'.$i.$posts_1->id.'"></div></td>';
//										}
                                            echo '</tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!-- End attendance div -->

                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
