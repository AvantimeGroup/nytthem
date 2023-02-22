<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
	<link rel="icon" type="image/png" href="https://www.nytthem.se/wp-content/themes/NyttHemLatest/img/favicon.ico">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
session_start();
$message = '';

if (isset($_POST["log_in"])) {
    
    $email 		= trim($_POST['email']);
    $password 	= trim($_POST['password']);
	
    if ($email == "chisburg@gmail.com" && $password == "Nytthem@2020") {
        
        $_SESSION['login_user'] = 1;
		header("location: list");
		
    } else {
		
        $message = '<div class="alert alert-danger alert-dismissible">
						<strong>Error!</strong> Invalid Email or Password.
					</div>';
    }
}
?>
	<div class="signup-form wklog_in">
		<?php echo $message; ?>
		<form action="" method="post">
			<h2>Login</h2>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
					<input type="email" class="form-control" name="email" placeholder="Email Address" required="required">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="password" placeholder="Password" required="required">
				</div>
			</div>
			<div class="form-group">
				<input type="submit" value="Log In" name="log_in" class="btn btn-primary btn-block btn-lg">
			</div>
		</form>
	</div>

</body>
</html>    
