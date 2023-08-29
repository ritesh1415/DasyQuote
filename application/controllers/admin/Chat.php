<?php
class Chat extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'chat';
        $this->load->model('admin_model');
        $this->load->model('chat_model');
        $this->data['base_url'] = base_url();
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
    }
    public function index()
    {
        $this->data['page'] = 'index';

        $chat_lists = $this->chat_model->get_chat_list('0dreamsadmin');
        $final = [];
        foreach ($chat_lists as $key => $value) {
            if (!empty($value->name)) {
                $final[$key]['profile_img'] = $value->profile_img;
                $final[$key]['token'] = $value->token;
                $final[$key]['name'] = $value->name;
                $final[$key]['last_msg'] = $this->chat_model->get_last_msg($value->token)->message;
                $final[$key]['badge'] = $this->chat_model->get_badge_count($value->token, $this->chat_token)->counts;
            }
        }
        $this->data['chat_list'] = $final;
        $this->data['server_name'] = settingValue('server_name');
        $this->data['port_no'] = settingValue('port_no');
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function provider_chat()
    {
        $this->data['page'] = 'provider_chat';

        $chat_lists = $this->chat_model->get_provider_chat_list('0dreamsadmin');
        $final = [];
        foreach ($chat_lists as $key => $value) {
            if (!empty($value->name)) {
                $final[$key]['profile_img'] = $value->profile_img;
                $final[$key]['token'] = $value->token;
                $final[$key]['name'] = $value->name;
                $final[$key]['last_msg'] = $this->chat_model->get_last_msg($value->token)->message;
                $final[$key]['badge'] = $this->chat_model->get_badge_count($value->token, $this->chat_token)->counts;
            }
        }
        $this->data['chat_list'] = $final;
        $this->data['server_name'] = settingValue('server_name');
        $this->data['port_no'] = settingValue('port_no');
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function user_chat()
    {
        $this->data['page'] = 'client_chat';

        $chat_lists = $this->chat_model->get_user_chat_list('0dreamsadmin');
        $final = [];
        foreach ($chat_lists as $key => $value) {
            if (!empty($value->name)) {
                $final[$key]['profile_img'] = $value->profile_img;
                $final[$key]['token'] = $value->token;
                $final[$key]['name'] = $value->name;
                $final[$key]['last_msg'] = $this->chat_model->get_last_msg($value->token)->message;
                $final[$key]['badge'] = $this->chat_model->get_badge_count($value->token, $this->chat_token)->counts;
            }
        }
        $this->data['chat_list'] = $final;
        $this->data['server_name'] = settingValue('server_name');
        $this->data['port_no'] = settingValue('port_no');
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function get_user_chat_lists()
    {
        $current_url = $this->input->post('url_data');
        if ($current_url == 'client-chat') {
            $chat_lists = $this->chat_model->get_user_chat_list('0dreamsadmin');
        } else if ($current_url == 'provider-chat') {
            $chat_lists = $this->chat_model->get_provider_chat_list('0dreamsadmin');
        } else {
            $chat_lists = $this->chat_model->get_chat_list('0dreamsadmin');
        }

        $final = [];
        foreach ($chat_lists as $key => $value) {
            $final[$key]['profile_img'] = $value->profile_img;
            $final[$key]['token'] = $value->token;
            $final[$key]['name'] = $value->name;
            $final[$key]['last_msg'] = $this->chat_model->get_last_msg($value->token)->message;
            $final[$key]['badge'] = $this->chat_model->get_badge_count($value->token, '0dreamsadmin')->counts;
        }
        $this->data['chat_list'] = $final;
        echo json_encode($this->data);
        exit;
    }

    public function booking_new_chat()
    {
        extract($_GET);
        $data = $this->chat_model->get_book_info($book_id);

        if (!empty($data)) {
            $self_info = $this->chat_model->get_token_info('0dreamsadmin');
            if ($self_info->type == 2) {
                $user_token = $this->chat_model->get_user_info($data['provider_id'], 1);
            } else {
                $user_token = $this->chat_model->get_user_info($data['user_id'], 2);
            }

        }
        $this->data['page'] = 'user_chats';
        $chat_lists = $this->chat_model->get_token_info($user_token['token']);

        $final['profile_img'] = $chat_lists->profile_img;
        $final['token'] = $chat_lists->token;
        $final['name'] = $chat_lists->name;
        $final['last_msg'] = '';
        $final['badge'] = $this->chat_model->get_badge_count($chat_lists->token, '0dreamsadmin')->counts;
        $this->data['server_name'] = settingValue('server_name');
        $this->data['port_no'] = settingValue('port_no');

        $this->data['chat_list'] = array($final);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function get_chat_history()
    {
        extract($_POST);
        $self_token = '0dreamsadmin';
        $data['chat_history'] = $this->chat_model->get_conversation_info($self_token, $partner_token);
        $data['partner_info'] = $this->chat_model->get_token_info($partner_token);
        $data['self_info'] = $this->chat_model->get_token_info($self_token);
        $this->load->view('admin/chat/ajax_page/chat_history', $data);
    }


    /*get token info*/
    public function get_token_informations()
    {
        extract($_POST);
        $self_token = '0dreamsadmin';
        $data['partner_info'] = $this->chat_model->get_token_info($partner_token);

        $data['self_info'] = array('id' => 1, 'name' => 'Admin', 'token' => '0dreamsadmin');
        echo json_encode($data);
    }
    /*insert_message*/

    public function insert_message()
    {
        extract($_POST);
        date_default_timezone_set('UTC');
        $date_time = date('Y-m-d H:i:s');
        date_default_timezone_set('Asia/Kolkata');
        $data = array(
            "sender_token" => $fromToken,
            "receiver_token" => $toToken,
            "message" => $content,
            "status" => 1,
            "read_status" => 0,
            "utc_date_time" => $date_time,
            "created_at" => date('Y-m-d H:i:s'),
        );

        $val = $this->chat_model->insert_msg($data);
        if ($val) {
            echo json_encode(['success' => true, 'msg' => "success"]);
            exit;
        } else {
            echo json_encode(['success' => false, 'msg' => "not insert"]);
            exit;
        }
    }

    /*clear screen*/

    public function clear_history()
    {
        extract($_POST);

        $data = $this->chat_model->get_conversation_info($self_token, $partner_token);
        $where = [];
        foreach ($data as $key => $value) {
            $where[] = $value->chat_id;
        }
        $data = array('status' => 0);
        $table = 'chat_table';

        $ret = $this->chat_model->update_info($where, $data, $table);
        if ($ret) {
            $ret = 1;
        } else {
            $ret = 2;
        }
        echo $ret;
    }

    /*change to read staus*/
    public function changeToRead_ctrl()
    {
        extract($_POST);

        $data = array('read_status' => 1);
        $table = 'chat_table';
        $where = array('receiver_token' => $self_token, 'sender_token' => $partner_token);
        $ret = $this->chat_model->changeToRead($where, $data, $table);
        if ($ret) {
            echo 1;
        } else {
            echo 2;
        }
    }

    // admin quote list
    public function quote_list()
    {

        $this->data['page'] = 'quote_list';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    // all quotes
    public function all_quotes()
    {
        // $quote['qanswers']=$this->chat_model->get_quote();
        // $this->data['page'] = 'all_quotes';
        $quote_data = $this->chat_model->get_quote();
        $quote['qanswers'] = $quote_data;
        $this->data['page'] = 'all_quotes';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template',$quote);
    }

    //  quotes response
    public function quote_response()
    {

        $this->data['page'] = 'quote_response';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template',);
    }

    //    quote inprogress
    public function quote_inprogress()
    {

        $this->data['page'] = 'quote_inprogress';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    //    quote inprogress
    public function quote_waiting()
    {

        $this->data['page'] = 'quote_waiting';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function quote_decline()
    {

        $this->data['page'] = 'quote_decline';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function cancel_quoteview(){
      $this->data['page']="all_quotes";
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
      }

}