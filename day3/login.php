<?php
//open or resume session
session_start();
//hide notices
error_reporting( E_ALL & ~E_NOTICE );
//temporary correct credentials
//todo: use database
$correct_username = 'booger';
$correct_password = 'butts';
//parse the form if user submits
if ( $_POST['did_log_in'] ) {
	//extract data from the form
	$username = $_POST['username'];
	$password = $_POST['password'];

	//todo: validate the data

	//check to see if they gave correct credentials, if so log in
	if ($username === $correct_username && $password === $correct_password) {
		//success - remember the user for 1 week
		//todo: make this more secure
		setcookie( 'loggedin', true, time() + 60 * 60 * 24 * 7 );
		$_SESSION['loggedin'] = true;
		//redirect to profile page
		header('Location:profile.php');
	}else{
		//error
		$feedback = 'Your username or password are incorrect';
	}

}//end parser



//logout - destroy session and cookie vars
if ( $_GET['action'] == 'logout' ) {
	//close the session, deletes id
	session_destroy();
	//erase session variables, set to blank array
	$_SESSION = array();

	//set cookies to null and expired
	setcookie( 'loggedin', '', time() - 99999999 );

	$feedback = 'you have logged out good job';

}elseif ( $_COOKIE['loggedin'] ) {
	$_SESSION['loggedin'] = true;
	//if user returns to page and cookie is still valid, re-create session
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Log In to an Account</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php //if logged in, hide the form
	if ($_SESSION['loggedin']) {
		echo 'You are logged in';
	}else{


	 ?>

	<h1>Log In</h1>

	<?php if ( isset($feedback) ) { ?>
	<div class="feedback">
	<?php echo $feedback; ?>
	</div>
	<?php }//close isset ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="username">Username</label>
		<input type="text" name="username" id="username">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">

		<input type="submit" value="Log In">

		<!-- this field triggers the parser -->
		<input type="hidden" name="did_log_in" value="true">
	</form>
	<?php }//end if loggedin ?>

</body>
</html>