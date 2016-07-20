<?php  
session_start();
require ('../db-config.php');
include_once ('../functions.php');
//if user has matching key in their session, they are logged in
//if not kill the page or redirect

$user_id = $_SESSION['user_id'];
$secretkey = $_SESSION['key'];

$query = "SELECT is_admin, username FROM users
		  WHERE user_id = $user_id
		  AND secretkey = '$secretkey'
		  LIMIT 1";
$result = $db->query($query);

if ( ! $result ){
	header('location:../login.php');
}
if ( $result->num_rows == 1 ){
	$row = $result->fetch_assoc();
	//success: define constants so we have useful data about this user
	define('USER_ID', $user_id);
	define('IS_ADMIN', $row['$is_admin']);
	define('USERNAME', $row['username']);

}else{
	//not logged in
	header('location:../login.php');
}


?>
<!doctype html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/admin-style.css">
</head>
<body>
	<header role="banner">
  <h1>Admin Panel</h1>
  <ul class="utilities">
    <li class="users"><a href="#">My Account</a></li>
    <li class="logout warn"><a href="../login.php?action=logout">Log Out</a></li>
  </ul>
</header>

<nav role='navigation'>
  <ul class="main">
    <li class="dashboard"><a href="index.php">Dashboard</a></li>
    <li class="write"><a href="admin-write.php">Write Post</a></li>
    <li class="edit"><a href="admin-manage.php">Edit Posts</a></li>
    <li class="comments"><a href="admin-comments.php">Comments</a></li>
    <li class="users"><a href="admin-profile.php">Edit Profile</a></li>
  </ul>
</nav>

<main role="main">