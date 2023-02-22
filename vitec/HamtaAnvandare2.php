<?php


$data = file_get_contents("php://input");

if($data)
file_put_contents(date('ymdhis').".log",$data);


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

	/* echo '<pre>';
	print_r($result); */

    foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
		
		if($value->Typ == 'CMNyProd' || $value->Typ == 'CMNyprod')
		{		
			$result_again = $client->HamtaProjekt(array(
				'licensid' => $value->KundNr,
				'licensnyckel' => $Licensnyckel,
				'guid' => $value->Guid 
			));	
			 
			echo '<pre>';
			print_r($result_again);
			
		}		
			
       
        //if (isset($result_again->HamtaAnvandareResult->Bilder)) {
        //        foreach ($result_again->HamtaAnvandareResult->Bilder as $key_bild => $value_bild) {
		//				echo $value_bild->Guid;
        //            $result_bild = $client->HamtaProjekt(array(
        //                'licensid' => $value->KundNr,
        //                'licensnyckel' => $Licensnyckel,
        //                'guid' => $value_bild->Guid
        //            ));
        //            echo '<pre>';
        //            print_r($result_bild);
        //        }
        //    }
    }
} catch (Exception $e) {
    var_dump($e->GetMessage());
}