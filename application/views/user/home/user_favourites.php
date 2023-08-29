<div class="content">
    <div class="container">
        <div class="row">

            <?php $this->load->view('user/home/user_sidemenu'); ?>

            <div class="col-xl-9 col-md-8">
                <div class="row align-items-center mb-4">
                    <div class="col">
                        <h4 class="widget-title mb-0"><?php echo (!empty($user_language[$user_selected]['lg_My_Favorites'])) ? $user_language[$user_selected]['lg_My_Favorites'] : $default_language['en']['lg_My_Favorites']; ?></h4>
                    </div>                    
                </div>
				
                <div id="dataList" class="table-responsive transaction-table">                    
                    <table id="dtBasicExample" class="table table-center mb-0 table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                              <th class="th-sm">#</th>
                              <th class="th-sm"><?php echo (!empty($user_language[$user_selected]['lg_Provider'])) ? $user_language[$user_selected]['lg_Provider'] : $default_language['en']['lg_Provider']; ?></th>
                              <th class="th-sm"><?php echo (!empty($user_language[$user_selected]['lg_Service'])) ? $user_language[$user_selected]['lg_Service'] : $default_language['en']['lg_Service']; ?></th>
                              <th class="th-sm"><?php echo (!empty($user_language[$user_selected]['lg_category'])) ? $user_language[$user_selected]['lg_category'] : $default_language['en']['lg_category']; ?></th>
                              <th class="th-sm"><?php echo (!empty($user_language[$user_selected]['lg_Sub_Category'])) ? $user_language[$user_selected]['lg_Sub_Category'] : $default_language['en']['lg_Sub_Category']; ?></th>
                              <th class="th-sm"><?php echo (!empty($user_language[$user_selected]['lg_action'])) ? $user_language[$user_selected]['lg_action'] : $default_language['en']['lg_action']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($all_favorites)) { 
                                $i=1;
                                foreach ($all_favorites as $favorites) { 
                                    if(file_exists($favorites['provider_img'])) {
                                        $provider_img = $favorites['provider_img'];
                                    } else {
                                        $provider_img ='assets/img/user.jpg';
                                    }
                                    if(file_exists($favorites['service_thumb_img'])) {
                                        $service_img = $favorites['service_thumb_img'];
                                    } else {
                                        $service_img = 'assets/img/no-image.png';
                                    }
                                    if(file_exists($favorites['category_thumb_img'])){
                                        $category_img = $favorites['category_thumb_img'];
                                    } else {
                                        $category_img = 'assets/img/no-image.png';
                                    }
                                    if(file_exists($favorites['subcategory_image'])) {
                                        $sub_category_img = $favorites['subcategory_image'];
                                    } else {
                                        $sub_category_img = 'assets/img/no-image.png';
                                    }
                                    $view = (!empty($user_language[$user_selected]['lg_view'])) ? $user_language[$user_selected]['lg_view'] : $default_language['en']['lg_view'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo '<a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$provider_img.'"></a>'.str_replace('-', ' ', $favorites['provider_name']); ?></td>
                                        <td><?php echo '<a href="#" class="avatar avatar-sm mr-2"> <img class="img-fluid serv-img" alt="" src="'.$service_img.'"></a>'.$favorites['service_title']; ?></td>
                                        <td><?php echo '<a href="#" class="avatar avatar-sm mr-2"> <img class="img-fluid serv-img" alt="" src="'.$category_img.'"></a>'.$favorites['category_name']; ?></td>
                                        <td><?php echo '<a href="#" class="avatar avatar-sm mr-2"> <img class="img-fluid serv-img" alt="" src="'.$sub_category_img.'"></a>'.$favorites['subcategory_name']; ?></td>
                                        <td><?php echo "<a target='_blank' href='".$base_url."service-preview/".$favorites['service_id'] . '?sid=' . md5($favorites['service_id'])."' alt='view' class='mr-2'><i class='far fa-eye mr-1'></i><span> ".$view."</span></a>"; ?></td>
                                    </tr>
                                <?php $i++; } //foreach end
                            } //if empty end
                            else{ ?>
                                <tr height="35"><td colspan="6" align="center"><?php echo (!empty($user_language[$user_selected]['lg_no_record_fou'])) ? $user_language[$user_selected]['lg_no_record_fou'] : $default_language['en']['lg_no_record_fou']; ?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table> 
                </div>    
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');
});
</script>