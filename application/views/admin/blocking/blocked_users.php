<?php
   $user_details = $this->db->get('users')->result_array();
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Blocked Users</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
                        <div class="table-responsive">
                            <table class="custom-table table table-hover table-center mb-0 w-100" id="users_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Blocked User</th>
                                        <th>Requested By</th>
										<th>Reason</th>
										<th>Status</th>
										<th>Created On</th>
										<th>Updated On</th>
                               		 	<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php 
									if(!empty($list)) {
										$i=1; 
										foreach ($list as $rows) { 
											if($rows['status']==2) {
												$status = "Requested to block user";
												$color = "info";
											}
											if($rows['status']==1) {
												$status = "Blocked";
												$color = "danger";
											}
											if(file_exists($rows['user_img'])) {
												$user_profile_img = $rows['user_img'];
											} else {
												$user_profile_img ='assets/img/user.jpg';
											}
											
											if(file_exists($rows['provider_img'])) {
												$provider_profile_img = $rows['provider_img'];
											} else {
												$provider_profile_img ='assets/img/user.jpg';
											}
											

											$base_url = base_url()."'admin/dashboard/blocked_users_byAdmin'".$rows['id'];

											$action = ""; 
											if($rows['status']!=1) {
												$action = "<a href='javascript:;' class='btn btn-sm bg-danger-light mr-2 blockbyAdmin' data-rowid='".$rows['id']."' data-blockedid='".$rows['blocked_id']."' data-blockedbyid='".$rows['blocked_by_id']."' data-usertype='2'><i class='fas fa-ban mr-1'></i> Block </a>";
											} else {
												$action = "<a href='javascript:;' class='btn btn-sm bg-success-light mr-2 unblockbyAdmin' data-rowid='".$rows['id']."' data-blockedid='".$rows['blocked_id']."' data-blockedbyid='".$rows['blocked_by_id']."' data-usertype='2'><i class='fas fa-ban mr-1'></i> UnBlock </a>";
											}

											echo'<tr>
											<td>'.$i++.'</td>
											<td>
												<h2 class="table-avatar">
													<a href="#" class="avatar avatar-sm mr-2">
														<img class="avatar-img rounded-circle" alt="" src="'.base_url().$user_profile_img.'">
													</a>
													<a href="'.base_url().'user-details/'.$rows['user_id'].'">'.str_replace('-', ' ', $rows['user_name']).'</a>
												</h2>
											</td>
											<td>
												<h2 class="table-avatar">
													<a href="#" class="avatar avatar-sm mr-2">
														<img class="avatar-img rounded-circle" alt="" src="'.base_url().$provider_profile_img.'">
													</a>
													<a href="'.base_url().'user-details/'.$rows['provider_id'].'">'.str_replace('-', ' ', $rows['provider_name']).'</a>
												</h2>
											</td>
											<td>'.ucfirst(strtolower($rows['blocked_reason'])).'</td>
											<td><label class="badge badge-'.$color.'">'.ucfirst($status).'</lable></td>
											<td>'.$rows['created_at'].'</td>
											<td>'.$rows['updated_at'].'</td>
											<td>'.$action.'</td>
											</tr>';
										}
                                    }
                                    else {
										echo '<tr><td colspan="6"><div class="text-center text-muted">No records found</div></td></tr>';
                                    }
									?>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>