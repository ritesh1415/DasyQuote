<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title bg-dark text-white shadow-lg" style="text-align:center"> User Quote </h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="shadow-lg rounded bg-body card ">
					<div class="card-body">
					<?php foreach ($qanswers as $row): ?>
						<form id="add_user" method="post" autocomplete="off" enctype="multipart/form-data">
						<div class="form-group">
								<h3 class="bg-gray"><?= $row->name ?></h3>
								
							</div>
							<input type="hidden" name="id" value="<?php echo (!empty($user['id']))?$user['id']:''?>" id="user_id">
							<input type="hidden" id="user_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
    
							<div class="form-group">
								<label class=" ">What is Event Duration ?</label>
								<lable class="form-control  " type="text"  name="name" id="name" value=""><?= $row->answers1?></label>
							</div>
							<div class="form-group">
								<?php $mob_no = '+'.!empty($user['country_code']).!empty($user['mobileno']); ?>

								<label>What is Event date ?</label><br>
								<label class="form-control no_only mobileno " type="text" name="mobileno" id="mobileno" value=""><?= $row->answers2?></label>
							</div>
							<div class="form-group">
								<label>Number of guests?</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers3?></label>
							</div>
							<div class="form-group">
								<label>Where is event?</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers4?></label>
							</div>

							<!-- <div class="form-group">
								<label>Selected service</label>
								<input type="checkbox" class="custom-control-input" id="ck2b" name="q5">
							</div> -->
							<div class="form-group">
							<h3 class="page-title bg-dark text-white shadow-lg" style="text-align:center"> Already Replied </h3>
							</div>
							
							<div class="form-group">
								<label>ID</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers4?></label>
							</div>
							<div class="form-group">
								<label>Quote Price</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers4?></label>
							</div>
							<div class="form-group">
								<label>Message</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers4?></label>
							</div>
							<div class="form-group">
								<label>Time</label>
								<label class="form-control " type="text"  name="email" id="email" value=""><?= $row->answers4?></label>
							</div>
							<div class="form-group">
								
									<div class="mt-4">
								<!-- <?php if($user_role==1){?>
								<button class="btn btn-primary " name="form_submit" value="submit" type="submit">Submit</button>
							 <?php }?> -->

								<a href="<?php echo $base_url; ?>prof-quotelist"  class="btn btn-primary btn-cancel">Back</a>
								<!-- <a href="<?php echo $base_url; ?>#exampleModal" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-cancel">Reply</a> -->

							</div>
						</form>
						<?php endforeach; ?>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
</div>
<!-- //reply to user -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reply To Customer's Quote</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url() ?>insert-quotationReply" method="post">
		<!-- hidden inputs -->
		
		      
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Quote Price:</label>
            <input type="text" class="form-control" id="recipient-name" name="quote_price">
			<input type="hidden" name="quoteId" value="<?= $this->uri->segment(3) ?>">
			
			
              <input type="hidden" name="provider_id" value="<?= $provider_id ?>">
            
              <!-- <input type="hidden" name="provider_id" value="<?= $provider['id'] ?>"> -->
            </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text" name="message"></textarea>
          </div>
		  <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  <!-- <a class="btn btn-primary" href="<?= base_url() ?>insert-quotationReply">Submit Quote</a> -->
              <button type="submit" class="btn btn-primary" >Submit Quote</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- //reply to user -->

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
				<form class="avatar-form" action="<?php echo base_url('admin/dashboard/crop_profile_img/'.$curprofile_img)?>" enctype="multipart/form-data" method="post">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
					<div class="avatar-body">
						<!-- Upload image and data -->
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput">Select Image</label>
							<input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/*">
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