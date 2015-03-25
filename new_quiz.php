<?php require_once('includes/auth.include.php'); 
restrictAccess();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php include('includes/header.include.php'); ?>
</head>
<body>
	<?php include('includes/nav.include.php'); ?>

<form action="result.php" method="post">
<div class="col-md-12">
<div class="container col-md-offset-3 col-md-6 col-md-offset-3" id="new_quiz">
<?php
if (isset($_GET['id'])){
	$quizID = $_GET['id'];	
}
else{
	$quizID = 1;/*fixme - change this so it uses desired quiz id*/
}

if ($Check = mysqli_prepare($link, "SELECT `ResultsID` FROM `results` WHERE `QuizID`=? AND `StudentID` = ?")) {
	mysqli_stmt_bind_param($Check, "ii", $quizID, $_SESSION['userID']);
	mysqli_stmt_execute($Check);
	mysqli_stmt_bind_result($Check, $results);
	while (mysqli_stmt_fetch($Check)) {
		if($results){
			header("Location: student.php");
		}
	}

	mysqli_stmt_close($Check);
}


printf("<input type=\"hidden\" name=\"quizID\" value=\"$quizID\">");

/* create a prepared statement */
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
			printf("<ol style=\"list-style: none;\">");
			printf("<div class=\"row\">");
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

<input type="submit" class="btn btn-success text-center" value="Submit">
</form></div></div>
<?php include('includes/footer.include.php'); ?>
<script src="js/flatui-radio.js"></script>
<?php include('includes/scripts.include.php'); ?>
</body>
</html>
