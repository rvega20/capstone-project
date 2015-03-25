<?php require_once('includes/auth.include.php'); 
restrictAccess();
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
	/* First, make sure we have arrived here in the correct way */
	if(!isset($_POST['quizID'])){
		/* Redirect them away, there is no result! */
		header( 'Location: new_quiz.php' ) ;
	}

	function getArray($stmt) {
		$data = mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();

		$fields[0] = &$stmt;
		$count = 1;

		while($field = mysqli_fetch_field($data)) {
			$fields[$count] = &$out[$field->name];
			$count++;
		}

		call_user_func_array('mysqli_stmt_bind_result', $fields);
		if (!mysqli_stmt_fetch($stmt)){
			return false;
		}
		return (count($out) == 0) ? false : $out;
	}

	$quizID = $_POST['quizID'];
	$studentID = $_SESSION['userID'];
	
	$pointsScored = 0;
	$totalPointsPossible = 0;

	if ($answer_stmt = mysqli_prepare($link, "SELECT questions.QuestionID, questions.PointValue, answers.answerID FROM questions
		INNER JOIN answers ON questions.QuestionID = answers.QuestionID
		WHERE answers.IsCorrect AND questions.QuizID = ? ORDER BY answerID ASC")) {
		mysqli_stmt_bind_param($answer_stmt, "i", $quizID);
		mysqli_stmt_execute($answer_stmt);
		mysqli_stmt_store_result($answer_stmt);

		while($answer = getArray($answer_stmt)) {

			/*TODO Add each studentResponse to database here? */

			$totalPointsPossible += $answer['PointValue'];

			$question_id = $answer['QuestionID'];
			if (array_key_exists($question_id, $_POST)){
				if ($answer['answerID'] == $_POST[$question_id]){
					$pointsScored += $answer['PointValue'];
				}
			}
			else{
				/*Something is wrong, they missed a question */
			}
		}

		mysqli_stmt_close($answer_stmt);
	}


	$percent = round((float)($pointsScored/$totalPointsPossible) * 100 ) . '%';

	/*Adding each studentQuiz to database*/
	if ($studentQuiz = mysqli_prepare($link, "INSERT INTO results (`StudentID`, `QuizID`, `PointsScored`, `PointsPossible`) VALUES (?,?,?,?)")) {
		mysqli_stmt_bind_param($studentQuiz, "iiii", $studentID, $quizID, $pointsScored, $totalPointsPossible);

		if (!mysqli_stmt_execute($studentQuiz)) {
			echo "Execute failed: (" . mysqli_stmt_errno($studentQuiz) . ") " . mysqli_stmt_error($studentQuiz);
		}
		mysqli_stmt_close($studentQuiz);
	}

	?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
				<h1 class="page-header" style="text-align:center;">Quiz Results</h1>

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="table-responsive" style="overflow-x:hidden;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Points Scored</th>
								</tr>
								<tbody>
								<tr>
									<td>
										<?php echo($pointsScored); ?>
									</td>
								</tr>
							</tbody>
								<tr>
									<th>Total Points</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo($totalPointsPossible); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="Quiz_grade">
						<?php 
						if(($percent) >= 90){
							echo "<h1 class=\"Agrade\">A</h1>";
						}
						else if(($percent) >= 80){
							echo "<h1 class=\"Bgrade\">B</h1>";
						}
						else if(($percent) >= 70){
							echo "<h1 class=\"Cgrade\">C</h1>";
						}
						else if(($percent) >= 60){
							echo "<h1 class=\"Dgrade\">D</h1>";
						}
						else { 
							echo "<h1 class=\"Fgrade\">F</h1>";
						}
						?>
					<p class="Qpercent">
						<?php echo ($percent); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="margin-top:5%;">
				<ol>
				<?php

					/* create a prepared statement */
					if ($question_stmt = mysqli_prepare($link, "SELECT `Text`, `Type`, `PointValue`, `QuestionID` FROM `questions` WHERE `QuizID`=? ORDER BY `Order` ASC")) {
						mysqli_stmt_bind_param($question_stmt, "i", $quizID);
						mysqli_stmt_execute($question_stmt);
						mysqli_stmt_bind_result($question_stmt, $questiontext, $type, $pointvalue, $questionid);
						mysqli_stmt_store_result($question_stmt);

						while (mysqli_stmt_fetch($question_stmt)) {
							$pointvaluestring = (string)$pointvalue;
							if ($pointvalue == 1){
								$pointvaluestring .= " point";
							}
							else {
								$pointvaluestring .= " points";
							}

							printf ("<li><strong>%s</strong> (%s)", $questiontext, $pointvaluestring);
							if ($answer_stmt = mysqli_prepare($link, "SELECT `Text`, `IsCorrect`, `AnswerID` FROM `answers` WHERE `QuestionID`=? ORDER BY `Order` ASC")) {
								mysqli_stmt_bind_param($answer_stmt, "i", $questionid);
								mysqli_stmt_execute($answer_stmt);
								mysqli_stmt_bind_result($answer_stmt, $answertext, $IsCorrect, $AnswerID);

								echo ("<ul>");

								while (mysqli_stmt_fetch($answer_stmt)) {
									echo("<li style='list-style-type: none;'>");
									if ($IsCorrect == "1"){
										echo ("<span class='glyphicon glyphicon-ok-circle'></span>");
									}
									else {
									if ($_POST[$questionid] == $AnswerID ){
										echo ("<span class='glyphicon glyphicon-remove-circle'></span>");
									}
									else{
											echo ("<span class='glyphicon glyphicon-none'></span>");
										}
									}
									printf("%s</li>", $answertext);
									}

								echo ("</ul>");

								mysqli_stmt_close($answer_stmt);
							}
						}
						mysqli_stmt_free_result($question_stmt);
						mysqli_stmt_close($question_stmt);
					}

					mysqli_close($link);

				?>
				</ol>				
			</div>
		</div>
	<?php include('includes/footer.include.php'); ?>
	</div>
</body>

<?php include('includes/scripts.include.php'); ?>

</html>