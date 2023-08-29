<?php
   $module_details = $this->db->where('status',1)->get('admin_modules')->result_array();
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-12 offset-xl-12">
			
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
						<form method="post" autocomplete="off" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=(!empty($user['user_id']))?$user['user_id']:''?>" id="user_id">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
							
							<div class="form-group">
								<label>Subject</label>
								<input type="text" name="subject" class="form-control" />
							</div>
							
							<div class="form-group">
								<label>Message</label>
								<textarea class="form-control" rows='10' name="message" id="message" ></textarea>
							</div>
							<div class="form-group">
								<label>Send To</label>
								<div class="example1">
									<div><input type="checkbox" name="selectall1" id="selectall1" class="all" value="1"> <label for="selectall1"><strong>Select all</strong></label></div>
									
									<div><input type="checkbox" name="accesscheck[]" id="check_1" value="1"> <label for="check_1">User</label></div>								
									<div><input type="checkbox" name="accesscheck[]" id="check_2" value="2"> <label for="check_2">Professional</label></div>								
								</div>
							</div>
							<div class="mt-4">
								<?php if($user_role==1){?>
								<button class="btn btn-primary " name="form_submit1" value="submit" type="submit">Submit</button>
							<?php }?>

								<a href="<?php echo $base_url; ?>admin/SendPushNotification"  class="btn btn-cancel">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

