<?php 
//header includes the db connection and functions file + doctype
require('header.php'); ?>

	<main>
	<?php
	//set up query to get up to 3 of the published posts
	$get_posts = "SELECT title, date, body
			  FROM posts
			  WHERE is_published = 1
			  ORDER BY date DESC
			  LIMIT 3";
	//run it
	$result = $db->query( $get_posts );
	//check it
	if ( $result->num_rows >= 1 ){
	
	//loop it
	while ( $row = $result->fetch_assoc() ){
		
	
	
	 ?>
		<article>
			<h2><?php echo $row['title']; ?></h2>
			<h3>posted on <?php echo nice_date($row['date']); ?></h3>
			<p><?php echo $row['body']; ?></p>
		</article>

	<?php 
		}//end while loop

		//free it after the loop is done
		$result->free();

	}else{
		echo 'sorry no posts here';
	}//end if there are posts to show ?>
	</main>

<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>