<div class="content">
	<div class="container">
		<div class="row">
            <div class="col-lg-12">
				<div class="section-header text-center">
					<h2>Featured Services</h2>
				</div>
				<div class="row">
					<?php 
					$placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
					if(!empty($services)){
						foreach ($services as $srows) {
						$mobile_image=explode(',', $srows['mobile_image']);
						$this->db->select("service_image");
						$this->db->from('services_image');
						$this->db->where("service_id",$srows['id']);
						$this->db->where("status",1);
						$image = $this->db->get()->row_array(); 
                        
						$user_currency_code = '';
                        $userId = $this->session->userdata('id');
                        If (!empty($userId)) {
                            $service_amount = $srows['service_amount'];
                            $type = $this->session->userdata('usertype');
                            if ($type == 'user') {
                                $user_currency = get_user_currency();
                            } else if ($type == 'provider') {
                                $user_currency = get_provider_currency();
                            }
                            $user_currency_code = $user_currency['user_currency_code'];

                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                        } else {
                            $user_currency_code = settings('currency');
                            $service_currency_code = $srows['currency_code'];
                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                        }
                        if (is_nan($service_amount) || is_infinite($service_amount)) {
                            $service_amount = $srows['service_amount'];
                        }
					?>
					<div class="col-lg-4 col-md-6">
                        <div class="service-widget">
                            <div class="service-img">
                                <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>">
                                    <?php if (!empty($image['service_image'])) { ?>
                                        <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>">
                                    <?php } else { ?>
                                        <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376248_user.jpg'; ?>">
                                    <?php } ?>
                                </a>
                                <div class="item-info">
                                    <div class="service-user">
                                        <a href="#">
                                            <?php if ($provider_details['profile_img'] != '') { ?>
                                                <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                            <?php } else { ?>
											    <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                
                                            <?php } ?>
                                        </a>
                                        <span class="service-price"><?php echo currency_code_sign($user_currency_code) . $service_amount; ?></span>
                                    </div>
                                    <div class="cate-list"> <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>
                                </div>
                            </div>
                            <div class="service-content">
                                <h3 class="title">
                                    <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>"><?php echo ucfirst($srows['service_title']); ?></a>
                                    <?php      
                                    if($this->session->userdata('usertype') != "provider") {
                                        if($userId && ($userId == $user_fav['user_id'])) {
                                            if($user_fav['status'] == 1) { ?>
                                                <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting" style="float: right;color:#007bff" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="0" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart filled"></i></a>
                                            <?php } 
                                            else { ?>
                                                <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting" style="float: right;" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="1" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart"></i></a>
                                            <?php } 
                                        } else { ?>
                                            <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting" style="float: right;" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $this->session->userdata('id');?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="1" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart"></i></a>
                                        <?php }
                                    }
                                    ?>
                                </h3>
                                <div class="rating">
                                    <?php
                                    for ($x = 1; $x <= $avg_rating; $x++) {
                                        echo '<i class="fas fa-star filled"></i>';
                                    }
                                    if (strpos($avg_rating, '.')) {
                                        echo '<i class="fas fa-star"></i>';
                                        $x++;
                                    }
                                    while ($x <= 5) {
                                        echo '<i class="fas fa-star"></i>';
                                        $x++;
                                    }
                                    ?>
                                    <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                </div>
                                <div class="user-info">

                                    <div class="row">
                                        <?php if ($this->session->userdata('id') != '') {
                                            ?>
                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                        <?php } else { ?>
                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                        <?php } ?>

                                        <span class="col ser-location"><span><?php echo ucfirst($srows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					<?php } }
					else{
						echo '<h3>No Services Found</h3>';
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
   

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal-dialog-centered">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="acc_title"></h5>
			</div>
			<div class="modal-body">
				<p id="acc_msg"></p>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-success si_accept_confirm">Yes</a>
				<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
