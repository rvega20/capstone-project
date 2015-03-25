<?php 
session_start();

function checkAuth(){
	return ((session_status() === PHP_SESSION_ACTIVE) && isset($_SESSION['authenticated']) && $_SESSION['authenticated']) ? TRUE : FALSE;
}

function restrictAccess($user=""){
	if(!checkAuth()){
		header('Location:unauthorized.php');
		exit;
	}
	if ($user=="students" && $_SESSION['isTeacher']){
		header('Location:unauthorized.php');
		exit;	
	}
	if ($user=="teachers" && !$_SESSION['isTeacher']){
		header('Location:unauthorized.php');
		exit;
	}
	return true;
}

$authorized = checkAuth();
?>