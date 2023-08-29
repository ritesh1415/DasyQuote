<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paysolution extends CI_Controller {
	public function index() {
		$data['title']    = 'Paysolution Pay';
		$this->load->view('user/testpay', $data);
    }
    
	public function postpaysuccess() {
		$pay_data = $_REQUEST;
		//Wallet - Paysolution
		if($pay_data['productdetail'] == 'wallet') {
			$user  = $this->db->where('email', $pay_data['customeremail'])->get('users')->row_array();
            $amount        = $pay_data['total'];
            $user_id       = $user['id'];
            $user_name     = $user['name'];
            $user_token    = $user['token'];
            $currency_type = $user['currency_code'];

            $wallet = $this->db->where('user_provider_id', $user_id)->where('type', 2)->get('wallet_table')->row_array();
            $wallet_amt = $wallet['wallet_amt'];

            $history_pay['token']=$user_token;
            $history_pay['user_provider_id']=$user_id;
            $history_pay['currency_code']= $user['currency_code'];
            $history_pay['credit_wallet'] = $amount;
            $history_pay['debit_wallet'] = 0;
            $history_pay['type']='1';
            $history_pay['transaction_id']= $pay_data['refno'];
            $history_pay['paid_status']='1';
            $history_pay['total_amt']=$amount;
            if($wallet_amt){
                $current_wallet = $wallet_amt+$amount;
            }else{
                $current_wallet = $amount;
            }
            $history_pay['current_wallet']=$wallet_amt;
            $history_pay['avail_wallet'] = $current_wallet;
            $history_pay['reason']='Wallet Amount Added';
            $history_pay['payment_type']='paysolution';
            $history_pay['created_at']=date('Y-m-d H:i:s');
            if($this->db->insert('wallet_transaction_history',$history_pay)){                     $this->db->where('user_provider_id', $user_id)->update('wallet_table', array(
                    'currency_code' => $user['currency_code'],
                    'wallet_amt' => $current_wallet
                ));                                            
           	}
            if($this->db->affected_rows() > 0) {
				echo 1;
            } else {
            	echo 0;
            }
        } else {
        	//Subscription - Paysolution
            $new_details = array();
            $stripe = array();
            $plan_id = explode('_', $pay_data['productdetail']);
            $subscription_id = $plan_id[1];
            $user  = $this->db->where('email', $pay_data['customeremail'])->get('providers')->row_array();
            $user_id       = $user['id'];

            $this->db->select('duration');
            $record = $this->db->get_where('subscription_fee',array('id'=>$subscription_id))->row_array();
               
            if(!empty($record)) {
                $duration = $record['duration'];
                $days = 30;
                switch ($duration) {
                    case 1:
                       $days = 30;
                      	break;
                    case 2:
                       $days = 60;
                       break;
                    case 3:
                       $days = 90;
                       break;
                    case 6:
                       $days = 180;
                       break;
                    case 12:
                       $days = 365;
                       break;
                    case 24:
                       $days = 730;
                       break;

                    default:
                       $days = 30;
                       break;
                }

                $subscription_date = date('Y-m-d H:i:s');
                $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$days."days"));

               $new_details['subscriber_id'] = $stripe['subscriber_id'] = $user_id;
               $new_details['subscription_id'] = $stripe['subscription_id'] = $subscription_id;
               $new_details['subscription_date'] = $stripe['subscription_date'] = $subscription_date;
               $new_details['expiry_date_time'] = $expiry_date_time;
               $new_details['type']=1;  
                     $this->db->where('subscriber_id', $user_id);
               $count = $this->db->count_all_results('subscription_details');
               if($count == 0){
                    $this->db->insert('subscription_details', $new_details);
                    $this->db->insert('subscription_details_history', $new_details);
                    $stripe['sub_id'] = $this->db->insert_id();

                } else {
                    $this->db->where('subscriber_id', $user_id);
                    $this->db->update('subscription_details', $new_details);
                    $this->db->insert('subscription_details_history', $new_details);
                    $this->db->where('subscriber_id', $user_id);
                    $details_sub = $this->db->get('subscription_details')->row_array();
                    $stripe['sub_id'] = $subscription_id;
                }
                $stripe['tokenid'] = $user['token'];
                $stripe['payment_details'] = 'Paysolution';
                $this->db->insert('subscription_payment', $stripe);
                if($this->db->affected_rows() > 0) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
	}
}
