<?php

# FOR DEBUG ONLY!! DISABLE FOR PRODUCTION USE
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$link = mysqli_connect('localhost','capstone','E2CXWZjW23TK5Nc9', 'capstone');

if (mysqli_connect_errno($link)) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

?>
