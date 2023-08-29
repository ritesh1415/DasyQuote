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
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paystack_payment_gateway'; ?>">Paystack</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paysolution_payment_gateway'; ?>">Paysolution</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url() . 'admin/cod_payment_gateway'; ?>">COD</a>
			</li>
		</ul>

        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<h4 class="card-title">COD</h4>
					</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="row mb-4">
								<div class="col">
									<h6 class="card-title mb-0">Cash On Delivery</h6>
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="cod_show" type="checkbox"  value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
							<div class="mt-4">
								<?php if ($user_role == 1) { ?>
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<?php } ?>
								<a href="<?php echo base_url() . 'admin/cod_payment_gateway' ?>" class="btn btn-cancel m-l-5">Cancel</a>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
