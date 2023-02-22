<?php 

define('WP_CACHE', false);

ini_set('max_execution_time', 0);

require_once('../wp-load.php');



//amacinfo_api

$links = mysqli_connect('nytthem-vitec-173404.mysql.binero.se', '173404_xh36686', 't3uytMHyDg');

mysqli_select_db($links, '173404-vitec-2017') or die('Unable to select database, Please Check Your Connection..');

$table_name = 'wp_vitec_succession_anvandare';

$kontakt_table_name = 'wp_vitec_succession_anvandare_kontakt_details';

$child_table_name = 'wp_vitec_succession_child_records';


require_once('lib/nusoap.php');

$url = 'http://export.capitex.se/fastighetsmaklare/Standardobjektmall/ExportV2.svc?singleWsdl';

$licensId = 13751;

$Licensnyckel = 'e93de2eb-3cdb-7c8e-fe1c-d8046e28803d';

$customer_no = 13751;



$client = new SoapClient($url);


try{
$result = $client->HamtaLista(array(
	
		'licensid' => $licensId,
        'licensnyckel' => $Licensnyckel,
        'kundnummer' => $customer_no

        ));
			
		
}catch(Exception $e){
	
	SenderrorAlarm($e->getMessage());
	echo '<pre>' ; print_r($e->getMessage());
	
}


$count = 0;		

//Virender
function SenderrorAlarm(){
	
	return;
}
function load_images($main_guid,$bild_obj,$folder){



	if((isset($bild_obj->Guid)) and isset($main_guid))

	{

		$dirpath = "../vitec_succession_guid/".$main_guid;

		$subdirpath = "../vitec_succession_guid/".$main_guid."/".$folder;

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
		//echo "<br><br>";
		//echo 'http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/img_'.$bild_obj->Guid.'.jpg';
		
		 if(!file_exists($dirpath.'/img_'.$bild_obj->Guid.'.jpg'))
		{

			copy('http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/img_'.$bild_obj->Guid.'.jpg');
			
			$source_path = $dirpath.'/img_'.$bild_obj->Guid.'.jpg';
			$destination_path = $dirpath.'/img_'.$bild_obj->Guid.'_lowres.jpg';
			$compp = compress_image($source_path, $destination_path, 90);

		} 

	}

}
// to compress images
function compress_image($source_url, $destination_url, $quality) {
	$info = getimagesize($source_url);
 
	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
 
	//save it
	imagejpeg($image, $destination_url, $quality);
 
	//return destination file url
	return $destination_url;
}

function load_kontact_images($main_guid,$bild_obj,$folder){



	if((isset($bild_obj->Guid)) and isset($main_guid))
	{
		$dirpath = "../vitec_succession_guid/".$folder;

		//echo "<br><br>";
		//echo 'http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/img_'.$bild_obj->Guid.'.jpg';
		if(!file_exists($dirpath.'/'.$bild_obj->Guid.'.jpg'))
		{

			copy('http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$bild_obj->Guid.'&t=CBild', $dirpath.'/'.$bild_obj->Guid.'.jpg');
			$source_path = $dirpath.'/'.$bild_obj->Guid.'.jpg';
			$destination_path = $dirpath.'/'.$bild_obj->Guid.'_lowres.jpg';
			$compp = compress_image($source_path, $destination_path, 90);

		}

	}

}


function load_files($url,$main_guid,$child_guid,$filerGuid,$folder){

	if((isset($child_guid)) and isset($main_guid))

	{

		$dirpath = "../vitec_succession_guid/".$main_guid."/".$child_guid;

		$subdirpath = "../vitec_succession_guid/".$main_guid."/".$child_guid."/".$folder;

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
		
		if(!file_exists($dirpath.'/pdf_'.$filerGuid.'.pdf'))

		{

			@copy( $url , $dirpath.'/pdf_'.$filerGuid.'.pdf');
			
		}

	}

} 

function load_images_child_bilder($url,$main_guid,$child_guid,$Guid,$folder){

	if((isset($child_guid)) and isset($main_guid))

	{
		//echo $dirpath = "../vitec_succession_guid/".$main_guid."/".$child_guid;
		$dirpath = "../vitec_succession_guid/".$main_guid."/".$child_guid;

		$subdirpath = "../vitec_succession_guid/".$main_guid."/".$child_guid."/".$folder;

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
		 if(!file_exists($dirpath.'/img_'.$Guid.'.jpg'))

		{

		@copy( $url , $dirpath.'/img_'.$Guid.'.jpg');
			
		$source_path = $dirpath.'/img_'.$Guid.'.jpg';
		$destination_path = $dirpath.'/img_'.$Guid.'_lowres.jpg';
		$compp = compress_image($source_path, $destination_path, 90);
			
		}

	}

}


function process_child($p_guid, $c_guid)

{
	
	global $client,$licensId,$Licensnyckel,$child_table_name,$links;
		
		try{
		$Bostadsrattslista = $client->HamtaBostadsratt(array(

			'licensid' => $licensId,

			'licensnyckel' => $Licensnyckel,

			'guid' => $c_guid

		));	
		}catch(Exception $e){
	
			SenderrorAlarm($e->getMessage());
			echo $c_guid ; echo '<br>';
			echo '<pre>' ; print_r($e->getMessage());
			
		}
		

		if($Bostadsrattslista->HamtaBostadsrattResult)

		{

			$BostadRestult = $Bostadsrattslista->HamtaBostadsrattResult;

			//Check if child GUID exists, If exists check if update date is other than existing

			$check_child_guid = "SELECT child_ID,parent_ID,guid,SenastAndrad,bilder FROM `".$child_table_name."` where `Guid`='".$c_guid."'";

			$child_guid_result = mysqli_query($links,$check_child_guid);

			$child_qu=false;

			$child_pre="";

			$bilder_object_dbb = "";
			
			if ($child_guid_result->num_rows > 0)	// if exists

			{

				while($row = $child_guid_result->fetch_assoc())

				{

					$child_record_id = $row["child_ID"];

					$child_upd_date = $row["SenastAndrad"];
					
					$bilder_object_dbb = unserialize($row["bilder"]);

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
			
			/* echo '<pre>';
			print_r($BostadRestult);
			echo '</pre>'; */
			
			/* echo '<pre>';
			print_r($bilder_object_dbb);
			echo '</pre>'; */

   			foreach($BostadRestult as $bostad_key=>$bostad_val)
			{
				
				if($bostad_key=='Bostadsrattsforening'  || $bostad_key=='BostadsrattsforeningInformation' || $bostad_key=='BudgivningInternet'
					 || $bostad_key=='Byggnad'  || $bostad_key=='Byteskrav'  || $bostad_key=='Driftkostnad'
					  || $bostad_key=='Energideklaration' || $bostad_key == "Etapp"
					  || $bostad_key=='Fastighetsbeteckning' 
					  || $bostad_key=='FritextTilltradesdag' || $bostad_key=='GemensammaUtrymmen'
					  || $bostad_key=='GemensamtUtrymme'
					  || $bostad_key=='Husnummer'
					  || $bostad_key=='Hustyp'
					  || $bostad_key=='Huvudhandlaggare'
					  || $bostad_key=='Internetanslutning'
					  || $bostad_key=='Internetinstallningar'
					  || $bostad_key=='Kommun'
					  || $bostad_key=='Kontor'
					  || $bostad_key=='Kontrakt'
					  || $bostad_key=='EgnaFalt'
					  || $bostad_key=='KoparePerson' || $bostad_key=='LagenhetsnummerForFolkbokforing' || $bostad_key=='Lan' || $bostad_key=='Lankar' 
					  || $bostad_key=='ListaVisning'
					  || $bostad_key=='Ovrigt' || $bostad_key=='Parkering' || $bostad_key=='PersonligaVisningar'|| $bostad_key=='Planlosning'|| $bostad_key=='OvrigaHandlaggare'|| $bostad_key=='RumsbeskrivningTvattutrymme'|| $bostad_key=='RumsbeskrivningGrund'|| $bostad_key=='RumsbeskrivningHygien'|| $bostad_key=='RumsbeskrivningKok'|| $bostad_key=='SaljareForetag'|| $bostad_key=='SaljarePerson'|| $bostad_key=='Tvanslutning'|| $bostad_key=='Upplatelse'|| $bostad_key=='Byggnadstyp'){
					
					continue;
					
					}
						
				
				if($bostad_key=='Adress'  || $bostad_key=='Vagbeskrivning' || $bostad_key=='Projektnamn'
					 || $bostad_key=='RumsbeskrivningFritext'  || $bostad_key=='Beskrivning'  || $bostad_key=='Visningar'
					  || $bostad_key=='SaljandeBeskrivningar' || $bostad_key == "Filer"
					  || $bostad_key=='Lagenhetsnummer' 
					  || $bostad_key=='Rum' || $bostad_key=='Hiss'
					  || $bostad_key=='Vaningsplan'
					  || $bostad_key=='Manadsavgift'
					  || $bostad_key=='Status'
					  || $bostad_key=='Guid'
					  || $bostad_key=='Byggnadstyp'
					  || $bostad_key=='Objekttyp'
					  || $bostad_key=='Filer'
					  || $bostad_key=='EgnaFalt'
					  || $bostad_key=='BalkongOchUteplats'
					  || $bostad_key=='PrisAnbudTillval'
					  || $bostad_key=='Bilder' || $bostad_key=='Utgangspris' || $bostad_key=='Uteplats' || $bostad_key=='Upplatelseform' 
					  || $bostad_key=='Upplatelse'
					  || $bostad_key=='Tvanslutning'
					  )
				
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
				
				
					if($bostad_key=="Filer")
					{
						
						$bostad_val1 = maybe_unserialize($bostad_val->Fil);
						
					 	if(is_array($bostad_val1))
						{
							
							foreach($bostad_val1 as $filer)	
							{
								$url = 'http://fastighet.capitex.se/'.$filer->Url;		
								load_files($url,$p_guid,$c_guid,$filer->Guid,"filer");
							}
						}
						else {
								$url = 'http://fastighet.capitex.se/'.$bostad_val1->Url;		
								load_files($url,$p_guid,$c_guid,$filer->Guid,"filer");
						}	 					

					}
					
					if($bostad_key=="Bilder")

						{

							foreach($bostad_val as $bild=>$bilds)

							{
								
								if(is_array($bilds))

								{

									foreach($bilds as $k=>$bild_last)

									{
												
										if(is_array($bilder_object_dbb->Bild))

										{
										//	echo 'processing2';
											$bild_image_name_dbb = $bilder_object_dbb->Bild[$k]->SenastAndrad;
											
										}

										else

										{
										//	echo 'processing1';
											$bild_image_name_dbb = $bilder_object_dbb->Bild->SenastAndrad;

										}
										$child_dir_path = "../vitec_succession_guid/".$p_guid."/".$c_guid."/bilder";
		
										
										if($bild_image_name_dbb <> $bild_last->SenastAndrad || !file_exists($child_dir_path.'/img_'.$bild_last->Guid.'.jpg'))

										{ 
										//	echo 'processing';
											$url = 'http://fastighet.capitex.se/'.$bild_last->Url;		
											load_images_child_bilder($url,$p_guid,$c_guid,$bild_last->Guid,"bilder");
										}									
										
									}
								}

								else

								{
										$child_dir_path = "../vitec_succession_guid/".$p_guid."/".$c_guid."/bilder";
										 if($bilder_object_db->Bild->SenastAndrad <> $bilds->SenastAndrad || !file_exists($child_dir_path.'/img_'.$bilds->Guid.'.jpg'))

										{	//echo 'processing3';
											$url = 'http://fastighet.capitex.se/'.$bilds->Url;		
											load_images_child_bilder($url,$p_guid,$c_guid,$bilds->Guid,"bilder");

										} 

								}

							}

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


$dbmain = "";
$dbbosted = "";


foreach ($result->HamtaListaResult->ObjektUppdateringsinfo as $key => $value) {
	$query_part1 = '';
	$query_part2 = '';
	$query_part3 = '';
	

  /*   if($value->Guid != "4L2QEU9M8P1GJBS1"){
		
		
		continue;
		
	}
 */
	// if($value->Typ == 'CMNyprod')
	if($value->Typ == 'CMNyProd' || $value->Typ == 'CMNyprod')

	{
		
		$guid_array[] = $value->Guid;

		try{
			$result = $client->HamtaProjekt(array(

				'licensid' => $value->KundNr,

				'licensnyckel' => $Licensnyckel,

				'guid' => $value->Guid 

			));
			
		}catch(Exception $e){
	
			SenderrorAlarm($e->getMessage());
			echo $value->Guid ; echo '<br>';
			echo '<pre>' ; print_r($e->getMessage());
			
		}
		$dbmain.="'".$value->Guid."',";
			
		$HamtaProjektResult = $result->HamtaProjektResult;
		
		$BostadChildObject = $HamtaProjektResult->Bostadsrattslista;

		$BostadChild = $BostadChildObject->BostadsrattsLista;

		



		

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
	//echo "<pre>"; print_r($HamtaProjektResult);
		foreach($HamtaProjektResult as $key=>$val)

		{

			/// save images of project

			if($key=="Kontor" || $key=="EgnaFalt" || $key=="ForstaOverforing" || $key=="FritextSalj" || $key=="Publiceringsdatum" || $key=="Tilltrade" || $key=="UtlandskaSaljandeBeskrivningar"){
				
				continue;
				
			}
			
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

							 $dir_path = "../vitec_succession_guid/".$HamtaProjektResult->GUID;
							 
						if($bild_image_name_db <> $bild_last->SenastAndrad || !file_exists($dir_path.'/img_'.$bild_last->Guid.'.jpg'))

							{ 
								try{
									
								load_images($HamtaProjektResult->GUID,$bild_last,"");
								
								}catch(Exception $e){
									
									SenderrorAlarm($e->getMessage());
									echo $HamtaProjektResult->GUID ; echo '<br>';
									echo '<pre>' ; print_r($e->getMessage());
									
								}

							}

						}



					}

					else

					{
						$dir_path = "../vitec_succession_guid/".$HamtaProjektResult->GUID;
					 	if($bilder_object_db->Bild->SenastAndrad <> $bilds->SenastAndrad || !file_exists($dir_path.'/img_'.$bilds->Guid.'.jpg'))

						{
							try{
							load_images($HamtaProjektResult->GUID,$bilds,"");
							}catch(Exception $e){
								SenderrorAlarm($e->getMessage());
								echo $HamtaProjektResult->GUID; echo '<br>';
								echo '<pre>' ; print_r($e->getMessage());
							}
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
					try{
						
					$result_again = $client->HamtaAnvandare(array(

						'licensid' => $customer_no,

						'licensnyckel' => $Licensnyckel,

						'guid' => $hu_guid

					));	
					
					}catch(Exception $e){
	
						SenderrorAlarm($e->getMessage());
						echo $hu_guid ; echo '<br>';
						echo '<pre>' ; print_r($e->getMessage());
						
					}

					//echo '<pre>' ; print_r($result_again) ; 
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

								try{	
								
								load_kontact_images($HamtaProjektResult->GUID,$kon_bilds_val,"kontact");
								
								}catch(Exception $e){
	
									SenderrorAlarm($e->getMessage());
									echo $HamtaProjektResult->GUID;  echo '<br>';
									echo '<pre>' ; print_r($e->getMessage());
								}
							
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

						
						$check_kontact_guid = "SELECT guid,senastandrad FROM  `".$kontakt_table_name."` where `guid`='".$hu_guid."'";
					
						$kontact_result = mysqli_query($links,$check_kontact_guid);
						
						if ($kontact_result->num_rows > 0)
						{
							while($row = $kontact_result->fetch_assoc())
							{
							  $kontact_date = $row["senastandrad"];

							}
							if($kontact_date <>  $kontact_details->SenastAndrad)

							{
								$kontakt_query = "UPDATE `".$kontakt_table_name."` SET `kontaktdetails`='".$kontakt_info."' where `guid`='".$hu_guid."'";
								mysqli_query($links, $kontakt_query);
							}
						}else{
							
								$kontakt_query = "INSERT INTO `".$kontakt_table_name."` SET `kontaktdetails`='".$kontakt_info."',`guid`='".$hu_guid."',`senastandrad`='".$kontact_details->SenastAndrad."',`type`='".$key."'";
								mysqli_query($links, $kontakt_query);
							
						} 

						$query_part2.=$pre." `kontaktdetails`='".$kontakt_info."'";

						$pre=",";

					}

				}

			}
			if($key=="Handlaggare2")

			{

				$hu_obj = $val->Handlaggare2;

				$hu_guid = $hu_obj->GUID;

				// if($hu_guid != "")

				if($hu_guid != "" and $hu_guid != "4693O4BD7J602ME5" )

				{
					try{
						
					$result_again = $client->HamtaAnvandare(array(

						'licensid' => $customer_no,

						'licensnyckel' => $Licensnyckel,

						'guid' => $hu_guid

					));	
					
					}catch(Exception $e){
	
						SenderrorAlarm($e->getMessage());
						echo $hu_guid ; echo '<br>';
						echo '<pre>' ; print_r($e->getMessage());
						
					}
						 
					//echo "<pre>"; print_r($result_again); 


					$kontact_details = null;

					if(isset($result_again->HamtaAnvandareResult))

						$kontact_details = $result_again->HamtaAnvandareResult;

					$rtrn2 = "";

					$kontakt_info = "";

					if($kontact_details)

					{

						$kon_bilder_obj = $kontact_details->Bilder;



						 foreach($kon_bilder_obj as $kon_bild_key=>$kon_bilds_val)

						{

								try{	
								
								load_kontact_images($HamtaProjektResult->GUID,$kon_bilds_val,"kontact");
								
								}catch(Exception $e){
	
									SenderrorAlarm($e->getMessage());
									echo $HamtaProjektResult->GUID ; echo '<br>';
									echo '<pre>' ; print_r($e->getMessage());
								}
							

						} 

						

						$rtrn2['kon_bild'] = $kon_bilds_val->Guid;

						$rtrn2['kon_befattning'] = $kontact_details->Befattning;

						$rtrn2['kon_namn'] = $kontact_details->Namn;

						

						$kon_epost_obj = $kontact_details->Epost;

						$rtrn2['kon_epost'] = $kon_epost_obj->Epostadress;

						

						$kon_telefon_mbl = $kontact_details->TelefonMobil;

						$kon_telefon_drkt = $kontact_details->TelefonDirekt;

						

						$rtrn2['kon_telefon'] = $kon_telefon_mbl?$kon_telefon_mbl:$kon_telefon_drkt;

						$kontakt_info = serialize($rtrn2);

						$check_kontact_guid = "SELECT guid,senastandrad FROM  `".$kontakt_table_name."` where `guid`='".$hu_guid."'";
					
						$kontact_result = mysqli_query($links,$check_kontact_guid);
						
						if ($kontact_result->num_rows > 0)
						{
							while($row = $kontact_result->fetch_assoc())
							{
							  $kontact_date = $row["senastandrad"];

							}
							if($kontact_date <>  $kontact_details->SenastAndrad)

							{
								$kontakt_query = "UPDATE `".$kontakt_table_name."` SET `kontaktdetails`='".$kontakt_info."' where `guid`='".$hu_guid."'";
								mysqli_query($links, $kontakt_query);
							}
						}else{
							
								$kontakt_query = "INSERT INTO `".$kontakt_table_name."` SET `kontaktdetails`='".$kontakt_info."',`guid`='".$hu_guid."',`senastandrad`='".$kontact_details->SenastAndrad."',`type`='".$key."'";
								mysqli_query($links, $kontakt_query);
							
						}

						$query_part2.=$pre." `kontaktdetails2`='".$kontakt_info."'";

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
		
			if(is_array($BostadChild) and count($BostadChild > 0))

			{

				foreach($BostadChild as $BostadGuid)
				{

					$dbbosted.="'".$BostadGuid->GUID."',";
					echo "<br><br>";
					echo "Bostad Child GUID = ".$BostadGuid->GUID."<br>";
					try{
						
					process_child($value->Guid,$BostadGuid->GUID);
					
					}catch(Exception $e){
	
									SenderrorAlarm($e->getMessage());
									echo $value->Guid ; echo '<br>';
									echo '<pre>' ; print_r($e->getMessage());
					}

				}

			}

			else {
				
				if(!empty($BostadChildObject->BostadsrattsLista->GUID))
				{	
					$dbbosted.="'".$BostadChildObject->BostadsrattsLista->GUID."',";
					echo "<br><br>";
					
					echo "Bostad Child GUID = ".$BostadChildObject->BostadsrattsLista->GUID."<br>";
					
					try{
					
					process_child($value->Guid,$BostadChildObject->BostadsrattsLista->GUID);
					
					}catch(Exception $e){
	
									SenderrorAlarm($e->getMessage());
									echo $value->Guid ;  echo '<br>' ; 
									echo '<pre>' ; print_r($e->getMessage());
								
					}
				}
			}	

		if($qu)

		{

			$final_query = $query_part1.$query_part2.$query_part3;
				print_r($final_query);
				echo '<br/><br/>------------------------------------------';
			mysqli_query($links, $final_query);

		}

	}

}

if(!empty($dbbosted))
{
	$dbbosted=rtrim($dbbosted,',');
	echo $rows_all = "delete FROM  `".$child_table_name."` where `Guid` not in (".$dbbosted.")";
	mysqli_query($links,$rows_all);
} 

if(!empty($dbmain))
{
 $dbmain=rtrim($dbmain,',');
 echo $rows_all = "delete FROM  `".$table_name."` where `guid` not in (".$dbmain.")"; 
 mysqli_query($links,$rows_all);
}

