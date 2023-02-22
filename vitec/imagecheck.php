<?php
if(isset($_REQUEST['GUID'])){
	
		
		echo $image = '<img src="http://fastighet.capitex.se/CapitexResources/Capitex.Datalager.DBFile/Capitex.Datalager.DBFile.dbfile.aspx?g='.$_REQUEST['GUID'].'&t=CBild">';
}

	

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Image Check</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
 <div class="col-md-4 col-md-offset-4">
 <h1>Check for Image</h1>	
  <form action="" class="form-inline">
    <div class="form-group">
      <label for="guid">Enter GUID :</label>
      <input type="text" class="form-control" id="GUID" required placeholder="GUID" name="GUID">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
</div>
</body>
</html>