<?php
$category = $this->db->get('categories')->result_array();
$subcategory = $this->db->get('subcategories')->result_array();
$services = $this->db->get('services')->result_array();
$user_list = $this->db->select('id,name,type,token')->get('users')->result_array();
$provider_list = $this->db->select('id,name,type,token')->get('providers')->result_array();
$all_member=array_merge($user_list,$provider_list);

?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Wallet</h3>
				</div>
				<div class="col-auto text-right">
					<a class="btn btn-white filter-btn mr-2" href="javascript: void(0);" id="filter_search">
						<i class="fas fa-filter"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<!-- Search Filter -->
		<form action="<?php echo base_url()?>admin/wallet-history" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>User</label>
								<select class="form-control" id="token" name="token">
									<option value="">Select User</option>
									<?php foreach ($all_member as $pro) 
									{
									if($pro['type']==1){
										$type_name='Provider';
									}else{
										$type_name='User';
									}
									if($filter['token_f']==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option <?=$select;?> value="<?=$pro['token']?>"><?php echo ucfirst($pro['name']).'-'.$type_name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>From Date</label>
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
								<div class="cal-icon">
									<input class="form-control start_date" type="text" id="from_f" name="from" value="<?=$fr_date;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>To Date</label>
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
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/wallet'; ?>">Wallet Report</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url().'admin/wallet-history'; ?>">Wallet History</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/wallet-request-history'; ?>">Wallet Request History</a>
			</li>
		</ul>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 service_table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Bank Details</th>
                                        <th>Current Amt</th>
                                        <th>Credit Amt</th>
                                        <th>Debit Amt</th>
                                        <th>Fee Amt</th>
                                        <th>Available Amt</th>
                                        <th>Reason</th>
                                        <th>Pay Type</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($list)) {
                                    $i=1;
                                    foreach ($list as $rows) {
									if(!empty($rows['date'])){
										$date =date(settingValue('date_format').' H:i:s', strtotime($rows['date']));
									}else{
										$date='-';
									}

									if(!empty($rows['credit_wallet'])){
										$color_t='success';
										$message_t='Credit';
									}else{
										$color_t='danger';
										$message_t='Debit';
									}
									if($rows['role']==1){
										$role=' provider ';
										$color='success';
									}else{
										$role='user';
										$color='primary';
									}
									if($rows['role']==1) { 
										$det = '<button type="button" class="btn btn-primary badge" onclick="getBankDetails('.$rows['user_provider_id'].');"><i class="fas fa-eye mr-1"></i>Bank</button>'; 
									} else {
										$det = '-';
									}
									echo '<tr>
										<td>'.$i++.'</td>
										<td>'.$date.'</td>
										<td>
											<h2 class="table-avatar">
												<a href="#" class="avatar avatar-sm mr-2">
													<img class="avatar-img rounded-circle" alt="" src="'.base_url().$rows['user_image'].'">
												</a>
												<a href="javascript:void(0);">'.str_replace('-', ' ', $rows['user_name']).'</a>
											</h2>
										</td>
										<td>'.$rows['user_mobile'].'</td>
										<td><span class="badge badge-'.$color.'">'.ucfirst($role).'</span></td>
										<td>'.$det.'</td>
										<td>'.currency_conversion($rows['currency_code']).$rows['current_wallet'].'</td>
										<td>'.currency_conversion($rows['currency_code']).$rows['credit_wallet'].'</td>
										<td>'.currency_conversion($rows['currency_code']).$rows['debit_wallet'].'</td>
										<td>'.currency_conversion($rows['currency_code']).$rows['fee_amt'].'</td>
										<td>'.currency_conversion($rows['currency_code']).$rows['avail_wallet'].'</td>
										<td>'.$rows['reason'].'</td>
										<td><span class="badge badge-'.$color_t.'">'.$message_t.'</span></td> 
									</tr>';
									} 
									} else {
									?>
									<tr>
										<td colspan="12">
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bank Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
			<div class="card-body">
				<div class="row">
					<p class="col-sm-6">Account holder name</p>
					<p class="ac_holder col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">Account Number</p>
					<p class="ac_no col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">IBAN Number</p>
					<p class="iban_no col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">Bank Name</p>
					<p class="bank_name col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">Bank Address</p>
					<p class="address col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">Sort Code</p>
					<p class="sort_code col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">Swift Code</p>
					<p class="swift_code col-sm-6"></p>
				</div>
				<div class="row">
					<p class="col-sm-6">IFSC Code</p>
					<p class="ifsc_code col-sm-6"></p>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function getBankDetails(id) {
		var csrf_token=$('#admin_csrf').val();
		var base_url=$('#base_url').val();
		$('#exampleModal').modal('show');
		$.ajax({
			type:'POST',
     		url: base_url+'provider_bank_details',
     		data :  {id:id,csrf_token_name:csrf_token},
     		dataType:'json',
     		success:function(res) {
     			$('.ac_holder').text(res.account_holder_name);
     			$('.ac_no').text(res.account_number);
     			$('.iban_no').text(res.account_iban);
     			$('.bank_name').text(res.bank_name);
     			$('.address').text(res.bank_address);
     			$('.sort_code').text(res.sort_code);
     			$('.swift_code').text(res.routing_number);
     			$('.ifsc_code').text(res.routing_number);
     		}

		})
	}
</script>