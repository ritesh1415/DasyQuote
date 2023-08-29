<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h4 class="page-title m-b-20 m-t-0">Edit Footer Menu</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="card-box">
						<?php foreach ($datalist as $value) { ?>
							<form class="form-horizontal" action="<?php echo base_url('admin/footer_submenu/edit/' . $value['id']); ?>" method="POST" enctype="multipart/form-data">
								<div class="form-group">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
									<label class="col-sm-3 control-label"></label>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="menu_status" value="0" name="menu_status" <?php
											if ($value['menu_status'] == 0) { echo 'checked=""'; } ?>>
										<label for="menu_status">Menu</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="menu_status_one" value="1" name="menu_status" <?php
											if ($value['menu_status'] == 1) { echo 'checked=""'; } ?>>
										<label for="menu_status">Widget</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Widget</label>
									<div class="col-sm-9">
										<select class="form-control" name="main_menu" id="main_menu" required readonly>
											<?php
											foreach ($main_menu as $main) {
											?>
												<option value="<?php echo $main['id']; ?>" <?php if ($main['id'] == $value['footer_menu']) { echo 'Selected'; } ?>><?php echo str_replace('_', ' ', $main['title']); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group cate" id="category" style="display: none;">
									<div class="form-group">
										<label class="col-sm-3 control-label">Category-view</label>
										<div class="col-sm-9">
											<select class="form-control" name="category_view" id="category_view">
												<option value="Name" <?php if($datalist[0]['category_view'] == 'Name') { echo 'selected'; } ?>>Name</option>
												<option value="Orderby" <?php if($datalist[0]['category_view'] == 'Orderby') { echo 'selected'; } ?>>Orderby Asc</option>
												<option value="Orderby_Desc" <?php if($datalist[0]['category_view'] == 'Orderby_Desc') { echo 'selected'; } ?>>Orderby Desc</option>
												<option value="Popular category" <?php if($datalist[0]['category_view'] == 'Popular category') { echo 'selected'; } ?>>Popular category</option>
												<option value="Recent category" <?php if($datalist[0]['category_view'] == 'Recent category') { echo 'selected'; } ?>>Recent category</option>
											</select>
										</div>
									</div>
									<div class="form-group sub_menu">
										<label class="col-sm-3 control-label">Category Count</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="category_count" attr="Category-count" id="category_count" value="<?php echo $datalist[0]['category_count']; ?>">
										</div>
									</div>
								</div>

							<div class="form-group" id="quick_link" style="display: none;">
								<button name="add" type="button" id="btn1" class="btn btn-primary center-block mb-3 ml-3">Add Links</button>
								<div class="row">
									<?php $links = json_decode($datalist[0]['link']); 
									foreach($links as $label => $link) { ?>
										<div class="col-sm-6">
											<div class="form-group sub_menu ml-3">
												<div class="row">
													<label class="col-sm-3 control-label mt-2">Label</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" name="label[]" attr="label" id="label" value="<?php echo $label; ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group sub_menu">
												<div class="row">
													<label class="col-sm-3 control-label mt-2">Link</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" name="link[]" attr="link" id="link" value="<?php echo $link; ?>">
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group sub_menu" id="contact_us" style="display: none;">
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Address</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="address" attr="address" id="address" value="<?php echo $datalist[0]['address'];?>">
									</div>
								</div>

								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Phone</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="phone" attr="phone" id="phone" value="<?php echo $datalist[0]['phone'];?>">
									</div>
								</div>

								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">E-mail</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="email" attr="email" id="email" value="<?php echo $datalist[0]['email'];?>">
									</div>
								</div>
							</div>

							<div class="form-group sub_menu" id="follow_us" style="display: none;">
								<?php $social_link = json_decode($datalist[0]['followus_link']); ?>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Facebook</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="facebook" attr="facebook" id="facebook" value="<?php echo $social_link->facebook; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Youtube</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="youtube" attr="youtube" id="youtube" value="<?php echo $social_link->youtube; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Instagram</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="instagram" attr="instagram" id="instagram" value="<?php echo $social_link->instagram; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Twitter</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="twitter" attr="twitter" id="twitter" value="<?php echo $social_link->twitter; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Whatsapp</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="whatsapp" attr="whatsapp" id="whatsapp" value="<?php echo $social_link->whatsapp; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Telegram</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="telegram" attr="telegram" id="telegram" value="<?php echo $social_link->telegram; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Snapchat</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="snapchat" attr="snapchat" id="snapchat" value="<?php echo $social_link->snapchat; ?>">
									</div>
								</div>
								<div class="form-group sub_menu">
									<label class="col-sm-3 control-label">Pinterest</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="pinterest" attr="pinterest" id="pinterest" value="<?php echo $social_link->pinterest; ?>">
									</div>
								</div>
							</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">Page Status</label>
									<div class="col-sm-9">
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="academy_status1" value="1" name="status" <?php if ($value['status'] == 1) { echo 'checked=""'; } ?>>
											<label for="academy_status1">Active</label>
										</div>
										<div class="radio radio-danger radio-inline">
											<input type="radio" id="academy_status2" value="0" name="status" <?php if ($value['status'] == 0) { echo 'checked=""'; } ?>>
											<label for="academy_status2">Inactive</label>
										</div>
									</div>
								</div>
								<div class="m-t-30 text-center">
									<?php if($user_role==1) { ?>
										<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
									<?php } ?>
									<a href="<?php echo $base_url; ?>admin/footer_submenu"  class="btn btn-primary">Cancel</a>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>