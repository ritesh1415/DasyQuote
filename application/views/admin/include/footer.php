<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
  value="<?php echo $this->security->get_csrf_hash(); ?>" id="admin_csrf" />
<input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
<input type="hidden" name="country_code_key" id='country_code_key'
  value="<?php echo settingValue('country_code_key'); ?>">
</div>

<script src="<?php echo $base_url; ?>assets/js/jquery-3.6.0.min.js"></script>
<!--  validation script  -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="<?php echo $base_url; ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/moment.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- Slimscroll JS -->
<script src="<?php echo $base_url; ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<?php $page = $this->uri->segment(1); ?>
<script src="<?php echo $base_url; ?>assets/js/bootstrapValidator.min.js"></script>

<!-- Datatables JS -->
<script src="<?php echo $base_url; ?>assets/plugins/datatables/datatables.min.js"></script>

<script src="<?php echo $base_url; ?>assets/js/bootstrap-notify.min.js"></script>

<!-- Select2 JS -->
<script src="<?php echo $base_url; ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<script src="<?php echo $base_url; ?>assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>

<script src="<?php echo $base_url; ?>assets/js/admin.js"></script>
<script src="<?php echo $base_url; ?>assets/js/select2.min.js"></script>

<input type="hidden" id="page" value="<?php echo $this->uri->segment(1); ?>">
<input type="hidden" id="provider_list_url" value="<?php echo site_url('provider_list') ?>">
<input type="hidden" id="requests_list_url" value="<?php echo site_url('request_list') ?>">
<input type="hidden" id="user_list_url" value="<?php echo site_url('users_list') ?>">
<input type="hidden" id="adminuser_list_url" value="<?php echo site_url('adminusers_list') ?>">
<input type="hidden" name="map_key" id='map_key' value="<?php echo settingValue('map_key'); ?>">


<?php if ($page == 'admin-profile') { ?>
  <script src="<?php echo $base_url; ?>assets/js/cropper_profile.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>
<?php } ?>

<?php
$page2 = $this->uri->segment(2);
if (($page == 'adminusers' && $page2 == 'edit') || ($page == 'users' && $page2 == 'edit') || ($page == 'providers' && $page2 == 'edit')) { ?>
  <script src="<?php echo $base_url; ?>assets/js/cropper_allusers.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
<?php } ?>

<script src="<?php echo $base_url; ?>assets/js/jquery.checkboxall-1.0.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/admin_functions.js"></script>

<!--External js Start-->
<?php if ($this->uri->segment(1) == "reject-payment") { ?>
  <script src="<?php echo base_url(); ?>assets/js/edit_reject_booking_view.js"></script>
<?php } ?>
<?php if ($this->uri->segment(2) == "emailsettings") { ?>
  <script src="<?php echo base_url(); ?>assets/js/admin_emailsettings.js"></script>
<?php } ?>
<?php if ($this->uri->segment(2) == "stripe_payment_gateway" || $this->uri->segment(2) == "settings") { ?>
  <script src="<?php echo base_url(); ?>assets/js/stripe_payment_gateway.js"></script>
<?php } ?>

<!--External js end-->

<?php
if (settingValue('socket_showhide') == 1) {
  $port = settingValue('server_port');
  $ip = settingValue('server_ip');
} else {
  $port = '108.1.1.1';
  $ip = '8443';
} ?>
<script type="text/javascript">
  let socketHost = '<?php echo $ip; ?>';
  let socketPort = '<?php echo $port; ?>';
  let WS = '<?php print $this->db->WS ?>';
  <?php
  $user['id'] = '0';
  $user['name'] = 'Admin';
  $user['usertype'] = 'user';
  ?>
  let chat_user = JSON.parse('<?php print addslashes(json_encode($user)); ?>');
</script>
<input type="hidden" id="usertype" name="user_type" value="provider">
<script src="<?php echo $base_url; ?>assets/js/admin_chat.js"></script>
<script src="<?php echo $base_url; ?>assets/js/websocket.js"></script>
<?php ?>

<?php if ($page == 'settings' && $page2 == 'about-us' || $page == 'settings' && $page2 == 'cookie-policy' || $page == 'settings' && $page2 == 'help' || $page == 'settings' && $page2 == 'privacy-policy' || $page == 'settings' && $page2 == 'terms-service') { ?>
  <script type="text/javascript">
    $(document).ready(function () {
      CKEDITOR.disableAutoInline = true;
      CKEDITOR.inline('.content-textarea');
      $('textarea.content-textarea').ckeditor();
    });
  </script>
  <script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
<?php } ?>

<?php
$page_id = $this->uri->segment(3);
$p = $this->uri->segment(2);
$lang = $this->uri->segment(4);
/*service list Active And De Active*/
if ($page == 'subcategories') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_subcategories(val) {
      bootbox.confirm("Deleting sub-category will also delete its Services!! ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/categories/delete_subcategory';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var category_id = val;
          var data = {
            category_id: category_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                $("#flash_success_message").show();
                window.location = BASE_URL + 'subcategories';
              } else {
                window.location = BASE_URL + 'subcategories';
              }
            }
          });
        }
      });
    }
    $(document).ready(function () {
      $(document).on("click", ".delete_subcategories", function () {
        var id = $(this).attr('data-id');
        delete_subcategories(id);
      });
    });
  </script>
<?php }

if ($page == 'contact-details') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function reply_contact(val, uname, umail) {

      bootbox.confirm("<h4>REPLY CONTACT</h4><br><textarea id='replycont' class='form-control' placeholder='REPLY...' rows='10' required></textarea><span class='text-danger error_msg'></span> ", function (result) {
        if (result == true) {
          var replycont = $("#replycont").val();
          var url = BASE_URL + 'admin/contact/reply_contact';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var contact_id = val;
          var name = uname;
          var email = umail;

          var data = {
            contact_id: contact_id,
            umail: umail,
            uname: uname,
            replycont: replycont

          };
          data[keyname] = keyvalue;
          if (replycont) {
            $('.error_msg').html('');
            $.ajax({
              url: url,
              data: data,
              type: "POST",
              success: function (res) {
                console.log(res);
                if (res == 1) {
                  $("#flash_success_message").show();
                  window.location = BASE_URL + 'contact-details/' + contact_id;
                } else {
                  window.location = BASE_URL + 'contact-details/' + contact_id;
                }
              }
            });
          } else {
            $('.error_msg').html('Please enter reply message');
            return false;
          }

        }
      });
    }
    $(document).ready(function () {
      $('.reply_contact').on('click', function () {
        var id = $(this).attr('data-id');
        var umail = $(this).attr('data-mail');
        var uname = $(this).attr('data-uname');
        reply_contact(id, uname, umail);
      });

    });
  </script>
<?php }


if ($page == 'categories') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_categories(val) {
      bootbox.confirm("Deleting category will also delete its sub-categories and Services!! ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/categories/delete_category';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var category_id = val;
          var data = {
            category_id: category_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                $("#flash_success_message").show();
                window.location = BASE_URL + 'admin/categories';
              } else {
                window.location = BASE_URL + 'admin/categories';
              }
            }
          });
        }
      });
    }
    $(document).ready(function () {
      $(document).on("click", ".delete_categories", function () {
        var id = $(this).attr('data-id');
        delete_categories(id);
      });

    });
  </script>
<?php }


if ($page == 'app_page_list') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_appkeyword(val) {
      bootbox.confirm("Deleting appkeyword!! ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/language/delete_appkeyword';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var appkeyword_id = val;
          var data = {
            appkeyword_id: appkeyword_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                $("#flash_success_message").show();
                window.location = BASE_URL + 'app_page_list';
              } else {
                window.location = BASE_URL + 'app_page_list';
              }
            }
          });
        }
      });
    }
    $(document).ready(function () {
      $(document).on("click", ".delete_appkeyword", function () {
        var id = $(this).attr('data-id');
        delete_appkeyword(id);
      });

    });
  </script>
<?php }
if ($p == 'country_code_config') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_country_code_config(val) {
      bootbox.confirm("Are you sure want to Delete ? ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/country_code_config/delete_country_code_config';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var tbl_id = val;
          var data = {
            tbl_id: tbl_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                window.location = BASE_URL + 'admin/country_code_config';
              } else {
                window.location = BASE_URL + 'admin/country_code_config';
              }
            }
          });
        }
      });
    }

    $(document).on("click", ".delete_country_code_config", function () {
      var id = $(this).attr('data-id');
      delete_country_code_config(id);
    });

  </script>
<?php }
if ($p == 'footer_menu') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_footer_menu(val) {
      bootbox.confirm("Are you sure want to Delete ? ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/footer_menu/delete_footer_menu';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var tbl_id = val;
          var data = {
            tbl_id: tbl_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                window.location = BASE_URL + 'admin/footer_menu';
              } else {
                window.location = BASE_URL + 'admin/footer_menu';
              }
            }
          });
        }
      });
    }
    $(document).ready(function () {
      $('.delete_footer_menu').on('click', function () {
        var id = $(this).attr('data-id');
        delete_footer_menu(id);
      });

    });
  </script>
<?php }
if ($p == 'footer_submenu') {
  ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  <script type="text/javascript">
    var BASE_URL = $('#base_url').val();
    function delete_footer_submenu(val) {
      console.log("1");
      bootbox.confirm("Are you sure want to Delete ? ", function (result) {
        if (result == true) {
          var url = BASE_URL + 'admin/footer_submenu/delete_footer_submenu';
          var keyname = "<?php echo $this->security->get_csrf_token_name(); ?>";
          var keyvalue = "<?php echo $this->security->get_csrf_hash(); ?>";
          var tbl_id = val;
          var data = {
            tbl_id: tbl_id
          };
          data[keyname] = keyvalue;
          $.ajax({
            url: url,
            data: data,
            type: "POST",
            success: function (res) {
              if (res == 1) {
                window.location = BASE_URL + 'admin/footer_submenu';
              } else {
                window.location = BASE_URL + 'admin/footer_submenu';
              }
            }
          });
        }
      });
    }
    $(document).ready(function () {
      $('.delete_footer_submenu').on('click', function () {
        console.log("2");
        var id = $(this).attr('data-id');
        delete_footer_submenu(id);
      });
      $('#menu_status').click(function () {
        $('#sub_menu').attr('required', 'required');
        $('.sub_menu').show();
      });
      $('#menu_status_one').click(function () {
        $('#sub_menu').removeAttr('required', 'required');
        $('.sub_menu').hide();
      });
    });
  </script>
<?php }
if ($page == 'add-wep-keyword') {
  ?>
  <script type="text/javascript">
    $(document).ready(function () {
      $(".check_key_name").keypress(function (event) {
        var inputValue = event.which;
        if ((!(inputValue >= 65 && inputValue <= 90) && !(inputValue >= 97 && inputValue <= 120)) && inputValue != 95) {
          event.preventDefault();
        }
      });
    });
  </script>
<?php }

if ($page == 'wep_language') { ?>
  <script type="text/javascript">
    $(document).ready(function () {


      var csrf_token = $('#web_csrf').val();

      language_table = $('#language_web_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "ajax": {
          "url": '<?php echo base_url('admin/language/language_web_list'); ?>',
          "type": "POST",
          "data": function (data) {
            data.csrf_token_name = $('#web_csrf').val();
          }
        },
        "columnDefs": [
          {
            "targets": [], //first column / numbering column
            "orderable": false, //set not orderable
          },
        ],

      });
    });
  </script>
<?php } ?>

<?php
if ($page == 'app_page_list') {
  $page_id = $this->uri->segment(2);
  $lang = $this->uri->segment(3); ?>
  <script type="text/javascript">
    $(document).ready(function () {
      var csrf_token = $('#app_csrf').val();

      language_table = $('#language_app_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "ajax": {
          "url": '<?php echo base_url('admin/language/language_list'); ?>',
          "type": "POST",

          "data": function (data) {
            data.csrf_token_name = $('#app_csrf').val();
            data.page_key = "<?php echo $page_id ?>";
            data.lang_key = "<?php echo $lang ?>";

          }

        },
        "columnDefs": [
          {
            "targets": [], //first column / numbering column
            "orderable": false, //set not orderable
          },
        ],

      });
    });
  </script>
<?php } ?>

<?php if (($page == 'adminusers' && $page2 == 'edit') || ($page == 'users' && $page2 == 'edit') || ($page == 'providers' && $page2 == 'edit')) { ?>
  <script type="text/javascript">
    $(document).ready(function () {
      var country_key = $('#country_code_key').val();
      var mobileno = $('#mobileno').val();
      if (mobileno != '') {
        $("#mobileno, #user_mobile, #userMobile").intlTelInput({
          separateDialCode: true
        }).done(function () {
          $("#mobileno, #user_mobile, #userMobile").intlTelInput("setNumber", mobileno);
        });
      } else {
        $("#mobileno, #user_mobile, #userMobile").intlTelInput({
          separateDialCode: true,
          nationalMode: false,
          initialCountry: country_key
        });
      }
    });



  </script>
<?php } ?>
</body>

</html>