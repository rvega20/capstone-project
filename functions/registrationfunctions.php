<?php

// returns 1 is user with the specified email address already exists
  function userAlreadyExists($address){
		$link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
		if ($stmt = mysqli_prepare($link,"SELECT COUNT( * ) FROM  `users` WHERE  `Email` = ?")) {

		    /* bind parameters for markers */
		    mysqli_stmt_bind_param($stmt, "s", $address);

		    /* execute query */
		    mysqli_stmt_execute($stmt);

		    /* bind result variables */
		    mysqli_stmt_bind_result($stmt, $result);

		    /* fetch value */
		    $show=mysqli_stmt_fetch($stmt);

		    /* close statement */
		    mysqli_stmt_close($stmt);
		    return $result >0;
}
}

function output_errors($errors){
   $output=array();
   foreach($errors as $error){
      $output[]='<li style="color:red; font-weight:bold;">'. $error . '</li>';
   }
   return '<ul>' . implode('',$output). '</ul>';
}


function IsTeacher($address){
	$link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
if ($stmt = mysqli_prepare($link, "SELECT `IsTeacher` FROM `users` WHERE `Email`=?")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "s", $address);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $result);

    /* fetch value */
    mysqli_stmt_fetch($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);
}
   return $result;
}

function getUserID($email){
 $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
if ($stmt = mysqli_prepare($link, "SELECT `UserID` FROM `users` WHERE `Email`=?")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "s", $email);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $result);

    /* fetch value */
    mysqli_stmt_fetch($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);
}
   return $result;
}

function getFirstName($email){
  $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
if ($stmt = mysqli_prepare($link, "SELECT `FirstName` FROM `users` WHERE `Email`=?")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "s", $email);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $result);

    /* fetch value */
    mysqli_stmt_fetch($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);
}
   return $result;
}

function getLastName($email){
  $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
if ($stmt = mysqli_prepare($link, "SELECT `LastName` FROM `users` WHERE `Email`=?")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "s", $email);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $result);

    /* fetch value */
    mysqli_stmt_fetch($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);
}
   return $result;
}

function convertDate($dateString){
      $dateTime = new DateTime($dateString);
      return $dateTime->format("m/d/y g:i A");
    }


?>