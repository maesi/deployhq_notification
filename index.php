<?php 
$payloadAsString = $_POST['payload'];
if(strlen($payloadAsString) == 0) {
	echo "Kein Payload.";
	exit;
}

$message = "PAYLOAD: " . $_POST['payload'] . PHP_EOL;;

$payload = json_decode($payloadAsString);

foreach($payload->servers as $server) {
	$message .= "SERVER: " . $server->name . PHP_EOL;
	
	$url = "http://".$server->name."/migration/";
	$message .= "URL: " . $url . PHP_EOL;
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	
	curl_close($ch);
}
if(!is_dir("log")) {
	mkdir("log");
}
$filename = "log" . DIRECTORY_SEPARATOR . date("YmdHis") . "_notification.txt";
file_put_contents($filename, $message);