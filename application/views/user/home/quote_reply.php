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
                        <form id="search_form">

                            <div class="filter-widget">
                             
                                <div class="filter-list">
                                    <h4 class="filter-title">
                                        <?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?>
                                    </h4>
                                    <select id="sort_by" class="form-control selectbox select">
                                        <option value="">
                                            <?php echo (!empty($user_language[$user_selected]['lg_Sort_By'])) ? $user_language[$user_selected]['lg_Sort_By'] : $default_language['en']['lg_Sort_By']; ?>
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
                                    </select>
                                </div>
                                
                            </div>

                            <div class="filter-widget">
                             
                                <div class="filter-list">
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
                                
                            </div>

                            


                            <button class="btn btn-primary pl-5 pr-5 btn-block get_services" type="button">
                                <?php echo (!empty($user_language[$user_selected]['lg_search'])) ? $user_language[$user_selected]['lg_search'] : $default_language['en']['lg_search']; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="card ml-5 mb-3" style="max-width: 750px;">
                    <div class="row g-1">
                        <div class="col-md-4">

                            <a href="http://localhost/dqn/service-preview/1?sid=c4ca4238a0b923820dcc509a6f75849b"
                                class="booking-img">
                                <img src="uploads/services/se_full_1678861965DJ1.jpeg" class="img-fluid category_reply"
                                    alt="..." style="width : 250px; height: 150px; margin : 20px; border-radius: 3px;">
                            </a>

                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <h5 class="card-title">DJ</h5>
                                <ul class="booking-details">
                                    <li><span>Amount</span> $5000</li>
                                    <li><span>Location</span> wadala</li>
                                    <li><span>Phone</span>1-99999999999</li>
                                    <li>
                                        <span>Provider</span>
                                        <div class="avatar avatar-xs mr-1">
                                            <img class="avatar-img rounded-circle" alt="User Image"
                                                src="http://localhost/dqn/assets/img/user.jpg">
                                        </div> Gaurish
                                        <!-- block providers -->
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-2 mt-5">
                            <a href="" class="btn btn-sm bg-success-light myCancel mt-2">
                                <i class=""></i> Accept </a>
                            <a href="" class="btn btn-sm bg-danger-light myCancel mt-2">
                                <i class=""></i> Decline</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>