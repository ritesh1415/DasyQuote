<?php
    $page = $this->uri->segment(1);
    $active =$this->uri->segment(2);
	$access_result_data_array = $this->session->userdata('access_module');	
	$admin_id=$this->session->userdata('admin_id');
 ?>
 <div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo $base_url; ?>dashboard">
			<img src="<?php echo $base_url.settingValue('header_icon'); ?>" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="<?php echo ($page == 'dashboard')?'active':'';?>">
					<a href="<?php echo $base_url; ?>dashboard"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
				</li>

				
				<?php if(in_array(1,$access_result_data_array) || in_array(13,$access_result_data_array) || in_array(12,$access_result_data_array)) { ?>
				<li class="submenu <?php echo ($page == 'adminusers')?'active':''; echo ($page == 'edit_adminuser')?'active':''; echo ($page == 'adminuser_details')?'active':''; echo ($page == 'users')?'active':''; echo ($page == 'service-providers')?'active':''; echo ($page == 'user-details')?'active':''; echo ($page == 'provider-details')?'active':'';?>">
					<a href="#">
						<i class="fas fa-users"></i> <span>User Settings </span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
					</a>
					<ul>
					    <?php
						if(in_array(1,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'adminusers')?'active':''; echo ($page == 'edit_adminuser')?'active':''; echo ($page == 'adminuser_details')?'active':'';?>" href="<?php echo $base_url; ?>adminusers"><span>Admin</span></a>
						</li>
						<?php
						} if(in_array(13,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'users')?'active':'';echo ($page == 'user-details')?'active':'';?>" href="<?php echo $base_url; ?>users"> <span>Users</span></a>
						</li>
						<?php
						} if(in_array(12,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'service-providers')?'active':''; echo ($page == 'provider-details')?'active':''; ?>" href="<?php echo $base_url; ?>service-providers"> <span> Professionals</span></a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>

				<?php if(in_array(4,$access_result_data_array)) { ?>
				<li class="<?php echo ($page == 'service-list' || $page == 'service-details') ? 'active':'';?>">
					<a href="<?php echo $base_url; ?>service-list">
						<i class="fas fa-bullhorn"></i> <span> Services</span>
					</a>
				</li>
				<?php } ?>
				
				<?php if(in_array(2,$access_result_data_array) || in_array(3,$access_result_data_array)) { ?>
				<li class="submenu <?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category' || $page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory') ? 'active':'';?>">
					<a href="#">
						<i class="fas fa-layer-group"></i> <span>Categories</span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
					</a>
					<ul>
						<?php
						if(in_array(2,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category') ? 'active':'';?>" href="<?php echo $base_url; ?>categories"> <span>Categories</span></a>
						</li>
						<?php
						} if(in_array(3,$access_result_data_array)) {
						?>
						<li>
							<a class="<?php echo ($page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory') ? 'active':'';?>" href="<?php echo $base_url; ?>subcategories"> <span>Sub Categories</span></a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php } ?>
				
				
				
				<?php } if (in_array(27, $access_result_data_array) || in_array(28,$access_result_data_array) || in_array(29,$access_result_data_array) ) { ?>
                <li class="submenuu <?php echo ($active == 'chat' || $page == 'provider-chat' || $page == 'client-chat') ? 'active' : ''; ?>">
                 <a  href="<?php echo $base_url; ?>admin/chat"><i class="far fa-comments"></i> <span>Chat</span></a> 
                </li>

				<?php } if (in_array(27, $access_result_data_array) || in_array(28,$access_result_data_array) || in_array(29,$access_result_data_array) ) { ?>
                <li class="<?php echo ($active == 'all-quotes'||$active =='all-quotes'||$active  == 'quote-response'||$active == 'quote-waiting'||$active == 'quote-decline'||$active == 'quote-inProgress' ||$page == 'all_quotes/view_quote'||$page == 'admin/all-quotes') ? 'active' : ''; ?>">
                 <a  href="<?php echo $base_url; ?>admin/all-quotes"><i class="fa fa-list"></i> <span>Quote</span></a> 
				</li>
				<?php  ?>
				
                <?php } if(in_array(5,$access_result_data_array)) { ?>
				<li class="<?php echo ($active =='total-report' || $active =='pending-report' || $active == 'inprogress-report' || $active == 'complete-report' || $active == 'reject-report' || $active == 'cancel-report' ||$page == 'reject-payment')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/total-report"><i class="far fa-calendar-check"></i> <span> Booking List</span></a>
				</li>
				<?php } ?>

				

				<!-- <?php if(in_array(5,$access_result_data_array)) { ?>
				<li class="<?php echo ($active =='total-report')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/total-report"><i class="far fa-calendar-check"></i> <span> Quote List</span></a>
				</li>
				<?php } ?> -->
				
				
				<?php if(in_array(9,$access_result_data_array) || in_array(6,$access_result_data_array) || in_array(10,$access_result_data_array) || in_array(11,$access_result_data_array)|| in_array(18,$access_result_data_array)) { ?>
					<li class="submenu <?php echo ($page == 'payment_list' || $page == 'payment_details' || $page == 'admin-payment' || $page == 'withdraw_list' || $page == 'view_withdraw' || $page == 'subscriptions' || $page == 'add-subscription' || $page == 'edit-subscription' || $active =='wallet' || $active =='wallet-history')? 'active':''; echo ($page == 'Revenue')?'active':''; echo ($active == 'cod')?'active':'';?>">
					<a href="#">
						<i class="far fa-money-bill-alt"></i> <span>Accounting </span>
					</a>
					<ul>
						<?php if(in_array(9,$access_result_data_array)) { ?>				
				<li>
					<a href="<?php echo $base_url; ?>subscriptions" class="<?php echo ($page == 'subscriptions')?'active':''; echo ($page == 'add-subscription')?'active':''; echo ($page == 'edit-subscription')?'active':'';?>"> <span>Subscriptions</span></a>
				</li>
				<?php } if(in_array(6,$access_result_data_array)) {?>
					<li>
						<a href="<?php echo $base_url; ?>payment_list" class="<?php echo ($page == 'payment_list')?'active':''; echo ($page == 'admin-payment')?'active':'';?>"><span>Payments</span></a>
					</li>
				<?php
				} if(in_array(10,$access_result_data_array)) { 
				?>
					<li>
						 <a href="<?php echo $base_url; ?>admin/wallet" class="<?php echo ($active =='wallet' || $active =='wallet-history')? 'active':''; ?>"><span> Wallet</span></a>
					</li>
				<?php
				} if(in_array(11,$access_result_data_array)) {
				?>
					<li>
						<a class="<?php echo ($page == 'Revenue') ? 'active':'';?>"  href="<?php echo $base_url; ?>Revenue"> <span>Revenue</span></a>
					</li>
				<?php
				} if(in_array(18,$access_result_data_array)) {
				?>
					<li>
						<a class="<?php echo ($active == 'cod') ? 'active':'';?>"  href="<?php echo $base_url; ?>admin/cod"> <span>COD</span></a>
					</li>
				<?php
				}
                ?>				
					</ul>
				</li>
				<?php } ?>
				<?php if(in_array(17,$access_result_data_array)) { ?>
				<li class="<?php echo ($active == 'contact' || $page == 'contact-details')?'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/contact"><i class="fas fa-paper-plane"></i> <span> Contact Messages</span></a>
				</li>
				<?php } ?>
				<!--<?php if(in_array(7,$access_result_data_array) || in_array(8,$access_result_data_array)) { ?>
				<li class="submenu <?php echo ($active == 'ratingstype' || $page == 'add-ratingstype' || $page == 'edit-ratingstype' || $page == 'review-reports' || $page == 'add-review-reports' || $page == 'edit-review-reports' || $page == 'view_review') ? 'active':'';?>">
					<a href="#">
						<i class="fas fa-star-half-alt"></i> <span>Ratings </span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
					<ul>						

				<?php if(in_array(7,$access_result_data_array)) { ?>
				<li>
					 <a href="<?php echo $base_url; ?>ratingstype" class="<?php echo ($page == 'ratingstype')?'active':''; echo ($page == 'add-ratingstype')?'active':''; echo ($page == 'edit-ratingstype')?'active':'';?>"><span>Rating Type</span></a>
				</li> 
				<?php }if(in_array(8,$access_result_data_array)) { ?>
				<li>
					 <a href="<?php echo $base_url; ?>review-reports" class="<?php echo ($page == 'review-reports')?'active':''; echo ($page == 'add-review-reports')?'active':''; echo ($page == 'edit-review-reports')?'active':'';?>"><span>Ratings</span></a>
				</li>
				<?php } ?>	
					</ul>
				</li>-->
				<?php } if(in_array(20,$access_result_data_array)) { ?>
				<li class="<?php echo ($active == 'emailtemplate' || $active =='edit-emailtemplate')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/emailtemplate"><i class="fas fa-envelope"></i> <span> Email Templates</span></a>
				</li>
				<?php } if(in_array(19,$access_result_data_array)) { ?>	
				<!--<li class="<?php echo ($active == 'SendPushNotificationList' || $active =='SendPushNotification')? 'active':''; ?>">
					<a href="<?php echo $base_url; ?>admin/SendPushNotificationList"><i class="fa fa-bell"></i> <span> Push Notifications</span></a>
				</li>-->
				<?php } ?>
				<?php if(in_array(14,$access_result_data_array) || in_array(15,$access_result_data_array) || in_array(16,$access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'settings' || $active =='emailsettings' || $active =='stripe_payment_gateway' || $active =='sms-settings' || $active =='theme-color' || $active == 'cancellation-amount-settings' || $page == 'language' || $page == 'add-language' || $page == 'wep_language' || $page == 'add-app-keyword' || $page == 'app_page_list' || $active == 'country_code_config' || $page == 'district' || $page == 'taluk' || $page == 'area' || $page == 'cod') ? 'active':''; ?>">
					<a href="#">
						<i class="fas fa-cog"></i> <span>Settings </span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
					</a>
					<ul>
						<?php if(in_array(27,$access_result_data_array)) { ?>
							<li >
								<a href="<?php echo $base_url; ?>admin/general-settings" class="<?php echo ($active == 'general-settings')? 'active':''; ?>"> <span> General Settings</span></a>
							</li> 
						<?php } ?>
					<?php if(in_array(42,$access_result_data_array)) { ?>
						<li>
							<a class="<?php echo ($active == 'system-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/system-settings"> <span>System Settings</span></a>
						</li>
					<?php } ?>
					<?php if(in_array(28,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'localization')?'active':'';?>" href="<?php echo $base_url; ?>admin/localization"> <span>Localization</span></a>
					</li>
				<?php } if(in_array(29,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'social-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/social-settings"> <span>Login Settings</span></a>
					</li>
				<?php } if(in_array(30,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'emailsettings')?'active':'';?>" href="<?php echo $base_url; ?>admin/emailsettings"> <span>Email Settings</span></a>
					</li>
				<?php } if(in_array(31,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'stripe_payment_gateway' || $active == 'razorpay_payment_gateway' || $active == 'paypal_payment_gateway' || $active == 'paystack_payment_gateway' || $active == 'paysolution_payment_gateway' || $active == 'cod_payment_gateway')?'active':'';?>" href="<?php echo $base_url; ?>admin/stripe_payment_gateway"> <span>Payment Settings</span></a>
					</li>
				<?php } if(in_array(32,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'seo-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/seo-settings"> <span>SEO Settings</span></a>
					</li>
				<?php } if(in_array(33,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'sms-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/sms-settings"> <span>SMS Settings</span></a>
					</li>
				<?php } if(in_array(34,$access_result_data_array)) { ?>
					<li>
						<a class="<?php echo ($active == 'theme-color')?'active':'';?>" href="<?php echo $base_url; ?>admin/theme-color"> <span>Theme Settings</span></a>
					</li>
				<?php } if(in_array(35,$access_result_data_array)) { ?>
						<li>
							<a href="<?php echo $base_url; ?>languages" class="<?php echo ($page == 'languages' || $page == 'wep_language' || $page == 'app_page_list' || $page == 'add-app-keyword' || $page == 'add-language')?'active':'';?>"> <span>Language</span></a>
						</li>

						<?php } if(in_array(36,$access_result_data_array)) { ?>
						<li>
							<a href="<?php echo $base_url; ?>admin/country_code_config" class="<?php echo ($active == 'country_code_config')?'active':'';?>"> <span>Country Code</span></a>
						</li>	
						<?php } if(in_array(360,$access_result_data_array)) { ?>						
						<li class="d-none">
							<a class="<?php echo ($page == 'cod')? 'active':''; ?>" href="<?php echo $base_url; ?>admin/cod"> <span> COD</span></a>
						</li>
						<?php } if(in_array(37,$access_result_data_array)) { ?>		
						<li>
							<a class="<?php echo ($active == 'other-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/other-settings"> <span>Other Settings</span></a>
						</li>
						<?php } if(in_array(38,$access_result_data_array)) { ?>		 
						<li>
							<a class="<?php echo ($active == 'chat-settings')?'active':'';?>" href="<?php echo $base_url; ?>admin/chat-settings"> <span>Chat Settings</span></a>
						</li>
						<?php } ?>
					</ul>
				</li>

				<?php if(in_array(39,$access_result_data_array) || in_array(40,$access_result_data_array) || in_array(41,$access_result_data_array)) { ?>
					<li class="submenu">
						<a href="#"><i class="fas fa-cog"></i> <span> Frontend Settings</span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
						<ul>
							<?php } if(in_array(39,$access_result_data_array)) { ?>		
							<li>
								<a class="<?php echo ($active == 'frontend-settings')?'active':'';?>"  href="<?php echo $base_url; ?>admin/frontend-settings" > <span> Header Settings</span></a>
							</li> 
							<?php } if(in_array(40,$access_result_data_array)) { ?>		
							<li>
								<a class="<?php echo ($active == 'footer-settings')?'active':'';?>"  href="<?php echo $base_url; ?>admin/footer-settings" > <span>Footer Settings</span></a>
							</li>
							<?php } if(in_array(41,$access_result_data_array)) { ?>		
							<li>
								<a class="<?php echo ($active == 'pages' || $active == 'home-page'|| $active == 'about-us'|| $active == 'cookie-policy'|| $active == 'faq'|| $active == 'help'|| $active == 'privacy-policy'|| $active == 'terms-service')?'active':'';?>"  href="<?php echo $base_url; ?>admin/pages"> <span>Pages </span></a>
							</li>
							<?php } ?>			
						</ul>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>