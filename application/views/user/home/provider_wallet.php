<div class="content">
    <div class="container">
        <div class="row">
            <?php $this->load->view('user/home/provider_sidemenu'); ?>
            <div class="col-xl-9 col-md-8">
                <div class="row">


                    <?php
                    
                    $user_currency_code = '';
                    $userId = $this->session->userdata('id');
                    If (!empty($userId)) {
                        $service_amount1 = ($wallet['wallet_amt'])?$wallet['wallet_amt']:'0';
                        $wallet_amount1 = ($wallet['wallet_amt'])?$wallet['wallet_amt']:'0';
                        $wallet_currency = ($wallet['currency_code'])?$wallet['currency_code']:'USD';
                        $user_currency = get_provider_currency();
                        $user_currency_code = $user_currency['user_currency_code'];
                        $service_amount1 = get_gigs_currency($wallet_amount1, $wallet_currency, $user_currency_code);
                    } else {
                        $user_currency_code = settings('currency');
                        $service_amount1 = $wallet['wallet_amt'];
                        
                    }
                    if (is_nan($service_amount1) || is_infinite($service_amount1)) {
                        $service_amount1 = $wallet['wallet_amt'];
                    }
                    ?>

                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?></h4>

                                <div class="wallet-details">
                                    <span><?php echo (!empty($user_language[$user_selected]['lg_Wallet_Balance'])) ? $user_language[$user_selected]['lg_Wallet_Balance'] : $default_language['en']['lg_Wallet_Balance']; ?></span>
                                    <h3><?php echo currency_conversion($user_currency_code) . $service_amount1; ?></h3>

                                    <div class="d-flex justify-content-between my-4">
                                        <?php
                                        $total_cr = 0;
                                        $total_dr = 0;
                                        if (!empty($wallet_history)) {
                                            foreach ($wallet_history as $key => $value) {
												$total_cr += get_gigs_currency($value['credit_wallet'], $value['currency_code'], $user_currency_code);
												$total_dr += abs(get_gigs_currency($value['debit_wallet'], $value['currency_code'], $user_currency_code));
                                            }
                                        }
                                        ?>
                                        <div>
                                            <p class="mb-1"><?php echo (!empty($user_language[$user_selected]['lg_Total_Credit'])) ? $user_language[$user_selected]['lg_Total_Credit'] : $default_language['en']['lg_Total_Credit']; ?></p>
                                            <h4><?php echo currency_conversion($user_currency_code) . number_format($total_cr, 2); ?></h4>
                                        </div>
                                        <div>
                                            <p class="mb-1"><?php echo (!empty($user_language[$user_selected]['lg_Total_Debit'])) ? $user_language[$user_selected]['lg_Total_Debit'] : $default_language['en']['lg_Total_Debit']; ?></p>
                                            <h4><?php echo currency_conversion($user_currency_code) . number_format($total_dr, 2); ?></h4>
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
                                            <span><?= $wallet['currency'] . '' . abs($wallet['total_debit']); ?></span>
                                            <span><?= $wallet['currency'] . '' . number_format($wallet['total_credit'], 2); ?></span>
                                        </div>

                                        <?php
                                        $total_per = 0;
                                        if (!empty($wallet['total_debit']) && !empty($wallet['total_credit'])) {
                                            $total_per = ($wallet['total_debit'] / $wallet['total_credit']) * 100;
                                        }
                                        ?>
                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" style="width:<?= round($total_per); ?>%">
                                                <?= number_format(abs($total_per), 2); ?>%
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
                                <h4 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_Withdraw'])) ? $user_language[$user_selected]['lg_Withdraw'] : $default_language['en']['lg_Withdraw']; ?></h4>
                                <form action="#">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text display-5"><?= currency_conversion($user_currency_code); ?></label>
                                            </div>
                                        <input type="hidden"  id="currency_val" name="currency_val" value="<?php echo $user_currency_code;?>">
										<input type="hidden" id="wallet_amount" value="<?php echo $service_amount1; ?>">
                                            <input type="text" maxlength="10"  class="form-control isNumber" name="wallet_withdraw_amt" id="wallet_withdraw_amt" placeholder="00.00">
                                            <input type="hidden" name="paystack_wallet_amount" id="paystack_wallet_amount" value="">
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center mb-3">
                                    <h5 class="mb-3"><?php echo (!empty($user_language[$user_selected]['lg_OR'])) ? $user_language[$user_selected]['lg_OR'] : $default_language['en']['lg_OR']; ?></h5>                                       
                                    <ul class="list-inline mb-0">
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="50" class="updatebtn withdraw_wallet_value"><?= currency_conversion($user_currency_code); ?>50</a>
                                        </li>
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="100" class="updatebtn withdraw_wallet_value"><?= currency_conversion($user_currency_code); ?>100</a>
                                        </li>
                                        <li class="line-inline-item mb-0 d-inline-block">
                                            <a href="javascript:;" data-amount="150" class="updatebtn withdraw_wallet_value"><?= currency_conversion($user_currency_code); ?>150</a>
                                        </li>
                                    </ul>
                                </div>
								
								<form action="<?= base_url() ?>user/wallet/payment" method="post" id="paypal_payment">
									<div class="form-group">
										<div id="payment-method">
											<div class="row">
												 <?php if($razorpay == '1') { ?>
                                                <div class="col-4">
                                                    <span>
                                                    <input type="radio" id="gigs_payment_radio6" name="group2" value="RazorPay">
                                                    <label for="gigs_payment_radio6"> <img src="<?php echo base_url(); ?>assets/img/razorpay.png" alt="RazorPay"></label>
                                                    </span>
                                                </div>
                                        <?php } ?>
                                                <?php if($paypal == '1') { ?>
                                                <div class="col-4">
                                                    <span>
                                                    <input type="radio" id="gigs_payment_radio3" name="group2" value="Direct">
                                                    <label for="gigs_payment_radio3"> <img src="<?php echo base_url(); ?>assets/img/paypal.png" alt="stripe"></label>
                                                </span>
                                                </div>
                                        <?php } ?>
                                        <?php if($stripe == '1') { ?>
                                                <div class="col-4">
                                                    <span>
                                                    <input type="radio" id="gigs_payment_radio5" name="group2" value="stripe" >
                                                    <label for="gigs_payment_radio5"> <img src="<?php echo base_url(); ?>assets/img/stripe.png" alt="stripe"></label>
                                                    </span>
                                                </div>
                                        <?php } ?>
                                         <?php if($paystack == '1') { ?>
                                                <div class="col-4">
                                                    <span>
                                                        <input type="radio" id="gigs_payment_radio7" name="group2" value="paystack" >
                                                        <label for="gigs_payment_radio3"><img src="<?php echo base_url() . "assets/img/paystack-logo-vector11.png"; ?>"></label>
                                                    </span>
                                                </div>
                                        <?php } if(settingValue('paysolution_show') == 1) { ?>
                                        <div class="col-4">
                                            <input class="form-check-input" type="radio" name="group2" id="paysolution"  value="paysolution">
                                            <img src="<?php echo base_url() . "assets/img/paysolution.png"; ?>">
                                        </div>
                                    <?php } ?>
											</div>
										</div>
										<div class="input-group mb-3">
										</div>
									</div>
								</form>
                                <a href="javascript:void(0);" data-userid="<?=$userId?>" id="stripe_withdraw_wallet" class="btn btn-primary btn-block withdraw-btn"><?php echo (!empty($user_language[$user_selected]['lg_Withdraw'])) ? $user_language[$user_selected]['lg_Withdraw'] : $default_language['en']['lg_Withdraw']; ?></a>
                                <div id="card_form_div" >
                                    <div class="payment-card">
                                        <span><?php echo (!empty($user_language[$user_selected]['lg_Withdraw_Amount_is'])) ? $user_language[$user_selected]['lg_Withdraw_Amount_is'] : $default_language['en']['lg_Withdraw_Amount_is']; ?></span>
                                        <h3 class="mb-3"><?php echo currency_conversion($user_currency_code); ?><span id="remember_withdraw_wallet"></span></h3>
                                        <h5 class="mb-3"><?php echo (!empty($user_language[$user_selected]['lg_fill_debit_card_details'])) ? $user_language[$user_selected]['lg_fill_debit_card_details'] : $default_language['en']['lg_fill_debit_card_details']; ?></h5>
                                        <div id="card-element">
                                            <!-- Stripe Element will be inserted here -->
                                        </div>

                                        <!-- Used to display form errors. -->
                                        <div id="card-errors" role="alert"></div>
                                        <div class="text-center"><div id="load_div"></div></div>
                                        <hr>
                                        <div class="text-center">
                                            <button class="btn btn-success" id="pay_btn"><?php echo (!empty($user_language[$user_selected]['lg_Withdraw'])) ? $user_language[$user_selected]['lg_Withdraw'] : $default_language['en']['lg_Withdraw']; ?></button>
                                            <button class="btn btn-secondary" id="cancel_card_btn"><?php echo (!empty($user_language[$user_selected]['lg_Cancel'])) ? $user_language[$user_selected]['lg_Cancel'] : $default_language['en']['lg_Cancel']; ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="mb-4"><?php echo (!empty($user_language[$user_selected]['lg_Recent_Transactions'])) ? $user_language[$user_selected]['lg_Recent_Transactions'] : $default_language['en']['lg_Recent_Transactions']; ?></h4>
                <div class="card transaction-table mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if (!empty($wallet_history)) {

                             ?>
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
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Available'])) ? $user_language[$user_selected]['lg_Available'] : $default_language['en']['lg_Available']; ?></th>
											<th><?php echo (!empty($user_language[$user_selected]['lg_reason'])) ? $user_language[$user_selected]['lg_reason'] : $default_language['en']['lg_reason']; ?></th>
                                            <th><?php echo (!empty($user_language[$user_selected]['lg_Status'])) ? $user_language[$user_selected]['lg_Status'] : $default_language['en']['lg_Status']; ?></th>
                                            <th>Documents</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_cr = 0;
                                        $total_dr = 0;
                                        if (!empty($wallet_history)) {
                                            foreach ($wallet_history as $key => $value) {
                                                
                                                $dname = explode(".", $value['transaction_document']);
                                                $extension = $dname[1];
                                                
                                                if(!empty($value['transaction_document'])) {
                                                    if($extension == 'pdf') { 
                                                        $document = '<a class="text-info" href="'.base_url() .  $value['transaction_document'].'" download><span><i class="fa fa-file-pdf" aria-hidden="true"> Download PDF</i></span></a>';
                                                         } else if($extension == 'xlsx') {
                                                            $document = '<a class="text-info" href="'.base_url() .  $value['transaction_document'].'" download><span><i class="fa fa-file-excel" aria-hidden="true"> Download Excel</i></span></a>'; 
                                                         } else {
                                                        $document = '<a class="text-info" href="'.base_url() .  $value['transaction_document'].'" download><img class="user-image" src="'.  base_url() .  $value['transaction_document'].'"/></a>';
                                                        }
                                                } else {
                                                    $document = '-';
                                                }
                                                if($value['paid_status'] == 'paid') { 
                                                    $status = '<button class="btn btn-success withdraw_verify" type="button" data-id='.$value['id'].' data-amount='.$value['debit_wallet'].' id="withdraw_verify">Verify</button>';
                                                } else if($value['paid_status'] == 'pending') {
                                                    $color = 'warning';
                                                    $message = (!empty($user_language[$user_selected]['lg_Pending'])) ? $user_language[$user_selected]['lg_Pending'] : $default_language['en']['lg_Pending'];
                                                    
                                                        $status = '<span class="badge bg-' . $color . '-light">'.$message.'</span>';
                                                } else if($value['paid_status'] == 'cancel') {
                                                    $color = 'danger';
                                                    $message = (!empty($user_language[$user_selected]['lg_Cancelled'])) ? $user_language[$user_selected]['lg_Cancelled'] : $default_language['en']['lg_Cancelled'];
                                                    
                                                        $status = '<span class="badge bg-' . $color . '-light">'.$message.'</span>'; 
                                                } else {  
                                                    $color = 'success';
                                                    $message = (!empty($user_language[$user_selected]['lg_Completed'])) ? $user_language[$user_selected]['lg_Completed'] : $default_language['en']['lg_Completed'];
                                                    
                                                        $status = '<span class="badge bg-' . $color . '-light">'.$message.'</span>';
                                                }

                                                if (!empty($value['credit_wallet'])) {
                                                    $color = 'success';
                                                    $message = (!empty($user_language[$user_selected]['lg_Completed'])) ? $user_language[$user_selected]['lg_Completed'] : $default_language['en']['lg_Completed'];
                                                } else { }
                                                $total_cr += (int) $value['credit_wallet'];
                                                $total_dr += (int) abs($value['debit_wallet']);

                                                $user_currency_code = '';
                                                $userId = $this->session->userdata('id');
                                                $user_details = $this->db->where('id', $userId)->get('providers')->row_array();
                                                If (!empty($userId)) {
                                                    $service_amount1 = $value["current_wallet"];
                                                    $service_amount2 = $value["credit_wallet"];
                                                    $service_amount3 = $value["debit_wallet"];
                                                    $service_amount4 = $txt_amt;
                                                    $service_amount5 = $value["avail_wallet"];
                                                    $get_currency = get_currency();
                                                    $user_currency = get_provider_currency();
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
                                                if($value['payment_type']== 1) {
                                                    $payment_type = 'COD';
                                                } else if($value['payment_type']==2) {
                                                    $payment_type = 'Wallet';    
                                                } else {
                                                   $payment_type = '-'; 
                                                }
                                                    $service_amount3 = $value["debit_wallet"];
                                                }
                                                if (is_nan($service_amount5) || is_infinite($service_amount5)) {
                                                    $service_amount5 = $value["avail_wallet"];
                                                }
                                             $datef = explode(' ', $value["created_at"]);
                                            if(settingValue('time_format') == '12 Hours') {
                                                $time = date('h:ia', strtotime($datef[1]));
                                            } elseif(settingValue('time_format') == '24 Hours') {
                                               $time = date('H:i:s', strtotime($datef[1]));
                                            } else {
                                                $time = date('G:ia', strtotime($datef[1]));
                                            }
                                           
                                            $date = (settingValue('date_format'))?date(settingValue('date_format'), strtotime($datef[0])):date('d-m-Y', strtotime($datef[0])); 
                                            $wall_time = $date.' '.$time;

                                                echo '<tr>
									<td>' . ($key + 1) . '</td>
									<td>' . $wall_time . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount1 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount2 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount3 . '</td>
									<td>' . currency_conversion($user_currency_code) . '' . $service_amount5 . '</td>
                                    
									<td><lable>' . $value["reason"] . '</lable></td>
									<td>'.$status.'</td> 
                                    <td>'.$document.'</td> 
									</tr>';
                                            }
                                        } else { ?>
                                            <tr> <td colspan="9"> <div class="text-center"><?php echo (!empty($user_language[$user_selected]['lg_No_data_found'])) ? $user_language[$user_selected]['lg_No_data_found'] : $default_language['en']['lg_No_data_found']; ?></div></td> </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>			

            </div>
        </div>

    </div>


    <?php
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

    if (!empty($logo_front)) {
        $web_log = base_url() . $logo_front;
    } else {
        $web_log = base_url() . 'assets/img/logo.png';
    }
    ?>

   <input type="hidden" id="paypal_key" value="<?= $paypall_key; ?>">
    <input type="hidden" id="razorpay_key" value="<?= $razorpay_key; ?>">
    <input type="hidden" id="paystack_key" value="<?= $paystack_key; ?>">
    <input type="hidden" id="logo_front" value="<?= $web_log; ?>">
    <input type="hidden" id="token" value="<?= $this->session->userdata('chat_token'); ?>">



  <!--- Withdraw details modal--->
    <div class="modal" id="withdraw_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="text-center"><?php echo (!empty($user_language[$user_selected]['lg_withdraw_amount'])) ? $user_language[$user_selected]['lg_withdraw_amount'] : $default_language['en']['lg_withdraw_amount']; ?></h2>
                <div class="modal-body">
                    <form id="bank_details" method="post" action="#">
                        <div class="paypal_details">
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_paypal_email_id'])) ? $user_language[$user_selected]['lg_paypal_email_id'] : $default_language['en']['lg_paypal_email_id']; ?></label>
                                <input class="form-control" type="text" name="paypal_email_id" value="<?= (!empty($bank_account['paypal_email_id'])) ? $bank_account['paypal_email_id'] : ''; ?>" id="paypal_email_id">
                                <span class="paypal_email_id_error"></span>
                            </div>
                        </div>
                        <div class="bank_details">
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_lg_Bank_Name'])) ? $user_language[$user_selected]['lg_lg_Bank_Name'] : $default_language['en']['lg_lg_Bank_Name']; ?>
                                </label>
                                <input class="form-control" type="text" name="bank_name" value="<?= (!empty($bank_account['bank_name'])) ? $bank_account['bank_name'] : ''; ?>" id="bank_name">
                                <span class="bank_name_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_Bank_Address'])) ? $user_language[$user_selected]['lg_Bank_Address'] : $default_language['en']['lg_Bank_Address']; ?></label>
                                <input class="form-control" type="text" name="bank_address" value="<?= (!empty($bank_account['bank_address'])) ? $bank_account['bank_address'] : ''; ?>" id="bank_address">
                                <span class="address_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_Account_No'])) ? $user_language[$user_selected]['lg_Account_No'] : $default_language['en']['lg_Account_No']; ?></label>
                                <input class="form-control" type="text" name="account_no" value="<?= (!empty($bank_account['account_number'])) ? $bank_account['account_number'] : ''; ?>" id="account_no">
                                <span class="account_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_lg_IFSC_Code'])) ? $user_language[$user_selected]['lg_lg_IFSC_Code'] : $default_language['en']['lg_lg_IFSC_Code']; ?></label>
                                <input class="form-control" type="text" name="ifsc_code" value="<?= (!empty($bank_account['account_ifsc'])) ? $bank_account['account_ifsc'] : ''; ?>" id="ifsc_code">
                                <span class="ifsc_code_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_Sort_Code'])) ? $user_language[$user_selected]['lg_Sort_Code'] : $default_language['en']['lg_Sort_Code']; ?></label>
                                <input class="form-control" type="text" name="sort_code" value="<?= (!empty($bank_account['sort_code'])) ? $bank_account['sort_code'] : ''; ?>" id="sort_code">
                                <span class="sort_code_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_Routing_No'])) ? $user_language[$user_selected]['lg_Routing_No'] : $default_language['en']['lg_Routing_No']; ?></label>
                                <input class="form-control" type="text" name="routing_number" value="<?= (!empty($bank_account['routing_number'])) ? $bank_account['routing_number'] : ''; ?>" id="routing_number">
                                <span class="routing_no_error"></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo (!empty($user_language[$user_selected]['lg_Pan_No'])) ? $user_language[$user_selected]['lg_Pan_No'] : $default_language['en']['lg_Pan_No']; ?></label>
                                <input class="form-control" type="text" name="pancard_no" value="<?= (!empty($bank_account['pancard_no'])) ? $bank_account['pancard_no'] : ''; ?>" id="pan_number">
                                <span class="pan_no_error"></span>
                            </div>
                        </div>
						<div class="razorpay_details">
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_Name'])) ? $user_language[$user_selected]['lg_Name'] : $default_language['en']['lg_Name']; ?>
                               </label>
                                <input class="form-control" type="text" name="name" value="<?= (!empty($bank_account['name'])) ? $bank_account['name'] : ''; ?>" id="name">
                                <span class="name"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                 <?php echo (!empty($user_language[$user_selected]['lg_Email_ID'])) ? $user_language[$user_selected]['lg_Email_ID'] : $default_language['en']['lg_Email_ID']; ?>
                                 </label>
                                <input class="form-control" type="email" name="email" value="<?= (!empty($bank_account['email'])) ? $bank_account['email'] : ''; ?>" id="email_id">
                                <span class="email_error"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo (!empty($user_language[$user_selected]['lg_Contact_No'])) ? $user_language[$user_selected]['lg_Contact_No'] : $default_language['en']['lg_Contact_No']; ?>
                                </label>
                                <input class="form-control" type="number" name="contact" value="<?= (!empty($bank_account['contact'])) ? $bank_account['contact'] : ''; ?>" id="contact">
                                <span class="contact_no_error"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                  <?php echo (!empty($user_language[$user_selected]['lg_Card_No'])) ? $user_language[$user_selected]['lg_Card_No'] : $default_language['en']['lg_Card_No']; ?>
                                </label>
                                <input class="form-control" type="number" name="cardno" value="<?= (!empty($bank_account['cardno'])) ? $bank_account['cardno'] : ''; ?>" id="cardno">
                                <span class="cardno_error"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                  <?php echo (!empty($user_language[$user_selected]['lg_Card_Name'])) ? $user_language[$user_selected]['lg_Card_Name'] : $default_language['en']['lg_Card_Name']; ?>
                                </label>
                                <input class="form-control" type="text" name="cardname" value="<?= (!empty($bank_account['cardname'])) ? $bank_account['cardname'] : ''; ?>" id="cardname">
                                <span class="cardname_error"></span>
                            </div>  
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_Bank_Name'])) ? $user_language[$user_selected]['lg_Bank_Name'] : $default_language['en']['lg_Bank_Name']; ?>
                                </label>
                                <input class="form-control" type="text" name="bank_name" value="" id="bank_name1">
                                <span class="bank_name1_error"></span>
                            </div>  
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_IFSC_Code'])) ? $user_language[$user_selected]['lg_IFSC_Code'] : $default_language['en']['lg_IFSC_Code']; ?>
                                </label>
                                <input class="form-control" type="text" name="ifsc" value="<?= (!empty($bank_account['ifsc'])) ? $bank_account['ifsc'] : ''; ?>" id="ifsc_code1">
                                <span class="ifsc_code1_error"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_Account_No'])) ? $user_language[$user_selected]['lg_Account_No'] : $default_language['en']['lg_Account_No']; ?>
                                </label>
                                <input class="form-control" type="number" name="accountnumber" value="<?= (!empty($bank_account['accountnumber'])) ? $bank_account['accountnumber'] : ''; ?>" id="accountnumber">
                                <span class="accountnumber_error"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                  <?php echo (!empty($user_language[$user_selected]['lg_Payment_Mode'])) ? $user_language[$user_selected]['lg_Payment_Mode'] : $default_language['en']['lg_Payment_Mode']; ?>
                                </label>
                                <select class="form-control" name="mode" id="payment_mode">
                                    <option value="">Select Payment Mode</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="IMPS">IMPS</option>
                                    <option value="UPI">UPI</option>
                                </select>
                                <span class="payment_mode_error"></span>
                            </div>
                            <div class="form-group">
                                <label>
                                   <?php echo (!empty($user_language[$user_selected]['lg_Payment_Purpose'])) ? $user_language[$user_selected]['lg_Payment_Purpose'] : $default_language['en']['lg_Payment_Purpose']; ?>
                                </label>
                                <select class="form-control" name="purpose">
									<option value=""><?php echo (!empty($user_language[$user_selected]['lg_Select_Payment_Purpose'])) ? $user_language[$user_selected]['lg_Select_Payment_Purpose'] : $default_language['en']['lg_Select_Payment_Purpose']; ?></option>
                                    <option value="refund"><?php echo (!empty($user_language[$user_selected]['lg_refund'])) ? $user_language[$user_selected]['lg_refund'] : $default_language['en']['lg_refund']; ?></option>
                                    <option value="cashback"><?php echo (!empty($user_language[$user_selected]['lg_cashback'])) ? $user_language[$user_selected]['lg_cashback'] : $default_language['en']['lg_cashback']; ?></option>
                                    <option value="payout" selected=""><?php echo (!empty($user_language[$user_selected]['lg_payout'])) ? $user_language[$user_selected]['lg_payout'] : $default_language['en']['lg_payout']; ?></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="amount" id="stripe_amount">
                        <input type="hidden" name="payment_type" id="payment_types">
                        <button type="submit" class="btn btn-primary btn-block withdraw-btn1"><?php echo (!empty($user_language[$user_selected]['lg_Save_Changes'])) ? $user_language[$user_selected]['lg_Save_Changes'] : $default_language['en']['lg_Save_Changes']; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

