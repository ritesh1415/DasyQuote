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
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url().'admin/all-quotes'; ?>">All Quotes<span class="badge badge-primary"><?=$all_booking;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-response'; ?>">Response <span class="badge badge-primary"><?=$pending;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-inProgress'; ?>">InProgress <span class="badge badge-primary"><?=$inprogress;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-waiting'; ?>">Waiting<span class="badge badge-primary"><?=$completed;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/quote-decline'; ?>">Decline <span class="badge badge-primary"><?=$rejected;?></span></a>
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
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
									
								<tbody>
									<?php foreach ($qanswers as $row): ?>
									
                                      
									  
									   <?php
									   $base_url = base_url('all_quotes/view_quote/'.$row->id);
                                        $action = "<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'><i class='far fa-edit mr-1'></i> View </a>"; ?>
												  
												
										   
                                        <tr>								
                                            <td><?php echo $row->user_id; ?></td>
                                            <td><?php echo $row->created_time; ?></td>
                                            <td>
											<?php echo $row->name; ?>
                                            </td>
                                           
                                            <td><?php echo $row->category_name; ?></td>
                                            <!-- <td>'.$totalamount.'</td> -->
                                            <!-- <td><label class="badge badge-'.$color.'">Waiting</lable></td> -->
                                            <td>Pending</td>
											<td>
    <?= $action ?>
		<?php if ($row->status == 1): ?>
			<a href="<?= base_url('Dashboard/quote_status') ?>?qid=<?= $row->id ?>&qval=<?php echo $row->status; ?>" class="btn btn-success">Active</a>
		<?php else: ?>
			<a href="<?= base_url('Dashboard/quote_status') ?>?qid=<?= $row->id ?>&qval=<?php echo $row->status;  ?>" class="btn btn-danger">Inactive</a>
		<?php endif; ?>
		</td>
					 
												
										
													<!-- <td class="text-center"></td> -->
										
				
												<!-- <td></td> -->
									
											</tr>
									 
								
											<tr>
												<td colspan="9">
													<!-- <div class="text-center text-muted">No records found</div> -->
												</td>
											</tr>
									
										
										
													<!-- <td class="text-center"></td> -->
										
				
												<!-- <td></td> -->
									
											</tr>
									 
								
											<tr>
												<td colspan="9">
													<!-- <div class="text-center text-muted">No records found</div> -->
												</td>
											</tr>
										<?php endforeach;?>
                                    </tbody>
									
                               
                            </table>
						</div> 
					</div> 
				</div> 
			</div>
		</div>
	</div>
</div>