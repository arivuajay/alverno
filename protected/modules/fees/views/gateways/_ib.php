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
        $to_be_pay = ($gateway->amount) ? $gateway->amount : $amount_payable;
        $dc_sc = ($to_be_pay > 2000) ? $sc->sc_dc_ul : $sc->sc_dc_ll;
        ?>
        <div class="row">
            <div class="col col-sm-1">
                <?php echo $form->labelEx($gateway, 'Option'); ?>
            </div>
            <div class="col col-sm-4">
                <input type="radio" name="pay_mode" id="pay_mode_1" value="CC" data-sc-mode="CC" data-sc-val="<?php echo $sc->sc_cc ?>" checked="checked" /> <label for="pay_mode_1">Credit Card [SC-<?php echo $sc->sc_cc ?>%+ST-15%(SC)]</label> <br />
                <input type="radio" name="pay_mode" id="pay_mode_2" value="DC" data-sc-mode="DC" data-sc-ul="<?php echo $sc->sc_dc_ul; ?>" data-sc-ll="<?php echo $sc->sc_dc_ll; ?>" /> <label for="pay_mode_2">Debit Card [SC-<span class="dc_sc_tt"><?php echo $dc_sc ?>%</span>+ST-15%(SC)]</label> <br />
                <input type="radio" name="pay_mode" id="pay_mode_3" value="NB" data-sc-mode="IB" data-sc-val="<?php echo $sc->sc_net_bank ?>" /> <label for="pay_mode_3">Net Banking of Other Banks [SC-RS.<?php echo $sc->sc_net_bank ?>+ST-15%(SC)]</label> <br />
                <div class="help-block">*SC = Service Charge; *ST = Service Tax</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <table class="table">
                    <tr>
                        <td>Amount*:</td>
                        <td>
                            <?php echo $form->textField($gateway, 'amount', array('class' => 'form-control', 'value' => $to_be_pay,'readonly'=>'readonly')); ?>
                            <?php echo $form->error($gateway, 'amount'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Service Charge(<span class="sc_val_text"></span>) = <span class="sc_val_amt"></span> + <br />
                            Service Tax 15%(SC) = <span class="st_val_amt"></span>
                        </td>
                        <td><span class="service_total_amt"></span></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><span class="total_val_amt"></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <label><input type="checkbox" class="terms_cond" name="terms" /> &nbsp; I agree to the <?php echo CHtml::link('terms and conditions', '#', array('target' => '_blank', 'data-toggle' => 'modal', 'data-target' => '#termCondModal')) ?></label> <br />
                            <?php echo $form->hiddenField($gateway, 'service_charge'); ?>
                            <?php echo CHtml::button(Yii::t("app", "Pay"), array("class" => "btn btn-primary", "id" => "ib-submit-button")); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>

        <div class="modal fade" id="termCondModal" tabindex="-1" role="dialog" aria-labelledby="termCondLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="termCondLabel">Terms & Conditions</h4>
                    </div>
                    <div class="modal-body" style="height: 80vh; overflow-y: scroll;">
                        <p>The Terms and Conditions contained herein shall apply to any person ("User") using the services of the <strong>Vani Vidyalaya</strong> for making Application Fee payment through an online payment gateway service ("Service") offered by Payment Gateway Service provider, through Vani Vidyalaya website – http://Vani.eschoool.com/. Each User is therefore deemed to have read and accepted these Terms and Conditions.</p>

                        <h2>A. Privacy Policy</h2>
                        <p>Vani Vidyalaya respects and protects the privacy of the individuals who access the information and use the services provided through them. Individually identifiable information about the User is not willfully disclosed to any third party without first receiving the User's permission, as covered in this Privacy Policy. This Privacy Policy describes Vani Vidyalaya's treatment of personally identifiable information that the Vani Vidyalaya collects when the User registers in the Vani Vidyalaya's website. The Vani Vidyalaya does not collect any unique information about the User (such as User's name, email address, age, gender etc.) except when the User specifically and knowingly provides such information on the Website.</p>

                        <p>Please be aware, however, that Vani Vidyalaya will release specific personal information about the User if required to do so in the following circumstances:</p>

                        <ul>
                            <li>in order to comply with any valid legal process such as a search warrant, statute, or court order, or</li>
                            <li>if any of User's actions on Vani Vidyalaya 's website violate the Terms of Service or any of Vani Vidyalaya 's guidelines for specific services, or</li>
                            <li>to protect or defend Vani Vidyalaya 's legal rights or property, intellectual capital, the Vani Vidyalaya  , or the Vani Vidyalaya  users ; or</li>
                            <li>to investigate, prevent, or take action regarding illegal activities, suspected fraud, situations involving potential threats to the security, integrity of Vani Vidyalaya  website/offerings.</li>

                        </ul>
                        <h2>B. General Terms and Conditions For Online-Payments</h2>
                        <ol>
                            <li>Once a User has accepted these Terms and Conditions, he/ she may register and avail the Services. A User may either register in Applicants' Info (Applicants Gateway) on the Vani Vidyalaya website time to time.</li>
                            <li>Vani Vidyalaya's rights, obligations, undertakings shall be subject to the laws in force in India, as well as any directives/ Procedures of Government of India, and nothing contained in these Terms and Conditions shall be in derogation of Vani Vidyalaya's right to comply with any law enforcement agencies request or requirements relating to any User's use of the website or information provided to or gathered by the Vani Vidyalaya with respect to such use. Each User accepts and agrees that the provision of details of his/ her use of the Website to regulators or police or to any other third party in order to resolve disputes or complaints which relate to the Website shall be at the absolute discretion of the Vani Vidyalaya .</li>
                            <li>If any part of these Terms and Conditions are determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth herein, then the invalid or unenforceable provision will be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of these Terms and Conditions shall continue in effect.</li>
                            <li>These Terms and Conditions constitute the agreement between the User and the Vani Vidyalaya.. A printed version of these Terms and Conditions and of any notice given in electronic form shall be admissible in judicial or administrative proceedings based upon or relating to these Terms and Conditions to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</li>
                            <li>The entries in the books of the Vani Vidyalaya and/or the Payment Service Providers kept in the ordinary course of business of the Vani Vidyalaya  and/or the Payment Service Providers with regard to transactions covered under these Terms and Conditions and matters therein appearing shall be binding on the User and shall be conclusive proof of the genuineness and accuracy of the transaction.</li>
                            <li>Refund For Charge Back Transaction: In the event there is any claim for/ of charge back by the User for any reason whatsoever, such User shall immediately approach the Vani Vidyalaya with his/ her claim details and claim refund from the Vani Vidyalaya alone. Such refund (if any) shall be effected only by the Vani Vidyalaya via payment gateway or such other means as the Vani Vidyalaya deems appropriate. No claims for refund/ charge back shall be made by any User to the Payment Service Provider(s) and in the event such claim is made it shall not be entertained.</li>
                            <li>In these Terms and Conditions, the term "Charge Back" shall mean, approved and settled credit card or net banking purchase transaction(s) which are at any time refused, debited or charged back to merchant account (and shall also include similar debits to Payment Service Provider's accounts, if any) by the acquiring bank or credit card company for any reason whatsoever, together with the bank fees, penalties and other charges incidental thereto. </li>
                            <li>Refund for fraudulent/duplicate transaction(s): The User shall directly contact the Vani Vidyalaya  for any fraudulent transaction(s) on account of misuse of Card/ Bank details by a fraudulent individual/party and such issues shall be suitably addressed by the Vani Vidyalaya  alone in line with their policies and rules.</li>
                            <li>Server Slow Down/Session Timeout: In case the Website or Payment Service Provider's webpage, that is linked to the Website, is experiencing any server related issues like ‘slow down' or ‘failure' or ‘session timeout', the User shall, before initiating the second payment,, check whether his/her Bank Account has been debited or not and accordingly resort to one of the following options:</li>
                            <ul>
                                <li>In case the Bank Account appears to be debited, ensure that he/ she does not make the payment twice and immediately thereafter contact the Vani Vidyalaya  via e-mail or any other mode of contact as provided by the Vani Vidyalaya  to confirm payment.</li>
                                <li>In case the Bank Account is not debited, the User may initiate a fresh transaction to make payment. However, the User agrees that under no circumstances the Payment Gateway Service Provider shall be held responsible for such fraudulent/duplicate transactions and hence no claims should be raised to Payment Gateway Service Provider No communication received by the Payment Service Provider(s) in this regards shall be entertained by the Payment Service Provider(s).</li>
                            </ul>
                        </ol>

                        <h2>C. Limitation of Liability</h2>
                        <ol>
                            <li>The Vani Vidyalaya has made this Service available to the User as a matter of convenience. The Vani Vidyalaya expressly disclaims any claim or liability arising out of the provision of this Service. The User agrees and acknowledges that he/ she shall be solely responsible for his/ her conduct and that the Vani Vidyalaya reserves the right to terminate the rights to use of the Service immediately without giving any prior notice thereof.</li>
                            <li>The Vani Vidyalaya and/or the Payment Service Providers shall not be liable for any inaccuracy, error or delay in, or omission of (a) any data, information or message, or (b) the transmission or delivery of any such data, information or message; or (c) any loss or damage arising from or occasioned by any such inaccuracy, error, delay or omission, non-performance or interruption in any such data, information or message. Under no circumstances shall the Vani Vidyalaya and/or the Payment Service Providers, its employees, directors, and its third party agents involved in processing, delivering or managing the Services, be liable for any direct, indirect, incidental, special or consequential damages, or any damages whatsoever, including punitive or exemplary arising out of or in any way connected with the provision of or any inadequacy or deficiency in the provision of the Services or resulting from unauthorized access or alteration of transmissions of data or arising from suspension or termination of the Services.</li>
                            <li>The Vani Vidyalaya and the Payment Service Provider(s) assume no liability whatsoever for any monetary or other damage suffered by the User on account of:
                                <ul>
                                    <li>The delay, failure, interruption, or corruption of any data or other information transmitted in connection with use of the Payment Gateway or Services in connection thereto; and/ or </li>
                                    <li>Any interruption or errors in the operation of the Payment Gateway.</li>
                                </ul>
                            </li>
                            <li>The User shall indemnify and hold harmless the Payment Service Provider(s) and the Vani Vidyalaya  and their respective officers, directors, agents, and employees, from any claim or demand, or actions arising out of or in connection with the utilization of the Services.</li>
                            <li>The User agrees that the Vani Vidyalaya or any of its employees will not be held liable by the User for any loss or damages arising from your use of, or reliance upon the information contained on the Website, or any failure to comply with these Terms and Conditions where such failure is due to circumstance beyond Vani Vidyalaya's reasonable control.</li>
                        </ol>
                        <h2>D. Miscellaneous Conditions:</h2>
                        <ol>
                            <li>Any waiver of any rights available to the Vani Vidyalaya under these Terms and Conditions shall not mean that those rights are automatically waived.</li>
                            <li>The User agrees, understands and confirms that his/ her personal data including without limitation details relating to debit card/ credit card transmitted over the Internet may be susceptible to misuse, hacking, theft and/ or fraud and that the Vani Vidyalaya  or the Payment Service Provider(s) have no control over such matters.</li>
                            <li>Although all reasonable care has been taken towards guarding against unauthorized use of any information transmitted by the User, the Vani Vidyalaya does not represent or guarantee that the use of the Services provided by/ through it will not result in theft and/or unauthorized use of data over the Internet.</li>
                            <li>The Vani Vidyalaya , the Payment Service Provider(s) and its affiliates and associates shall not be liable, at any time, for any failure of performance, error, omission, interruption, deletion, defect, delay in operation or transmission, computer virus, communications line failure, theft or destruction or unauthorized access to, alteration of, or use of information contained on the Website.</li>
                            <li>The User will be required to login his/ her own User ID and Password, given by the Vani Vidyalaya  in order to register and/ or use the Services provided by Vani Vidyalaya  on the Website. By accepting these Terms and Conditions the User aggress that his/ her User ID and Password are very important pieces of information and it shall be the User's own responsibility to keep them secure and confidential. In furtherance hereof, the User agrees to;
                                <ul>
                                    <li>Choose a new password, whenever required for security reasons.</li>
                                    <li>Keep his/ her User ID & Password strictly confidential.</li>
                                    <li>Be responsible for any transactions made by User under such User ID and Password. The User is hereby informed that that Vani Vidyalaya will never ask the User for the User's password in an unsolicited phone call or in an unsolicited email. The User is hereby required to sign out of his/ her Vani Vidyalaya account on the Website and close the web browser window when the transaction(s) have been completed. This is to ensure that others cannot access the User's personal information and correspondence when the User happens to share a computer with someone else or is using a computer in a public place like a library or Internet café.</li>
                                </ul>
                            </li>
                        </ol>
                        <h2>E. Debit/Credit Card, Bank Account Details</h2>
                        <ol>
                            <li>The User agrees that the debit/credit card details provided by him/ her for use of the aforesaid Service(s) must be correct and accurate and that the User shall not use a debit/ credit card, that is not lawfully owned by him/ her or the use of which is not authorized by the lawful owner thereof. The User further agrees and undertakes to provide correct and valid debit/credit card details.</li>
                            <li>The User may pay his/ her fees to the Vani Vidyalaya by using a debit/credit card or through online banking account. The User warrants, agrees and confirms that when he/ she initiates a payment transaction and/or issues an online payment instruction and provides his/ her card / bank details:
                                <ul>
                                    <li>The User is fully and lawfully entitled to use such credit / debit card, bank account for such transactions;</li>
                                    <li>The User is responsible to ensure that the card/ bank account details provided by him/ her are accurate;</li>
                                    <li>The User is authorizing debit of the nominated card/ bank account for the payment of fees selected by such User along with the applicable Fees.</li>
                                    <li>The User is responsible to ensure sufficient credit is available on the nominated card/ bank account at the time of making the payment to permit the payment of the dues payable or the bill(s) selected by the User inclusive of the applicable Fee.</li>
                                </ul>
                            </li>
                        </ol>

                        <h2>F. Personal Information</h2>
                        <ol>
                            <li>The User agrees that, to the extent required or permitted by law, the Vani Vidyalaya  and/ or the Payment Service Provider(s) may also collect, use and disclose personal information in connection with security related or law enforcement investigations or in the course of cooperating with authorities or complying with legal requirements.</li>
                            <li>The User agrees that any communication sent by the User vide e-mail, shall imply release of information therein/ therewith to the Vani Vidyalaya. The User agrees to be contacted via e-mail on such mails initiated by him/ her.</li>
                            <li>In addition to the information already in the possession of the Vani Vidyalaya and/ or the Payment Service Provider(s), the Vani Vidyalaya may have collected similar information from the User in the past. By entering the Website the User consents to the terms of the Vani Vidyalaya's information privacy policy and to the Vani Vidyalaya's continued use of previously collected information. By submitting the User's personal information to the Vani Vidyalaya, the User will be treated as having given his/ her permission for the processing of the User's personal data as set out herein. </li>
                            <li>. The User acknowledges and agrees that his/ her information will be managed in accordance with the laws for the time in force.</li>
                        </ol>

                        <h2>G. Payment Gateway Disclaimer</h2>
                        <p>The Service is provided in order to facilitate access to view and pay Student Fees online. The Vani Vidyalaya or the Payment Service Provider(s) do not make any representation of any kind, express or implied, as to the operation of the Payment Gateway other than what is specified in the Website for this purpose. By accepting/ agreeing to these Terms and Conditions, the User expressly agrees that his/ her use of the aforesaid online payment Service is entirely at own risk and responsibility of the User.</p>


                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function sc_change() {
                scValAmt = stValAmt = ServiceTotal = theTotal = 0.00;
                scValText = 0;
                ServiceTax = 0.15; // 15%
                Amt = parseFloat($('#IbForm_amount').val()).toFixed(2);
                if (Amt > 0) {
                    DCVAL = (Amt > 2000) ? $('#pay_mode_2').data('sc-ul') : $('#pay_mode_2').data('sc-ll');
                    $('.dc_sc_tt').text(DCVAL + '%');

                    SC_ATTR = $('[name="pay_mode"]:checked');
                    if (SC_ATTR.data('sc-mode') == 'CC') {
                        scValText = SC_ATTR.data('sc-val') + '%';
                        subCharge = Amt * (SC_ATTR.data('sc-val') / 100);
                    } else if (SC_ATTR.data('sc-mode') == 'DC') {
                        scValText = DCVAL + '%';
                        subCharge = Amt * (DCVAL / 100);
                    } else if (SC_ATTR.data('sc-mode') == 'IB') {
                        scValText = 'RS.' + SC_ATTR.data('sc-val');
                        subCharge = SC_ATTR.data('sc-val');
                    }
                    stValAmt = parseFloat(subCharge * ServiceTax).toFixed(2);
                    scValAmt = parseFloat(subCharge).toFixed(2);
                }
                _scTotal = parseFloat(scValAmt) + parseFloat(stValAmt);
                ServiceTotal = _scTotal.toFixed(2);
                _total = parseFloat(Amt) + parseFloat(ServiceTotal);
                theTotal = _total.toFixed(2);

                $('.sc_val_text').text(scValText);
                $('.sc_val_amt').text(scValAmt);
                $('.st_val_amt').text(stValAmt);
                $('.service_total_amt').text(ServiceTotal);
                $('#IbForm_service_charge').val(ServiceTotal);
                $('.total_val_amt').text(theTotal);
            }
            $(function () {
                sc_change();
                $('#IbForm_amount').on('keyup', function () {
                    sc_change();
                });
                $('[name="pay_mode"]').on('change', function () {
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