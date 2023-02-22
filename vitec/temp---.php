<?php
require_once('../wp-load.php');
//amacinfo_api
$links = mysqli_connect('nytthem-vitec-173404.mysql.binero.se', '173404_xh36686', 't3uytMHyDg');
mysqli_select_db($links, '173404-vitec-2017') or die('Unable to select database, Please Check Your Connection..');
$table_name = 'wp_anvandare';
$child_table_name = 'wp_child_records';

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
function process_child($p_guid, $c_guid)
{
	global $client,$licensId,$Licensnyckel,$child_table_name,$links;
	if($c_guid <> '4AABM4UVC56MRGT2' and $c_guid <> '49F3C234EUC4TH0P' and $c_guid <> '4AABLF3SU56MRCH0' and $c_guid <> '49F3C237AUC4TH0R')
	{
		// echo "in if ".$c_guid."<br>";
		$Bostadsrattslista = $client->HamtaBostadsratt(array(
			'licensid' => $licensId,
			'licensnyckel' => $Licensnyckel,
			'guid' => $c_guid
		));	

		if($Bostadsrattslista->HamtaBostadsrattResult)
		{
			$BostadRestult = $Bostadsrattslista->HamtaBostadsrattResult;
			//Check if child GUID exists, If exists check if update date is other than existing
			$check_child_guid = "SELECT child_ID,parent_ID,guid,SenastAndrad FROM `".$child_table_name."` where `guid`='".$c_guid."'";
			$child_guid_result = mysqli_query($links,$check_child_guid);
			$child_qu=false;
			$child_pre="";
			
			if ($child_guid_result->num_rows > 0)	// if exists
			{
				while($row = $child_guid_result->fetch_assoc())
				{
					$child_record_id = $row["child_ID"];
					$child_upd_date = $row["SenastAndrad"];
				}

				if($child_upd_date <> $BostadRestult->SenastAndrad)
				{
					$child_qu=true;
					$child_query_part1="UPDATE `".$child_table_name."` SET ";
					$child_query_part3="WHERE `child_ID`='".$child_record_id."'";
				}
			}
			else
			{
				$child_qu=true;
				$child_query_part1="INSERT INTO `".$child_table_name."` SET `parent_ID`='".$p_guid."'";
				$child_query_part3="";
				$child_pre=",";
			}
			foreach($BostadRestult as $bostad_key=>$bostad_val)
			{
				if($bostad_key != "Bilder")
				{
					if(is_object($bostad_val))
					{
						$child_col_val = serialize($bostad_val);
					}
					else
					{
						$child_col_val = $bostad_val;
					}
					$child_query_part2.=$child_pre." `".$bostad_key."`='".$child_col_val."'";
					$child_pre=",";
				}
			}

			if($child_qu)
			{
				// echo "<hr>";
				$final_child_query = $child_query_part1.$child_query_part2.$child_query_part3;
				mysqli_query($links, $final_child_query);
			}
			// else
			// {
				// echo "no query";
			// }
		}
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
		
		$BostadChildObject = $HamtaProjektResult->Bostadsrattslista;
		$BostadChild = $BostadChildObject->BostadsrattsLista;
		if(is_array($BostadChild) and count($BostadChild > 0))
		{
			foreach($BostadChild as $BostadGuid)
			{
				//echo "Bostad Child GUID = ".$BostadGuid->GUID."<br>";
				process_child($value->Guid,$BostadGuid->GUID);
			}
		}

		
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
							if(is_array($bilder_object_db->Bild))
							{
								$bild_image_name_db = $bilder_object_db->Bild[$k]->SenastAndrad;
							}
							else
							{
								$bild_image_name_db = $bilder_object_db->Bild->SenastAndrad;
							}

							if($bild_image_name_db <> $bild_last->SenastAndrad)
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