<?php
$category = $this->service->get_category();
$subcategory = $this->service->get_subcategory();
$service_image = $this->service->service_image($services['id']);
$service_id = $services['id'];


$user_currency_code = '';
$userId = $this->session->userdata('id');
if (!empty($userId)) {
    $service_amount = $services['service_amount'];
    $type = $this->session->userdata('usertype');
    if ($type == 'user') {
        $user_currency = get_user_currency();
    } else if ($type == 'provider') {
        $user_currency = get_provider_currency();
    }
    $user_currency_code = $user_currency['user_currency_code'];

    $service_amount = get_gigs_currency($services['service_amount'], $services['currency_code'], $user_currency_code);
} else {
    $user_currency_code = settings('currency');
    $service_amount = $services['service_amount'];
}
if (is_nan($service_amount) || is_infinite($service_amount)) {
    $service_amount = $services['service_amount'];
}
?>
<div class="content">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header text-center">
                    <h2>
                        <?php echo (!empty($user_language[$user_selected]['lg_Edit_Service'])) ? $user_language[$user_selected]['lg_Edit_Service'] : $default_language['en']['lg_Edit_Service']; ?>
                    </h2>
                </div>

                <form method="post" enctype="multipart/form-data" autocomplete="off" id="update_service"
                    action="<?php echo base_url() ?>user/service/update_service">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input class="form-control" type="hidden" name="currency_code"
                        value="<?php echo $user_currency_code; ?>">
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">
                            <?php echo (!empty($user_language[$user_selected]['lg_service_info'])) ? $user_language[$user_selected]['lg_service_info'] : $default_language['en']['lg_service_info']; ?>
                        </h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_service_title'])) ? $user_language[$user_selected]['lg_service_title'] : $default_language['en']['lg_service_title']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="hidden" name="service_id" id="service_id"
                                        value="<?php echo $services['id']; ?>">
                                    <input type="hidden" class="form-control" id="map_key"
                                        value="<?php echo settingValue('map_key'); ?>">
                                    <input class="form-control" type="text" name="service_title" id="service_title"
                                        value="<?php echo $services['service_title']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_Service_Amount'])) ? $user_language[$user_selected]['lg_Service_Amount'] : $default_language['en']['lg_Service_Amount']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="service_amount" id="service_amount"
                                        value="<?php echo $service_amount; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_Service_Location'])) ? $user_language[$user_selected]['lg_Service_Location'] : $default_language['en']['lg_Service_Location']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="service_location"
                                        id="service_location" value="<?php echo $services['service_location'] ?>">
                                    <input type="hidden" name="service_latitude" id="service_latitude"
                                        value="<?php echo $services['service_latitude'] ?>">
                                    <input type="hidden" name="service_longitude" id="service_longitude"
                                        value="<?php echo $services['service_longitude'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="service-fields mb-3">
                        <h3 class="heading-2">
                            <?php echo (!empty($user_language[$user_selected]['lg_service_category'])) ? $user_language[$user_selected]['lg_service_category'] : $default_language['en']['lg_service_category']; ?>
                        </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_category'])) ? $user_language[$user_selected]['lg_category'] : $default_language['en']['lg_category']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" name="category">
                                        <?php foreach ($category as $cat) { ?>
                                            <option value="<?= $cat['id'] ?>" <?php if ($cat['id'] == $services['category']) { ?> selected="selected" <?php } ?>><?php echo $cat['category_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_Sub_Category'])) ? $user_language[$user_selected]['lg_Sub_Category'] : $default_language['en']['lg_Sub_Category']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" name="subcategory">
                                        <?php foreach ($subcategory as $sub_category) { ?>
                                            <option value="<?= $sub_category['id'] ?>" <?php if ($sub_category['id'] == $services['subcategory']) { ?> selected="selected"
                                                <?php } ?>><?php echo $sub_category['subcategory_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="service-fields mb-3">
                        <h3 class="heading-2">
                            <?php echo (!empty($user_language[$user_selected]['lg_service_offer'])) ? $user_language[$user_selected]['lg_service_offer'] : $default_language['en']['lg_service_offer']; ?>
                        </h3>

                        <div class="membership-info">
                            <?php
                            if (!empty($serv_offered) && $serv_offered != 'null') {
                                $offered_data = json_decode($serv_offered[0]['service_offered']);
                                $count = is_array($offered_data) ? count($offered_data) : 0;
                                if ($count == 0) { ?>
                                    <div class="row form-row membership-cont">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="service_offered[]"
                                                    value="<?php echo $serv_offered[0]['service_offered']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2 col-lg-2">
                                            <a href="#" class="btn btn-danger trash"><i class="far fa-times-circle"></i></a>
                                        </div>
                                    </div>
                                <?php } else {
                                    foreach ($offered_data as $key => $value) {
                                        ?>

                                        <div class="row form-row membership-cont">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo (!empty($user_language[$user_selected]['lg_service_offered'])) ? $user_language[$user_selected]['lg_service_offered'] : $default_language['en']['lg_service_offered']; ?>
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="service_offered[]"
                                                        value="<?php echo $value; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2 col-lg-2">
                                                <label>&nbsp;</label>
                                                <a href="#" class="btn btn-danger trash"><i class="far fa-times-circle"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <div class="row form-row membership-cont">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="service_offered[]" value="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-lg-2">
                                        <a href="#" class="btn btn-danger trash"><i class="far fa-times-circle"></i></a>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                        <div class="add-more form-group">
                            <a href="javascript:void(0);" class="add-membership"><i class="fas fa-plus-circle"></i>
                                <?php echo (!empty($user_language[$user_selected]['lg_add_more'])) ? $user_language[$user_selected]['lg_add_more'] : $default_language['en']['lg_add_more']; ?>
                            </a>
                        </div>
                    </div>
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">
                            <?php echo (!empty($user_language[$user_selected]['lg_details_information'])) ? $user_language[$user_selected]['lg_details_information'] : $default_language['en']['lg_details_information']; ?>
                        </h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_descriptions'])) ? $user_language[$user_selected]['lg_descriptions'] : $default_language['en']['lg_descriptions']; ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class='form-control content-textarea' id='ck_editor_textarea_id4' rows='6'
                                        name='about'><?php echo $services['about'] ?></textarea>
                                    <?php echo display_ckeditor($ckeditor_editor4); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="service-fields mb-3">
                        <h3 class="heading-2">
                            <?php echo (!empty($user_language[$user_selected]['lg_service_gallery'])) ? $user_language[$user_selected]['lg_service_gallery'] : $default_language['en']['lg_service_gallery']; ?>
                        </h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="service-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>
                                        <?php echo (!empty($user_language[$user_selected]['lg_upload_service_images'])) ? $user_language[$user_selected]['lg_upload_service_images'] : $default_language['en']['lg_upload_service_images']; ?>
                                        *
                                    </span>
                                    <input type="file" name="images[]" id="images" multiple
                                        accept="image/jpeg, image/png, image/gif,">

                                </div>
                                <div id="uploadPreview">
                                    <ul class="upload-wrap" id="imgList">
                                        <?php
                                        $service_img = array();
                                        for ($i = 0; $i < count($service_image); $i++) { ?>
                                            <li id="service_img_<?php echo $service_image[$i]['id']; ?>">
                                                <div class="upload-images">

                                                    <a href="javascript:void(0);"
                                                        class="file_close1 btn btn-icon btn-danger btn-sm delete_img"
                                                        data-img_id="<?php echo $service_image[$i]['id']; ?>">X</a><img
                                                        alt="Service Image"
                                                        src="<?php echo base_url() . $service_image[$i]['service_image']; ?>">
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <!-- created by gouresh 
                                <h3 class="heading-2">Add video</h3>
                                <div class="service-upload">

                                    <label for="videos"></label>
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Upload video*</span>
                                    <input type="file" id="videos" name="videos[]" multiple><br><br>
                                </div>
                                <div id="uploadPreview2"></div>
                                 created by gouresh -->
                            </div>

                        </div>
                    </div>
            </div>
            <input type="hidden" class="submit_status" value="0">
            <div class="submit-section">
                <button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">
                    <?php echo (!empty($user_language[$user_selected]['lg_Submit'])) ? $user_language[$user_selected]['lg_Submit'] : $default_language['en']['lg_Submit']; ?>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>