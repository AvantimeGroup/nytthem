<?php
require_once('../wp-load.php');
//amacinfo_api
require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 840102;
$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
$customer_no = 840102;

$client = new SoapClient($url);


$result = $client->HamtaProjekt(array(
	'licensid' => $customer_no,
	'licensnyckel' => $Licensnyckel,
	'guid' => "4H3IMVB41SVD1I8B"
));
// 'guid' => "48P3HE4OMU9TEUK7" 

$HamtaProjektResult = $result->HamtaProjektResult;
echo "<pre>";
print_r($HamtaProjektResult );
echo "</pre>";
die;