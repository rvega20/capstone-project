<?php require_once('includes/auth.include.php'); 
restrictAccess("teachers");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Classes</title>
	<?php include('includes/header.include.php'); ?>
</head>
<body>
	<?php include('includes/nav.include.php'); ?>
	<div class="container-fluid">

		<?php require_once('database/connect.php');
		if (isset($_SESSION['userID'])){
			$teacherID = $_SESSION['userID'];
		}
		else {
			$teacherID = 1;
		}

		$query = "SELECT ClassID, Name, Description FROM classes WHERE classes.TeacherID = ?";

		if ($class_stmt = mysqli_prepare($link, $query)) {
			mysqli_stmt_bind_param($class_stmt, "s", $teacherID);
			mysqli_stmt_execute($class_stmt);
			mysqli_stmt_bind_result($class_stmt, $classID, $className, $classDescription);

			while (mysqli_stmt_fetch($class_stmt)) {

				$classes[] = [
					"classID" => $classID, 
					"className" => $className, 
					"classDescription" => $classDescription
					];

			}
			mysqli_stmt_close($class_stmt);
		}

		foreach ($classes as $class){
			?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="text-center">
					<h1 style="margin-top:0%;"><?php echo $class['className']; ?></h1>
					<p><em><?php echo $class['classDescription']; ?></em></p>
					<p><b>Student Access ID: <?php echo $class['classID']; ?></b></p>
					<hr></div>
					<div class="row">
						<div class="col-md-6">
							<h5>Quizzes</h5>
							<table class="table" style="margin-bottom:10%">
								<thead>
									<tr>
										<th>Quiz Name</th>
										<th>Created</th>
										<th>Due</th>
									</tr>
								</thead>
								<tbody>
								<?php

								$query = "SELECT QuizID, Name, ActiveDate, DeadlineDate FROM quizzes WHERE quizzes.ClassID = ?";

								if ($quiz_stmt = mysqli_prepare($link, $query)) {
									mysqli_stmt_bind_param($quiz_stmt, "s", $class['classID']);
									mysqli_stmt_execute($quiz_stmt);
									mysqli_stmt_bind_result($quiz_stmt, $quizID, $quizName, $quizActive, $quizDeadline);

									while (mysqli_stmt_fetch($quiz_stmt)) {
										$quizActiveDate = strtotime($quizActive);
										$quizCreatedDate = date('F j, Y', $quizActiveDate);
										$quizCreatedHour = date('g:i a', $quizActiveDate);
										$quizDeadlineDate = convertDate($quizDeadline);
										$quizDeadlineDate = strtotime($quizDeadline);
										$quizDueDate = date('F j, Y', $quizDeadlineDate);
										$quizDueHour = date('g:i a', $quizDeadlineDate);

										echo "<tr>";
										echo "<td><a href=\"quiz_results.php?id=$quizID\">$quizName</a></td>";
										echo "<td>$quizCreatedDate $quizCreatedHour </td>";
										echo "<td>$quizDueDate $quizDueHour</td>";
										echo "</tr>";
									}
									mysqli_stmt_close($quiz_stmt);
								}
								?>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<h5>Registered Students</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Student Name</th>
										<th>Phone</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>
								<?php

								$query = "SELECT FirstName, LastName, PhoneNumber, Email 
									FROM users
									INNER JOIN registrations 
									ON users.UserID = registrations.UserID
									WHERE ClassID = ? and IsTeacher = 0";

								if ($user_stmt = mysqli_prepare($link, $query)) {
									mysqli_stmt_bind_param($user_stmt, "s", $class['classID']);
									mysqli_stmt_execute($user_stmt);
									mysqli_stmt_bind_result($user_stmt, $firstName, $lastName, $phoneNumber, $email);

									while (mysqli_stmt_fetch($user_stmt)) {
										echo "<tr>";
										echo "<td>$firstName $lastName</td>";
										echo "<td>$phoneNumber</td>";
										echo "<td><a href=\"mailto:$email\">$email</a></td>";
										echo "</tr>";

									}
									mysqli_stmt_close($user_stmt);
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div></div>
	<?php include('includes/footer.include.php'); ?>
</div>
</body>

<?php include('includes/scripts.include.php'); ?>

</html>