<?php
session_start();

if (!isset($_SESSION['login_user'])) {
	
	header("location: login");
	
}
include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<title>API Data</title>
	<link rel="icon" type="image/png" href="https://nytthem.se/wp-content/themes/NyttHemLatest/img/favicon.ico">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fff;">
	<div class="tableapi_section">
		<div id="loader-icon" style="display: none;">
			<img src="images/loaderIcon.gif">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="api_button_main">
						<div class="tableapi_inner">
							<button class="menu active" data-type="get_successions">Succession</button>
						</div>
						<div class="tableapi_inner">
							<button class="menu" data-type="get_projekts">Projekt</button>
						</div>
						<div class="tableapi_inner">
							<button class="menu" data-type="get_succession_projekts">Succession Projekt</button>
						</div>
						<div class="logout_btn">
							<img class="menuImg" src="images/loggaut.svg">
							<a href="logout.php">Logga ut</a>
						</div>
					</div>
				</div>						
			</div>
			<div class="row">   
				<div class="col-md-12">
					<div class="heading_main">
						<h1 class="projekt_heading">Succession</h1>
						<button type="button" class="show_all">Show All</button>
					</div>
				</div>
				<div class="all_api_data"></div>
				<div class="col-md-12" id="project_listing">
					<?php 
					
					$successions = get_successions_data(); 
//					echo "<pre>"; print_r($successions); 
					if($successions){
						$counter = 1;
						foreach($successions as $succession){ 
						
						$prefix = "CMBOLGH";
						$guid  = remove_prefix_from_guid($prefix, $succession['guid']);
						$succession_url = "https://nytthem.se/succession/?guid=".$guid;
						
						$class = ($counter % 2 == 0)? "even" : "odd";
						//echo "<pre>"; print_r($successions); die;
					?>	
						<div class="api_table <?php echo $class; ?>">
							<div class="api_content">
								<h2>Namn</h2>
								<h4><?php echo $succession['streetAddress']; ?></h4>
							</div>
							<div class="api_content">
								<h2>GUID</h2>
								<h4><?php echo $succession['guid']; ?></h4>
							</div>
							<div class="api_content">
								<h2>Lank</h2>
								<h4><a target="_blank" href="<?php echo $succession_url; ?>">URL tor nytthem</a></h4>
							</div>
							<div class="api_content">
								<h2>Handling</h2> 
								<h4><a target="_blank" href="https://nytthem.se/vitec_express_succession/succession_cron.php?name=Objekt&type=Estate&event=Update&customerId=S13751&subtype=HousingCooperative&id=<?php echo $succession['guid']; ?>">Uppdatering</a></h4>
								<span class="loader_gif"><img src="images/refresh.svg" data-type="succession" data-guid="<?php echo $succession['guid']; ?>" class="img-fluid"></span>
								<span class="loader_gif loader"><img src="images/loader.gif" class="img-fluid"></span>
							</div>
						</div>
						<?php $counter++; }
					} ?>	
				</div>
			</div>
			<!--div class="row">
				<div class="col-md-12">
					<div class="output_result">
					
					</div>
				</div>
			</div-->
		</div>	
	</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/custom.js?ver=1.2"></script>
</body>
</html>
