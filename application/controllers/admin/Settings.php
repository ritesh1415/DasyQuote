<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model('admin_model', 'admin');
		$this->load->model('common_model','common_model');
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'settings';
        $this->data['base_url'] = base_url();
        $this->load->helper('user_timezone_helper');
        $this->data['user_role'] = $this->session->userdata('role');
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->helper('ckeditor');
		$this->data['ckeditor_editor1'] = array(
			'id'   => 'ck_editor_textarea_id',
			'path' => 'assets/js/ckeditor',
			'config' => array(
				'toolbar' 					=> "Full",
				'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
        );
        $this->data['ckeditor_editor2'] = array(
			'id'   => 'ck_editor_textarea_id1',
			'path' => 'assets/js/ckeditor',
			'config' => array(
				'toolbar' 					=> "Full",
				'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
        );
        $this->data['ckeditor_editor3'] = array(
			'id'   => 'ck_editor_textarea_id2',
			'path' => 'assets/js/ckeditor',
			'config' => array(
				'toolbar' 					=> "Full",
				'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
		);
    }
    
    public function aboutus($id) {

		$this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 1))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id' => 1);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
          if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'About Us updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'about-us';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 
     public function faq_delete() {
        $id = $this->input->post('id');
        $this->db->where('id',$id)->delete('faq');
        $result = $this->db->where('id',$id)->delete('faq');
          if($result){
           $this->session->set_flashdata('success_message', 'FAQ deleted successfully');
             redirect($_SERVER["HTTP_REFERER"]);
          }else{
           $this->session->set_flashdata('error_message', 'Something went wront, Try again');
           redirect($_SERVER["HTTP_REFERER"]);
          }
    }
    public function faq($id) {
        $this->common_model->checkAdminUserPermission(24);
        $titles = $this->input->post('page_title');
        $cont = $this->input->post('page_content'); 
        $faq_id = $this->input->post('faq_id'); 

        if($this->input->post("form_submit") == true) {
            foreach ($titles as $key => $value) {
                $data = array(  
                    'page_title'     => $value,
                    'page_content'  => $cont[$key],  
                    'status'   =>1,  
                    'created_datetime' =>date('Y-m-d H:i:s') 
                    );  

                 if (empty($faq_id[$key])) {
                    
                    $this->db->insert('faq', $data);
                 }else {
                    $where = array('id'=> $faq_id[$key]);
                    $this->db->update('faq', $data ,$where);
                 }

            }
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'FAQ updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            
        }
               
        $this->data['pages']=$this->admin->getting_faq_list();
        $this->data['page'] = 'faq';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
            }
        
     public function cookie_policy($id) {
        $this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 19))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 19);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Cookie Policy updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'cookie_policy';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 

    public function help($id) {
        $this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 14))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 14);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Help updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'help';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 
    public function privacy_policy($id) {
        $this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 15))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where =array('id'=> 15);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] =date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Privacy Policy updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'privacy_policy';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 
     public function terms_of_services($id) {
        $this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 16))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $terms_slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($terms_slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] = date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 16);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Terms Of Services updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'terms_of_services';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 
    public function termconditions() {
		$this->common_model->checkAdminUserPermission(25);
        if ($this->input->post('form_submit')) {
            $this->load->library('upload');
            $data = $this->input->post();
				foreach ($data AS $key => $val) {

                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }

		}
        $results = $this->admin->get_setting_list();

        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'termconditions';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    
    public function privacypolicy() {
		$this->common_model->checkAdminUserPermission(26);
        if ($this->input->post('form_submit')) {
            $this->load->library('upload');
            $data = $this->input->post();
				foreach ($data AS $key => $val) {

                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }

		}
        $results = $this->admin->get_setting_list();

        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'privacypolicy';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	public function banner_image() 
    {
        $this->data['page'] = 'banner_image';	
        if ($this->input->post('form_submit')) {
            extract($_POST);
            $category = $this->input->post('category');
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            $this->data['list'] = $this->admin->categories_list_filter($category, $from_date, $to_date);
        } else {
			$wr=array('id !'=>'');
            $this->data['list'] = $this->admin->GetBannerDet();
        }

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	public function edit_banner($id) {
        $this->data['page'] = 'edit_banner';
        if ($this->input->post()) {
			$inp=$this->input->post();
			extract($_POST);
			if($this->input->post('bgimg_for')=='banner' || $this->input->post('bgimg_for')=='bottom_image1' || $this->input->post('bgimg_for')=='bottom_image2' || $this->input->post('bgimg_for')=='bottom_image3' || $this->input->post('bgimg_for')=='art'){
				$data['banner_content'] = $this->input->post('banner_content');
				$data['banner_sub_content'] = $this->input->post('banner_sub_content');
				
				$this->load->library('common');
				$this->db->where('bgimg_id', $id);
				if ($this->db->update('bgimage', $data)) {
					$message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully updated.</div>";
				}
				$insert_id = $id;
				if($this->input->post('bgimg_for')=='banner' || $this->input->post('bgimg_for')=='bottom_image1' || $this->input->post('bgimg_for')=='bottom_image2' || $this->input->post('bgimg_for')=='bottom_image3' || $this->input->post('bgimg_for')=='art')
				{
					if (isset($_FILES) && !empty($_FILES['upload_image']['name'])) {
						$av_file       = $_FILES['upload_image'];
						$src           = 'uploads/banners/' . $av_file['name'];
						$imageFileType = pathinfo($src, PATHINFO_EXTENSION);
						$image_name    = time() . '.' . $imageFileType;
						$src2          = 'uploads/banners/' . $image_name;
						$src3          = 'uploads/banners/' . $image_name;
						move_uploaded_file($av_file['tmp_name'], $src2);
						$this->db->query("UPDATE `bgimage` SET `upload_image` = '" . $src2 . "',`cropped_img` ='".$src2."' WHERE `bgimg_id` = '".$insert_id."' ");
					}
				}
				if($this->input->post('bgimg_for')=='banner'){
					$tile = 'Banner';
				}
				if($this->input->post('bgimg_for')=='bottom_image1'){
					$tile = 'Bottom Image-1';
				}
				if($this->input->post('bgimg_for')=='bottom_image2'){
					$tile = 'Bottom Image-2';
				}
				if($this->input->post('bgimg_for')=='bottom_image3'){
					$tile = 'Bottom Image-3';					
				}
                if($this->input->post('bgimg_for')=='art'){
					$tile = 'Art';					
				}
				$this->session->set_flashdata('success_message', $tile.' Updated successfully');
			}
			redirect(base_url('admin/edit_banner/'.$id.''));
			
        } else {
			$wr=array('id !'=>'');
            $this->data['list'] = $this->admin->GetBannerDetId($id);
        }
		$this->data['id'] = $id;
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function index() {
		$this->common_model->checkAdminUserPermission(14);

        if ($this->input->post('form_submit')) {
            $this->load->library('upload');
            $data = $this->input->post();

            /*
             *  commision insert start vasanth
             */

            $admin_id = $this->session->userdata('admin_id');
            $commission = $this->input->post('commission');
            $CommInsert = [
                'admin_id' => $admin_id,
                'commission' => $commission,
            ];
            $where = [
                'status' => 1,
                'admin_id' => $admin_id,
            ];

            $AdminData = $this->admin->getSingleData('admin_commission', $where);

            if ($admin_id === $AdminData->admin_id) {

                $where = ['admin_id' => $admin_id];
                $this->admin->update_data('admin_commission', $CommInsert, $where);
            } else {
                $this->admin->update_data('admin_commission', $CommInsert);
            }

            /*
             *  commision insert end vasanth
             */
            if ($_FILES['banner_image']['name']) {
                $table_data1 = [];
                $configfile['upload_path'] = FCPATH . 'uploads/banner_img';
                $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
                $configfile['overwrite'] = FALSE;
                $configfile['remove_spaces'] = TRUE;
                $file_name = $_FILES['banner_image']['name'];
                $configfile['file_name'] = time() . '_' . $file_name;
                $image_name = $configfile['file_name'];
                $image_url = 'uploads/logo/' . $image_name;
                $this->upload->initialize($configfile);
                if ($this->upload->do_upload('banner_image')) {
                    $img_uploadurl = 'uploads/banner_img' . $_FILES['banner_image']['name'];
                    $key = 'banner_image';
                    $val = 'uploads/banner_img/' . $image_name;
                    $this->db->where('key', $key);
                }
                $this->db->delete('system_settings');
                $table_data1['key'] = $key;
                $table_data1['value'] = $val;
                $table_data1['system'] = 1;
                $table_data1['groups'] = 'config';
                $table_data1['update_date'] = date('Y-m-d');
                $table_data1['status'] = 1;
                $this->db->insert('system_settings', $table_data1);
            }

            if ($_FILES['site_logo']['name']) {
                $table_data1 = [];
                $configfile['upload_path'] = FCPATH . 'uploads/logo';
                $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
                $configfile['overwrite'] = FALSE;
                $configfile['remove_spaces'] = TRUE;
                $file_name = $_FILES['site_logo']['name'];
                $configfile['file_name'] = time() . '_' . $file_name;
                $image_name = $configfile['file_name'];
                $image_url = 'uploads/logo/' . $image_name;
                $this->upload->initialize($configfile);
                if ($this->upload->do_upload('site_logo')) {
                    $img_uploadurl = 'uploads/logo' . $_FILES['site_logo']['name'];
                    $key = 'logo_front';
                    $val = 'uploads/logo/' . $image_name;
                    $this->db->where('key', $key);
                }
                $this->db->delete('system_settings');
                $table_data1['key'] = $key;
                $table_data1['value'] = $val;
                $table_data1['system'] = 1;
                $table_data1['groups'] = 'config';
                $table_data1['update_date'] = date('Y-m-d');
                $table_data1['status'] = 1;
                $this->db->insert('system_settings', $table_data1);
            }
            if ($_FILES['favicon']['name']) {
                $img_uploadurl1 = '';
                $table_data2 = '';
                $table_data = [];
                $configfile['upload_path'] = FCPATH . 'uploads/logo';
                $configfile['allowed_types'] = 'png|ico';
                $configfile['overwrite'] = FALSE;
                $configfile['remove_spaces'] = TRUE;
                $file_name = $_FILES['favicon']['name'];
                $configfile['file_name'] = $file_name;
                $this->upload->initialize($configfile);
                if ($this->upload->do_upload('favicon')) {

                    $img_uploadurl1 = $_FILES['favicon']['name'];
                    $key = 'favicon';
                    $val = $img_uploadurl1;
                    $select_fav_icon = $this->db->query("SELECT * FROM `system_settings` WHERE `key` = '$key' ");
                    $fav_icon_result = $select_fav_icon->row_array();

                    if (count($fav_icon_result) > 0) {
                        $this->db->where('key', $key);
                        $this->db->update('system_settings', array('value' => $val));
                    } else {
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $this->db->insert('system_settings', $table_data);
                    }
                    $error = '';
                } else {
                    $error = $this->upload->display_errors();
                }
            }
            if ($data) {
                $table_data = array();

                # stripe_option // 1 SandBox, 2 Live 
                # stripe_allow  // 1 Active, 2 Inactive  

                $live_publishable_key = $live_secret_key = $secret_key = $publishable_key = '';

                $query = $this->db->query("SELECT * FROM payment_gateways WHERE status = 1");
                $stripe_details = $query->result_array();
                if (!empty($stripe_details)) {
                    foreach ($stripe_details as $details) {
                        if (strtolower($details['gateway_name']) == 'stripe') {
                            if (strtolower($details['gateway_type']) == 'sandbox') {

                                $publishable_key = $details['api_key'];
                                $secret_key = $details['value'];
                            }
                            if (strtolower($details['gateway_type']) == 'live') {
                                $live_publishable_key = $details['api_key'];
                                $live_secret_key = $details['value'];
                            }
                        }
                    }
                }
                
                $braintree_merchant = $braintree_key = $braintree_publickey = $braintree_privatekey = $paypal_appid = $paypal_appkey = '';
$live_braintree_merchant = $live_braintree_key = $live_braintree_publickey = $live_braintree_privatekey = $live_paypal_appid = $live_paypal_appkey = '';
    $pdata['braintree_key'] = $this->input->post('braintree_key');
    $pdata['braintree_merchant'] = $this->input->post('braintree_merchant');
    $pdata['braintree_publickey'] = $this->input->post('braintree_publickey');
    $pdata['braintree_privatekey'] = $this->input->post('braintree_privatekey');
    $pdata['paypal_appid'] = $this->input->post('paypal_appid');
    $pdata['paypal_appkey'] = $this->input->post('paypal_appkey');
    $pdata['gateway_type'] = $this->input->post('paypal_gateway');
    if($_POST['paypal_gateway']=="sandbox"){
        $pid=1;
    }else{
        $pid=2;
    }
	$this->db->where('id',$pid);
	$this->db->update('paypal_payment_gateways',$pdata); 
	
  $query = $this->db->query("SELECT * FROM paypal_payment_gateways");
  $paypal_details = $query->result_array();
  if(!empty($paypal_details)){
    foreach ($paypal_details as $details) {      
        if(strtolower($details['gateway_type'])=='sandbox'){
		  $braintree_key = $details['braintree_key'];
		  $braintree_merchant = $details['braintree_merchant'];
		  $braintree_publickey = $details['braintree_publickey'];
		  $braintree_privatekey = $details['braintree_privatekey'];
		  $paypal_appid = $details['paypal_appid'];
		  $paypal_appkey = $details['paypal_appkey'];
        }else{
		  $live_braintree_key = $details['braintree_key'];
		  $live_braintree_merchant = $details['braintree_merchant'];
		  $live_braintree_publickey = $details['braintree_publickey'];
		  $live_braintree_privatekey = $details['braintree_privatekey'];
		  $live_paypal_appid = $details['paypal_appid'];
		  $live_paypal_appkey = $details['paypal_appkey'];
        }
    }
  } 
  $data['braintree_key']    = $braintree_key;
  $data['braintree_merchant']       = $braintree_merchant;
  $data['braintree_publickey'] = $braintree_publickey;
  $data['braintree_privatekey']    = $braintree_privatekey;
  $data['paypal_appid'] = $paypal_appid;
  $data['paypal_appkey']    = $paypal_appkey;
  
  $data['live_braintree_key']    = $live_braintree_key;
  $data['live_braintree_merchant']       = $live_braintree_merchant;
  $data['live_braintree_publickey'] = $live_braintree_publickey;
  $data['live_braintree_privatekey']    = $live_braintree_privatekey; 
  $data['live_paypal_appid'] = $live_paypal_appid;
  $data['live_paypal_appkey']    = $live_paypal_appkey;

                $data['publishable_key'] = $publishable_key;
                $data['secret_key'] = $secret_key;
                $data['live_publishable_key'] = $live_publishable_key;
                $data['live_secret_key'] = $live_secret_key;

                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }
            $message = '';
            if (!empty($error)) {
                $this->session->set_flashdata('error_message', 'Something wrong, Please try again');
            } else {
                $this->session->set_flashdata('success_message', 'Settings updated successfully');
            }
            redirect(base_url('admin/settings'));
        }

        $results = $this->admin->get_setting_list();


        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $data['banner_image'] = $this->db->get_where('system_settings', array('key'=>'banner_image'))->row()->value;

        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function emailsettings() {
        $this->common_model->checkAdminUserPermission(30);
		$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {


            $this->load->library('upload');
            $data = $this->input->post();
            if ($data) {
                $table_data = array();
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }


            $message = 'Settings saved successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url('admin/emailsettings'));
        }

        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'emailsettings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	   public function googleplus_social_media() {
		$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {


            $this->load->library('upload');
            $data = $this->input->post();
            if ($data) {
                $table_data = array();
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }


            $message = 'Settings saved successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url('admin/googleplus_social_media'));
        }

        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'googleplus_social_media';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	
	public function twit_social_media() {
		$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {


            $this->load->library('upload');
            $data = $this->input->post();
            if ($data) {
                $table_data = array();
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }


            $message = 'Settings saved successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url('admin/twit_social_media'));
        }

        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'twit_social_media';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	
		public function fb_social_media() {
		$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {


            $this->load->library('upload');
            $data = $this->input->post();
            if ($data) {
                $table_data = array();
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }


            $message = 'Settings saved successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url('admin/fb_social_media'));
        }

        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }

        $this->data['page'] = 'fb_social_media';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	public function smssettings() 
    {
		
        $this->common_model->checkAdminUserPermission(33);
        if ($this->input->post('form_submit')) {
            $data = $this->input->post();
            if ($data) {
                $table_data = array();
                if (isset($_POST['default_otp'])) {
                    $data['default_otp'] = 1;
                } else {
                    $data['default_otp'] = 0;
                }

                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            }

            $message = 'Settings saved successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url('admin/sms-settings'));
        }

        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }
        $this->data['page'] = 'smssettings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    
	public function cod_payment_gateway(){ 
		$this->common_model->checkAdminUserPermission(14);  
        $id = settingValue('cod_option');

        if ($this->input->post('form_submit')) {
			$this->db->where('key', 'cod_option');
			$this->db->delete('system_settings');
			$table_data['key'] = 'cod_option';
			$table_data['value'] = !empty($this->input->post('cod_show'))?$this->input->post('cod_show'):0;;
			$table_data['system'] = 1;
			$table_data['groups'] = 'config';
			$table_data['update_date'] = date('Y-m-d');
			$table_data['status'] = 1;
			$this->db->insert('system_settings', $table_data);
			$message = 'COD status updated successfully';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/cod_payment_gateway');
        }
        if (!empty($id)) {
            $this->data['list']['status'] = 1;
        } else {
            $this->data['list']['status'] = 0;
        }

        $this->data['page'] = 'cod_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function stripe_payment_gateway() {
		$this->common_model->checkAdminUserPermission(14);  
        $id = settingValue('stripe_option');
        if (!empty($id)) {
            $this->data['list'] = $this->admin->edit_payment_gateway($id);
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }
        $this->data['page'] = 'stripe_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	 public function razorpay_payment_gateway() {
		 $this->common_model->checkAdminUserPermission(14);  
		 $id = settingValue('razor_option');

        if (!empty($id)) {
            $this->data['list'] = $this->admin->edit_razor_payment_gateway($id);
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }

        $this->data['page'] = 'razorpay_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	public function paypal_payment_gateway() {
        $id = settingValue('paypal_option');

		if (!empty($id)) {
            $this->data['list'] = $this->admin->edit_paypal_payment_gateway($id);
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }

        $this->data['page'] = 'paypal_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	public function paytabs_payment_gateway() {
		
		$this->data['list'] = $this->admin->edit_paytab_payment_gateway();
        $this->data['page'] = 'paytab_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function payment_type() {
        if (!empty($_POST['type'])) {
            $result = $this->db->where('gateway_type=', $_POST['type'])->get('payment_gateways')->row_array();
            echo json_encode($result);
            exit;
        }
    }
	
	public function razor_payment_type() {
	if (!empty($_POST['type'])) {
		$result = $this->db->where('gateway_type=', $_POST['type'])->get('razorpay_gateway')->row_array();
		echo json_encode($result);
		exit;
	}
	}
	
	
	public function paypal_payment_type(){ 
	  if(!empty($_POST['type'])){
		$result=$this->db->where('gateway_type=',$_POST['type'])->get('paypal_payment_gateways')->row_array();
		echo json_encode($result);exit;
	  }
	}

    public function paystack_payment_type(){ 
        if(!empty($_POST['type'])){
            $result=$this->db->where('gateway_type=',$_POST['type'])->get('paystack_payment_gateways')->row_array();
            echo json_encode($result);exit;
        }
    }
    public function edit($id = NULL) {
		$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {
            if ($_POST['gateway_type'] == "sandbox") {
                $id = 1;
            } else {
                $id = 2;
            }
            $data['gateway_name'] = $this->input->post('gateway_name');
            $data['gateway_type'] = $this->input->post('gateway_type');
            $data['api_key'] = $this->input->post('api_key');
            $data['value'] = $this->input->post('value');
            $data['status'] = !empty($this->input->post('stripe_show'))?$this->input->post('stripe_show'):0;
            $this->db->where('id', $id);
            if ($this->db->update('payment_gateways', $data)) {
                if ($this->input->post('gateway_type') == 'sandbox') {
                    $datass['publishable_key'] = $this->input->post('api_key');
                    $datass['secret_key'] = $this->input->post('value');
                } else {
                    $datass['live_publishable_key'] = $this->input->post('api_key');
                    $datass['live_secret_key'] = $this->input->post('value');
                }
                $stripe_option = settingValue('stripe_option');
                if (!empty($stripe_option)) {
                    $this->db->where('key', 'stripe_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'stripe_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            }
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/stripe_payment_gateway');
        }

        $this->data['list'] = $this->admin->edit_payment_gateway($id);
        $this->data['page'] = 'stripe_payment_gateway_edit';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	
	    public function razor_edit($id = NULL) {
			$this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {
            if ($_POST['gateway_type'] == "sandbox") {
                $id = 1;
            } else {
                $id = 2;
            }
            $data['gateway_name'] = $this->input->post('gateway_name');
            $data['gateway_type'] = $this->input->post('gateway_type');
            $data['api_key'] = $this->input->post('api_key');
            $data['api_secret'] = $this->input->post('value');
            $data['status'] = !empty($this->input->post('razor_show'))?$this->input->post('razor_show'):0;
            $this->db->where('id', $id);
            if ($this->db->update('razorpay_gateway', $data)) {
                if ($this->input->post('gateway_type') == 'sandbox') {
                    $datass['razorpay_apikey'] = $this->input->post('api_key');
                    $datass['razorpay_secret_key'] = $this->input->post('value');
                } else {
                    $datass['live_razorpay_apikey'] = $this->input->post('api_key');
                    $datass['live_razorpay_secret_key'] = $this->input->post('value');
                }
                $razor_option = settingValue('razor_option');
				
                if (!empty($razor_option)) {
                    $this->db->where('key', 'razor_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'razor_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            }
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/razorpay_payment_gateway');
        }

        $this->data['list'] = $this->admin->edit_payment_gateway($id);
        $this->data['page'] = 'razorpay_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	   public function paypal_edit($id = NULL) {
		   $this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {
            if ($_POST['paypal_gateway'] == "sandbox") {
                $id = 1;
            } else {
                $id = 2;
            }

            $data['braintree_key'] = $this->input->post('braintree_key');
            $data['gateway_type'] = $this->input->post('paypal_gateway');
            $data['braintree_merchant'] = $this->input->post('braintree_merchant');
            $data['braintree_publickey'] = $this->input->post('braintree_publickey');
            $data['braintree_privatekey'] = $this->input->post('braintree_privatekey');
            $data['paypal_appid'] = $this->input->post('paypal_appid');
            $data['paypal_appkey'] = $this->input->post('paypal_appkey');
           $data['status'] = !empty($this->input->post('paypal_show'))?$this->input->post('paypal_show'):0;
            $this->db->where('id', $id);
            if ($this->db->update('paypal_payment_gateways', $data)) {
                if ($this->input->post('paypal_gateway') == 'sandbox') {
                    $datass['braintree_key'] = $this->input->post('braintree_key');
					$datass['gateway_type'] = $this->input->post('paypal_gateway');
					$datass['braintree_merchant'] = $this->input->post('braintree_merchant');
					$datass['braintree_publickey'] = $this->input->post('braintree_publickey');
					$datass['braintree_privatekey'] = $this->input->post('braintree_privatekey');
					$datass['paypal_appid'] = $this->input->post('paypal_appid');
					$datass['paypal_appkey'] = $this->input->post('paypal_appkey');
                } else {
                    $datass['braintree_key'] = $this->input->post('braintree_key');
					$datass['gateway_type'] = $this->input->post('paypal_gateway');
					$datass['braintree_merchant'] = $this->input->post('braintree_merchant');
					$datass['braintree_publickey'] = $this->input->post('braintree_publickey');
					$datass['braintree_privatekey'] = $this->input->post('braintree_privatekey');
					$datass['paypal_appid'] = $this->input->post('paypal_appid');
					$datass['paypal_appkey'] = $this->input->post('paypal_appkey');
                }
                $paypal_option = settingValue('paypal_option');
				
                if (!empty($paypal_option)) {
                    $this->db->where('key', 'paypal_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'paypal_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            } else {
                if ($this->db->insert('paypal_payment_gateways', $data)) {
                if ($this->input->post('paypal_gateway') == 'sandbox') {
                    $datass['braintree_key'] = $this->input->post('braintree_key');
                    $datass['gateway_type'] = $this->input->post('paypal_gateway');
                    $datass['braintree_merchant'] = $this->input->post('braintree_merchant');
                    $datass['braintree_publickey'] = $this->input->post('braintree_publickey');
                    $datass['braintree_privatekey'] = $this->input->post('braintree_privatekey');
                    $datass['paypal_appid'] = $this->input->post('paypal_appid');
                    $datass['paypal_appkey'] = $this->input->post('paypal_appkey');
                } else {
                    $datass['braintree_key'] = $this->input->post('braintree_key');
                    $datass['gateway_type'] = $this->input->post('paypal_gateway');
                    $datass['braintree_merchant'] = $this->input->post('braintree_merchant');
                    $datass['braintree_publickey'] = $this->input->post('braintree_publickey');
                    $datass['braintree_privatekey'] = $this->input->post('braintree_privatekey');
                    $datass['paypal_appid'] = $this->input->post('paypal_appid');
                    $datass['paypal_appkey'] = $this->input->post('paypal_appkey');
                }
                $paypal_option = settingValue('paypal_option');
                
                if (!empty($paypal_option)) {
                    $this->db->where('key', 'paypal_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'paypal_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            }
        }
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/paypal_payment_gateway');
        }

        $this->data['list'] = $this->admin->edit_payment_gateway($id);
        $this->data['page'] = 'paypal_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	 public function paytab_edit($id = NULL) {
		 $this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {
            
			$id=1;
            $data['sandbox_email'] = $this->input->post('sandbox_email');
            $data['sandbox_secretkey'] = $this->input->post('sandbox_secretkey');
            $data['email'] = $this->input->post('email');
            $data['secretkey'] = $this->input->post('secretkey');
            $this->db->where('id', $id);
            if ($this->db->update('paytabs_details', $data)) {
               
                    $datass['sandbox_email'] = $this->input->post('sandbox_email');
					$datass['sandbox_secretkey'] = $this->input->post('sandbox_secretkey');
					$datass['email'] = $this->input->post('email');
					$datass['secretkey'] = $this->input->post('secretkey');
                
                $paytab_option = settingValue('paytab_option');
				
                if (!empty($paytab_option)) {
                    $this->db->where('key', 'paytab_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'paytab_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            }
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/paytabs_payment_gateway');
        }

        $this->data['list'] = $this->admin->edit_payment_gateway($id);
        $this->data['page'] = 'paytab_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
	
	
	

    public function ThemeColorChange() {
        $this->common_model->checkAdminUserPermission(34);
        $this->data['page'] = 'theme_color';
        $this->data['Colorlist'] = $this->admin->ColorList();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function ChangeColor() {
        $Postdata = $this->input->post();
        $ChangeColor = $Postdata['color'];

        if ($ChangeColor) {

            $whr = [
                'id' => $ChangeColor
            ];
            $color = [
                'status' => 1
            ];
            $query=$this->db->query("UPDATE theme_color_change SET status='0'");
            $updateColor = $this->admin->update_data('theme_color_change', $color, $whr);

            if ($updateColor) {
                $this->session->set_flashdata('success_message1', 'Color Change Suceessfully');
                redirect(base_url() . 'admin/theme-color');
            }
        } else {
            $this->session->set_flashdata('error_message1', 'Choose the Color');
            redirect(base_url() . 'admin/theme-color');
        }
    }

    public function paystack_payment_gateway() {
        $id = settingValue('paystack_option');
        if (!empty($id)) {
            $this->data['list'] = $this->admin->edit_paystack_payment_gateway($id);
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }

        $this->data['page'] = 'paystack_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function paysolution_payment_gateway() {
        if($this->input->post('form_submit') == 'submit') {
            $paymentdata = $this->input->post();
            $paymentdata['paysolution_show'] = $paymentdata['paysolution_show']?'1':'0';
            foreach ($paymentdata AS $key => $val) {
                $data['key'] = $key;
                $data['value'] = $val;
                $data['system'] = 1;
                $data['groups'] = 'config';
                $data['update_date'] = date('Y-m-d');
                $data['status'] = 1;
                $paysolution = $this->db->get_where('system_settings', array('key'=>$key))->row();
                if($key != 'form_submit') {
                    if($paysolution == '') {
                        $this->db->insert('system_settings', $data);
                    } else {
                        $this->db->where('key', $key)->update('system_settings', $data);
                    }
                }
            } 
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Payment Settings Updated Succesfullly');
                redirect(base_url() . 'admin/paysolution_payment_gateway');
            } else {
                $this->session->set_flashdata('success_error', 'Something went wrong, try again');
                redirect(base_url() . 'admin/paysolution_payment_gateway');
            } 
        }
        $this->data['page'] = 'paysolution_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function paystack_edit($id = NULL) {
            $this->common_model->checkAdminUserPermission(14);
        if ($this->input->post('form_submit')) {
            if ($_POST['gateway_type'] == "sandbox") {
                $id = 1;
            } else {
                $id = 2;
            }
            $data['gateway_name'] = $this->input->post('gateway_name');
            $data['gateway_type'] = $this->input->post('gateway_type');
            $data['api_key'] = $this->input->post('api_key');
            $data['value'] = $this->input->post('value');
            $data['status'] = !empty($this->input->post('paystack_show'))?$this->input->post('paystack_show'):0;
            $this->db->where('id', $id);
            if ($this->db->update('paystack_payment_gateways', $data)) {
                if ($this->input->post('gateway_type') == 'sandbox') {
                    $datass['paystack_apikey'] = $this->input->post('value');
                    $datass['paystack_secret_apikey'] = $this->input->post('api_key');
                } else {
                    $datass['live_paystack_apikey'] = $this->input->post('value');
                    $datass['live_paystack_secret_apikey'] = $this->input->post('api_key');
                }
                $paystack_option = settingValue('paystack_option');
                
                if (!empty($paystack_option)) {
                    $this->db->where('key', 'paystack_option')->update('system_settings', ['value' => $id]);
                } else {
                    $this->db->insert('system_settings', ['key' => 'paystack_option', 'value' => $id]);
                }

                foreach ($datass AS $key => $val) {
                    $this->db->where('key', $key);
                    $this->db->delete('system_settings');
                    $table_data['key'] = $key;
                    $table_data['value'] = $val;
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                }

                $message = 'Payment gateway edit successfully';
            }
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . 'admin/paystack_payment_gateway');
        }

        $this->data['list'] = $this->admin->edit_paystack_payment_gateway($id);
        $this->data['page'] = 'paystack_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    //App Section 
    public function appsection() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['download_showhide'])) {
                    $data['download_showhide'] = 1;
                } else {
                    $data['download_showhide'] = 0;
                }
                print_r($data);exit;
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
                 $this->session->set_flashdata('success_message', 'Popular Services Details updated successfully');
            redirect(base_url() . 'admin/pages');
            }
        }

        $this->data['appsection_showhide'] = settingValue('download_showhide');
        $this->data['app_store_link'] = settingValue('app_store_link');
        $this->data['play_store_link'] = settingValue('play_store_link');
        $this->data['page'] = 'appsection';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function systemSetting() {
        $this->common_model->checkAdminUserPermission(42);
        if($this->input->post('form_submit') == true) {
            $map_details = $this->db->get_where('system_settings', array('key'=>'map_key'))->row();
            $apikey_details = $this->db->get_where('system_settings', array('key'=>'firebase_server_key'))->row();

            if($this->input->post('map_key')) {
                if(empty($map_details)) {
                    $table_data['key'] = 'map_key';
                    $table_data['value'] = $this->input->post('map_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                } else {
                    $where = array('key' => 'map_key');
                    $table_data['key'] = 'map_key';
                    $table_data['value'] = $this->input->post('map_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->admin->update_data('system_settings', $table_data, $where);
                }
            }
            if($this->input->post('firebase_server_key')) {
                if(empty($apikey_details)) {
                    $table_data['key'] = 'firebase_server_key';
                    $table_data['value'] = $this->input->post('firebase_server_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                } else {
                    $where = array('key' => 'firebase_server_key');
                    $table_data['key'] = 'firebase_server_key';
                    $table_data['value'] = $this->input->post('firebase_server_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->admin->update_data('system_settings', $table_data, $where);
                }
            }
            $this->session->set_flashdata('success_message', 'Details updated successfully');
            redirect(base_url() . 'admin/system-settings');
        }
        $this->data['firebase_server_key'] = settingValue('firebase_server_key');
        $this->data['map_key'] = settingValue('map_key');
        $this->data['page'] = 'system_settings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function localization() {
        $this->common_model->checkAdminUserPermission(28);
         $data = $this->input->post();

        if ($this->input->post('form_submit')) {
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                        
                    }
                }
             if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Localization updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            }
        $this->data['currency_symbol'] = currency_code_symbol();
        $this->data['page'] = 'localization';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function get_currnecy_symbol() {
        $code = $this->input->post('id');
        $result = currency_code_sign($code);
        echo $result;
    }

    //Update Social settings details
    public function socialSetting() {
        $this->common_model->checkAdminUserPermission(29);
        if($this->input->post('form_submit') == true) {
            $data = $this->input->post();
            $table_data = array();
            foreach ($data AS $key => $val) {
                if ($key != 'form_submit') {
                    $data_details = $this->db->get_where('system_settings', array('key'=>$key))->row();
                    $table_data = array(
                        'key' => $key,
                        'value' => $val,
                        'system' => 1,
                        'groups' => 'config',
                        'update_date' => date('Y-m-d'),
                        'status' => 1
                    );
                    if(empty($data_details)) {
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $where = array('key' => $key);
                        $this->db->update('system_settings', $table_data, $where);
                    }
                    
                }
            }
            $this->session->set_flashdata('success_message', 'Details updated successfully');
            redirect(base_url() . 'admin/social-settings');
        }
        $this->data['login_type'] = settingValue('login_type');
        $this->data['otp_by'] = settingValue('otp_by');
        $this->data['page'] = 'social_settings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

     public function frontSetting() {
        $this->data['page'] = 'localization';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function footerSetting() {
        $this->common_model->checkAdminUserPermission(40);
        $this->data['page'] = 'footerSetting';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function pages() {
        $this->common_model->checkAdminUserPermission(41);
        $this->data['pages'] = $this->db->get('page_content')->result();
        $this->data['page'] = 'pages';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 
    public function seoSetting() {
        $this->common_model->checkAdminUserPermission(32);
         if($this->input->post("form_submit") == true) {
            $data = $this->input->post();
            $table_data = array();
            foreach ($data AS $key => $val) {
                if ($key != 'form_submit') {
                    $data_details = $this->db->get_where('system_settings', array('key'=>$key))->row();
                    $table_data = array(
                        'key' => $key,
                        'value' => $val,
                        'system' => 1,
                        'groups' => 'config',
                        'update_date' => date('Y-m-d'),
                        'status' => 1
                    );
                    if(empty($data_details)) {
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $where = array('key' => $key);
                        $this->db->update('system_settings', $table_data, $where);
                    }
                    
                }
            }
            
            $this->session->set_flashdata('success_message', 'SEO Details updated successfully');
            redirect(base_url() . 'admin/seo-settings');
        }
        $results = $this->admin->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }
        $this->data['page'] = 'seo_settings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function home_page() {
        $this->data['featured'] = $this->db->get_where('categories', array('is_featured'=>1, 'status'=>1))->result_array();
        $this->data['list'] = $this->admin->GetBannersettings();
        $this->data['service'] = $this->admin->Getpopularsettings();
        $this->data['page'] = 'home_page';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    } 

    public function bannersettings() {
       $this->common_model->checkAdminUserPermission(24);
        $title = $this->input->post('bgimg_for');
        if($this->input->post("form_submit") == true) {
            $banner_title = $this->db->get_where('bgimage', array('bgimg_id'=> 1))->row();
            $post_data = $this->input->post();
             $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['upload_image']['name']) && !empty($_FILES['upload_image']['name'])) {
                $uploaded_file_name = $_FILES['upload_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/banners/', 'upload_image', time() . $filename);

                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];

                    if (!empty($uploaded_file_name)) {
                        $image_url = 'uploads/banners/' . $uploaded_file_name;                    }
                }
            }else {
                $image_url = $banner_title->upload_image;
            }
            $table_data = array(
                'banner_content' => $post_data['banner_content'],
                'banner_sub_content' => $post_data['banner_sub_content'],
                'banner_settings' => ($post_data['banner_showhide'])?'1':'0',
                'main_search' => ($post_data['main_showhide'])?'1':'0',
                'popular_search' => ($post_data['popular_showhide'])?'1':'0',
                'upload_image' => $image_url,
                'popular_label' => $post_data['popular_label']
            );
            if(empty($banner_title)) {
                $table_data['created_datetime'] =date('Y-m-d H:i:s');
                $this->db->insert('bgimage', $table_data);
            } else {  
                $where = array('bgimg_id' => 1);
                $table_data['updated_datetime'] =date('Y-m-d H:i:s');
                $this->admin->update_data('bgimage', $table_data, $where);
            }
            
            $this->session->set_flashdata('success_message', 'Bannersettings Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
        }
    }

    public function howitworks() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
           if ($data) {
                if (isset($data['how_showhide'])) {
                    $data['how_showhide'] = '1';
                } else {
                    $data['how_showhide'] = '0';
                }

                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['how_title_img_1']['name']) && !empty($_FILES['how_title_img_1']['name'])) {
                    $uploaded_file_name = $_FILES['how_title_img_1']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'how_title_img_1', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $image_url_1= 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $image_url_1 = settingValue('how_title_img_1');
                }

                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['how_title_img_2']['name']) && !empty($_FILES['how_title_img_2']['name'])) {
                    $uploaded_file_name = $_FILES['how_title_img_2']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'how_title_img_2', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $image_url_2 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $image_url_2 =settingValue('how_title_img_2');
                }


                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['how_title_img_3']['name']) && !empty($_FILES['how_title_img_3']['name'])) {
                    $uploaded_file_name = $_FILES['how_title_img_3']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'how_title_img_3', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $image_url_3 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $image_url_3 = settingValue('how_title_img_3');
                }
                    //   changes for logo update by gouresh @17-03023//
                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['how_title_img_4']['name']) && !empty($_FILES['how_title_img_4']['name'])) {
                    $uploaded_file_name = $_FILES['how_title_img_4']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'how_title_img_4', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $image_url_4= 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $image_url_4 = settingValue('how_title_img_4');
                }
                // end  changes for logo update by gouresh @17-03023//

                $data['how_title_img_1'] = $image_url_1;
                $data['how_title_img_2'] = $image_url_2;
                $data['how_title_img_3'] = $image_url_3;
                 //   changes for logo update by gouresh @17-03023//
                $data['how_title_img_4'] = $image_url_4;
                //   changes for logo update by gouresh @17-03023//
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'How It Works Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }

    public function popularservices() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['popular_ser_showhide'])) {
                    $data['popular_ser_showhide'] = '1';
                } else {
                    $data['popular_ser_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Popular Services Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }

    public function newestservices() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['newest_ser_showhide'])) {
                    $data['newest_ser_showhide'] = '1';
                } else {
                    $data['newest_ser_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Popular Services Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }


    public function topratingservices() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['top_rating_showhide'])) {
                    $data['top_rating_showhide'] = '1';
                } else {
                    $data['top_rating_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Featured Services Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }


    public function download_sec() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {
           
            
            if ($data) {
                if (isset($data['download_showhide'])) {
                    $data['download_showhide'] = '1';
                } else {
                    $data['download_showhide'] = '0';
                }
                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['app_store_img']['name']) && !empty($_FILES['app_store_img']['name'])) {
                    $uploaded_file_name = $_FILES['app_store_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'app_store_img', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $app_store_img1 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $app_store_img1 = settingValue('app_store_img');
                }
                $uploaded_file_name = '';
                if (isset($_FILES) && isset($_FILES['play_store_img']['name']) && !empty($_FILES['play_store_img']['name'])) {
                    $uploaded_file_name = $_FILES['play_store_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'play_store_img', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $play_store_img1 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                } else {
                $play_store_img1 =settingValue('play_store_img');
                }
                $data['play_store_img'] = $play_store_img1;
                $data['app_store_img'] = $app_store_img1;
                 foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Download Section Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }

     public function featured_categories() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['featured_showhide'])) {
                    $data['featured_showhide'] = '1';
                } else {
                    $data['featured_showhide'] = '0';
                }
                $datas = array(
                    'featured_showhide' => $data['featured_showhide'],
                    'featured_title' => $data['featured_title'],
                    'featured_content' => $data['featured_content'],
                    'featured_categories' => $data['selected_categories1']
                );
                foreach ($datas AS $key => $val) {
                    $getdata = $this->db->get_where('system_settings', array('key' => $key))->row();
                    $table_data = array(
                        'key' => $key,
                        'value' => $val,
                        'system' => 1,
                        'groups' => 'config',
                        'update_date' => date('Y-m-d'),
                        'status' => 1
                    );
                    if(empty($getdata)) {
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $this->db->where('key',$key);
                        $this->db->update('system_settings',$table_data);
                    }
                }

            $this->session->set_flashdata('success_message', 'Featured Categories Details updated successfully');
            redirect(base_url() . 'settings/home-page/17');
            }
        }
    }

     public function page_status(){
        $id=$this->input->post('status_id');
        $table_data['status'] =$this->input->post('status');
        $this->db->where('id',$id);
        if($this->db->update('page_content',$table_data)){ 
          echo "success";
        } else {
          echo "error";
        }
  }

    public function analytics() {
        $this->common_model->checkAdminUserPermission(37);
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
          if ($data) {
                if (isset($data['analytics_showhide'])) {
                    $data['analytics_showhide'] = '1';
                } else {
                    $data['analytics_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Google Analytics Details updated successfully');
            redirect(base_url() . 'admin/other-settings');
            }
        }
    }

    public function cookies() {
        $this->common_model->checkAdminUserPermission(37);
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
           if ($data) {
                if (isset($data['cookies_showhide'])) {
                    $data['cookies_showhide'] = '1';
                } else {
                    $data['cookies_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Cookies Agreement Details updated successfully');
            redirect(base_url() . 'admin/other-settings');
            }
        }
    }

    public function socket() {
        $this->common_model->checkAdminUserPermission(38);
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['socket_showhide'])) {
                    $data['socket_showhide'] = '1';
                } else {
                    $data['socket_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Socket Details updated successfully');
            redirect(base_url() . 'admin/chat-settings');
            }
        }
    }

     public function chat() {
        $this->common_model->checkAdminUserPermission(38);
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($data) {
                if (isset($data['chat_showhide'])) {
                    $data['chat_showhide'] = '1';
                } else {
                    $data['chat_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Chat Details updated successfully');
            redirect(base_url() . 'admin/chat-settings');
            }
        }
    }

     public function midtrans_payment_gateway() {
        $this->common_model->checkAdminUserPermission(14);
        $datas = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($datas) {
                if (isset($data['midtrans_showhide'])) {
                    $datass['midtrans_show'] = '1';
                } else {
                    $datass['midtrans_show'] = '0';
                }
                if ($_POST['gateway_type'] == "sandbox") {
                    $id = 1;
                } else {
                    $id = 2;
                }
                $data['gateway_name'] = $this->input->post('midtrans_gateway_name');
                $data['gateway_type'] = $this->input->post('gateway_type');
                $data['client_key'] = $this->input->post('client_key');
                $data['serverkey_key'] = $this->input->post('server_key');
                $data['merchant_id'] = $this->input->post('merchant_id');
                $data['status'] = !empty($this->input->post('midtrans_show'))?$this->input->post('midtrans_show'):0;
                $this->db->where('id', $id);
                if ($this->db->update('midtrans_gateway', $data)) {
                   
                    $datass['midtrans_show'] = $this->input->post('midtrans_show');
                    $datass['midtrans_option'] = $id;
                    if ($this->input->post('gateway_type') == 'sandbox') {
                        $datass['midtrans_secret_apikey'] = $this->input->post('client_key');
                        $datass['midtrans_secret_serverkey'] = $this->input->post('server_key');
                    } else {
                        $datass['live_midtrans_secret_apikey'] = $this->input->post('client_key');
                        $datass['live_midtrans_secret_serverkey'] = $this->input->post('server_key');
                    }
                    $midtrans_option = settingValue('midtrans_option');
                    
                    if (!empty($midtrans_option)) {
                        $this->db->where('key', 'midtrans_option')->update('system_settings', ['value' => $id]);
                    } else {
                        $this->db->insert('system_settings', ['key' => 'midtrans_option', 'value' => $id]);
                    }

                    foreach ($datass AS $key => $val) {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }

                    $this->session->set_flashdata('success_message', 'Payment Details updated successfully');
                    redirect(base_url() . 'admin/midtrans_payment_gateway');
                }
            
            }  
        }
        $id = settingValue('midtrans_option');
        if (!empty($id)) {
            $this->data['list'] = $this->admin->midtrans_payment_gateway($id);
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }
        $this->data['page'] = 'midtrans_payment_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');

    }

    public function midtrans_payment_type(){ 
        if(!empty($this->input->post('type'))){
            $result=$this->db->where('gateway_type=',$this->input->post('type'))->get('midtrans_gateway')->row_array();
            echo json_encode($result);exit;
        }
    }

    public function midtrans_payout_gateway() {
        $this->common_model->checkAdminUserPermission(14);
        $datas = $this->input->post();
        if ($this->input->post('form_submit')) {
            if ($datas) {
                if ($_POST['midtrans_payout_option'] == "sandbox") {
                    $id = 1;
                } else {
                    $id = 2;
                }
                $data['gateway_name'] = 'midtrans';
                $data['gateway_type'] = $this->input->post('midtrans_payout_option');
                $data['client_key'] = $this->input->post('payout_client_key');
                $data['status'] = $id;
                $this->db->where('id', $id);
                if ($this->db->update('midtrans_payout_gateway', $data)) {
                   
                    $datass['midtrans_show'] = $this->input->post('midtrans_show');
                    $datass['midtrans_option'] = $id;
                    if ($this->input->post('midtrans_payout_option') == 'sandbox') {
                        $datass['midtrans_payout_apikey'] = $this->input->post('payout_client_key');
                        $datass['midtrans_payout_option'] =$_POST['midtrans_payout_option'];
                    } else {
                        $datass['live_midtrans_payout_apikey'] = $this->input->post('payout_client_key');
                    }
                    $midtrans_option = settingValue('midtrans_payout_option');
                    
                    if (!empty($midtrans_option)) {
                        $this->db->where('key', 'midtrans_payout_option')->update('system_settings', ['value' => $id]);
                    } else {
                        $this->db->insert('system_settings', ['key' => 'midtrans_payout_option', 'value' => $id]);
                    }

                    foreach ($datass AS $key => $val) {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }

                    $this->session->set_flashdata('success_message', 'Payment Details updated successfully');
                    redirect(base_url() . 'admin/midtrans_payout_gateway');
                }
            
            }  
        }
        $id = settingValue('midtrans_payout_option');
        if (!empty($id)) {
            $this->data['list'] = $this->admin->midtrans_payout_gateway($id);
           // echo '<pre>'; print_r($this->data['list']); exit;
        } else {
            $this->data['list'] = [];
            $this->data['list']['id'] = '';
            $this->data['list']['gateway_type'] = '';
            $this->data['gateway_type'] = '';
        }
        $this->data['page'] = 'midtrans_payout_gateway';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');

    }

    public function midtrans_payout_type(){ 
        if(!empty($this->input->post('type'))){
            $result=$this->db->where('gateway_type',$this->input->post('type'))->get('midtrans_payout_gateway')->row_array();
            echo json_encode($result);exit;
        }
    }

}
