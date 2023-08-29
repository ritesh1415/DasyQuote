<?php 

if(!function_exists('sendFCMMessage')){
  function sendFCMMessage($data,$target){ 
    $ci =& get_instance();
    $val=$ci->db->where('key','firebase_server_key')->where('status',1)->get('system_settings')->row();


    $firebase_api = trim($val->value);
    $value[]=$target;
    $fields = array(
        'registration_ids' => $value,
        'data' => $data,
    );

            // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = array(
      'Authorization: key=' . $firebase_api,
      'Content-Type: application/json'
  );

            // Open connection
    $ch = curl_init();

            // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarily
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
    $result = curl_exec($ch);  
    if($result === FALSE){ 
      die('Curl failed: ' . curl_error($ch));
  }
            // Close connection
  curl_close($ch);
}


}

/*APNS*/

if(!function_exists('sendApnsMessage'))
{
    function sendApnsMessage($data,$target){
        $CI =& get_instance();
        $query = $CI->db->query("select * from system_settings WHERE status = 1");
       $result = $query->result_array();
       $server_key ='';
       if(!empty($result))
       {
           foreach($result as $datas){
          
           if($datas['key'] == 'firebase_server_key'){
                    $server_key = $datas['value'];
           }
           
           }
       }
       
       if($server_key){

           $SERVER_API_KEY = $server_key;
       

           $ch = curl_init("https://fcm.googleapis.com/fcm/send");

       
           $data['additional_data']['body']=$data['message'];
           $data['additional_data']['title']=$data['title'];
           
           
           $aps['aps'] = [
               'alert' => [
                   'title' => $data['title'],
                   'body' => $data['message'],
               ],
                 'badge' => 0,
                 'sound' => 'default',
                 'title' => $data['title'],
                 'body' => $data['message'],
                 'my_value_1' =>   $data['additional_data'],
           ];
           $result = [
               "registration_ids" => array($target),
               "notification" => $aps['aps'],  
           ];

           //Generating JSON encoded string form the above array.
           
            $json = json_encode($result);
            //Setup headers:
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           $headers[] = 'Authorization: key= '. $SERVER_API_KEY.''; // key here

           //Setup curl, add headers and post parameters.
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                
           curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
           curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

           //Send the request
           $response = curl_exec($ch);
          return $response; 
       }
     
    }

  
}

?>