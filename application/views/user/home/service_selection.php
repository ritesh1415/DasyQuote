<?php
// $this->db->where('provider_id', $service['user_id'])->get('business_hours')->row_array();   
// $this->db->select('AVG(rating)');
// $this->db->where(array('service_id' => $service['id'], 'status' => 1));
// $this->db->from('rating_review');
// $rating = $this->db->get()->row_array();
// $avg_rating = round($rating['AVG(rating)'], 2);

$this->db->select("r.*,u.profile_img,u.name");
$this->db->from('rating_review r');
$this->db->join('users u', 'u.id = r.user_id', 'LEFT');
$this->db->where(array('r.service_id' => $service['id'], 'r.status' => 1));


?>
<!-- sorting -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 theiaStickySidebar">
                <div class="card filter-card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Filter


                            <!-- <?php echo (!empty($user_language[$user_selected]['lg_Search_Filter'])) ? $user_language[$user_selected]['lg_Search_Filter'] : $default_language['en']['lg-Filter']; ?> -->
                        </h4>
                        <form id="search_form" method="post" action="<?= base_url() ?>">

                            <div class="filter-widget">
                             
                                <div class="filter-list">
                                    <h4 class="filter-title">
                                        <?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?>
                                    </h4>
                                    <select id="sort_by" class="form-control selectbox select">
                                        <option value="">
                                            Sort By Rating
                                            <!-- <?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?> -->
                                        </option>
                                        <option value="1">
                                            <?php echo (!empty($user_language[$user_selected]['lg_Price_Low_High'])) ? $user_language[$user_selected]['lg_Price_Low_High'] : $default_language['en']['lg_Price_Low_High']; ?>
                                        </option>
                                        <option value="2">
                                            <?php echo (!empty($user_language[$user_selected]['lg_Price_High_Low'])) ? $user_language[$user_selected]['lg_Price_High_Low'] : $default_language['en']['lg_Price_High_Low']; ?>
                                        </option>
                                        <option value="3">
                                            <?php echo (!empty($user_language[$user_selected]['lg_Newest'])) ? $user_language[$user_selected]['lg_Newest'] : $default_language['en']['lg_Newest']; ?>
                                        </option>
                                        <option value="4">
                                            Near by location
                                            <!-- <?php echo (!empty($user_language[$user_selected]['lg_Newest'])) ? $user_language[$user_selected]['lg_Newest'] : $default_language['en']['lg_Newest']; ?> -->
                                        </option>
                                    </select>
                                </div>
                                
                            </div>

                            <!-- <div class="filter-widget"> -->
                             
                                <!-- <div class="filter-list">
                                    <h4 class="filter-title">Sort By</h4>
                                    <select id="sort_by" class="form-control selectbox select">
                                        <option value="">Sort By Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Star</option>
                                        <option value="3">3 Star</option>
                                        <option value="4">4 Star</option>
                                        <option value="5">5 Star</option>
                                    </select>
                                </div>
                                
                            </div> -->

                            


                            <button class="btn btn-primary pl-5 pr-5 btn-block get_services" type="button">
                                <?php echo (!empty($user_language[$user_selected]['lg_search'])) ? $user_language[$user_selected]['lg_search'] : $default_language['en']['lg_search']; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
         <form id="quotePublish" method="post" action="<?= base_url() ?>insert-quotePublish">
            <div class="service-box">
                <input type="checkbox" class="select-all-checkbox" name="select-all">
               <label for="select-all-checkbox">Select All</label>
               <?php    
             //fetching services
					  $placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
					  if(!empty($services)){
						foreach ($services as $srows) {
                            // print_r($srows);
                            // exit;

                        // $this->load->db;  
                        $this->db->select('AVG(rating)');
                        $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                        $this->db->from('rating_review');
                        $rating = $this->db->get()->row_array();
                        $avg_rating = round($rating['AVG(rating)'], 2);

						$mobile_image=explode(',', $srows['mobile_image']);
						$this->db->select("service_image");
						$this->db->from('services_image');
						$this->db->where("service_id",$srows['id']);
						$this->db->where("status",1);
						$image = $this->db->get()->row_array(); 

						$user_currency_code = '';
                        $userId = $this->session->userdata('id');
                   
					 ?>
                <div class="card ml-5 mb-3" style="max-width: 750px;">
                    <div class="row g-1"> 
                         <div class="col-md-1">
                            <!-- its contain providers id of each selected checkbox -->
                           <input type="checkbox" class="card-checkbox" name="selective[]" value="<?= $srows['user_id'] ?>">
                        </div>
                        <div class="col-md-4">

                            <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>"
                                class="booking-img">
                                <!-- <img src="uploads/services/se_full_1678861965DJ1.jpeg" class="img-fluid category_reply"
                                    alt="..." style="width : 250px; height: 150px; margin : 20px; border-radius: 3px;"> -->
                                    <?php if (!empty($image['service_image'])) { ?>
                                        <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>">
                                    <?php } else { ?>
                                        <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376248_user.jpg'; ?>">
                                    <?php } ?>
                            </a>

                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <!-- <h5 class="card-title">DJ</h5> -->
                                <ul class="booking-details ">
                                    <!-- <li><span>Amount</span> $5000</li>
                                    <li><span>Location</span> wadala</li> -->
                                    <li>
                                        <span>Provider</span>
                                        <div >
                                    <div class="service-user">
                                        <a href="#">
                                            <?php if ($provider_details['profile_img'] != '') { ?>
                                                <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                            <?php } else { ?>
											    <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <?php
                                           if (!empty($srows['user_id'])) {
                                              $provider = $this->db->select('*')->from('providers')->where('id', $srows['user_id'])->get()->row_array();
                                               ?>
                                              <a name="prov_id" href="javascript:void(0);" class="ser-provider-name"><?= !empty($provider['name']) ? $provider['name'] : '-'; ?></a>
                                              <!-- get providers id in hidden type -->
                                              <input type="hidden" name="provider_id[]" value="<?= $provider['id'] ?>">
                                               <?php } ?>
                                   
                                </div>
                                <div class="cate-list col-sm-5"> <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>
                                        <!-- block providers -->
                                    </li>
                                    <li><span>Description</span>Disc jockeys, also known as DJs, and at public events.</li>
                                    <li>
                                        <span>Rating</span>
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
                                    </li>
                                   <li>
                                     <span>mobile no.</span>
                                      <?php if ($this->session->userdata('id') != '') { ?>
                                        <span class="col ser-contact">
                                            <!-- <i class="fas fa-phone mr-1"> -->

                                            </i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                        <?php } else { ?>
                                        <span class="col ser-contact">
                                            <!-- <i class="fas fa-phone mr-1"></i>  -->
                                            <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                        <?php } ?>

                                              
                                    </li>
                                    <li>
                                        <span>Location</span>
                                        <span class="col "><?php echo ucfirst($srows['service_location']); ?></span>
                                    </li>
                                </ul>
                                    
                            </div> 
                        </div>
                        <!-- <div class="col-md-2 mt-5">
                            <a href="" class="btn btn-sm bg-success-light myCancel mt-2">
                                <i class=""></i> Accept </a>
                            <a href="" class="btn btn-sm bg-danger-light myCancel mt-2">
                                <i class=""></i> Decline</a>
                        </div> -->
                    
                    </div>
                </div>
                <?php } }
					else{
						// echo '<h3>No Services Found</h3>';
					} ?>
                
          </div>
                
        </div>
        <input type="hidden" name="quoteId" value="<?= $this->uri->segment(2) ?>">
        <input type="hidden" name="catId" value="<?= $this->uri->segment(3) ?>">
        
        <button style="float:right;" class="btn btn-primary" id="subBtn">Submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".select-all-checkbox").change(function() {
            $(".card-checkbox").prop("checked", $(this).prop("checked"));
        });

        $(".card-checkbox").change(function() {
            if (!$(this).prop("checked")) {
                $(".select-all-checkbox").prop("checked", false);
            }
            else if ($(this).prop("checked")){

            }
        });
        
    });
</script>

<script src="<?= base_url()?>assets\js\jquery-3.6.0.min.js"> </script>


