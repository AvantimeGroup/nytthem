<?php
require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d1';
$customer_no = 13751;

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

