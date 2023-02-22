<?php

	$succession = $projekt = [];

	$succession['auth'] 		= 'MzgyOnlRalRuRlJreDMxWVZvYjdiaFY3VXFFWnA4cE9BTUVpRXZnSkt0SW1jSFhHQzRBdU5BcFJBSFU3Q0FjZk8yWmE=';
	$succession['password'] 	= 'yQjTnFRkx31YVob7bhV7UqEZp8pOAMEiEvgJKtImcHXGC4AuNApRAHU7CAcfO2Za';
	$succession['customer_id'] 	= 'S13751';

	$projekt['auth'] 		= 'MzgyOnZGWGlzN0t2dnBpVUFaWGJTRkZ2dkNSczhsOFNoWUg1a3Rqbm1rdk90RHBjaG0wRmNvUkFCa2lpbGNhNnlxRU0=';
	$projekt['password'] 	= 'vFXis7KvvpiUAZXbSFFvvCRs8l8ShYH5ktjnmkvOtDpchm0FcoRABkiilca6yqEM';
	$projekt['customer_id'] = 'S13907';
	

	/**********************************************/
	/***** Function get the request from API ******/
	/**********************************************/
	
	function httpRequest($URL, $data){
		 
			$ch 	 = curl_init();
			$auth 	 = $data['auth'];
			$headers = ['Authorization: Basic '.$auth];
			curl_setopt($ch, CURLOPT_USERNAME, "{382}");
			curl_setopt($ch, CURLOPT_PASSWORD, '{'.$data['password'].'}');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $URL);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			if($data['method']){
				$customerID = array('customerId' => $data['customer_id']);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerID));
			}
			$result = curl_exec($ch);
			if (curl_errno($ch)) {	
				die(curl_getinfo($ch));
			}
			$info = curl_getinfo($ch);
			curl_close($ch);

			$http_code = $info["http_code"];
			if ($http_code == 200) {
			   return  json_decode($result, true);
			}

	}
	/**********************************************/
	/***** Function get All the successions ******/
	/**********************************************/
	
	function get_successions_data(){
		
		global $succession;
		$api_url = "https://connect.maklare.vitec.net/Estate/GetEstateList/";
		
		$succession['method'] = "POST";
		$customer_objects =  httpRequest($api_url, $succession);
//		echo "<pre>"; print_r($customer_objects); die;
		
	   /* Housing cooperative subtype records */
		$childs = [];
		foreach($customer_objects as $object){ 
			
			
			foreach($object['housingCooperativeses'] as $key => $_object){
					
				if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMBOLGH4QRCKBCGI6M0IKHN'){
					 
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);

//if($guid =='CMBOLGH5CCA9HBMJUTQP58F'){echo "<pre>"; print_r($guid); }
// echo "<br>"; print_r($guid);     

					
					if($project['baseInformation']['newConstruction']!=1){
						
						$childs[$key]['streetAddress'] 	= $_object['streetAddress'];
						$childs[$key]['guid'] 		 	= $_object['id'];
						
					}
				}
			}	
		}
		foreach($customer_objects as $object){ 
			
			
			foreach($object['condominiums'] as $key => $_object){
					
				if($_object['status']['name'] == 'Till salu' ||  $_object['id'] == 'CMAGARLGH5AMJO28NJ27NFU6I'){
					 
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetCondominium";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);

//					if($guid =="CMAGARLGH5B5J1BMHA4N3V3JP"){
//                                              echo "<pre>"; print_r($guid); die;
//                                         }
//                                        echo "<pre>"; print_r($project);     

					if($project['baseInformation']['newConstruction']!= 1){
						
						$childs[$key]['streetAddress'] 	= $_object['streetAddress'];
						$childs[$key]['guid'] 		 	= $_object['id'];
						
					}
				}
			}	
		}
		/* Houses subtype records */
		$childs_house = [];
		foreach($customer_objects as $object){
			
			foreach($object['houses'] as $key => $_object){
				
				if($_object['status']['name'] == 'Till salu' || $_object['id'] == 'CMVILLA55NIGRFBSEDVHLNH'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];

//if($guid =='CMAGARLGH5B5J1BMHA4N3V3JP'){  echo "<pre>"; print_r($guid); die;  }
// echo "<pre>"; print_r($guid); 

					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetHouse";
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
					
					if($project['baseInformation']['newConstruction']!= 1){
						$childs_house[$key]['streetAddress'] = $_object['streetAddress'];
						$childs_house[$key]['guid'] 		 = $_object['id'];
					}
				}
			}	
		}
		/* Plots subtype records */
		$childs_plots = [];
		foreach($customer_objects as $object){
			
			foreach($object['plots'] as $key => $_object){
				if($_object['status']['name'] == 'Till salu'){
					
					unset($succession['method']);
					$guid       =  $_object['id'];
					
					$api_url 	= "https://connect.maklare.vitec.net/Estate/GetPlot"; 
					$data 		= "?estateId=".$guid."&customerId=".$succession['customer_id']."&onlyFutureViewings=False";
					$api_url 	= $api_url.$data;
					$project 	= httpRequest($api_url, $succession);
// echo "<pre>"; print_r($guid); 					
					if($project['baseInformation']['newConstruction']!= 1){
						
						$childs_plots[$key]['streetAddress'] = $_object['streetAddress'];
						$childs_plots[$key]['guid'] 		 = $_object['id'];
					}
				}
			}	
		}
		$childs  =  array_merge($childs, $childs_house, $childs_plots);
		return $childs;
		/* echo '<pre>' ; print_r($childs); 
		exit(); */
		
	}
	
	/**********************************************/
	/***** Function To remove prefix ******/
	/**********************************************/
	
	function remove_prefix_from_guid($prefix, $guid){
		
		if(strpos($guid, $prefix) !== false){
			$guid = str_replace($prefix,"", $guid);
		}
		return $guid;		
	}
