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
	$kemm_array = array();
    foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
		
		// if($value->Typ == 'CMNyprod')
		{		
			$result_again = $client->HamtaProjekt(array(
				'licensid' => $value->KundNr,
				'licensnyckel' => $Licensnyckel,
				'guid' => "4H3IMVB41SVD1I8B"
			));				
			// 'guid' => "48P3HE4OMU9TEUK7"
		
			$rslt = $result_again->HamtaListaResult;
			echo "<pre>";
			print_R($rslt);
			echo "</pre>";
			die;
			/*foreach ($result_again->HamtaProjektResult->Huvudhandlaggare as $key_bild => $value_bild) {
					  //echo $value_bild->GUID.'<br/>';	
					  $kemm_array[] = $value_bild->GUID ;
			}*/	
		}		
    }
	echo "<br>KundNr = ".$value->KundNr;
	array_unique($kemm_array);
	foreach ($kemm_array as $kemm_array)
	{
			$result_again = $client->HamtaAnvandare(array(
				'licensid' => $value->KundNr,
				'licensnyckel' => $Licensnyckel,
				'guid' => $kemm_array
			));	
			 
			echo '<pre>';
			print_r($result_again);		
	}
	
} catch (Exception $e) {
    var_dump($e->GetMessage());
}