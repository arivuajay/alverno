<style type="text/css">
    .left1{ float:left; padding:5px;}
    .batches{ margin-right:10px;}
    #all_batches{ margin-right:10px;}
    table.spacer tr td{ padding:5px 0}
    .spacer{ height:200px;
             overflow:auto;
             border: 1px #ccc solid;
             width:610px;
             padding:10px;
    }
</style>
<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Notify'),
    Yii::t('app', 'Generate Contact'),);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top" id="port-left">
<?php $this->renderPartial('/default/left_side'); ?>
        </td>
        <td valign="top">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                        <td width="75%" valign="top">
                            <div  class="cont_right formWrapper">
                                <h1><?php echo Yii::t('app', 'Generate Contact'); ?></h1>
                                <div class="formCon">
                                    <div class="formConInner">
                                        <div class="form left" style=" padding-left:20px">



                                            <?php
                                            $form = $this->beginWidget('CActiveForm', array(
                                                'id' => 'mail-form',
                                                'enableAjaxValidation' => false,
                                                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                                            ));

                                            $content = EmailDrafts::model();

                                            /* if(isset($_REQUEST['sub_error']))
                                              {
                                              echo $sub_error=$_REQUEST['sub_error'];
                                              } */
                                            ?>
                                            <table cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <h3><?php echo Yii::t('app', 'Select') . ' Cohort'; ?></h3>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;<td></tr>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        /* Error Message */
                                                        if (Yii::app()->user->hasFlash('batchselect')):
                                                            ?>
                                                            <span class="required"><?php echo Yii::app()->user->getFlash('batchselect'); ?></span>

                                                        <?php
                                                        endif;
                                                        /* End Error Message */
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $current_academic_yr = Configurations::model()->findByAttributes(array('id' => 35));
                                                        if (Yii::app()->user->year) {
                                                            $year = Yii::app()->user->year;
                                                        } else {
                                                            $year = $current_academic_yr->config_value;
                                                        }
                                                        $batches = Batches::model()->findAll("is_deleted=:x AND academic_yr_id=:y", array(':x' => '0', ':y' => $year));
                                                        ?>
                                                        <div class="spacer">
                                                            <table >

                                                                <tr><td><input type="checkbox" name="batch[]" id="all_batches" value="0"><?php echo Yii::t('app', 'All') . ' Cohort'; ?></td></tr>


<?php
$data = array();
foreach ($batches as $batch) {
    ?>

                                                                    <tr><td> <input type="checkbox" class="batches" value="<?php echo $batch->id; ?>" id="batch-<?php echo $batch->id; ?>" name="batch[]"  /><?php echo $data[$batch->id] = $batch->course123->course_name . '-' . $batch->name; ?>&nbsp;
                                                                        </td></tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </table>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <td>&nbsp;<td></tr>

                                                <tr>
                                                    <td>
<?php echo CHtml::submitButton(Yii::t('app', 'Generate Contact'), array('name' => 'ParentContacts')); ?>
                                                    </td>
                                                </tr>

                                            </table>

                                                        <?php $this->endWidget(); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="clear"></div>
                            </div>
                        </td>
                    </tr>
                </tbody></table>
        </td>
    </tr>
</table>

<script type="text/javascript">
    $(document).ready(function () {

        $("#all_batches").change(function () {
            if (this.checked) {
                $('.batches').attr('checked', true);
            }
            else {
                $('.batches').attr('checked', false);
            }
        });
        $(".batches").change(function () { /* Check/Uncheck SMS All on enabling/disabling of SMS */
            if ($('.batches:checked').size() >= ($('.batches').size()))
            {
                $('#all_batches').attr('checked', true);
            }
            else
            {
                $('#all_batches').attr('checked', false);
            }
        });
    });
</script>
