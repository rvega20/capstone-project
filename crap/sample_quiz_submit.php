<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
function binarySearch($needle, $array)
{
	$start = 0;
	$end = count($array) - 1;

	while ($start <= $end) {
		$middle = (int) ($start + ($end - $start) / 2);
		if ($needle < $array[$middle]) {
			$end = $middle - 1;
		}
		else if ($needle > $array[$middle]) {
			$start = $middle + 1;
		}
		else {
			return $middle;/*instead of returning found value, return the position it is at?*/
		}
	}
	return false;
}

require_once('database/connect.php');

$questionID = array();
$pointsPossible = array();
$duplicatePoints = array();
$quizID = $_POST['quizID'];
$pointsScored = 0;

if ($answers = mysqli_prepare($link, "SELECT questions.QuestionID, questions.PointValue, answers.answerID FROM questions
		INNER JOIN answers ON questions.QuestionID = answers.QuestionID
		WHERE answers.IsCorrect	AND questions.QuizID = ? ORDER BY answerID ASC")) {
	mysqli_stmt_bind_param($answers, "i", $quizID);
	mysqli_stmt_execute($answers);
	mysqli_stmt_bind_result($answers, $QID, $PV, $AID);

	while (mysqli_stmt_fetch($answers)) {
		if (in_array($QID, $questionID)) {
			$duplicatePoints[] = $PV;
		}
		$questionID[] = $QID;
		$answerID[] = $AID;
		$pointsPossible[] = $PV;
	}


	mysqli_stmt_close($answers);
	mysqli_close($link);

	echo "Points possible " . array_sum($pointsPossible) . "<br>";
	echo "duplicate points " . array_sum($duplicatePoints) . "<br>";

	foreach ($questionID as $id) {
		if (($pos = binarySearch($_POST[$id], $answerID)) !== false) {
			$pointsScored += $pointsPossible[$pos];
		}
	}

	$totalPointsPossible = array_sum($pointsPossible);
	$percent = round((float)($pointsScored/$totalPointsPossible) * 100 ) . '%';

	echo "Points Scored = $pointsScored <br/>";
	echo "Percent = $percent <br/>";

	if(($percent) >= 90){
		echo "A";
	}
	else if(($percent) >= 80){
		echo "B";
	}
	else if(($percent) >= 70){
		echo "C";
	}
	else if(($percent) >= 60){
		echo "D";
	}
	else { 
		echo "F";
	}
}
?>

</body>
</html>

<!--
todo: check this before doing the foreach 
	if(isset($_POST[0]) and count($_POST) > 0)
-->

