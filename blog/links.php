<?php 
//header includes the db connection and functions file + doctype
require('header.php'); ?>

<main>
	<h2>LINKS</h2>
	<?php 
	$get_links = "SELECT links.url, links.title, links.description, 					 links.user_id, users.username
				  FROM links, users
				  WHERE links.user_id = users.user_id";

	$result = $db->query( $get_links );

	if( $result->num_rows >=1 ){
		while( $row = $result->fetch_assoc() ){
	 ?>

	 <div class="links">
	 	<h3><a href="<?php echo $row['url'] ?>" target="_blank"><?php echo $row['title'] ?></a></h3>
	 	<p><?php echo $row['description'] ?></p>
	 	<p class="sm">posted by <?php echo $row['username'] ?></p>

	 </div>

	 <?php 
	 	}//end while
	 	$result->free();
	}else{
		echo 'no links';
	}//end if
	 ?>

</main>


<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>