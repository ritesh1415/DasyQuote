<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Revenue</h3>
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
		<form action="<?php echo base_url()?>admin/Revenue" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
					
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Provider Name</label>
								<select class="form-control" name="provider_name" >
									<option value="">Select provider name</option>
									<?php foreach ($provider_list as $provider) { ?>
									<option value="<?=$provider['id']?>"><?php echo $provider['name']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Date</label>
								<div class="cal-icon">
									<input class="form-control datetimepicker" type="text" name="date" id="date">
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
		
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class=" table table-hover table-center mb-0 payment_table">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Provider Name</th>
										<th>User Name</th>
										<th>Amount</th>
										<th>Commission Amount</th>
										<th>Status</th>
										
										
									
									</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($list)) {
									$i=1;
								foreach ($list as $rows) { 
                                                                    $amount=$rows['amount'];
                                                                    $comi=$rows['commission'];
                                                                    $comAount=$amount*$comi/100;
                                                                    ?>
								<tr>
									 
									<td><?php echo $i++; ?></td> 
									<td><?=date(settingValue('date_format'), strtotime($rows['date']));?></td>
									<td><?php echo ($rows['provider']); ?></td> 
									<td><?php echo ($rows['user']); ?></td> 
									<td><?php echo currency_conversion($rows['currency_code']).($rows['amount']); ?></td> 
									<td><?php echo currency_conversion($rows['currency_code']).($comAount); ?></td> 
									<td><label class="badge badge-success">Completed</label></td> 
									
									<!-- Compete Request Accept update_status_user -->

								</tr>
								<?php } } else {
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