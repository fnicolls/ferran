<?php
//open or resume session
session_start();
require ('header.php');

//parse the form if user submits
if ( $_POST['did_log_in'] ) {
	//extract & sanitize data from the form
	$username = mysqli_real_escape_string( $db, strip_tags($_POST['username']) );
	$password = mysqli_real_escape_string( $db, strip_tags($_POST['password']) );
	
	//todo: validate the data
	$valid = true;

	//username within 5-50 characters
	if ( strlen($username) >= 5 AND strlen($username) < 50 AND strlen($password) > 8 ) {
		//check if user is in db
		$query = "SELECT user_id, is_admin
				  FROM users
				  WHERE username = '$username'
				  AND password = sha1('$password')
				  LIMIT 1";
		$result = $db->query($query);

		if ( $result->num_rows == 1 ){
			//success
			//remember user for 1 week
			$secretkey = sha1( microtime() . 'jtq234i0!fgivjfheialfiuhafewio1!*$@92jedqo' );
			setcookie( 'key', $secretkey, time() + 60 * 60 * 24 * 7 );
			$_SESSION['key'] = $secretkey;

			//get user_id of user logging in
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];

			//store user_id
			setcookie( 'user_id', $user_id, time() + 60 * 60 * 24 * 7 );
			$_SESSION['user_id'] = $user_id;

			//store secret key in db
			$dbkey = "UPDATE users
					  SET secretkey = '$secretkey'
					  WHERE user_id = $user_id";
			$result = $db->query($dbkey);



			//redirect to admin panel
			header('Location:admin/index.php');
		}else{
			//error
			$feedback = 'Your username or password are incorrect';
		}

	}else{
		$feedback = 'Your username or password are incorrect';
	}//end if valid

}//end parser



//logout - destroy session and cookie vars
if ( $_GET['action'] == 'logout' ){
	//removes key from db
	$user_id = $_SESSION['user_id'];
	$query = "UPDATE users
			  SET secretkey = ''
			  WHERE user_id = $user_id";
	$result = $db->query($query);

	//close the session, deletes id
	session_destroy();
	//erase session variables, set to blank array
	$_SESSION = array();

	//set cookies to null and expired
	setcookie( 'key', '', time() - 99999999 );
	setcookie( 'user_id', '', time() - 99999999 );

	$feedback = 'you have logged out good job';

}


 ?>
	<main id="login">


	<h2>Log In</h2>

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

	</main>
</body>
</html>