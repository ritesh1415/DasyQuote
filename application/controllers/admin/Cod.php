<?php
class Cod extends CI_Controller
{
    public $data;
    
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['model'] = 'cod';
        $this->load->model('admin_model');
		$this->load->model('common_model','common_model');
        $this->data['base_url'] = base_url();
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role        = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
    }

    public function index($offset = 0)
    {
		$this->common_model->checkAdminUserPermission(18);
        $this->data['page'] = 'index';
        $this->data['lists'] = $this->admin_model->get_cod();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    
}
