<?php
$type = $this->session->userdata('usertype');
$userId = $this->session->userdata('id');
$default_language = default_language();
$active_language = active_language();

if ($this->session->userdata('user_select_language') == '') {

    $lang = $default_language['language_value'];
} else {
    $lang = $this->session->userdata('user_select_language');
}

$default_language_select = default_language();
$header_settings = $this->db->get('header_settings')->row();
$google_analytics_showhide = $this->db->get_where('system_settings', array('key' => 'analytics_showhide'))->row()->value;
$google_analytics_code = $this->db->get_where('system_settings', array('key' => 'google_analytics'))->row()->value;
?>
<head>
<style>
    /* * {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
} */
/* DJ */
    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }
    /* makeup artist */
    #regForm1 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }
    /* chairtable */
    #regForm2 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }
    /* event organiser */
    #regForm3 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }
    /* photographer */
    #regForm4 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }
    /* master ceremony */
    #regForm5 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 100%;
        min-width: 300px;
        position: absolute;
        top: -115px;
        padding-left: 176px;
    }



    /* h1 {
  text-align: center;  
} */

    /* input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
} */

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }
    .tab1 {
        display: none;
    }
    .tab2 {
        display: none;
    }
    .tab3 {
        display: none;
    }
    .tab4 {
        display: none;
    }
    .tab5 {
        display: none;
    }

    button.b1 {
        background-color: #000;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button.b1:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }
/* dj */
    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #000;
    }

    /* makeup */
     .step1 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step1.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step1.finish1 {
        background-color: #000;
    }
     /* chair table */
    .step2 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step2.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step2.finish {
        background-color: #000;
    }
   /* event organiser */
    .step3 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step3.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step3.finish {
        background-color: #000;
    }
   /* photographer */
    .step4 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step4.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step4.finish {
        background-color: #000;
    }

   /* Master Of Ceremony */
    .step5 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
    }

    .step5.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step5.finish {
        background-color: #000;
    }
    label.lab{
        font-size: 20px;
    }
    h2.fill-h2{
        font-size: 23px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets\css\flatpickr.min.css">
<link href="<?php echo base_url(); ?>assets\css\styleq.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets\css\all_icons_min.css" rel="stylesheet">
</head>
<body>
    <?php if ($google_analytics_showhide == 1 && $google_analytics_code != '') { ?>
            <script>
                 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
             
                         ga('create', '<?php echo $google_analytics_code; ?>', 'auto');
                         ga('send', 'pageview');
            </script>
    <?php } ?>

    <div class="main-wrapper">
        <!-- <?php if ($this->session->flashdata('item')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('item'); ?>
        </div>
        <?php endif; ?> -->
        <header class="header sticktop">
        
        <!-- <a id="menu-button-mobile" class="cmn-toggle-switch cmn-toggle-switch__htx" href="javascript:void(0);"><span></span></a> -->
            <nav class="navbar navbar-expand-lg header-nav">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
                        <span class="bar-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </a>
                    <a href="<?php echo base_url(); ?>" class="navbar-brand logo">
                       <?php if (!empty($this->website_logo_front)) { ?>
                                                                        <img src="<?php echo base_url() . settingValue('logo_front'); ?>" class="img-fluid" alt="Logo">
                    <?php } else { ?>
                                                                        <img src="<?php echo (settingValue('profile_placeholder_image')) ? base_url() . settingValue('profile_placeholder_image') : base_url() . 'assets\img\logo-dasy.png'; ?>" class="img-fluid" alt="Logo">
                    <?php } ?>


                    </a>
                    <a href="<?php echo base_url(); ?>" class="navbar-brand logo-small">
                        <img src="<?php echo (settingValue('header_icon')) ? base_url() . settingValue('header_icon') : base_url() . 'assets\img\logo-dasy.png'; ?>" class="img-fluid" alt="Logo">
                    </a>
                </div>

                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="<?php echo base_url(); ?>" class="menu-logo">
                            <img src="<?php echo base_url() . $this->website_logo_front; ?>" class="img-fluid" alt="Logo">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <ul class="main-nav">
                    <?php if ($this->session->userdata('usertype') == 'user') { ?>

                                         <!-- <li class="has-submenu">
                                                             <a href="javascript:;">Get a quote<i class="fas fa-chevron-down"></i></a> 
                                                             <ul class="submenu lang-blk">
                                                               <li>
                                                                 <div class="request">
                                                                  <a href="#tab_1" data-toggle="tab"
                                                                    class="res">DJ</a></div>
                                                               </li>
                                                               <li>
                                                                 <div class="request1">
                                                                  <a href="#tab_2" data-toggle="tab"
                                                                    class="res">Makeup Artist</a></div>
                                                               </li>
                                                               <li>
                                                                 <div class="request2">
                                                                  <a href="#tab_3" data-toggle="tab"
                                                                    class="res">Chair / Table Decoration</a></div>
                                                               </li>
                                                               <li>
                                                                 <div class="request3">
                                                                  <a href="#tab_4" data-toggle="tab"
                                                                    class="res">Event Organizer</a></div>
                                                               </li>
                                                               <li>
                                                                 <div class="request4">
                                                                  <a href="#tab_5" data-toggle="tab"
                                                                    class="res">Photographer</a></div>
                                                               </li>
                                                               <li>
                                                                 <div class="request5">
                                                                  <a href="#tab_6" data-toggle="tab"
                                                                    class="res"> 
                                                                    Master Of Ceremony</a></div>
                                                               </li>
                                                             </ul>
                                                            </li> -->
                <div class="dropdown show">
                  <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <?php } ?>
                                <?php if ($header_settings->header_menu_option == 1 && !empty($header_settings->header_menus)) {
                                    $menus = json_decode($header_settings->header_menus);
                                    foreach ($menus as $menu) {
                                        if ($menu->label == 'Categories' && $menu->id == 1 && $menu->label != '' && $menu->link != '') { ?>
                                                         <li class="has-submenu">
                                                          <?php
                                                          $this->db->select('*');
                                                          $this->db->from('categories');
                                                          $this->db->where('status', 1);
                                                          $this->db->order_by('id', 'DESC');
                                                          $result = $this->db->get()->result_array();
                                                          ?>
                                                           <!-- <a href="<?php echo $menu->link; ?>"><?php echo $menu->label; ?> <i class="fas fa-chevron-down"></i></a> -->
                                                           <ul class="submenu">
                                                               <?php foreach ($result as $res) { ?>
                                                                                                                   <li><a href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', strtolower($res['category_slug'])); ?>"><?php echo ucfirst($res['category_name']); ?></a></li>
                                                               <?php } ?>
                                                           </ul>
                                                       </li>
                                <?php } else {


                                            if ($menu->label != '' && $menu->link != '') {
                                                ?>
                                                             <li><a href="<?php echo $menu->link; ?>"><?php echo $menu->label; ?></a></li>
                                                                                                                                                                                        <?php }
                                        }
                                    } ?>
                                
                                <?php } else {

                                    $this->db->select('*');
                                    $this->db->from('categories');
                                    $this->db->where('status', 1);
                                    $this->db->order_by('id', 'DESC');
                                    $result = $this->db->get()->result_array();
                                    ?>
                                        <li class="has-submenu">
                                     <a href="<?php echo base_url(); ?>all-categories"><?php echo (!empty($user_language[$user_selected]['lg_category_name'])) ? $user_language[$user_selected]['lg_category_name'] : $default_language['en']['lg_category_name']; ?> <i class="fas fa-chevron-down"></i></a>
                                     <ul class="submenu">
                                  <?php foreach ($result as $res) { ?>
                                     <li><a href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', strtolower($res['category_slug'])); ?>"><?php echo ucfirst($res['category_name']); ?></a></li>
                                 <?php } ?>
                                 </ul>
                                 </li>

                                <li><a href="<?php echo base_url(); ?>about-us"><?php echo (!empty($user_language[$user_selected]['lg_about'])) ? $user_language[$user_selected]['lg_about'] : $default_language['en']['lg_about']; ?></a></li>
                                    <li><a href="<?php echo base_url(); ?>contact"><?php echo (!empty($user_language[$user_selected]['lg_contact'])) ? $user_language[$user_selected]['lg_contact'] : $default_language['en']['lg_contact']; ?></a></li>
                                                                                         
 
                        <?php } ?>
                        <?php if ($this->session->userdata('id') == '') { ?>
                                                                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard"><?php echo (!empty($user_language[$user_selected]['lg_become_prof'])) ? $user_language[$user_selected]['lg_become_prof'] : $default_language['en']['lg_become_prof']; ?></a></li>

                                                                            <?php
                                                                            ?>
                                                                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard1"><?php echo (!empty($user_language[$user_selected]['lg_become_user'])) ? $user_language[$user_selected]['lg_become_user'] : $default_language['en']['lg_become_user']; ?></a></li>

                                                                            <li><a href="<?php echo base_url(); ?>contact">Contact</a></li>
                                                                            <li><a href="<?php echo base_url(); ?>about-us">About</a></li>
                                        
                                                                            <li class="has-submenu">
                                                                             <a href="javascript:;">Get a quote<i class="fas fa-chevron-down"></i></a> 
                                                                             <ul class="submenu lang-blk">
                                                                               <li>
                                                                                 <div class="request">
                                                                                  <a href="#tab_1" data-toggle="tab"
                                                                                    class="res">DJ</a></div>
                                                                               </li>
                                                                               <li>
                                                                                 <div class="request1">
                                                                                  <a href="#tab_2" data-toggle="tab"
                                                                                    class="res">Makeup Artist</a></div>
                                                                               </li>
                                                                               <li>
                                                                                 <div class="request2">
                                                                                  <a href="#tab_3" data-toggle="tab"
                                                                                    class="res">Chair / Table Decoration</a></div>
                                                                               </li>
                                                                               <li>
                                                                                 <div class="request3">
                                                                                  <a href="#tab_4" data-toggle="tab"
                                                                                    class="res">Event Organizer</a></div>
                                                                               </li>
                                                                               <li>
                                                                                 <div class="request4">
                                                                                  <a href="#tab_5" data-toggle="tab"
                                                                                    class="res">Photographer</a></div>
                                                                               </li>
                                                                               <li>
                                                                                 <div class="request5">
                                                                                  <a href="#tab_6" data-toggle="tab"
                                                                                    class="res"> 
                                                                                    Master Of Ceremony</a></div>
                                                                               </li>
                                                                             </ul>
                                                                            </li>


                                                                            <li class="login-link">
                                                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#tab_login_modal"><?php echo (!empty($user_language[$user_selected]['lg_login'])) ? $user_language[$user_selected]['lg_login'] : $default_language['en']['lg_login']; ?></a>
                                                                            </li>
                        <?php } ?> 
                        
                        <?php if ($header_settings->language_option == 1) { ?>
                                                                        <li class="has-submenu">
                                                                             <a href="javascript:;"><?php echo $lang; ?><i class="fas fa-chevron-down"></i></a> 
                                                                            <ul class="submenu lang-blk">
                                                                                <?php foreach ($active_language as $active) { ?>
                                                                                                                                    <li>

                                                                                                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_lang"/>

                                                                                                                                        <a href="javascript:;" id="change_language"  lang_tag="<?php echo $active['tag']; ?>" lang="<?php echo $active['language_value']; ?>" <?php
                                                                                                                                              if ($active['language_value'] == $lang) {
                                                                                                                                                  echo "selected";
                                                                                                                                              }
                                                                                                                                              ?>>
                                                                                                                                            <?php echo ($active['language']); ?></a></li>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </li>
                    <?php } ?>
                        <?php
                        if ($userId != '') {
                            $get_currency = get_currency();
                            if ($type == 'user') {
                                $user_currency = get_user_currency();
                            } else if ($type == 'provider') {
                                $user_currency = get_provider_currency();
                            }
                            $user_currency_code = $user_currency['user_currency_code'];

                            if ($header_settings->currency_option == 1) { ?>
                            
                                    <li class="has-submenu">
                                    <span class="currency-blk">
                                <select class="form-control-sm custom-select" id="user_currency"> 
                            <?php foreach ($get_currency as $row) { ?>
                                    <option value="<?php echo $row['currency_code']; ?>" <?php echo ($row['currency_code'] == $user_currency_code) ? 'selected' : ''; ?>><?php echo $row['currency_code']; ?></option>
                            <?php } ?> 
                        </select> 
                         </span>     
                    </li>
                <?php }
                        } ?>

                        <?php
                        if (($this->session->userdata('id') != '') && ($this->session->userdata('usertype') == 'provider')) {


                            $get_details = $this->db->where('id', $this->session->userdata('id'))->get('providers')->row_array();
                            $get_availability = $this->db->where('provider_id', $this->session->userdata('id'))->get('business_hours')->row_array();
                            if (!empty($get_availability['availability'])) {
                                $check_avail = strlen($get_availability['availability']);
                            } else {
                                $check_avail = 2;
                            }

                            $get_subscriptions = $this->db->select('*')->from('subscription_details')->where('subscriber_id', $this->session->userdata('id'))->where('expiry_date_time >=', date('Y-m-d 00:00:59'))->get()->row_array();
                            if (!isset($get_subscriptions)) {
                                $get_subscriptions['id'] = '';
                            }
                            if (!empty($get_availability) && !empty($get_subscriptions['id']) && $check_avail > 5) {
                                ?>
                                            <li class="mobile-list">
                                                <a href="<?php echo base_url(); ?>add-service"><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></a>
                                                    </li>
                                 <?php
                            } elseif ($get_subscriptions['id'] == '') {
                                ?>
                             <li class="mobile-list">
                                    <span class="post-service-blk">
                                        <a href="javascript:;" class="get_pro_subscription"><i class="fas fa-plus-circle mr-1"></i><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></a>
                                    </span>
                                </li>
                            <?php
                            } elseif ($get_availability == '' || $get_availability['availability'] == '' || $check_avail < 5) {
                                ?>
                                    <li class="mobile-list">
                                    <a href="javascript:;" class="get_pro_availabilty"><span><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></span></a>
                                     </li>
                                            <?php
                            }
                        }
                        ?>
                        
                    </ul>		 
                </div>		 
                <ul class="nav header-navbar-rht">
                    <?php if ($this->session->userdata('id') == '') { ?>
            <li class="nav-item">
                <a class="nav-link header-login " href="javascript:void(0);" data-toggle="modal" data-target="#tab_login_modal"><?php echo (!empty($user_language[$user_selected]['lg_login'])) ? $user_language[$user_selected]['lg_login'] : $default_language['en']['lg_login']; ?></a>
             </li>
                                                        
                <div class="request nav header-navbar-rht"> 
                 <!-- <li><a href="#tab_1" data-toggle="tab" class="nav-link header-login active show">Request a quote</a></li> -->
                    <!-- <li ><a href="<?php echo base_url(); ?>quote-cat"  class="nav-link header-login active show">Request a quote</a></li> -->
                </div>
                                   

                <?php
                    }
                    $wallet = 0;
                    $token = '';
                    if ($this->session->userdata('id') != '') {
                        if (!empty($token = $this->session->userdata('chat_token'))) {
                            $wallet_sql = $this->db->select('*')->from('wallet_table')->where('token', $this->session->userdata('chat_token'))->get()->row();
                            if (!empty($wallet_sql)) {
                                $wallet = $wallet_sql->wallet_amt;
                                $user_currency_code = '';
                                if (!empty($userId)) {

                                    $wallet = $wallet_sql->wallet_amt;
                                    if ($type == 'user') {
                                        $user_currency = get_user_currency();
                                    } else if ($type == 'provider') {
                                        $user_currency = get_provider_currency();
                                    }
                                    $user_currency_code = $user_currency['user_currency_code'];

                                    $wallet = get_gigs_currency($wallet_sql->wallet_amt, $wallet_sql->currency_code, $user_currency_code);
                                } else {
                                    $user_currency_code = settings('currency');
                                    $wallet = $wallet_sql->wallet_amt;
                                }
                            }
                        }
                        if (is_nan($wallet) || is_infinite($wallet)) {
                            $wallet = $wallet_sql->wallet_amt;
                        }
                        if ($this->session->userdata('usertype') == 'provider') {
                            ?>
                                 <li class="nav-item desc-list wallet-menu">
                             <a href="<?php echo base_url() . 'provider-wallet' ?>" class="nav-link header-login">
                                  <img src="<?php echo $base_url ?>assets/img/wallet.png" alt="" class="mr-2 wallet-img"><span><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?>:</span> <?php echo currency_conversion($user_currency_code) . $wallet; ?>
                                </a>
                                </li>
                            <?php } else {
                            ?>
                             <li class="nav-item desc-list wallet-menu">
                                <a href="<?php echo base_url() . 'user-wallet' ?>" class="nav-link header-login">
                                    <img src="<?php echo $base_url ?>assets/img/wallet.png" alt="" class="mr-2 wallet-img"><span><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?>:</span> <?php echo currency_conversion($user_currency_code) . $wallet; ?>
                               </a>
                            </li>
                           <?php
                        }
                    }
                    ?>

                    <?php
                    if (($this->session->userdata('id') != '') && ($this->session->userdata('usertype') == 'provider')) {

                        $get_details = $this->db->where('id', $this->session->userdata('id'))->get('providers')->row_array();
                        $get_availability = $this->db->where('provider_id', $this->session->userdata('id'))->get('business_hours')->row_array();
                        if (!empty($get_availability['availability'])) {
                            $check_avail = strlen($get_availability['availability']);
                        } else {
                            $check_avail = 2;
                        }

                        $get_subscriptions = $this->db->select('*')->from('subscription_details')->where('subscriber_id', $this->session->userdata('id'))->where('expiry_date_time >=', date('Y-m-d 00:00:59'))->get()->row_array();
                        if (!isset($get_subscriptions)) {
                            $get_subscriptions['id'] = '';
                        }
                        if (!empty($get_availability) && !empty($get_subscriptions['id']) && $check_avail > 5) {
                            ?>
                                                                                                                            <li class="nav-item desc-list">
                                                                                                                                <a href="<?php echo base_url(); ?>add-service" class="nav-link header-login"><i class="fas fa-plus-circle mr-1"></i> <span><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></span></a>
                                                                                                                            </li>
                                                                                                                            <?php
                        } elseif ($get_subscriptions['id'] == '') {
                            ?>
                                                                                                                            <li class="nav-item desc-list">
                                                                                                                                <a href="javascript:;" class="nav-link header-login get_pro_subscription"><i class="fas fa-plus-circle mr-1"></i> <span><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></span></a>
                                                                                                                            </li>
                                                                                                                            <?php
                        } elseif ($get_availability == '' || $get_availability['availability'] == '' || $check_avail < 5) {
                            ?>
                                                                                                                            <li class="nav-item desc-list">
                                                                                                                                <a href="javascript:;" class="nav-link header-login get_pro_availabilty"><i class="fas fa-plus-circle mr-1"></i> <span><?php echo (!empty($user_language[$user_selected]['lg_post_service'])) ? $user_language[$user_selected]['lg_post_service'] : $default_language['en']['lg_post_service']; ?></span></a>
                                                                                                                            </li>
                                                                                                                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($this->session->userdata('id')) {
                        if ($this->session->userdata('usertype') == 'user') {

                            $user_details = $this->db->where('id', $this->session->userdata('id'))->get('users')->row_array();
                        } elseif ($this->session->userdata('usertype') == 'provider') {
                            $user_details = $this->db->where('id', $this->session->userdata('id'))->get('providers')->row_array();
                        }
                        ?>
                                                                        <?php if ($this->session->userdata('usertype') == 'provider') { ?>
                                                                                                                            <!-- Notifications -->
                                                                                                                            <li class="nav-item dropdown logged-item">
                                                                                                                                <?php
                                                                                                                                if (!empty($this->session->userdata('chat_token'))) {
                                                                                                                                    $sestoken = $this->session->userdata('chat_token');
                                                                                                                                } else {
                                                                                                                                    $sestoken = '';
                                                                                                                                }

                                                                                                                                if (!empty($sestoken)) {
                                                                                                                                    $ret = $this->db->select('*')->
                                                                                                                                        from('notification_table')->
                                                                                                                                        where('receiver', $sestoken)->
                                                                                                                                        where('status', 1)->
                                                                                                                                        order_by('notification_id', 'DESC')->
                                                                                                                                        get()->result_array();

                                                                                                                                    $notification = [];
                                                                                                                                    if (!empty($ret)) {
                                                                                                                                        foreach ($ret as $key => $value) {
                                                                                                                                            $user_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                from('users')->
                                                                                                                                                where('token', $value['sender'])->
                                                                                                                                                get()->row();
                                                                                                                                            $provider_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                from('providers')->
                                                                                                                                                where('token', $value['sender'])->
                                                                                                                                                get()->row();
                                                                                                                                            if (!empty($user_table)) {
                                                                                                                                                $user_info = $user_table;
                                                                                                                                            } else {
                                                                                                                                                $user_info = $provider_table;
                                                                                                                                            }
                                                                                                                                            $notification[$key]['name'] = !empty($user_info->name) ? $user_info->name : '';
                                                                                                                                            $notification[$key]['message'] = !empty($value['message']) ? $value['message'] : '';
                                                                                                                                            $notification[$key]['profile_img'] = !empty($user_info->profile_img) ? $user_info->profile_img : '';
                                                                                                                                            $notification[$key]['created_at'] = !empty($value['created_at']) ? $value['created_at'] : '';
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    $n_count = count($notification);
                                                                                                                                } else {
                                                                                                                                    $n_count = 0;
                                                                                                                                    $notification = [];
                                                                                                                                }

                                                                                                                                /* Notification Count */
                                                                                                                                if (!empty($n_count) && $n_count != 0) {
                                                                                                                                    $notify = "<span class='badge badge-pill bg-yellow'>" . $n_count . "</span>";
                                                                                                                                } else {
                                                                                                                                    $notify = "";
                                                                                                                                }
                                                                                                                                ?>

                                                                                                                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                    <i class="fas fa-bell"></i> <?php echo $notify; ?>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu notify-blk dropdown-menu-right notifications">
                                                                                                                                    <div class="topnav-dropdown-header">
                                                                                                                                        <span class="notification-title"><?php echo (!empty($user_language[$user_selected]['lg_Notifications'])) ? $user_language[$user_selected]['lg_Notifications'] : $default_language['en']['lg_Notifications']; ?></span>
                                                                                                                                        <a href="javascript:void(0)" class="clear-noti noty_clear" data-token="<?php echo $this->session->userdata('chat_token'); ?>"><?php echo (!empty($user_language[$user_selected]['lg_clear_all'])) ? $user_language[$user_selected]['lg_clear_all'] : $default_language['en']['lg_clear_all']; ?>  </a>
                                                                                                                                    </div>
                                                                                                                                    <div class="noti-content">
                                                                                                                                        <ul class="notification-list">
                                                                                                                                            <?php
                                                                                                                                            if (!empty($notification)) {
                                                                                                                                                foreach ($notification as $key => $notify) {
                                                                                                                                                    $datef = explode(' ', $notify["created_at"]);
                                                                                                                                                    if (settingValue('time_format') == '12 Hours') {
                                                                                                                                                        $time = date('h:ia', strtotime($datef[1]));
                                                                                                                                                    } elseif (settingValue('time_format') == '24 Hours') {
                                                                                                                                                        $time = date('H:i:s', strtotime($datef[1]));
                                                                                                                                                    } else {
                                                                                                                                                        $time = date('G:ia', strtotime($datef[1]));
                                                                                                                                                    }
                                                                                                                                                    $date = date(settingValue('date_format'), strtotime($datef[0]));
                                                                                                                                                    $timeBase = $date . ' ' . $time;

                                                                                                                                                    if (file_exists($notify['profile_img'])) {
                                                                                                                                                        $profile_img = $notify['profile_img'];
                                                                                                                                                    } else {
                                                                                                                                                        $profile_img = 'assets/img/user.jpg';
                                                                                                                                                    }
                                                                                                                                                    ?>
                                                                                                                                                                                                                                                    <li class="notification-message">
                                                                                                                                                                                                                                                        <a href="<?php echo base_url(); ?>notification-list">
                                                                                                                                                                                                                                                            <div class="media">
                                                                                                                                                                                                                                                                <span class="avatar avatar-sm">
                                                                                                                                                                                                                                                                    <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url() . $profile_img; ?>">
                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                <div class="media-body">
                                                                                                                                                                                                                                                                    <p class="noti-details"> <span class="noti-title"><?php echo ucfirst($notify['message']); ?></span></p>
                                                                                                                                                                                                                                                                    <p class="noti-time"><span class="notification-time"><?php echo $timeBase; ?></span></p>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                                                    <?php
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                ?>
                                                                                                                                                  <li class="notification-message">
                                                                                                                                                        <p class="text-center text-danger mt-3"><?php echo (!empty($user_language[$user_selected]['lg_notification_empty'])) ? $user_language[$user_selected]['lg_notification_empty'] : $default_language['en']['lg_notification_empty']; ?></p>
                                                                                                                                                    </li>
                                                                                                                                            <?php } ?>

                                                                                                                                        </ul>
                                                                                                                                    </div>
                                                                                                                                    <div class="topnav-dropdown-footer">
                                                                                                                                        <a href="<?php echo base_url(); ?>notification-list"><?php echo (!empty($user_language[$user_selected]['lg_view_notification'])) ? $user_language[$user_selected]['lg_view_notification'] : $default_language['en']['lg_view_notification']; ?></a>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <!-- /Notifications -->

                                                                                                                            <?php if (!empty($this->session->userdata('id'))) { ?>
                                                                                                                                                                                <!-- chat -->
                                                                                                                                    <?php
                                                                                                                                    $chat_token = $this->session->userdata('chat_token');
                                                                                                                                    if (!empty($chat_token)) {
                                                                                                                                        $chat_detail = $this->db->where('receiver_token', $chat_token)->where('read_status=', 0)->get('chat_table')->result_array();
                                                                                                                                    }
                                                                                                                                    ?>
                                                                                                                                        <li class="nav-item dropdown logged-item">

                                                                                                                                       <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-comments" aria-hidden="true"></i>
                                                                                                                                                        <?php if (count($chat_detail) != 0) { ?>
                                                                                                                                                                    <span class="badge badge-pill bg-yellow chat-bg-yellow"><?php echo count($chat_detail); ?></span>
                                                                                                                                                        <?php } ?>
                                  

                                                                                                                                            <div class="dropdown-menu comments-blk dropdown-menu-right notifications">
                                                                                                                                                    <div class="topnav-dropdown-header">
                                                                                                                                                            <span class="notification-title"><?php echo (!empty($user_language[$user_selected]['lg_chats'])) ? $user_language[$user_selected]['lg_chats'] : $default_language['en']['lg_chats']; ?></span>
                                                                                                                                                                <a href="javascript:void(0)" class="clear-noti chat_clear_all" data-token="<?php echo $this->session->userdata('chat_token'); ?>" > <?php echo (!empty($user_language[$user_selected]['lg_clear_all'])) ? $user_language[$user_selected]['lg_clear_all'] : $default_language['en']['lg_clear_all']; ?> </a>
                                                                                                                                                    </div>

                                                                                                                                            <div class="noti-content">
                                                                                                                                                 <ul class="chat-list notification-list">
                                                                                                                                                    <?php
                                                                                                                                                    if (count($chat_detail) > 0) {
                                                                                                                                                        $sender = '';
                                                                                                                                                        foreach ($chat_detail as $row) {

                                                                                                                                                            $user_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                                from('users')->
                                                                                                                                                                where('token', $row['sender_token'])->
                                                                                                                                                                get()->row();
                                                                                                                                                            $provider_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                                from('providers')->
                                                                                                                                                                where('token', $row['sender_token'])->
                                                                                                                                                                get()->row();
                                                                                                                                                            if (!empty($user_table)) {
                                                                                                                                                                $user_info = $user_table;
                                                                                                                                                            } else {
                                                                                                                                                                $user_info = $provider_table;
                                                                                                                                                            }
                                                                                                                                                            $datef = explode(' ', $row["created_at"]);
                                                                                                                                                            if (settingValue('time_format') == '12 Hours') {
                                                                                                                                                                $time = date('h:ia', strtotime($datef[1]));
                                                                                                                                                            } elseif (settingValue('time_format') == '24 Hours') {
                                                                                                                                                                $time = date('H:i:s', strtotime($datef[1]));
                                                                                                                                                            } else {
                                                                                                                                                                $time = date('G:ia', strtotime($datef[1]));
                                                                                                                                                            }

                                                                                                                                                            $date = date(settingValue('date_format'), strtotime($datef[0]));
                                                                                                                                                            $timeBase = $date . ' ' . $time;

                                                                                                                                                            if (file_exists($user_info->profile_img)) {
                                                                                                                                                                $profile_img = $user_info->profile_img;
                                                                                                                                                            } else {
                                                                                                                                                                $profile_img = 'assets/img/user.jpg';
                                                                                                                                                            }
                                                                                                                                                            ?>

                                                                                                                                                                                                                                                                                                        <li class="notification-message">
                                                                                                                                                                                                                                                                                                            <a href="<?php echo base_url(); ?>user-chat">
                                                                                                                                                                                                                                                                                                                <div class="media">
                                                                                                                                                                                                                                                                                                                    <span class="avatar avatar-sm">

                                                                                                                                                                                                                                                                                                                        <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url() . $profile_img; ?>">
                                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                                    <div class="media-body">
                                                                                                                                                                                                                                                                                                                        <p class="noti-details"> <span class="noti-title"><?php echo $user_info->name . " send a message as " . $row['message']; ?></span></p>
                                                                                                                                                                                                                                                                                                                        <p class="noti-time"><span class="notification-time"><?php echo $timeBase; ?></span></p>
                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                        <?php
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                    if (count($chat_detail) == 0) {
                                                                                                                                                        ?>

                                                                                                                                                                                                        <li class="notification-message">
                                                                                                                                                                                                            <p class="text-center text-danger mt-3"><?php echo (!empty($user_language[$user_selected]['lg_empty_chats'])) ? $user_language[$user_selected]['lg_empty_chats'] : $default_language['en']['lg_empty_chats']; ?></p>
                                                                                                                                                                                                        </li>
                                                                                                                                                                                                <?php } ?>

                                                                                                                                                                                            </ul>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="topnav-dropdown-footer">
                                                                                                                                                                                            <a href="<?php echo base_url(); ?>user-chat"><?php echo (!empty($user_language[$user_selected]['lg_view_all_chat'])) ? $user_language[$user_selected]['lg_view_all_chat'] : $default_language['en']['lg_view_all_chat']; ?></a>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </li>
                                                                                                                                                                                <!-- /chat -->
                                                                                                                            <?php } ?>
                                                                                                                            <!-- User Menu -->
                                                                                                                            <li class="nav-item dropdown has-arrow logged-item">
                                                                                                                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                    <span class="user-img">
                                                                                                                                        <?php if (file_exists($user_details['profile_img'])) { ?>
                                                                                                                                                    <img class="rounded-circle" src="<?php echo $base_url . $user_details['profile_img'] ?>" width="31" alt="">
                                                                                                                                        <?php } else { ?>
                                                                                                                                                    <img class="rounded-circle" src="<?php echo base_url() . settingValue('profile_placeholder_image'); ?>" alt="">
                                                                                                                                        <?php } ?>
                                                                                                                                    </span>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <div class="user-header">
                                                                                                                                        <div class="avatar avatar-sm">
                                                                                                                                            <?php if (file_exists($user_details['profile_img'])) { ?>
                                                                                                                                                    <img class="avatar-img rounded-circle" src="<?php echo $base_url . $user_details['profile_img'] ?>" alt="">
                                                                                                                                            <?php } else { ?>
                                                                                                                                                    <img class="avatar-img rounded-circle" src="<?php echo $base_url ?>assets/img/user.jpg" alt="">
                                                                                                                                            <?php } ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="user-text">
                                                                                                                                            <h6><?php echo $user_details['name']; ?></h6>
                                                                                                                                            <p class="text-muted mb-0"><?php echo (!empty($user_language[$user_selected]['lg_Provider'])) ? $user_language[$user_selected]['lg_Provider'] : $default_language['en']['lg_Provider']; ?></p>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>provider-dashboard"><?php echo (!empty($user_language[$user_selected]['lg_Dashboard'])) ? $user_language[$user_selected]['lg_Dashboard'] : $default_language['en']['lg_Dashboard']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>my-services"><?php echo (!empty($user_language[$user_selected]['lg_My_Services'])) ? $user_language[$user_selected]['lg_My_Services'] : $default_language['en']['lg_My_Services']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>provider-bookings"><?php echo (!empty($user_language[$user_selected]['lg_Booking_List'])) ? $user_language[$user_selected]['lg_Booking_List'] : $default_language['en']['lg_Booking_List']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>prof-quotelist">Quote list</a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>provider-settings"><?php echo (!empty($user_language[$user_selected]['lg_Profile_Settings'])) ? $user_language[$user_selected]['lg_Profile_Settings'] : $default_language['en']['lg_Profile_Settings']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>provider-wallet"><?php echo (!empty($user_language[$user_selected]['lg_wallet'])) ? $user_language[$user_selected]['lg_wallet'] : $default_language['en']['lg_wallet']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>provider-subscription"><?php echo (!empty($user_language[$user_selected]['lg_Subscription'])) ? $user_language[$user_selected]['lg_Subscription'] : $default_language['en']['lg_Subscription']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>provider-availability"><?php echo (!empty($user_language[$user_selected]['lg_Availability'])) ? $user_language[$user_selected]['lg_Availability'] : $default_language['en']['lg_Availability']; ?></a>
                                                                                                                                    <?php
                                                                                                                                    $query = $this->db->query("select * from system_settings WHERE status = 1");
                                                                                                                                    $result = $query->result_array();

                                                                                                                                    $login_type = '';
                                                                                                                                    foreach ($result as $res) {

                                                                                                                                        if ($res['key'] == 'login_type') {
                                                                                                                                            $login_type = $res['value'];
                                                                                                                                        }

                                                                                                                                        if ($res['key'] == 'login_type') {
                                                                                                                                            $login_type = $res['value'];
                                                                                                                                        }

                                                                                                                                    }
                                                                                                                                    if ($login_type == 'email') {
                                                                                                                                        ?>
                                                                                                                                        <a class="dropdown-item" href="<?php echo base_url() ?>provider-change-password"><?php echo (!empty($user_language[$user_selected]['lg_change_password'])) ? $user_language[$user_selected]['lg_change_password'] : $default_language['en']['lg_change_password']; ?></a>
                                    
                                                                                                                                        <?php } ?>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>user-chat"><?php echo (!empty($user_language[$user_selected]['lg_chat'])) ? $user_language[$user_selected]['lg_chat'] : $default_language['en']['lg_chat']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>logout"><?php echo (!empty($user_language[$user_selected]['lg_Logout'])) ? $user_language[$user_selected]['lg_Logout'] : $default_language['en']['lg_Logout']; ?></a>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <!-- /User Menu -->
                                                                                            

                                                                        <?php } elseif ($this->session->userdata('usertype') == 'user') { ?>
                                                             


                                                                                                                            <!-- Notifications -->
                                                                                                                            <li class="nav-item dropdown logged-item">
                                                                                                                                <?php
                                                                                                                                if (!empty($this->session->userdata('chat_token'))) {
                                                                                                                                    $ses_token = $this->session->userdata('chat_token');
                                                                                                                                } else {
                                                                                                                                    $ses_token = '';
                                                                                                                                }
                                                                                                                                if (!empty($ses_token)) {
                                                                                                                                    $ret = $this->db->select('*')->
                                                                                                                                        from('notification_table')->
                                                                                                                                        where('receiver', $ses_token)->
                                                                                                                                        where('status', 1)->
                                                                                                                                        order_by('notification_id', 'DESC')->
                                                                                                                                        get()->result_array();
                                                                                                                                    $notification = [];
                                                                                                                                    if (!empty($ret)) {
                                                                                                                                        foreach ($ret as $key => $value) {
                                                                                                                                            $user_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                from('users')->
                                                                                                                                                where('token', $value['sender'])->
                                                                                                                                                get()->row();
                                                                                                                                            $provider_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                from('providers')->
                                                                                                                                                where('token', $value['sender'])->
                                                                                                                                                get()->row();
                                                                                                                                            if (!empty($user_table)) {
                                                                                                                                                $user_info = $user_table;
                                                                                                                                            } else {
                                                                                                                                                $user_info = $provider_table;
                                                                                                                                            }
                                                                                                                                            $notification[$key]['name'] = !empty($user_info->name) ? $user_info->name : '';
                                                                                                                                            $notification[$key]['message'] = !empty($value['message']) ? $value['message'] : '';
                                                                                                                                            $notification[$key]['profile_img'] = !empty($user_info->profile_img) ? $user_info->profile_img : '';
                                                                                                                                            $notification[$key]['created_at'] = !empty($value['created_at']) ? $value['created_at'] : '';
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    $n_count = count($notification);
                                                                                                                                } else {
                                                                                                                                    $n_count = 0;
                                                                                                                                    $notification = [];
                                                                                                                                }

                                                                                                                                /* notification Count */
                                                                                                                                if (!empty($n_count) && $n_count != 0) {
                                                                                                                                    $notify = "<span class='badge badge-pill bg-yellow'>" . $n_count . "</span>";
                                                                                                                                } else {
                                                                                                                                    $notify = "";
                                                                                                                                }
                                                                                                                                ?>
                                                                                                

                                                                                                                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                    <i class="fas fa-bell"></i> <?php echo $notify; ?>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right notifications">
                                                                                                                                    <div class="topnav-dropdown-header">
                                                                                                                                        <span class="notification-title"><?php echo (!empty($user_language[$user_selected]['lg_Notifications'])) ? $user_language[$user_selected]['lg_Notifications'] : $default_language['en']['lg_Notifications']; ?></span>
                                                                                                                                        <a href="javascript:void(0)" class="clear-noti noty_clear" data-token="<?php echo $this->session->userdata('chat_token'); ?>" > <?php echo (!empty($user_language[$user_selected]['lg_clear_all'])) ? $user_language[$user_selected]['lg_clear_all'] : $default_language['en']['lg_clear_all']; ?> </a>
                                                                                                                                    </div>
                                                                                                                                    <div class="noti-content">
                                                                                                                                        <ul class="notification-list">
                                                                                                                                            <?php
                                                                                                                                            if (!empty($notification)) {
                                                                                                                                                foreach ($notification as $key => $notify) {
                                                                                                                                                    $datef = explode(' ', $notify["created_at"]);
                                                                                                                                                    if (settingValue('time_format') == '12 Hours') {
                                                                                                                                                        $time = date('h:ia', strtotime($datef[1]));
                                                                                                                                                    } elseif (settingValue('time_format') == '24 Hours') {
                                                                                                                                                        $time = date('H:i:s', strtotime($datef[1]));
                                                                                                                                                    } else {
                                                                                                                                                        $time = date('G:ia', strtotime($datef[1]));
                                                                                                                                                    }
                                                                                                                                                    $date = date(settingValue('date_format'), strtotime($datef[0]));
                                                                                                                                                    $timeBase = $date . ' ' . $time;



                                                                                                                                                    if (file_exists($notify['profile_img'])) {
                                                                                                                                                        $profile_img = $notify['profile_img'];
                                                                                                                                                    } else {
                                                                                                                                                        $profile_img = 'assets/img/user.jpg';
                                                                                                                                                    }
                                                                                                                                                    ?>

                                                                                                                                                                                                                                                    <li class="notification-message">
                                                                                                                                                                                                                                                        <a href="<?php echo base_url(); ?>notification-list">
                                                                                                                                                                                                                                                            <div class="media">
                                                                                                                                                                                                                                                                <span class="avatar avatar-sm">
                                                                                                                                                                                                                                                                    <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url() . $profile_img; ?>">
                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                <div class="media-body">
                                                                                                                                                                                                                                                                    <p class="noti-details"> <span class="noti-title"><?php echo ucfirst($notify['message']); ?></span></p>
                                                                                                                                                                                                                                                                    <p class="noti-time"><span class="notification-time"><?php echo $timeBase; ?></span></p>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                                                    <?php
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                ?>
                                                                                                                                                                                                <li class="notification-message">
                                                                                                                                                                                                    <p class="text-center text-danger mt-3"><?php echo (!empty($user_language[$user_selected]['lg_notification_empty'])) ? $user_language[$user_selected]['lg_notification_empty'] : $default_language['en']['lg_notification_empty']; ?></p>
                                                                                                                                                                                                </li>
                                                                                                                                            <?php } ?>
                                                                                                                                        </ul>
                                                                                                                                    </div>
                                                                                                                                    <div class="topnav-dropdown-footer">
                                                                                                                                        <a href="<?php echo base_url(); ?>notification-list"><?php echo (!empty($user_language[$user_selected]['lg_view_notification'])) ? $user_language[$user_selected]['lg_view_notification'] : $default_language['en']['lg_view_notification']; ?></a>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <!-- /Notifications -->

                                                                                                                            <?php if (!empty($this->session->userdata('id'))) { ?>
                                                                                                                                                                                <!-- chat -->
                                                                                                                                                                                <?php
                                                                                                                                                                                $chat_token = $this->session->userdata('chat_token');
                                                                                                                                                                                if (!empty($chat_token)) {
                                                                                                                                                                                    $chat_detail = $this->db->where('receiver_token', $chat_token)->where('read_status=', 0)->get('chat_table')->result_array();
                                                                                                                                                                                }
                                                                                                                                                                                ?>
                                                                                                                                                                                <li class="nav-item dropdown logged-item">

                                                                                                                                                                                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                                                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                                                                                                                                                                        <?php if (count($chat_detail) != 0) { ?>
                                                                                                                                                                                                                                            <span class="badge badge-pill bg-yellow chat-bg-yellow"><?php echo count($chat_detail); ?></span>
                                                                                                                                                                                        <?php } ?>
                                                                                                                                                                                    </a>

                                                                                                                                                                                    <div class="dropdown-menu comments-blk dropdown-menu-right notifications">
                                                                                                                                                                                        <div class="topnav-dropdown-header">
                                                                                                                                                                                            <span class="notification-title"><?php echo (!empty($user_language[$user_selected]['lg_chats'])) ? $user_language[$user_selected]['lg_chats'] : $default_language['en']['lg_chats']; ?></span>
                                                                                                                                                                                            <a href="javascript:void(0)" class="clear-noti chat_clear_all" data-token="<?php echo $this->session->userdata('chat_token'); ?>" > <?php echo (!empty($user_language[$user_selected]['lg_clear_all'])) ? $user_language[$user_selected]['lg_clear_all'] : $default_language['en']['lg_clear_all']; ?> </a>
                                                                                                                                                                                        </div>

                                                                                                                                                                                        <div class="noti-content">
                                                                                                                                                                                            <ul class="chat-list notification-list">
                                                                                                                                                                                                <?php
                                                                                                                                                                                                if (count($chat_detail) > 0) {
                                                                                                                                                                                                    $sender = '';
                                                                                                                                                                                                    foreach ($chat_detail as $row) {

                                                                                                                                                                                                        $user_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                                                                            from('users')->
                                                                                                                                                                                                            where('token', $row['sender_token'])->
                                                                                                                                                                                                            get()->row();
                                                                                                                                                                                                        $provider_table = $this->db->select('id,name,profile_img,token,type')->
                                                                                                                                                                                                            from('providers')->
                                                                                                                                                                                                            where('token', $row['sender_token'])->
                                                                                                                                                                                                            get()->row();
                                                                                                                                                                                                        if (!empty($user_table)) {
                                                                                                                                                                                                            $user_info = $user_table;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            $user_info = $provider_table;
                                                                                                                                                                                                        }
                                                                                                                                                                                                        $datef = explode(' ', $row["created_at"]);
                                                                                                                                                                                                        if (settingValue('time_format') == '12 Hours') {
                                                                                                                                                                                                            $time = date('h:ia', strtotime($datef[1]));
                                                                                                                                                                                                        } elseif (settingValue('time_format') == '24 Hours') {
                                                                                                                                                                                                            $time = date('H:i:s', strtotime($datef[1]));
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            $time = date('G:ia', strtotime($datef[1]));
                                                                                                                                                                                                        }

                                                                                                                                                                                                        $date = date(settingValue('date_format'), strtotime($datef[0]));
                                                                                                                                                                                                        $timeBase = $date . ' ' . $time;

                                                                                                                                                                                                        if (file_exists($user_info->profile_img)) {
                                                                                                                                                                                                            $profile_img = $user_info->profile_img;
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            $profile_img = 'assets/img/user.jpg';
                                                                                                                                                                                                        }
                                                                                                                                                                                                        ?>

                                                                                                                                                                                                                                                                                                        <li class="notification-message">
                                                                                                                                                                                                                                                                                                            <a href="<?php echo base_url(); ?>user-chat">
                                                                                                                                                                                                                                                                                                                <div class="media">
                                                                                                                                                                                                                                                                                                                    <span class="avatar avatar-sm">

                                                                                                                                                                                                                                                                                                                        <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url() . $profile_img; ?>">
                                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                                    <div class="media-body">
                                                                                                                                                                                                                                                                                                                        <p class="noti-details"> <span class="noti-title"><?php echo $user_info->name . " send a message as " . $row['message']; ?></span></p>
                                                                                                                                                                                                                                                                                                                        <p class="noti-time"><span class="notification-time"><?php echo $timeBase; ?></span></p>
                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                        <?php
                                                                                                                                                                                                    }
                                                                                                                                                                                                }
                                                                                                                                                                                                if (count($chat_detail) == 0) {
                                                                                                                                                                                                    ?>

                                                                                                                                                                                                                                                    <li class="notification-message">
                                                                                                                                                                                                                                                        <p class="text-center text-danger mt-3"><?php echo (!empty($user_language[$user_selected]['lg_chat_empty'])) ? $user_language[$user_selected]['lg_chat_empty'] : $default_language['en']['lg_chat_empty']; ?></p>
                                                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                <?php } ?>

                                                                                                                                                                                            </ul>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="topnav-dropdown-footer">
                                                                                                                                                                                            <a href="<?php echo base_url(); ?>user-chat"><?php echo (!empty($user_language[$user_selected]['lg_view_all_chat'])) ? $user_language[$user_selected]['lg_view_all_chat'] : $default_language['en']['lg_view_all_chat']; ?></a>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </li>
                                                                                                                                                                                <!-- /chat -->
                                                                                                                            <?php } ?>
                                                                                            
                                                                                                                            <li class="nav-item dropdown has-arrow logged-item">
                                                                                                                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                                                                                                                    <span class="user-img">
                                                                                                                                        <?php if (file_exists($user_details['profile_img'])) { ?>
                                                                                                                                                    <img class="rounded-circle" src="<?php echo $base_url . $user_details['profile_img'] ?>" alt="">
                                                                                                                                        <?php } else { ?>
                                                                                                                                                    <img class="rounded-circle" src="<?php echo (settingValue('profile_placeholder_image')) ? base_url() . settingValue('profile_placeholder_image') : base_url() . 'assets/img/user.jpg'; ?>" alt="">
                                                                                                                                        <?php } ?>
                                                                                                                                    </span>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <div class="user-header">
                                                                                                                                        <div class="avatar avatar-sm">
                                                                                                                                            <?php if (file_exists($user_details['profile_img'])) { ?>
                                                                                                                                                         <img class="avatar-img rounded-circle" src="<?php echo $base_url . $user_details['profile_img'] ?>" alt="">
                                                                                                                                            <?php } else { ?>
                                                                                                                                                          <img class="avatar-img rounded-circle" src="<?php echo (settingValue('profile_placeholder_image')) ? base_url() . settingValue('profile_placeholder_image') : base_url() . 'assets/img/user.jpg'; ?>" alt="">
                                                                                                                                            <?php } ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="user-text">
                                                                                                                                            <h6><?php echo $user_details['name']; ?></h6>
                                                                                                                                            <p class="text-muted mb-0"><?php echo (!empty($user_language[$user_selected]['lg_User'])) ? $user_language[$user_selected]['lg_User'] : $default_language['en']['lg_User']; ?></p>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>user-dashboard"><?php echo (!empty($user_language[$user_selected]['lg_Dashboard'])) ? $user_language[$user_selected]['lg_Dashboard'] : $default_language['en']['lg_Dashboard']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>user-bookings"><?php echo (!empty($user_language[$user_selected]['lg_My_Bookings'])) ? $user_language[$user_selected]['lg_My_Bookings'] : $default_language['en']['lg_My_Bookings']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>myquote-list">My Quote List</a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>user-favorites"><?php echo (!empty($user_language[$user_selected]['lg_My_Favorites'])) ? $user_language[$user_selected]['lg_My_Favorites'] : $default_language['en']['lg_My_Favorites']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url(); ?>user-settings"><?php echo (!empty($user_language[$user_selected]['lg_Profile_Settings'])) ? $user_language[$user_selected]['lg_Profile_Settings'] : $default_language['en']['lg_Profile_Settings']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>all-services"><?php echo (!empty($user_language[$user_selected]['lg_Book_Service'])) ? $user_language[$user_selected]['lg_Book_Service'] : $default_language['en']['lg_Book_Service']; ?></a>
                                    
                                                                                                                                    <?php
                                                                                                                                    $query = $this->db->query("select * from system_settings WHERE status = 1");
                                                                                                                                    $result = $query->result_array();

                                                                                                                                    $login_type = '';
                                                                                                                                    foreach ($result as $res) {

                                                                                                                                        if ($res['key'] == 'login_type') {
                                                                                                                                            $login_type = $res['value'];
                                                                                                                                        }

                                                                                                                                        if ($res['key'] == 'login_type') {
                                                                                                                                            $login_type = $res['value'];
                                                                                                                                        }

                                                                                                                                    }
                                                                                                                                    if ($login_type == 'email') {
                                                                                                                                        ?>
                                                                                                                                                <a class="dropdown-item" href="<?php echo base_url() ?>change-password"><?php echo (!empty($user_language[$user_selected]['lg_change_password'])) ? $user_language[$user_selected]['lg_change_password'] : $default_language['en']['lg_change_password']; ?></a>
                                    
                                                                                                                                        <?php } ?>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>user-chat"><?php echo (!empty($user_language[$user_selected]['lg_chat'])) ? $user_language[$user_selected]['lg_chat'] : $default_language['en']['lg_chat']; ?></a>
                                                                                                                                    <a class="dropdown-item" href="<?php echo base_url() ?>logout"><?php echo (!empty($user_language[$user_selected]['lg_Logout'])) ? $user_language[$user_selected]['lg_Logout'] : $default_language['en']['lg_Logout']; ?></a>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <?php
                                                                        }
                    }
                    ?>
                </ul>
            </nav>
           
                    </header>
    </div>
   
 <!-- quote modle  -->
     
     <!-- DJ-modal -->
     <!-- quote modle  -->
    <div id="main_container">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_1">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->
 
                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">   
                              <form id="regForm" class="qs" method="post" action="<?= base_url() ?>insert-ans">
                               <!-- insert-ans ,service-selection --> 
                                <h1 id ="DJ" name="DJ">DJ</h1><br>
                                <input type="hidden" name="category_id" value="4"></input>
                                <!-- One "tab" for each step in the form: -->
                                <div class="tab">
                                    <h4>What is Event Duration ?</h4>
                                            <p><input type="radio" value="1 hour" name="q1" id="eventduration1"
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1">1 hour</label >
                                            </p>
                                            <p><input type="radio" value="2-3 hour" name="q1" id="eventduration2"
                                                    oninput="this.className = ''"> <label class="lab" for="" >2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half day" name="q1" id="eventduration3"
                                                    oninput="this.className = ''"> <label class="lab" for="" >half
                                                    day</label>
                                            </p>

                                            <p><input type="radio" value="full day" name="q1" id="eventduration4"
                                                    oninput="this.className = ''"> <label class="lab" for="" >full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab" style="display:none">
                                    <h4 name="question">What is Event date ?</h4>
                                            <p>
                                               
                                                    <input type="text" id="my-range-field"  size="30" name="q2">
                                            </p>
                                </div>

                                <div class="tab" style="display:none">
                                    <h4 name="question">Where is Event ?</h4>
                                            <p><input type="text"  name="q3" id="eventplace"
                                                    oninput="this.className = ''" >
                                            </p>
                                </div>
    

                                <div class="tab" style="display:none">
                                    <h4 name="question">Number of guests? </h4>
                                            <p><input type="text"  name="q4" id="eventguest"
                                                    oninput="this.className = ''"/>
                                            </p>
                                </div>
                                <div class="tab" style="display:none">
                                
                                    <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="q5" id="currentInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="q5" id="currentInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="q5" id="currentInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="q5" id="currentInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>
                              </div>

                             

                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn" class="b1"
                                            onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" id="nextBtn" class="b1" name=""
                                            onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                </div>

                            </form>
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>
<!-- quote modle  -->
<script>
    
</script>

      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request');
var $Mc = $('#main_container');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container")
    $(".request li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
        <!-- <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

//working login status code//
function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;

    // Check if user is logged in
    var isLoggedIn = checkSession();
    if (!isLoggedIn) {
        // User is not logged in, redirect to login page
        //  document.querySelector('.header-login').click(); // Trigger click event on login link
        // document.querySelector('#tab_login_modal').click();
        // return false;
        // alert("heii");
    }
    else {
        alert("hello");
    }

    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
        //...the form gets submitted:
            document.querySelector('.header-login').click();
        document.getElementById("regForm").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function checkSession() {
    // Check if session variable exists that indicates user is logged in
    // Replace 'loggedIn' with the actual name of the session variable
    var isLoggedIn = sessionStorage.getItem("loggedIn");
    if (isLoggedIn === "true") {
        return true;
    } else {
        return false;
    }
}
        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script> -->
    <!-- DJ-modal END -->

         <!-- Makeup Artist -modal -->
     <!-- quote modle  -->
    <div id="main_container1">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_2">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->

                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">
                            <!-- <div id="top-wizard">
                                <strong>Progress</strong>
                                <div id="progressbar"
                                    class="ui-progressbar ui-widget ui-widget-content ui-corner-all"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="ui-progressbar-value ui-widget-header ui-corner-left"
                                        style="display: none; width: 0%;"></div>
                                </div>
                            </div> -->
                            <!-- /top-wizard -->

                            <form id="regForm1" class="qs" method="post" action="<?= base_url() ?>insert-makeup-ans">

                                <h1>Makeup Artist</h1><br>
                                <input type="hidden" name="makeup_id" value="3"></input>

                                <!-- One "tab" for each step in the form: -->
                                <div class="tab1">
                                    <h4 name="question">What is Event Duration ?<h4>
                                            <p><input type="radio" value="1 hour" name="make1" 
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1" name="ans">1 hour</label>
                                            </p>
                                            <p><input type="radio" value="2-3 hour" name="make1" 
                                                    oninput="this.className = ''"> <label class="lab" for="opt2" name="ans">2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half day" name="make1" 
                                                    oninput="this.className = ''"> <label class="lab" for="opt3" name="ans">half day
                                                    </label>
                                            </p>

                                            <p><input type="radio" value="full day" name="make1" 
                                                    oninput="this.className = ''"> <label class="lab" for="opt4" name="ans">full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab1" style="display:none">
                                    <h4 name="question">What is Event date ?<h4>
                                            <p>
                                                <!-- <input type="date" value="op1" name="date" id="datepicker"
                                                    oninput="this.className = ''"> -->
                                                    <input type="text" id="my-range-field1" size="30" name="make2" />
                                            </p>
                                            
                                            
                                </div>
                                

                                <div class="tab1" style="display:none">
                                    <h4 name="question">Where is Event ?<h4>
                                            <p><input type="text" value="" name="make3" id="make3"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab1" style="display:none">
                                    <h4 name="question">Number of guests? <h4>
                                            <p><input type="text" value="" name="make4" id="make4"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>
                                <div class="tab1" style="display:none">
                                 <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="make5" id="makeInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="make5" id="makeInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="make5" id="makeInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="make5" id="makeInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>

                                </div>
                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                    
                                        <button type="button" id="prevBtn1" class="b1"
                                            onclick="nextPrev1(-1)">Previous</button>
                                        <button type="button" id="nextBtn1" class="b1"
                                            onclick="nextPrev1(1)">Next</button>
                                    </div>
                                </div>


                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step1"></span>
                                    <span class="step1"></span>
                                    <span class="step1"></span>
                                    <span class="step1"></span>
                                    <span class="step1"></span>
                                </div>

                            </form>
                            
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>
<!-- quote modle  -->

       <script>
        flatpickr("#my-range-field1", {
          mode: "range"
        });
      </script>
      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request1');
var $Mc = $('#main_container1');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request1  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container1")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container1")
    $(".request1 li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
   
        <script>
        // var currentTab1 = 0; // Current tab is set to be the first tab (0)
        // showTab1(currentTab1); // Display the current tab

        // function showTab1(n) {
        //     // This function will display the specified tab of the form ...
        //     var x = document.getElementsByClassName("tab1");
        //     x[n].style.display = "block";
        //     // ... and fix the Previous/Next buttons:
        //     if (n == 0) {
        //         document.getElementById("prevBtn1").style.display = "none";
        //     } else {
        //         document.getElementById("prevBtn1").style.display = "inline";
        //     }
        //     if (n == (x.length - 1)) {
        //         document.getElementById("nextBtn1").innerHTML = "Submit";
        //     } else {
        //         document.getElementById("nextBtn1").innerHTML = "Next";
        //     }
        //     // ... and run a function that displays the correct step indicator:
        //     fixStepIndicator1(n)
        // }

        // function nextPrev1(n) {
        //     // This function will figure out which tab to display
        //     var x = document.getElementsByClassName("tab1");
        //     // Exit the function if any field in the current tab is invalid:
        //     if (n == 1 && !validateForm1()) return false;
        //     // Hide the current tab:
        //     x[currentTab1].style.display = "none";
        //     // Increase or decrease the current tab by 1:
        //     currentTab1 = currentTab1 + n;
        //     // if you have reached the end of the form... :
        //     if (currentTab1 >= x.length) {
        //         //...the form gets submitted:
        //         document.getElementById("regForm1").submit();
        //         return false;
        //     }
        //     // Otherwise, display the correct tab:
        //     showTab1(currentTab1);
        // }

        // function validateForm1() {
        //     // This function deals with validation of the form fields
        //     var x, y, i, valid = true;
        //     x = document.getElementsByClassName("tab1");
        //     y = x[currentTab1].getElementsByTagName("input");
        //     // A loop that checks every input field in the current tab:
        //     for (i = 0; i < y.length; i++) {
        //         // If a field is empty...
        //         if (y[i].value == "") {
        //             // add an "invalid" class to the field:
        //             y[i].className += " invalid";
        //             // and set the current valid status to false:
        //             valid = false;
        //         }
        //     }
        //     // If the valid status is true, mark the step as finished and valid:
        //     if (valid) {
        //         document.getElementsByClassName("step1")[currentTab1].className += " finish1";
        //     }
        //     return valid; // return the valid status
        // }

        function fixStepIndicator1(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step1");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script>
    <script>
$(function() {
    $("#datepicker").datepicker({
        onSelect: function(dateText) {
            var selectedDate = $(this).datepicker("getDate");
            if (!selectedDate) {
                selectedDate = new Date();
            }
            selectedDate.setDate(selectedDate.getDate() + 1);
            $(this).datepicker("setDate", selectedDate);
        },
        beforeShowDay: function(date) {
            var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [true, datesToHighlight.indexOf(dateString) !== -1 ? "highlight" : ""];
        }
    });
});
</script>
    <!-- Makeup Artist-modal END -->

    <!-- Chair / Table Decoration -->
         <!-- quote modle  -->
    <div id="main_container2">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_3">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->

                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">
                            <!-- <div id="top-wizard">
                                <strong>Progress</strong>
                                <div id="progressbar"
                                    class="ui-progressbar ui-widget ui-widget-content ui-corner-all"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="ui-progressbar-value ui-widget-header ui-corner-left"
                                        style="display: none; width: 0%;"></div>
                                </div>
                            </div> -->
                            <!-- /top-wizard -->

                            <form id="regForm2" class="qs" method="post" action="<?= base_url() ?>insert-chair-ans">

                                <h1>Chair/Table Decoration</h1><br>
                                <input type="hidden" name="chair_id" value="7"></input>
                                <!-- One "tab" for each step in the form: -->
                                <div class="tab2">
                                    <h4>What is Event Duration ?<h4>
                                            <p><input type="radio" value="1 hour " name="chair1" id=opt1
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1">1 hour</label>
                                            </p>
                                            <p><input type="radio" value="2-3 hour" name="chair1" id="opt2"
                                                    oninput="this.className = ''"> <label class="lab" for="">2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half day" name="chair1" id="opt3"
                                                    oninput="this.className = ''"> <label class="lab" for="">half
                                                    day</label>
                                            </p>

                                            <p><input type="radio" value="full day" name="chair1" id="opt4"
                                                    oninput="this.className = ''"> <label class="lab" for="">full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab2" style="display:none">
                                    <h4>What is Event date ?<h4>
                                            <p>
                                            <input type="text" name="chair2" id="my-range-field2" size="30" />
                                            </p>
                                </div>

                                <div class="tab2" style="display:none">
                                    <h4>Where is Event ?<h4>
                                            <p><input type="text" value="" name="chair3" id="chair3"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab2" style="display:none">
                                    <h4>Number of guests? <h4>
                                            <p><input type="text" value="" name="chair4" id="chair4"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>
                                <div class="tab2" style="display:none">
                                  <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="chair5" id="chairInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="chair5" id="chairInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="chair5" id="chairInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="chair5" id="chairInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>
                                </div>

                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn2" class="b1"
                                            onclick="nextPrev2(-1)">Previous</button>
                                        <button type="button" id="nextBtn2" class="b1"
                                            onclick="nextPrev2(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step2"></span>
                                    <span class="step2"></span>
                                    <span class="step2"></span>
                                    <span class="step2"></span>
                                    <span class="step2"></span>
                                </div>

                            </form>
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>
<!-- quote modle  -->
<script>
        flatpickr("#my-range-field2", {
          mode: "range"
        });
</script>
      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request2');
var $Mc = $('#main_container2');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request2  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container2")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container2")
    $(".request2 li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
        <!-- <script>
        // var currentTab1 = 0; // Current tab is set to be the first tab (0)
        // showTab2(currentTab1); // Display the current tab

        // function showTab2(n) {
        //     // This function will display the specified tab of the form ...
        //     var x = document.getElementsByClassName("tab2");
        //     x[n].style.display = "block";
        //     // ... and fix the Previous/Next buttons:
        //     if (n == 0) {
        //         document.getElementById("prevBtn2").style.display = "none";
        //     } else {
        //         document.getElementById("prevBtn2").style.display = "inline";
        //     }
        //     if (n == (x.length - 1)) {
        //         document.getElementById("nextBtn2").innerHTML = "Submit";
        //     } else {
        //         document.getElementById("nextBtn2").innerHTML = "Next";
        //     }
        //     // ... and run a function that displays the correct step indicator:
        //     fixStepIndicator2(n)
        // }

        // function nextPrev2(n) {
        //     // This function will figure out which tab to display
        //     var x = document.getElementsByClassName("tab2");
        //     // Exit the function if any field in the current tab is invalid:
        //     if (n == 1 && !validateForm2()) return false;
        //     // Hide the current tab:
        //     x[currentTab1].style.display = "none";
        //     // Increase or decrease the current tab by 1:
        //     currentTab1 = currentTab1 + n;
        //     // if you have reached the end of the form... :
        //     if (currentTab1 >= x.length) {
        //         //...the form gets submitted:
        //         document.getElementById("regForm2").submit();
        //         return false;
        //     }
        //     // Otherwise, display the correct tab:
        //     showTab2(currentTab1);
        // }

        // function validateForm2() {
        //     // This function deals with validation of the form fields
        //     var x, y, i, valid = true;
        //     x = document.getElementsByClassName("tab2");
        //     y = x[currentTab1].getElementsByTagName("input");
        //     // A loop that checks every input field in the current tab:
        //     for (i = 0; i < y.length; i++) {
        //         // If a field is empty...
        //         if (y[i].value == "") {
        //             // add an "invalid" class to the field:
        //             y[i].className += " invalid";
        //             // and set the current valid status to false:
        //             valid = false;
        //         }
        //     }
        //     // If the valid status is true, mark the step as finished and valid:
        //     if (valid) {
        //         document.getElementsByClassName("step2")[currentTab1].className += " finish";
        //     }
        //     return valid; // return the valid status
        // }

        // function fixStepIndicator2(n) {
        //     // This function removes the "active" class of all steps...
        //     var i, x = document.getElementsByClassName("step2");
        //     for (i = 0; i < x.length; i++) {
        //         x[i].className = x[i].className.replace(" active", "");
        //     }
        //     //... and adds the "active" class to the current step:
        //     x[n].className += " active";
        // }
    </script> -->
    <!-- END Chair / Table Decoration -->
    <!-- Event Organizer -->
    
         <!-- quote modle  -->
    <div id="main_container3">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_4">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->

                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">
                            <!-- <div id="top-wizard">
                                <strong>Progress</strong>
                                <div id="progressbar"
                                    class="ui-progressbar ui-widget ui-widget-content ui-corner-all"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="ui-progressbar-value ui-widget-header ui-corner-left"
                                        style="display: none; width: 0%;"></div>
                                </div>
                            </div> -->
                            <!-- /top-wizard -->

                            <form id="regForm3" class="qs" method="post" action="<?= base_url() ?>insert-event-ans">

                                <h1>Event Organiser</h1><br>
                                <input type="hidden" name="event_id" value="8"></input>

                                <!-- One "tab" for each step in the form: -->
                                <div class="tab3">
                                    <h4>What is Event Duration ?<h4>
                                            <p><input type="radio" value="1 hour" name="event1" id=opt1
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1">1 hour</label>
                                            </p>
                                            <p><input type="radio" value="2-3 hour" name="event1" id="opt2"
                                                    oninput="this.className = ''"> <label class="lab" for="">2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half day" name="event1" id="opt3"
                                                    oninput="this.className = ''"> <label class="lab" for="">half
                                                    day</label>
                                            </p>

                                            <p><input type="radio" value="full day" name="event1" id="opt4"
                                                    oninput="this.className = ''"> <label class="lab" for="">full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab3" style="display:none">
                                    <h4>What is Event date ?<h4>
                                            <p><input type="text" name="event2" id="my-range-field3" size="30" />
                                            </p>
                                            
                                </div>

                                <div class="tab3" style="display:none">
                                    <h4>Where is Event ?<h4>
                                            <p><input type="text" value="" name="event3" id="event3"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab3" style="display:none">
                                    <h4>Number of guests? <h4>
                                            <p><input type="text" value="" name="event4" id="event4"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab3" style="display:none">
                                  <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="event5" id="eventInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="event5" id="eventInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="event5" id="eventInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="event5" id="eventInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>
                                </div>

                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn3" class="b1"
                                            onclick="nextPrev3(-1)">Previous</button>
                                        <button type="button" id="nextBtn3" class="b1"
                                            onclick="nextPrev3(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step3"></span>
                                    <span class="step3"></span>
                                    <span class="step3"></span>
                                    <span class="step3"></span>
                                    <span class="step3"></span>
                                </div>

                            </form>
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>
<script src="<?php echo base_url(); ?>assets\js\flatpickr.js"></script>
<script>
        flatpickr("#my-range-field3", {
          mode: "range"
        });
      </script>
<!-- quote modle  -->

      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request3');
var $Mc = $('#main_container3');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request3  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container3")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container3")
    $(".request3 li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
        <!-- <script>
        var currentTab1 = 0; // Current tab is set to be the first tab (0)
        showTab3(currentTab1); // Display the current tab

        function showTab3(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab3");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn3").style.display = "none";
            } else {
                document.getElementById("prevBtn3").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn3").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn3").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator3(n)
        }

        function nextPrev3(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab3");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm3()) return false;
            // Hide the current tab:
            x[currentTab1].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab1 = currentTab1 + n;
            // if you have reached the end of the form... :
            if (currentTab1 >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm3").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab3(currentTab1);
        }

        function validateForm3() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab3");
            y = x[currentTab1].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step3")[currentTab1].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator3(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step3");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script> -->

    <!--END Event Organizer -->
    <!-- Photographer -->
           <!-- quote modle  -->
    <div id="main_container4">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_5">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->

                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">
                            <!-- <div id="top-wizard">
                                <strong>Progress</strong>
                                <div id="progressbar"
                                    class="ui-progressbar ui-widget ui-widget-content ui-corner-all"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="ui-progressbar-value ui-widget-header ui-corner-left"
                                        style="display: none; width: 0%;"></div>
                                </div>
                            </div> -->
                            <!-- /top-wizard -->

                            <form id="regForm4" class="qs" method="post" action="<?= base_url() ?>insert-photo-ans">

                                <h1>Photographer</h1>
                                <input type="hidden" name="photo_id" value="5"></input><br>

                                <!-- One "tab" for each step in the form: -->
                                <div class="tab4">
                                    <h4>What is Event Duration ?<h4>
                                            <p><input type="radio" value="1 hour" name="photo1" id=opt1
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1">1 hour</label>
                                            </p>
                                            <p><input type="radio" value="2-3 hour" name="photo1" id="opt2"
                                                    oninput="this.className = ''"> <label class="lab" for="">2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half day" name="photo1" id="opt3"
                                                    oninput="this.className = ''"> <label class="lab" for="">half
                                                    day</label>
                                            </p>

                                            <p><input type="radio" value="full day" name="photo1" id="opt4"
                                                    oninput="this.className = ''"> <label class="lab" for="">full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab4" style="display:none">
                                    <h4>What is Event date ?<h4>
                                            <p>
                                                <!-- <input type="date" value="op1" name="date" id="date1"
                                                    oninput="this.className = ''"> -->
                                                    <input type="text" name="photo2" id="my-range-field4" size="30" />
                                            </p>
                                </div>

                                <div class="tab4" style="display:none">
                                    <h4>Where is Event ?<h4>
                                            <p><input type="text" value="" name="photo3" id="photo3"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab4" style="display:none">
                                    <h4>Number of guests? <h4>
                                            <p><input type="text" value="" name="photo4" id="photo4"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>
                                <div class="tab4" style="display:none">
                                <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="make5" id="photoInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="make5" id="photoInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="make5" id="photoInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="make5" id="photoInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>
                                </div>

                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn4" class="b1"
                                            onclick="nextPrev4(-1)">Previous</button>
                                        <button type="button" id="nextBtn4" class="b1"
                                            onclick="nextPrev4(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step4"></span>
                                    <span class="step4"></span>
                                    <span class="step4"></span>
                                    <span class="step4"></span>
                                    <span class="step4"></span>
                                </div>

                            </form>
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>
<script src="<?php echo base_url(); ?>assets\js\flatpickr.js"></script>
<script>
        flatpickr("#my-range-field4", {
          mode: "range"
        });
      </script>
<!-- quote modle  -->

      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request4');
var $Mc = $('#main_container4');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request4  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container4")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container4")
    $(".request4 li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
        <!-- <script>
        var currentTab1 = 0; // Current tab is set to be the first tab (0)
        showTab4(currentTab1); // Display the current tab

        function showTab4(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab4");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn4").style.display = "none";
            } else {
                document.getElementById("prevBtn4").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn4").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn4").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator4(n)
        }

        function nextPrev4(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab4");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm4()) return false;
            // Hide the current tab:
            x[currentTab1].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab1 = currentTab1 + n;
            // if you have reached the end of the form... :
            if (currentTab1 >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm4").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab4(currentTab1);
        }

        function validateForm4() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab4");
            y = x[currentTab1].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step4")[currentTab1].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator4(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step4");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script> -->
     <!--END Photographer -->
    <!-- Master Of Ceremony -->
              <!-- quote modle  -->
    <div id="main_container5">

<div id="header_in">
    <a href="#0" class="close_in close_border "><i class="fas fa-times"></i></a>
</div>

<div class="wrapper_in">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab_6">

                <div class="subheader" id="quote">
                    <img src="uploads/logo/1678367133_logo.png" alt="" class="img-pos">
                </div>
                <div class="row">
                    <aside class="col-xl-3 col-lg-4">
                        <h2 class="fill-h2">Fill the form and we will reply with custom quote for your needs.</h2>

                        <ul class="list_ok">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Share your requirement with us.</li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Please feel free to include any additional information on any question you have.
                            </li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <li>Once submitted, our team will review and get back to you as soon as possible.
                            </li>
                        </ul>
                    </aside><!-- /aside -->

                    <div class="col-xl-9 col-lg-8">
                        <div id="wizard_container" class="wizard" novalidate="novalidate">
                            <!-- <div id="top-wizard">
                                <strong>Progress</strong>
                                <div id="progressbar"
                                    class="ui-progressbar ui-widget ui-widget-content ui-corner-all"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="ui-progressbar-value ui-widget-header ui-corner-left"
                                        style="display: none; width: 0%;"></div>
                                </div>
                            </div> -->
                            <!-- /top-wizard -->

                            <form id="regForm5" class="qs" method="post" action="<?= base_url() ?>insert-master-ans">

                                <h1>Master Of Ceremony</h1>
                                <input type="hidden" name="master_id" value="6"></input><br>

                                <!-- One "tab" for each step in the form: -->
                                <div class="tab5">
                                    <h4>What is Event Duration ?<h4>
                                            <p><input type="radio" value="1 hour" name="master1" id=opt1
                                                    oninput="this.className = ''">
                                                <label class="lab" for="opt1">1 hour</label>
                                            </p>
                                            <p><input type="radio" value="2-3
                                                    hour" name="master1" id="opt2"
                                                    oninput="this.className = ''"> <label class="lab" for="">2-3
                                                    hour</label>
                                            </p>
                                            <p><input type="radio" value="half
                                                    day" name="master1" id="opt3"
                                                    oninput="this.className = ''"> <label class="lab" for="">half
                                                    day</label>
                                            </p>

                                            <p><input type="radio" value="fullday" name="master1" id="opt4"
                                                    oninput="this.className = ''"> <label class="lab" for="">full
                                                    day</label>
                                            </p>


                                </div>

                                <div class="tab5" style="display:none">
                                    <h4>What is Event date ?<h4>
                                            <p><input type="text" name="master2" id="my-range-field5" size="30" />
                                            </p>
                                </div>
                                

                                <div class="tab5" style="display:none">
                                    <h4>Where is Event ?<h4>
                                            <p><input type="text" value="" name="master3" id="master3"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>

                                <div class="tab5" style="display:none">
                                    <h4>Number of guests? <h4>
                                            <p><input type="text" value="" name="master4" id="master4"
                                                    oninput="this.className = ''">
                                            </p>
                                </div>
                                <div class="tab5" style="display:none">
                                <h4 name="question">Are you sure with this ?</h4><br>
                                    <div class="row">
                                    <div class="col-md-6"><h6 name="question">1.What is Event Duration ? </h6></div>
                                         <div  class="col-md-6">
                                            <p><input type="text"  name="master5" id="masterInput1"
                                                    oninput="this.className = ''" disabled/>
                                            </p>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                      <h6 name="question">2.What is Event date ? </h6>
                                    </div>
                                      <div class="col-md-6">
                                            <p><input type="text"  name="master5" id="masterInput2"
                                                    oninput="this.className = ''"disabled/>
                                             </p>    
                                      </div>
                                    </div>
                                    <div class="row"><div class="col-md-6">
                                    <h6 name="question">3.Where is Event ? </h6>
                                    </div>
                                       <div class="col-md-6">
                                       <p><input type="text"  name="master5" id="masterInput3"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <h6 name="question">4.Number of guests? </h6>
                                       </div>
                                       <div class="col-md-6">
                                            <p>
                                           <input type="text"  name="master5" id="masterInput4"
                                                    oninput="this.className = ''"disabled/>
                                            </p>
                                       </div>
                                    </div>
                                     <br>
                                </div>

                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn5" class="b1"
                                            onclick="nextPrev5(-1)">Previous</button>
                                        <button type="button" id="nextBtn5" class="b1" name="save"
                                            onclick="nextPrev5(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step5"></span>
                                    <span class="step5"></span>
                                    <span class="step5"></span>
                                    <span class="step5"></span>
                                </div>

                            </form>
                        </div><!-- /Wizard container -->

                    </div><!-- /col -->
                </div><!-- /row -->
            </div><!-- /TAB 1:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


        </div><!-- /tab content -->
    </div><!-- /container-fluid -->
</div><!-- /wrapper_in -->
</div>

<!-- quote modle  -->

    <script>
        flatpickr("#my-range-field5", {
          mode: "range"
        });
      </script>
      
      <script> 
        (function ($) {

"use strict";

/*Aside panel + nav*/
var $Main_nav = $('.request5');
var $Mc = $('#main_container5');
var $Layer = $('.layer');
var $Btn_m = $('#menu-button-mobile');
var $Tabs_c = $('.request5  a');

$Main_nav.on("click", function () {
    $Mc.addClass("show_container5")
    $Layer.addClass("layer-is-visible")
});
$(".close_in").on("click", function () {
    $Mc.removeClass("show_container5")
    $(".request5 li a.active").removeClass("active")
    $Layer.removeClass("layer-is-visible")
});
$Tabs_c.on('click', function (e) {
    var href = $(this).attr('href');
    $('.wrapper_in').animate({
        scrollTop: $(href).offset().top
    }, 'fast');
    e.preventDefault();
    if ($(window).width() <= 767) {
        $Btn_m.removeClass("active");
        $Main_nav.slideToggle(300);
    }
});
$Btn_m.on("click", function () {
    $Main_nav.slideToggle(500);
    $(this).toggleClass("active");
});

$(window).on("resize", function () {
    var width = $(window).width();
    if (width <= 767) {
        $Main_nav.hide();
    } else {
        $Main_nav.show();
    }
});

/* Scroll to top small screens: chanhe the top position offset based on your content*/
var $Scrolbt = $('button.backward,button.forward');
var $Element = $('.wrapper_in');

if( window.innerWidth < 800 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 500 }, "slow");
  return false;
});
}

if( window.innerWidth < 600 ) {
    $Scrolbt.on("click", function (){
      $Element.animate({ scrollTop: 610 }, "slow");
  return false;
});
}

/* Tooltip*/
// $('.tooltip-1').tooltip({
//     html: true
// });

/* Accordion*/
function toggleChevron(e) {
    $(e.target)
        .prev('.card-header')
        .find("i.indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
}
$('#accordion').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
    function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".indicator")
        .toggleClass('icon_minus_alt2 icon_plus_alt2');
};

/* Video modal*/
$('.video_modal').magnificPopup({
    type: 'iframe'
});

/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

/* Carousel*/
$('.owl-carousel').owlCarousel({
    items: 1,
    dots: false,
    loop: true,
    autoplay: true,
    autoHeight: true,
    autoplayTimeout: 3500,
    animateOut: 'fadeOut',
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});

/*  Wizard */
jQuery(function ($) {
    $('form#wrapped').attr('action', 'smtp/quote_send.php');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function (event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward)
                return true;
            var inputs = $(this).wizard('state').step.find(':input');
            return !inputs.length || !!inputs.valid();
        }
    }).validate({
        errorPlacement: function (error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });
});

/* Check and radio input styles */
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_square-yellow'
});

})(window.jQuery); // JavaScript Document
        </script>
        <!-- <script>
        var currentTab1 = 0; // Current tab is set to be the first tab (0)
        showTab5(currentTab1); // Display the current tab

        function showTab5(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab5");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn5").style.display = "none";
            } else {
                document.getElementById("prevBtn5").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn5").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn5").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator5(n)
        }

        function nextPrev5(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab5");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm5()) return false;
            // Hide the current tab:
            x[currentTab1].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab1 = currentTab1 + n;
            // if you have reached the end of the form... :
            if (currentTab1 >= x.length) {
                //...the form gets submitted:
                document.getElementById("regForm5").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab5(currentTab1);
        }

        function validateForm5() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab5");
            y = x[currentTab1].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step5")[currentTab1].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator5(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step5");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script> -->
    <!-- <div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="icon-box">
                    <i class="material-icons">&#xE876;</i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>Great!</h4>	
                <p>Your account has been created successfully.</p>
                <button class="btn btn-success" data-dismiss="modal"><span>Start Exploring</span> <i class="material-icons">&#xE5C8;</i></button>
            </div>
        </div>
    </div>
</div> -->
    <!--END Master Of Ceremony -->
         <!-- <script src="assets\js\jquery-3.2.1.min.js"></script> -->
         <script src="<?php echo base_url(); ?>assets\js\jquery-3.2.1.min.js"></script>
    <!-- Common script -->
    <!-- <script src="assets\js\common_scripts_min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets\js\common_scripts_min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets\js\common_scripts.js"></script>
    <script src="<?php echo base_url(); ?>assets\js\sweetalert.min.js"></script>
    <!-- multiple date selector -->
    <!-- <script src="<?php echo base_url(); ?>assets\js\flatpickr.js"></script> -->
    <!-- <script src="//code.jquery.com/jquery-3.2.1.min.js"></script> -->
 <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <script src="<?php echo base_url(); ?>assets\js\input_value.js"></script>

</body>


        

