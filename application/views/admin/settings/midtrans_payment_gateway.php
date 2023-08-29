<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Payment Settings</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
		
		<ul class="nav nav-tabs menu-tabs">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/stripe_payment_gateway'; ?>">Stripe</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/razorpay_payment_gateway'; ?>">Razorpay </a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paypal_payment_gateway'; ?>">PayPal</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paystack_payment_gateway'; ?>">Paystack</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paysolution_payment_gateway'; ?>">Paysolution</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url() . 'admin/midtrans_payment_gateway'; ?>">Midtrans</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/midtrans_payout_gateway'; ?>">Midtrans Payout</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/cod_payment_gateway'; ?>">COD</a>
			</li>
		</ul>

        <div class="row">
            <div class="col-lg-8">
				<form action="<?php echo base_url() . 'admin/midtrans_payment_gateway'; ?>" method="post">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title">Midtrans</h4>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="midtrans_show" type="checkbox"  value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
                            <div class="form-group">
                                <label>Midtrans Option</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input midtrans_payment" id="sandbox" name="gateway_type" value="sandbox" type="radio" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="sandbox">Sandbox</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input midtrans_payment" id="livepaypal" name="gateway_type" value="live" type="radio"  <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="livepaypal">Live</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gateway Name</label>
                                <input  type="text" id="midtrans_gateway_name" name="midtrans_gateway_name"  value="<?php if (!empty($list['gateway_name'])) {echo $list['gateway_name'];} ?>" required class="form-control" placeholder="Gateway Name">
                            </div>
                            <div class="form-group">
                                <label>Client Key</label>
                                <input type="text" id="client_key" name="client_key" value="<?php if (!empty($list['client_key'])) {echo $list['client_key'];} ?>" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Server Key</label>
                                <input type="text" id="server_key" name="server_key" value="<?php if (!empty($list['serverkey_key'])) {echo $list['serverkey_key'];} ?>" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Merchant ID</label>
                                <input type="text" id="merchant_id" name="merchant_id" value="<?php if (!empty($list['merchant_id'])) {echo $list['merchant_id'];} ?>" required class="form-control">
                            </div>
                            <div class="mt-4">
								<?php if ($user_role == 1) { ?>
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<?php } ?>
                                <a href="<?php echo base_url() . 'admin/stripe_payment_gateway' ?>" class="btn btn-cancel m-l-5">Cancel</a>
                            </div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
