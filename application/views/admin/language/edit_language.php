<div class="page-wrapper">
	<div class="content container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h4 class="page-title m-b-20 m-t-0">App-keyword Edit</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card-box">

                            <form action="<?php echo base_url().'edit-language/' . $pages->p_id; ?>" method="POST" enctype="multipart/form-data">
                            	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                            <div class="form-group">
                                <label>Page Title</label>
                                <input type="text" class="form-control" name="page_title" id="page_title" required value="<?php echo $pages->page_title;?>">
                                <input class="form-control" type="hidden" value="<?php echo $pages->p_id;?>"  name="id" id="id">
                            </div>
                            
                                <div class="m-t-30 text-center">
                                    <?php if($user_role==1) { ?>
                                    <button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
                                    <?php } ?>
                                    <a href="<?php echo $base_url; ?>app_page_list"  class="btn btn-primary">Cancel</a>
                                </div>
                            </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>