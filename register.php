<?php require_once('includes/auth.include.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Rocket Quiz Us!</title>

	<?php include('includes/header.include.php'); ?>

</head>

<body>
<?php 
include('includes/nav.include.php');


$errors=array();

if(isset($_POST['email']) && userAlreadyExists($_POST['email'])==1){
    array_push($errors, "User already exists !");
}
if(isset($_POST['email']) && !preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i', strtolower($_POST['email']))){
    array_push($errors, "Email not valid!");
}

if(isset($_POST['pass']) && $_POST['pass']!== $_POST['passcon']){
   array_push($errors, "Passwords do not match !");
}
if(isset($_POST['pass']) &&strlen($_POST['pass'])<6){
    array_push($errors,"Password should be at least 6 characters long"); 
}

// if there are errors display  them
if (count($errors)!=0){
	echo output_errors($errors);
}
// if not then register.
else {


/* create a prepared statement */
if ($stmt = mysqli_prepare($link, "INSERT INTO `capstone`.`users` (`UserID`, `FirstName`, `LastName`,`PhoneNumber`,`Email`,`Password`,`IsTeacher`) VALUES (NULL, ?,?,?,?,?,?)")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ssssss", $_POST['fname'], $_POST['lname'],$_POST['pnum'],$_POST['email'],$_POST['pass'],$_POST['accounttype'] );

    /* execute query */
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    
    /* close statement */
    mysqli_stmt_close($stmt);                                                        
}

//redirect user to right page   later thank you messages may be added or redirect after certain period of time
if(isset($_POST['email']) && IsTeacher( $_POST['email']))  {
header( 'Location: index.php' ) ;
}
else if(isset($_POST['email']) ){

	header( 'Location: index.php' ) ;
}
}  // register user

?>

<div class="container board active registerform" id="rmod">
				<form  method="post" action="register.php" class="form-horiztonal registerform" id="registerform" name="registerform" role="form">
					<fieldset>
						<h1 class="rf">Register</h1>
						<div class="control-group">
							<label class="control-label" for="inputFname">First Name</label>
							<div class="controls">
								<input id="inputFname" name="fname" type="text" placeholder="First Name" class="form-control" required>

							</div>
						</div>

						<!-- Text input-->
						<div class="control-group">
							<label class="control-label" for="inputLname">Last Name</label>
							<div class="controls">
								<input id="inputLname" name="lname" type="text" placeholder="Last Name" class="form-control" required >
								
							</div>
						</div>

						<!-- Text input-->
						<div class="control-group">
							<label class="control-label" for="inputLname">Phone Number</label>
							<div class="controls">
								<input id="inputLname" name="pnum" type="text" placeholder="Phone Number" class="form-control">
								
							</div>
						</div>
						
						<!-- Text input-->
						<div class="control-group">
							<label class="control-label" for="inputEmail">E-Mail</label>
							<div class="controls">
								<input id="inputEmail" name="email" type="text" placeholder="E-Mail" class="form-control" required>

							</div>
						</div>

						<!-- Password input-->
						<div class="control-group">
							<label class="control-label" for="inputPass">Password</label>
							<div class="controls">
								<input id="inputPass" name="pass" type="password" placeholder="Password" class="form-control" required>

							</div>
						</div>

						<!-- Password input-->
						<div class="control-group">
							<label class="control-label" for="inputPassCon">Confirm Password</label>
							<div class="controls">
								<input id="inputPassCon" name="passcon" type="password" placeholder="Confirm Password" class="form-control" required>
								
							</div>
						</div>
						
						<div class="control-group">
						   
							<label class="control-label" for="inputPassCon">Account Type</label>
								<div class="controls">
									<select class="form-control" id="subject" name="accounttype">
									   <option  value="0" selected>Student</option>
										<option value="1">Instructor</option>
									</select>			
								</div>
						</div>
						
						<!-- Button -->
						<div class="form-group">
							<label class="control-label" for="submit"></label>
							<div class="controls pull-right">
								<input type="submit" value="Submit" class="btn btn-lg btn-success">
							</div>
						</div>

					</fieldset>
				</form>
			</div>
<?php include('includes/footer.include.php'); ?>
	</body>
	<?php include('includes/scripts.include.php'); ?>
	</html>