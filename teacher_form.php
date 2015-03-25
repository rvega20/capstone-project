<?php require_once('includes/auth.include.php'); 
restrictAccess("teachers");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Rocket Quiz Us!</title>

	<?php include('includes/header.include.php'); ?>

</head>
<body>
<?php include('includes/nav.include.php'); ?>
<?php 

$teacherID = $_SESSION['userID'];

if ($stmt = mysqli_prepare($link, "INSERT INTO `capstone`.`classes` (`ClassID`, `Name`, `Description`, `TeacherID`) VALUES (NULL, ?,?,?)")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "sss", $_POST['csubject'], $_POST['ctitle'], $teacherID);

    /* execute query */
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    
    /* close statement */
    mysqli_stmt_close($stmt);        
 }
 if(isset($_POST['csubject']) && $_POST['ctitle'])  {
header( 'Location: teacher.php' ) ;
} 
?>
<div class="container board active" id="createclass">
		<form class="form-horiztonal registerform" method="post" action="teacher_form.php">
			<fieldset>
				<h1 class="rf">Create A Class</h1>
				<div class='control-group'>
					<label class="control-label pad" for="csubject">Class Subject</label>
					<div class="controls">
					<input id="csubject" name="csubject" type="text" placeholder="Class Subject" class="form-control" required>
					</div>
				<!-- Select Basic -->

				<div class='control-group'>
					<label class="control-label pad" for="ctitle">Course Title</label>
					<div class="controls">
						<input id="ctitle" name="ctitle" type="text" placeholder="Class Section" class="form-control" required>
						</div>
					</div>
					<!-- Button -->
					<div class="control-group">
						<label class="control-label" for="submit"></label>
						<div class="controls ">
							<button href="teacher.php" type="submit" id="submit" name="submit" class="btn btn-success btn-lg submit show1">Submit</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
			<?php include('includes/footer.include.php'); ?>
		</body>

<?php include('includes/scripts.include.php'); ?>

</html>