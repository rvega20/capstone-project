<?php require_once('includes/auth.include.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Unathorized Access</title>
	<link rel="stylesheet" media="screen,projection" href="css/ui.totop.css" />
</head>
<body>
	<?php include ('includes/nav.include.php');
	 include('includes/header.include.php');
	?>

    <div class="text-center">
       <img src="img/stop.jpg" width="30%"; height="50%;">
    </div>
    <div class="col-md-10 text-center" style=" font-size:22px; color:red; margin-top:3%; margin-left:6%;" >
	<p><i class="glyphicon glyphicon-exclamation-sign"></i><i class="glyphicon glyphicon-exclamation-sign"></i> Unauthorized Access Please Log In</p>
	</div>
	<div class="footer row " style="margin-top:10%; margin-left:5%;">
	<?php include('includes/footer.include.php'); ?>
	</div>
</body>

</html>
