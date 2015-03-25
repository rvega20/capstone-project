<<<<<<< HEAD
=======
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-select.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
        </script>

<?php include('includes/nav.include.php'); ?>

>>>>>>> f9a9e7daf367e5b70d240dd3ac1d36e4c47720f6
<?php
	ini_set("display_errors",1);
	error_reporting(-1);

	
	require_once('database/connect.php');

	$studentID = 1;

	if ($classes = mysqli_prepare($link, "SELECT classes.`ClassID`, `Name`, `Description` FROM `classes` 
			INNER JOIN registrations ON classes.ClassID = registrations.ClassID
			WHERE registrations.UserID = ?")) {
		mysqli_stmt_bind_param($classes, "i", $studentID);
		mysqli_stmt_execute($classes);
		mysqli_stmt_bind_result($classes, $classID, $className, $classDescription);
		mysqli_stmt_store_result($classes);

		while (mysqli_stmt_fetch($classes)) {

			echo $className . " " . $classDescription . "<br>";

			if ($quiz = mysqli_prepare($link, "SELECT quizzes.QuizID, results.PointsPossible, results.PointsScored, 
				quizzes.Name, quizzes.DeadlineDate 
				FROM quizzes 
				LEFT OUTER JOIN results 
				ON results.QuizID = quizzes.QuizID 
				WHERE quizzes.ClassID = ? AND 
				(results.StudentID = ? 
				OR results.QuizID IS null)")) {

				mysqli_stmt_bind_param($quiz, "ii", $studentID, $classID);
				mysqli_stmt_execute($quiz);
				mysqli_stmt_bind_result($quiz, $quizID, $pointsPossible, $pointsScored, $quizName, $quizDeadline);

				$totalPointsPossible = 0;
				$totalPointsScored  = 0;


				while (mysqli_stmt_fetch($quiz)) {

					if ($pointsPossible) {
 						echo "&nbsp;&nbsp;&nbsp;&nbsp;Quiz: " . $quizName . "     " . $quizDeadline . "     grade:" . ($pointsScored / $pointsPossible) . "<br>";
 					}
 					else {
 						echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"new_quiz.php?id=$quizID\">$quizName due on $quizDeadline</a> <br>";
 					}

					$totalPointsPossible += $pointsPossible;
					$totalPointsScored += $pointsScored;
				}
				mysqli_stmt_close($quiz);
				/*mysqli_close($link);*/

				if ($totalPointsPossible) {
					echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>class grade:</b> " . ($totalPointsScored / $totalPointsPossible) . "<br>";
				}
			}










		}
		mysqli_stmt_free_result($classes);
		mysqli_stmt_close($classes);
	}




/*

	if ($registration = mysqli_prepare($link, "INSERT INTO registrations (`ClassID`, `UserID`) VALUES (?,?)")) {
		mysqli_stmt_bind_param($registration, "ii", $classID, $studentID);

		if (!mysqli_stmt_execute($registration)) {
			echo "Execute failed: (" . mysqli_stmt_errno($registration) . ") " . mysqli_stmt_error($registration);
		}
		mysqli_stmt_close($registration);
	}
*/


?>

    <div class="container">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="bs3Select" class="col-lg-2 control-label">Test bootstrap 3 form</label>
                <div class="col-lg-10">
                    <select id="bs3Select" class="selectpicker show-tick form-control" multiple data-live-search="true">
                    <?php 			if ($class = mysqli_prepare($link, "SELECT `ClassID`, `Name`, `Description` FROM classes
				ORDER BY Name ASC")) {

				mysqli_stmt_execute($class);
				mysqli_stmt_bind_result($class, $classID, $className, $classDescription);

				while (mysqli_stmt_fetch($class)) {
 					echo "<option>$className $classDescription ($classID)</option>";
				}
				mysqli_stmt_close($class);
				/*mysqli_close($link);*/
			}?>
                      <!-- class="get-class" disabled -->
                    </select>
                </div>
              </div>
        <form>
    </div>
<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>

