<?php 
error_reporting( E_ALL & ~E_NOTICE );

//make an array for the "reasons" drop down, makes validating easier
$valid_reasons = array(
	'hire' => 'I want to hire you',
	'help' => 'I need help',
	'hey'  => 'hey what up',
	);


if ( $_POST['did_submit'] ) {
	//extract user data
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$reason = $_POST['reason'];
	$message = $_POST['message'];
	$newsletter = $_POST['newsletter'];

	//todo: clean & validate
	if ( $newsletter == '') {
		$newsletter = 'false';
	}

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

	if ( $did_send ){
		//success
		$feedback = "Thank you for your message, $name. I will be in touch";
		$css_class = 'success';
		//redirect
		header("Location:thanks.php?name=$name");
	}else{
		//error
		$feedback = 'Something went wrong. Your message could not be sent';
		$css_class = 'error';
	}

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

	<?php if( isset($feedback) ){ ?>
	<div class="feedback">
		<?php echo $feedback; ?>
	</div>
	<?php } ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="name">Your Name</label>
		<input type="text" name="name" id="name">

		<label for="email">Email Address</label>
		<input type="email" name="email" id="email">

		<label for="phone">Phone Number (optional)</label>
		<input type="tel" name="phone" id="phone">

		<label for="reason">How can I help?</label>
		<select name="reason" id="reason">
			<option>choose one</option>
			<?php foreach( $valid_reasons as $value => $label ){ ?>
			<option value="<?php echo $value; ?>">
				<?php echo $label; ?>
			</option>
			<?php } ?>
		</select>

		<label for="message">Your Message</label>
		<textarea name="message" id="message"></textarea>

		<label>
			<input type="checkbox" name="newsletter" value="true">
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