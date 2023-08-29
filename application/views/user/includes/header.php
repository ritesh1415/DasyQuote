<!DOCTYPE html>
<html>
    <?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->website_logo_front = 'assets/img/logo.png';
    $fav = base_url() . 'assets/img/favicon.png';
    if (!empty($result)) {
        foreach ($result as $data) {
            if ($data['key'] == 'website_name') {
                $this->website_name = $data['value'];
            }
            if ($data['key'] == 'favicon') {
                $favicon = $data['value'];
            }
            if ($data['key'] == 'logo_front') {
                $this->website_logo_front = $data['value'];
            }
            if($data['key'] == 'meta_title'){
				$this->meta_title =  $data['value'];
			}
			if($data['key'] == 'meta_desc'){
				$this->meta_description =  $data['value'];
			}
			if($data['key'] == 'meta_keyword'){
				$this->meta_keywords =  $data['value'];
			}
        }
    }
    if (!empty($favicon)) {
        $fav = base_url() . 'uploads/logo/' . $favicon;
    }
    $lang = (!empty($this->session->userdata('lang'))) ? $this->session->userdata('lang') : 'en';

    $ColorList = $this->db->get('theme_color_change')->result_array();

    $Orgcolor = $ColorList[0]['status'];
    $Bluecolor = $ColorList[1]['status'];
    $Redcolor = $ColorList[2]['status'];
    $Greencolor = $ColorList[3]['status'];
    $Defcolor = $ColorList[4]['status'];
    //session out for blocked users
	if($this->session->userdata('usertype')=='user')
	{
		$user_det = $this->db->where('id', $this->session->userdata('id'))->get('users')->row_array();
		if($user_det['status'] != 1)
		{
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
    //session out for blocked providers
    if($this->session->userdata('usertype')=='provider')
	{
		$provider_det = $this->db->where('id', $this->session->userdata('id'))->get('providers')->row_array();
		if($provider_det['status'] != 1)
		{
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
    ?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $this->meta_title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="<?php echo $this->meta_description; ?>">
        <meta name="keywords" content="<?php echo $this->meta_keywords; ?>">
		
        <meta name="author" content="Dreamguy's Technologies">

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav; ?>">
		
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet"> 
        <?php if ($this->session->userdata('user_select_language') == '') {

    $lang = $default_language['language_value'];
} else {
    $lang = $this->session->userdata('user_select_language');
}

$default_language_select = default_language();

if ($this->session->userdata('user_select_language') == '') {
    if ($default_language_select['tag'] == 'ltr' || $default_language_select['tag'] == '') { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css"> 
    <?php } elseif ($default_language_select['tag'] == 'rtl') { ?>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php }
} else {
    if ($this->session->userdata('tag') == 'ltr' || $this->session->userdata('tag') == '') { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <?php } elseif ($this->session->userdata('tag') == 'rtl') { ?>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php }
} ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css"> 
        <!-- <link rel="stylesheet" href="assets\css\flatpickr.min.css">
        <link href="assets\css\styleq.css" rel="stylesheet">
        <link href="assets\css\all_icons_min.css" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/> -->
        
        <?php if ($module == 'home' || $module == 'services') { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">
        <?php } ?>

        <?php if ($module == 'service') { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tagsinput.css">
        <?php } ?>    

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toaster/toastr.min.css">
        
		
		<?php	
			if ($this->session->userdata('user_select_language') == '') {
				if ($default_language_select['tag'] == 'ltr' || $default_language_select['tag'] == '') { ?>
					<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
				<?php } elseif ($default_language_select['tag'] == 'rtl') { ?>
					<link href="<?php echo base_url(); ?>assets/css/style-rtl.css" rel="stylesheet" />
				<?php }
			} else {
				if ($this->session->userdata('tag') == 'ltr' || $this->session->userdata('tag') == '') { ?>
					<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
				<?php } elseif ($this->session->userdata('tag') == 'rtl') { ?>
					<link href="<?php echo base_url(); ?>assets/css/style-rtl.css" rel="stylesheet" />
				<?php }
			}
		?>


        <?php if (!empty($Orgcolor) && $Orgcolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_org.css">
        <?php } else if (!empty($Bluecolor) && $Bluecolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_blue.css">
        <?php } else if (!empty($Redcolor) && $Redcolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_red.css">
        <?php } else if (!empty($Greencolor) && $Greencolor == 1) { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_green.css">
        <?php } ?>

        <?php if ($this->uri->segment(1) == "book-service") { ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css">
        <?php } ?>

        <script src="<?php echo $base_url; ?>assets/js/jquery-3.6.0.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        
    </head>