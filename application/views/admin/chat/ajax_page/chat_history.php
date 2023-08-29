<?php
$self_info='0dreamsadmin';
foreach ($chat_history as $key => $msg_value) {
$datef = explode(' ', $msg_value->created_at);

if(settingValue('time_format') == '12 Hours') {
    $time = date('h:ia', strtotime($datef[1]));
} elseif(settingValue('time_format') == '24 Hours') {
   $time = date('H:i:s', strtotime($datef[1]));
} else {
    $time = date('G:ia', strtotime($datef[1]));
}
$date = date(settingValue('date_format'), strtotime($datef[0]));
$timeBase = $date.' '.$time;

if($self_info != $msg_value->sender_token){
?>
<div class="d-flex justify-content-start mb-4">
	<div class="img_cont_msg">
	</div>
	<div class="msg_cotainer">
		<?=$msg_value->message;?>
		<span class="msg_time"> <?=$timeBase;?></span>
	</div>
</div>
<?php
}else{ ?>
<div class="d-flex justify-content-end mb-4">
	<div class="msg_cotainer_send">
		<?=$msg_value->message;?>
		<span class="msg_time_send"> <?=$timeBase;?></span>
	</div>
	<div class="img_cont_msg">
	</div>
</div>
<?php } } ?>