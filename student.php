<?php require_once('includes/auth.include.php'); 
restrictAccess("students");
require_once('functions/registrationfunctions.php');  //include path on server for this one to work.
require_once('database/connect.php');
require_once('functions/user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Rocket Quiz Us!</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-select.js"></script>
              <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">

<link rel="apple-touch-icon-precomposed" href="pencil.png">
<link rel="stylesheet" type="text/css" href="css/flat-ui.css">
    <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
</script>
</head>
<body>
	<?php  if(isset($_POST['classID'])){
 list($cname, $cdesc, $classID) = preg_split('[,]', $_POST['classID']);
 $_SESSION['classID'] = $classID;
if ($remove = mysqli_prepare($link, "DELETE FROM `registrations`
			WHERE UserID = ? AND classID=?")) {
		mysqli_stmt_bind_param($remove, "si", $_SESSION['userID'],$_SESSION['classID']);
		mysqli_stmt_execute($remove);
		mysqli_stmt_close($remove);
}
}
?>


	<?php include('includes/nav.include.php'); ?>


	
	<!--Contact Form Modal -->
				<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog ">
					<div class="modal-content ">
					   <div class="modal-body ">
										 <div class="row ">
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">
													Name</label>
												<input type="text" class="form-control" id="name" placeholder="Enter name" required="required">
											</div>
											<div class="form-group">
												<label for="email">
													Email Address</label>
												<div class="input-group">
													<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
													</span>
													<input type="email" class="form-control" id="email" placeholder="Enter email" required="required"></div>
											</div>
											<div class="form-group">
												<label for="subject">
													Subject</label>
												<select id="subject" name="subject" class="form-control" required="required">
													<option value="na" selected="">Choose One:</option>
													<option value="service">Quiz Question</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">
													Message</label>
												<textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
												Send Message</button>
										</div>
									</div>
							</div>		
					</div>
				  </div>
				</div> 
	<!--Contact Form Modal End-->

<!-- Modal -->

		       <?php
	
	if ($classes = mysqli_prepare($link, "SELECT classes.`ClassID`, `Name`, `Description` FROM `classes` 
			INNER JOIN registrations ON classes.ClassID = registrations.ClassID
			WHERE registrations.UserID = ?")) {
		mysqli_stmt_bind_param($classes, "i", $_SESSION['userID']);
		mysqli_stmt_execute($classes);
		mysqli_stmt_bind_result($classes, $classID, $className, $classDescription);
		mysqli_stmt_store_result($classes);
		$hide = 0; 
		while (mysqli_stmt_fetch($classes)) {
			if($hide < 1){
			echo "<div class=\"container col-md-12 col-xs-12\" id=\"regclass\" style=\"$hide\">";
			echo "<h5>Registered Classes <i class=\"glyphicon glyphicon-list-alt\"></i></h5>";
			echo "<hr style=\"border:outset\">";
			}
			$hide++;
			echo "<h6 class='className'><b>".$className. " | " . $classDescription . "</b>&nbsp&nbsp&nbsp&nbsp<form method=\"POST\" onSubmit=\"if(!confirm('Are you Sure? You want to remove $className $classDescription from your available classes?')){return false;}\" style=\"display:inline\"><button type=\"submit\" value=\"$className, $classDescription, $classID \" id=\"classID\" name=\"classID\" class=\"btn btn-sm btn-danger\">Unregister</button></form>"."</h6>";
			
			if ($quiz = mysqli_prepare($link, "SELECT quizzes.QuizID, results.PointsPossible, results.PointsScored, 
				quizzes.Name, quizzes.DeadlineDate 
				FROM quizzes 
				LEFT OUTER JOIN results 
				ON results.QuizID = quizzes.QuizID 
				WHERE quizzes.ClassID = ? AND 
				(results.StudentID = ? 
				OR results.QuizID IS null)
				ORDER BY quizzes.DeadlineDate DESC")) {

				mysqli_stmt_bind_param($quiz, "ii", $classID,$_SESSION['userID']);
				mysqli_stmt_execute($quiz);
				mysqli_stmt_bind_result($quiz, $quizID, $pointsPossible, $pointsScored, $quizName, $quizDeadline);

				$totalPointsPossible = 0;
				$totalPointsScored  = 0;
				?>
				<table class="table">
					<thead>
						<tr>
							<th>Quiz Name</th>
							<th>Due</th>
							<th>Quiz Grade</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while (mysqli_stmt_fetch($quiz)) {
					$quizDeadlineDate = strtotime($quizDeadline);
					if ($pointsPossible){
						$quizDueDate = date('F j, Y', $quizDeadlineDate);
						$quizDueHour = date('g:i a', $quizDeadlineDate);
						$grade = round((float)($pointsScored/$pointsPossible) * 100 ) . '%';
						echo "<tr>";
 						echo "<td>$quizName</td>";
 						echo "<td>$quizDueDate at $quizDueHour</td>";
 						echo "<td>$grade</td>";
 						echo "</tr>";
 					}
					
 					else {
					$quizDueDate = date('F j, Y', $quizDeadlineDate);
					$quizDueHour = date('g:i a', $quizDeadlineDate);
					echo "<tr>";
					echo "<td><a href=\"new_quiz.php?id=$quizID\">$quizName</td>";
					echo "<td>$quizDueDate at $quizDueHour</td>";
					echo "<td>$pointsScored</td>";
 					echo "</tr>";
					}
					
					$totalPointsPossible += $pointsPossible;
					$totalPointsScored += $pointsScored;
				}
				
				echo "</tbody></table>";
				
				echo "<hr border=\"1px solid black\">";
				
				mysqli_stmt_close($quiz);
				/*mysqli_close($link);*/

				if ($totalPointsPossible) {
					$classgrade = round((float)($totalPointsScored / $totalPointsPossible * 100)) . '%';
					echo "<p style=\"margin-bottom:6%;\">Total Grade for ". $className ." = ". $classgrade."</p>";
				}
}
}
		mysqli_stmt_free_result($classes);
		mysqli_stmt_close($classes);
	

}
?>
	     </div>
		
<div class="container">
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 regbox" id="registerbox">
		<div class="container">
     	<h5>Register</h5>
     	<p>Select your class below or enter the Access ID provided by your professor.</p></div>
     	    <div class="container col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <form  method="get" action="classregister.php"class="form-horizontal" role="form" >
            <div class="form-group">
                <div class="col-md-12 col-lg-12">
                    <select id="bs3Select" name="subject" class="selectpicker show-tick form-control" data-live-search="true">
                    <?php 			if ($class = mysqli_prepare($link, "SELECT `ClassID`, `Name`, `Description` FROM classes
				ORDER BY Name ASC")) {

				mysqli_stmt_execute($class);
				mysqli_stmt_bind_result($class, $classID, $className, $classDescription);

				while (mysqli_stmt_fetch($class)) {

 					echo "<option class=\"hidden-sm hidden-xs\" value=\"{$classID}\"> $className $classDescription ($classID) </option>";
 					echo "<option class=\"hidden-md hidden-lg\" style=\"font-size:21px;\" value=\"{$classID}\">$className ($classID) </option>";
				}
				mysqli_stmt_close($class);
				/*mysqli_close($link);*/
			}?>
                      <!-- class="get-class" disabled -->
                    </select>
        
        </div></div>
        	<div><p><input type="submit" style="float:right; margin-right:0;"class="btn btn-sm btn-success"></p></div>
    </div></div>
</form>
     <div class="col-md-12 col-xs-12 ">
            </div>
		</div>
		<?php include('includes/footer.include.php'); ?>
</body>

</html>