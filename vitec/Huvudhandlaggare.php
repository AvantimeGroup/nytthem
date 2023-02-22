<?php

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 840102;
$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
$customer_no = 840102;

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
