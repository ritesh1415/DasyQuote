<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Cash On Delivery</h3>
				</div>
				<div class="col-auto text-right d-none">
					<div class="col-sm-4 text-right m-b-20">
						<a href="<?php echo base_url().$theme . '/' . $model . '/create'; ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>
					</div>
				
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		<?php
			if ($this->session->userdata('message')) {
				echo $this->session->userdata('message');
			}
			?>
		<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-actions-bar m-b-0 categories_table">
							<thead>
								<tr>
									<th>#</th>
									<th>Title</th>
									<th>Username</th>
									<th>Professional</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Service Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($lists)) {
									$sno = 0;
									foreach ($lists as $row) {
										$badge='';
										if ($row['status']==0) {
											$badge='UnPaid';
											$color='danger';
										}
										if ($row['status']==1) {
											$badge='Paid';
											$color='success';
										}
										 $boorows = $this->db->where('id',$row['id'])->from('book_service')->get()->row_array();
										$bstatus = '';
										if($boorows['status'] == 1) {
                                            $bstatus = 'Pending';
										}
										elseif($boorows['status'] == 2) {
                                            $bstatus = 'Inprogress';
										}
										elseif($boorows['status'] == 3) {
                                            $bstatus = 'Complete Request to User';
										}
										elseif($boorows['status'] == 5&&empty($boorows['reject_paid_token'])) {
                                            $bstatus = 'Rejected by User';
										}
										elseif($boorows['status'] == 6) {
                                            $bstatus = 'Payment Completed';
										}
										elseif($boorows['status'] == 7&&empty($boorows['reject_paid_token'])) {
                                            $bstatus = 'Cancelled by Provider';
										} else if($boorows['status'] == 8) {
											$bstatus = 'Payment Completed';
										}
								?>
										<tr>
											<td> <?php echo ++$sno; ?></td>
											<td> <?php echo $row['service_title']; ?></td>
											<td> <?php echo $row['username']; ?></td>
											<td> <?php echo $row['providername']; ?></td>
											<td> <?php echo currency_conversion($row['currency_code']).$row['amount']; ?></td>
											<td> <?php echo '<label class="badge badge-'.$color.'">'.ucfirst($badge).'</lable>'; ?></td>
											<td><?php echo $bstatus;?></td>
										</tr>
									<?php
									}
								} else {
									?>
									<tr>
										<td colspan="7">
											<p class="text-center mb-0">No Records Found</p>
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
</div>