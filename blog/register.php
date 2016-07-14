<?php 
require ('header.php');

//parse the form
if ( $_POST['did_register'] ) {
	
	//sanitize
	$username = mysqli_real_escape_string( $db, strip_tags($_POST['username']) );
	$email 	  = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) );
	$password = mysqli_real_escape_string( $db, strip_tags($_POST['password']) );
	$tos 	  = mysqli_real_escape_string( $db, filter_var($_POST['tos'], FILTER_SANITIZE_NUMBER_INT) );

	//validate
	$valid = true;

	//if username not btw 5/50 characters
		
	if ( strlen($username) <5 || strlen($username) >50 ){
		$valid = false;
		$errors['username'] = 'Your username must be between 5 and 50 characters';
	}else{
		//if username already taken
		$query = "SELECT username 
				  FROM users 
				  WHERE username = '$username'
				  LIMIT 1";

		$result = $db->query($query);

		if ( $result->num_rows == 1 ){
			$valid = false;
			$errors['username'] = 'Sorry, that username already exists';
		}
	}//end if username valid


	//if email invalid
		
	if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address (ex: name@mail.com)';
	}else{
		//email already taken
		$query = "SELECT email
				  FROM users
				  WHERE email = '$email'
				  LIMIT 1";
		$result = $db->query($query);

		if ( $result->num_rows == 1 ){
				$valid = false;
				$errors['email'] = 'An account with that email already exists';
			}	
	}//end if email valid

	//password too short
	if ( strlen($password) < 8 ){
			$valid = false;
			$errors['password'] = 'Your password must be at least 8 characters';
	}	
	
	//tos box unchecked
	if ( $tos != 1 ){
		$valid = false;
		$errors['tos'] = 'You must agree to the terms of service to create an account';
	}	

	//if valid, as user to db

	if ( $valid ){
		$query = "INSERT INTO users
				  (username, email, password, is_admin, date_joined)
				  VALUES
				  ('$username', '$email', sha1('$password'), 0, now() )";
		$result = $db->query($query);

		//check if row was added
		if ( $db->affected_rows == 1 ){
			//success
			$feedback = 'Success! Your account has been created, you may now login';
		}else{
			//error
			$feedback = 'Sorry :( Something went wrong, please refresh and try again';
		}
	}else{
		$feedback = 'Please fix the following problems:';
	}//end if form valid

}//end form parser




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create an Account</title>
	<link rel="stylesheet" href="admin/css/admin-style.css">
</head>
<body id="register">
	
	<h1 class="signup">Sign Up</h1>
	<?php form_feedback( $feedback, $errors );	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
		<label for="username">Create a Username</label>
		<input type="text" name="username" required>
		<span class="hint">Must be between 5-50 characters</span>

		<label for="email">Email Address</label>
		<input type="email" name="email" required>
		
		<label for="password">Create a Password</label>
		<input type="password" name="password" required>
		<span class="hint">Must be at least 8 characters long</span>
		
		<label for="tos">
			<input type="checkbox" name="tos" value="1">
			By signing up, you agree to our <a href="#" target="_blank">terms of service</a>
		</label>

		<input type="submit" value="Create Account">
		<input type="hidden" name="did_register" value="1">

	</form>

</body>
</html>