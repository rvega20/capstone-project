<?php require_once('includes/auth.include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Rocket Quiz Us!</title>

	<?php include('includes/header.include.php'); ?>
	<?php include('includes/scripts.include.php'); ?>
	<link href="css/owl.carousel.css" rel="stylesheet">
	<link href="css/owl.theme.css" rel="stylesheet">

</head>
<body>
	<?php include('includes/nav.include.php'); ?>
	<?php
	$_SESSION['authenticated']=false;
//  Login



	if( isset($_POST['login_email']) && isset($_POST['login_password']) ){

		if ($stmt = mysqli_prepare($link, "SELECT `Password` FROM `users` WHERE `Email`=?")) {

			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "s",$_POST['login_email']);

			/* execute query */
			mysqli_stmt_execute($stmt);

			/* bind result variables */
			mysqli_stmt_bind_result($stmt, $result);

			/* fetch value */
			mysqli_stmt_fetch($stmt);

			/* close statement */
			mysqli_stmt_close($stmt);
		}

		if( isset($_POST['login_password']) && $_POST['login_password'] === $result ) {
			$_SESSION['authenticated']=true;
			$_SESSION['username']=getFirstName($_POST['login_email'])."   ".getLastName($_POST['login_email']);
			$_SESSION['userID']=getUserID($_POST['login_email']);

			if(isTeacher($_POST['login_email'])){
				$_SESSION['isTeacher'] = true;
				header( 'Location: teacher.php' ) ;
					
			}

			else if(!isTeacher($_POST['login_email'])) {
				$_SESSION['isTeacher'] = false;
				header( 'Location: student.php' ) ;
			} 
		}
//display the errors next time
		else {

			echo '<div style="margin-bottom:1%; margin-top:-1%; margin-left:75%; color:red; font-weight:bold;">'."Incorrect Password !".'</div>';

		}
	}
	?>

	<div class="container">
		<div id="myCarousel" class="carousel slide hidden-sm hidden-xs" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#mainCarousel" data-slide-to="1"></li>
				<li data-target="#mainCarousel" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active slide1">
					<div class="carousel-caption">
						<h1>Rocketquiz Classroom.</h1>
						<h2>Sign Up Today!</h2>
						<p>We aim to build a better and brighter classroom for tomorrow.</p>
						<p><a class="btn btn-lg btn-primary" href="register.php"  role="button">Register</a></p>
					</div>
				</div>

				<div class="item slide2">
					<div class="carousel-caption">
						<h2>Take Advantage of Mobile Technology.</h2>
						<p>Do away with dedicated clicker devices altogether. Use any smartphone with web access and never miss a quiz again!</p>
						<p><a class="btn btn-lg btn-primary" href="#myAnchor" id="anchor1" role="button">Learn more</a></p>
					</div>
				</div>
				<div class="item slide3">
					<div class="carousel-caption">
						<h1>This project is brought to you by Team B6.</h1>
						<p> <br>College of Engineering Design Expo 
							<br>University of Toledo 2014

						</p>
					</div>
				</div>
			</div>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div></div>


		<div id="owl-demo" class="owl-carousel hidden-md hidden-lg">
			<div class="item"><img  src="img/fullimage1.jpg"></div>
			<div class="item"><img  src="img/fullimage2.jpg"></div>
			<div class="item"><img  src="img/fullimage3.jpg"></div>
		</div>

		<script src="js/jquery-1.9.1.min.js"></script> 
		<script src="js/owl.carousel.js"></script>


		<!-- Demo -->

		<style>
			#owl-demo .item img{
				display: block;
				height: auto;
				margin: 0 auto;
			}
		</style>


		<script>
			$(document).ready(function() {
				$("#owl-demo").owlCarousel({

					navigation : false,
					slideSpeed : 300,
					paginationSpeed : 400,
					singleItem : true,
				});
			});
		</script>

		<div class="container">

		</div>

		<div class="container marketing">

			<!-- Three columns of text below the carousel -->
			<div class="row">
				<div class="col-md-4 col-lg-4 mobile">

					<a align="center"><img src="../img/mobile.png" alt="Generic placeholder image"></a>
					<h2>Use any Smart Phone</h2>
					<p>RocketQuiz is compatible with all mobile devices with web browsing capabilities.</p>

				</div><!-- /.col-lg-4 -->
				<div class="col-md-4 col-lg-4 Analysis">
					<img src="../img/Student.png" alt="Generic placeholder image">
					<h2>Student Rosters</h2>
					<p>Wondering who's in your course? With classroom rosters you can quickly see who's in your class.</p>
				</div><!-- /.col-lg-4 -->
				<div class="col-md-4 col-lg-4 Analysis">
					<img src="../img/Numbers-icon.png" alt="Generic placeholder image">
					<h2>Student Analysis</h2>
					<p>Keep up to date on grades, attendance, and individual student performance.</p>

				</div><!-- /.col-lg-4 -->
			</div><!-- /.row -->

			<?php include('includes/footer.include.php'); ?>
		
		</div>
		<!-- /END THE FEATURETTES -->

	</div>

</div>

</body>


<script>
	$(document).ready(function() {

		$("#owl-demo").owlCarousel({

	  navigation : true, // Show next and prev buttons
	  slideSpeed : 300,
	  paginationSpeed : 400,
	  singleItem:true
	  
	});

	});
</script>

<script src="assets/js/application.js"></script>

</html>
