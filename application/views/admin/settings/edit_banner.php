<div class="page-wrapper">
	<div class="content container-fluid">
	
		<div class="row">
			<div class="col-xl-8 offset-xl-2">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Edit Banner</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="card">
					<div class="card-body">
                        <form id="update_banner" method="post" autocomplete="off" enctype="multipart/form-data">
                        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<input class="form-control" type="hidden" name="bgimg_for" value="<?=$list['bgimg_for']?>" id="bgimg_for">
							<?php
							if($list['bgimg_for']=='banner'){
								$tile = 'Banner';
								$imgnote='image size for banner should be 1400 x 500';
							}
							if($list['bgimg_for']=='bottom_image1'){
								$tile = 'Bottom Image-1';
								$imgnote='image size for bottom image-1 should be 120 x 120';
							}
							if($list['bgimg_for']=='bottom_image2'){
								$tile = 'Bottom Image-2';
								$imgnote='image size for bottom image-2 should be 120 x 120';
							}
							if($list['bgimg_for']=='bottom_image3'){
								$tile = 'Bottom Image-3';
								$imgnote='image size for bottom image-3 should be 120 x 120';
							}
							// logo size update by gouresh @17-03-2023
							if($list['bgimg_for']=='art'){
								$tile = 'Art';
								$imgnote='image size for art should be 500 x 300';
							}
							// logo size update by gouresh @17-03-2023
								
								$label= $tile.' Image';
								
							?>
							<div class="form-group">
                                <label><?=$tile?> Content</label>
                                <input class="form-control" type="text" name="banner_content" value="<?=$list['banner_content']?>" id="banner_content">
                            </div>
							
							<div class="form-group">
                                <label><?=$tile?> Sub Content</label>
                                <input class="form-control" type="text" name="banner_sub_content" value="<?=$list['banner_sub_content']?>" id="banner_sub_content">
                            </div>
							
							
                            <div class="form-group">
                                <label><?=$label?></label>
                                <input class="form-control" type="file" name="upload_image" id="upload_image" accept="image/*">
								<div id="" style="color:#d40f0f;">* <?=$imgnote?></div>
								<span class="error img_err"></span>
                            </div>
                            <div class="form-group">
								<div class="avatar">
									<img class="avatar-img rounded" alt="" src="<?php echo base_url().$list['upload_image'];?>">
								</div>
                            </div>
                            <div class="mt-4">
                            	<?php if($user_role==1){?>
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit" >Save Changes</button>
                                <?php } ?>

								<a href="<?php echo $base_url; ?>admin/banner_image"  class="btn btn-cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $base_url; ?>assets/js/jquery-3.6.0.min.js"></script>
<script>
	$('#upload_image').change(function(){
		var title = '<?php echo $tile ?>';
  		var img_size = $('#upload_image')[0].files[0].size;
		if(title == 'Banner') {
			var fileUpload = $("#upload_image")[0];
			var reader = new FileReader();
			reader.readAsDataURL(fileUpload.files[0]);
			reader.onload = function (e) {
			var image = new Image();
			image.src = e.target.result;
			image.onload = function () {
				var height = this.height;
				var width = this.width;
				if (height != 500 || width != 1400) {
					$('.img_err').html('Invalid image size');
					$('#upload_image').val('');
				} else {
					$('.img_err').html('');
				}
			};
		  }
		} else {
			var fileUpload = $("#upload_image")[0];
			var reader = new FileReader();
			reader.readAsDataURL(fileUpload.files[0]);
			reader.onload = function (e) {
			var image = new Image();
			image.src = e.target.result;
			image.onload = function () {
				var height = this.height;
				var width = this.width;
				if (height != 32 || width != 32) {
					$('.img_err').html('Invalid image size');
					$('#upload_image').val('');
				} else {
					$('.img_err').html('');
				}
			};
		  }
			
		}

 });
</script>