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
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/stripe_payment_gateway'; ?>">Stripe</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/razorpay_payment_gateway'; ?>">Razorpay </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paypal_payment_gateway'; ?>">PayPal</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paystack_payment_gateway'; ?>">Paystack</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paysolution_payment_gateway'; ?>">Paysolution</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/cod_payment_gateway'; ?>">COD</a>
			</li>
		</ul>

        <div class="row">
            <div class="col-lg-8">
				<form action="<?php echo base_url() . 'admin/settings/paystack_edit/' . $list['id']; ?>" method="post">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title">Paystack</h4>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="paystack_show" type="checkbox" value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Paystack Gateway</label>
								<div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paystack_payment" id="paystack_sandbox" type="radio" required="" name="gateway_type" value="sandbox" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?>>
										<label class="custom-control-label" for="paystack_sandbox">Sandbox</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paystack_payment" id="live_paystack" type="radio" required="" name="gateway_type" value="live" <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?>>
									<label class="custom-control-label" for="live_paystack">Live</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Gateway Name</label>
								<input class="form-control" type="text" name="gateway_name" id="gateway_name" value="<?php if (!empty($list['gateway_name'])) { echo $list['gateway_name']; } ?>" >
							</div>
							<div class="form-group">
								<label>API key</label>
								<input class="form-control" type="text" name="api_key" id="api_key" value="<?php if (!empty($list['api_key'])) { echo $list['api_key']; } ?>" >
							</div>
							<div class="form-group">
								<label>Secret key</label>
								<input class="form-control" type="text" name="value" id="value" value="<?php if (!empty($list['value'])) { echo $list['value']; } ?>" >
							</div>
                            <div class="mt-4">
								<?php if ($user_role == 1) { ?>
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<?php } ?>
                                <a href="<?php echo base_url() . 'admin/paystack_payment_gateway' ?>" class="btn btn-cancel m-l-5">Cancel</a>
                            </div>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
