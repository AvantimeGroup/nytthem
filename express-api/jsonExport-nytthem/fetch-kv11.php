<?php 
include('functions.php');

$parentID = "CMNYPROD56TICMLQGE4OSRT5";

$projekt_table_name = 'wp_express_anvandare';
$child_table_name 	= 'wp_child_express_records_new';

$query = "SELECT * FROM `".$child_table_name."` where `parent_ID`='".$parentID."'";

$results = mysqli_query($links, $query);

$main_data = $result = [];

if ($results->num_rows > 0)
{
	$counter = 1;
	$statusprice = '';
	while($row = $results->fetch_assoc())
	{	
		$baseInformation 	= unserialize($row['baseInformation']);
		$floorAndElevator 	= unserialize($row['floorAndElevator']);
		$assignment 		= unserialize($row['assignment']);
		$interior 			= unserialize($row['interior']);
		
		if($assignment['status']['name'] == 'Bokad'){
			$statusprice = '';
		}else{
			$price 	= unserialize($row['price']);
			$statusprice = $price['startingPrice'];
		}
	
		$aprno = isset($baseInformation['apartmentNumber']) ? $baseInformation['apartmentNumber'] : 'NA-'.$counter;
		
		$records = array(
						'available' =>	$assignment['status']['name'],
						'fee' 		=>	$baseInformation['monthlyFee'],
						'floor' 	=>	$floorAndElevator['floor'],
						'price' 	=>	$statusprice,
						'rooms' 	=>	$interior['numberOfRooms'],
						'size' 		=>	$baseInformation['livingSpace'],
					);
		
		$main_data[$aprno] 	= $records;
		$counter++;
	}
	$pquery = "SELECT * FROM `".$projekt_table_name."` where `estateId`='".$parentID."'";
	$presult = mysqli_query($links, $pquery);
	$presult = $presult->fetch_assoc();

	$result['info'] = array(
						'changeTime' =>	$presult['dateChanged'],
						'unit' 		 =>	'metric',
						'language'   =>	'sv',
					);
	$result['apts']  = $main_data;
	// echo "<pre>"; print_r($result); die;
	
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($result); exit;
	
}else{
	echo "No record found!"; exit;
}


							