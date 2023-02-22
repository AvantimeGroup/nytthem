<?php

require_once('lib/nusoap.php');

function getProd($guid) {
    try {
        $url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
        $licensId = 840102;
        $Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
        $customer_no = 840102;
        $client = new SoapClient($url);
        $result_again = $client->HamtaProjekt(array(
            'licensid' => $value->KundNr,
            'licensnyckel' => $Licensnyckel,
            'guid' => $guid
        ));
        return (json_encode($result_again));
    } catch (Exception $e) {
        
    }
}


$server = new soap_server();
$server->register("getProd");
$server->service($HTTP_RAW_POST_DATA);
