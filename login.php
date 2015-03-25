<?php

if( isset($_POST['login_email']) && isset($_POST['login_password']) ){
  $link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');
        if ($stmt = mysqli_prepare($link, "SELECT `Password` FROM `users` WHERE `Email`=?")) {

            /* bind parameters for markers */
            mysqli_stmt_bind_param($stmt, "s",$_POST['login_email']);

            /* execute query */
            mysqli_stmt_execute($stmt);

            /* bind result variables */
            mysqli_stmt_bind_result($stmt, $result);

            /* fetch value */
            mysqli_stmt_fetch($stmt);

            /* close statement */
            mysqli_stmt_close($stmt);
        }

        if( isset($_POST['login_password']) && $_POST['login_password'] === $result ) {

              	if(isTeacher($_POST['login_email'])){
              		header( 'Location: teacher.php' ) ;
              		$_SESSION['authenticated']=true;
              		$_SESSION['username']=getFirstName($_POST['login_email'])."   ".getLastName($_POST['login_email']);
              	}
            
            	else if(!isTeacher($_POST['login_email'])) {
            		header( 'Location: student.php' ) ;
            		$_SESSION['authenticated']=true;
            		$_SESSION['username']=getFirstName($_POST['login_email'])."   ".getLastName($_POST['login_email']);
            	}
        }
//display the errors next time
else {

    echo '<div style="margin-bottom:1%; margin-top:-1%; margin-left:75%; color:red; font-weight:bold;">'."Incorrect Password !".'</div>';
        
     }


}

?>