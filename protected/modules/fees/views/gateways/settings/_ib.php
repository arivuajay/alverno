<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ib-config-_ibs-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class='formCon'>
        <div class='formConInner'>
            <h3><?php echo Yii::t('app', 'Indian Bank Settings'); ?></h3>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20%"><?php echo $form->labelEx($gateway, 'mrctCode'); ?></td>
                    <td><?php echo $form->textField($gateway, 'mrctCode'); ?>
                        <?php echo $form->error($gateway, 'mrctCode'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'currencyType'); ?></td>
                    <td><?php echo $form->textField($gateway, 'currencyType'); ?>
                        <?php echo $form->error($gateway, 'currencyType'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'bankCode'); ?></td>
                    <td><?php echo $form->textField($gateway, 'bankCode'); ?>
                        <?php echo $form->error($gateway, 'bankCode'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'locatorURL'); ?></td>
                    <td><?php
                        $items = array_keys(IbConfig::getLocurlvalue());
                        $list = array_combine($items, $items);
                        echo $form->dropDownList($gateway, 'locatorURL', $list);
                        ?>
                        <?php echo $form->error($gateway, 'locatorURL'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'scheme_code'); ?></td>
                    <td><?php echo $form->textField($gateway, 'scheme_code'); ?>
                        <?php echo $form->error($gateway, 'scheme_code'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'key'); ?></td>
                    <td><?php echo $form->textField($gateway, 'key'); ?>
                        <?php echo $form->error($gateway, 'key'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'iv'); ?></td>
                    <td><?php echo $form->textField($gateway, 'iv'); ?>
                        <?php echo $form->error($gateway, 'iv'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'sc_cc'); ?></td>
                    <td><?php echo $form->textField($gateway, 'sc_cc'); ?>
                        <?php echo $form->error($gateway, 'sc_cc'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'sc_dc_ll'); ?></td>
                    <td><?php echo $form->textField($gateway, 'sc_dc_ll'); ?>
                        <?php echo $form->error($gateway, 'sc_dc_ll'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'sc_dc_ul'); ?></td>
                    <td><?php echo $form->textField($gateway, 'sc_dc_ul'); ?>
                        <?php echo $form->error($gateway, 'sc_dc_ul'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($gateway, 'sc_net_bank'); ?></td>
                    <td><?php echo $form->textField($gateway, 'sc_net_bank'); ?>
                        <?php echo $form->error($gateway, 'sc_net_bank'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo CHtml::submitButton(Yii::t('app', 'Save Settings'), array('class' => 'formbut')); ?></td>
                </tr>

            </table>



            <div class="row">


            </div>

            <div class="row">


            </div>
        </div>
    </div>

    <div class="row buttons">

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->