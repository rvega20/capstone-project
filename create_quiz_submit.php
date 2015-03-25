<?php require_once('includes/auth.include.php'); 
restrictAccess();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php include('includes/header.include.php'); ?>
</head>
<body>
<?php include('includes/nav.include.php'); ?>
<?php

if (!empty($_POST))
{
	require_once('database/connect.php');
	// Turn off all error reporting
	error_reporting(0);
	$classID = $_SESSION['classID'];
	if ($quiz_stmt = mysqli_prepare($link, "INSERT INTO quizzes (`ClassID`, `Name`, `ActiveDate`, `DeadlineDate`, `CompletionTime`) VALUES (?,?,NOW(),NOW() + INTERVAL 2 HOUR,0);")) {
		mysqli_stmt_bind_param($quiz_stmt, "ss",$classID,$_POST['name']);
		mysqli_stmt_execute($quiz_stmt);
		mysqli_stmt_get_result($quiz_stmt);
		mysqli_stmt_close($quiz_stmt);
	}

	/* Pull the newly generated quizID */
	$quizid = mysqli_insert_id($link);

	if ($quizid){
		$quiztype = "multi";
		$questionValue = 1;

		foreach ($_POST['q'] as $qnum => $qtext) {
			/* If we hit a blank question, we are DONE */
			if ($qtext == ""){
				break;
			}

			if ($question_stmt = mysqli_prepare($link, "INSERT INTO questions (`QuizID`, `Text`, `Type`, `PointValue`, `Order`) VALUES (?,?,?,?,?);")) {
				mysqli_stmt_bind_param($question_stmt, "issii", $quizid, $qtext, $quiztype, $questionValue, $qnum);

				if (!mysqli_stmt_execute($question_stmt)) {
					echo "Execute failed: (" . mysqli_stmt_errno($question_stmt) . ") " . mysqli_stmt_error($question_stmt);
				}
				mysqli_stmt_close($question_stmt);

				/* Pull the newly generated questionID */
				$questionid = mysqli_insert_id($link);

				/* Now enter the corresponding answers */
				foreach ($_POST['a'][$qnum] as $anum => $atext) {
					
					/* If we hit a blank answer, we are DONE */
					if ($atext == ""){
						break;
					}

					/* Check to see if our answer is marked as a correct answer */
					if (array_key_exists($anum, $_POST['check'][$qnum])){
						$is_correct = True;
					}
					else {
						$is_correct = False;
					}

					if ($answer_stmt = mysqli_prepare($link, "INSERT INTO answers (`QuestionID`, `Text`, `IsCorrect`, `Order`) VALUES (?,?,?,?);")) {
						mysqli_stmt_bind_param($answer_stmt, "isii", $questionid, $atext, $is_correct, $anum);

						if (!mysqli_stmt_execute($answer_stmt)) {
							echo "Execute failed: (" . mysqli_stmt_errno($answer_stmt) . ") " . mysqli_stmt_error($answer_stmt);
						}
						mysqli_stmt_close($answer_stmt);
					}
					else{
						echo "Execute failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
					}
				}

			}
			else{
				echo "Execute failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
			}
		}

	}
	else {
		printf("Quiz Creation failed!");
	}
}
?>
<div class="text-center" style="margin-top:15%;">
<h1> Congratulations on creating a new quiz</h1><br/>
<p> Click the button below to go back to your homepage or wait 5 seconds to be redirected</p>
<button href="teacher.php" class="btn btn-primary" style="margin-bottom:20%;">Home</button>
</div>

<?php header( "refresh:5;url=teacher.php" );?>
	<?php include('includes/footer.include.php'); ?>
</body>

<?php include('includes/scripts.include.php'); ?>
</html>