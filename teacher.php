<?php require_once('includes/auth.include.php'); 
restrictAccess("teachers");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HomePage</title>

	<?php include('includes/header.include.php'); ?>
	
	<script type="text/javascript">
	$('link[rel=stylesheet][href~="css/flat-ui.css"]').remove();
	</script>
</head>
<body>
<?php include('includes/nav.include.php'); ?>
<script>
  $(document).ready(function() {  
     $('input[name=classID]').click(function(e) {
     session = $(this).attr('id')

     $.post('teacher.php', {session:session}
    );              
     });
     });
</script>
<?php  if(isset($_POST['classID'])){
 $_SESSION['classID'] = $_POST['classID'];}?>

<?php 
if (!isset($_SESSION['classID'])){
	$teacher = $_SESSION['userID'];
	if ($clas = mysqli_prepare($link, "SELECT ClassID FROM classes
			WHERE classes.TeacherID = $teacher")) {
		mysqli_stmt_execute($clas);
		mysqli_stmt_bind_result($clas, $ClassID);
		if (mysqli_stmt_fetch($clas)) {
			$_SESSION['classID'] = $ClassID;
		}
 mysqli_stmt_close($clas);}}
?>
	<div class="container">
		<div class="jumbotron j1">
			<div class="container">
		<?php
if (isset($_SESSION['classID'])){
	$course = $_SESSION['classID'];

	if ($class = mysqli_prepare($link, "SELECT ClassID,Name, Description FROM classes
			WHERE classes.ClassID = $course")) {
		mysqli_stmt_execute($class);
		mysqli_stmt_bind_result($class,$courseID,$className,$classDescription);

		while (mysqli_stmt_fetch($class)) {
			echo "<h1 class=\"page-header\" style=\"text-align:center;\">$className</h1>";
			echo "<p class=\"lead\"><kbd>$classDescription<br/>Student Access ID: $courseID</kbd></p>";
		}
 mysqli_stmt_close($class);}} else{
 	echo "<h1>Welcome to a new Classroom!</h1>";
 	echo "<p class=\"lead\"><kbd>Congratulations you've arrived here.Get started Below!</kbd></p>";
 }
?>
			</div>
		</div>
		<div id="infoi" class="show3" style="text-align:center">

			<a class="btn btn-lg btn-success" href="teacher_form.php" id="Teachertrigger"  role="button" ><span class="glyphicon glyphicon-plus"></span> Create a Class</a>
			<a class="btn btn-lg btn-primary" href="#" data-toggle="modal" data-target="#classModal" id="Teachertrigger1" role="button"><span class="glyphicon glyphicon-list" ></span>&nbsp;&nbsp;&nbsp;Select A Class</a>
		</div>
	</div>
	
	<?php if (isset($_SESSION['classID'])){ ?>
	<div class="row text-center rw2 testing">
		<div class="container pass">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="class center-block">
					<img src='../img/Quiz.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head1">Quizzes</h3>
						<p>Create or edit an existing Quiz.</p>
						<ul>
							<li>Import/Export Quiz Banks</li>
							<li>Create A quiz from scratch</li>
							<li>Rank questions by difficulty</li>
							<br/>
						</ul>
						<a class="btn btn-primary" href="create_quiz.php" role="button">Create Quiz</a>
					</div>
				</div>
			</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="class center-block">
					<img src='../img/classroom.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head2">Classroom</h3>
						<p>Check on your class.</p>
						<ul>
							<li>Real-Time Chat</li>
							<li>View Students by class</li>
							<li>Take Attendance</li>   
							<br/>    
						</ul>
						<a href="class_classroom.php" class="btn btn-primary btn1" role="button">Class</a>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="class center-block">
					<img src='../img/Student Scores.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head3"> Student Results</h3>
						<p>View Students results.</p>  
						<ul>
							<li>Organized by Name</li>
							<li>View student averages</li>
							<li>View question difficulties</li>
							<br/>
						</ul>
						<a href="class_results.php" class="btn btn2 btn-primary btn1" role="button">Results</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else {?>
	<div class="row text-center rw2 testing greyedout"  +filter: grayscale(100%); >
		<div class="container pass" disabled>
			<div class="col-xs-12 col-sm-6 col-md-4" disabled>
				<div class="class center-block" disabled>
					<img src='../img/Quiz.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head1">Quizzes</h3>
						<p>Create or edit an existing Quiz.</p>
						<ul>
							<li>Import/Export Quiz Banks</li>
							<li>Create A quiz from scratch</li>
							<li>Rank questions by difficulty</li>
							<br/>
						</ul>
						<a class="btn btn-primary" href="create_quiz.php" role="button" disabled>Create Quiz</a>
					</div>
				</div>
			</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="class center-block">
					<img src='../img/classroom.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head2">Classroom</h3>
						<p>Check on your class.</p>
						<ul>
							<li>Real-Time Chat</li>
							<li>View Students by class</li>
							<li>Take Attendance</li>   
							<br/>    
						</ul>
						<a href="class_classroom.php" class="btn btn-primary btn1" role="button" disabled>Class</a>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="class center-block">
					<img src='../img/Student Scores.jpg' alt="No photo here, move on folks.">
					<div class="caption">
						<h3 id="head3"> Student Results</h3>
						<p>View Students results.</p>  
						<ul>
							<li>Organized by Name</li>
							<li>View student averages</li>
							<li>View question difficulties</li>
							<br/>
						</ul>
						<a href="class_results.php" class="btn btn2 btn-primary btn1" role="button" disabled>Results</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>

<form action="" method="post">
	<!--Select Class Modal-->
	            <div class="modal fade" id="classModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog ">
				 	 <div class="modal-content ">

						<div class="modal-body ">
							<div class="form-group">
								<label for="subject">Select Class</label>
								<select id="classID" name="classID" class="form-control" required="required">
									<option selected="">Choose One</option>
									<?php
										$teacherID = $_SESSION['userID'];
										if ($classes = mysqli_prepare($link, "SELECT ClassID, Name, Description FROM classes WHERE TeacherID = ?")) {
											mysqli_stmt_bind_param($classes, "i", $teacherID);
											mysqli_stmt_execute($classes);
											mysqli_stmt_bind_result($classes , $classID, $Name, $Description);

											while (mysqli_stmt_fetch($classes)) {
												echo "<option id=\"class\" name=\"class\" value=\"$classID\">".$Name." ".$Description."</option>";  
												
											}
											mysqli_stmt_close($classes);
											mysqli_close($link);
										}
									?>
							</select>
							</div><div class="text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
							<input type="submit" value="Submit" class="btn btn-sm btn-success" id="clickme"></div></div>
                     </div>
                   </div>
                </div>					   
    <!--Select Class Modal End-->	
 </form>
			<?php include('includes/footer.include.php'); ?>

		</div>
	</div>

<script>
    var classID=document.getElementById('subject') /*FIXME this should update each time the dropdown selection is changed.. so we can pass the selected dropdown item to next page..?*/
    classID.onchange = function() {
        classUpdate.value = classID.value;
        alert("testing...");
    }
</script>

</body>

<?php include('includes/scripts.include.php'); ?>

</html>


