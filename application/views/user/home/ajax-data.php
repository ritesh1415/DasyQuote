
				<?php 

				if(!empty($all_bookings)) {
				foreach ($all_bookings as $bookings) { 
				$this->db->select("service_image");
				$this->db->from('services_image');
				$this->db->where("service_id",$bookings['service_id']);
				$this->db->where("status",1);
				$image = $this->db->get()->result_array();
				$serv_image = array();
				foreach ($image as $key => $i) {
				  $serv_image[] = $i['service_image'];
				}
				$placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
				if (file_exists($serv_image[0])) {
					$serviceimage = base_url() . $serv_image[0];
				} else {
					$serviceimage = ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';
				}
				?>
								 
				<div class="bookings">
					<div class="booking-list">
						<div class="booking-widget">
							<a href="<?php echo base_url().'service-preview/'.$bookings['service_id'].'?sid='.md5($bookings['service_id']);?>" class="booking-img">
								<img src="<?php echo $serviceimage?>" alt="User Image">
							</a>
							<div class="booking-det-info">

								<?php
								$badge='';
								$class='';
								if ($bookings['status'] == 1) {
									$badge = (!empty($user_language[$user_selected]['lg_Pending'])) ? $user_language[$user_selected]['lg_Pending'] : $default_language['en']['lg_Pending'];
									$class = 'bg-warning';
								}
								if ($bookings['status'] == 2) {
									$badge = (!empty($user_language[$user_selected]['lg_Inprogress'])) ? $user_language[$user_selected]['lg_Inprogress'] : $default_language['en']['lg_Inprogress'];
									$class = 'bg-primary';
								}
								if ($bookings['status'] == 3) {
									$badge = (!empty($user_language[$user_selected]['lg_complete_req_sent_provider'])) ? $user_language[$user_selected]['lg_complete_req_sent_provider'] : $default_language['en']['lg_complete_req_sent_provider'];
									$class = 'bg-success';
								}
								if ($bookings['status'] == 4) {
									$badge = (!empty($user_language[$user_selected]['lg_Accepted'])) ? $user_language[$user_selected]['lg_Accepted'] : $default_language['en']['lg_Accepted'];
									$class = 'bg-success';
								}
								if ($bookings['status'] == 5) {
									$badge = (!empty($user_language[$user_selected]['lg_rejected_by_user'])) ? $user_language[$user_selected]['lg_rejected_by_user'] : $default_language['en']['lg_rejected_by_user'];
									$class = 'bg-danger';
								}
								if ($bookings['status'] == 6) {
									$badge = (!empty($user_language[$user_selected]['lg_completed_accepted'])) ? $user_language[$user_selected]['lg_completed_accepted'] : $default_language['en']['lg_completed_accepted'];
									$class = 'bg-success';
								}
								if ($bookings['status'] == 7) {
									$badge = (!empty($user_language[$user_selected]['lg_cancelled_provider'])) ? $user_language[$user_selected]['lg_cancelled_provider'] : $default_language['en']['lg_cancelled_provider'];
									$class = 'bg-danger';
								}
								if($bookings['admin_change_status'] == 1) {
									$by_admin = (!empty($user_language[$user_selected]['lg_by_admin'])) ? $user_language[$user_selected]['lg_by_admin'] : $default_language['en']['lg_by_admin'];
									$badge = $badge.' '.$by_admin;
								}
								?>
								<h3>
									<a href="<?php echo base_url().'service-preview/'.$bookings['service_id'].'?sid='.md5($bookings['service_id']);?>">
										<?php echo $bookings['service_title']?>
									</a>
								</h3>
								<?php
								if(!empty($bookings['user_id'])){
								$user_info=$this->db->select('*')->
								from('users')->
								where('id',(int)$bookings['user_id'])->
								get()->row_array();
								}
								   
								if(file_exists($user_info['profile_img'])){
									$image=base_url().$user_info['profile_img'];
								}else{
									$image=base_url().'assets/img/user.jpg';
								}
								$user_currency_code = '';
								$userId = $this->session->userdata('id');
								If (!empty($userId)) {
									$service_amount = $bookings['amount'];
									$type = $this->session->userdata('usertype');
									if ($type == 'user') {
										$user_currency = get_user_currency();
									} else if ($type == 'provider') {
										$user_currency = get_provider_currency();
									}
									$user_currency_code = $user_currency['user_currency_code'];

									$service_amount = get_gigs_currency($bookings['amount'], $bookings['currency_code'], $user_currency_code);
								} else {
									$user_currency_code = settings('currency');
									$service_amount = $bookings['amount'];
								}
								if (is_nan($service_amount) || is_infinite($service_amount)) {
									$service_amount = $bookings['amount'];
								}
								?>
								<ul class="booking-details">
									<li>
										 <?php if(!empty($bookings['service_date'])){
	                                         $date=date(settingValue('date_format'), strtotime($bookings['service_date']));
	                                     }else{
	                                            $date='-';                                
	                                     } ?>

										<span><?php echo (!empty($user_language[$user_selected]['lg_Booking_Date'])) ? $user_language[$user_selected]['lg_Booking_Date'] : $default_language['en']['lg_Booking_Date']; ?></span> <?=$date; ?> 
										<span class='badge badge-pill badge-prof <?php echo $class; ?>'><?= $badge; ?></span>
									</li>
									<li>
										 <?php  
                                            if(settingValue('time_format') == '12 Hours') {
                                                $from_time = date('h:ia', strtotime($bookings['from_time']));
                                                $to_time = date('h:ia', strtotime($bookings['to_time']));
                                            } elseif(settingValue('time_format') == '24 Hours') {
                                               $from_time = date('H:i:s', strtotime($bookings['from_time']));
                                               $to_time = date('H:i:s', strtotime($bookings['to_time']));
                                            } else {
                                                $from_time = date('G:ia', strtotime($bookings['from_time']));
                                                $to_time = date('G:ia', strtotime($bookings['to_time']));
                                            }
                                         ?>

										<span><?php echo (!empty($user_language[$user_selected]['lg_Booking_time'])) ? $user_language[$user_selected]['lg_Booking_time'] : $default_language['en']['lg_Booking_time']; ?></span> <?= $from_time ?> - <?= $to_time ?></li>
									<li><span><?php echo (!empty($user_language[$user_selected]['lg_Amount'])) ? $user_language[$user_selected]['lg_Amount'] : $default_language['en']['lg_Amount']; ?></span> <?php echo currency_conversion($user_currency_code) . $service_amount; ?></li>
									<li><span><?php echo (!empty($user_language[$user_selected]['lg_Location'])) ? $user_language[$user_selected]['lg_Location'] : $default_language['en']['lg_Location']; ?></span> <?php echo $bookings['location'] ?></li>
									<li><span><?php echo (!empty($user_language[$user_selected]['lg_Phone'])) ? $user_language[$user_selected]['lg_Phone'] : $default_language['en']['lg_Phone']; ?></span> <?php echo $user_info['mobileno'] ?></li>
									<li>
										<span><?php echo (!empty($user_language[$user_selected]['lg_User'])) ? $user_language[$user_selected]['lg_User'] : $default_language['en']['lg_User']; ?></span>
										<div class="avatar avatar-xs mr-1">
											<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo $image; ?>">
										</div> <?= !empty($user_info['name']) ? $user_info['name'] : '-'; ?>
										
										 <!-- block user/provider -->
                                                    <?php
                                                        $this->db->select('id,blocked_id,blocked_by_id,status');
                                                        $this->db->where('blocked_by_id', $this->session->userdata('id'));
                                                        $this->db->where('blocked_id', $bookings['user_id']);
                                                        $this->db->from('block_user_provider');
                                                        $blocked_user = $this->db->get()->row_array();

                                                        if($blocked_user['status'] == "1") {
                                                            $blk_class = "bg-danger";
                                                            $blk_text = (!empty($user_language[$user_selected]['lg_blocked'])) ? $user_language[$user_selected]['lg_blocked'] : $default_language['en']['lg_blocked'];
                                                        }else if($blocked_user['status'] == "2") {
                                                            $blk_class = "bg-info";
                                                            $blk_text = (!empty($user_language[$user_selected]['lg_request_to_report_user'])) ? $user_language[$user_selected]['lg_request_to_report_user'] : $default_language['en']['lg_request_to_report_user']; 
                                                        }
                                                        else{
                                                            $blk_class = "bg-danger";
                                                            $blk_text = (!empty($user_language[$user_selected]['lg_report_user'])) ? $user_language[$user_selected]['lg_report_user'] : $default_language['en']['lg_report_user'];
                                                        }

                                                        $userId = $this->session->userdata('id');
                                                        if($this->session->userdata('usertype') == "provider") { 
                                                            if($userId && ($userId == $blocked_user['blocked_by_id']) && ($bookings['user_id'] == $blocked_user['blocked_id']) ) {
                                                                if($blocked_user['status'] == 1) { ?>
                                                                    <span class='badge badge-pill badge-prof <?php echo $blk_class; ?>'><?= $blk_text; ?></span>
                                                                <?php } else if($blocked_user['status'] == 2) { ?>
                                                                    <span class='badge badge-pill badge-prof <?php echo $blk_class; ?>'><?= $blk_text; ?></span>
                                                                <?php }
                                                            }
                                                        }
                                                    ?>
										
										
									</li>
								</ul>
							</div>
						</div>
					
						<div class="booking-action">
							
							<?php if ($bookings['status']==2) {$pending=0;?>
								<a href="<?php echo base_url()?>user-chat/booking-new-chat?book_id=<?php echo $bookings['id']?>" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> <?php echo (!empty($user_language[$user_selected]['lg_chat'])) ? $user_language[$user_selected]['lg_chat'] : $default_language['en']['lg_chat']; ?>
								</a> 
								<a href="javascript:;" class="btn btn-sm bg-danger-light myCancel" data-toggle="modal" data-target="#myCancel" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 	
											<i class="fas fa-times"></i> <?php echo (!empty($user_language[$user_selected]['lg_cancel_service'])) ? $user_language[$user_selected]['lg_cancel_service'] : $default_language['en']['lg_cancel_service']; ?>
										</a>	
								
								<a href="javascript:;" class="btn btn-sm bg-success-light update_pro_booking_status"  data-id="<?=$bookings['id'];?>" data-status="3" data-rowid="<?=$pending;?>" data-review="2">
									<i class="fas fa-check"></i> <?php echo (!empty($user_language[$user_selected]['lg_complete_res_user'])) ? $user_language[$user_selected]['lg_complete_res_user'] : $default_language['en']['lg_complete_res_user']; ?>
								</a>
								<?php }elseif($bookings['status']==1){ 
									$pending=$bookings['status'];?>
									<a href="javascript:;" class="btn btn-sm bg-success-light update_pro_booking_status"  data-id="<?=$bookings['id'];?>" data-status="2" data-rowid="<?=$pending;?>" data-review="2" >
									<i class="fas fa-check"></i> <?php echo (!empty($user_language[$user_selected]['lg_user_res_accept'])) ? $user_language[$user_selected]['lg_user_res_accept'] : $default_language['en']['lg_user_res_accept']; ?>
								</a>
							<a href="javascript:;" class="btn btn-sm bg-danger-light myCancel" data-toggle="modal" data-target="#myCancel" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 	
											<i class="fas fa-times"></i> <?php echo (!empty($user_language[$user_selected]['lg_cancel_service'])) ? $user_language[$user_selected]['lg_cancel_service'] : $default_language['en']['lg_cancel_service']; ?>
										</a>
							<?php }elseif($bookings['status']==3){
									$pending=0;?>
							<?php }?>	

									<?php if ($bookings['status']==7 || $bookings['status']==5  ) {?>
									<button type="button" data-id="<?php echo $bookings['id']?>"  class="btn btn-sm bg-default-light reason_modal">
											<i class="fas fa-info-circle"></i> <?php echo (!empty($user_language[$user_selected]['lg_reason'])) ? $user_language[$user_selected]['lg_reason'] : $default_language['en']['lg_reason']; ?>
										</button>
										<input type="hidden" id="reason_<?=$bookings['id'];?>" value="<?=$bookings['reason'];?>">
									<?php }?>
							</div>
					
					</div>
				</div>
				<?php } } else { ?>
				<p><?php echo (!empty($user_language[$user_selected]['lg_no_record_fou'])) ? $user_language[$user_selected]['lg_no_record_fou'] : $default_language['en']['lg_no_record_fou']; ?></p>
				<?php } ?>
				<?php 
				
						echo $this->ajax_pagination->create_links();
					?>
					<script src="<?php echo base_url();?>assets/js/functions.js"></script>