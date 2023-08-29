<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '../vendor/autoload.php');
use Twilio\Rest\Client;
	
Class Sms{

	public function send_message($mobileno,$message)
	{
		$CI =& get_instance();
		$sms_key=$CI->db->where('key','twilio_sms_key')->from('system_settings')->get()->row_array();
		$sms_secret_key=$CI->db->where('key','twilio_sms_livekey')->from('system_settings')->get()->row_array();
		$number_twilio=$CI->db->where('key','twilio_sms_secret_key')->from('system_settings')->get()->row_array();
		
		$sid = $sms_key['value'];
		$token = $sms_secret_key['value'];
		$mobile_number_twilio = $number_twilio['value'];

		$client = new Client($sid, $token);
		$result=$client->messages->create('+'.$mobileno,array('from' => $mobile_number_twilio,'body' => $message));
		return $result;
	}

     
		

}