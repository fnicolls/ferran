`<?php 
require('header-login.php');
require ('interior_head.php');

//REGISTER PARSE
if ( $_POST['did_register'] ){
	
	//sanitize
	$email 			 = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) );
	$username 		 = mysqli_real_escape_string( $db, strip_tags($_POST['username']) );
	$password 		 = mysqli_real_escape_string( $db, strip_tags($_POST['password']) );
	$tos			 = mysqli_real_escape_string( $db, filter_var($_POST['tos'], FILTER_SANITIZE_NUMBER_INT) );

	//validate
	$valid = true;

	//username guidelines (min 5 max 30)
	if ( strlen($username) <5  OR strlen($username) >30 ){
		$valid = false;
		$errors['username'] = 'Your username must be between 5 and 30 characters';
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

	//if email valid
	if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address. (ex: name@mail.com)';
	}else{
		//if email already taken
		$query = "SELECT email
				  FROM users
				  WHERE email = '$email'
				  LIMIT 1";
		$result = $db->query($query);

		if ( $result->num_rows == 1 ){
			$valid = false;
			$errors['email'] = 'Sorry, an account using that email already exists. Try loggin in.';
		}
	}//end if email valid

	//password guidelines (min 8 characters)
	if ( strlen($password) < 8 ){
		$valid = false;
		$errors['password'] = 'Your password must be at least 8 characters';
	}

	//tos box unchecked
	if ( $tos != 1 ){
		$valid = false;
		$errors['tos'] = 'You must agree to the terms of service to create an account';
	}

	if( $valid ){
		$query = "INSERT INTO users
				  (email, username, password, date_joined)
				  VALUES
				  ('$email', '$username', sha1('$password'), now() )";
		$result = $db->query($query);

		//check if row was added
		if ( $db->affected_rows == 1 ){
			//success
			$feedback = 'Account created!';
			header('Location:profile.php');
		}else{
			$feedback = 'Sorry :( Something went wrong, please refresh and try again';
		}
	}else{
		$feedback = 'Please fix the following:';
	}//end if form valid


}//end register parser


 ?>



<main>
	
	<div class="signup">
		<h2>Create an Account</h2>
		<?php form_feedback($feedback, $errors); ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php echo $email; ?>">

			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?php echo $username; ?>">

			<label for="password">Create Password</label>
			<input type="password" name="password" id="password">

			<label for="tos">
				<input type="checkbox" name="tos" value="1">
				By signing up you agree to our <a href="tos.php" target="_blank">Terms of Service</a>
			</label>	
			
			<input type="submit" value="Create Account" id="logsubmit">
			<input type="hidden" name="did_register" value="1">
			
		</form>
	</div>


</main>



<?php 
require('footer.php');

 ?>

 