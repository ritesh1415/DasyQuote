<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

  public $data;

  public function __construct() 
  {
    parent::__construct();
    $this->load->model('service_model','service');
    $this->load->model('Api_model','api');
    $this->load->model('wallet_model','wallet');
    $this->load->model('Booking_report_model','book');
		$this->load->model('common_model','common_model');
		$this->load->model('templates_model');
		$this->site_name ='DasyQuote';

    $this->data['theme'] = 'admin';
    $this->data['model'] = 'bookings';
    $this->data['base_url'] = base_url();
    $this->session->keep_flashdata('error_message');
    $this->session->keep_flashdata('success_message');
    $this->load->helper('user_timezone_helper');
    $this->data['user_role']=$this->session->userdata('role');
  }

	public function index()
	{

    if(!empty($this->input->post())){
      
    }else{
      $this->data['page'] = 'wallet_report_view';
      $this->data['model'] = 'wallet';
      $this->data['list'] = $this->wallet->get_wallet_info();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }

		
	}

  public function total_bookings() 
  {
    $this->data['currency_code'] = settings('currency');
    $this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'total_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_total_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                ); 
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();

      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'total_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_total_bookings();
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
  }

  /*pending report*/
  public function pending_bookings() 
  {
		$this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'pending_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_pending_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                );
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'pending_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_pending_bookings();
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
  }
	
/*Inprogress*/
  public function inprogress_bookings() 
  {
    $this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'inprogress_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_inprogress_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                );
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'inprogress_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->data['list'] = $this->book->get_inprogress_bookings();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
  }

  /*Completed*/
  public function completed_bookings() 
  {
		$this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'complete_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_complete_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                );
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'complete_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->data['list'] = $this->book->get_complete_bookings();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
  }

  /*Rejected*/
  public function rejected_bookings() 
  { 
    $this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'reject_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_reject_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                );
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'reject_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->data['list'] = $this->book->get_reject_bookings();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
  }

  /*Cancelled booking*/
  public function cancel_bookings() 
  {
	  $this->common_model->checkAdminUserPermission(5);
    if(!empty($this->input->post())){
      extract($_POST);
         
      $service_id =$service_title;
      $status     =$service_status;
      $user_id    =$user_id;
      $provider_id=$provider_id;
      $from       =$from;
      $to         =$to;

      $this->data['page'] = 'cancel_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_filter_cancel_bookings($service_id,$status,$user_id,$provider_id,$from,$to);

      $this->data['filter']=array(
                                  'service_t'=>$service_title,
                                  'service_s'=>$service_status,
                                  'user_i'=>$user_id,
                                  'provider_i'=>$provider_id,
                                  'service_from'=>$from,
                                  'service_to'=>$to,
                                );
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'cancel_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_cancel_bookings();
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,3,4,5,6,7,8)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status in (2,3)')->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->or_where('status',8)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();
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


    if($result)
   {
           $this->session->set_flashdata('success_message','Service deleted successfully');    
           redirect(base_url()."service-list");   
    }
    else
    {
        $this->session->set_flashdata('error_message','Something wrong, Please try again');
        redirect(base_url()."service-list");   

     } 
  }



/* rejected payments */

public function reject_booking_payment(){
	$this->common_model->checkAdminUserPermission(5);
      $id=$this->uri->segment('2');

      if(!empty($this->uri->segment('2'))){
      $this->data['page'] = 'edit_reject_booking_view';
      $this->data['model'] = 'bookings';
      $this->data['list'] = $this->book->get_reject_bookings_by_id($this->uri->segment('2'));
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template'); 
      }else{
        redirect(base_url('admin/reject-report'));
      }


    
}

/* rejected function */

public function update_reject_payment(){
	$this->common_model->checkAdminUserPermission(5);
  if(!empty($_POST['booking_id']))
      
    $pay= $this->book->get_reject_bookings_by_id($_POST['booking_id']);

  if(!empty($pay['id'])){
            $paid_token='';
			$tomailid = '';
            if($_POST['token']==$pay['user_token']){
            $paid_token=$pay['user_token'];
			$this->data['uname'] = $pay['user_name'];
			$tomailid = $pay['user_email'];
            }
            if($_POST['token']==$pay['provider_token']){
            $paid_token=$pay['provider_token'];
			$this->data['uname'] = $pay['provider_name'];
			$tomailid = $pay['provider_email'];
            }

            $data['book_id']=$pay['id'];
            $data['service_title']=$_POST['service_name'];
            $data['amount']=$pay['amount'];
            $data['token']=$paid_token;
            $data['favour_comment']=$_POST['favour_comment'];

            $ret=$this->book->reject_pay_proccess($data);
            if($ret){
               $this->session->set_flashdata('success_message','Reject Payment added successfully');
			   
			   $phpmail_config=settingValue('mail_config');
              if(isset($phpmail_config)&&!empty($phpmail_config)){
                if($phpmail_config=="phpmail"){
                  $from_email=settingValue('email_address');
                }else{
                  $from_email=settingValue('smtp_email_address');
                }
              }
			  $this->data['service_amount']= $pay['amount'];
			  $this->data['service_date']= $pay['service_date'];
			  $this->data['service_title']= $data['service_title'];
              $this->data['comments'] = $data['favour_comment'];
			  $bodyid = 5;
			  $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
			  $body = $tempbody_details['template_content'];
			  $body = str_replace('{user_name}', $this->data['uname'], $body);
			  $body = str_replace('{service_amount}', $pay['amount'], $body);
			  $body = str_replace('{service_title}', $pay['service_title'], $body);
			  $body = str_replace('{service_date}', $pay['service_date'], $body);
			  $body = str_replace('{admin_comments}', $data['favour_comment'], $body);
			  $body = str_replace('{sitetitle}',$this->site_name, $body);
			  $preview_link = base_url();
			  $body = str_replace('{preview_link}',$preview_link, $body);
			  
              $this->load->library('email');
              //Send mail to provider
              if(!empty($from_email)&&isset($from_email)){
	        	$mail = $this->email
	            	->from($from_email)
	            	->to($tomailid)
	            	->subject('Service Booking Refund')
                    ->message($body)
	            	->send();
	         }
			  
      redirect(base_url('admin/reject-report'));

            }else{
               $this->session->set_flashdata('error_message','Something wrong, Please try again');
      redirect(base_url('admin/reject-report'));

            }
          


  }else{
               $this->session->set_flashdata('error_message','Something wrong, Please try again');
      redirect(base_url('admin/reject-report'));


  
  }
}


  //Booking status changed by Admin
  public function change_status_byAdmin()
  {
    $this->common_model->checkAdminUserPermission(5);
    $params=$this->input->post();

    if(!empty($params['status']) && !empty($params['id']) ) {
      $status = $params['status'];
      $row_id = $params['id'];
      $user_id=$params['user_id'];
      $provider_id=$params['provider_id'];
      $service_id=$params['service_id'];
      $updated_on = date('Y-m-d H:i:s'); 

      $update_data['reason'] = "";
      if (!empty($params['review'])) {
          $update_data['reason'] = $params['review'];
      }

      $update_data['status'] = $status;
      $update_data['updated_on'] = $updated_on;
	   $update_data['admin_update_status'] = 1;

      $WHERE = array('id'=>$row_id, 'user_id'=>$user_id, 'provider_id'=>$provider_id, 'service_id'=>$service_id);
      $result=$this->service->update_bookingstatus($update_data,$WHERE);
      $service_data = $this->db->where('id',$service_id)->from('services')->get()->row_array();

      $user_data = $this->db->where('id',$user_id)->from('users')->get()->row_array();
      
      $provider_data = $this->db->where('id',$provider_id)->from('providers')->get()->row_array();

      if($result) { 
        $message= 'Booking updated successfully';
        $token=$this->session->userdata('chat_token');

        if($status==1){
          $this->send_push_notification($token,$row_id,2,'  <b>Pending</b> For The Service - '.$service_data['service_title']);
          $success_message = "Admin changed status as <b> Pending</b> For The Service ( ".$service_data['service_title']." ).";
        }

        if($status==2){
          $this->send_push_notification($token,$row_id,2,'  <b>Inprogress</b> For The Service - '.$service_data['service_title']);
          $success_message = "Admin changed status as <b> Accepted/Inprogress</b> For The Service ( ".$service_data['service_title']." ).";
        }

        if($status==3){
          $this->send_push_notification($token,$row_id,2,'  <b>Completed Request</b> For The Service - '.$service_data['service_title']);
          $success_message = "Admin changed status as <b>Completed Service Request</b> For The Service ( ".$service_data['service_title']." )";
        }

        if($status==4){
          $this->send_push_notification($token,$row_id,2,'  <b>Accepted User Request</b> For The Service - '.$service_data['service_title']);
          $success_message = "Admin changed status as <b>Accepted The Service By User </b> For The Service- ( ".$service_data['service_title']." )";
        }

        if($status==5){
          $this->send_push_notification($token,$row_id,2,'  <b>Rejected</b> For The Service - '.$service_data['service_title']);
          $success_message = "Sorry to Say! Admin changed status as <b>Rejected</b> For The Service - ( ".$service_data['service_title']." )<br>Reason : ".$update_data['reason'].". "; 
        }

        if($status==6){
          $token=$this->session->userdata('chat_token');
		  
		  $old_booking_status = $this->db->where('id', $row_id)->get('book_service')->row();
		  if($old_booking_status->cod == 2) {
			$this->api->user_accept_history_flow($row_id);
		  }

          //COD changes
          $coddata['status'] = 1;
          $this->db->where('book_id', $row_id);
          $this->db->update('book_service_cod', $coddata);

          $this->send_push_notification($token,$row_id,1,' <b>Accepted Completed</b> For The Service - '.$service_data['service_title']);
          $success_message = "Admin changed status as <b>Accepted Your Completed Request</b> For This Service  - ( ".$service_data['service_title']." ). Please check your wallet the amount was credited !";
        }

        if($status==7){
          $this->send_push_notification($token,$row_id,2,'  <b>Cancelled</b> For The Service - '.$service_data['service_title']);
          $success_message = "Sorry to Say! Admin changed status as <b>Cancelled</b> For The Service - ( ".$service_data['service_title']." )<br>Reason : ".$update_data['reason'].". ";
        }

        //Sending mail after changing booking status
        $bodyid = 4;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body = $tempbody_details['template_content'];
        $body = str_replace('{success_message}',$success_message, $body);
        $body = str_replace('{sitetitle}',$this->site_name, $body);
        $preview_link = base_url();
        $body = str_replace('{preview_link}',$preview_link, $body);

        $phpmail_config=settingValue('mail_config');
        if(isset($phpmail_config)&&!empty($phpmail_config)){
          if($phpmail_config=="phpmail"){
            $from_email=settingValue('email_address');
          }else{
            $from_email=settingValue('smtp_email_address');
          }
        }
        $this->load->library('email');
        $this->load->library('sms');

        //To User
        $this->data['uname']=$user_data['name'];
        $this->data['success_message']=$success_message;

        $body = str_replace('{user_name}', $user_data['name'], $body);
                       
        if(!empty($from_email)){
          $mail = $this->email
          ->from($from_email)
          ->to($user_data['email'])
          ->subject('Booking Status')
          ->message($body)
          ->send();
        }
        
        if(settingValue('sms_option') == 'Nexmo') {
          $sms_config=settingValue('nexmo_sms_key');
          $sms_secret_key=settingValue('nexmo_sms_secret_key');
          $sms_sender_id=settingValue('nexmo_sms_sender_id');            
          if(!empty($sms_config) && !empty($sms_secret_key) && !empty($sms_sender_id)){
            $smsmessage = "Hi ".$user_data['name'].",".$success_message;
            require_once('vendor/nexmo/src/NexmoMessage.php');
            $nexmo_sms = new NexmoMessage($sms_config,$sms_secret_key);
            $nexmo_sms->sendText($user_data['country_code'].$user_data['mobileno'],$sms_sender_id,$smsmessage);
          }
        } elseif(settingValue('sms_option') == '2Factor') {
            $phone = '+' . $user_data['country_code'].$user_data['mobileno']; // target number; includes ISD
            $api_key = settingValue('factor_sms_key'); // API Key
            $smsmessage = "Hi ".$user_data['name'].",".$success_message;
            $req = "https://2factor.in/API/V1/" . $api_key . "/SMS/" . $phone . "/" . $smsmessage;
            $sms = file_get_contents($req);
            $sms_status = json_decode($sms, true);
            if ($sms_status['Status'] !== 'Success') {
                $err = 'Could not send OTP to ' . $phone;
                echo json_encode(array('response' => 'error', 'result' => 'mobile', 'msg' => $err));
            }
        } elseif(settingValue('sms_option') == 'Twilio') {
            $this->sms->send_message($user_data['country_code'].$user_data['mobileno'],$message);
        }
        

        //To Provider   
        $this->data['uname']=$provider_data['name'];
        $this->data['success_message']=$success_message;     

        $body = str_replace('{user_name}', $user_data['name'], $body);
        
        if(!empty($from_email)){
          $mail = $this->email
          ->from($from_email)
          ->to($provider_data['email'])
          ->subject('Booking Status')
          ->message($body)
          ->send();
        }
        
        if(settingValue('sms_option') == 'Nexmo') {
            $sms_config=settingValue('nexmo_sms_key');
            $sms_secret_key=settingValue('nexmo_sms_secret_key');
            $sms_sender_id=settingValue('nexmo_sms_sender_id');            
            if(!empty($sms_config) && !empty($sms_secret_key) && !empty($sms_sender_id)){
              $smsmessage = "Hi ".$provider_data['name'].",".$success_message;
              require_once('vendor/nexmo/src/NexmoMessage.php');
              $nexmo_sms = new NexmoMessage($sms_config,$sms_secret_key);
              $nexmo_sms->sendText($user_data['country_code'].$user_data['mobileno'],$sms_sender_id,$smsmessage);
            }
            echo "1";
        } elseif(settingValue('sms_option') == '2Factor') {
            $phone = '+' . $user_data['country_code'].$user_data['mobileno']; // target number; includes ISD
            $api_key = settingValue('factor_sms_key'); // API Key
            $smsmessage = "Hi ".$provider_data['name'].",".$success_message;
            $req = "https://2factor.in/API/V1/" . $api_key . "/SMS/" . $phone . "/" . $smsmessage;
            $sms = file_get_contents($req);
            $sms_status = json_decode($sms, true);
            if ($sms_status['Status'] !== 'Success') {
                $err = 'Could not send OTP to ' . $phone;
                echo json_encode(array('response' => 'error', 'result' => 'mobile', 'msg' => $err));
            }
            echo "1";
        } elseif(settingValue('sms_option') == 'Twilio') {
            $this->sms->send_message($user_data['country_code'].$user_data['mobileno'],$message);
            
        }
         echo "1";
      } 
      else {
        $message = 'Something went wrong.Please try again later.';
        echo "2";
      }      
    } else {
      echo "3";
      return false;
    }
  }


  /* push notification */
  public function send_push_notification($token, $service_id, $type, $msg = '') 
  {
    $data = $this->api->get_book_info($service_id);
    if (!empty($data)) {
      //get userInfo        
      $user_info = $this->api->get_user_info($data['user_id'], 2);
      $provider_info = $this->api->get_user_info($data['provider_id'], 1);

      /* insert notification */
	  $msg = 'Admin changed status as ' . strtolower($msg);

      if(!empty($user_info['token'])) {
        $this->api->insert_notification($token, $user_info['token'], $msg);
      }
      if(!empty($provider_info['token'])) {
        $this->api->insert_notification($token, $provider_info['token'], $msg);
      }

    } else {
        $this->token_error();
    }
  }

//    quote inprogress



  
} //Class end.

?>
