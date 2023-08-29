<div class="content">
    <div class="container">
        <div class="row">
            <?php
            $type = $this->session->userdata('usertype');
            if ($type == 'user') {
                ?>
                <?php $this->load->view('user/home/user_sidemenu'); ?>
            <?php } else { ?>
                <?php $this->load->view('user/home/provider_sidemenu'); ?>
            <?php } ?>
            <div class="col-xl-9 col-md-8">
               
                <div class="dashboradsec">
                    <h4 class="widget-title"><?php echo (!empty($user_language[$user_selected]['lg_Notifications'])) ? $user_language[$user_selected]['lg_Notifications'] : $default_language['en']['lg_Notifications']; ?></h4>
                    <div class="notcenter" id="dataListnotify">
                        <?php
                        if (!empty($notification_list)) {
                            foreach ($notification_list as $key => $value) {
                                $datef = explode(' ', $value["created_at"]);
                                if(settingValue('time_format') == '12 Hours') {
                                    $time = date('h:ia', strtotime($datef[1]));
                                } elseif(settingValue('time_format') == '24 Hours') {
                                   $time = date('H:i:s', strtotime($datef[1]));
                                } else {
                                    $time = date('G:ia', strtotime($datef[1]));
                                }
                                $date = date(settingValue('date_format'), strtotime($datef[0]));
                                $timeBase = $date.' '.$time;
                                ?>
                                <div class="notificationlist">
                                    <div class="inner-content-blk position-relative">
                                        <div class="d-flex text-dark">
                                <?php
                                if (file_exists($value['profile_img'])) {
                                    $image = base_url() . $value['profile_img'];
                                } else {
                                    $image = base_url() . 'assets/img/user.jpg';
                                }
                                ?>
                                            <img class="rounded" src="<?php echo $image; ?>" width="50" alt="">
                                            <div class="noti-contents">
                                                <h3><strong style="word-break: break-all;"><?= $value['message']; ?></strong></h3>
                                                <span><?= $timeBase; ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

    <?php }
} else { ?>
                            <div class="notificationlist">
                                <p class="text-center text-danger mt-3"><?php echo (!empty($user_language[$user_selected]['lg_notification_empty'])) ? $user_language[$user_selected]['lg_notification_empty'] : $default_language['en']['lg_notification_empty']; ?></p>
                            </div>
<?php } ?>
                        <?php
                        if (!empty($notification_list)) {
                            echo $this->ajax_pagination->create_links();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>