<?php 
error_reporting( E_ALL & ~E_NOTICE );
//make this page password protected - check for valid login first
session_start();
if ( ! $_SESSION['loggedin'] ) {
	//die('error! you do not have access to this page');
	//if not logged in, send back to login page
	header('Location:login.php');
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1>only a logged in user will see this shiz</h1>
	<p>profile page</p>

	<a href="login.php?action=logout">Log out</a>
</body>
</html>