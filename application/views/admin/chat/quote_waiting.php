<?php
$category = $this->db->get('categories')->result_array();
$subcategory = $this->db->get('subcategories')->result_array();
$services = $this->db->get('services')->result_array();
$user_list = $this->db->select('id,name')->get('users')->result_array();
$provider_list = $this->db->select('id,name')->get('providers')->result_array();
$servie_staus = array(
array("id"=>1,'value'=>'Pending'),
array("id"=>2,'value'=>'Inprogress'),
array("id"=>3,'value'=>'Provider Complete'),
array("id"=>4,'value'=>'Accept User Request'),
array("id"=>5,'value'=>'Reject'),
array("id"=>6,'value'=>'Complete'),
array("id"=>7,'value'=>'Cancel'),
array("id"=>8,'value'=>'Cod Completed')
); 
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Quote List</h3>
				</div>
				<div class="col-auto text-right">
					<a class="btn btn-white filter-btn mr-3" href="javascript:void(0);" id="filter_search">
						<i class="fas fa-filter"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<!-- Search Filter -->
		<form action="<?php echo base_url();?>admin/total-report" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    

			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Service Title</label>
								<select class="form-control" id="service_id_f" name="service_title">
									<option value="">Select service</option>
									<?php foreach ($services as $pro) {
									if(!empty($filter['service_t'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option <?=$select;?> value="<?=$pro['id']?>"><?php echo $pro['service_title']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" id="status_f" name="service_status">
									<option value="">Select Status</option>
									<?php foreach ($servie_staus as $pro) {
									if(!empty($filter['service_s'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option <?=$select;?> value="<?=$pro['id']?>"><?php echo $pro['value']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label">User</label>
								<select class="form-control" id="user_id_f" name="user_id">
									<option value="">Select User</option>
									<?php foreach ($user_list as $pro) {
									if(!empty($filter['user_i'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option <?=$select;?> value="<?=$pro['id']?>"><?php echo ucfirst($pro['name']);?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label">Professional</label>
								<select class="form-control" id="provider_id_f" name="provider_id">
									<option value="">Select Professional</option>
									<?php foreach ($provider_list as $pro) {
									if(isset($filter['provider_i'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option <?=$select;?> value="<?=$pro['id']?>"><?php echo ucfirst($pro['name']);?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label">From Date</label>
								<div class="cal-icon">
									<?php
									if(!empty($filter['service_from'])){
										$fr_date=$filter['service_from'];
									}else{
										$fr_date='';
									}
									if(!empty($filter['service_to'])){
										$to_date=$filter['service_to'];
									}else{
										$to_date='';
									}
									?>
									<input class="form-control start_date" type="text" id="from_f" name="from" value="<?=$fr_date;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label">To Date</label>
								<div class="cal-icon">
									<input class="form-control end_date" type="text" id="to_f" name="to" value="<?=$to_date;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<button class="btn btn-primary btn-block" name="form_submit" value="submit" type="submit">Submit</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
		<!-- /Search Filter -->

		<ul class="nav nav-tabs menu-tabs">
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url().'admin/all-quotes'; ?>">All Quotes<span class="badge badge-primary"><?=$all_booking;?></span></a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-response'; ?>">Response <span class="badge badge-primary"><?=$pending;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-inProgress'; ?>">InProgress <span class="badge badge-primary"><?=$inprogress;?></span></a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-waiting'; ?>">Waiting <span class="badge badge-primary"><?=$completed;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-decline'; ?>">Decline<span class="badge badge-primary"><?=$rejected;?></span></a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/cancel-report'; ?>">Canceled <span class="badge badge-primary"><?=$cancelled;?></span></a>
			</li> -->
		</ul>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive total-booking-report">
							<table class="table table-hover table-center mb-0 service_table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Professional</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($list)) {

                                    $i=1;
                                    foreach ($list as $rows) {
									if(file_exists($rows['user_profile_img'])){
										$user_image = $rows['user_profile_img'];
									} else {
										$user_image ='assets/img/user.jpg';
									}
									if(file_exists($rows['provider_profile_img'])) {
										$provider_image = $rows['provider_profile_img'];
									} else {
										$provider_image ='assets/img/user.jpg';
									}
									if(!empty($rows['service_date'])){
										$service_date=date(settingValue('date_format'), strtotime($rows['service_date']));
									}else{
										$service_date='-';
									}
									$datef = explode(' ', $rows['updated_on']);
									if(settingValue('time_format') == '12 Hours') {
	                                    $time = date('h:ia', strtotime($datef[1]));
	                                } elseif(settingValue('time_format') == '24 Hours') {
	                                   $time = date('H:i:s', strtotime($datef[1]));
	                                } else {
	                                    $time = date('G:ia', strtotime($datef[1]));
	                                }     

	                                $date = date(settingValue('date_format'), strtotime($datef[0]));
	                                $timeBase = $date.' '.$time;
									

									$badge='';
									if ($rows['status']==1) {
										$badge='Pending';
										$color='dark';
									}
									if ($rows['status']==2) {
										$badge='Inprogress';
										$color='info';
									}
									if ($rows['status']==3) {
										$badge='Complete Request';
										$color='primary';
									}
									if ($rows['status']==4) {
										$badge='Accepted';
										$color='purple';
									}
									if ($rows['status']==5) {
										if($rows['admin_update_status'] == 0) { $badge='Rejected by Provider'; }
										else  { $badge='Rejected'; }
										$color='warning';
									} 
									if ($rows['status']==6 && $rows['cod']==1) {
										$badge='Service Completed & Payment Pending';
										$color='primary';
									} 
									if ($rows['status']==6 && $rows['cod']==2) {
										$badge='Completed';
										$color='success';
									} 
									if ($rows['status']==7) {
										if($rows['admin_update_status'] == 0) { $badge='Cancelled by User'; }
										else  { $badge='Cancelled'; }
										$color='danger';
									}
									if ($rows['status']==8) {
										$badge='Completed';
										$color='success';
									}
									if($rows['admin_update_status'] == 1) {
										$badge = $badge." - by Admin";
									}
									$statcheck = 0;
									if($rows['status'] == 5 || $rows['status'] == 7){
										if(!empty($rows['reject_paid_token'])){
											$statcheck = 1;
										} 
									}
									if($rows['status'] == 6 || $rows['status'] == 8 || $rows['status'] == 7){
										$statcheck = 1;
									}
									$subtxt = '';
									if(!empty($rows['reject_paid_token'])){
									 	if($rows['admin_reject_comment']=="This service amount favour for User"){
									 		$subtxt="Amount refund to User";
									 	}else{
											$subtxt="Amount refund to Professional";
									 	}
									}
									$badge .= '<br><span class="small">'.$subtxt."</span>";

				                    //Currency Convertion Based 
				                    $currency_code_old = $rows['currency_code'];
				                    $subscription_amount = get_gigs_currency($rows['amount'], $currency_code_old, $currency_code);
				                    $totalamount=  currency_code_sign(settings('currency')).$subscription_amount; 
									echo '<tr>
										<td>'.$i++.'</td>
										<td>'.$service_date.'</td>
										<td>
											<h2 class="table-avatar">
												<a href="#" class="avatar avatar-sm mr-2">
													<img class="avatar-img rounded-circle" alt="" src="'.base_url().$user_image.'">
												</a>
												<a href="javascript:void(0);">'.str_replace('-', ' ', $rows['user_name']).'</a>
											</h2>
										</td>
										<td>
											<h2 class="table-avatar">
												<a href="#" class="avatar avatar-sm mr-2">
													<img class="avatar-img rounded-circle" alt="" src="'.base_url().$provider_image.'">
												</a>
												<a href="javascript:void(0);">'.str_replace('-', ' ', $rows['provider_name']).'</a>
											</h2>
										</td>
										<td>'.$rows['service_title'].'</td>
										<td>'.$totalamount.'</td>
										<td><label class="badge badge-'.$color.'">'.ucfirst($badge).'</lable></td>
										<td>'.$timeBase.'</td>';
										if($user_role == 1) {										
										if($statcheck == 0) {
											echo '<td><select class="form-control chngstatus" name="ser_status" data-id="'.$rows['id'].'" data-userid="'.$rows['userid'].'" data-providerid="'.$rows['providerid'].'" data-serviceid="'.$rows['serviceid'].'">
													<option value="">Select Status</option>';
													foreach ($servie_staus as $pro) { 
													echo '<option value="'.$pro['id'].'">'.$pro['value'].'</option>';
													} 
												echo '</select></td>';
												
										} else {
											echo '<td class="text-center">-</td>';
										}
									} else {
										
										foreach ($servie_staus as $pro) {
											if($rows['status'] == $pro['id']) {
												$status = $pro['value'];
											}
										}
										echo '<td>'.$status.'</td>';
									}
									echo '</tr>';
									} 
									} else {
                                    ?>
									<tr>
										<td colspan="9">
											<div class="text-center text-muted">No records found</div>
										</td>
									</tr>
									<?php } ?>
                                </tbody>
                            </table>
						</div> 
					</div> 
				</div> 
			</div>
		</div>
	</div>
</div>