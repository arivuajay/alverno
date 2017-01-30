<div class="contentpanel" id="payment-area">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('app', 'Make a payment'); ?></h3>
    </div>
    <div class="people-item">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'ib-payment-form',
            'enableAjaxValidation' => false,
        ));
        $sc = IbConfig::model()->find();
        $to_be_pay  = ($gateway->amount) ? $gateway->amount : $amount_payable;
        $dc_sc = ($to_be_pay > 2000) ? $sc->sc_dc_ul : $sc->sc_dc_ll;
        ?>
        <div class="row">
            <div class="col col-sm-1">
                <?php echo $form->labelEx($gateway, 'Option'); ?>
            </div>
            <div class="col col-sm-4">
                <input type="radio" name="pay_mode" id="pay_mode_1" value="CC" data-sc-mode="PR" data-sc-val="<?php echo $sc->sc_cc ?>" checked="checked" /> <label for="pay_mode_1">Credit Card (SC - <?php echo $sc->sc_cc ?>%)</label> <br />
                <input type="radio" name="pay_mode" id="pay_mode_2" value="DC" data-sc-mode="PR" data-sc-val="<?php echo $dc_sc ?>" /> <label for="pay_mode_2">Debit Card (SC - <?php echo $dc_sc ?>%)</label> <br />
                <input type="radio" name="pay_mode" id="pay_mode_3" value="NB" data-sc-mode="RS" data-sc-val="<?php echo $sc->sc_net_bank ?>" /> <label for="pay_mode_3">Net Banking of Other Banks (SC - Rs.<?php echo $sc->sc_net_bank ?>)</label> <br />
                <div class="help-block">*SC-Service Charge</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <table class="table">
                    <tr>
                        <td>Amount*:</td>
                        <td>
                            <?php echo $form->textField($gateway, 'amount', array('class' => 'form-control', 'value' => $to_be_pay)); ?>
                            <?php echo $form->error($gateway, 'amount'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Service Charge(<span class="sc_val_text"></span>):</td>
                        <td><span class="sc_val_amt"></span></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><span class="total_val_amt"></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <label><input type="checkbox" class="terms_cond" name="terms" /> &nbsp; I agree to the <?php echo CHtml::link('terms and conditions', '/uploads/terms_and_conditions.doc', array('target'=>'_blank')) ?></label> <br />
                            <?php echo $form->hiddenField($gateway, 'service_charge'); ?>
                            <?php echo CHtml::button(Yii::t("app", "Pay"), array("class" => "btn btn-primary", "id" => "ib-submit-button")); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
<?php $this->endWidget(); ?>
        <script type="text/javascript">
            function sc_change() {
                scValAmt = theTotal = 0.00;
                scValText = 0;
                ServiceTax = 0.15; // 15%
                Amt = parseFloat($('#IbForm_amount').val()).toFixed(2);
                if (Amt > 0) {
                    SC_ATTR = $('[name="pay_mode"]:checked');
                    if (SC_ATTR.data('sc-mode') == 'PR') {
                        scValText = SC_ATTR.data('sc-val') + '%';
                        subCharge = Amt * (SC_ATTR.data('sc-val') / 100);
                    } else if (SC_ATTR.data('sc-mode') == 'RS') {
                        scValText = 'Rs.' + SC_ATTR.data('sc-val');
                        subCharge = SC_ATTR.data('sc-val');
                    }
                    scValAmt = parseFloat(subCharge + (subCharge * ServiceTax)).toFixed(2);
                }
                Total = parseFloat(Amt) + parseFloat(scValAmt);
                theTotal = Total.toFixed(2);

                $('.sc_val_text').text(scValText);
                $('.sc_val_amt').text(scValAmt);
                if($('[name="pay_mode"]:checked').val() == 'DC'){
                    $('#IbForm_service_charge').val(0);
                }else{
                    $('#IbForm_service_charge').val(scValAmt);
                }
                $('.total_val_amt').text(theTotal);
            }
            $(function () {
                sc_change();
                $('#IbForm_amount').on('keyup',function(){
                    sc_change();
                });
                $('[name="pay_mode"]').on('change',function(){
                    sc_change();
                });
                $('#ib-submit-button').click(function () {
                    if ($('[name="pay_mode"]:checked').length == 0) {
                        alert('Please select anyone of payment option');
                        $('[name="pay_mode"]:first').focus();
                        return false;
                    }

                    if ($('.terms_cond:checked').length == 0) {
                        alert('Please accept the terms and conditions');
                        $('.terms_cond:first').focus();
                        return false;
                    }

                    $("form#ib-payment-form").submit();
                    return false;
                });
            });
        </script>
    </div>
</div>