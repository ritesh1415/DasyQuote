<?php 
$user_count=0;
$providers_count=0;
$services_count=0;
$users = $this->dashboard->users_list_all();
$providers = $this->dashboard->providers_list_all();
$services = $this->dashboard->services_list_all();
$bookinglist = $this->dashboard->get_bookinglist();
$map_key=settingValue('map_key');
?>

<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title">Welcome Admin!</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->

		<div class="row">
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon bg-primary">
								<i class="far fa-user"></i>
							</span>
							<div class="dash-widget-info">
								<h3>
								<?php
								if(!empty($users)) {
									$user_count =$users;
								}
								if(!empty($user_count)){ echo $user_count;}else{ echo "0"; } ?>
								</h3>
								<h6 class="text-muted">Users</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon bg-primary">
								<i class="fas fa-user-shield"></i>
							</span>
							<div class="dash-widget-info">
								<h3>
								<?php
								if(!empty($providers)) {
									$providers_count = $providers;
								}
								if(!empty($providers_count)){ echo $providers_count;}else{ echo "0"; } ?>
								</h3>
								<h6 class="text-muted">Professionals</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon bg-primary">
								<i class="fas fa-qrcode"></i>
							</span>
							<div class="dash-widget-info">
								<h3>
								<?php
								if(!empty($services)) {
									$services_count = $services;
								} 
								if(!empty($services_count)){ echo $services_count;}else{ echo "0"; } ?></h3>
								<h6 class="text-muted">Services</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-body">
						<div class="dash-widget-header">
							<span class="dash-widget-icon bg-primary">
								<i class="far fa-credit-card"></i>
							</span>
							<div class="dash-widget-info">
								<h3>
								<?php if(!empty($payment_amount)){ echo currency_code_sign(settings('currency')).$payment_amount;}else{ echo currency_code_sign(settings('currency'))."0"; } ?>
								</h3>
								<h6 class="text-muted">Subscription</h6>
							</div>
						</div>
					</div>
				</div>
			</div>-->
		</div>
		
		<div class="row">
			<div class="col-md-6 d-flex">
			
				<!-- Recent Bookings -->
				<div class="card card-table flex-fill">
					<div class="card-header">
						<h4 class="card-title">Recent Bookings</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-center">
								<thead>
									<tr>
										<th>Name</th>
										<th>Date</th>
										<th class="text-center">Service</th>
										<th class="text-center">Status</th>
										<th class="text-right">Price</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($bookinglist)) {
									foreach ($bookinglist as $list) { ?>
									<tr>
										<td class="text-nowrap">
												<?php
												if(file_exists($list['profile_img'])){
													$image=base_url().$list['profile_img'];
												}else{
													$image=base_url().'assets/img/user.jpg';
												}
												?>
												<img class="avatar-xs rounded-circle" src="<?php echo $image;?>" alt="User Image"> <?php echo $list['name']?>
										</td>
										<td class="text-nowrap"><?php echo date(settingValue('date_format'), strtotime($list['service_date']));?></td>
										<td class="text-center"><?php echo $list['service_title']?></td>
										<td class="text-center">
											<?php if ($list['status']==1) {
											$badge='Pending';
											$color='warning';
											}
											if ($list['status']==2) {
												$badge='Inprogress';
												$color='info';
											}
											if ($list['status']==3) {
												$badge='Complete Request';
												$color='primary';
											}
											if ($list['status']==4) {
												$badge='Accepted';
												$color='muted';
											}
											if ($list['status']==5) {
												$badge='Rejected by User';
												$color='warning';
											} 
											if ($list['status']==6) {
												$badge='Payment Completed';
												$color='success';
											}
											if ($list['status']==7) {
												$badge='Cancelled by Provider';
												$color='danger';
											}
											if ($list['status']==8) {
												$badge='Completed';
												$color='success';
											}?>
											<span class="badge bg-<?php echo $color;?> inv-badge"><?php echo $badge;?></span>
										</td>
										<td class="text-right">
										<?php 
											//Currency Convertion Based 
						                    $currency_code_old = $list['currency_code1'];
						                    $subscription_amount = get_gigs_currency($list['service_amount'], $currency_code_old, $currency_code);
						                    $totalamount=  currency_code_sign(settings('currency')).$subscription_amount;
										?>
											<div class="font-weight-600"><?php echo $totalamount; ?></div>
										</td>
									</tr>
									<?php } } else {
									?>
									<tr>
										<td colspan="5">
											<div class="text-center text-muted">No records found</div>
										</td>
									</tr>
								  <?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /Recent Bookings -->
				
			</div>
			<div class="col-md-6 d-flex">
				<?php
					$this->db->select('*');
					$this->db->from('book_service');
					$this->db->where('tokenid !=', '');
					$this->db->order_by('id','DESC');
					$this->db->limit(5);
					$query = $this->db->get();
					$list_payments= $query->result_array();
				?>
				<!-- Payments -->
				<div class="card card-table flex-fill">
					<div class="card-header">
						<h4 class="card-title">Payments</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-center">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Professional</th>
										<th>Service</th>
										<th>Amount</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($list_payments)) {
										$i=1;
									foreach ($list_payments as $rows) {
										$provider_name = $this->db->where('id',$rows['provider_id'])->get('providers')->row_array();
										$user_name = $this->db->where('id',$rows['user_id'])->get('users')->row_array();
										$service = $this->db->where('id',$rows['service_id'])->get('services')->row_array();
										$service = $this->db->where('id',$rows['service_id'])->get('services')->row_array();
										$admin_payment = $this->db->where('booking_id',$rows['id'])->get('admin_payment')->row_array();
										$color='';
									if($rows['status'] == 1) {
										$status = 'Pending';
										$color='warning';
									}
									elseif($rows['status'] == 2) {
										$status = 'Inprogress';
										$color='primary';
									}
									elseif($rows['status'] == 3) {
										$status = 'Completed Provider';
										$color='success';
									}
									elseif($rows['status'] == 5) {
										$status = 'Rejected';
										$color='danger';
									} 
									elseif($rows['status'] == 6) {
										$status = 'Accepted';
										$color='success';
									} 
									elseif($rows['status'] == 7) {
										$status = 'Cancelled Provider';
										$color='danger';
									} 
									elseif($rows['status'] == 8) {
										$status = 'Completed';
										$color='success';
									}							
									//Currency Convertion Based 
				                    $currency_code_old = $rows['currency_code'];
				                    $subscription_amount = get_gigs_currency($rows['amount'], $currency_code_old, $currency_code);
				                    $totalamount=  currency_code_sign(settings('currency')).$subscription_amount;
									?>
									<tr>
										<td><?php echo $i++ ?></td> 
										<td><?php echo date(settingValue('date_format'), strtotime($rows['service_date']));?></td>
										<td><?php echo $provider_name['name'] ?></td>
										<td><?php echo $service['service_title']?></td>
										<td><?php echo $totalamount; ?></td>
										<td><span class="badge bg-<?php echo $color;?> inv-badge"><?php echo $status?></span></td>
									</tr>
									<?php } } else {
									?>
									<tr><td colspan="6"><div class="text-center text-muted">No records found</div></td></tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card provider-map">
					<div class="card-header text-center">
						<h4 class="card-title">Professional in Map</h4>
					</div>
					<div class="card-body align-items-center">
						<div class="row">
							<div class="col-md-12">
								<div class="">
								    <div id="map-container"><div id="map"></div></div>
									<div id="world-map-markers"></div>
								</div>                                                                     
							</div>                              
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>          
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_key?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/markerclusterer.js"></script>