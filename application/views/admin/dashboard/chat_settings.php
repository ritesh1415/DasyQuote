<div class="page-wrapper"> 
	<div class="content container-fluid"> 
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title">Chat Settings</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		<<div class="row">
			<div class=" col-lg-6 col-sm-12 col-12">
				<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="socket" action="<?php echo base_url('admin/settings/socket'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card">
						<div class="card-header">
							<div class="card-heads">
								<h4 class="card-title">Socket Details</h4>
								<div class="col-auto">
									<div class="status-toggle mr-3">
	                                    <input  id="socket_showhide" class="check" type="checkbox" name="socket_showhide"<?=settingValue('socket_showhide')?'checked':'';?>>
	                                    <label for="socket_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
	                            <label>Server IP</label>
	                            <input type="text" class="form-control" name="server_ip" value="<?php echo settingValue('server_ip'); ?>">
			                </div>
			                <div class="form-group">
	                            <label>Port</label>
	                            <input type="text" class="form-control" name="server_port" value="<?php echo settingValue('server_port'); ?>">
			                </div>
			                <?php if($this->session->userdata('admin_id') == 1) { ?>
								<div class="form-groupbtn">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save</button>
								</div>
							<?php } ?>
						</div>
					</div>
				</form>
			</div> 

			<div class=" col-lg-6 col-sm-12 col-12 d-flex">
				<div class="card flex-fill">
					<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="chat" action="<?php echo base_url('admin/settings/chat'); ?>">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
						<div class="card-header">
							<div class="card-heads">
								<h4 class="card-title">Chat Content</h4>
								<div class="col-auto">
									<div class="status-toggle mr-3">
	                                    <input  id="chat_showhide" class="check" type="checkbox" name="chat_showhide"<?=settingValue('chat_showhide')?'checked':'';?>>
	                                    <label for="chat_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
	                            <label>Chat Content Text</label>
	                            <input type="text" class="form-control" name="chat_text" value="<?php echo settingValue('chat_text'); ?>">
			                </div>
			                <?php if($this->session->userdata('admin_id') == 1) { ?>
								<div class="form-groupbtn">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save</button>
								</div>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> 