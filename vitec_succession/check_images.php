<?php
 require_once('../wp-load.php');
//amacinfo_api
require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/fastighetsmaklare/Standardobjektmall/ExportV2.svc?singleWsdl';
$client = new SoapClient($url);
/*

$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d1';
$customer_no = 13751;
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
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
die; */
$huv_id = isset($_REQUEST['GUID']) ? $_REQUEST['GUID'] : '';

$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d';
$customer_no = 13751;

$client = new SoapClient($url);



	$result = $client->HamtaLista(array(
			'licensid' => $licensId,
			'licensnyckel' => $Licensnyckel,
			'kundnummer' => $customer_no
		)); 

	foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
			if($value->Typ == 'CMBoLgh' || $value->Typ == 'CMBoLgh')
			{	
				if($value->Guid==$huv_id ){
						$result_again = $client->HamtaBostadsratt(array(
							'licensid' => $value->KundNr,
							'licensnyckel' => $Licensnyckel,
							'guid' => $value->Guid 
						));	
					
					    echo "<b>GUID:</b> ".$value->Guid;
						$huvv_id = $result_again->HamtaBostadsrattResult->Huvudhandlaggare->Guid;
						echo "======================================================================"."<br>";
						
				}
			}		
		
		}

			 $result_again11 = $client->HamtaAnvandare(array(

						'licensid' => $customer_no,

						'licensnyckel' => $Licensnyckel,

						'guid' => $huvv_id

					));	
					if($result_again11->HamtaAnvandareResult->Bilder->Bild){
						echo "<h2>Copy Image Path: </h2>".'http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$result_again11->HamtaAnvandareResult->Bilder->Bild->Guid.'&t=CBild';
					}
					
					echo "<pre>"; print_r($result_again11); die;
					if(isset($result_again->HamtaAnvandareResult))

						$kontact_details = $result_again->HamtaAnvandareResult;

					

					$rtrn = "";

					$kontakt_info = "";

					if($kontact_details)

					{
						$kon_bilder_obj = $kontact_details->Bilder;



						 foreach($kon_bilder_obj as $kon_bild_key=>$kon_bilds_val)

						{
							echo "<pre>"; print_r($kon_bilds_val);
							
						}
						
					} 
