<?php
session_start();
echo "subject id".$_GET['subject']."<br>";
echo "user id ".$_SESSION['userID']."<br>";


//checks if specific user is registered for specific class, returns 1 if already registered for a class
function IsRegisteredForClass($userID,$subject){
     $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');

     if ($stmt = mysqli_prepare($link, "SELECT `classID` FROM registrations WHERE `userID`=?")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userID']);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $result);
 
    /* fetch value */
   while( $row=mysqli_stmt_fetch($stmt)){

   if(	$result==$subject){
       return true;
       break;
    }
    else 
      return false;

   } 

    /* close statement */
    mysqli_stmt_close($stmt);
}

}




if(IsRegisteredForClass($_SESSION['userID'],$_GET['subject'])==false){
      $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');

		if ($stmt = mysqli_prepare($link, "INSERT INTO `registrations` (`classID`, `userID`) VALUES (?, ?);")) {

		    /* bind parameters for markers */
		    mysqli_stmt_bind_param($stmt, "ii", $_GET['subject'],$_SESSION['userID']);

		    /* execute query */
		    mysqli_stmt_execute($stmt);

		    printf("registered");

		    /* close statement */
		    mysqli_stmt_close($stmt);
		}
}
else {
	echo "already registered";
}



header("Location:student.php");






?>