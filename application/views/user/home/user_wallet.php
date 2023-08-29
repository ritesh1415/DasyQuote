<?php
$get_details = $this->db->where('id', $this->session->userdata('id'))->get('users')->row_array();
?>
<div class="content">
    <div class="container">
        <div class="row">
            <?php
            if (!empty($_GET['tbs'])) {
                $val = $_GET['tbs'];
            } else {
                $val = 1;
            }
            ?>
            <input type="hidden" name="tab_ctrl" id="tab_ctrl" value="<?php echo $val; ?>">
            <?php $this->load->view('user/home/user_sidemenu'); ?>

            <div class="col-xl-9 col-md-8">

                <div class="row">
                    <?php
                    $total_cr = 0;
                    $total_dr = 0;
					$user_currency = get_user_currency();
                    $user_currency_code = $user_currency['user_currency_code'];
                    if (!empty($wallet_history)) {
                        foreach ($wallet_history as $key => $value) {
                            
                            if (!empty($value['credit_wallet'])) {
                                $color = 'success';
                                $message = 'Credit';
                            } else {
                                $color = 'danger';
                                $message = 'Debit';
                            }
                            if (!empty($value["fee_amt"]) && $value["fee_amt"] > 1) {
                                $txt_amt = number_format($value["fee_amt"] / 100, 2);
                            } else {
                                $txt_amt = 0;
                            }
                            $total_cr += get_gigs_currency($value['credit_wallet'], $value['currency_code'], $user_currency_code);
                            $total_dr += abs(get_gigs_currency($value['debit_wallet'], $value['currency_code'], $user_currency_code));
                        }
                    }
                    ?>

                    <?php
                    $user_currency_code = '';
                    $userId = $this->session->userdata('id');
                    If (!empty($userId)) {
                        
                        $service_amount1 = $wallet['wallet_amt'];
                        $service_amount2 = $total_cr;
                        $service_amount3 = $total_dr;
                        $get_currency = get_currency();
                        $user_currency = get_user_currency();
                        $user_currency_code = $user_currency['user_currency_code'];
                        $service_amount1 = get_gigs_currency($wallet['wallet_amt'], $wallet['currency_code'], $user_currency_code);
                        if (is_nan($service_amount1) || is_infinite($service_amount1)) {
                            $service_amount1 = $wallet['wallet_amt'];
                        }
                    } else {
                        $user_currency_code = settings('currency');
                        $service_amount1 = $wallet['wallet_amt'];
                        $service_amount2 = $total_cr;
                        $service_amount3 = $total_dr;
                    }
					
                    ?>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?></h4>

                                <div class="wallet-details">
                                    <span><?php echo (!empty($user_language[$user_selected]['lg_Wallet_Balance'])) ? $user_language[$user_selected]['lg_Wallet_Balance'] : $default_language['en']['lg_Wallet_Balance']; ?></span>
                                    <h3><?php echo currency_conversion($user_currency_code) . $wallet['wallet_amt']; ?></h3>


                                    <div class="d-flex justify-content-between my-4">
                                        <div>
                                            <p class="mb-1"><?php echo (!empty($user_language[$user_selected]['lg_Total_Credit'])) ? $user_language[$user_selected]['lg_Total_Credit'] : $default_language['en']['lg_Total_Credit']; ?></p>
                                            <h4><?php echo currency_conversion($user_currency_code) . number_format($service_amount2, 2); ?></h4>
                                        </div>
                                        <div>
                                            <p class="mb-1"><?php echo (!empty($user_language[$user_selected]['lg_Total_Debit'])) ? $user_language[$user_selected]['lg_Total_Debit'] : $default_language['en']['lg_Total_Debit']; ?></p>
                                            <h4><?php echo currency_conversion($user_currency_code) . number_format($service_amount3, 2); ?></h4>
                                        </div>
                                    </div>

                                    <div class="wallet-progress-chart">
                                         <div class="d-flex justify-content-between">
											<?php
                                            if (!empty($wallet['total_credit'])) {
                                                $wallet['total_credit'] = $total_cr;
												$wallet['total_debit'] = $total_dr;
                                            } else {
                                                $wallet['total_credit'] = 0;
												$wallet['total_debit'] = $total_dr;
                                            }
                                            ?>
                                            <span><?php echo $wallet['currency'] . '' . abs($wallet['total_debit']); ?></span>
                                            <span><?php echo $wallet['currency'] . '' . number_format($wallet['total_credit'], 2); ?></span>
                                        </div>

                                        <?php
                                        $total_per = 0;
                                        if (!empty($wallet['total_debit']) && !empty($wallet['total_credit'])) {
                                            $total_per = ($wallet['total_debit'] / $wallet['total_credit']) * 100;
                                        }
                                        ?>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($total_per); ?>%">
                                                <?php echo number_format(abs($total_per), 2); ?>%
                                            </div>
                                        </div>                                     
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_add_wallet'])) ? $user_language[$user_selected]['lg_add_wallet'] : $default_language['en']['lg_add_wallet']; ?></h4>
                                <form action="<?php echo base_url() ?>user/Dashboard/paytab_payment" method="get" id="paytab_payment">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text display-5"><?php echo currency_conversion($user_currency_code); ?></label>
                                            </div>
											 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="text"  maxlength="10" class="form-control isNumber" name="wallet_amt" id="wallet_amt" placeholder="00.00" value="">
                                            <input type="hidden"  id="currency_val" name="currency_val"  value="<?php echo $user_currency_code; ?>">
                                            <input type="hidden"  id="paystack_wallet_amt" name="paystack_wallet_amt"  value="<?php echo $user_currency_code; ?>">
                                            
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center mb-3">
                                    <h5 class="mb-3"><?php echo (!empty($user_language[$user_selected]['lg_OR'])) ? $user_language[$user_selected]['lg_OR'] : $default_language['en']['lg_OR']; ?></h5>


                                    <ul class="list-inline mb-0">
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="50" class="updatebtn add_wallet_value"><?php echo currency_conversion($user_currency_code); ?>50</a>
                                        </li>
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="100" class="updatebtn add_wallet_value"><?php echo currency_conversion($user_currency_code); ?>100</a>
                                        </li>
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="150" class="updatebtn add_wallet_value"><?php echo currency_conversion($user_currency_code); ?>150</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="container">
                                <div class="row">
									<?php if(!empty($paypal_option_status)) { ?>
                                    <div class="col-4">
                                        <input class="form-check-input" type="radio" name="payment_type" id="paypal" value="paypal">
                                        <img src="<?php echo base_url() . "assets/img/paypal.png"; ?>">
                                    </div>
									<?php } if(!empty($stripe_option_status)) { ?>
                                    <div class="col-4">
                                        <input class="form-check-input" type="radio" name="payment_type" id="stripe"  value="stripe">
                                        <img src="<?php echo base_url() . "assets/img/stripe.png"; ?>">
                                    </div>
									<?php } if(!empty($razor_option_status)) { ?>
									<div class="col-4">
                                        <input class="form-check-input" type="radio" name="payment_type" id="razorpay"  value="razorpay">
                                        <img src="<?php echo base_url() . "assets/img/razorpay.png"; ?>">
                                    </div>
									<?php } if(!empty($paystack_option_status)) { ?>
    									<br><div class="col-4">
                                            <input class="form-check-input" type="radio" name="payment_type" id="paystack"  value="paystack">
                                            <img src="<?php echo base_url() . "assets/img/paystack-logo-vector11.png"; ?>">
                                        </div>
                                    <?php } if(settingValue('paysolution_show') == 1) { ?>
                                        <div class="col-4">
                                            <input class="form-check-input" type="radio" name="payment_type" id="paysolution"  value="paysolution">
                                            <img src="<?php echo base_url() . "assets/img/paysolution.png"; ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                    <br>
                                </div>

                                <input type="hidden" id="paypal_gateway" value="<?php echo $paypal_gateway; ?>">
                                <input type="hidden" id="braintree_key" value="<?php echo $braintree_key; ?>">
								
								<input type="hidden" id="razorpay_apikey" value="<?php echo $razorpay_apikey; ?>">
                                <input type="hidden" id="paystack_apikey" value="<?php echo $paystack_apikey; ?>">

                                <input type="hidden" id="username" value="<?php echo $user_details['name']; ?>">
                                <input type="hidden" id="mobileno" value="<?php echo $user_details['mobileno']; ?>">
                                <input type="hidden" id="email" value="<?php echo $user_details['email']; ?>">


                                <input type="hidden" id="state" value="<?php echo (!empty($state)) ? $state : "IL"; ?>">
                                <input type="hidden" id="country" value="<?php echo (!empty($country)) ? $country : "US"; ?>">
                                <input type="hidden" id="pincode" value="<?php echo (!empty($user_details['pincode'])) ? $user_details['pincode'] : "60652"; ?>">
                                <input type="hidden" id="address" value="<?php echo (!empty($user_details['address'])) ? $user_details['address'] : "1234 Main St."; ?>"><input type="hidden" id="city" value="<?php echo (!empty($city)) ? $city : "Chicago"; ?>">
                            <?php    $query = $this->db->query("select * from system_settings WHERE status = 1");
                                    $result = $query->result_array();
                                    $stripe_option = '1';
                                    $publishable_key = '';
                                    $live_publishable_key = '';
                                    $logo_front = '';
                                    $paypall_option = settingValue('paypal_option');
                                    $razorpay_option = settingValue('razorpay_option');
                                    $paystack_option = settingValue('paystack_option');
                                    foreach ($result as $res) {
                                        if ($res['key'] == 'stripe_option') {
                                            $stripe_option = $res['value'];
                                        }
                                        if ($res['key'] == 'publishable_key') {
                                            $publishable_key = $res['value'];
                                        }
                                        if ($res['key'] == 'live_publishable_key') {
                                            $live_publishable_key = $res['value'];
                                        }

                                        if ($res['key'] == 'logo_front') {
                                            $logo_front = $res['value'];
                                        }
                                    }

                                    if ($stripe_option == 1) {
                                        $stripe_key = $publishable_key;
                                    } else {
                                        $stripe_key = $live_publishable_key;
                                    }

                                    if ($paypall_option == 1) {
                                        $paypall_key = settingValue('paypal_appkey');
                                    } else {
                                        $paypall_key = settingValue('live_paypal_appkey');
                                    }
                                    if ($razorpay_option == 1) {
                                        $razorpay_key = settingValue('razorpay_apikey');
                                    } else {
                                        $razorpay_key = settingValue('live_razorpay_apikey');
                                    }

                                    if ($paystack_option == 1) {
                                        $paystack_key = settingValue('paystack_apikey');
                                    } else {
                                        $paystack_key = settingValue('live_paystack_apikey');
                                    }

                                    if (file_exists($logo_front)) {
                                        $web_log = base_url() . $logo_front;
                                    } else {
                                        $web_log = base_url() . 'assets/img/logo.png';
                                    }
                                    ?>

                                    <input type="hidden" id="stripe_key" value="<?php echo $stripe_key; ?>">
                                    <input type="hidden" id="paypal_key" value="<?php echo $paypall_key; ?>">
                                    <input type="hidden" id="razorpay_key" value="<?php echo $razorpay_key; ?>">
                                    <input type="hidden" id="paystack_key" value="<?php echo $paystack_key; ?>">
                                    <input type="hidden" id="logo_front" value="<?php echo $web_log; ?>">
                                    <input type="hidden" id="tokens" value="<?php echo $this->session->userdata('chat_token'); ?>">
                                <a href="javascript:void(0);"id="stripe_wallet" class="btn btn-primary btn-block withdraw-btn"><?php echo (!empty($user_language[$user_selected]['lg_add_to_wallet'])) ? $user_language[$user_selected]['lg_add_to_wallet'] : $default_language['en']['lg_add_to_wallet']; ?></a>
                                <span class="paypal_desc"><?php echo (!empty($user_language[$user_selected]['lg_click_paypal_to_pay'])) ? $user_language[$user_selected]['lg_click_paypal_to_pay'] : $default_language['en']['lg_click_paypal_to_pay']; ?></span>
                                <a id="pays">
                                    <div id="paypal-button"></div>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>

            <form method="POST" action="<?php echo base_url() . "paypal_braintree" ?>" id="myForm">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" name="amount" value="" id="paypal_amount">
                <input type="hidden" name="payload_nonce" value="" id="payload_nonce">  
                <input type="hidden" name="orderID" value="" id="orderID">  
            </form>

            <form method="POST" action="https://www.thaiepay.com/epaylink/payment.aspx?lang=en" id="paysolution_form" target="_blank">
                <input type="hidden" name="paytype" value="wallet" />
                <input type="hidden" name="payso" value="payso" />
                <input type="hidden" name="refno" value="<?php echo rand(1000000000, 9999999999); ?>">
                <input type="hidden" name="merchantid" value="<?php echo settingValue('paysolution_merchant_id'); ?>">
                <input type="hidden" name="customeremail" value="<?php echo $this->session->userdata('email'); ?>">
                <input type="hidden" name="cc" value="00">
                <input type="hidden" name="productdetail" value="wallet">
                <input type="hidden" name="total" id="paysolution_amt" value="">
            </form>

            <h4 class="mb-4"><?php echo (!empty($user_language[$user_selected]['lg_wallet_transaction'])) ? $user_language[$user_selected]['lg_wallet_transaction'] : $default_language['en']['lg_wallet_transaction']; ?></h4>
            <div class="card transaction-table mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if (!empty($wallet_history)) { ?>
                            <table id="order-summary" class="table table-center mb-0">
                            <?php } else { ?>
                                <table class="table table-center mb-0">
                                <?php } ?>
                                <thead>
                                    <tr>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_sno'])) ? $user_language[$user_selected]['lg_sno'] : $default_language['en']['lg_sno']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Date'])) ? $user_language[$user_selected]['lg_Date'] : $default_language['en']['lg_Date']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Credit'])) ? $user_language[$user_selected]['lg_Credit'] : $default_language['en']['lg_Credit']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Debit'])) ? $user_language[$user_selected]['lg_Debit'] : $default_language['en']['lg_Debit']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Txt_amt'])) ? $user_language[$user_selected]['lg_Txt_amt'] : $default_language['en']['lg_Txt_amt']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Available'])) ? $user_language[$user_selected]['lg_Available'] : $default_language['en']['lg_Available']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_reason'])) ? $user_language[$user_selected]['lg_reason'] : $default_language['en']['lg_reason']; ?></th>
                                        <th><?php echo (!empty($user_language[$user_selected]['lg_Status'])) ? $user_language[$user_selected]['lg_Status'] : $default_language['en']['lg_Status']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_cr = 0;
                                    $total_dr = 0;
                                    if (!empty($wallet_history)) {
                                        foreach ($wallet_history as $key => $value) {

                                            if (!empty($value['credit_wallet'])) {
                                                $color = 'success';
                                                $message = 'Credit';
                                            } else {
                                                $color = 'danger';
                                                $message = 'Debit';
                                            }
                                            if (!empty($value["fee_amt"]) && $value["fee_amt"] > 1) {
                                                $txt_amt = number_format($value["fee_amt"] / 100, 2);
                                            } else {
                                                $txt_amt = 0;
                                            }
                                            $datef = explode(' ', $value["created_at"]);
                                            if(settingValue('time_format') == '12 Hours') {
                                                $time = date('h:ia', strtotime($datef[1]));
                                            } elseif(settingValue('time_format') == '24 Hours') {
                                               $time = date('H:i:s', strtotime($datef[1]));
                                            } else {
                                                $time = date('G:ia', strtotime($datef[1]));
                                            }
                                            
                                            $date = date(settingValue('date_format'), strtotime($datef[0]));
                                            $wall_time = $date.' '.$time;

                                            $user_currency_code = '';
                                            $userId = $this->session->userdata('id');
                                            $user_details = $this->db->where('id', $userId)->get('users')->row_array();
                                            If (!empty($userId)) {
                                                $service_amount1 = $value["current_wallet"];
                                                $service_amount2 = $value["credit_wallet"];
                                                $service_amount3 = $value["debit_wallet"];
                                                $service_amount4 = $txt_amt;
                                                $service_amount5 = $value["avail_wallet"];
                                                $get_currency = get_currency();
                                                $user_currency = get_user_currency();
                                                $user_currency_code = $user_currency['user_currency_code'];

                                                $service_amount1 = get_gigs_currency($value["current_wallet"], $value["currency_code"], $user_details['currency_code']);
                                                $service_amount2 = get_gigs_currency($value["credit_wallet"], $value["currency_code"], $user_details['currency_code']);
                                                $service_amount3 = get_gigs_currency($value["debit_wallet"], $value["currency_code"], $user_details['currency_code']);
                                                $service_amount4 = get_gigs_currency($txt_amt, $value["currency_code"], $user_details['currency_code']);
                                                $service_amount5 = get_gigs_currency($value["avail_wallet"], $value["currency_code"], $user_details['currency_code']);
                                            } else {
                                                $user_currency_code = settings('currency');
                                                $service_amount1 = $value["current_wallet"];
                                                $service_amount2 = $value["credit_wallet"];
                                                $service_amount3 = $value["debit_wallet"];
                                                $service_amount4 = $txt_amt;
                                                $service_amount5 = $value["avail_wallet"];
                                            }
                                            if (is_nan($service_amount1) || is_infinite($service_amount1)) {
                                                $service_amount1 = $value["current_wallet"];
                                            }
                                            if (is_nan($service_amount2) || is_infinite($service_amount2)) {
                                                $service_amount2 = $value["credit_wallet"];
                                            }
                                            if (is_nan($service_amount3) || is_infinite($service_amount3)) {
                                                $service_amount3 = $value["debit_wallet"];
                                            }
                                            if (is_nan($service_amount5) || is_infinite($service_amount5)) {
                                                $service_amount5 = $value["avail_wallet"];
                                            }
											
                                            echo '<tr>
									<td>' . ($key + 1) . '</td>
									<td>' . $wall_time . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount1 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount2 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount3 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount4 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount5 . '</td>
									<td><lable>' . $value["reason"] . '</lable></td>
									<td><span class="badge bg-' . $color . '-light">' . $message . '</span></td> 
									</tr>';
                                        }
                                    } else {
                                        echo '<tr> <td colspan="9"> <div class="text-center text-muted">No data found</div></td> </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>


<!-- <footer class="footer">
 -->    <?php /*
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $stripe_option = '1';
    $publishable_key = '';
    $live_publishable_key = '';
    $logo_front = '';
    $paypall_option = settingValue('paypall_option');
    $razorpay_option = settingValue('razorpay_option');
    $paystack_option = settingValue('paystack_option');
    foreach ($result as $res) {
        if ($res['key'] == 'stripe_option') {
            $stripe_option = $res['value'];
        }
        if ($res['key'] == 'publishable_key') {
            $publishable_key = $res['value'];
        }
        if ($res['key'] == 'live_publishable_key') {
            $live_publishable_key = $res['value'];
        }

        if ($res['key'] == 'logo_front') {
            $logo_front = $res['value'];
        }
    }

    if ($stripe_option == 1) {
        $stripe_key = $publishable_key;
    } else {
        $stripe_key = $live_publishable_key;
    }

    if ($paypall_option == 1) {
        $paypall_key = settingValue('paypal_appkey');
    } else {
        $paypall_key = settingValue('live_paypal_appkey');
    }

    if ($razorpay_option == 1) {
        $razorpay_key = settingValue('razorpay_apikey');
    } else {
        $razorpay_key = settingValue('live_razorpay_apikey');
    }

    if ($paystack_option == 1) {
        $paystack_key = settingValue('paystack_apikey');
    } else {
        $paystack_key = settingValue('live_paystack_apikey');
    }

    if (file_exists($logo_front)) {
        $web_log = base_url() . $logo_front;
    } else {
        $web_log = base_url() . 'assets/img/logo.png';
    }
    ?>

    <input type="hidden" id="stripe_key" value="<?php echo $stripe_key; ?>">
    <input type="hidden" id="paypal_key" value="<?php echo $paypall_key; ?>">
    <input type="hidden" id="razorpay_key" value="<?php echo $razorpay_key; ?>">
    <input type="hidden" id="paystack_key" value="<?php echo $paystack_key; ?>">
    <input type="hidden" id="logo_front" value="<?php echo $web_log; ?>">
    <input type="hidden" id="tokens" value="<?php echo $this->session->userdata('chat_token'); ?>"> */ ?>
<!-- </footer> -->


<button id="stripe_booking" >Purchase book</button>


<span id="success_message"><?php echo $this->session->flashdata('success_message'); ?></span>
<span id="error_message"><?php echo $this->session->flashdata('error_message'); ?></span>
<?php if (!empty($this->session->flashdata('success_message'))) { ?>
    <script src="<?php echo base_url(); ?>assets/js/success_toaster.js"></script>
<?php } ?>

<?php if (!empty($this->session->flashdata('error_message'))) { ?>
    <script src="<?php echo base_url(); ?>assets/js/error_toaster.js"></script>
    <?php
}
$this->session->unset_userdata('error_message');
$this->session->unset_userdata('success_message');
?>

    <script>
        $('#stripe_wallet').hide();
        $('#stripe').click(function(){
            $stripe= $(this).val();
           
            if($stripe == 'stripe'){
                $('#stripe_wallet').show();
                
            }else{
                $('#stripe_wallet').hide();
            }
        });
        $('#paypal').click(function(){
            $paypal= $(this).val();
           
            if($paypal == 'paypal'){
                $('#stripe_wallet').show();
            }else{
                $('#stripe_wallet').hide();
            }
        });
		
		$('#razorpay').click(function(){
            $razorpay= $(this).val();
           
            if($razorpay == 'razorpay'){
                $('#stripe_wallet').show();
            }else{
                $('#stripe_wallet').hide();
            }
        });
		
		$('#paytabs').click(function(){
            $paytabs= $(this).val();
           
            if($paytabs == 'paytabs'){
                $('#stripe_wallet').show();
            }else{
                $('#stripe_wallet').hide();
            }
        });
		
		$('#paystack').click(function(){
            $paystack= $(this).val();
           
            if($paystack == 'paystack'){
                $('#stripe_wallet').show();
            }else{
                $('#stripe_wallet').hide();
            }
        });

        $('#paysolution').click(function(){
            $paysolution= $(this).val();
           
            if($paysolution == 'paysolution'){
                $('#stripe_wallet').show();
            }else{
                $('#stripe_wallet').hide();
            }
        });
        </script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


