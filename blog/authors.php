<?php 
//header includes the db connection and functions file + doctype
require('header.php'); ?>

<main>
	<h2>AUTHORS</h2>
	<?php 
	$authors = "SELECT username, bio
				FROM users";

	$result = $db->query($authors);

	if( $result->num_rows >= 1 ){
		while( $row = $result->fetch_assoc() ){
	 ?>

	<div class="authors">
		<h3><?php echo $row['username']; ?></h3>
		<p><?php echo $row['bio']; ?></p>
	</div>

	<?php
			}//end while
		}else{
			echo 'no users';
		}//end if/else
	 ?>

</main>


<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>