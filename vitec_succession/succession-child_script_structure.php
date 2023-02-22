<?php
$data = file_get_contents("php://input");

if($data)
file_put_contents(date('ymdhis').".log",$data);

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/fastighetsmaklare/Standardobjektmall/ExportV2.svc?singleWsdl';
$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d';
$customer_no = 13751;


$client = new SoapClient($url);

$result = $client->HamtaLista(array(
        'licensid' => $licensId,
        'licensnyckel' => $Licensnyckel,
        'kundnummer' => $customer_no
    ));
//echo '<pre>'; print_r($result); 
if(isset($_REQUEST['guid'])){
	$result_again = $client->HamtaBostadsratt(array(
							'licensid' => $licensId,
							'licensnyckel' => $Licensnyckel,
							'guid' => $_REQUEST['guid'] 
						));	
	echo "<b>GUID:</b> ".$_REQUEST['guid'];
	echo '<pre>'; print_r($result_again); echo '</pre>';  die;
}

	

	/*   echo '<pre>';
	print_r($result);die("here");  */
      
		foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
			if($value->Typ == 'CMBoLgh' || $value->Typ == 'CMBoLgh')
			{	
				
						$result_again = $client->HamtaBostadsratt(array(
							'licensid' => $value->KundNr,
							'licensnyckel' => $Licensnyckel,
							'guid' => $value->Guid 
						));	
					
					    echo "<b>GUID:</b> ".$value->Guid;
						echo '<pre>'; print_r($result_again); echo '</pre>'; 
						echo "======================================================================"."<br>";
			}		
		
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
    
