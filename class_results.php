<?php require_once('includes/auth.include.php'); 
restrictAccess("teachers");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Classes</title>
	    <link href="css/tablecloth.css" rel="stylesheet">
	<?php include('includes/header.include.php'); ?>
</head>
<body>
	<?php include('includes/nav.include.php'); ?>
	<div class="container-fluid">

		<?php require_once('database/connect.php');
		if (isset($_SESSION['userID'])){
			$teacherID = $_SESSION['userID'];
			$course = $_SESSION['classID'];
		}
		else {
			$teacherID = 1;
		}


		$query = "SELECT ClassID, Name, Description FROM classes WHERE classes.ClassID = $course";

		if ($class_stmt = mysqli_prepare($link, $query)) {
			mysqli_stmt_execute($class_stmt);
			mysqli_stmt_bind_result($class_stmt, $classID, $className, $classDescription);

			while (mysqli_stmt_fetch($class_stmt)) {
			}
			mysqli_stmt_close($class_stmt);
		}
			?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="text-center">
					<h1 style="margin-top:0;"><?php echo $className; ?></h1>
					<h5 style="margin-bottom:2%;">Grade Book</h5>
</div>
					<div class="row">
						<div class="col-md-12">
	
							<table class="table" id="gradebook">
								<thead>
									<tr>
										<th><b>Quiz Name</b></th>
										<th><b>Student</b></th>
										<th><b>Points</b></th>
										<th><b>Grade</b></th>
									</tr>
								</thead>
								<tbody>
								<?php
								error_reporting(0);
								$query = "SELECT users.`UserID`,users.`FirstName`, users.`LastName`, registrations.ClassID, quizzes.QuizID, quizzes.Name, results.PointsPossible, results.PointsScored 
								from users 
								LEFT OUTER JOIN results ON users.UserID = results.StudentID 
								INNER JOIN quizzes ON results.QuizID = quizzes.QuizID 
								INNER JOIN registrations ON users.UserID = registrations.UserID AND registrations.ClassID = quizzes.ClassID
								 WHERE quizzes.ClassID = $course\n";

								if ($quiz_stmt = mysqli_prepare($link, $query)) {
									mysqli_stmt_execute($quiz_stmt);
									mysqli_stmt_bind_result($quiz_stmt, $userID, $firstName, $lastName, $ClassID, $quizID,$quizName,$pointsPossible, $pointsScored);

									$totalPointsPossible = 0;
									$totalPointsScored  = 0;

									while (mysqli_stmt_fetch($quiz_stmt)) {
										$grade = round((float)($pointsScored/$pointsPossible) * 100 ) . '%'; 
										echo "<tr>";
										echo "<td>$quizName</a></td>";
										echo "<td>$firstName $lastName</td>";
										echo "<td>$pointsScored/$pointsPossible</td>";
										echo "<td>$grade</td>";
										echo "</tr>";
										$totalPointsPossible += $pointsPossible;
										$totalPointsScored += $pointsScored;
									}
									mysqli_stmt_close($quiz_stmt);

								}
				
								?> 
								</tbody>
							</table>
							<?php 									if ($totalPointsPossible) {
									$classaverage = round((float)(($totalPointsScored / $totalPointsPossible) * 100)) . '%';
									echo "<p style=\"margin-bottom:1%;\">Class Average for ". $className ." = ". $classaverage."</p>";
									}?>
						</div>
					</div>
				</div>
			</div>
	</div></div>
	    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.metadata.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/jquery.tablecloth.js"></script>
        <script type="text/javascript" charset="utf-8">
      $(document).ready(function() {
        $("table").tablecloth({
          theme: "paper",
          bordered: true,
          striped: true,
          sortable: true,
          condensed: false
        });
      });
    </script>
	<?php include('includes/footer.include.php'); ?>
</div>
</body>


</html>