
<!-- sorting -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 theiaStickySidebar">
                <div class="card filter-card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo (!empty($user_language[$user_selected]['lg_Search_Filter'])) ? $user_language[$user_selected]['lg_Search_Filter'] : $default_language['en']['lg_Search_Filter']; ?></h4>
                        <form id="search_form">

                            <div class="filter-widget">
                                <div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_Keyword'])) ? $user_language[$user_selected]['lg_Keyword'] : $default_language['en']['lg_Keyword']; ?></h4>
                                    <input type="text" id="common_search" value="<?php if (isset($_POST["common_search"]) && !empty($_POST["common_search"])) echo $_POST["common_search"]; ?>" class="form-control common_search" placeholder="<?php echo (!empty($user_language[$user_selected]['lg_what_you_look'])) ? $user_language[$user_selected]['lg_what_you_look'] : $default_language['en']['lg_what_you_look']; ?>" />
                                </div>
                                <div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?></h4>
                                    <select id="sort_by" class="form-control selectbox select">
                                        <option value=""><?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?></option>
                                        <option value="1"><?php echo (!empty($user_language[$user_selected]['lg_Price_Low_High'])) ? $user_language[$user_selected]['lg_Price_Low_High'] : $default_language['en']['lg_Price_Low_High']; ?></option>
                                        <option value="2"><?php echo (!empty($user_language[$user_selected]['lg_Price_High_Low'])) ? $user_language[$user_selected]['lg_Price_High_Low'] : $default_language['en']['lg_Price_High_Low']; ?></option>
                                        <option value="3"><?php echo (!empty($user_language[$user_selected]['lg_Newest'])) ? $user_language[$user_selected]['lg_Newest'] : $default_language['en']['lg_Newest']; ?></option>
                                    </select>
                                </div>
                                <div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_category_name'])) ? $user_language[$user_selected]['lg_category_name'] : $default_language['en']['lg_category_name']; ?></h4>
                                    <select id="categories" class="form-control form-control selectbox select">
                                        <option value=""><?php echo (!empty($user_language[$user_selected]['lg_all_categories'])) ? $user_language[$user_selected]['lg_all_categories'] : $default_language['en']['lg_all_categories']; ?></option>
                                        <?php
                                        foreach ($category as $crows) {
                                            $selected = '';
                                            if (isset($category_id) && !empty($category_id)) {
                                                if ($crows['id'] == $category_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                            echo'<option value="' . $crows['id'] . '" ' . $selected . '>' . $crows['category_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
								<div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_Sub_Category'])) ? $user_language[$user_selected]['lg_Sub_Category'] : $default_language['en']['lg_Sub_Category']; ?></h4>
                                    <select id="subcategories" class="form-control form-control selectbox select">
                                        <option value=""><?php echo (!empty($user_language[$user_selected]['lg_Choose_the_Sub_Category'])) ? $user_language[$user_selected]['lg_Choose_the_Sub_Category'] : $default_language['en']['lg_Choose_the_Sub_Category']; ?></option>
                                        <?php
                                        foreach ($subcategory as $crows) {
                                            $selected = '';
                                            if (isset($subcategory_id) && !empty($subcategory_id)) {
                                                if ($crows['id'] == $subcategory_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                            echo'<option value="' . $crows['id'] . '" ' . $selected . '>' . $crows['subcategory_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_Location'])) ? $user_language[$user_selected]['lg_Location'] : $default_language['en']['lg_Location']; ?></h4>
                                    <input class="form-control" type="text" id="service_location" value="<?php if (isset($_POST["user_address"]) && !empty($_POST["user_address"])) echo $_POST["user_address"]; ?>" placeholder="Search Location" name="user_address" >
                                    <input type="hidden" value="<?php if (isset($_POST["user_latitude"]) && !empty($_POST["user_latitude"])) echo $_POST["user_latitude"]; ?>" id="service_latitude">
                                    <input type="hidden" value="<?php if (isset($_POST["user_longitude"]) && !empty($_POST["user_longitude"])) echo $_POST["user_longitude"]; ?>" id="service_longitude">
                                </div>
                                <div class="filter-list">
                                    <h4 class="filter-title"><?php echo (!empty($user_language[$user_selected]['lg_Price_Range'])) ? $user_language[$user_selected]['lg_Price_Range'] : $default_language['en']['lg_Price_Range']; ?></h4>
                                    <div class="price-ranges">
                                        <!-- <?php
                                        $user_currency_code = '';
                                        $userId = $this->session->userdata('id');
                                        If (!empty($userId)) {
                                            $type = $this->session->userdata('usertype');
                                            if ($type == 'user') {
                                                $user_currency = get_user_currency();
                                            } else if ($type == 'provider') {
                                                $user_currency = get_provider_currency();
                                            }
                                            $user_currency_code = $user_currency['user_currency_code'];
                                            } else {
                                            $user_currency_code = settings('currency');
                                            }
                                        ?> -->
                                        <?php echo currency_conversion($user_currency_code); ?><span class="from d-inline-block" id="min_price"><?php echo $min_price['service_amount'] ?></span> -
                                        <?php echo currency_conversion($user_currency_code); ?><span class="to d-inline-block" id="max_price"><?php echo $max_price['service_amount'] ?></span>
                                    </div>	
                                    <div class="range-slider price-range"></div>										
                                </div>
                            </div>
                            <button class="btn btn-primary pl-5 pr-5 btn-block get_services" type="button"><?php echo (!empty($user_language[$user_selected]['lg_search'])) ? $user_language[$user_selected]['lg_search'] : $default_language['en']['lg_search']; ?></button>
                        </form>	
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
            <div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
            
			<div class="col-xl-8 offset-xl-2">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">My Quote </h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="card">
					<div class="card-body">
					<?php foreach ($qanswers as $row): ?>
						<form id="add_user" method="post" autocomplete="off" enctype="multipart/form-data">
						<div class="form-group">
								<h3><?= $row->name ?></h3>
								
							</div>
							<input type="hidden" name="id" value="<?php echo (!empty($user['id']))?$user['id']:''?>" id="user_id">
							<input type="hidden" id="user_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
    
							<div class="form-group">
								<label>What is Event Duration ?</label>
								<input class="form-control" type="text"  name="name" id="name" value="<?= $row->answers1?>">
							</div>
							<div class="form-group">
								<?php $mob_no = '+'.!empty($user['country_code']).!empty($user['mobileno']); ?>

								<label>What is Event date ?</label><br>
								<input class="form-control no_only mobileno" type="text" name="mobileno" id="mobileno" value="<?= $row->answers2?>">
							</div>
							<div class="form-group">
								<label>Number of guests?</label>
								<input class="form-control" type="text"  name="email" id="email" value="<?= $row->answers3?>">
							</div>
							<div class="form-group">
								<label>Where is event?</label>
								<input class="form-control" type="text"  name="email" id="email" value="<?= $row->answers4?>">
							</div>
							<div class="form-group">
								<label>Selected service</label>
								<input type="checkbox" class="custom-control-input" id="ck2b" name="q5">
								<!-- fetching services -->
								<?php
                            if (!empty($services)) {
                                foreach ($services as $srows) {


                                    $this->db->select("service_image");
                                    $this->db->from('services_image');
                                    $this->db->where("service_id", $srows['id']);
                                    $this->db->where("status", 1);
                                    $image = $this->db->get()->row_array();

                                    $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();


                                    $this->db->select('AVG(rating)');
                                    $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                    $this->db->from('rating_review');
                                    $rating = $this->db->get()->row_array();
                                    $avg_rating = round($rating['AVG(rating)'], 1);

                                    $user_currency_code = '';
                                    $userId = $this->session->userdata('id');
                                    if (!empty($userId)) {
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
                                    <div class="service-widget">
                                        <div class="service-img">
                                            <a
                                                href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>">

                                                <?php if ($image['service_image'] != '' && (@getimagesize(base_url() . $image['service_image']))) { ?>
                                                    <img class="img-fluid serv-img" alt="Service Image"
                                                        src="<?php echo base_url() . $image['service_image']; ?>" alt="">
                                                <?php } else { ?>
                                                    <img class="img-fluid serv-img" alt="Service Image"
                                                        src="<?php echo ($placholder_img) ? $placholder_img : base_url() . 'uploads/placeholder_img/1641376256_banner.jpg'; ?>">
                                                <?php } ?>

                                            </a>
                                            <div class="item-info">
                                                <div class="service-user">
                                                    <a href="#">
                                                        <?php if ($provider_details['profile_img'] != '' && (@getimagesize(base_url() . $provider_details['profile_img']))) { ?>
                                                            <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/img/user.jpg">

                                                        <?php } ?>
                                                    </a>
                                                    <span class="service-price">
                                                        <?php echo currency_conversion($user_currency_code) . $service_amount; ?>
                                                    </span>
                                                </div>
                                                <div class="cate-list">
                                                    <a class="bg-yellow"
                                                        href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="service-content">
                                            <h3 class="title">
                                                <a
                                                    href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>"><?php echo ucfirst($srows['service_title']); ?></a>
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
                                                <span class="d-inline-block average-rating">(
                                                    <?php echo $avg_rating ?>)
                                                </span>
                                            </div>
                                            <div class="user-info">

                                                <div class="row">
                                                    <?php if ($this->session->userdata('id') != '') {
                                                        ?>
                                                        <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx
                                                                <?= rand(00, 99) ?>
                                                            </span></span>
                                                    <?php } else { ?>
                                                        <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx
                                                                <?= rand(00, 99) ?>
                                                            </span></span>
                                                    <?php } ?>
                                                    <span class="col ser-location"><span>
                                                            <?php echo ucfirst($srows['service_location']); ?>
                                                        </span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {

                                echo '<div>	
									<p class="mb-0">' . (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : $default_language["en"]["lg_no_service"];
                                '</p>
								</div>';
                            }
                            ?>
								<!-- end fetching -->
							</div>
							<div class="form-group">
								
									<div class="mt-4">
								<!-- <?php if($user_role==1){?>
								<button class="btn btn-primary " name="form_submit" value="submit" type="submit">Submit</button>
							 <?php }?> -->

								<a href="<?php echo $base_url; ?>myquote-list"  class="btn btn-primary btn-cancel">Cancel</a>
							</div>
						</form>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

                <!-- <div class="row align-items-center mb-4">
                    <div class="col-md-6 col">
                        <h4><span id="service_count"><?php echo $count; ?></span> <?php echo (!empty($user_language[$user_selected]['lg_Services_Found'])) ? $user_language[$user_selected]['lg_Services_Found'] : $default_language['en']['lg_Services_Found']; ?></h4>
                    </div>
                    <div class="col-md-6 col-auto">
                        <div class="view-icons ">
                            <a href="javascript:void(0);" class="grid-view active"><i class="fas fa-th-large"></i></a>
                        </div>

                    </div>
                </div> -->
                <div>
                    <div class="row" id="dataList">

                        <?php

                        if (!empty($service)) {
                            foreach ($service as $srows) {

                                $serviceimage = explode(',', $srows['service_image']);

                                $serviceimages = $this->db->where('service_id', $srows['id'])->get('services_image')->row_array();

                                $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();

                                $this->db->select('AVG(rating)');
                                $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                $this->db->from('rating_review');
                                $rating = $this->db->get()->row_array();
                                $avg_rating = round($rating['AVG(rating)'], 1);
                                $this->db->select('id,user_id,status,service_id');
                                $this->db->where('user_id', $this->session->userdata('id'));
                                $this->db->where('provider_id', $srows['user_id']);
                                $this->db->where('service_id', $srows['id']);
                                $this->db->from('user_favorite');
                                $query = $this->db->get();

                                if($query !== FALSE && $query->num_rows() > 0){
                                    $user_fav = $query->row_array();
                                }
                                

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
                                                            <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting" style="float: right;color:#ff0080" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="0" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart filled"></i></a>
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
                                <?php
                            }
                        } else {

                            // echo '<div class="col-lg-12">
							// 		<p class="mb-0">
							// 			No Services Found
							// 		</p>
							// 	</div>';
                        }

                        echo $this->ajax_pagination->create_links();
                        ?>



                    </div>
                </div>

            </div>					
        </div>
    </div>
</div>
<!-- //my quote part -->


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