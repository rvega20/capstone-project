<?php

//displays list of classes that user has registered
function displayRegisteredClasses(){
   
    $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');


   if ($stmt = mysqli_prepare($link, "SELECT classes.Name, classes.Description, registrations.userID,classes.ClassID FROM classes
INNER JOIN registrations ON classes.ClassID=registrations.ClassID WHERE registrations.userID=? ")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "i",$_SESSION['userID']);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $classname,$description,$userid,$classID);

 
   while( mysqli_stmt_fetch($stmt) ){
    /* fetch value */
     
     echo "<li>".$classname."<br>".$description."</li>";
	 
	
	 

// this is where while ends
}   

    /* close statement */
    mysqli_stmt_close($stmt);
}


}
function whatever(){
 $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');


 	$studentID = 65;
if ($classes = mysqli_prepare($link, "SELECT classes.`ClassID`, `Name`, `Description` FROM `classes` 
			INNER JOIN registrations ON classes.ClassID = registrations.ClassID
			WHERE registrations.UserID = ?")) {
		mysqli_stmt_bind_param($classes, "i", $studentID);
		mysqli_stmt_execute($classes);
		mysqli_stmt_bind_result($classes, $classID, $className, $classDescription);
		mysqli_stmt_store_result($classes);

		while (mysqli_stmt_fetch($classes)) {

			echo $className . " " . $classDescription . "<br>";

			if ($quizGrade = mysqli_prepare($link, "SELECT results.QuizID, results.PointsPossible, results.PointsScored, quizzes.Name, quizzes.DeadlineDate FROM results
					INNER JOIN quizzes ON results.QuizID = quizzes.QuizID
					WHERE results.StudentID = ? AND quizzes.ClassID = ?")) {
				mysqli_stmt_bind_param($quizGrade, "ii", $studentID, $classID);
				mysqli_stmt_execute($quizGrade);
				mysqli_stmt_bind_result($quizGrade, $quizID, $pointsPossible, $pointsScored, $quizName, $quizDeadline);

				$totalPointsPossible = 0;
				$totalPointsScored  = 0;


				while (mysqli_stmt_fetch($quizGrade)) {
					echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $quizName . " " . $quizDeadline . " grade:" . ($pointsScored / $pointsPossible) . "<br>";
					$totalPointsPossible += $pointsPossible;
					$totalPointsScored += $pointsScored;
				}
				mysqli_stmt_close($quizGrade);
				/*mysqli_close($link);*/

				if ($totalPointsPossible) {
					echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>class grade:</b> " . ($totalPointsScored / $totalPointsPossible) . "<br>";
				}
			}
		}
		mysqli_stmt_free_result($classes);
		mysqli_stmt_close($classes);
	}
}
?>

