<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h4 class="page-title m-b-20 m-t-0">Create Footer Menu</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="card-box">
						
							<div class="form-group">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Widget</label>
								<div class="col-sm-9">
									<select class="form-control" name="main_menu" id="main_menu">
										<?php

										foreach ($main_menu as $main) { ?>
											<option value="<?php echo $main['id']; ?>"><?php echo str_replace('_', ' ', $main['title']); ?></option>
										<?php  }
										?>
									</select>
								</div>
							</div>
							<div class="form-group cate" id="category" style="display: none;">
							<div class="form-group">
								<label class="col-sm-3 control-label">Category-view</label>
								<div class="col-sm-9">
									<select class="form-control" name="category_view" id="category_view">
										<option>Name</option>
										<option>Orderby</option>
										<option>Popular category</option>
										<option>Recent category</option>
									</select>
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Category Count</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="category_count" attr="Category-count" id="category_count" value="">
								</div>
							</div>
							</div>
							<div class="form-group" id="quick_link" style="display: none;">
							
							<button name="add" type="button" id="btn1" class="btn btn-primary center-block mb-3 ml-3">Add Links</button>
							<div class="row">
							<div class="col-sm-6">
							<div class="form-group sub_menu ml-3">
								<div class="row">
								<label class="col-sm-3 control-label mt-2">Label</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="label[]" attr="label" id="label" value="">
								</div>
							</div>
							</div>
							</div>
							<div class="col-sm-6">
							<div class="form-group sub_menu">
								<div class="row">
								<label class="col-sm-3 control-label mt-2">Link</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="link[]" attr="link" id="link" value="">
								</div>
								</div>
							</div>
							</div>
							</div>
							</div>
							<div class="form-group sub_menu" id="contact_us" style="display: none;">
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Address</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="address" attr="address" id="address" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Phone</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="phone" attr="phone" id="phone" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">E-mail</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="email" attr="email" id="email" value="">
								</div>
							</div>
							</div>
							<div class="form-group sub_menu" id="follow_us" style="display: none;">
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Facebook</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="facebook" attr="facebook" id="facebook" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Youtube</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="youtube" attr="youtube" id="youtube" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Instagram</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="instagram" attr="instagram" id="instagram" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Twitter</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="twitter" attr="twitter" id="twitter" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Whatsapp</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="whatsapp" attr="whatsapp" id="whatsapp" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Telegram</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="telegram" attr="telegram" id="telegram" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Snapchat</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="snapchat" attr="snapchat" id="snapchat" value="">
								</div>
							</div>
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Pinterest</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="pinterest" attr="pinterest" id="pinterest" value="">
								</div>
							</div>
							</div>
							<div class="form-group sub_menu" id="hidey" style="display: none;">
							<div class="form-group sub_menu">
								<label class="col-sm-3 control-label">Title</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="sub_menu" id="sub_menu" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Page Content</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="page_desc" id="ck_editor_textarea_id"></textarea>
									<?php echo display_ckeditor($ckeditor_editor1);  ?>
								</div>
							</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Page Status</label>
								<div class="col-sm-9">
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="academy_status1" value="1" name="status" checked="">
										<label for="academy_status1">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="academy_status2" value="0" name="status">
										<label for="academy_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
								<a href="<?php echo $base_url; ?>admin/footer_submenu"  class="btn btn-primary">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>