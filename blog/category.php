<?php 
//header includes the db connection and functions file + doctype
require('header.php'); ?>

<main>

	<?php 
		$cat_id = $_GET['cat_id'];
		
		$get_cat = "SELECT categories.name, categories.category_id, posts.title, posts.post_id, posts.date, posts.body, users.username
					FROM categories, posts, users
					WHERE categories.category_id = posts.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
					AND categories.category_id = $cat_id
					ORDER BY date DESC
					LIMIT 10";

		$result = $db->query($get_cat);
	
	if( $result->num_rows >=1 ){ ?>

	<h2><?php echo $result->num_rows; ?> posts</h2>
	
	<?php
			while( $row = $result->fetch_assoc() ){
	 ?>
		<article class="cat_posts">
			<a href="single.php?post_id=<?php echo $row['post_id'];?>" target="_blank"><h2><?php echo $row['title']; ?></h2></a>
			<h3>posted by <span><?php echo $row['username']; ?></span> on <span><?php echo nice_date($row['date']); ?></span> category <span><?php echo $row['name']; ?></span></h3>
			<p><?php echo substr($row['body'], 0, 55); ?>&hellip; <a href="single.php?post_id=<?php echo $row['post_id'];?>" class="rmore">read more</a></p>
		</article>
	<?php 
		}//end while
		$result->free();

	}else{
		echo $db->error;
	}//end if

	?>

</main>


<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>