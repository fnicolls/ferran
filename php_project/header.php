<?php 
require('db-config.php');
include_once('functions.php');
auth_user();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Playground - Meet and Make Music</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed|Lato|Roboto' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>
<?php 
//if not logged in
if( ! is_logged_in() ){
 ?>
	<header>
		<a href="index.php"><div id="logo"><img src="imgs/pg_logo.svg" alt="logo"></div></a>
		<div id="login"><a href="login.php">Log In</a> | <a href="register.php">Sign Up</a></div>
	</header>
<?php }else{
//if logged in
 ?>
	<header>
		<a href="index.php"><div id="logo"><img src="imgs/pg_logo.svg" alt="logo"></div></a>
		<div id="login"><a href="profile-edit.php?user_id=<?php echo USER_ID ?>"><?php echo USERNAME ?></a> | <a href="login.php?action=logout">Logout</a></div>
	</header>
<?php } ?>