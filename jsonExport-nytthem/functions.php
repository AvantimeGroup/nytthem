<?php

$links = mysqli_connect('localhost', 'virendervitect', 't3uytMHyDg');
mysqli_select_db($links, 'nytthem_vitec') or die('Unable to select database, Please Check Your Connection..');


$projekt = [];
$projekt['auth'] 		= 'MzgyOnZGWGlzN0t2dnBpVUFaWGJTRkZ2dkNSczhsOFNoWUg1a3Rqbm1rdk90RHBjaG0wRmNvUkFCa2lpbGNhNnlxRU0=';
$projekt['password'] 	= 'vFXis7KvvpiUAZXbSFFvvCRs8l8ShYH5ktjnmkvOtDpchm0FcoRABkiilca6yqEM';
$projekt['customer_id'] = 'S13907';


/**********************************************/
/***** Function get the request from API ******/
/**********************************************/

function httpRequest($URL, $data){
	 
	$ch 	 = curl_init();
	$auth 	 = $data['auth'];
	$headers = ['Authorization: Basic '.$auth];
	curl_setopt($ch, CURLOPT_USERNAME, "{382}");
	curl_setopt($ch, CURLOPT_PASSWORD, '{'.$data['password'].'}');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if($data['method']){
		$customerID = array('customerId' => $data['customer_id']);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerID));
	}
	$result = curl_exec($ch);
	if (curl_errno($ch)) {	
		die(curl_getinfo($ch));
	}
	$info = curl_getinfo($ch);
	curl_close($ch);

	$http_code = $info["http_code"];
	if ($http_code == 200) {
	   return  json_decode($result, true);
	}

}