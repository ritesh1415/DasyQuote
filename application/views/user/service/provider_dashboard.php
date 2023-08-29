<?php 
$booking_count = $this->service->booking_count($this->session->userdata('id'));
$services_count = $this->service->services_count($this->session->userdata('id'));
$my_subscribe = $this->home->get_my_subscription(); 
if(!empty($my_subscribe)){
	$subscription_name=$this->db->where('id',$my_subscribe['subscription_id'])->get('subscription_fee')->row_array();
}else{
	$subscription_name['subscription_name']='';
}
?>
<div class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('user/home/provider_sidemenu');?>
			
			<div class="col-xl-9 col-md-8">
				<h4 class="widget-title"><?php echo (!empty($user_language[$user_selected]['lg_Dashboard'])) ? $user_language[$user_selected]['lg_Dashboard'] : $default_language['en']['lg_Dashboard']; ?></h4>
				<div class="row">
					<div class="col-lg-4">
						<a href="<?php echo base_url()?>provider-bookings" class="dash-widget dash-bg-1">
							<span class="dash-widget-icon"><?php echo $booking_count?></span>
							<div class="dash-widget-info">
								<span><?php echo (!empty($user_language[$user_selected]['lg_Bookings'])) ? $user_language[$user_selected]['lg_Bookings'] : $default_language['en']['lg_Bookings']; ?></span>
							</div>
						</a>
					</div>
					<div class="col-lg-4">
						<a href="<?php echo base_url()?>my-services" class="dash-widget dash-bg-2">
							<span class="dash-widget-icon"><?php echo $services_count?></span>
							<div class="dash-widget-info">
								<span><?php echo (!empty($user_language[$user_selected]['lg_Services'])) ? $user_language[$user_selected]['lg_Services'] : $default_language['en']['lg_Services']; ?></span>
							</div>
						</a>
					</div>
					<?php
					if(!empty($this->session->userdata('chat_token'))){
						$ses_token=$this->session->userdata('chat_token');
					}else{
						$ses_token='';
					}
  
					if(!empty($ses_token)){

						$ret=$this->db->select('*')->
						from('notification_table')->
						where('receiver',$ses_token)->
						where('status',1)->
						order_by('notification_id','DESC')->
						get()->result_array();
						
						$notification=[];
						if(!empty($ret)){ 
							foreach ($ret as $key => $value) {
								$user_table=$this->db->select('id,name,profile_img,token,type')->
								from('users')->
								where('token',$value['sender'])->
								get()->row();
								$provider_table=$this->db->select('id,name,profile_img,token,type')->
								from('providers')->
								where('token',$value['sender'])->
								get()->row();
								if(!empty($user_table)){
									$user_info= $user_table;
								}else{
									$user_info= $provider_table;
								}  
								$notification[$key]['name']= !empty($user_info->name)?$user_info->name:'';
								$notification[$key]['message']= !empty($value['message'])?$value['message']:'';
								$notification[$key]['profile_img']= !empty($user_info->profile_img)?$user_info->profile_img:'';
								$notification[$key]['utc_date_time']= !empty($value['utc_date_time'])?$value['utc_date_time']:'';
							}
						}
						$n_count=count($notification);
					}else{
						$n_count=0;
						$notification=[];
					}
					?>
					<div class="col-lg-4">
						<a href="notification-list" class="dash-widget dash-bg-3">
							<span class="dash-widget-icon"><?=$n_count;?></span>
							<div class="dash-widget-info">
								<span><?php echo (!empty($user_language[$user_selected]['lg_Notifications'])) ? $user_language[$user_selected]['lg_Notifications'] : $default_language['en']['lg_Notifications']; ?></span>
							</div>
						</a>
					</div>
				</div>
				<?php if(empty($my_subscribe)){?>
				<div class="card mb-0">
					<div class="row no-gutters">
						<div class="col-lg-8">
							<div class="card-body">
								<h6 class="title"><?php echo (!empty($user_language[$user_selected]['lg_Plan_Details'])) ? $user_language[$user_selected]['lg_Plan_Details'] : $default_language['en']['lg_Plan_Details']; ?></h6>
								<div class="sp-plan-name">
									<h6 class="title">
										<?php if(!empty($subscription_name['subscription_name'])){ ?>
										<?php echo $subscription_name['subscription_name'];?> <span class="badge badge-success badge-pill">Active</span>
									<?php }else{?>
										<?php echo (!empty($user_language[$user_selected]['lg_Eterprice_Plan'])) ? $user_language[$user_selected]['lg_Eterprice_Plan'] : $default_language['en']['lg_Eterprice_Plan']; ?> <span class="badge badge-success badge-pill"><?php echo (!empty($user_language[$user_selected]['lg_Expired'])) ? $user_language[$user_selected]['lg_Expired'] : $default_language['en']['lg_Expired']; ?></span>
									<?php }?>
									</h6>
									<p><?php echo (!empty($user_language[$user_selected]['lg_Subscription_ID'])) ? $user_language[$user_selected]['lg_Subscription_ID'] : $default_language['en']['lg_Subscription_ID']; ?>: <span class="text-base">100394949</span></p>
								</div>
								<ul class="row">
									<li class="col-6 col-lg-6">
										<p><?php echo (!empty($user_language[$user_selected]['lg_Started_On'])) ? $user_language[$user_selected]['lg_Started_On'] : $default_language['en']['lg_Started_On']; ?> <?php if(!empty($my_subscribe['subscription_date'])){echo date('d M, Y',strtotime($my_subscribe['subscription_date']));}?></p>
									</li>
									<?php  $user_currency = get_provider_currency();
										   $user_currency_code = $user_currency['user_currency_code'];                          
						        	?>
						 			<li class="col-6 col-lg-6">
										<p><?php echo (!empty($user_language[$user_selected]['lg_Price'])) ? $user_language[$user_selected]['lg_Price'] : $default_language['en']['lg_Price']; ?> <?php if(!empty($subscription_name['fee'])){ echo currency_conversion($user_currency_code) . get_gigs_currency($subscription_name['fee'], $subscription_name['currency_code'], $user_currency_code); }
													?></p>
									</li>
								</ul>
								<h6 class="title"><?php echo (!empty($user_language[$user_selected]['lg_Last_Payment'])) ? $user_language[$user_selected]['lg_Last_Payment'] : $default_language['en']['lg_Last_Payment']; ?></h6>
								<ul class="row">
									<li class="col-sm-6">
										<p><?php echo (!empty($user_language[$user_selected]['lg_Paid_at'])) ? $user_language[$user_selected]['lg_Paid_at'] : $default_language['en']['lg_Paid_at']; ?> <?php if(!empty($my_subscribe['subscription_date'])){echo date('d M Y',strtotime($my_subscribe['subscription_date'])); }?></p>
									</li>
									<li class="col-sm-6">
										<p><span class="text-success"><?php echo (!empty($user_language[$user_selected]['lg_Paid'])) ? $user_language[$user_selected]['lg_Paid'] : $default_language['en']['lg_Paid']; ?></span> <span class="amount"><?php if(!empty($subscription_name['fee'])){ echo currency_conversion($user_currency_code) . get_gigs_currency($subscription_name['fee'], $subscription_name['currency_code'], $user_currency_code);}?></span></p>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="sp-plan-action card-body">
								<div class="mb-2">
									<a href="<?php echo base_url().'provider-subscription'?>" class="btn btn-primary"><span><?php echo (!empty($user_language[$user_selected]['lg_Change_Plan'])) ? $user_language[$user_selected]['lg_Change_Plan'] : $default_language['en']['lg_Change_Plan']; ?></span></a>
								</div>
								<div class="next-billing">
									<p><?php echo (!empty($user_language[$user_selected]['lg_Next_Billing_on'])) ? $user_language[$user_selected]['lg_Next_Billing_on'] : $default_language['en']['lg_Next_Billing_on']; ?> <span><?php if(!empty($my_subscribe['subscription_date'])){ echo date('d M, Y',strtotime($my_subscribe['expiry_date_time']));}?></span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php }?>
			</div>
        </div>
    </div>
</div>