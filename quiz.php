<?php require_once('includes/auth.include.php'); 
restrictAccess();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz - RocketQuiz.us</title>
	<?php include('includes/header.include.php'); ?>
</head>
<body>
	<?php include('includes/nav.include.php'); 

		if (isset($_GET['id'])){
			$quizID = $_GET['id'];	
			/* store the quizID in the form for submit() to use */
		}
		else{
			/* If the quiz id isn't set, send them to a place where they can choose the quiz they want */
			header( 'Location: index.php' ) ;
		}

		require_once('database/connect.php');

		$query = "SELECT
				quizzes.Name AS QuizName, 
				quizzes.ActiveDate, 
				quizzes.DeadlineDate, 
				quizzes.CompletionTime, 
				classes.Name AS ClassName, 
				classes.Description AS ClassDescription, 
				users.LastName, 
				users.Email 
			FROM quizzes
				JOIN classes ON quizzes.ClassID = classes.ClassID
				JOIN users ON classes.TeacherID = users.UserID
			WHERE IsTeacher = 1 
			AND quizzes.QuizID = ?;";

		if ($quiz_stmt = mysqli_prepare($link, $query)){
			mysqli_stmt_bind_param($quiz_stmt, "i", $quizID);
			mysqli_stmt_execute($quiz_stmt);
			mysqli_stmt_bind_result($quiz_stmt, $quizname, $activedate, $deadlinedate, $completiontime, $classname, $classdescription, $lastname, $email);
			mysqli_stmt_fetch($quiz_stmt);
			mysqli_stmt_close($quiz_stmt);
		}
		else {
			echo (mysqli_error($link));
		}
	?>

	<div class="container">
		<div class="row">
			<h1><?php echo($quizname); ?></h1><p>
			<?php
				printf("<em>Created on %s by <a href='mailto:%s'>Professor %s</a>.</em><br>", date("l, F j, Y - h:i A",strtotime($activedate)), $email, $lastname);



				if ($completiontime) {
					printf("Time to complete: %s Minutes<br>", $completiontime);
				}
				else {
					printf("Deadline: %s<br>", date("l, F j, Y - h:i A",strtotime($deadlinedate)));
				}
			?>
			</p>
		</div>
		<div class="row">
			<form role="form" action="result.php" method="post">
				<?php

					printf("<input type=\"hidden\" name=\"quizID\" value=\"$quizID\">");
					
					/* Load the list of questions */
					if ($questions = mysqli_prepare($link, "SELECT `Text`, `Type`, `PointValue`, `QuestionID` FROM `questions` WHERE `QuizID`=? ORDER BY `Order` ASC")) {
						mysqli_stmt_bind_param($questions, "i", $quizID);
						mysqli_stmt_execute($questions);
						mysqli_stmt_bind_result($questions, $questiontext, $type, $pointvalue, $questionid);
						mysqli_stmt_store_result($questions);

						printf("<ol>");

						while (mysqli_stmt_fetch($questions)) {
							printf ("<li>%s</li>", $questiontext);
							if ($answers = mysqli_prepare($link, "SELECT `Text`, `IsCorrect`, `AnswerID` FROM `answers` WHERE `QuestionID`=? ORDER BY `Order` ASC")) {
								mysqli_stmt_bind_param($answers, "i", $questionid);
								mysqli_stmt_execute($answers);
								mysqli_stmt_bind_result($answers, $answertext, $IsCorrect, $AnswerID);
								printf("<ol>");
								printf("<div class=\"col-xs-12\">");
								while (mysqli_stmt_fetch($answers)) {
									printf("<label class=\"radio\">");
									printf("<input type=\"radio\" name=\"%s\" value=\"%s\" data-toggle=\"radio\">%s<br>", $questionid, $AnswerID, $answertext);
									printf("</label>");
								}
								printf("</div>");
								printf("</ol>");
								mysqli_stmt_close($answers);
							}

						}
						printf("</ol>");

						mysqli_stmt_free_result($questions);
						mysqli_stmt_close($questions);
					}

					mysqli_close($link);

				?>
				<input type="submit" value="Submit">
			</form>
		</div>


		<?php include('includes/footer.include.php'); ?>
	</div>

	<script src="js/flatui-radio.js"></script>
	<script type="text/javascript">
		var groups = [];
		$(function() {
			$("input[type=radio][name]").each(function() {
				// Add the unique group name to the array
				if (groups[groups.length - 1] != $(this).attr("name")) groups.push($(this).attr("name"));
			});
		});
		$('form').submit(function () {
			var isValid = true;

			$.each(groups, function(i, o) {
				// For each group, check at least one is checked
				if (isValid) isValid = $("input[name='"+o+"']:checked").length;
			});

			if (!isValid) {
				alert("All questions must be answered!");
				return false;
			}

			return true;
		});
	</script>

	<?php include('includes/scripts.include.php'); ?>
</body>
</html>
