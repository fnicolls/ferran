<?php 
session_start();
require('header-login.php');
require ('interior_head.php');


//LOGIN PARSER
if ( $_POST['did_login'] ){
	
	//sanitize
	$username = mysqli_real_escape_string( $db, strip_tags($_POST['username']) );
	$password = mysqli_real_escape_string( $db, strip_tags($_POST['password']) );

	//validate
	$valid = true;

	//check info and set session/cookies
	if ( strlen($username) >=5 AND strlen($username) < 30 AND strlen($password) >= 8 ){
		//check if user is in db
		$query = "SELECT user_id
				  FROM users
				  WHERE username = '$username'
				  AND password = sha1('$password')
				  LIMIT 1";
		$result = $db->query($query);

		if ( $result->num_rows == 1 ){
			//success
			//remember user for 1 week
			$secretkey = sha1( microtime() . 'jdiwqu830rjfq8@*)#@Jdwp' );
			setcookie( 'key', $secretkey, time() + 60 * 60 * 24 * 7 );
			$_SESSION['key'] = $secretkey;

			//get user_id
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

			//redirect to profile page
			//todo: make profile link unique to user
			header('Location:profile.php?user_id='.$user_id);
			// $feedback = 'You are logged in!';
		}else{
			//error
			$feedback = $db->error;
		}

	}else{
		$feedback = 'Your username or password are incorrect';
	}//end if username valid

}//end login parser


//logout - destroy session and cookies
if ( $_GET['action'] == 'logout' ){
	//remove key from db
	$user_id = $_SESSION['user_id'];
	$query = "UPDATE users
			  SET secretkey = ''
			  WHERE user_id = $user_id";
	$result = $db->query($query);

	//close session, delete id
	session_destroy();
	//erase session variables, set to blank array
	$_SESSION = array();

	//set cookies to null and expired
	setcookie( 'key', '', time() - 99999999 );
	setcookie( 'user_id', '', time() - 99999999 );

	$feedback = 'You are logged out';


}


 ?>



<main>


	<div class="loginform">
		<h2>Log In</h2>
		<?php form_feedback($feedback, $errors); ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="username">Username</label>
		<input type="text" name="username" id="username">

		<label for="password">Password</label>
		<input type="password" name="password" id="password">

		<input type="submit" value="Log In" id="logsubmit">
		<input type="hidden" name="did_login" value="1">
		</form>
		
	</div>

</main>



<?php 
require('footer.php');

 ?>

 