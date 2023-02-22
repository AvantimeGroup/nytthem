<?php

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d1';
$customer_no = 13751;

echo $guid = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : ''; 
/* 
if(!$guid){
	
	echo 'Please provide parent GUID' ;
	exit;
} */


$client = new SoapClient($url);

try {
		$result = $client->HamtaLista(array(
        'licensId' => $licensId,
        'licensNyckel' => $Licensnyckel,
        'kundnummer' => $customer_no,
    ));
	
	//echo '<pre>' ; print_r($result->HamtaListaResult->ObjektUppdateringsinfo) ; die;
	foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
		
		if(($value->Typ == 'CMNyProd' || $value->Typ == 'CMNyprod'  || $value->Typ == 'CMBoLgh' ) && $value->Guid == $guid)
		{	
	
		$resultchild = $client->HamtaProjekt(array(
				'licensid' =>$value->KundNr,
				'licensnyckel' => $Licensnyckel,
				'guid' => $guid 
			));	
			
		echo '<pre>' ; print_r($resultchild) ; die;
		$HamtaProjektResult = $resultchild->HamtaProjektResult;
		
		$BostadChildObject = $HamtaProjektResult->Bostadsrattslista;

		$BostadChild = $BostadChildObject->BostadsrattsLista;
		
		if(is_array($BostadChild) and count($BostadChild > 0))

			{

				foreach($BostadChild as $BostadGuid)
				{

				
					$Bostadsrattslista = $client->HamtaBostadsratt(array(

						'licensid' => $licensId,

						'licensnyckel' => $Licensnyckel,

						'guid' =>$BostadGuid->GUID

					));	
					
					
					echo '<pre>' ; print_r($Bostadsrattslista) ; 

				}

			}
	 
		}
	}
} catch (Exception $e) {
    echo '<pre>' ; print_r($e);
	exit(2);
}