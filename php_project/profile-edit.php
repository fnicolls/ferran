<?php 
session_start();
require('header.php');
require ('interior_head.php');


$user_id = USER_ID;



$query = "SELECT *
		  FROM users
		  WHERE users.user_id = $user_id
		  LIMIT 1";

$result = $db->query($query);

if ( !$result ){
	// header('location:login.php');
	die($db->error);
}

if ( $result->num_rows >= 1 ){
	$row = $result->fetch_assoc();
	extract($row);
	// $username = $row['username'];

	$info  = "SELECT users.user_id skills.*, influences.*, bands.*
			  FROM users, skills, influences, bands
			  WHERE users.user_id = skills.user_id
			  AND users.user_id = influences.user_id
			  AND users.user_id = bands.user_id
			  AND users.user_id = $user_id
			  LIMIT 1";
	$result = $db->query($info);

//form parser
if ( $_POST['did_save'] ){
	$allowed_tags = '<img><br><p><b><i><a><h1><h2><h3><h4><h5><h6><blockquote>';
	
	//sanitize
	$about 		= mysqli_real_escape_string( $db, strip_tags($_POST['about'], $allowed_tags) );
	$influences = mysqli_real_escape_string( $db, strip_tags($_POST['about'], $allowed_tags) );
	$skills 	= mysqli_real_escape_string( $db, strip_tags($_POST['about'], $allowed_tags) );
	$bands 		= mysqli_real_escape_string( $db, strip_tags($_POST['about'], $allowed_tags) );

	$valid = true;

	if( $valid ){
		$update = "UPDATE users, skills, influences, bands
				   SET
				   users.about 		= '$about'
				   skills.skillset 	= '$skills'
				   influences.body 	= '$influences'
				   bands.bands 		= '$bands'
				   WHERE user_id 	= $user_id";
		$result = $db->query($update);

		if( ! result ){
			$feedback = $db->error;
		}elseif( $db->affected_rows == 1 ){
			$feedback = 'changes saved';
		}else{
			$feedback = 'no changes made';
		}

	}else{
		$feedback = 'Fix the following';
	}//end if valid

}//end parser



?>

<main>
	<div id="user-bar">
		<h2><?php echo $username; ?></h2>
		<h3><?php echo $location; ?></h3>
	</div>

	<aside>
		<div id="user-pic"></div>
		<ul class="user-links">
			<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="">INBOX (0)</a></li>
			<li><i class="fa fa-users" aria-hidden="true"></i><a href="">GROUPS</a></li>
			<li><i class="fa fa-calendar-plus-o" aria-hidden="true"></i><a href="calendar.php">CALENDAR</a></li>
			<li><i class="fa fa-cog" aria-hidden="true"></i><a href=""> SETTINGS</a></li>
		</ul>
	</aside>

	<div class="fl-rt">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $user_id; ?>" method="post">
	<?php form_feedback( $feedback, $errors ) ?>
		<section>
			<label for="about">ABOUT</label>
			<textarea name="about"><?php echo stripslashes($about); ?></textarea>
		</section>
		<section>
			<label for="about">INFLUENCES / MUSIC TASTES</label>
			<textarea name="influences"><?php echo stripslashes($influences); ?></textarea>
		</section>
		<section>
			<label for="about">INSTRUMENTS / SKILLS</label>
			<textarea name="skills"><?php echo stripslashes($skills); ?></textarea>
		</section>
		<section>
			<label for="about">CURRENT / PREVIOUS ACTS</label>
			<textarea name="bands"><?php echo stripslashes($bands); ?></textarea>
		</section>

		<input type="submit" value="Save" id="submit">
		<input type="hidden" name="did_save" value="1">

	</form>
	</div>


</main>



<?php 
}else{
	echo 'no result';
}//end if

require('footer.php');

 ?>

 