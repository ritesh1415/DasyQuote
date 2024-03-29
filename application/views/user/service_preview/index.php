<head>
<link rel="stylesheet" href="assets\css\flatpickr.min.css">
<link href="assets\css\styleq.css" rel="stylesheet">
<link href="assets\css\all_icons_min.css" rel="stylesheet">
</head>
<?php
$business_hours = $this->db->where('provider_id', $service['user_id'])->get('business_hours')->row_array();
$availability_details = json_decode($business_hours['availability'], true);
$this->db->select('AVG(rating)');
$this->db->where(array('service_id' => $service['id'], 'status' => 1));
$this->db->from('rating_review');
$rating = $this->db->get()->row_array();
$avg_rating = round($rating['AVG(rating)'], 2);

$this->db->select("r.*,u.profile_img,u.name");
$this->db->from('rating_review r');
$this->db->join('users u', 'u.id = r.user_id', 'LEFT');
$this->db->where(array('r.service_id' => $service['id'], 'r.status' => 1));
$reviews = $this->db->get()->result_array();
$get_details = $this->db->where('id', $this->session->userdata('id'))->get('users')->row_array();
                        

$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
if (!empty($result)) {
    foreach ($result as $data) {
        if ($data['key'] == 'currency_option') {
            $currency_option = $data['value'];
        }
    }
}
$service_amount = $service['service_amount'];
if (!empty($service['user_id'])) {
    $provider_online = $this->db->where('id', $service['user_id'])->from('providers')->get()->row_array();
    $datetime1 = new DateTime();
    $datetime2 = new DateTime($provider_online['last_logout']);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->format('%a');
    $hours = $interval->format('%h');
    $minutes = $interval->format('%i');
    $seconds = $interval->format('%s');
} else {
    $days = $hours = $minutes = $seconds = 0;
}

//user favourite
$this->db->select('id,user_id,status');
$this->db->where('user_id', $this->session->userdata('id'));
$this->db->where('provider_id', $service['user_id']);
$this->db->where('service_id', $service['id']);
$this->db->from('user_favorite');
$query = $this->db->get();

if($query !== FALSE && $query->num_rows() > 0){
    $user_fav = $query->row_array();
}

$placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
?>

<div class="content">
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <div class="service-view">
                    <div class="service-header">
                        <h1><?php echo ucfirst($service['service_title']); ?></h1>
                        <address class="service-location"><i class="fas fa-location-arrow"></i> <?php echo ucfirst($service['service_location']); ?></address>
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
                            <span class="d-inline-block average-rating">(<?php echo $avg_rating; ?>)</span>
                        </div>
                        <div class="service-cate">
                            <a class="cate-link" href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', $service['category_name']); ?>"><?php echo ucfirst($service['category_name']); ?></a>
							                        <?php  
                        if($this->session->userdata('usertype') != "provider") {    
                            $userId = $this->session->userdata('id');
                            if($userId && ($userId == $user_fav['user_id']) && $user_fav['service_id'] == $serv['id'] ) {
                                if($user_fav['status'] == 1) { ?>
                                    <a href="javascript:;" id="ufav" class="fav-link favourited" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $service['user_id']?>" data-servid="<?php echo $service['id']?>" data-favstatus="0" data-pagename="<?php echo $service['category_name']?>" title="Click here to unfavorite the service"><i class="fas fa-heart filled"></i></a>
                                <?php } 
                                else { ?>
                                    <a href="javascript:;" id="ufav" class="fav-link" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $service['user_id']?>" data-servid="<?php echo $service['id']?>" data-favstatus="1" data-pagename="<?php echo $service['category_name']?>"  title="Click here to favorite the service"><i class="fas fa-heart"></i></a>
                                <?php } 
                            } else { ?>
                                <a href="javascript:;" id="ufav" class="fav-link" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $this->session->userdata('id');?>" data-provid="<?php echo $service['user_id']?>" data-servid="<?php echo $service['id']?>" data-favstatus="1" data-pagename="<?php echo $service['category_name']?>" title="Click here to favorite the service"><i class="fas fa-heart"></i></a>
                            <?php } 
                        }?>
                        </div>
                    </div>

                    <div class="service-images service-carousel">
                        <div class="images-carousel owl-carousel owl-theme">
                            <?php
                            if (!empty($service_image)) {
                                for ($i = 0; $i < count($service_image); $i++) {
									if (!empty($service_image[$i]['service_image']) && (@getimagesize(base_url().$service_image[$i]['service_image']))) {
										echo'<div class="item"><img src="' . base_url() . $service_image[$i]['service_image'] . '" alt="" class="img-fluid"></div>';
									}else{
										echo'<div class="item"><img src="'. base_url() .$placholder_img.'" alt="" class="img-fluid"></div>';
									}
                                }
                            } else { ?>
                                <div class="item"><img src="<?php echo base_url().$placholder_img; ?>" alt="" class="img-fluid"></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="service-details">
                        <ul class="nav nav-pills service-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo (!empty($user_language[$user_selected]['lg_Overview'])) ? $user_language[$user_selected]['lg_Overview'] : $default_language['en']['lg_Overview']; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo (!empty($user_language[$user_selected]['lg_Services_Offered'])) ? $user_language[$user_selected]['lg_Services_Offered'] : $default_language['en']['lg_Services_Offered']; ?></a>
                            </li>

                            <!-- created by gouresh video nav 
                            <li class="nav-item">
                                <a class="nav-link" id="pills-videos-tab" data-toggle="pill" href="#pills-videos" role="tab" aria-controls="pills-videos" aria-selected="false">Introduction Video</a>
                            </li>
                            created by gouresh video nav -->
                            <li class="nav-item">
                                <a class="nav-link" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false"><?php echo (!empty($user_language[$user_selected]['lg_Reviews'])) ? $user_language[$user_selected]['lg_Reviews'] : $default_language['en']['lg_Reviews']; ?></a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="card service-description">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_Service_Details'])) ? $user_language[$user_selected]['lg_Service_Details'] : $default_language['en']['lg_Service_Details']; ?></h5>
                                        <p class="mb-0"><?php echo $service['about']; ?></p>
                                    </div>
                                </div>
                            </div>

                           
                             <!-- tab for videos of vendor created gouresh march 23 
                             <div class="tab-pane fade show active" id="pills-videos" role="tabpanel" aria-labelledby="pills-videos-tab">
                                <div class="card service-description">
                                    <div class="card-body">
                                        <h5 class="card-title">hello</h5>
                                        <p class="mb-0"><?php echo $service['about']; ?></p>
                                    </div>
                                </div>
                            </div>
                             tab for videos of vendor created gouresh march 23 -->

                            <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                                <div class="card review-box">
                                    <div class="card-body">
                                        <?php
                                        if (!empty($reviews)) {
                                            foreach ($reviews as $review) {
                                                $full_date =date('Y-m-d H:i:s', strtotime($review['created']));
                                                $date=date('Y-m-d',strtotime($full_date));
                                                $date_f=date('d-m-Y',strtotime($full_date));
                                                $yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
                                                $time=date('H:i',strtotime($full_date));
                                                $session = date('h:i A', strtotime($time));
                                                if($date == date('Y-m-d')){
                                                    $datetime ="Today ".$session;
                                                }elseif($date == $yes_date){
                                                    $datetime ="Yester day ".$session;
                                                }else{
                                                    $datetime =$date_f." ".$session;
                                                }
                                                $avg_ratings = round($review['rating'], 2);
                                                ?>
                                                <div class="review-list">
                                                    <div class="review-img">
                                                        <?php if ($review['profile_img'] == '') { ?>
                                                            <img class="rounded-circle" src="<?php echo base_url(); ?>assets/img/user.jpg" alt="">
                                                        <?php } else { ?>
                                                            <img class="rounded-circle" src="<?php echo base_url() . $review['profile_img'] ?>" alt="">
                                                        <?php } ?>
                                                    </div>
                                                    <div class="review-info">
                                                        <h5><?php echo $review['name'] ?></h5>
                                                        <div class="review-date"><?php echo $datetime; ?></div>
                                                        <p class="mb-0"><?php echo $review['review'] ?></p>
                                                    </div>
                                                    <div class="review-count">
                                                        <div class="rating">
                                                            <?php
                                                            for ($x = 1; $x <= $avg_ratings; $x++) {
                                                                echo '<i class="fas fa-star filled"></i>';
                                                            }
                                                            if (strpos($avg_ratings, '.')) {
                                                                echo '<i class="fas fa-star"></i>';
                                                                $x++;
                                                            }
                                                            while ($x <= 5) {
                                                                echo '<i class="fas fa-star"></i>';
                                                                $x++;
                                                            }
                                                            ?>	
                                                            <span class="d-inline-block average-rating">(<?php echo $review['rating'] ?>)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <span><?php echo (!empty($user_language[$user_selected]['lg_No_reviews'])) ? $user_language[$user_selected]['lg_No_reviews'] : $default_language['en']['lg_No_reviews']; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <h4 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_Related_Services'])) ? $user_language[$user_selected]['lg_Related_Services'] : $default_language['en']['lg_Related_Services']; ?></h4>

                <div class="service-carousel">
                    <div class="popular-slider owl-carousel owl-theme">
                        <?php
                        foreach ($popular_service as $key => $serv) {

                            $mobile_image = explode(',', $serv['mobile_image']);
                            $this->db->select("service_image");
                            $this->db->from('services_image');
                            $this->db->where("service_id", $serv['id']);
                            $this->db->where("status", 1);
                            $image = $this->db->get()->row_array();

							$provider_details = $this->db->where('id', $serv['user_id'])->get('providers')->row_array();
                            $user_currency_code = '';
                            $userId = $this->session->userdata('id');
                            If (!empty($userId)) {
                                $service_amount12 = $serv['service_amount'];
                                $type = $this->session->userdata('usertype');
                                if ($type == 'user') {
                                    $user_currency = get_user_currency();
                                } else if ($type == 'provider') {
                                    $user_currency = get_provider_currency();
                                }
                                $user_currency_code = $user_currency['user_currency_code'];
                                $service_amount12 = get_gigs_currency($serv['service_amount'], $serv['currency_code'], $user_currency_code);
                            } else {
                                $user_currency_code = settings('currency');
                                $service_amount12 = get_gigs_currency($serv['service_amount'], $serv['currency_code'], $user_currency_code);
                            }
                            if (is_nan($service_amount12) || is_infinite($service_amount12)) {
                                $service_amount12 = $serv['service_amount'];
                            }
                            ?>

                            <div class="service-widget">
                                <div class="service-img">
                                    <a href="<?php echo base_url() . 'service-preview/' . $serv['id'] . '?sid=' . md5($serv['id']); ?>">
									
										<?php if (!empty($image['service_image']) && (@getimagesize(base_url().$image['service_image']))) { ?>
											<img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>">
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
                                            <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount12; ?></span>
                                        </div>
                                        <div class="cate-list"> <a class="bg-yellow" href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', $serv['category_name']); ?>"><?= ucfirst($serv['category_name']); ?></a></div>
                                    </div>
                                </div>
                                <div class="service-content">
                                     <h3 class="title">
                                                <a href="<?php echo base_url() . 'service-preview/' . $serv['id'] . '?sid=' . md5($serv['id']); ?>"><?php echo ucfirst($serv['service_title']); ?></a>
                                                <?php    
                                                
                                                if($this->session->userdata('usertype') != "provider") {
                                                    if($userId && ($userId == $user_fav['user_id']) && $user_fav['service_id'] == $serv['id']) {
                                                        if($user_fav['status'] == 1) { ?>
                                                            <a href="javascript:;" id="ufav<?=$serv['id']?>" class="hearting" style="float: right;color:#007bff" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $serv['user_id']?>" data-servid="<?php echo $serv['id']?>" data-favstatus="0" data-pagename="<?php echo $serv['category_name']?>"><i class="fas fa-heart filled"></i></a>
                                                        <?php } 
                                                        else { ?>
                                                            <a href="javascript:;" id="ufav<?=$serv['id']?>" class="hearting" style="float: right;" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $serv['user_id']?>" data-servid="<?php echo $serv['id']?>" data-favstatus="1" data-pagename="<?php echo $serv['category_name']?>"><i class="fas fa-heart"></i></a>
                                                        <?php } 
                                                    } else { ?>
                                                        <a href="javascript:;" id="ufav<?=$serv['id']?>" class="hearting" style="float: right;" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $this->session->userdata('id');?>" data-provid="<?php echo $serv['user_id']?>" data-servid="<?php echo $serv['id']?>" data-favstatus="1" data-pagename="<?php echo $serv['category_name']?>"><i class="fas fa-heart"></i></a>
                                                    <?php }
                                                }
                                                ?>
                                            </h3>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="d-inline-block average-rating">(0)</span>
                                    </div>
                                    <div class="user-info">
                                        <div class="row">
                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                            
                                            <span class="col ser-location" title="Address"><span><?= $serv['service_location']; ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            $user_currency_code = '';
            $userId = $this->session->userdata('id');
            $user_details = $this->db->where('id', $userId)->get('users')->row_array();
            If (!empty($userId)) {
                $service_amount = $service['service_amount'];
                $type = $this->session->userdata('usertype');
                if ($type == 'user') {
                    $user_currency = get_user_currency();
                } else if ($type == 'provider') {
                    $user_currency = get_provider_currency();
                }
                $user_currency_code = $user_currency['user_currency_code'];

                $service_amount = get_gigs_currency($service['service_amount'], $service['currency_code'], $user_currency_code);
            } else {
                $user_currency_code = settings('currency');
                $service_currency_code = $service['currency_code'];
                $service_amount = get_gigs_currency($service['service_amount'], $service['currency_code'], $user_currency_code);
            }
            
            if (is_nan($service_amount) || is_infinite($service_amount)) {
                $service_amount = $service['service_amount'];
            }
            ?>
            <div class="col-lg-4 theiaStickySidebar">
                <div class="sidebar-widget widget">
                    <div class="service-amount">
                        <span><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                    </div>
                    <div class="service-book">
                        <?php
                        $val = $this->db->select('*')->from('book_service')->where('service_id', $service['id'])->where('user_id', $this->session->userdata('id'))->order_by('id', 'DESC')->get()->row();
                        $userId = $this->session->userdata('id');
                        $usertype = $this->session->userdata('usertype');
                        $token = $this->session->userdata('chat_token');

                        if (!empty($userId)) {
                            if (!empty($usertype) && $usertype == 'user') {

                                $type = $this->session->userdata('usertype');
                                if ($type == 'user') {
                                    $user_currency = get_user_currency();
                                } else if ($type == 'provider') {
                                    $user_currency = get_provider_currency();
                                }
                                $user_currency_code = $user_currency['user_currency_code'];

                                $service_amount = get_gigs_currency($service['service_amount'], $service['currency_code'], $user_currency_code);

                                $where = [
                                    'token' => $token
                                ]; ?>
                                <!-- <a href="javascript:void(0);" class="btn btn-primary" data-toggle="tab" data-target="#tab1"> Request Quote </a> -->
                                <div class="dropdown show">
              <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               Get a quote
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <div class="request">
                <a class="dropdown-item" href="#tab_1" data-toggle="tab">DJ</a>
                                </div>
                                <div class="request1">
                <a class="dropdown-item" href="#tab_2" data-toggle="tab">Makeup Artist</a>
                                </div>
                                <div class="request2">
                <a class="dropdown-item" href="#tab_3" data-toggle="tab">Chair / Table Decoration</a>
                                </div>
                                <div class="request3">
                <a class="dropdown-item" href="#tab_4" data-toggle="tab">Event Organizer</a>
                                </div>
                                <div class="request4">
                <a class="dropdown-item" href="#tab_5" data-toggle="tab">Photographer</a>
                                </div>
                                <div class="request5">
                <a class="dropdown-item" href="#tab_6" data-toggle="tab">Master Of Ceremony</a>
                                </div>
              </div>
            </div>
                                <button class="btn btn-primary" type="button" id="go_book_service" data-id="<?php echo $service['id'] ?>" ><?php echo (!empty($user_language[$user_selected]['lg_Book_Service'])) ? $user_language[$user_selected]['lg_Book_Service'] : $default_language['en']['lg_Book_Service']; ?> </button>
                                

                                <?php
                            }
                        } else {
                            ?>
                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="tab" data-target="#tab1"> Request Quote </a><br>
                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#modal-wizard1"> <?php echo (!empty($user_language[$user_selected]['lg_Book_Service'])) ? $user_language[$user_selected]['lg_Book_Service'] : $default_language['en']['lg_Book_Service']; ?> </a>
                        <?php } ?>
                        <?php
                        if (!empty($this->session->userdata('id'))) {
                            if ($service['user_id'] == $this->session->userdata('id')) {
                                if ($this->session->userdata('usertype') != 'user') {
                                    ?>
                                    <a href="<?php echo base_url() . 'user/service/edit_service/' . $service['id'] ?>" class="btn btn-primary" > <?php echo (!empty($user_language[$user_selected]['lg_Edit_Service'])) ? $user_language[$user_selected]['lg_Edit_Service'] : $default_language['en']['lg_Edit_Service']; ?> </a>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="card provider-widget clearfix">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_Service_Provider'])) ? $user_language[$user_selected]['lg_Service_Provider'] : $default_language['en']['lg_Service_Provider']; ?></h5>
                        <?php
                        if (!empty($service['user_id'])) {
                            $provider = $this->db->select('*')->
                                            from('providers')->
                                            where('id', $service['user_id'])->
                                            get()->row_array();
                            ?>

                            <div class="about-author">
                                <div class="about-provider-img">
                                    <div class="provider-img-wrap">
                                        <?php
                                        if (file_exists($provider['profile_img'])) {
                                            $image = base_url() . $provider['profile_img'];
                                        } else {
                                            $image = base_url() . 'assets/img/user.jpg';
                                        }
                                        ?>
                                        <a href="javascript:void(0);"><img class="img-fluid rounded-circle" alt="" src="<?php echo $image; ?>"></a>
                                    </div>
                                </div>

                                <div class="provider-details">
                                    <a href="javascript:void(0);" class="ser-provider-name"><?= !empty($provider['name']) ? $provider['name'] : '-'; ?></a>
                                    <p class="last-seen"> 
                                        <?php if ($provider_online['is_online'] == 2) { ?>
                                            <i class="fas fa-circle"></i> <?php echo (!empty($user_language[$user_selected]['lg_last_seen'])) ? $user_language[$user_selected]['lg_last_seen'] : $default_language['en']['lg_last_seen']; ?>: &nbsp;
                                            <?= (!empty($days)) ? $days . ' "'.(!empty($user_language[$user_selected]['lg_days'])) ? $user_language[$user_selected]['lg_days'] : $default_language['en']['lg_days'].'"' : ''; ?> 
                                            <?php if ($days == 0) { ?>
                                                <?= (!empty($hours)) ? $hours . (!empty($user_language[$user_selected]['lg_hours'])) ? $user_language[$user_selected]['lg_hours'] : $default_language['en']['lg_hours'] : ''; ?>
                                            <?php } ?>
                                            <?php if ($days == 0 && $hours == 0) { ?>
                                                <?= (!empty($minutes)) ? $minutes . (!empty($user_language[$user_selected]['lg_mints'])) ? $user_language[$user_selected]['lg_mints'] : $default_language['en']['lg_mints'] : ''; ?>
                                            <?php } ?>
                                            <?php echo (!empty($user_language[$user_selected]['lg_ago'])) ? $user_language[$user_selected]['lg_ago'] : $default_language['en']['lg_ago']; ?>
                                        </p>
                                    <?php } elseif ($provider_online['is_online'] == 1) { ?>
                                        <i class="fas fa-circle online"></i> Online</p>
                                    <?php } ?>
                                    <p class="text-muted mb-1"><?php echo (!empty($user_language[$user_selected]['lg_Member_Since'])) ? $user_language[$user_selected]['lg_Member_Since'] : $default_language['en']['lg_Member_Since']; ?> <?= date('M Y', strtotime($provider['created_at'])); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="provider-info">
                                <p class="mb-1"><i class="far fa-envelope mr-1"></i> <?= $provider['email'] ?></p>
                                <p class="mb-0"><i class="fas fa-phone-alt mr-1"></i>
                                    <?php
                                    if ($this->session->userdata('id')) {
                                        echo $provider['country_code'].' - '.$provider['mobileno'];
                                    } else {
                                        ?>
                                        xxxxxxxx<?= rand(00, 99); ?>
                                    <?php } ?>

                                </p>
                            </div>
                            <hr>
                            <!-- block user/provider -->

                        <?php } ?>
                    </div>
                </div>
                <div class="card available-widget">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo (!empty($user_language[$user_selected]['lg_Service_Availability'])) ? $user_language[$user_selected]['lg_Service_Availability'] : $default_language['en']['lg_Service_Availability']; ?></h5>
                        <ul>
                            <?php
                            if (!empty($availability_details)) {
                                foreach ($availability_details as $availability) {

                                    $day = $availability['day'];
                                    $from_time = $availability['from_time'];
                                    $to_time = $availability['to_time'];

                                    if ($day == '1') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_monday'])) ? $user_language[$user_selected]['lg_monday'] : $default_language['en']['lg_monday'];
                                    } elseif ($day == '2') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_tuesday'])) ? $user_language[$user_selected]['lg_tuesday'] : $default_language['en']['lg_tuesday'];
                                    } elseif ($day == '3') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_wednesday'])) ? $user_language[$user_selected]['lg_wednesday'] : $default_language['en']['lg_wednesday'];
                                    } elseif ($day == '4') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_thursday'])) ? $user_language[$user_selected]['lg_thursday'] : $default_language['en']['lg_thursday'];
                                    } elseif ($day == '5') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_friday'])) ? $user_language[$user_selected]['lg_friday'] : $default_language['en']['lg_friday'];
                                    } elseif ($day == '6') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_saturday'])) ? $user_language[$user_selected]['lg_saturday'] : $default_language['en']['lg_saturday'];
                                    } elseif ($day == '7') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_sunday'])) ? $user_language[$user_selected]['lg_sunday'] : $default_language['en']['lg_sunday'];
                                    } elseif ($day == '0') {
                                        $weekday = (!empty($user_language[$user_selected]['lg_sunday'])) ? $user_language[$user_selected]['lg_sunday'] : $default_language['en']['lg_sunday'];
                                    }

                                    echo '<li><span>' . $weekday . '</span>' . $from_time . ' - ' . $to_time . '</li>';
                                }
                            } else {
                                echo '<li class="text-center">No Details found</li>';
                            }
                            ?>
                        </ul>
                    </div>				
                </div>				
            </div>
        </div>
    </div>
</div>

