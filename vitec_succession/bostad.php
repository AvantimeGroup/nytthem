<?php



require_once('../wp-load.php');



//amacinfo_api



$links = mysqli_connect('nytthem-vitec-173404.mysql.binero.se', '173404_xh36686', 't3uytMHyDg');



mysqli_select_db($links, '173404-vitec-2017') or die('Unable to select database, Please Check Your Connection..');



$table_name = 'wp_vitec_succession_anvandare';







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

	$kemm_array = array();

	

	

	$Bostadsrattslista = $client->HamtaBostadsratt(array(

				'licensid' => $licensId,

				'licensnyckel' => $Licensnyckel,

				'guid' => '49F3C234EUC4TH0P'

			));	

    

	echo "<pre>";

	print_r($Bostadsrattslista);

	echo "</pre>";

	

	foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {

		

		if($value->Typ == 'CMNyProd' || $value->Typ == 'CMNyprod')

		{		

			$result_again = $client->HamtaProjekt(array(

				'licensid' => $value->KundNr,

				'licensnyckel' => $Licensnyckel,

				'guid' => $value->Guid

			));				

				

			echo "<pre>";

			print_r($result_again);

			echo "</pre>"; 

			

			/* foreach ($result_again->HamtaProjektResult->Bostadsrattslista->Bostadsrattslista as $key_bild => $value_bild) {

					  //echo $value_bild->GUID.'<br/>';	

					  $kemm_array[] = $value_bild->GUID ;

			} */

		}		

    }



	/* array_unique($kemm_array);



	echo "<pre>";

	print_r($kemm_array);

	echo "</pre>";

	

	foreach ($kemm_array as $kemm_array)

	{

			$result_again = $client->HamtaAnvandare(array(

				'licensid' => $value->KundNr,

				'licensnyckel' => $Licensnyckel,

				'guid' => $kemm_array

			));	

			 

			echo '<pre>';

			print_r($result_again);		

	} */

	

} catch (Exception $e) {

    var_dump($e->GetMessage());

}