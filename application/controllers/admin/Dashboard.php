<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Dashboard extends CI_Controller {

  public $data;

  public function __construct() 
  {
    parent::__construct();
    $this->data['theme'] = 'admin';
    $this->data['model'] = 'dashboard';
    $this->load->model('admin_model','admin');
    $this->load->model('dashboard_model','dashboard');
    $this->load->model('user_login_model','user');
	$this->load->model('common_model','common_model');
	$this->load->model('admin_model','admin');
	$this->load->model('api_model','api');

    $this->data['base_url'] = base_url();
    $this->load->helper('user_timezone');
		$this->data['user_role']=$this->session->userdata('role');
  }

	public function index()
	{
    $this->data['page'] = 'index';
    $this->data['currency_code'] = settings('currency');
    $this->data['payment']= $this->dashboard->get_payment_info();
    $this->data['currency_code'] = (settings('currency'))?settings('currency'):'USD';
	  $this->data['active']=$this->db->from('users')->where('status',1)->count_all_results();
    $this->data['in_active']=$this->db->from('users')->where('status',2)->count_all_results();
    $this->data['p_active']=$this->db->from('providers')->where('status',1)->count_all_results();
    $this->data['p_in_active']=$this->db->from('providers')->where('status',2)->count_all_results();
    //Currency Convertion 
    $currency_code_old = ($this->data['payment'][0]['currency_code'])?$this->data['payment'][0]['currency_code']:'USD';
    $subscription_amount = get_gigs_currency($this->data['payment'][0]['paid_amt'], $currency_code_old, $this->data['currency_code']);
    $this->data['payment_amount'] = $subscription_amount;
    $this->load->vars($this->data);
		$this->load->view($this->data['theme'].'/template');
	}

  public function admin_notification($value='')
  {
    $this->data['page'] = 'admin_notification';
    $this->data['admin_notification'] = $this->db->where('n.receiver',$this->session->userdata('chat_token'))->where('n.status',1)->from('notification_table as n')->join('providers as p ','p.token=n.sender')->select('n.notification_id,n.message,n.created_at,p.name,p.profile_img,n.utc_date_time')->order_by('notification_id', 'DESC')->get()->result_array();
    $this->data['booking_list'] = $this->db->order_by('id', 'DESC')->get('book_service')->result();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }


  public function map_list()
  {
      $this->data['page'] = 'map_list';
      $this->data['map']= $this->dashboard->get_payments_info();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }

  public function service_map_list(){

  $this->db->select('tab_2.name,tab_1.service_latitude,tab_1.service_longitude,tab_1.service_title')->from('services tab_1');
  $val=$this->db->join('providers tab_2','tab_2.id=tab_1.user_id','LEFT')->get()->result_array();

  if(!empty($val)){

    $result_json = [];

    foreach ($val as $key => $value) {
      $temp = $temp2 = [];
      $temp2[] = $value["service_latitude"];
      $temp2[] = $value["service_longitude"];

      $temp['latLng'] = $temp2;
      $temp['name'] = $value['name'];

      $result_json[] = $temp;
    
    }

  }

  $data=json_encode($result_json);
  print($data);
  }

  public function users($value='')
  {
	  $this->common_model->checkAdminUserPermission(13);
    $this->data['page'] = 'users';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function user_details($value='')
  {
	  $this->common_model->checkAdminUserPermission(13);
    $this->data['page'] = 'user_details';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }


  public function users_list($value='') {
	$user_role=$this->session->userdata('role');
	$this->common_model->checkAdminUserPermission(13);
    extract($_POST);
    
    if($this->input->post('form_submit'))
    {
      $this->data['page'] = 'users';
      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $from = $this->input->post('from');
      $to = $this->input->post('to');
      $this->data['lists'] = $this->dashboard->user_filter($username,$email,$from,$to);
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }
    else
    {
      $lists = $this->dashboard->users_list();
    
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
        }

        $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a>
        <a href="'.base_url().'user-details/'.$template->id.'">'.str_replace('-', ' ', $template->name).'</a></h2>';
           
        $row[]  = $template->email;
        $row[]  = $mobileNumber;
        $created_date='-';
        if (isset($template->last_login)) {
          if (!empty($template->last_login) && $template->last_login != "0000-00-00 00:00:00") {
            $date_time = $template->last_login;
            $date_time = ($date_time);
            $created_date = date(settingValue('date_format'), strtotime($date_time));
          }
        }
        $created_at='-';
        if (isset($template->created_at)) {
          if (!empty($template->created_at) && $template->created_at != "0000-00-00 00:00:00") {
            $date_time = $template->created_at;
            $date_time = ($date_time);
            $created_at = date(settingValue('date_format'), strtotime($date_time));
          }
        }
        $row[]  = $created_at;
        $row[]  = $created_date;

        if($this->session->userdata('admin_id') == 1) { 
            $display_status = '';
        } else {
            $display_status = 'disabled';
        }

        if($template->status==1)
        {
          $val='checked';
        }
        else
        {
          $val='';
        }

        if($template->type==1)
        {
            $row[] ='';
        }
        else
        {
          $row[] ='<div class="status-toggle"><input id="status_'.$template->id.'" class="check change_Status_user1" data-id="'.$template->id.'" type="checkbox" '.$val.' '.$display_status.'><label for="status_'.$template->id.'" class="checktoggle">checkbox</label></div>';
        } 

        $base_url=base_url()."users/edit/".$template->id;
        if($this->data['user_role'] == 1) {
            $row[] ="<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'><i class='far fa-edit mr-1'></i> Edit</a><a href='javascript:;'' class='on-default remove-row btn btn-sm bg-danger-light mr-2 delete_user_data' id='Onremove_'".$template->id."' data-id='".$template->id."'><i class='far fa-trash-alt mr-1'></i> Delete</a>";
        } else {
            $row[] ="<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'><i class='far fa-edit mr-1'></i> Edit</a><a href='javascript:;'' class='on-default remove-row btn btn-sm bg-danger-light mr-2 delete_user_data1' id='Onremove_'".$template->id."' data-id='".$template->id."'><i class='far fa-trash-alt mr-1'></i> Delete</a>";
        }        

        $data[] = $row; 
      }

      $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->dashboard->users_list_all(),
                  "recordsFiltered" => $this->dashboard->users_list_filtered(),
                  "data" => $data,
                );
      echo json_encode($output);
    }  
  }

   public function change_rating()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('rating_type',array('status' =>$status));
  }
  
   public function change_subcategory()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('subcategories',array('status' =>$status));
  }

   public function change_category()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('categories',array('status' =>$status));
  }

     public function change_Status()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('users',array('status' =>$status));
  }
  
  /*change delete_users */
  public function delete_users()
  {
    $id=$this->input->post('user_id');
    $status=$this->input->post('status');
    $table_data['status'] = $status;
    $this->db->where('id',$id);
    if($this->db->update('users',$table_data)){
      echo "success";
    }else{
      echo "error";
    }
  }
 
  /*change delete_provider */
  public function delete_provider()
  {
    $id=$this->input->post('provider_id');
    $status=$this->input->post('status');
    $table_data['status'] = $status;
    $this->db->where('id',$id);
    if($this->db->update('providers',$table_data)){
      echo "success";
    }else{
      echo "error";
    }
  }

//paramesh code

public function adminusers($value='')
{
  $this->common_model->checkAdminUserPermission(1);
  $this->data['page'] = 'adminusers';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function adminuser_details($value='')
{
  $this->common_model->checkAdminUserPermission(1);
  $this->data['page'] = 'adminuser_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function adminusers_list($value='') {
	$user_role=$this->session->userdata('role');
	$this->common_model->checkAdminUserPermission(1);
  extract($_POST);

  if($this->input->post('form_submit'))
  {
    $this->session->set_userdata('user_filter', $this->input->post());
    $this->data['page'] = 'adminusers';
    $username = $this->input->post('username');
    $this->data['lists'] = $this->dashboard->adminuser_filter($username);
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');

  }
  else
  {
    $this->session->unset_userdata('user_filter');
    $lists = $this->dashboard->adminusers_list();

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
      $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a>
      <a href="'.base_url().'adminuser-details/'.$template->user_id.'">'.str_replace('-', ' ', $template->full_name).'</a></h2>';

      $row[]  = $template->username;
      $row[]  = $template->email;
	  $base_url=base_url()."adminusers/edit/".$template->user_id;
		if($template->user_id !=1)
		{
	  $row[] ="<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'>
	  <i class='far fa-edit mr-1'></i> Edit
	  </a>";
        if($user_role==1){
	       $row[] = "<a class='btn btn-sm bg-info-light delete_show' data-id='".$template->user_id."'><i class='fa fa-trash' ></i> Delete</a>";
        }
		}
		else
		{
			 $row[] ="";
			
		}
   
    $data[] = $row; 
  }

  $output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $this->dashboard->adminusers_list_all(),
    "recordsFiltered" => $this->dashboard->adminusers_list_filtered(),
    "data" => $data,
  );
  echo json_encode($output);
}
}


  public function edit_adminusers($id=NULL)
  {
    $this->common_model->checkAdminUserPermission(1);
    if(!empty($id)){
      $this->data['user']=$this->dashboard->get_adminuser_details($id);
      $this->data['title']="Edit Admin User";
    }else{
      $this->data['user']=array();
      $this->data['title']="Add Admin User";
    }

    $this->data['page']="edit_adminuser";
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function update_adminuser()
  {
  	$this->common_model->checkAdminUserPermission(1);
    $params=$this->input->post();
    $user_id='';
    $uploaded_file_name = '';

    $profile_image = $this->input->post('profile_img');
    if (!empty($profile_image)) { 
      $params['profile_img'] = $profile_image;
    }else{
      unset($params['profile_img']);
    }

    $params['role']=1;  
    $accesscheck = $params['accesscheck'];
    if(!empty($params['id'])){
      $user_id=$params['id'];
      unset($params['id']);
  	  unset($params['accesscheck']);
      unset($params['selectall1']);
      $result=$this->db->where('user_id',$user_id)->update('administrators',$params);
    }else{
      $params['password']=md5($params['password']);
      unset($params['id']);
      unset($params['accesscheck']);
      unset($params['selectall1']);
      $result=$this->db->insert('administrators',$params);
      $user_id = $this->db->insert_id();
      $token = $this->user->getToken(14,$user_id);
      $this->db->where('user_id', $user_id);
      $this->db->update('administrators', array('token'=>$token));
    }
  	
    $module_result = $this->db->where('status',1)->select('id')->get('admin_modules')->result_array();
  	foreach ($module_result as $module){
  		$adminparams['admin_id'] = $user_id;
  		$adminparams['module_id'] = $module['id'];
  		$access_result = $this->db->where('admin_id',$user_id)->where('module_id',$module['id'])->select('id')->get('admin_access')->result_array();
  		if (in_array($module['id'], $accesscheck)){			
  			$adminparams['access'] = 1;
  		}else{
  			$adminparams['access'] = 0;
  		}
  		if(!empty($access_result)){
  			$result=$this->db->where('id',$access_result[0]['id'])->update('admin_access',$adminparams);
  		}else{
  			$result=$this->db->insert('admin_access',$adminparams);
  		}		
  	}
    if($result==true){
      if(empty($user_id)){
       echo json_encode(['status'=>true,'msg'=>"Admin Userdetails Added SuccesFullly..."]);
      }else{
        echo json_encode(['status'=>true,'msg'=>"Admin Userdetails Updated SuccesFullly..."]);
      }
    }else{
      echo json_encode(['status'=>false,'msg'=>"Someting Went in Server end..."]);
    }
  }

public function check_adminuser_name()
{
  $name = $this->input->post('name');
  $id = $this->input->post('id');
  if(!empty($id))
  {
    $this->db->select('*');
    $this->db->where('username', $name);
    $this->db->where('user_id !=', $id);
    $this->db->from('administrators');
    $result = $this->db->get()->num_rows();
  }
  else
  {
    $this->db->select('*');
    $this->db->where('username', $name);
    $this->db->from('administrators');
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

public function check_adminuser_email()
{
  $email = $this->input->post('email');
  $id = $this->input->post('id');
  if(!empty($id))
  {
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->where('user_id !=', $id);
    $this->db->from('administrators');
    $result = $this->db->get()->num_rows();
  }
  else
  {
    $this->db->select('*');
    $this->db->where('email', $email);
    $this->db->from('administrators');
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

public function adminuser_delete(){
	$this->common_model->checkAdminUserPermission(1);
  $params=$this->input->post();
  if(!empty($params['id'])){
    $result=$this->db->where('user_id',$params['id'])->delete('administrators');
    if($result==true){
      echo json_encode(['status'=>true,'msg'=>"Admin User Deleted SuccessFully..."]);
    }else{
      echo json_encode(['status'=>false,'msg'=>"Something Went in server end..."]);
    }
  }
}

//Export Excel
public function adminusers_export(){
	$this->common_model->checkAdminUserPermission(1);
  $style= array(
    'borders' => array(
        'allborders' => array(
            'style' => Border::BORDER_MEDIUM,
            'color' => array('argb' => '006200'),
        ),
    ),
      'fill' => array(
          'type' => Fill::FILL_SOLID,
          'color' => array('rgb' => '006200' )
      ),
      'font'  => array(
          'bold'  =>  true
      )
   );
  $fileName = 'users.xlsx';
  $service_filter=$this->session->userdata('user_filter');

  if($service_filter['form_submit']=="submit"){

    $username = $service_filter['username'];

    $list =$this->dashboard->get_adminusers_filter($username);

  }else{
    $list =$this->dashboard->get_adminusers_list();
  }

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setCellValue('A1', 'ID');
  $sheet->setCellValue('B1', 'User Name');
  $sheet->setCellValue('C1', 'Full Name');


  $sheet->getStyle('A1:H1')->applyFromArray($style);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);

  $rows = 2;

  foreach ($list as $val){   

    $sheet->setCellValue('A' . $rows, $val['user_id']);
    $sheet->setCellValue('B' . $rows, $val['username']);
    $sheet->setCellValue('C' . $rows, $val['full_name']);
    $rows++;
  } 
  $writer = new Xlsx($spreadsheet);
  $writer->save("uploads/service_excel/".$fileName);
  header("Content-Type: application/vnd.ms-excel");
  redirect(base_url()."/uploads/service_excel/".$fileName);             
}

public function SendPushNotification()
{
	$this->common_model->checkAdminUserPermission(19);
	
	if($this->input->post())
	{
		$admin_id=$this->session->userdata('admin_id');
		
		$input =$this->input->post();
		$user_access=0;
		$provider_access=0;
		if(isset($input['accesscheck']) && !empty($input['accesscheck']))
		{
			foreach($input['accesscheck'] as $val)
			{
				if($val==1)
				{
					$user_access=1;
				}
				if($val==2)
				{
					$provider_access=1;
				}
			}
			
			if($user_access==1)
			{
				$records = $this->db->select('*')->from('users')->where('status',1)->get()->result_array(); 
				$admin_det = $this->db->select('*')->from('administrators')->where('user_id',$admin_id)->get()->result_array(); 
				
				if(isset($records) && !empty($records))
				{
					foreach($records as $rec)
					{
						if($rec['email'] !='')
						{
							$user_info = $this->api->get_user_info($rec['id'],2);
							$tomailid=$rec['email'];
							$phpmail_config=settingValue('mail_config');
							if(isset($phpmail_config)&&!empty($phpmail_config)){
							if($phpmail_config=="phpmail"){
							  $from_email=settingValue('email_address');
							}else{
							  $from_email=settingValue('smtp_email_address');
							}
						  }
						
						  $body = $input['message'];
						  
						  $this->load->library('email');
						  //Send mail to provider
						  if(!empty($from_email)&&isset($from_email)){
							$mail = $this->email
								->from($from_email)
								->to($tomailid)
								->subject($input['subject'])
								->message($body)
								->send();
								if($mail)
								{
									/* insert notification */
									$msg = ucfirst(strtolower($body));
									if (!empty($user_info['token'])) {
										$this->api->insert_notification($admin_det[0]['token'], $user_info['token'], $msg);
									}
								}
							}
						}
					}
				}
			}
			
			
			if($provider_access==1)
			{
				$providerrecords = $this->db->select('*')->from('providers')->where('status',1)->where('delete_status',0)->get()->result_array(); 
				if(isset($providerrecords) && !empty($providerrecords))
				{
					foreach($providerrecords as $prec)
					{
						if($prec['email'] !='')
						{
							$provider_info = $this->api->get_user_info($prec['id'],1);
							$ptomailid=$prec['email'];
							$phpmail_config=settingValue('mail_config');
							if(isset($phpmail_config)&&!empty($phpmail_config)){
							if($phpmail_config=="phpmail"){
							  $from_email=settingValue('email_address');
							}else{
							  $from_email=settingValue('smtp_email_address');
							}
						  }
						
						  $body = $input['message'];
						  
						  $this->load->library('email');
						  if(!empty($from_email)&&isset($from_email)){
							$mail = $this->email
								->from($from_email)
								->to($ptomailid)
								->subject($input['subject'])
								->message($body)
								->send();
								if($mail)
								{
									/* insert notification */
									$msg = ucfirst(strtolower($body));
									if (!empty($provider_info['token'])) {
										$this->api->insert_notification($admin_det[0]['token'], $provider_info['token'], $msg);
									}
								}
						 }
						}
					}
				}
			}
			
			
			
			
			$data = array(
            'subject' => $input['subject'],
            'message' => $input['message'],
            'user_status' => $user_access,
            'provider_status' => $provider_access,
            'created_on' => date('Y-m-d H:i:s')
        );

        $ret = $this->db->insert('push_notification', $data);
		}
		
		redirect(base_url()."/admin/SendPushNotificationList");  
	}

	$this->data['page'] = 'send_push_notification';
	$this->data['title']="Send Push Notification";
	$this->load->vars($this->data);
	$this->load->view($this->data['theme'].'/template');
}


  public function SendPushNotificationList() 
  {
		$this->common_model->checkAdminUserPermission(19);
    $this->data['page'] = 'push_notification_list';
    $this->data['list_filter'] = $this->admin->pn_list();
    
    if ($this->input->post('form_submit')) {
        extract($_POST);
        $this->data['list'] = $this->admin->pn_list();
    } else {
      
        $this->data['list'] = $this->admin->pn_list();
    }

    $this->load->vars($this->data);
    $this->load->view($this->data['theme'] . '/template');
  }


  //Added new
  public function edit_users($id=NULL)
  {
    $this->common_model->checkAdminUserPermission(13);
    $this->data['countrycode']= $this->admin->get_country_code_config();
    if(!empty($id)){
      $this->data['user']=$this->dashboard->get_user_details($id);
      $this->data['title']="Edit User";
    }else{
      $this->data['user']=array();
      $this->data['title']="Add User";
    }
    $this->data['page']="edit_user";
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');  
  }

  public function check_user_name()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->where('id !=', $id);
      $this->db->from('users');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->from('users');
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

  public function check_user_mobile()
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
      $this->db->from('users');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('country_code', $country_code);
      $this->db->where('mobileno', $mobileno);
      $this->db->from('users');
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

  public function check_user_email()
  {
    $email = $this->input->post('email');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->where('id !=', $id);
      $this->db->from('users');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->from('users');
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

	public function update_user()
  {
    $this->common_model->checkAdminUserPermission(13);
    $params=$this->input->post();
    $user_id='';
    $uploaded_file_name = '';

    if (isset($_FILES) && isset($_FILES['profile_img']['name']) && !empty($_FILES['profile_img']['name'])) {
      $uploaded_file_name = $_FILES['profile_img']['name'];
      $uploaded_file_name_arr = explode('.', $uploaded_file_name);
      $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
      $this->load->library('common');
      $upload_sts = $this->common->global_file_upload('uploads/profile_img/', 'profile_img', time().$filename);    
      if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
        $uploaded_file_name = $upload_sts['data']['file_name'];
      }
    }
    if(!empty($uploaded_file_name)){
      $params['profile_img']="uploads/profile_img/".$uploaded_file_name;
    }

    $profile_image = $this->input->post('profile_img');
    if (!empty($profile_image)) { 
      $params['profile_img'] = $profile_image;
    }else{
      unset($params['profile_img']);
    }
    if(!empty($params['id'])){
      $user_id=$params['id'];
      $params['updated_at'] = date('Y-m-d H:i:s'); 
      $result=$this->db->where('id',$user_id)->update('users',$params);
    }else{
      $params['currency_code'] = 'INR';  
      $params['otp'] = '1234';  
      $params['share_code'] = $this->user->ShareCode(6,$params['name']);
      $params['created_at'] = date('Y-m-d H:i:s');
      $params['is_agree'] = 1;

      
      $result=$this->db->insert('users',$params);
      $user_id = $this->db->insert_id();
      $token = $this->user->getToken(14,$user_id);
      $this->db->where('id', $user_id);
      $this->db->update('users', array('token'=>$token));

      //insert chat
      if(settingValue('chat_showhide') == 1 && settingValue('chat_text') != '') {
        $chat_text = settingValue('chat_text');
      } else {
        $chat_text = 'Hi! Welcome to '.settingValue('website_name');
      }
      
      $chat_arr = ['sender_token'=>'0dreamsadmin', 'receiver_token'=>$token, 'message'=> $chat_text, 'status'=>'1', 'read_status'=>'0', 'utc_date_time'=>date('Y-m-d H:i:s')];
      $this->db->insert('chat_table', $chat_arr);
      //insert wallet
      $data = array("token" => $token, 'currency_code' => 'INR', "user_provider_id" => $user_id, "type" => 2, "wallet_amt" => 0, "created_at" => date('Y-m-d H:i:s'));
      $wallet_result = $this->db->insert('wallet_table', $data);
    }
    
    if($result==true){
      if(empty($user_id)){
        echo json_encode(['status'=>true,'msg'=>"User Details Added SuccesFullly..."]);
      }else{
        echo json_encode(['status'=>true,'msg'=>"User Details Updated SuccesFullly..."]);
      }
    }else{
      echo json_encode(['status'=>false,'msg'=>"Someting Went wrong in server end..."]);
    }
  }

  public function delete_user_data()
  {
    $adminId = $this->session->userdata('admin_id');
    if ($adminId > 1) {
      echo json_encode(['status'=>false,'msg'=>"Permission Denied.!!"]);
    }else{
      $id = $this->input->post('user_id');
      if (!empty($id)) {
        if($this->db->delete('users', array('id' => $id))) {
          echo json_encode(['status'=>true,'msg'=>"Users Details Deleted SuccesFullly."]);
        }else{
          echo json_encode(['status'=>false,'msg'=>"Someting went wrong on server end.."]);
        }
      }else {
        echo json_encode(['status'=>false,'msg'=>"Someting went wrong, Please try again !!"]);
      }
    }
  }

   /*change delete_provider_data */
public function delete_provider_data(){
	$id=$this->input->post('user_id');
	$this->db->where('provider_id',$id)->delete('book_service');
	$this->db->where('provider_id',$id)->delete('book_service_cod');
	$this->db->where('provider_id',$id)->delete('business_hours');
	$this->db->where('user_id',$id)->delete('services');
	$this->db->where('subscriber_id',$id)->delete('subscription_details');
	$this->db->where('subscriber_id',$id)->delete('subscription_details_history');
	$this->db->where('provider_id',$id)->delete('rating_review');
	$this->db->where('provider_id',$id)->delete('provider_address');
	$this->db->where('user_provider_id',$id)->where('type',1)->delete('wallet_table');
	$this->db->where('user_provider_id',$id)->where('type',1)->delete('wallet_transaction_history');
	$result = $this->db->where('id',$id)->delete('providers');
      if($result){
        echo "success";
      }else{
        echo "error";
      }

} 
  public function crop_profile_img($prev_img = '') 
  {
    ini_set('max_execution_time', 3000);
    ini_set('memory_limit', '-1');

    if (!empty($prev_img)) {
      $file_path = FCPATH . $prev_img;
      if (!file_exists($file_path)) {
        unlink(FCPATH . $prev_img);
      }
    }
    
    $error_msg = '';
    $av_src = $this->input->post('avatar_src');
    $av_data = json_decode($this->input->post('avatar_data'), true);
    $av_file = $_FILES['avatar_file'];
    $src = 'uploads/profile_img/' . $av_file['name'];
    $imageFileType = pathinfo($src, PATHINFO_EXTENSION);
    $image_name = time() . '.' . $imageFileType;
    $src2 = 'uploads/profile_img/temp/' . $image_name;
    move_uploaded_file($av_file['tmp_name'], $src2);

    $ref_path = '/uploads/profile_img/temp/';
    $image1 = $this->crop_images($image_name, $av_data, 200, 200, "/uploads/profile_img/", $ref_path);

    $rand = rand(100, 999);

    $response = array(
      'state' => 200,
      'message' => $error_msg,
      'result' => 'uploads/profile_img/' . $image_name,
      'success' => 'Y',
      'img_name1' => $image_name
    );
    echo json_encode($response);
  }

  public function crop_images($image_name, $av_data, $t_width, $t_height, $path, $ref_path) 
  {
    $w = $av_data['width'];
    $h = $av_data['height'];
    $x1 = $av_data['x'];
    $y1 = $av_data['y'];

    list($imagewidth, $imageheight, $imageType) = getimagesize(FCPATH . $ref_path . $image_name);

    $imageType = image_type_to_mime_type($imageType);
    $ratio = ($t_width / $w);
    $nw = ceil($w * $ratio);
    $nh = ceil($h * $ratio);

    $newImage = imagecreatetruecolor($nw, $nh);
    $backgroundColor = imagecolorallocate($newImage, 0, 0, 0);
    imagefill($newImage, 0, 0, $backgroundColor);
    $black = imagecolorallocate($newImage, 0, 0, 0);

    // Make the background transparent
    imagecolortransparent($newImage, $black);

    switch ($imageType) {
        case "image/gif" : $source = imagecreatefromgif(FCPATH . $ref_path . $image_name);
        break;
        case "image/pjpeg":
        case "image/jpeg" :
        case "image/jpg" : $source = imagecreatefromjpeg(FCPATH . $ref_path . $image_name);
        break;
        case "image/png" :
        case "image/x-png": $source = imagecreatefrompng(FCPATH . $ref_path . $image_name);
        break;
    }

    imagecopyresampled($newImage, $source, 0, 0, $x1, $y1, $nw, $nh, $w, $h);

    switch ($imageType) {
      case "image/gif" : imagegif($newImage, FCPATH . $path . $image_name);
      break;
      case "image/pjpeg":
      case "image/jpeg" :
      case "image/jpg" : imagejpeg($newImage, FCPATH . $path . $image_name, 100);
      break;
      case "image/png" :
      case "image/x-png": imagepng($newImage, FCPATH . $path . $image_name);
      break;
    }
  }


  public function blocked_providers() 
  {
    $this->common_model->checkAdminUserPermission(31);
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
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,5,6,7)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status',2)->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();

      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'blocked-users';
      $this->data['list'] = $this->dashboard->get_blocked_list();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
    $this->data['page'] = 'blocked_providers';
    $this->data['model'] = 'blocking';
    $this->data['list'] = $this->dashboard->get_blocked_providers_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function blocked_users() 
  {
    $this->common_model->checkAdminUserPermission(32);
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
      $this->data['all_booking']=$this->db->from('book_service')->where('status in (1,2,5,6,7)')->count_all_results();
      $this->data['pending']=$this->db->from('book_service')->where('status',1)->count_all_results();
      $this->data['inprogress']=$this->db->from('book_service')->where('status',2)->count_all_results();
      $this->data['completed']=$this->db->from('book_service')->where('status',6)->count_all_results();
      $this->data['rejected']=$this->db->from('book_service')->where('status',5)->count_all_results();
      $this->data['cancelled']=$this->db->from('book_service')->where('status',7)->count_all_results();

      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');

    }else{
      $this->data['page'] = 'blocked-users';
      $this->data['list'] = $this->dashboard->get_blocked_list();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
    $this->data['page'] = 'blocked_users';
    $this->data['model'] = 'blocking';
    $this->data['list'] = $this->dashboard->get_blocked_users_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  //Blocked user/provider status changed by Admin
  public function blocked_users_byAdmin()
  {
    $this->common_model->checkAdminUserPermission(30);
    if (empty($this->session->userdata('id'))) {
    }

    $params=$this->input->post(); 

    if(!empty($params['status']) && !empty($params['id']) ) {
      $status = $params['status'];
      $row_id = $params['id'];
      $blocked_id = $params['blockedId'];
      $blocked_by_id = $params['blockedById'];
      $user_type = $params['userType'];
      $updated_on = date('Y-m-d H:i:s'); 

      $update_data['status'] = $status;
      $update_data['updated_at'] = $updated_on;
      
      if($user_type == 2) {
        $WHERE = array('id'=>$row_id, 'blocked_id'=>$blocked_id, 'blocked_by_id'=>$blocked_by_id, 'blocked_by_type'=>1);
        $table_name = "block_user_provider"; //blocked users tbl by provider
      }
      if($user_type == 1) {
        $WHERE = array('id'=>$row_id, 'blocked_id'=>$blocked_id, 'blocked_by_id'=>$blocked_by_id, 'blocked_by_type'=>2);
        $table_name = "blocked_providers"; //blocked providers tbl by user
      }
      $result=$this->dashboard->update_blockedstatus($table_name,$update_data,$WHERE, $user_type);
      if($result) { 
        $message= 'Blocked successfully';
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

public function unblocked_users_byAdmin()
  {
    $this->common_model->checkAdminUserPermission(30);
    if (empty($this->session->userdata('id'))) {
    }

    $params=$this->input->post(); 

    if(!empty($params['id']) ) { 
      $status = $params['status'];
      $row_id = $params['id'];
      $blocked_id = $params['blockedId'];
      $blocked_by_id = $params['blockedById'];
      $user_type = $params['userType'];
      $updated_on = date('Y-m-d H:i:s'); 

      $update_data['status'] = $status;
      $update_data['updated_at'] = $updated_on;
      
      if($user_type == 2) {
        $WHERE = array('id'=>$row_id, 'blocked_id'=>$blocked_id, 'blocked_by_id'=>$blocked_by_id, 'blocked_by_type'=>1);
        $table_name = "block_user_provider"; //blocked users tbl by provider
      }
      if($user_type == 1) {
        $WHERE = array('id'=>$row_id, 'blocked_id'=>$blocked_id, 'blocked_by_id'=>$blocked_by_id, 'blocked_by_type'=>2);
        $table_name = "blocked_providers"; //blocked providers tbl by user
      }
      $result=$this->dashboard->update_unblockedstatus($table_name,$update_data,$WHERE, $user_type);
      if($result) { 
        $message= 'Blocked successfully';
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


 public function generalSetting() {
  $this->common_model->checkAdminUserPermission(27);
    if($this->input->post('form_submit') == true) {
        $this->load->library('upload');
        $data = $this->input->post();
        if (isset($data['radius_showhide'])) {
            $data['radius_showhide'] = '1';
        } else {
            $data['radius_showhide'] = '0';
        }
        
        if (!is_dir('uploads/logo')) {
            mkdir('./uploads/logo', 0777, TRUE);
        }

        if (!is_dir('uploads/placeholder_img')) {
            mkdir('./uploads/placeholder_img', 0777, TRUE);
        }

        


        if (isset($_FILES['logo_front']['name'])) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/logo';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['logo_front']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('logo_front')) {
                $img_uploadurl = 'uploads/logo' . $_FILES['logo_front']['name'];
                $key = 'logo_front';
                $val = 'uploads/logo/' . $image_name;
                $data['logo_front'] = $val;
            }
        }

        if (isset($_FILES['favicon']['name'])) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/logo';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['favicon']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('favicon')) {
                $img_uploadurl = 'uploads/logo' . $_FILES['favicon']['name'];
                $key = 'favicon';
                $val = $image_name;
                $data['favicon'] = $val;
            }
        }
        if (isset($_FILES['header_icon']['name'])) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/logo';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['header_icon']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('header_icon')) {
                $img_uploadurl = 'uploads/logo' . $_FILES['header_icon']['name'];
                $key = 'header_icon';
                $val = 'uploads/logo/' . $image_name;
                $data['header_icon'] = $val;
            }
        }

        if (isset($_FILES['service_placeholder_image']['name'])) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/placeholder_img';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['service_placeholder_image']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('service_placeholder_image')) {
                $img_uploadurl = 'uploads/placeholder_img' . $_FILES['service_placeholder_image']['name'];
                $key = 'service_placeholder_image';
                $val = 'uploads/placeholder_img/' . $image_name;
                $data['service_placeholder_image'] = $val;
            }
        }

        if (isset($_FILES['profile_placeholder_image']['name'])) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/placeholder_img';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['profile_placeholder_image']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/placeholder/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('profile_placeholder_image')) {
                $img_uploadurl = 'uploads/placeholder_img' . $_FILES['profile_placeholder_image']['name'];
                $key = 'profile_placeholder_image';
                $val = 'uploads/placeholder_img/' . $image_name;
                $data['profile_placeholder_image'] = $val;
            }
        }
        
        if ($data) {
            $table_data = array();
            foreach ($data AS $key => $val) {
                if ($key != 'form_submit') {
                    $data_details = $this->db->get_where('system_settings', array('key'=>$key))->row();
                    if(empty($data_details)) {
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $where = array('key' => $key);
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->update('system_settings', $table_data, $where);
                    }
                    
                }
            }
            if(!empty($data['language'])) {
                $this->db->where('language_value',$data['language']);
                $this->db->update('language',array('default_language' =>1));
                $this->db->where('language_value!=',$data['language']);
                $this->db->update('language',array('default_language' =>2));
            }
            $this->session->set_flashdata('success_message', 'Setting details updated successfully');
            redirect(base_url() . 'admin/general-settings');
        }
    }
    
    $results = $this->admin->get_setting_list();
    foreach ($results AS $config) {
        $this->data[$config['key']] = $config['value'];
    }
    $this->data['currencies'] = $this->db->get('currency')->result_array();
    $this->data['languages'] = $this->db->get('language')->result_array();
    $this->data['page'] = 'general-settings';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

    public function otherSettings() {
        $this->data['page'] = 'other_settings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
     public function chatSettings() {
        $this->data['page'] = 'chat_settings';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }

    public function sendSubscriptionExpiredMail() {
        $get_subscripe_plan = $this->db->order_by("id","DESC")->get_where('subscription_details', array('date(expiry_date_time)'=>date('Y-m-d', strtotime('+1 day'))))->result_array();
        foreach($get_subscripe_plan as $plans) {
            $mail_data = $this->db->order_by("id","DESC")->get_where('subscription_expired_mail', array('date(expiry_date)'=>date('Y-m-d', strtotime('+1 day')), 'message_status'=>1, 'subscriper_id'=>$plans['subscriber_id'],'subscription_id'=>$plans['subscription_id']))->row_array();

            $mail_details = array(
                'subscription_id' =>$plans['subscription_id'],
                'subscriper_id' =>$plans['subscriber_id'],
                'expiry_date' =>$plans['expiry_date_time'],
                'message_status' =>1,
                'created_datetime' =>date('Y-m-d H:i:s'),
            );
            if(empty($mail_data)) {
                $mail_insert = $this->db->insert('subscription_expired_mail', $mail_details);
            } else {
                $this->db->where(array('subscription_id'=>$plans['subscription_id'],'subscriper_id' =>$plans['subscriber_id']));
                $this->db->update('subscription_expired_mail', $mail_details);
            }
            $pro_data = $this->db->get_where('providers', array('id'=>$plans['subscriber_id']))->row_array();

            //Mail Content
            $planName = $this->db->get_where('subscription_fee', array('id'=>$plans['subscription_id']))->row()->subscription_name;
            $message = 'Your subscription plan <b>'.$planName.'</b> is expire on <b>'.date('Y-m-d', strtotime('+1 day')).'</b>. Kindly subscripe any other plan';
            $body = 'Hi '.$pro_data['name'].',<br> '.$message;

            //Mail Configuration
            $phpmail_config = settingValue('mail_config');
            if (isset($phpmail_config) && !empty($phpmail_config)) {
                if ($phpmail_config == "phpmail") {
                    $from_email = settingValue('email_address');
                } else {
                    $from_email = settingValue('smtp_email_address');
                }
            }

            //Send Mail Functionality
            if(empty($mail_data)) {
                $this->load->library('email');
                //Send mail to User
                if(!empty($from_email)&&isset($from_email)){
                        $mail = $this->email
                        ->from($from_email)
                        ->to($pro_data['email'])
                        ->subject('Subscription Expiring')
                        ->message($body);
            
                    if (!$this->email->send()) {
                        echo '1';
                        //echo $this->email->print_debugger(); exit;
                    } else {
                        echo '0';
                    }
                }
            } else {
                echo '0';

            }
        } 
    }

    public function view_userquote($id){
      $this->load->model('Dashboard_model');
      $quote_data = $this->Dashboard_model->get_quote_ans($id);
      $quote['qanswers'] = $quote_data;
      $this->data['page'] = 'view_userquote';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'] . '/template',$quote);
    //   $this->data['page']="view_userquote";
    // $this->load->vars($this->data);
    // $this->load->view($this->data['theme'].'/template');
    }

  // public function quote_status()
  // {
  //   if (isset($_REQUEST['qval'])) 
  //   {
  //     $this->load->model('Dashboard_model');
  //     $q_status = $this->Dashboard_model->quote_stat();

  //     if ($q_status>0) {
  //       $this->session->set_flashdata('success_message', 'quote status updated successfully');
  //       // redirect('admin/general-settings');

  //     }
  //     else{
  //      $this->session->set_flashdata('error_message', 'Something went wront, Try again');
  //     }
  //     return redirect('admin/all-quotes');
      
  //   }
 

  //   // redirect(base_url('admin/all-quotes'));
  // }
//   public function quote_status(){
//     $id = $this->input->get('qid');
//     $status = $this->input->get('qval');
//     if($id && $status){
//         $this->load->model('Dashboard_model');
//         $result = $this->Dashboard_model->update_quote_status($id, $status);
//         if ($result){
//             $this->session->set_flashdata('success_message', 'Quote status updated successfully');
//         }else{
//             $this->session->set_flashdata('error_message', 'Something went wrong, please try again.');
//         }
//     }
//     redirect(base_url('admin/all-quotes'));
// }
public function quote_status(){
  $id = $this->input->get('qid');
  $status = $this->input->get('qval');
  $this->load->model('Dashboard_model');
  $q_status = $this->Dashboard_model->quote_stat($id, $status);

  if ($q_status) {
      $this->session->set_flashdata('success_message', 'Quote status updated successfully');
  } else {
      $this->session->set_flashdata('error_message', 'Something went wrong. Please try again.');
  }

  redirect('admin/all-quotes');
}
     
//get user quote ansers
    public function user_quoteanswers() {

  }
}//Class end.

?>
