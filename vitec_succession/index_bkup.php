<?php
require_once('../wp-load.php');
//amacinfo_api
$links = mysqli_connect('nytthem-vitec-173404.mysql.binero.se', '173404_xh36686', 't3uytMHyDg');
mysqli_select_db($links, '173404-vitec-2017') or die('Unable to select database, Please Check Your Connection..');
$table_name = 'wp_anvandare';

require_once('lib/nusoap.php');
$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';
$licensId = 840102;
$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';
$customer_no = 840102;

$client = new SoapClient($url);

$result = $client->HamtaLista(array(
    'licensId' => $licensId,
    'licensNyckel' => $Licensnyckel,
    'kundnummer' => $customer_no
        ));
$count = 0;		

function load_images($main_guid,$bild_obj,$folder){

	if((isset($bild_obj->Guid)) and isset($main_guid))
	{
		$dirpath = "../GUID/".$main_guid;
		$subdirpath = "../GUID/".$main_guid."/".$folder;
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777);
		}
		if($folder <>"")
		{
			if (!is_dir($subdirpath)) {
				mkdir($subdirpath, 0777);
			}
			$dirpath = $subdirpath; 
		}
		if(!file_exists($dirpath.'/img_'.$bild_obj->Guid.'.jpg'))
		{
			copy('http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/img_'.$bild_obj->Guid.'.jpg');
		}
	}
}
function load_images2($main_guid,$bild_obj){
	if((isset($bild_obj->Guid)) and isset($main_guid))
	{
		$dirpath = "../GUID/".$main_guid;
		$mode = "0777";
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777);
		}

		copy('http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/img_'.$bild_obj->Guid.'.jpg');
	}
}
foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
    
	// if($value->Typ == 'CMNyprod')
	if($value->Typ == 'CMNyProd' || $value->Typ == 'CMNyprod')
	{
		$result = $client->HamtaProjekt(array(
			'licensid' => $value->KundNr,
			'licensnyckel' => $Licensnyckel,
			'guid' => $value->Guid 
		));
		$HamtaProjektResult = $result->HamtaProjektResult;
// echo "<pre>";
// print_r($HamtaProjektResult);
// echo "</pre>";

		
		//Check if GUID exists, If exists check if update date is other than existing
		$check_guid = "SELECT anvandare_id,guid,senastandrad,bilder FROM  `".$table_name."` where `guid`='".$value->Guid."'";

		$qu=false;
		$bilder_object_db="";
		$guid_result = mysqli_query($links,$check_guid);
		if ($guid_result->num_rows > 0)
		{
			while($row = $guid_result->fetch_assoc())
			{
				$anv_id = $row["anvandare_id"];
				$upd_date = $row["senastandrad"];
				$bilder_object_db = unserialize($row["bilder"]);
			}
			if($upd_date <> $HamtaProjektResult->SenastAndrad)
			{
				$qu=true;
				$query_part1="UPDATE `".$table_name."` SET ";
				$query_part3="WHERE `anvandare_id`='".$anv_id."'";
			}
		}
		else
		{
			$qu=true;
			$query_part1="INSERT INTO `".$table_name."` SET ";
			$query_part3="";
		}
		
		
		$pre="";
		$query_part2="";
		foreach($HamtaProjektResult as $key=>$val)
		{
			/// save images of project
			if($key=="Bilder")
			{
				foreach($val as $bild=>$bilds)
				{
					if(is_array($bilds))
					{
						foreach($bilds as $k=>$bild_last)
						{
							if($bilder_object_db->Bild[$k]->SenastAndrad <> $bild_last->SenastAndrad)
							{
								load_images($HamtaProjektResult->GUID,$bild_last,"");
							}
						}

					}
					else
					{
						if($bilder_object_db->Bild->SenastAndrad <> $bilds->SenastAndrad)
						{
							load_images($HamtaProjektResult->GUID,$bilds,"");
						}
					}
				}
			}
			
			/// save image for kontakt details
			if($key=="Huvudhandlaggare")
			{
				$hu_obj = $val->Huvudhandlaggare;
				$hu_guid = $hu_obj->GUID;
				// if($hu_guid != "")
				if($hu_guid != "" and $hu_guid != "4693O4BD7J602ME5" )
				{
					$result_again = $client->HamtaAnvandare(array(
						'licensid' => $customer_no,
						'licensnyckel' => $Licensnyckel,
						'guid' => $hu_guid
					));	

					$kontact_details = null;
					if(isset($result_again->HamtaAnvandareResult))
						$kontact_details = $result_again->HamtaAnvandareResult;
					
					$rtrn = "";
					$kontakt_info = "";
					if($kontact_details)
					{
						$kon_bilder_obj = $kontact_details->Bilder;

						foreach($kon_bilder_obj as $kon_bild_key=>$kon_bilds_val)
						{
							/*if(is_array($kon_bilds_val))
							{
								echo "in if";
								die;
								// foreach($kon_bilds_val as $kon_bilds_val_last)
								// {
									// load_images($HamtaProjektResult->GUID,$kon_bilds_val,"kontact");
								// }
							}
							else
							{*/
								load_images($HamtaProjektResult->GUID,$kon_bilds_val,"kontact");
							/*}*/
						}
						
						$rtrn['kon_bild'] = $kon_bilds_val->Guid;
						$rtrn['kon_befattning'] = $kontact_details->Befattning;
						$rtrn['kon_namn'] = $kontact_details->Namn;
						
						$kon_epost_obj = $kontact_details->Epost;
						$rtrn['kon_epost'] = $kon_epost_obj->Epostadress;
						
						$kon_telefon_mbl = $kontact_details->TelefonMobil;
						$kon_telefon_drkt = $kontact_details->TelefonDirekt;
						
						$rtrn['kon_telefon'] = $kon_telefon_mbl?$kon_telefon_mbl:$kon_telefon_drkt;
						$kontakt_info = serialize($rtrn);
						
						$query_part2.=$pre." `kontaktdetails`='".$kontakt_info."'";
						$pre=",";
					}
				}
			}
			
			if(is_object($val))
			{
				$col_val = serialize($val);
			}
			else
			{
				$col_val = $val;
			}
			$query_part2.=$pre." `".$key."`='".$col_val."'";
			$pre=",";
		}
		if($qu)
		{
			$final_query = $query_part1.$query_part2.$query_part3;
			mysqli_query($links, $final_query);
		}
	}
}