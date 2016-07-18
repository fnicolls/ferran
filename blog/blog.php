<?php 
//header includes the db connection and functions file + doctype
require('header.php'); 
?>

<main>
	<?php
	
	//set up query to get the published posts
	$get_posts = "SELECT posts.post_id, posts.title, posts.date, posts.body, users.username, categories.name AS catname
			  FROM posts, users, categories
			  WHERE posts.is_published = 1
			  AND posts.user_id = users.user_id
			  AND posts.category_id = categories.category_id
			  ORDER BY posts.date DESC";
	//run it
	$result = $db->query( $get_posts );
	$totalposts = $result->num_rows;
	

		if ( $result->num_rows >= 1 ){
		while ( $row = $result->fetch_assoc() ){
	 ?>
		<article>
			<h2>
			<a href="single.php?post_id=<?php echo $row['post_id'];?>">
			<?php echo $row['title']; ?>
			</a>
			</h2>
			<h3>
			posted by <span><?php echo $row['username']; ?></span>
			on <span><?php echo nice_date($row['date']); ?></span>
			category <span><?php echo $row['catname']; ?></span>
			</h3>
			<p><?php echo $row['body']; ?></p>
			<a href="single.php?post_id=<?php echo $row['post_id'];?>#comm"><h3 class="right"><span>(<?php count_comments( $row['post_id'], 0 ); ?></span></h3></a>
		</article>
	<?php } //end while
		} //end if
	?>



	</main>

<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>