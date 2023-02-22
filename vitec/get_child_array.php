<?php
require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 840102;
$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
$customer_no = 840102;

$guid = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : ''; 
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
				'guid' => $value->Guid
			));	
			
		echo '<pre>' ; print_r($resultchild) ; die;
		$HamtaProjektResult = $resultchild->HamtaProjektResult;
		
		$BostadChildObject = $HamtaProjektResult->Bostadsrattslista;

		$BostadChild = $BostadChildObject->BostadsrattsLista;
		//echo '<pre>' ; print_r($BostadChildObject) ; die;
		if(is_array($BostadChild) and count($BostadChild > 0))

			{

				foreach($BostadChild as $BostadGuid)
				{

					$Bostadsrattslista = $client->HamtaBostadsratt(array(

						'licensid' => $licensId,

						'licensnyckel' => $Licensnyckel,

						'guid' =>$BostadGuid->GUID

					));	
					
					echo $BostadGuid->GUID;
					echo '<pre>' ; print_r($Bostadsrattslista) ; 

				}

			}else{
				if(!empty($BostadChildObject->BostadsrattsLista->GUID))
				{	
			
		
					
					try{
					
					$Bostadsrattslista = $client->HamtaBostadsratt(array(

						'licensid' => $licensId,

						'licensnyckel' => $Licensnyckel,

						'guid' =>$BostadChildObject->BostadsrattsLista->GUID

					));	
					
					echo $BostadChildObject->BostadsrattsLista->GUID;
					echo '<pre>' ; print_r($Bostadsrattslista) ; 

					
					}catch(Exception $e){
	
									SenderrorAlarm($e->getMessage());
									echo $value->Guid ;  echo '<br>' ; 
									echo '<pre>' ; print_r($e->getMessage());
								
					}
				}
			}
	 
		}
	}
} catch (Exception $e) {
    echo '<pre>' ; print_r($e);
	exit(2);
}