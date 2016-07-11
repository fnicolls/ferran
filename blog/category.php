<?php 
//header includes the db connection and functions file + doctype
require('header.php'); ?>

<main>

	<?php 
		$category_id = $_REQUEST['cat_id'];
		
		$get_cat = "SELECT categories.name, posts.title, posts.post_id, posts.date, users.username
					FROM categories, posts, users
					WHERE categories.category_id = posts.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
					ORDER BY date DESC
					LIMIT 10";

		$result = $db->query( $get_cat );?>

<h2><?php echo $result->num_rows; ?> posts in the <?php echo $row['name']; ?>category</h2>
	
	<?php
		if( $result->num_rows >=1 ){
			while( $row = $result->fetch_assoc() ){
	 ?>
	 
		<article class="cat_posts">
			<a href="single.php?post_id=<?php echo $row['post_id'];?>" target="_blank"><h2><?php echo $row['title']; ?></h2></a>
			<h3>posted by <span><?php echo $row['username']; ?></span> on <span><?php echo nice_date($row['date']); ?></span></h3>
		</article>
	<?php 
		}//end while
		$result->free();

	}else{
		echo 'no posts';
	}//end if

	?>

</main>


<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>