<?php

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/fastighetsmaklare/Standardobjektmall/export.svc?singleWsdl';
$licensId = 13751;
$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d';
$customer_no = 13751;


$guid = isset($_REQUEST['GUID']) ? $_REQUEST['GUID'] : ''; 

$client = new SoapClient($url);
try{
$result = $client->HamtaAnvandare(array(

						'licensid' => $customer_no,

						'licensnyckel' => $Licensnyckel,

						'guid' => $guid

					));	
echo '<pre>' ; print_r($result) ;
}
catch(Exception $e){
	echo '<pre>' ; print_r($e) ; die;
	
}
?>

<img src="http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g=<?php echo $result->HamtaAnvandareResult->Bilder->Bild->Guid; ?>&t=CBild">					
