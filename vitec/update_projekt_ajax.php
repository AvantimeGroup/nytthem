<?php 

define('WP_CACHE', false);

ini_set('max_execution_time', 0);

require_once('../wp-load.php');

if(isset($_REQUEST['token']) && $_REQUEST['token'] == "k1evzAVAtvLysb2CtSPj"){       //if token set

	$links = mysqli_connect('localhost', 'virendervitect', 't3uytMHyDg');

	mysqli_select_db($links, 'nytthem_vitec') or die('Unable to select database, Please Check Your Connection..');

	$table_name = 'wp_anvandare';

	$kontakt_table_name = 'wp_anvandare_kontakt_details';

	$child_table_name = 'wp_child_records_new';


	require_once('lib/nusoap.php');

	$url = 'http://export.capitex.se/Nyprod/Standard/Export.svc?singleWsdl';

	$licensId = 840102;

	$Licensnyckel = '04e6cad5-e6fa-861f-11bd-5a1aecec37ae';

	$customer_no = 840102;



	$client = new SoapClient($url);


	try{
	$result = $client->HamtaLista(array(

		'licensId' => $licensId,

		'licensNyckel' => $Licensnyckel,

		'kundnummer' => $customer_no

			));
	}catch(Exception $e){
		
		SenderrorAlarm($e->getMessage());
		// echo '<pre>' ; print_r($e->getMessage());
		
	}
	$count = 0;		

	//Virender

	function SenderrorAlarm($message){
			
	$mail_content = '
	<html>
	  <head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Simple Transactional Email</title>
		<style>
		  /* -------------------------------------
			  GLOBAL RESETS
		  ------------------------------------- */
		  img {
			border: none;
			-ms-interpolation-mode: bicubic;
			max-width: 100%; }

		  body {
			background-color: #f6f6f6;
			font-family: sans-serif;
			-webkit-font-smoothing: antialiased;
			font-size: 14px;
			line-height: 1.4;
			margin: 0;
			padding: 0;
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%; }

		  table {
			border-collapse: separate;
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
			width: 100%; }
			table td {
			  font-family: sans-serif;
			  font-size: 14px;
			  vertical-align: top; }

		  /* -------------------------------------
			  BODY & CONTAINER
		  ------------------------------------- */

		  .body {
			background-color: #f6f6f6;
			width: 100%; }

		  /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		  .container {
			display: block;
			Margin: 0 auto !important;
			/* makes it centered */
			max-width: 580px;
			padding: 10px;
			width: 580px; }

		  /* This should also be a block element, so that it will fill 100% of the .container */
		  .content {
			box-sizing: border-box;
			display: block;
			Margin: 0 auto;
			max-width: 580px;
			padding: 10px; }

		  /* -------------------------------------
			  HEADER, FOOTER, MAIN
		  ------------------------------------- */
		  .main {
			background: #ffffff;
			border-radius: 3px;
			width: 100%; }

		  .wrapper {
			box-sizing: border-box;
			padding: 20px; }

		  .content-block {
			padding-bottom: 10px;
			padding-top: 10px;
		  }

		  .footer {
			clear: both;
			Margin-top: 10px;
			text-align: center;
			width: 100%; }
			.footer td,
			.footer p,
			.footer span,
			.footer a {
			  color: #999999;
			  font-size: 12px;
			  text-align: center; }

		  /* -------------------------------------
			  TYPOGRAPHY
		  ------------------------------------- */
		  h1,
		  h2,
		  h3,
		  h4 {
			color: #000000;
			font-family: sans-serif;
			font-weight: 400;
			line-height: 1.4;
			margin: 0;
			Margin-bottom: 30px; }

		  h1 {
			font-size: 35px;
			font-weight: 300;
			text-align: center;
			text-transform: capitalize; }

		  p,
		  ul,
		  ol {
			font-family: sans-serif;
			font-size: 14px;
			font-weight: normal;
			margin: 0;
			Margin-bottom: 15px; }
			p li,
			ul li,
			ol li {
			  list-style-position: inside;
			  margin-left: 5px; }

		  a {
			color: #3498db;
			text-decoration: underline; }

		  /* -------------------------------------
			  BUTTONS
		  ------------------------------------- */
		  .btn {
			box-sizing: border-box;
			width: 100%; }
			.btn > tbody > tr > td {
			  padding-bottom: 15px; }
			.btn table {
			  width: auto; }
			.btn table td {
			  background-color: #ffffff;
			  border-radius: 5px;
			  text-align: center; }
			.btn a {
			  background-color: #ffffff;
			  border: solid 1px #3498db;
			  border-radius: 5px;
			  box-sizing: border-box;
			  color: #3498db;
			  cursor: pointer;
			  display: inline-block;
			  font-size: 14px;
			  font-weight: bold;
			  margin: 0;
			  padding: 12px 25px;
			  text-decoration: none;
			  text-transform: capitalize; }

		  .btn-primary table td {
			background-color: #3498db; }

		  .btn-primary a {
			background-color: #3498db;
			border-color: #3498db;
			color: #ffffff; }

		  /* -------------------------------------
			  OTHER STYLES THAT MIGHT BE USEFUL
		  ------------------------------------- */
		  .last {
			margin-bottom: 0; }

		  .first {
			margin-top: 0; }

		  .align-center {
			text-align: center; }

		  .align-right {
			text-align: right; }

		  .align-left {
			text-align: left; }

		  .clear {
			clear: both; }

		  .mt0 {
			margin-top: 0; }

		  .mb0 {
			margin-bottom: 0; }

		  .preheader {
			color: transparent;
			display: none;
			height: 0;
			max-height: 0;
			max-width: 0;
			opacity: 0;
			overflow: hidden;
			mso-hide: all;
			visibility: hidden;
			width: 0; }

		  .powered-by a {
			text-decoration: none; }

		  hr {
			border: 0;
			border-bottom: 1px solid #f6f6f6;
			Margin: 20px 0; }

		  /* -------------------------------------
			  RESPONSIVE AND MOBILE FRIENDLY STYLES
		  ------------------------------------- */
		  @media only screen and (max-width: 620px) {
			table[class=body] h1 {
			  font-size: 28px !important;
			  margin-bottom: 10px !important; }
			table[class=body] p,
			table[class=body] ul,
			table[class=body] ol,
			table[class=body] td,
			table[class=body] span,
			table[class=body] a {
			  font-size: 16px !important; }
			table[class=body] .wrapper,
			table[class=body] .article {
			  padding: 10px !important; }
			table[class=body] .content {
			  padding: 0 !important; }
			table[class=body] .container {
			  padding: 0 !important;
			  width: 100% !important; }
			table[class=body] .main {
			  border-left-width: 0 !important;
			  border-radius: 0 !important;
			  border-right-width: 0 !important; }
			table[class=body] .btn table {
			  width: 100% !important; }
			table[class=body] .btn a {
			  width: 100% !important; }
			table[class=body] .img-responsive {
			  height: auto !important;
			  max-width: 100% !important;
			  width: auto !important; }}

		  /* -------------------------------------
			  PRESERVE THESE STYLES IN THE HEAD
		  ------------------------------------- */
		  @media all {
			.ExternalClass {
			  width: 100%; }
			.ExternalClass,
			.ExternalClass p,
			.ExternalClass span,
			.ExternalClass font,
			.ExternalClass td,
			.ExternalClass div {
			  line-height: 100%; }
			.apple-link a {
			  color: inherit !important;
			  font-family: inherit !important;
			  font-size: inherit !important;
			  font-weight: inherit !important;
			  line-height: inherit !important;
			  text-decoration: none !important; }
			.btn-primary table td:hover {
			  background-color: #34495e !important; }
			.btn-primary a:hover {
			  background-color: #34495e !important;
			  border-color: #34495e !important; } }

		</style>
	  </head>
	  <body class="">
		<table border="0" cellpadding="0" cellspacing="0" class="body">
		  <tr>
			<td>&nbsp;</td>
			<td class="container">
			  <div class="content">

				<!-- START CENTERED WHITE CONTAINER -->
				<table class="main">
					<!-- START MAIN CONTENT AREA -->
				  <tr>
					<td class="wrapper">
					  <table border="0" cellpadding="0" cellspacing="0">
						<tr>
						  <td>
							<p>'.$message.'</p>
						  </td>
						</tr>
					  </table>
					</td>
				  </tr>

			   
				</table>
			
			  </div>
			</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </body>
	</html>';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <no-reply@nytthem.se>' . "\r\n";
	//mail('Chisburg@gmail.com','Error Alarm',$mail_content,$headers);
		
	}
	//Virender

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
			$dirpath = "../GUID/".$folder;

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

			$dirpath = "../GUID/".$main_guid."/".$child_guid;

			$subdirpath = "../GUID/".$main_guid."/".$child_guid."/".$folder;

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
			//echo $dirpath = "../GUID/".$main_guid."/".$child_guid;
			$dirpath = "../GUID/".$main_guid."/".$child_guid;

			$subdirpath = "../GUID/".$main_guid."/".$child_guid."/".$folder;

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
				/* echo $c_guid ; echo '<br>';
				echo '<pre>' ; print_r($e->getMessage()); */
				
			}
			

			if($Bostadsrattslista->HamtaBostadsrattResult)

			{

				$BostadRestult = $Bostadsrattslista->HamtaBostadsrattResult;

				//Check if child GUID exists, If exists check if update date is other than existing

				$check_child_guid = "SELECT child_ID,parent_ID,guid,SenastAndrad,bilder,BostadsrattsforeningInformation FROM `".$child_table_name."` where `Guid`='".$c_guid."'";

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
						
						$bostadsrattsforeningchild = unserialize($row["BostadsrattsforeningInformation"]);
						
						$bilder_object_dbb = unserialize($row["bilder"]);

					}



					if($child_upd_date <> $BostadRestult->SenastAndrad || (isset($bostadsrattsforeningchild->DateChanged) && isset($BostadRestult->BostadsrattsforeningInformation->DateChanged) && $bostadsrattsforeningchild->DateChanged <> $BostadRestult->BostadsrattsforeningInformation->DateChanged))

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
					
					if($bostad_key=='BudgivningInternet'   || $bostad_key=='Byggnad'  || $bostad_key=='Byteskrav'  
						  || $bostad_key=='Energideklaration' || $bostad_key == "Etapp"
						  || $bostad_key=='Fastighetsbeteckning' 
						  || $bostad_key=='FritextTilltradesdag' || $bostad_key=='GemensammaUtrymmen'
						  || $bostad_key=='GemensamtUtrymme'
						  || $bostad_key=='Husnummer'
						  || $bostad_key=='Hustyp'
						  || $bostad_key=='Huvudhandlaggare'
						  || $bostad_key=='Internetanslutning'
						  || $bostad_key=='Internetinstallningar'
						  || $bostad_key=='Kontor'
						  || $bostad_key=='KoparePerson' || $bostad_key=='LagenhetsnummerForFolkbokforing' || $bostad_key=='Lan' || $bostad_key=='Lankar' 
						  || $bostad_key=='ListaVisning'
						  || $bostad_key=='Ovrigt' || $bostad_key=='Parkering' || $bostad_key=='PersonligaVisningar'|| $bostad_key=='OvrigaHandlaggare'|| $bostad_key=='RumsbeskrivningTvattutrymme'|| $bostad_key=='RumsbeskrivningGrund'|| $bostad_key=='RumsbeskrivningHygien'|| $bostad_key=='RumsbeskrivningKok'|| $bostad_key=='SaljareForetag'|| $bostad_key=='SaljarePerson'|| $bostad_key=='Tvanslutning'|| $bostad_key=='Upplatelse'|| $bostad_key=='Byggnadstyp'){
						
						continue;
		
						}
							
					
					if( $bostad_key=='Bostadsrattsforening' || $bostad_key=='Kommun' ||  $bostad_key=='Planlosning' || $bostad_key=='Vagbeskrivning' || $bostad_key=='Omrade'   || $bostad_key=='Kontrakt' || $bostad_key=='Adress' || $bostad_key=='Driftkostnad'  || $bostad_key=='BostadsrattsforeningInformation' || $bostad_key=='Projektnamn'
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
											$child_dir_path = "../GUID/".$p_guid."/".$c_guid."/bilder";
			
											
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
											$child_dir_path = "../GUID/".$p_guid."/".$c_guid."/bilder";
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
				/* echo $value->Guid ; echo '<br>';
				echo '<pre>' ; print_r($e->getMessage()); */
				
			}
			$dbmain.="'".$value->Guid."',";
				
			$HamtaProjektResult = $result->HamtaProjektResult;
			
			$BostadChildObject = $HamtaProjektResult->Bostadsrattslista;

			$BostadChild = $BostadChildObject->BostadsrattsLista;

			



			

			//Check if GUID exists, If exists check if update date is other than existing

			$check_guid = "SELECT anvandare_id,guid,senastandrad,bilder,bostadsrattsforening FROM  `".$table_name."` where `guid`='".$value->Guid."'";


			$qu=false;

			$bilder_object_db="";

			$guid_result = mysqli_query($links,$check_guid);

			if ($guid_result->num_rows > 0)

			{

				while($row = $guid_result->fetch_assoc())

				{
					
					
					$anv_id = $row["anvandare_id"];

					$upd_date = $row["senastandrad"];
					$bostadsrattsforening = unserialize($row["bostadsrattsforening"]);
					
				//	$upd_date_new = $row["bostadsrattsforening"];

					$bilder_object_db = unserialize($row["bilder"]);

				}

				if($upd_date <> $HamtaProjektResult->SenastAndrad || (isset($bostadsrattsforening->Bostadsrattsforening->DateChanged) && isset($HamtaProjektResult->Bostadsrattsforening->Bostadsrattsforening->DateChanged) && $bostadsrattsforening->Bostadsrattsforening->DateChanged <> $HamtaProjektResult->Bostadsrattsforening->Bostadsrattsforening->DateChanged))

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
				  // check the values that are in the 'wp_anvandare' tables
				  
			$table_arr = array("anvandare_id","affarsenhet","antalbostader","antalbyggstartadebostader","antaldagar","antalrummax","antalrummin","arkitekt","avgiftmax","avgiftmin",	"bebyggelsetyp","bilder","boareamax","boareamin","bostadsrattsforening","bostadsrattslista","byggforetag","byggslut","byggstart","egnaprojektuppgifter","filer","fritidshuslista","guid","handlaggare2","huvudhandlaggare","huvudprojekt","inredningssaljare","internetinstallningar","internetnummer","intresseanmalan","kommun","kvarter","lankhemsida","lankar","listatomt","namn","omgivning","omrade","planeratavslut","prismax","prismin","produktionsstart","projektlage","projektnyheter","projektdeltagare","projektnummer","region","saljandebeskrivning","saljkrav","saljstart","saljstartfritext","saljstarttom","senastandrad","sistaslutbesiktning","sorteringsordning","status","texter","tilltradeforsta","tilltradefritext","tilltradesista","upplatelseform","utokadintresseanmalan","vagbeskrivning","villalista","visningar","kontaktdetails","kontaktdetails2","Adress","Ovrigt","ProjektInfo","Sokord");
			
				if(!in_array($key, $table_arr) && !in_array(strtolower($key),$table_arr)){
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

								 $dir_path = "../GUID/".$HamtaProjektResult->GUID;
								 
							if($bild_image_name_db <> $bild_last->SenastAndrad || !file_exists($dir_path.'/img_'.$bild_last->Guid.'.jpg'))

								{ 
									try{
										
									load_images($HamtaProjektResult->GUID,$bild_last,"");
									
									}catch(Exception $e){
										
										SenderrorAlarm($e->getMessage());
									/* 	echo $HamtaProjektResult->GUID ; echo '<br>';
										echo '<pre>' ; print_r($e->getMessage()); */
										
									}

								}

							}



						}

						else

						{
							$dir_path = "../GUID/".$HamtaProjektResult->GUID;
							if($bilder_object_db->Bild->SenastAndrad <> $bilds->SenastAndrad || !file_exists($dir_path.'/img_'.$bilds->Guid.'.jpg'))

							{
								try{
								load_images($HamtaProjektResult->GUID,$bilds,"");
								}catch(Exception $e){
									SenderrorAlarm($e->getMessage());
									/* echo $HamtaProjektResult->GUID; echo '<br>';
									echo '<pre>' ; print_r($e->getMessage()); */
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
							// echo $hu_guid ; echo '<br>';
							// echo '<pre>' ; print_r($e->getMessage());
							
						}

						//echo '<pre>' ; print_r($result_again) ; 
						$kontact_details = null;

						if(isset($result_again->HamtaAnvandareResult))

							$kontact_details = $result_again->HamtaAnvandareResult;

						

						$rtrn = array();

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
									/* 	echo $HamtaProjektResult->GUID;  echo '<br>';
										echo '<pre>' ; print_r($e->getMessage()); */
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
							/* echo $hu_guid ; echo '<br>';
							echo '<pre>' ; print_r($e->getMessage()); */
							
						}
							 
						//echo "<pre>"; print_r($result_again); 


						$kontact_details = null;

						if(isset($result_again->HamtaAnvandareResult))

							$kontact_details = $result_again->HamtaAnvandareResult;

						$rtrn2 = array();

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
										/* echo $HamtaProjektResult->GUID ; echo '<br>';
										echo '<pre>' ; print_r($e->getMessage()); */
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
						/* echo "<br><br>";
						echo "Bostad Child GUID = ".$BostadGuid->GUID."<br>"; */
						try{
							
						process_child($value->Guid,$BostadGuid->GUID);
						
						}catch(Exception $e){
		
										SenderrorAlarm($e->getMessage());
									/* 	echo $value->Guid ; echo '<br>';
										echo '<pre>' ; print_r($e->getMessage()); */
						}

					}

				}

				else {
					
					if(!empty($BostadChildObject->BostadsrattsLista->GUID))
					{	
						$dbbosted.="'".$BostadChildObject->BostadsrattsLista->GUID."',";
						/* echo "<br><br>";
						
						echo "Bostad Child GUID = ".$BostadChildObject->BostadsrattsLista->GUID."<br>"; */
						
						try{
						
						process_child($value->Guid,$BostadChildObject->BostadsrattsLista->GUID);
						
						}catch(Exception $e){
		
										SenderrorAlarm($e->getMessage());
									/* 	echo $value->Guid ;  echo '<br>' ; 
										echo '<pre>' ; print_r($e->getMessage()); */
									
						}
					}
				}	

			if($qu)

			{

				$final_query = $query_part1.$query_part2.$query_part3;
				/* 	print_r($final_query);
					echo '<br/><br/>------------------------------------------'; */
				mysqli_query($links, $final_query);

			}

		}

	}

	if(!empty($dbbosted))
	{
		$dbbosted=rtrim($dbbosted,',');
		 $rows_all = "delete FROM  `".$child_table_name."` where `Guid` not in (".$dbbosted.")";
		mysqli_query($links,$rows_all);
	} 

	if(!empty($dbmain))
	{
	 $dbmain=rtrim($dbmain,',');
	  $rows_all = "delete FROM  `".$table_name."` where `guid` not in (".$dbmain.")"; 
	 mysqli_query($links,$rows_all);
	}

	 mysqli_query($links,"DELETE n1 FROM `".$table_name."` n1, `".$table_name."` n2 WHERE n1.anvandare_id < n2.anvandare_id AND n1.guid = n2.guid");
	 
	 $update_query = "INSERT INTO `wp_vitect_updates` SET `type`='1'";
	  mysqli_query($links, $update_query);
	 
	ob_start();
	echo "updated";
	ob_end_flush();
	exit;
}