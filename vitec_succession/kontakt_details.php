<?php
require_once('../wp-load.php');
//amacinfo_api
require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d1';
$customer_no = 13751;

$client = new SoapClient($url);


$result = $client->HamtaProjekt(array(
	'licensid' => $customer_no,
	'licensnyckel' => $Licensnyckel,
	'guid' => "4T2IBCM242V6S099"
));
// 'guid' => "48P3HE4OMU9TEUK7" 

$HamtaProjektResult = $result->HamtaProjektResult;
echo "<pre>";
print_r($HamtaProjektResult );
echo "</pre>";
die;