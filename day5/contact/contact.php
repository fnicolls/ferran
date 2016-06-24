<?php 
error_reporting( E_ALL & ~E_NOTICE );
include('functions.php');

//make an array for the "reasons" drop down, makes validating easier
$valid_reasons = array(
	'hire' => 'I want to hire you',
	'help' => 'I need help',
	'hey'  => 'hey what up',
	);


if ( $_POST['did_submit'] ) {
	//extract user data
	$name 		= filter_var( $_POST['name'], FILTER_SANITIZE_STRING );
	$email 		= filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
	$phone 		= filter_var( $_POST['phone'], FILTER_SANITIZE_NUMBER_INT );
	$reason 	= filter_var( $_POST['reason'], FILTER_SANITIZE_STRING );
	$message 	= filter_var( $_POST['message'], FILTER_SANITIZE_STRING );
	$newsletter = filter_var( $_POST['newsletter'], FILTER_SANITIZE_STRING );

	//todo: clean & validate
	if ( $newsletter != 'true') {
		$newsletter = 'false';
	}

	$valid = true;
	$errors = array();

	//name is blank
	if ( $name == '' ) {
		$valid = false;
		$errors['name'] = 'Please enter your name';
	}
	//email is blank or not valid format
	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Please enter a valid email';
	}

	//phone not a number
	if ( ! filter_var( $phone, FILTER_VALIDATE_INT ) ){
		$valid = false;
		$errors['phone'] = 'Please enter a valid phone number';
	}
	if( strlen($phone) < 10 ){
		$valid = false;
		$errors['phone'] = 'Please enter a valid phone number';
	}

	//reason not on list
	//todo: fix it
	if ( ! array_key_exists( $reason, $valid_reasons ) ){
		$valid = false;
		$errors['reason'] = 'Please choose a reason from the list';
	}


	if ( $valid ) {
		//if valid send the mail, otherwise show error
		$to 		= 'ferrannicolls@gmail.com';
		$subject 	= "$name just reached out to you from your contact page";

		$body 		= "Email: $email \n";
		$body	   .= "Name: $name \n";
		$body	   .= "Phone: $phone \n";
		$body	   .= "Reason: $valid_reasons[$reason] \n";
		
		if ( $newsletter == 'true') {
		$body	   .= "Sign me up! \n";
		}
		
		$body	   .= "Message: $message \n";

		$header		= "From: Ferran <ferrannicolls@gmail.com> \r\n";
		$header	   .= "Reply-to: $email";

		//send it
		$did_send = mail($to, $subject, $body, $header);

	}//end if valid

	if ( $did_send ){
		//success
		$feedback = "Thank you for your message, $name. I will be in touch soon";
		$css_class = 'success';
		//redirect
		header("Location:thanks.php?name=$name");
	}else{
		//error
		$feedback = 'Something went wrong. Your message could not be sent';
		$css_class = 'error';
	}//end did_send

}//end parser


?>
<!DOCTYPE html>
<html>
<head>
	<title>Simple Contact Form Example</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="<?php echo $css_class; ?>">
	<div id="container">
	<h1>Contact ME</h1>

	<?php form_feedback( $feedback, $errors ); ?>

	<!--use "novalidate" attribute to check fallback validation -->
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="name">Your Name</label>
		<input type="text" name="name" id="name" value="<?php echo $name; ?>" <?php inline_error($errors, 'name'); ?>>

		<label for="email">Email Address</label>
		<input type="email" name="email" id="email" value="<?php echo $email; ?>" <?php inline_error($errors, 'email'); ?>>

		<label for="phone">Phone Number</label>
		<input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>" <?php inline_error($errors, 'phone'); ?>> 

		<label for="reason">How can I help?</label>
		<select name="reason" id="reason" <?php inline_error($errors, 'reason'); ?>>
			<option>choose one</option>
			<?php foreach( $valid_reasons as $value => $label ){ ?>
			<option value="<?php echo $value; ?>" <?php 
			if ( $reason == $value ){
				echo 'selected';
			}
			?>>
				<?php echo $label; ?>
			</option>
			<?php } ?>
		</select>

		<label for="message">Your Message</label>
		<textarea name="message" id="message"><?php echo $message; ?></textarea>

		<label>
			<input type="checkbox" name="newsletter" value="true" <?php if( $newsletter === 'true' ){
				echo 'checked';
				} ?>>
			Subscribe to Newsletter
		</label>

		<input type="submit" value="Send Message">

		<input type="hidden" name="did_submit" value="true">

	</form>
	</div>

<!-- just for testing: display the body -->
<!-- <pre>
<?php echo $body; ?>
</pre> -->



</body>
</html>