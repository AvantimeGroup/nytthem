<?php 
error_reporting(E_WARNING);
require_once('../wp-load.php');
define('WP_CACHE', false);

include('functions.php');

$links = mysqli_connect('localhost', 'virendervitect', 't3uytMHyDg');
mysqli_select_db($links, 'nytthem_vitec') or die('Unable to select database, Please Check Your Connection..');

$parentID = "CMNYPROD56TICMLQGE4OSRT5";
//$child_table_name = 'wp_child_express_records_new';
//$query = "SELECT baseInformation FROM `".$child_table_name."` where `estateId`='".$parentID."'";
//$child_result = mysqli_query($links,$query);
$guid  		=  $parentID;
$api_url 	= "https://connect.maklare.vitec.net/Estate/GetProject"; 
$data 		= "?projectId=".$guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
$api_url 	= $api_url.$data;

$project =  httpRequest($api_url, $projekt);
$apartments = $result = [];

if($project){
	
	$dateChanged   = strtotime($project['dateChanged']);
	
	foreach ($project['housingCooperatives'] as $c_guid){
		
		$URL = "https://connect.maklare.vitec.net/Estate/GetHousingCooperative";
		$data = "?estateId=".$c_guid."&customerId=".$projekt['customer_id']."&onlyFutureViewings=False";
		$URL = $URL.$data;
		
		$child_data =  httpRequest($URL, $projekt);
		
		if($child_data){
			
			$main_data = array(
							'available' =>	$child_data['assignment']['status']['name'],
							'fee' 		=>	$child_data['baseInformation']['monthlyFee'],
							'floor' 	=>	$child_data['floorAndElevator']['floor'],
							'price' 	=>	$child_data['price']['startingPrice'],
							'rooms' 	=>	$child_data['interior']['numberOfRooms'],
							'size' 		=>	$child_data['baseInformation']['livingSpace'],
						);
			
			$apartments[$child_data['baseInformation']['apartmentNumber']]  =  $main_data;
		}

	}

	$result['info'] = array(
						'changeTime' =>	date('Y-m-d H:i:s',$dateChanged),
						'unit' 		 =>	'metric',
						'language'   =>	'sv',
					);
	$result['apts']  = $apartments;
	header('Content-Type: application/json; charset=utf-8');
	//echo json_encode($result, JSON_PRETTY_PRINT); 
	echo json_encode($result); 
	exit;
}else{
	echo "Projekt not found!";
}
