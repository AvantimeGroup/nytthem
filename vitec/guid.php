<?php

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 840102;
$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
$customer_no = 840102;

$client = new SoapClient($url);

try {
    $result = $client->HamtaLista(array(
        'licensId' => $licensId,
        'licensNyckel' => $Licensnyckel,
        'kundnummer' => $customer_no
    ));
	//shuffle($result->HamtaListaResult->ObjektUppdateringsinfo);
    foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
			echo $value->Guid.'<br/>';
    }
	
} catch (Exception $e) {
    var_dump($e->GetMessage());
}

?>

