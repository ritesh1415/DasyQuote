<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->load->model('service_model','service');
  $this->load->model('common_model','common_model');
  $this->data['theme'] = 'admin';
  $this->data['model'] = 'service';
  $this->load->model('admin_model','admin');
  $this->load->model('user_login_model','user_login');
  $this->load->model('templates_model');
  $this->data['base_url'] = base_url();
  $this->session->keep_flashdata('error_message');
  $this->session->keep_flashdata('success_message');
  $this->load->helper('user_timezone_helper');
  $this->data['user_role']=$this->session->userdata('role');
}

public function index()
{
  redirect(base_url('subscriptions'));
}

public function subscriptions()
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'subscriptions';
    $this->data['model'] = 'service';
    $this->data['currency_code'] = settings('currency');
    $this->data['list'] = $this->service->subscription_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
    redirect(base_url()."admin");
  }
}

public function delete_subsciption() 
{
  $inp = $this->input->post();
  $this->db->where('id', $inp['id']);
  $this->db->update('subscription_fee', ['status'=>0]);
  echo json_encode("success");
}

public function add_subscription()
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'add_subscription';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
    redirect(base_url()."admin");
  }
}

public function check_subscription_name()
{
  $subscription_name = $this->input->post('subscription_name');
  $id = $this->input->post('subscription_id');
  if(!empty($id))
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->where('id !=', $id);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  else
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  if ($result > 0) {
    $isAvailable = FALSE;
  } else {
    $isAvailable = TRUE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
}

public function save_subscription()
{
$this->common_model->checkAdminUserPermission(9);
	removeTag($this->input->post());
  $data['subscription_name'] = $this->input->post('subscription_name');
  $data['fee'] = $this->input->post('subscription_amount');
  $data['currency_code'] = settings('currency');
  $data['duration'] = $this->input->post('subscription_duration');
  $data['fee_description'] = $this->input->post('fee_description');
  $data['status'] = 1;
  
  $result = $this->db->insert('subscription_fee', $data);
  if(!empty($result))
  {
   $this->session->set_flashdata('success_message','Subscription added successfully');
   echo 1;
 }
 else
 {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
  echo 2;
}
}

public function edit_subscription($id)
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'edit_subscription';
    $this->data['model'] = 'service';
    $this->data['subscription'] = $this->service->subscription_details($id);
    $this->data['currency_code'] = settings('currency');
    //Currency Convertion 
    $currency_code_old = $this->data['subscription']['currency_code'];
    $subscription_amount = get_gigs_currency($this->data['subscription']['fee'], $this->data['subscription']['currency_code'], $this->data['currency_code']);
    $this->data['subscription_amt'] = $subscription_amount;

    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
   redirect(base_url()."admin");
 }

}

public function update_subscription()
{ 
$this->common_model->checkAdminUserPermission(9);
removeTag($this->input->post());
  $where['id'] = $this->input->post('subscription_id');
  $data['subscription_name'] = $this->input->post('subscription_name');
  $data['fee'] = $this->input->post('subscription_amount');
  $data['currency_code'] = settings('currency');
  $data['duration'] = $this->input->post('subscription_duration');
  $data['fee_description'] = $this->input->post('fee_description');
  $data['status'] = $this->input->post('status');
  $result = $this->db->update('subscription_fee', $data, $where);
  if(!empty($result))
  {
   $this->session->set_flashdata('success_message','Subscription updated successfully');
   echo 1;
 }
 else
 {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
  echo 2;
}
}

  public function service_providers()
  {
    $this->common_model->checkAdminUserPermission(12);
    $this->data['page'] = 'service_providers';
    $this->data['subcategory']=$this->service->get_subcategory();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function provider_details($value='')
  {
    $this->common_model->checkAdminUserPermission(12);
    $this->data['page'] = 'provider_details';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function provider_list()
  {
	$user_role=$this->session->userdata('role');
    $this->common_model->checkAdminUserPermission(12);
    extract($_POST);
    if($this->input->post('form_submit'))
    {
      $this->data['page'] = 'service_providers';
      $username = $this->input->post('username');
      $email = $this->input->post('email'); 
      $from = $this->input->post('from');
      $to = $this->input->post('to');
      $subcategory=$this->input->post('subcategory');
      $this->data['lists'] = $this->service->provider_filter($username,$email,$from,$to,$subcategory);
      $this->data['subcategory']=$this->service->get_subcategory();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
    else
    {
      $lists = $this->service->provider_list();

      $data = array();
      $no = $_POST['start'];
      foreach ($lists as $template) {
        $no++;
        $row    = array();
        $row[]  = $no;
        $profile_img = $template->profile_img;
        if(empty($profile_img)){
          $profile_img = 'assets/img/user.jpg';
        }
        if(!empty($template->country_code)) {
            $mobileNumber = '(+'.$template->country_code.')-'.$template->mobileno;
        } else {
            $mobileNumber = $template->mobileno;
        }
        
        $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a><a href="'.base_url().'provider-details/'.$template->id.'">'.$template->name.'</a></h2>';
        $row[]  = $mobileNumber;
        $row[]  = $template->email;
        $created_at='-';
        if (isset($template->created_at)) {
          if (!empty($template->created_at) && $template->created_at != "0000-00-00 00:00:00") {
            $date_time = $template->created_at;
            $date_time = utc_date_conversion($date_time);
            $created_at = date(settingValue('date_format'), strtotime($date_time));
          }
        }
        $row[]  = $created_at;
        $row[]  = $template->subscription_name;
        $val = '';

        if($this->session->userdata('admin_id') == 1) { 
            $display_status = '';
        } else {
            $display_status = 'disabled';
        }
        $status = $template->status;
        $delete_status = $template->status;
        if($status == 2) {
          $val = '';
        }
        elseif($status == 1) {
          $val = 'checked';
        }
        $row[] ='<div class="status-toggle mb-2"><input id="status_'.$template->id.'" class="check change_Status_provider1" data-id="'.$template->id.'" type="checkbox" '.$val.' '.$display_status.'><label for="status_'.$template->id.'" class="checktoggle">checkbox</label></div>';
                
        $base_url=base_url()."providers/edit/".$template->id;

        $row[] ="<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'>
        <i class='far fa-edit mr-1'></i> Edit </a>";
        if($user_role == 1) {
        $row[] = "<a href='javascript:;'' class='on-default remove-row btn btn-sm bg-danger-light mr-2 delete_provider_data' id='Onremove_'".$template->id."' data-id='".$template->id."'><i class='far fa-trash-alt mr-1'></i> Delete</a>";
        }
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->service->provider_list_all(),
        "recordsFiltered" => $this->service->provider_list_filtered(),
        "data" => $data,
      );
      echo json_encode($output);
    }
  }

public function service_list()
{
  $this->common_model->checkAdminUserPermission(4);
  extract($_POST);
 
  $this->data['page'] = 'service_list';
  $this->data['approval_status'] = $this->db->get_where('system_settings', array('key'=>'auto_approval'))->row();
  if ($this->input->post('form_submit')) {  
    $service_title = $this->input->post('service_title');
    $category = $this->input->post('category');
    $subcategory = $this->input->post('subcategory');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $this->data['list'] =$this->service->service_filter($service_title,$category,$subcategory,$from,$to);
  }
  else {
    $this->data['list'] = $this->service->service_list();
  }
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function service_details($value='')
{
	$this->common_model->checkAdminUserPermission(4);
  $this->data['page'] = 'service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

/*change service list */
public function change_Status_service_list1(){
  $id=$this->input->post('id');
  $status=$this->input->post('status');

  if($status==0){
    $avail=$this->service->check_booking_list($id);
    if($avail==0){
      $this->db->where('id',$id);
      if($this->db->update('services',array('status' =>$status, 'admin_verification' =>1))){
        echo "success";
      }else{
        echo "error";
      }
    }else{
      echo "1";
    }
  }else{
    $this->db->where('id',$id);
    if($this->db->update('services',array('status' =>$status, 'admin_verification' =>0))){
      echo "success";
    }else{
      echo "error";
    }
  }
}

/*change service list */
public function change_Status_service_list(){

  $id=$this->input->post('id');
  $status=$this->input->post('status');
  $avail=$this->db->get_where('services', array('id'=>$id))->row();
    if($avail->admin_verification==0){
      $this->db->where('id',$id);
      if($this->db->update('services',array('status' =>1, 'admin_verification' =>1))){
        echo "success";
      }else{
        echo "error";
      }
  }else{
    $this->db->where('id',$id);
    if($this->db->update('services',array('status' =>2, 'admin_verification' =>0))){
      echo "success";
    }else{
      echo "error";
    }
  }

  $status_mail=$this->db->select('*')->
                      from('providers')->
                      where('id',$avail->user_id)->
                      get()->row_array();

  $bodyid = 6;
  $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
  $body = $tempbody_details['template_content'];
  $body = str_replace('{user_name}', $status_mail['name'], $body);
  $preview_link = base_url();
  $body = str_replace('{service_name}',$avail->service_title, $body);
      
  $phpmail_config=settingValue('mail_config');
  if(isset($phpmail_config)&&!empty($phpmail_config)){
    if($phpmail_config=="phpmail"){
      $from_email=settingValue('email_address');
    }else{
      $from_email=settingValue('smtp_email_address');
    }
  }
  $this->load->library('email');

  if(!empty($from_email)){
    $mail = $this->email
    ->from($from_email)
    ->to($status_mail['email'])
    ->subject('Admin Approval')
    ->message($body)
    ->send();
  }



}
public function change_Status()
{
  $id=$this->input->post('id');
  $status=$this->input->post('status');

  $this->db->where('id',$id);
  $this->db->update('providers',array('status' =>$status));
}
public function delete_provider()
{
  $id=$this->input->post('id');
  $data=array('delete_status'=>1);
  $this->db->where('id',$id);
  
  if($this->db->update('providers',$data))
  {
    echo 1;
  }
}
public function service_requests()
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'service_requests';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');		
  }
  else {
   redirect(base_url()."admin");
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
    if($result) {
      $this->session->set_flashdata('success_message','Service deleted successfully');    
      redirect(base_url()."service-list");   
    }
    else {
      $this->session->set_flashdata('error_message','Something wrong, Please try again');
      redirect(base_url()."service-list");  
    } 
  }

  //Added New
  public function edit_providers($id=NULL)
  {
    $this->common_model->checkAdminUserPermission(12);
    $this->data['countrycode']= $this->admin->get_country_code_config();
    $this->data['category']=$this->service->get_category();
    $this->data['subcategory']=$this->service->get_subcategory();
    if(!empty($id)){
      $this->data['user']=$this->service->edit_provider_data($id);
      $this->data['title']="Edit Professional";
    }else{
      $this->data['user']=array();
      $this->data['title']="Add Professional";
    }
    $this->data['page']="edit_provider";
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');  
  }

  public function fetch_subcategorys() {    
    $this->db->where('status', 1);
    $this->db->where('category', $_POST['id']);
    $query = $this->db->get('subcategories');
    $result = $query->result();
    $data = array();
    if (!empty($result)) {
        foreach ($result as $r) {
            $data['value'] = $r->id;
            $data['label'] = $r->subcategory_name;
            $json[] = $data;
        }
    } 
    echo json_encode($json);
  }

  public function check_provider_name()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function check_provider_mobile()
  {
    $mobileno = $this->input->post('mobileno');
    $country_code = $this->input->post('country_code');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('country_code', $country_code);
      $this->db->where('mobileno', $mobileno);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('country_code', $country_code);
      $this->db->where('mobileno', $mobileno);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function check_provider_email()
  {
    $email = $this->input->post('email');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function update_provider()
  {
    $this->common_model->checkAdminUserPermission(12);
    $params=$this->input->post();
    $user_id='';
    $uploaded_file_name = '';

    $profile_image = $this->input->post('profile_img');
    if (!empty($profile_image)) { 
      $params['profile_img'] = $profile_image;
    }else{
      unset($params['profile_img']);
    }
    
    if(!empty($params['id'])){
      $user_id=$params['id'];
      $params['updated_at'] = date('Y-m-d H:i:s'); 
      $result=$this->db->where('id',$user_id)->update('providers',$params);
    }else{
      $params['currency_code'] = 'INR';  
      $params['otp'] = '1234';  
      $params['share_code'] = $this->service->ShareCode(6,$params['name']);
      $params['created_at'] = date('Y-m-d H:i:s');
      $params['is_agree'] = 1;
      
      $result=$this->db->insert('providers',$params);
      $user_id = $this->db->insert_id();
      $token = $this->service->getToken(14,$user_id);
      $this->db->where('id', $user_id);
      $this->db->update('providers', array('token'=>$token));
       if(settingValue('chat_showhide') == 1 && settingValue('chat_text')) {
        $chat_text = settingValue('chat_text');
      } else {
        $chat_text = 'Hi! Welcome to '.settingValue('website_name');
      }
      //insert chat
      $chat_arr = ['sender_token'=>'0dreamsadmin', 'receiver_token'=>$token, 'message'=>$chat_text, 'status'=>'1', 'read_status'=>'0', 'utc_date_time'=>date('Y-m-d H:i:s')];
      $this->db->insert('chat_table', $chat_arr);
      //insert wallet
      $data = array("token" => $token, 'currency_code' => 'INR', "user_provider_id" => $user_id, "type" => 1, "wallet_amt" => 0, "created_at" => date('Y-m-d H:i:s'));
      $wallet_result = $this->db->insert('wallet_table', $data);
    }
    
    if($result==true){
      if(empty($user_id)){
        echo json_encode(['status'=>true,'msg'=>"Provider Details Added SuccesFullly..."]);
      }else{
        echo json_encode(['status'=>true,'msg'=>"Provider Details Updated SuccesFullly..."]);
      }
    }else{
      echo json_encode(['status'=>false,'msg'=>"Someting Went wrong in server end..."]);
    }
  }

  public function delete_provider_data()
  {
    $adminId = $this->session->userdata('admin_id');
    if ($adminId > 1) {
      echo json_encode(['status'=>false,'msg'=>"Permission Denied.!!"]);
    }else{
      $id = $this->input->post('user_id');
      if (!empty($id)) {
        $data=array('delete_status'=>1);
        $this->db->where('id',$id);
        if($this->db->update('providers',$data)) {
          echo json_encode(['status'=>true,'msg'=>"Providers Details Deleted SuccesFullly."]);
        }else {
          echo json_encode(['status'=>false,'msg'=>"Someting went wrong on server end.."]);
        }
      }else {
        echo json_encode(['status'=>false,'msg'=>"Someting went wrong, Please try again !!"]);
      }
    }
  }

public function changeAutoApprovalStatus() {
    $status=$this->input->post('status');
    //Get not approved service id's
    $serviceId = $this->db->select('GROUP_CONCAT(id) as id')->get_where('services', array('status'=>2))->row();

    $autoApproval = $this->db->where('key', 'auto_approval')->get('system_settings')->row();
        $data = array(
            'key'=>'auto_approval', 
            'value'=>$status, 
            'system'=>'1', 
            'groups'=>'config', 
            'status'=>1, 
            'update_date'=>date('Y-m-d')
        );
    if(!$autoApproval) {
        $this->db->insert('system_settings', $data);
    } else {
        $this->db->where('key','auto_approval');
        $this->db->update('system_settings',array('value' =>$status));
    }
    if($this->db->affected_rows() > 0) {
        echo 1;       
    } else {
        echo 0;
    }
    
}


}//Class end.