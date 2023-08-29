<?php
	$query = $this->db->query("select * from system_settings WHERE status = 1");
	$result = $query->result_array();
	if(!empty($result))
		{
		foreach($result as $data){
			if($data['key'] == 'currency_option'){
				$currency_option = $data['value'];
			}
		}
	}

	if(!empty($service)) {
		foreach ($service as $srows) {
			$provider_details = $this->db->where('id',$srows['user_id'])->get('providers')->row_array();
			$serviceimage=explode(',', $srows['service_image']);

			$this->db->select('AVG(rating)');
			$this->db->where(array('service_id'=>$srows['id'],'status'=>1));
			$this->db->from('rating_review');
			$rating = $this->db->get()->row_array();
			$avg_rating = round($rating['AVG(rating)'],1);
            $this->db->select('id,user_id,status,service_id');
            $this->db->where('user_id', $this->session->userdata('id'));
            $this->db->where('provider_id', $srows['user_id']);
            $this->db->where('service_id', $srows['id']);
            $this->db->from('user_favorite');
            $query = $this->db->get();

            if($query !== FALSE && $query->num_rows() > 0){
                $user_fav = $query->row_array();
            }
			$service_amount = $srows['service_amount'];
			$userId = $this->session->userdata('id');
			If (empty($userId)) {
			$user_currency_code = settings('currency');
			$service_currency_code = $srows['currency_code'];
			$service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
			}
            if (is_nan($service_amount) || is_infinite($service_amount)) {
                $service_amount = $srows['service_amount'];
            }
			$serviceimages=$this->db->where('service_id',$srows['id'])->get('services_image')->row_array();
			
            $placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
			
		?>
		
                                <div class="col-lg-4 col-md-6">
                                    <div class="service-widget">
                                        <div class="service-img">
                                            <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>">
                                                <?php if (!empty($serviceimages['service_image']) && (@getimagesize(base_url().$serviceimages['service_image']))) { ?>
                                                    <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $serviceimages['service_image']; ?>">
                                                <?php } else { ?>
                                                    <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376248_user.jpg'; ?>">
                                                <?php } ?>
                                            </a>
                                            <div class="item-info">
                                                <div class="service-user">
                                                    <a href="#">
                                                        <?php if ($provider_details['profile_img'] != '' && (@getimagesize(base_url().$provider_details['profile_img']))) { ?>
                                                            <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                        <?php } else { ?>
														    <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                            
                                                        <?php } ?>
                                                    </a>
                                                    <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                                </div>
                                                <div class="cate-list"> <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>
                                            </div>
                                        </div>
                                        <div class="service-content">
                                            <h3 class="title">
                                                <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>"><?php echo ucfirst($srows['service_title']); ?></a>
                                                <?php    
                                                
                                                if($this->session->userdata('usertype') != "provider") {
                                                    if($userId && ($userId == $user_fav['user_id']) && $user_fav['service_id'] == $srows['id']) {
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
else { 
	echo '<div class="col-lg-12">
		<p class="mb-0">No Services Found</p>
	</div>';
} 
echo $this->ajax_pagination->create_links();
?>
		<script src="<?php echo base_url();?>assets/js/functions.js"></script>