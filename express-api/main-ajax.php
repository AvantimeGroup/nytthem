<?php 

	include('functions.php');

	if(isset($_POST['type']) && $_POST['type'] == 'succession'){
		
		$guid  		=  $_POST['guid'];
		if(strpos($guid, "CMVILLA") !== false){
			$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHouse";
		}elseif(strpos($guid, "CMTOMT") !== false){
			$api_url 	= "https://connect.maklare.vitec.net/Estate/GetPlot"; 
		}elseif(strpos($guid, "CMAGA") !== false){
			$api_url 	= "https://connect.maklare.vitec.net/Estate/GetCondominium";
		}else{
			$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
		}
		
		$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
		$api_url 	= $api_url.$data;
		
		$project 	=  httpRequest($api_url, $succession);
		echo "<b>GUID: ".$guid."</b>";
		echo "<pre>"; print_r($project); exit();
		
	}


	if(isset($_POST['type']) && $_POST['type'] == 'projekt'){
			
		$guid  		=  $_POST['guid'];
		$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
		$data 		= "?projectId=".$guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
		$api_url 	= $api_url.$data;
		
		$project =  httpRequest($api_url, $projekt);
		echo "<b>GUID: ".$guid."</b>";
		echo '<pre>'; print_r($project); echo '</pre>'; 
		
		foreach ($project['housingCooperatives'] as $c_guid){
			
			$URL = "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
			$data = "?estateId=".$c_guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
			$URL = $URL.$data;
			
			$child_data =  httpRequest($URL, $projekt);
			if($child_data){
				echo '<b>Child GUID: '.$c_guid.'</b>';
				echo '<pre>' ; print_r($child_data); echo '</pre>';
			}
		
		}
		
		foreach ($project['condominiums'] as $c_guid){
			
			$URL = "https://connect.maklare.vitec.net/Estate/GetCondominium";
			$data = "?estateId=".$c_guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
			$URL = $URL.$data;
			
			$child_data =  httpRequest($URL, $projekt);
			if($child_data){
				echo '<b>Child GUID: '.$c_guid.'</b>';
				echo '<pre>' ; print_r($child_data); echo '</pre>';
			}
		
		}
		exit();
		
	}

	if(isset($_POST['type']) && $_POST['type'] == 'succession_projekt'){
			
		$guid  		=  $_POST['guid'];
		$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
		$data 		= "?projectId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
		$api_url 	= $api_url.$data;
		
		$project =  httpRequest($api_url, $succession);
		echo "<b>GUID: ".$guid."</b>";
		echo '<pre>'; print_r($project); echo '</pre>'; 
		
		foreach ($project['housingCooperatives'] as $c_guid){
			
			$URL = "https://connect.maklare.vitec.net/Estate/GetCondominium";
			$data = "?estateId=".$c_guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
			$URL = $URL.$data;
			
			$child_data =  httpRequest($URL, $succession);
			if($child_data){
				echo '<b>Child GUID: '.$c_guid.'</b>';
				echo '<pre>' ; print_r($child_data); echo '</pre>';
			}
		
		}
		exit();
		
	}

	if(isset($_POST['type']) && $_POST['type'] == 'get_projekts'){
		
		$api_url 			= "https://connect.maklare.vitec.net/Estate/GetEstateList/";
		$projekt['method']  = "POST";
		$customer_object 	=  httpRequest($api_url, $projekt);
		
		$html = "";
		
		foreach($customer_object as $objects){ 
		
			$counter = 1;
			//echo "<pre>"; print_r($objects); die;
			foreach($objects['projects'] as $_project){
				
				$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
				$data 		= "?projectId=".$_project['id']."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
				$api_url 	= $api_url.$data;
				unset($projekt['method']);
				$project =  httpRequest($api_url, $projekt);
				
				$class = ($counter % 2 == 0)? "even" : "odd";
				
				$html.= '<div class="api_table '.$class.'">
							<div class="api_content">
								<h2>Namn</h2>
								<h4>'.$project['baseInformation']['projectName'].'</h4>
							</div>';
					$html.= '<div class="api_content">
								<h2>Adress</h2>
								<h4>'.$_project['streetAddress'].'</h4>
							</div>';
					$html.= '<div class="api_content">
								<h2>GUID</h2>
								<h4 style="font-size: 12px;">'.$_project['id'].'</h4>
							</div>';
					$html.='<div class="api_content">
								<h2>Lank</h2>
								<h4><a target="_blank" href="https://www.nytthem.se/projekt/?guid='.$_project['id'].'">URL tor nytthem</a></h4>
							</div>';
					$html.='<div class="api_content">
								<h2>Handling</h2>
								<h4><a target="_blank" href="https://www.nytthem.se/vitec_express_projekt/projekt_cron.php?name=Projekt&type=Project&event=Update&customerId=S13907&id='.$_project['id'].'">Uppdatering</a></h4>
								<span class="loader_gif"><img src="images/refresh.svg" data-type="projekt" data-guid="'.$_project['id'].'" class="img-fluid"></span>
								<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
							</div>		
						</div>';
				$counter++; 
			}
			 
		}
		echo $html;
		exit();
		
	}
	
	if(isset($_POST['show_all']) && $_POST['show_all'] == 'get_projekts'){
		
		$api_url 			= "https://connect.maklare.vitec.net/Estate/GetEstateList/";
		$projekt['method']  = "POST";
		$customer_object 	=  httpRequest($api_url, $projekt);
	
		foreach($customer_object as $objects){ 
		
			foreach($objects['projects'] as $_project){
				
				$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
				$data 		= "?projectId=".$_project['id']."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
				$api_url 	= $api_url.$data;
				unset($projekt['method']);
				$project =  httpRequest($api_url, $projekt);
				echo "<b>GUID: ".$_project['id']."</b>";
				echo '<pre>'; print_r($project); echo '</pre>'; 
				
				foreach ($project['housingCooperatives'] as $c_guid){
			
					$URL = "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
					$data = "?estateId=".$c_guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
					$URL = $URL.$data;
					
					$child_data =  httpRequest($URL, $projekt);
					if($child_data){
							echo '<b>Child GUID: '.$c_guid.'</b>';
							echo '<pre>' ; print_r($child_data); echo '</pre>';
						}
					
				}
			}
		}
		exit();
		
	}



	if(isset($_POST['type']) && $_POST['type'] == 'get_successions'){
		
		
		$api_url = "https://connect.maklare.vitec.net/Estate/GetEstateList/";
			
		$succession['method'] = "POST";
		$customer_objects =  httpRequest($api_url, $succession);
		$html = "";
		
		foreach($customer_objects as $object){
			
			$counter = 1;
			
			foreach($object['housingCooperativeses'] as $key => $_object){
				
				if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMBOLGH4QRCKBCGI6M0IKHN'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
					
					if($project['baseInformation']['newConstruction']!= 1){
					
						$class = ($counter % 2 == 0)? "even" : "odd";
						$prefix = "CMBOLGH";
						$guid  = remove_prefix_from_guid($prefix, $_object['id']);
						
									

						$html.= '<div class="api_table '.$class.'">
								<div class="api_content">
									<h2>Namn</h2>
									<h4>'.$_object['streetAddress'].'</h4>
								</div>';
						$html.= '<div class="api_content">
									<h2>GUID</h2>
									<h4>'.$_object['id'].'</h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Lank</h2>
									<h4><a target="_blank" href="https://www.nytthem.se/succession/?guid='.$guid.'">URL tor nytthem</a></h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Handling</h2>
									<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Objekt&type=Estate&event=Update&customerId=S13751&subtype=HousingCooperative&id='.$_object['id'].'">Uppdatering</a></h4>
									<span class="loader_gif"><img src="images/refresh.svg" data-type="succession" data-guid="'.$_object['id'].'" class="img-fluid"></span>
									<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
								</div>		
							</div>';
						$counter++;
					}
				}
				
			}

			foreach($object['condominiums'] as $key => $_object){
				
				if($_object['status']['name'] == 'Till salu' && $_object['id'] == 'CMAGARLGH5AMJO28NJ27NFU6I'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
					
					if($project['baseInformation']['newConstruction']!= 1){
					
						$class = ($counter % 2 == 0)? "even" : "odd";
						$prefix = "CMBOLGH";
						$guid  = remove_prefix_from_guid($prefix, $_object['id']);
						
									

						$html.= '<div class="api_table '.$class.'">
								<div class="api_content">
									<h2>Namn</h2>
									<h4>'.$_object['streetAddress'].'</h4>
								</div>';
						$html.= '<div class="api_content">
									<h2>GUID</h2>
									<h4>'.$_object['id'].'</h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Lank</h2>
									<h4><a target="_blank" href="https://www.nytthem.se/succession/?guid='.$guid.'">URL tor nytthem</a></h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Handling</h2>
									<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Objekt&type=Estate&event=Update&customerId=S13751&subtype=HousingCooperative&id='.$_object['id'].'">Uppdatering</a></h4>
									<span class="loader_gif"><img src="images/refresh.svg" data-type="succession" data-guid="'.$_object['id'].'" class="img-fluid"></span>
									<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
								</div>		
							</div>';
						$counter++;
					}
				}
				
			}
		}
		// echo "<pre>"; print_r($customer_objects); die;
		foreach($customer_objects as $object){
			
			foreach($object['houses'] as $key => $_object){
				
				
				//if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMBOLGH4QRCKBCGI6M0IKHN'){
				if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMVILLA55NIGRFBSEDVHLNH'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHouse";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
					
					if($project['baseInformation']['newConstruction']!= 1){
					
						$class = ($counter % 2 == 0)? "even" : "odd";
						$prefix = "CMVILLA";
						$guid  = remove_prefix_from_guid($prefix, $_object['id']);

						$html.= '<div class="api_table '.$class.'">
								<div class="api_content">
									<h2>Namn</h2>
									<h4>'.$_object['streetAddress'].'</h4>
								</div>';
						$html.= '<div class="api_content">
									<h2>GUID</h2>
									<h4>'.$_object['id'].'</h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Lank</h2>
									<h4><a target="_blank" href="https://www.nytthem.se/succession/?guid='.$guid.'">URL tor nytthem</a></h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Handling</h2>
									<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Objekt&type=Estate&event=Update&customerId=S13751&subtype=HousingCooperative&id='.$_object['id'].'">Uppdatering</a></h4>
									<span class="loader_gif"><img src="images/refresh.svg" data-type="succession" data-guid="'.$_object['id'].'" class="img-fluid"></span>
									<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
								</div>		
							</div>';
						$counter++;
					}
				}
				
			}
		}
		
		foreach($customer_objects as $object){
			
			foreach($object['plots'] as $key => $_object){
				
				if($_object['status']['name'] == 'Till salu'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetPlot"; 
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
					
					if($project['baseInformation']['newConstruction']!= 1){
					
						$class = ($counter % 2 == 0)? "even" : "odd";
						$prefix = "CMTOMT";
						$guid  = remove_prefix_from_guid($prefix, $_object['id']);

						$html.= '<div class="api_table '.$class.'">
								<div class="api_content">
									<h2>Namn</h2>
									<h4>'.$_object['streetAddress'].'</h4>
								</div>';
						$html.= '<div class="api_content">
									<h2>GUID</h2>
									<h4>'.$_object['id'].'</h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Lank</h2>
									<h4><a target="_blank" href="https://www.nytthem.se/succession/?guid='.$guid.'">URL tor nytthem</a></h4>
								</div>';
						$html.='<div class="api_content">
									<h2>Handling</h2>
									<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Objekt&type=Estate&event=Update&customerId=S13751&subtype=HousingCooperative&id='.$_object['id'].'">Uppdatering</a></h4>
									<span class="loader_gif"><img src="images/refresh.svg" data-type="succession" data-guid="'.$_object['id'].'" class="img-fluid"></span>
									<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
								</div>		
							</div>';
						$counter++;
					}
				}
				
			}	
		}
		
		echo $html;
		exit();
		
	}



	if(isset($_POST['type']) && $_POST['type'] == 'get_succession_projekts'){
		
		$api_url = "https://connect.maklare.vitec.net/Estate/GetEstateList/";
		
		$succession['method'] = "POST";
		$customer_objects =  httpRequest($api_url, $succession);
		$html = "";
		
		foreach($customer_objects as $objects){
			$counter = 1;
			
			foreach($objects['projects'] as $_project){
				
				$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
				$data 		= "?projectId=".$_project['id']."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
				$api_url 	= $api_url.$data;
				
				unset($succession['method']);
				
				$project =  httpRequest($api_url, $succession);
				//echo "<pre>"; print_r($project); die;
				$class = ($counter % 2 == 0)? "even" : "odd";
				$html.= '<div class="api_table '.$class.'">
						<div class="api_content">
							<h2>Namn</h2>
							<h4>'.$project['baseInformation']['projectName'].'</h4>
						</div>';
				$html.= '<div class="api_content">
						<h2>Adress</h2>
						<h4>'.$_project['streetAddress'].'</h4>
					</div>';
				$html.= '<div class="api_content">
							<h2>GUID</h2>
							<h4 style="font-size:12px;">'.$_project['id'].'</h4>
						</div>';
				$html.='<div class="api_content">
							<h2>Lank</h2>
							<h4><a target="_blank" href="https://www.nytthem.se/projekt/?guid='.$_project['id'].'">URL tor nytthem</a></h4>
						</div>';
				$html.='<div class="api_content">
							<h2>Handling</h2>
							<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Projekt&type=Project&event=Update&customerId=S13751&id='.$_project['id'].'">Uppdatering</a></h4>
							<span class="loader_gif"><img src="images/refresh.svg" data-type="succession_projekt" data-guid="'.$_project['id'].'" class="img-fluid"></span>
							<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
						</div>		
					</div>';
				$counter++;
			}	
		}
		
		echo $html;
		exit();
		
	}
	
	if(isset($_POST['show_all']) && $_POST['show_all'] == 'get_successions'){
		
		$api_url = "https://connect.maklare.vitec.net/Estate/GetEstateList/";
			
		$succession['method'] = "POST";
		$customer_objects =  httpRequest($api_url, $succession);
		
	
		foreach($customer_objects as $object){
			
			foreach($object['housingCooperativeses'] as $key => $_object){
				
				if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMBOLGH4QRCKBCGI6M0IKHN'){
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
					$data 		= "?estateId=".$_object['id']."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					unset($succession['method']);
					$project 	=  httpRequest($api_url, $succession);
					echo "<b>GUID: ".$_object['id']."</b>";
					echo "<pre>"; print_r($project); echo "</pre>";
				}
				
			}
			
		}
		exit();
		
	}
	
	
	if(isset($_POST['show_all']) && $_POST['show_all'] == 'get_succession_projekts'){
		
		$api_url = "https://connect.maklare.vitec.net/Estate/GetEstateList/";
		
		$succession['method'] = "POST";
		$customer_objects =  httpRequest($api_url, $succession);
		
		unset($succession['method']);
		foreach($customer_objects as $objects){
			
			foreach($objects['projects'] as $_project){
				
				$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
				$data 		= "?projectId=".$_project['id']."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
				$api_url 	= $api_url.$data;
				
				$project =  httpRequest($api_url, $succession);
				echo "<b>GUID: ".$_project['id']."</b>";
				echo '<pre>'; print_r($project); echo '</pre>'; 
				
				foreach ($project['housingCooperatives'] as $c_guid){
					
					$URL = "https://connect.maklare.vitec.net/Estate/GetCondominium";
					$data = "?estateId=".$c_guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$URL = $URL.$data;
					
					$child_data =  httpRequest($URL, $succession);
					if($child_data){
						echo '<b>Child GUID: '.$c_guid.'</b>';
						echo '<pre>' ; print_r($child_data); echo '</pre>';
					}
				
				}
				
			}
		}
		
		exit();
	}