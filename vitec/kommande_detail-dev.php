<?php 
/* Template Name: Kommande Detail Dev Single */ 
get_header();
global $vitec;
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/projekt-new.css">
<?php  $current_date = date('Y-m-d'); ?>
  <body class="page-succession">
	<?php
	if(isset($_REQUEST['guid']))
	{
		//global $wpdb;
		//$wpdb = vitecDatabase(); // connection to live database
		//$wpdb->prefix = "wp_";
		$get_guid = $_REQUEST['guid'];
		$get_kommande = "SELECT namn,bilder,status,antalbostader,tilltradefritext,kommun,antalrummin,antalrummax,saljandebeskrivning,bostadsrattsforening,visningar,huvudhandlaggare,kontaktdetails,omrade,bostadsrattslista,PrisMax,PrisMin,BoareaMax,BoareaMin,Byggforetag, Arkitekt,AvgiftMax,AvgiftMin,lankhemsida,Vagbeskrivning,Adress FROM `".ANVANDARE."` where `guid`='".$get_guid."' LIMIT 1";
		//$kommande_result = $wpdb->get_results($get_kommande, OBJECT);
		$kommande_result = $vitec->get_results($get_kommande, OBJECT);
		
		$kommande = $kommande_result['0'];
		//echo "<pre>"; print_r($kommande); die;
		$kontaktdetails = unserialize($kommande->kontaktdetails);	
		$huvudhandlaggare = unserialize($kommande->huvudhandlaggare);
		$omrade = unserialize($kommande->omrade);
		if($omrade <> "")
		{
			$om_Kommun = $omrade->Kommun;
			$om_Namn = $omrade->Namn;
		}

		$bostadsrattslista = unserialize($kommande->bostadsrattslista);
		$Visningar =  unserialize($kommande->visningar);

		$kommandenamn = "";
		if($kommande->namn <> ''){
			$kommandenamn	= $kommande->namn;
		}

		$Vagbeskrivning =  unserialize($kommande->Vagbeskrivning);
		
		//echo "<pre>"; print_r($Saljandebeskrivning); die;
		// $huvudhand = $huvudhandlaggare->Huvudhandlaggare;
		

    // ACF functions should be added here, inside "the Loop"
	?>
    <?php include('left-header.php'); ?>
    
	<section id="wrapper">
		<!--Main Content-->
        <section id="mainContent" class="locationContent removePaddingTop">
		<div id="loader"></div>
            <section class="container-fluid">
				<section class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <!--Banner-->
                        <section id="bannerInner">
                            <section class="slider">
                                <!--Slider-->
									<?php
									$bilder_arr = unserialize($kommande->bilder);
									//die("KOM: " . print_r($bilder_arr, true));
									if(!empty($bilder_arr->Bild)) 
									{										
										$bild_obj = $bilder_arr->Bild;
										
										$count=0;
										if(is_object($bild_obj))
										{
											if($bld_obj->HuvudBild == 1){
												$img_src = get_image_url($get_guid,$bild_obj->Guid,"");
												$slider_content.='<div class="item active" style="background: url('.$img_src.') center center / cover no-repeat;">
												<a href="javascript:void(0)" class="visa_alla wiggle">Visa alla bilder</a><div class="brf_outer"><span class="brf_btn">'.$kommandenamn.' <ul>
														<li><a class="wiggle" href="#">Alla bilder</a></li>
														<li><a  href="#lägenhetslista">Läghenhetslista</a></li>
														<li><a  href="#kARTA">Karta</a></li>
														</ul></span></div>
												</div>';
											}
										}
										else
										{
											
											foreach($bild_obj as $bld_obj)
											{
												$act = "";
												if($count == 0)
												$act = "active";
												if($bld_obj->HuvudBild == 1){
													$img_src = get_image_url($get_guid,$bld_obj->Guid,"");
													$slider_content.='<div class="item active" style="background: url('.$img_src.') center center / cover no-repeat;">
														<a href="javascript:void(0)" class="visa_alla wiggle">Visa alla bilder</a><div class="brf_outer"><span class="brf_btn">'.$kommandenamn.' <ul>
																<li><a class="wiggle" href="#">Alla bilder</a></li>
																<li><a  href="#lägenhetslista">Läghenhetslista</a></li>
																<li><a  href="#kARTA">Karta</a></li>
																</ul></span></div>
														</div>';
												}

												$count++;
											}
										}
										echo $slider_content;
									}
									
									?>
                                <!--./Slider-->
                            </section>
                        </section>    
                        <!--./Banner-->
                    </div>
				</section>
			</section>
			<section class="container-fluid wh_margin wksec">
	 		<section class="col-lg-6 col-md-8 col-sm-6 removePaddingTop textBlock mobile_section">
				<div class="saljandeBeskrivningWRP saljandeBeskrivning">
					<?php 
							$content_obj = unserialize($kommande->saljandebeskrivning);
								
								if($content_obj->KortSaljandeBeskrivning <> ""){
									echo '<p>'.nl2br($content_obj->KortSaljandeBeskrivning).'</p>';
								}
							echo '<p>'.nl2br($content_obj->LangSaljandeBeskrivning).'</p>';
								
					?>
				</div>
             </section>
			 <div class="marginTop30 marginBottom10 text-center">
 					</div>
				<section class="row rowPadding30 marginTop10">

	                <section class="col-lg-3 col-md-4 col-sm-6 ">
	                    <div class="kommande_detail marginTop20">
							<h4 class="bold text-center marginBottom20 komm">Om projektet <div class="wh_icon"><i class="fas fa-plus"></i> <i class="fas fa-minus"></i></div></h4>
						<div class="komm_content">	
						<?php
							$kommun =  unserialize($kommande->kommun);
							$Adress =  unserialize($kommande->Adress);
							
							
								echo "<p><span class='mediumFont'>Kommun: </span>".$kommun->Namn."</p>";
							
							
								echo "<p><span class='mediumFont'>Gatuadress: </span>".$Adress->Gatuadress."</p>";
							
								echo "<p><span class='mediumFont'>Bost&auml;der: </span>".$kommande->antalbostader." st"."</p>";

							$boarea_min = $kommande->BoareaMin?$kommande->BoareaMin:"";
							$boarea_max = $kommande->BoareaMax?$kommande->BoareaMax:"";

							if(($boarea_min <> '') or ($boarea_max <> ''))
							echo "<p><span class='mediumFont'>Storlek: </span>".$boarea_min." kvm"." - ".$boarea_max." kvm</p>";
									
							$rum_min = $kommande->antalrummin?$kommande->antalrummin:"";
							$rum_max = $kommande->antalrummax?$kommande->antalrummax:"";
							
							if(($rum_min <> '') or ($rum_max <> ''))
								echo "<p><span class='mediumFont'>Rum: </span>".$rum_min." - ".$rum_max."</p>";
							
							$pris_min = $kommande->PrisMin?$kommande->PrisMin:"";
							$pris_max = $kommande->PrisMax?$kommande->PrisMax:"";

							if(($pris_min <> '') or ($pris_max <> ''))
								echo "<p><span class='mediumFont'>Pris: </span>".number_format($pris_min,'0','',' ')." kr"." - ".number_format($pris_max,'0','',' ')." kr</p>";
							
							$avgift_min = $kommande->AvgiftMin?$kommande->AvgiftMin:"";
							$avgift_max = $kommande->AvgiftMax?$kommande->AvgiftMax:"";

							if(($avgift_min <> '') or ($avgift_max <> ''))
								echo "<p><span class='mediumFont'>Avgift: </span>".number_format($avgift_min,'0','',' ')." kr"." - ".number_format($avgift_max,'0','',' ')." kr</p>";
							
							echo "<p><span class='mediumFont'>Inflyttning: </span>".$kommande->tilltradefritext."</p>";
							
							echo "<p><span class='mediumFont'>Status: </span>".$kommande->status."</p>";

							/*	
							if($kommande->Byggforetag <> '')
									echo "<p><span class='mediumFont'>Byggföretag: </span>".$kommande->Byggforetag."</p>";
								
							if($kommande->Arkitekt <> '')
									echo "<p><span class='mediumFont'>Arkitekt: </span>".$kommande->Arkitekt."</p>";*/
							?>
	                    </div>
	                    </div>
						<div class="hideSmallerScreens">
							<?php 
							echo "<a href=".$kommande->lankhemsida." target='_blank'><div class='projektSidaBtn maklarMailBtn'><p>Besök projektsida</p></div></a>"; 
							?>
						</div>
						
						<!--mobile -->
						<div class="mb_show1 mb_mrgn">
						 <?php if(!empty($Visningar->Visning))
						{
							
						?>
						<div class="pos-rel textBlock accordianOrig kommande_detail marginTop20 marginBottom20 visningar aad ">
						<h4 class="bold text-center">Visningar</h4>
                        <div class="clearfix"></div>
						
							<div class="accorrd marginTop20"> 
									<?php 
									//echo "<pre>"; print_r($Visningar); echo "</pre>";
										if(is_array($Visningar->Visning))
										{
											$upcoming = false;
											$noupcoming = false;
											foreach($Visningar->Visning as $Visning)								
											{
												$datum = $Visning->Datum;
												$datum = substr($datum, 0, strpos($datum, "T"));	
												if($current_date <= $datum)
												{
													 $upcoming = true;
													echo "<div class='accordionRow'>";
													$Fran = $Visning->Fran;
													$format = substr($Fran, strpos($Fran, "T") + 1);    
	
													 if($format !="00:00:00"){
														$Fran = str_replace('T',' kl.', $Fran);
													 }else{
														$Fran = str_replace('T','', $Fran);
													 }
													$Fran = substr($Fran, 0, -3);
													
													$Till = $Visning->Till;
													//$Till = substr($Fran, 0, -3);
													$Till = date('H:i', strtotime($Till));
													//$Till = str_replace('T',' - Klockan:', $Till);
													if($format !="00:00:00"){
														$Till = $Fran.' - '.$Till;
													}else{
														$Till = $Fran;
														$Till = str_replace("00:00","",$Till);
													} 
												
													echo "<H4 class='visningaraccorrd font_style'><span class='mediumFont'>Datum: </span>".$Till."</h4>";	
													echo "<div class='accordContent' >";
													echo "<p><span class='mediumFont'>Plats: </span>".$Visning->Visningsplats."</p>";
													echo "<p><span class='mediumFont'>Kommentar: </span>".$Visning->Kommentar."</p>";
													echo "</div></div>";
												}else{
														$noupcoming = true;
												}	
												
											
											}
											if($upcoming == false){
													if($noupcoming){
															echo "<h4 class='visningaraccorrd font_style'><span class=''>Kontakta mäklaren för en personlig visning</span></h4>";
													}
												}
										}
										else {	
												$datum = $Visningar->Visning->Datum;
												$datum = substr($datum, 0, strpos($datum, "T"));
												if($current_date <= $datum)
												{
													
													echo "<div class='accordionRow'>";
													$Fran = $Visningar->Visning->Fran;
													//echo "<pre>"; print_r($Fran);
													$format = substr($Fran, strpos($Fran, "T") + 1);
													$Fran = str_replace('T',' kl.', $Fran);
													
													if($format !="00:00:00"){
														$Fran = str_replace('T',' kl.', $Fran);
													 }else{
														$Fran = str_replace('T','', $Fran);
													 }
													
													$Fran = substr($Fran, 0, -3);
													
													$Till = $Visningar->Visning->Till;
													//$Till = substr($Till, 0, -3);
													$Till = date('H:i', strtotime($Till));
													//$Till = str_replace('T',' - Klockan:', $Till);
													
													if($format !="00:00:00"){
														$Till = $Fran.' - '.$Till;
													}else{
														$Till = $Fran;
														$Till = str_replace("00:00","",$Till);
													} 
												
													echo "<H4 class='visningaraccorrd font_style'><span class='mediumFont'>Datum: </span>".$Till."</h4>";	
													echo "<div class='accordContent' >";
													echo "<p><span class='mediumFont'>Plats: </span>".$Visningar->Visning->Visningsplats."</p>";
													echo "<p><span class='mediumFont'>Kommentar: </span>".$Visningar->Visning->Kommentar."</p>";
													echo "</div></div>";
												}else{
																echo "<h4 class='visningaraccorrd font_style'><span class=''>Kontakta mäklaren för en personlig visning</span></h4>";
													}	
										}
										?>	
									</div>
								</div>
								<?php }else{
									
												echo '<div class="pos-rel textBlock accordianOrig kommande_detail marginTop20 marginBottom20 visningar aad">
													<h4 class="bold text-center">Visningar</h4>
													<div class="clearfix"></div><div class="accorrd marginTop20"> 
													<h4 class="visningaraccorrd font_style"><span class="">Kontakta mäklaren för en personlig visning</span></h4>	
													</div></div>';
								}	?>
								<h4 class="bold text-center marginTop40">Mäklarkontakt</h4>	
							<?php
								$huvud_guid = $huvudhandlaggare->Huvudhandlaggare->GUID;
							    $kontact_details = get_kontact_details($huvud_guid);
							    $kontaktdetails = unserialize($kontact_details->kontaktdetails);
							    $im_src = get_kontact_image($get_guid,$kontaktdetails['kon_bild'],'kontact');
		//die( " im:" . $im_src);						
								if(!$im_src)
									$im_src = site_url().'/wp-content/uploads/2016/05/maklare_template.png';
								?>
							<section class=" noPadding addPaddingLR">							
									<!--TextBlock-->
								<div class="maklarProject marginBottom20 ">
									<img src="<?php echo $im_src; ?>">
								</div>					
								<div class="text-center ">
									<p class="maklareKontakt text-uppercase"><?php echo $kontaktdetails['kon_befattning']; ?></p>
									<p class="maklareKontakt"><?php echo $kontaktdetails['kon_namn']; ?></p>
									<p class="maklareKontakt"><?php echo $kontaktdetails['kon_telefon']; ?></p>
									<a href="mailto:<?php echo $kontaktdetails['kon_epost']; ?>" target='_blank'>
										<p class="projektSidaBtn maklarMailBtn">Maila mig vid intresse</p>
									</a>
								</div>																
								<!--./TextBlock-->							
							</section>	
						</div>
						<!-- ende mobile-->
	                </section>
	                <section class="col-lg-6 col-md-8 col-sm-6 saljandeBeskrivning removePaddingTop textBlock wk">
						<div class="saljandeBeskrivningWRP">
						  <div class="hideSmallerScreens">
							<?php 
								$content_obj = unserialize($kommande->saljandebeskrivning);
								
								if($content_obj->KortSaljandeBeskrivning <> ""){
									echo '<p>'.nl2br($content_obj->KortSaljandeBeskrivning).'</p>';
								}
								
								echo '<p>'.nl2br($content_obj->LangSaljandeBeskrivning).'</p>';
								?>
							</div>	
							<?php
								$bostadsrattsforening = unserialize($kommande->bostadsrattsforening);
								$Bostadsrattsforen = $bostadsrattsforening->Bostadsrattsforening;
								//echo "<pre>"; print_r($Bostadsrattsforen); die;
								
							 if(!empty($Bostadsrattsforen))
							{
							
								$allmant = '<p class="sub_allmant">'.substr(nl2br($Bostadsrattsforen->AllmantOmForening), 0,60).'</p>';
								
							  echo '<div class="toggle_icon"><h4 class="wh_h4"><span>Om föreningen</span> </h4>'.$allmant.'<div class="wh_icon wh_toggle "><i class="fas fa-plus"></i> <i class="fas fa-minus"></i></div><div class="wh_content">';
							 // echo '<p><span class="mediumFont">Antal Lokaler: </span>'.$Bostadsrattsforen->AntalLokaler.'</p>';
							 // echo '<p><span class="mediumFont">Antal Lägenheter: </span>'.nl2br($Bostadsrattsforen->AntalLagenheter).'</p>';
									if($allmant){
										echo '<p>'.nl2br($Bostadsrattsforen->AllmantOmForening).'</p>';
									  }
							  ?></div></div>
							
							<?php }  ?>
						</div>		
	                </section>
					<section class="col-lg-3 col-md-8 col-sm-12 maklarKontakt hideSmallerScreens">
					<?php if(!empty($Visningar->Visning))
						{
							
						?>
						<div class="pos-rel textBlock accordianOrig kommande_detail marginTop20 visningar aad">
						<h4 class="bold text-center">Visningar</h4>
                        <div class="clearfix"></div>
							<div class="accorrd marginTop20"> 
									<?php 
									//echo "<pre>"; print_r($Visningar); echo "</pre>";
										if(is_array($Visningar->Visning))
										{
											$upcoming = false;
											$noupcoming = false;
											foreach($Visningar->Visning as $Visning)								
											{
												$datum = $Visning->Datum;
												$datum = substr($datum, 0, strpos($datum, "T"));	
												if($current_date <= $datum)
												{
													 $upcoming = true;
													echo "<div class='accordionRow'>";
													$Fran = $Visning->Fran;
													$format = substr($Fran, strpos($Fran, "T") + 1);    
	
													 if($format !="00:00:00"){
														$Fran = str_replace('T',' kl.', $Fran);
													 }else{
														$Fran = str_replace('T','', $Fran);
													 }
													$Fran = substr($Fran, 0, -3);
													
													$Till = $Visning->Till;
													//$Till = substr($Fran, 0, -3);
													$Till = date('H:i', strtotime($Till));
													//$Till = str_replace('T',' - Klockan:', $Till);
													if($format !="00:00:00"){
														$Till = $Fran.' - '.$Till;
													}else{
														$Till = $Fran;
														$Till = str_replace("00:00","",$Till);
													} 
												
													echo "<H4 class='visningaraccorrd font_style'><span class='mediumFont'>Datum: </span>".$Till."</h4>";	
													echo "<div class='accordContent' >";
													echo "<p><span class='mediumFont'>Plats: </span>".$Visning->Visningsplats."</p>";
													echo "<p><span class='mediumFont'>Kommentar: </span>".$Visning->Kommentar."</p>";
													echo "</div></div>";
												}else{
														$noupcoming = true;
												}	
												
											
											}
											if($upcoming == false){
													if($noupcoming){
															echo "<h4 class='visningaraccorrd font_style'><span class=''>Kontakta mäklaren för en personlig visning</span></h4>";
													}
												}
										}
										else {	
												$datum = $Visningar->Visning->Datum;
												$datum = substr($datum, 0, strpos($datum, "T"));
												if($current_date <= $datum)
												{
													
													echo "<div class='accordionRow'>";
													$Fran = $Visningar->Visning->Fran;
													//echo "<pre>"; print_r($Fran);
													$format = substr($Fran, strpos($Fran, "T") + 1);
													$Fran = str_replace('T',' kl.', $Fran);
													
													if($format !="00:00:00"){
														$Fran = str_replace('T',' kl.', $Fran);
													 }else{
														$Fran = str_replace('T','', $Fran);
													 }
													
													$Fran = substr($Fran, 0, -3);
													
													$Till = $Visningar->Visning->Till;
													//$Till = substr($Till, 0, -3);
													$Till = date('H:i', strtotime($Till));
													//$Till = str_replace('T',' - Klockan:', $Till);
													
													if($format !="00:00:00"){
														$Till = $Fran.' - '.$Till;
													}else{
														$Till = $Fran;
														$Till = str_replace("00:00","",$Till);
													} 
												
													echo "<H4 class='visningaraccorrd font_style'><span class='mediumFont'>Datum: </span>".$Till."</h4>";	
													echo "<div class='accordContent' >";
													echo "<p><span class='mediumFont'>Plats: </span>".$Visningar->Visning->Visningsplats."</p>";
													echo "<p><span class='mediumFont'>Kommentar: </span>".$Visningar->Visning->Kommentar."</p>";
													echo "</div></div>";
												}else{
																echo "<h4 class='visningaraccorrd font_style'><span class=''>Kontakta mäklaren för en personlig visning</span></h4>";
													}	
										}
										?>	
									</div>
								</div>
								<?php }else{
									
												echo '<div class="pos-rel textBlock accordianOrig kommande_detail marginTop20 visningar aad">
													<h4 class="bold text-center">Visningar</h4>
													<div class="clearfix"></div><div class="accorrd marginTop20"> 
													<h4 class="visningaraccorrd font_style"><span class="">Kontakta mäklaren för en personlig visning</span></h4>	
													</div></div>';
								}	?>
						<h4 class="bold text-center marginTop40">Mäklarkontakt</h4>	
						<?php
						
						    $huvud_guid = $huvudhandlaggare->Huvudhandlaggare->GUID;
							$kontact_details = get_kontact_details($huvud_guid);
							$kontaktdetails = unserialize($kontact_details->kontaktdetails);
							$im_src = get_kontact_image($get_guid,$kontaktdetails['kon_bild'],'kontact');
							//$no_src = get_image($get_guid,$['kon_bild'],'kontact');
							if (@getimagesize($im_src) == false) {
								$im_src = site_url().'/wp-content/uploads/2016/05/maklare_template.png';
							}
							
							?>
						<section class=" noPadding addPaddingLR marginTop20">							
								<!--TextBlock-->
							<div class="maklarProject marginBottom20 <?php if (getimagesize($im_src) == false) { echo 'bilder_noimg'; } ?>">
								<img src="<?php echo $im_src; ?>">
							</div>					
							<div class="text-center ">
								<p class="maklareKontakt text-uppercase"><?php echo $kontaktdetails['kon_befattning']; ?></p>
								<p class="maklareKontakt"><?php echo $kontaktdetails['kon_namn']; ?></p>
								<p class="maklareKontakt"><?php echo $kontaktdetails['kon_telefon']; ?></p>
								<a href="mailto:<?php echo $kontaktdetails['kon_epost']; ?>" target='_blank'>
									<p class="projektSidaBtn maklarMailBtn">Maila mig vid intresse</p>
								</a>
							</div>																
							<!--./TextBlock-->							
						</section>
						
					</section>
                </section>
			</section>
        <!--Partners-->
		
		<?php 			
		
		if(!empty($bostadsrattslista->BostadsrattsLista)) { 
		
		?>
		
        <section class="container-fluid marginBottom20">
           	<section class="row rowPadding30">
            	<section class="col-lg-12 col-md-12 col-sm-12 ">
				<div class="lägenhetslista" id="lägenhetslista">
					<h4 class="wh_h4"><span>Lägenhetslista</span></h4>
					<!--div class="">
						<h3>Lägenhetslista</h3>
					</div-->
				</div>
				</section>
        	</section>
			<section class="row rowPadding30 marginTop10">
				<section class="kommande_detail listHead mediumFont lghListRows">
					<section class="lghListRow hideMobile">
						<p>Lgh Nr</p>
					</section>	
					<section class="lghListRow">
						<p>Rum</p>
					</section>	
					<section class="lghListRow">
						<p>Yta</p>
					</section>	
					<section class="lghListRow">
						<p>Våning</p>
					</section>	
					<section class="lghListRow hideMobile">
						<p>Avgift</p>
					</section>	
					<section class="lghListRow hideMobile">
						<p>Pris</p>
					</section>	
					<section class="lghListRow hideMobile">
						<p>Status</p>
					</section>	
				</section>
        	</section>

		<?php
		
			foreach($bostadsrattslista->BostadsrattsLista as $bost_guid)
				{	
					if(is_object($bost_guid)){
						 $get_bostad_record = "SELECT child_ID,Lagenhetsnummer,Rum,Vaningsplan,Manadsavgift,PrisAnbudTillval,Status,Filer FROM  `".CHILD_GUIDS."` where `guid`='".$bost_guid->GUID."' LIMIT 1";
					}else{
						 $get_bostad_record = "SELECT child_ID,Lagenhetsnummer,Rum,Vaningsplan,Manadsavgift,PrisAnbudTillval,Status,Filer FROM  `".CHILD_GUIDS."` where `guid`='".$bost_guid."' LIMIT 1";
					}
					
					//die("SQL:  . \n$get_bostad_record ");
					$bostad_result = $vitec->get_results($get_bostad_record, OBJECT);
				/* 	
					if(!$bostad_result)
					{
						
						$get_bostad_record = "SELECT child_ID,Lagenhetsnummer,Rum,Vaningsplan,Manadsavgift,PrisAnbudTillval,Status,Filer FROM  ".CHILD_GUIDS . " where `guid`='".$bost_guid."' LIMIT 1";
						
							
						$bostad_result = $vitec->get_results($get_bostad_record, OBJECT);						
					} */
					
					if($bostad_result){
						
					$bostads = $bostad_result['0'];
					if($bostads)
					{
						$Lagenhetsnummer =  $bostads->Lagenhetsnummer;
						
						$Rum =  unserialize($bostads->Rum);
						$AntalRumMax =  $Rum->AntalRumMax;
						$AntalRumMin =  $Rum->AntalRumMin;
						$BostadsArea =  $Rum->BostadsArea;
						
						$Vaningsplan_obj =  unserialize($bostads->Vaningsplan);
						$Vaning =  $Vaningsplan_obj->Vaning;
						
						$Manadsavgift_obj =  unserialize($bostads->Manadsavgift);
						$ManadsAvgift =  $Manadsavgift_obj->ManadsAvgift;
						
						$PrisAnbudTillval_obj =  unserialize($bostads->PrisAnbudTillval);
						$BegartPris =  $PrisAnbudTillval_obj->BegartPris;
						
						$Status =  $bostads->Status;
						
						$Filer_obj =  unserialize($bostads->Filer);
						// $Filer =  $Filer_obj->;
						
						//$bostads->child_ID;
						$trimmed = str_replace('Återtagen','Atertagen', $Status);
						
						if ($Status  != "Återtagen")
							if(!empty($bost_guid->GUID))
						{	
							echo '<a href="'.site_url().'/bostad-dev/?guid='.$bost_guid->GUID.'">'; 
						}
						else {
							echo '<a href="'.site_url().'/bostad-dev/?guid='.$bost_guid.'">'; 
						}
						if ($Status  != "Under intag"){
							echo '<section class="row rowPadding30 lghList">
								<section class="kommande_detail lghListRows '.$trimmed.'">				
							<section class="lghListRow hideMobile">
							<p>'.$Lagenhetsnummer.'</p>
							</section>	
							<section class="lghListRow">
							<p>'.$AntalRumMin.'</p>
							</section>	
							<section class="lghListRow">
							<p>'.$BostadsArea.' kvm'.'</p>
							</section>	
							<section class="lghListRow">
							<p>'.$Vaning.'</p>
							</section>	
							<section class="lghListRow hideMobile">
							<p>'.number_format($ManadsAvgift,'0','',' ').' kr'.'</p>
							</section>	
							<section class="lghListRow hideMobile">
							<p>'.number_format($BegartPris,'0','',' ').' kr'.'</p>
							</section>	
							<section class="lghListRow hideMobile">
							<p>'.$Status.'</p>
							</section>	
							</section>	
							</section></a>';
						}
					}
					
				  }
				}
			}
		?>
			
		<!--./Row-->   	
		</section>
		 <section class="container-fluid">
		  <section class="row  marginTop10">
		   <div class="map_box mp" id="kARTA">
				<h4 class="wh_h41"><span>KARTA</span></h4>
		   </div>
          	<section class="col-lg-12 col-md-12 col-sm-12 ">
				<div id="map" class="map"></div>
				</section>
			</section>
		</section>	
        <!--./Partners-->
    </section>
	<?php 	
	}
	?>
  <?php get_footer(); ?>
  <div id="content">
	<a href="#image1" class="wiggle"></a>
	  <div class="lightbox short-animate visaallapopup" id="image1">
	  </div>
	  <div id="lightbox-controls" class="short-animate close-popup1">
		<a id="close-lightbox" class="long-animate" href="#!">Close Lightbox</a>
	  </div>
	</div>
	
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

	
	<script>
	var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
	jQuery(".wiggle").click(function(){
		jQuery(".page-succession , html").addClass("remove_scroll");
		jQuery('#loader').html('<div id="loader-icon"><img src="http://www.nytthem.se/wp-content/themes/NyttHemLatest/loaderIcon.gif"></div>');
		var data = {
			'action': 'project_visa_all_bilder',
			'guid': '<?php echo $_REQUEST['guid']; ?>',
		};
		jQuery.post(ajaxurl, data, function(response) {
			if(response!=""){
				jQuery('.visaallapopup').html(response);
				 setTimeout(function(){ 
						jQuery(".visaallapopup").addClass("active");
						jQuery('#loader').html('<div id="loader-icon"></div>');
					}, 500);
			
			}else{
				jQuery('#loader').html('<div id="loader-icon"></div>');
			}
		});
	});
	jQuery(".close-popup1").click(function(){
		jQuery(".visaallapopup").removeClass("active");
		jQuery(".page-succession , html").removeClass("remove_scroll");
	});
	
	jQuery(document).keyup(function(e) {
	  if (e.keyCode == '27') {
		 jQuery(".visaallapopup").removeClass("active");
	  }
	});


	jQuery(document).click(function(event) {
		var modal1 = document.getElementById('image1');
		var modal2 = document.getElementById('image2');
		if (event.target == modal1 || event.target == modal2) {
		   jQuery(".visaallapopup").removeClass("active");
		   jQuery(".page-succession , html").removeClass("remove_scroll");
		}
	}); 
	</script>
	<script>
		jQuery(document).ready(function() {
			var map = '';
			initMap();
		});
		var map = '';
		function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 20,
			maxZoom: 15,
			scrollwheel: false,
			navigationControl: false,
			mapTypeControl: false,
			scaleControl: false,
			draggable: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			// styles: [{"stylers": [{ "saturation": -100 }]}],
			styles: [
						{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"color": "#929292"}, {"weight": "0.50"}, {"gamma": "0.63"}, {"visibility": "on"}, {"saturation": "-69"}, {"lightness": "2"}]}
						,
						{"featureType": "administrative", "elementType": "labels.text.stroke", "stylers": [{"visibility": "off"}]},
						{"featureType": "administrative", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape", "elementType": "all", "stylers": [{"visibility": "on"}, {"color": "#f2f2f2"}]},
						{"featureType": "landscape.man_made", "elementType": "geometry", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape.man_made", "elementType": "geometry.fill", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape.man_made", "elementType": "labels.text", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape.natural", "elementType": "all", "stylers": [{"visibility": "simplified"}, {"color": "#f6f6f6"}]},
						{"featureType": "landscape.natural", "elementType": "labels", "stylers": [{"visibility": "on"}]},
						{"featureType": "landscape.natural", "elementType": "labels.text", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape.natural", "elementType": "labels.text.fill", "stylers": [{"visibility": "on"}]},
						{"featureType": "landscape.natural", "elementType": "labels.text.stroke", "stylers": [{"visibility": "off"}]},
						{"featureType": "landscape.natural", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},
						{"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}, {"hue": "#ff0000"}, {"saturation": "-43"}, {"lightness": "51"}]},
						{"featureType": "road", "elementType": "all", "stylers": [{"saturation": -100}, {"lightness": 45}, {"visibility": "on"}]},
						{"featureType": "road", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]},
						{"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "off"}]},
						{"featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{"visibility": "on"}]},
						{"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "simplified"}]},
						{"featureType": "transit.line", "elementType": "all", "stylers": [{"visibility": "off"}]},
						{"featureType": "transit.station", "elementType": "all", "stylers": [{"visibility": "off"}]},
						{"featureType": "water", "elementType": "all", "stylers": [{"color": "#e9e9e9"}, {"visibility": "on"}]}
					],
		});

		var locations = [
						  ['', <?php echo $Vagbeskrivning->Latitud; ?>,  <?php echo $Vagbeskrivning->Longitud; ?>]							  
						];

		setMarkers11(map,locations)
		if(map == ""){
			$(".wh_h41").css("display",'none');
		}
	}

	function setMarkers11(map,locations){
		var marker, i;
		var bounds = new google.maps.LatLngBounds();

		for (i = 0; i < locations.length; i++)
		{  		
			var lat = locations[i][1]
			var long = locations[i][2]

			latlngset = new google.maps.LatLng(lat, long);
			var image = '<?php echo get_template_directory_uri(); ?>/img/google_marker.png';
			var marker = new google.maps.Marker({  
				map: map,  position: latlngset , icon: image
			});

			//extend the bounds to include each marker's position
			bounds.extend(marker.position);

		}
		//now fit the map to the newly inclusive bounds
		center = bounds.getCenter();
		map.fitBounds(bounds);
	}
	 
	</script>
	
	
	<script>
	if(jQuery(window).width() < 768){
   jQuery(document).ready(function(){

	   jQuery(".wh_h4").click(function(){
			jQuery(this).next().next().trigger('click');
	   })
	   jQuery(".komm , .toggle_icon .wh_icon").click(function(){
		if(jQuery(this).hasClass('active')){
			jQuery('.komm_content , .toggle_icon .wh_content').hide('fast');
			 jQuery('.sub_allmant').removeClass('wh_active');
			
			jQuery(this).removeClass('active');
		}else{
			jQuery('.komm_content , .toggle_icon .wh_content').hide('fast');
			jQuery('.komm , .toggle_icon .wh_icon').removeClass('active');
			
			if(!jQuery(this).hasClass("om_foren")){
			    jQuery('.sub_allmant').addClass('wh_active');
			}else{
				 jQuery('.sub_allmant').removeClass('wh_active');
			}
			
			jQuery(this).next('.komm_content , .toggle_icon .wh_content ').show('fast');
			jQuery(this).addClass('active');
		} 
	});
});
}
	</script>
			
  </body>
</html>