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
	<section>
		<h4>ABOUT</h4>
		<div><?php echo stripslashes($about); ?></div>
	</section>
	<section>
		<h4>INFLUENCES / MUSIC TASTES</h4>
		<div><?php echo stripslashes($influences); ?></div>
	</section>
	<section>
		<h4>INSTRUMENTS / SKILLS</h4>
		<div><?php echo stripslashes($skills); ?></div>
	</section>
	<section>
		<h4>CURRENT / PREVIOUS ACTS</h4>
		<div><?php echo stripslashes($bands); ?></div>
	</section>
	</div>


</main>



<?php
}else{
	echo 'no result';
}//end if

require('footer.php');

 ?>

 