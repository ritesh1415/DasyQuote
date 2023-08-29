<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">App Section</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="card">
					<div class="card-body">
							<form class="form-horizontal"  method="POST" enctype="multipart/form-data" >
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
						<h5>Section Switch</h5>
						<div class="row align-items-center">
                            <div class="col">
                                <p class="mb-0">Home Section Show And Hide Download Stores</p>
                            </div>
                            <div class="col-auto">
                                <div class="status-toggle">
                                    <?php if ($user_role == 1) { ?>
                                        <input  id="appsection_showhide" class="check" type="checkbox" name="appsection_showhide" <?= ($appsection_showhide == 'show') ? 'checked' : ''; ?>>
                                    <?php } else { ?>
                                        <input  id="appsection_showhide" class="check" type="checkbox" name="appsection_showhide" <?= ($appsection_showhide == 'hide') ? 'checked' : ''; ?> disabled>
                                    <?php } ?>
                                    <label for="appsection_showhide" class="checktoggle">checkbox</label>
                                </div>
                            </div>
                        </div>
                        <div class="store_links" id="store_links">
						<div class="form-group mt-5">
                                <label>App Store Link</label>
                                <input type="text" class="form-control" name="app_store_link" value="<?php if (isset($app_store_link)) echo $app_store_link; ?>" required>
                        </div>
                        <div class="form-group mt-5">
                                <label>Play Store Link</label>
                                <input type="text" class="form-control" name="play_store_link" value="<?php if (isset($play_store_link)) echo $play_store_link; ?>" required>
                        </div>
                    	</div>
                    		<br>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save</button>
							</div>
						</form>              
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

