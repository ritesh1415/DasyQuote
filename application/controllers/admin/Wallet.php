<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

   public $data;

  public function __construct() 
  {
    parent::__construct();
    $this->load->model('service_model','service');
    $this->load->model('wallet_model','wallet');
    $this->load->model('common_model','common_model');
    $this->load->model('api_model','api');
    $this->data['theme'] = 'admin';
    $this->data['model'] = 'wallet';
    $this->data['base_url'] = base_url();
    $this->session->keep_flashdata('error_message');
    $this->session->keep_flashdata('success_message');
    $this->load->helper('user_timezone_helper');
  }

	public function index()
	{
    $this->common_model->checkAdminUserPermission(10);
    if(!empty($this->input->post())) {
      $token=$this->input->post('token');
      $from=$this->input->post('from');
      $to=$this->input->post('to');
      $this->data['page'] = 'wallet_report_view';
      $this->data['model'] = 'wallet';
      $this->data['list'] = $this->wallet->get_wallet_info_filter($token,$from,$to); 
      $this->data['filter'] = array('token_f'=>$token, 
                                    'service_from'=>$from,
                                    'service_to'=>$to 
                                  );
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');     
    }else{
      $this->data['page'] = 'wallet_report_view';
      $this->data['model'] = 'wallet';
      $this->data['list'] = $this->wallet->get_wallet_info();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }

		
	}

    public function wallet_history() {
    	$this->common_model->checkAdminUserPermission(10);
        if(!empty($this->input->post())){
            $token=$this->input->post('token');
            $from=$this->input->post('from');
            $to=$this->input->post('to');
            $this->data['page'] = 'wallet_trans_report_view';
            $this->data['model'] = 'wallet';
            $this->data['list'] = $this->wallet->get_wallet_history_filter($token,$from,$to); 
            $this->data['filter'] = array('token_f'=>$token, 'service_from'=>$from,'service_to'=>$to);
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'].'/template');
        } else {
            $this->data['page'] = 'wallet_trans_report_view';
            $this->data['model'] = 'wallet';
            $this->data['list'] = $this->wallet->get_wallet_history();
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'].'/template');
        }
    }

    public function wallet_request_history() {
        $this->common_model->checkAdminUserPermission(10);
        if(!empty($this->input->post())){
            $token=$this->input->post('token');
            $from=$this->input->post('from');
            $to=$this->input->post('to');
            $this->data['page'] = 'wallet_request_view';
            $this->data['model'] = 'wallet';
            $this->data['list'] = $this->wallet->get_wallet_request_history_filter($token,$from,$to); 
            $this->data['filter'] = array('token_f'=>$token, 'service_from'=>$from,'service_to'=>$to);
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'].'/template');
        } else {
            $this->data['page'] = 'wallet_request_view';
            $this->data['model'] = 'wallet';
            $this->data['list'] = $this->wallet->get_wallet_request_history();
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'].'/template');
        }
    }
	
    
  public function request_list()
	{
			$lists = $this->service->request_list();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($lists as $template) {
	            $no++;
	            $row    = array();
	            $row[]  = $no;
              $profile_img = $template['profile_img'];
              if(empty($profile_img)){
                $profile_img = 'assets/img/user.jpg';
              }
	            $row[]  = '<a href="#" class="avatar"> <img alt="" src="'.$profile_img.'"></a><h2><a href="#">'.$template['username'].'</a></h2>';
	            $row[]  = $template['contact_number'];
              $row[]  = $template['title'];
              $row[]  = '<p class="price-sup"><sup>RM</sup>'.$template['proposed_fee'].'</p>';
              $row[]  = '<span class="service-date">'.date("d M Y", strtotime($template['request_date'])).'<span class="service-time">'.date("H.i A", strtotime($template['request_time'])).'</span></span>';
              $row[]  = date("d M Y", strtotime($template['created']));
              $val = '';
              $status = $template['status'];
              if($status == -1)
              {
                $val = '<span class="label label-danger-border">Expired</span>';
              }
              if($status == 0)
              {
                $val = '<span class="label label-warning-border">Pending</span>';
              }
              elseif($status == 1)
              {
                $val = '<span class="label label-info-border">Accepted</span>';
              }
              elseif($status == 2)
              {
                $val = '<span class="label label-success-border">Completed</span>';
              }
              elseif($status == 3)
              {
                $val = '<span class="label label-danger-border">Declined</span>';
              }
              elseif($status == 4)
              {
                $val = '<span class="label label-danger-border">Deleted</span>';
              }
	            $row[]  = $val;
	            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->service->request_list_all(),
                        "recordsFiltered" => $this->service->request_list_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);

	}

   public function delete_service()
  {
    $id=$this->input->post('service_id');

    $inputs['status']= '0';
    $WHERE =array('id' => $id);
    $result=$this->service->update_service($inputs,$WHERE);


        redirect(base_url()."service-list");   

     } 
 //
  public function getProivdierBankDetails() {
    $provider_id = $this->input->post('id');
    $bank_details = $this->db->select('account_holder_name,account_number,account_iban,bank_name, bank_address,sort_code,routing_number,account_ifsc')->get_where('stripe_bank_details', array('user_id'=>$provider_id))->row();
    echo json_encode($bank_details); 
  }

    public function wallet_request_status() {
        $postdata = $this->input->post();
        //echo 'data<pre>'; print_r($postdata);
        //echo '<pre>file<pre>'; print_r($_FILES); exit;

        if(!is_dir('uploads/wallet_trans_doc')) {
            mkdir('./uploads/wallet_trans_doc/', 0777, TRUE);
        }

        $uploaded_file_name = '';
        if (isset($_FILES) && isset($_FILES['upload_doc']['name']) && !empty($_FILES['upload_doc']['name'])) {
            $uploaded_file_name = $_FILES['upload_doc']['name'];
            $uploaded_file_name_arr = explode('.', $uploaded_file_name);
            $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
            $this->load->library('common');
            $upload_sts = $this->common->global_file_upload('uploads/wallet_trans_doc/', 'upload_doc', time() . $filename);

            if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                $uploaded_file_name = $upload_sts['data']['file_name'];

                if (!empty($uploaded_file_name)) {
                    $image_url = 'uploads/wallet_trans_doc/' . $uploaded_file_name;
                    //$table_data['thumb_image'] = $this->image_resize(150, 150, $image_url, $uploaded_file_name);
                }
            }
        }
        $token = $this->db->get_where('providers', array('id'=>$postdata['provider_id']))->row()->token;
        $update_data = array(
            'paid_status' => 'paid',
            'transaction_document' => $image_url,
        );

        $this->db->where('id',$postdata['id']);                
        $this->db->update('wallet_transaction_history', $update_data);

        if($this->db->affected_rows() > 0) {
            $this->send_push_notification($token, $postdata['provider_id'], 1, 'Your Wallet Request Amount Paid by Admin');
        }
        $this->session->set_flashdata('success_message', 'Status updated successfully');
        redirect(base_url() . "admin/wallet");
    }


    public function wallet_request_cancel() {
        $postdata = $this->input->post();
        $user = $this->db->where('id', $postdata['provider_id'])->get('providers')->row_array();
        $wallet = $this->db->where('user_provider_id', $postdata['provider_id'])->where('type', 1)->get('wallet_table')->row_array();
        $wallet_amt = $wallet['wallet_amt'];
        $user_name     = $user['name'];
        $user_token    = $user['token'];
        $currency_type = $user['currency_code'];
        if($wallet_amt){
            $current_wallet = $wallet_amt+$postdata['amount'];
        }else{
            $current_wallet = $wallet_amt;
        }

        $history_pay['token']=$user_token;
        $history_pay['user_provider_id']=$postdata['provider_id'];
        $history_pay['currency_code']=$user['currency_code'];
        $history_pay['credit_wallet'] = 0;
        $history_pay['debit_wallet'] = $postdata['amount'];
        $history_pay['type']='1';
        $history_pay['transaction_id']='0';
        $history_pay['paid_status']='cancel';
        $history_pay['cust_id']='self';
        $history_pay['card_id']='self';
        $history_pay['reference_key']=$ref_key;
        $history_pay['total_amt']=$postdata['amount'];
        $history_pay['tokenid']=$user_token;
        $history_pay['current_wallet']=$wallet_amt;
        $history_pay['avail_wallet'] = $current_wallet;
        $history_pay['reason']='Admin Cancelled Withdraw Request';
        $history_pay['payment_detail']='Withdraw Request Cancelled';
        $history_pay['created_at'] = date('Y-m-d H:i:s');

        $this->db->where('id',$postdata['id']);                
        $this->db->update('wallet_transaction_history', $history_pay);
        if($this->db->affected_rows() > 0) {
            
            $this->db->where(array('user_provider_id'=>$postdata['provider_id'], 'type'=>'1'))->update('wallet_table', array(
                'currency_code' => $user['currency_code'],
                'wallet_amt' => $wallet_amt+$postdata['amount'],
                'updated_on' => date('Y-m-d H:i:s')
            ));
            echo '1'; 
        }

    }
    /*push notification*/

    public function send_push_notification($token,$user_id, $type,$msg=''){

    if($type==1){
        $device_tokens=$this->api->get_device_info_multiple($data['provider_id'],1); 
    } else {
        $device_tokens=$this->api->get_device_info_multiple($data['user_id'],2); 
    }

       if($type==2){
        $user_info=$this->api->get_user_info($data['user_id'],$type);

        $name=$this->api->get_user_info($data['provider_id'],1);

      }else{
        $name=$this->api->get_user_info($data['user_id'],2);

        $user_info=$this->api->get_user_info($data['provider_id'],$type);
      }

      

      /*insert notification*/

      $msg=ucfirst($name['name']).' '.strtolower($msg);

      if(!empty($user_info['token'])){
        $this->api->insert_notification($token,$user_info['token'],$msg);
      }

      $title=$data['service_title'];


      if (!empty($device_tokens)) {
        foreach ($device_tokens as $key => $device) {
          if(!empty($device['device_type']) && !empty($device['device_id'])){

            if(strtolower($device['device_type'])=='android'){

              $notify_structure=array(
                'title' => $title,
                'message' => $msg,
                'image' => 'test22',
                'action' => 'test222',
                'action_destination' => 'test222',
              );

              sendFCMMessage($notify_structure,$device['device_id']);  

            }

            if(strtolower($device['device_type']=='ios')){
              $notify_structure= array(
                'alert' => $msg,
                'sound' => 'default',
                'badge' => 0,
              );


              sendApnsMessage($notify_structure,$device['device_id']);  

            }
          }
        }

      }
      /*apns push notification*/
    }
}
