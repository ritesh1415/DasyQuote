<?php
   $mainmodule_details = $this->db->select('parent')->group_by('parent')->where('status',1)->order_by('module_order')->get('admin_modules')->result_array();
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title"><?=$title;?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="card">
					<div class="card-body">
						<form id="add_adminuser" method="get" autocomplete="off" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=(!empty($user['user_id']))?$user['user_id']:''?>" id="user_id">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
    
							<div class="form-group">
								<label>Name</label>
								<input class="form-control" type="text"  name="full_name" id="full_name" value="<?=(!empty($user['full_name']))?$user['full_name']:''?>">
							</div>
							<div class="form-group">
								<label>Username</label>
								<input class="form-control" type="text"  name="username" id="username" value="<?=(!empty($user['username']))?$user['username']:''?>">
							</div>
							<?php if(empty($user['password'])){ ?>
							<div class="form-group">
								<label>Password</label>
								<input class="form-control" type="password"  name="password" id="password" >
							</div>
							<?php }else{ ?>
							<input class="form-control" type="hidden"  name="password" id="password" value="<?php echo $user['password'];?>">
							<?php } ?>
							
							<div class="form-group">
								<label>Email ID</label>
								<input class="form-control" type="text"  name="email" id="email" value="<?=(!empty($user['email']))?$user['email']:''?>">
							</div>

							<div class="form-group">
								<label>Profile Image</label>
								<div class="media align-items-center">
									<div class="media-left">
										<?php if($user) {
										if (file_exists($user['profile_img'])) { ?>
											<img class="rounded-circle" src="<?php echo base_url().$user['profile_img'];?>" width="100" height="100" class="profile-img avatar-view-img" id="preview_img">
										<?php } } else {?>
											<img class="rounded-circle" src="<?php echo base_url('assets/img/user.jpg');?>" width="100" height="100" class="profile-img avatar-view-img" id="preview_img">
											
										<?php }
										?>									
									</div>
									<div class="media-body">
										<div class="uploader"><button type="button" class="btn btn-secondary btn-sm ml-2 avatar-view-btn">Change profile picture</button>
										<input type="hidden" id="crop_prof_img" name="profile_img">
										</div>
										<span id="image_error" class="text-danger" ></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Set Access</label>
								<div class="example1">
									<div><input type="checkbox" name="selectall1" id="selectall1" class="all" value="1"> <label for="selectall1"><strong>Select all</strong></label></div>
									<?php 
									$dups = $new_arr = array();
									foreach ($mainmodule_details as $mainmodule) {
										$module_details = $this->db->where('status',1)->where('parent',$mainmodule['parent'])->get('admin_modules')->result_array();
										foreach ($module_details as $module) {
										$checkcondition  = "";
										if(!empty($user['user_id'])){
											$access_result = $this->db->where('admin_id',$user['user_id'])->where('module_id',$module['id'])->where('access',1)->select('id')->get('admin_access')->result_array();
											if(!empty($access_result)){
												$checkcondition  = "checked='checked'";
											}
										}
									?>
									<li><input type="checkbox" <?php echo $checkcondition; ?> name="accesscheck[]" id="check<?php echo $module['id'];?>" value="<?php echo $module['id'];?>"> <label for="check1"><?php echo $module['module_name'];?></label></li>
									<?php } 
									echo "</ol>";
									} ?>									
								</div>
							</div>
							<div class="mt-4">
								<?php if($user_role==1){?>
								<button class="btn btn-primary " name="form_submit" value="submit" type="submit">Submit</button>
							<?php }?>
								<a href="<?php echo $base_url; ?>adminusers"  class="btn btn-cancel">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Profile Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<?php $curprofile_img = (!empty($profile['profile_img']))?$profile['profile_img']:''; ?>
				<form class="avatar-form" action="<?=base_url('admin/dashboard/crop_profile_img/'.$curprofile_img)?>" enctype="multipart/form-data" method="post">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
					<div class="avatar-body">
						<!-- Upload image and data -->
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput">Select Image</label>
							<input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
							<span id="image_upload_error" class="error" ></span>
						</div>
						<!-- Crop and preview -->
						<div class="row">
							<div class="col-md-12">
								<div class="avatar-wrapper"></div>
							</div>
						</div>
						<div class="mt-4 text-center">
							<button class="btn btn-primary avatar-save upload_images" id="upload_images" type="submit" >Yes, Save Changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>