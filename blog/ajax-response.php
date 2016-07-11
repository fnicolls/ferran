<?php 
/**
 * display output
 * this file has no doctype and will never leave the server
 * it simply runs a query and returns the text content for our interface 
 */
require ('db-config.php');

//this var will be sent to this file via JS
$category_id = $_REQUEST['cat_id'];

//query to get all the published posts in that category
$query = "SELECT posts.title, posts.body, users.username
		  FROM posts, users
		  WHERE posts.user_id = users.user_id
		  AND posts.is_published = 1
		  AND posts.category_id = $category_id
		  ORDER BY date DESC";

$result = $db->query($query);

if( ! $result ){
	echo $db->error;
}


?>
<h2><?php echo $result->num_rows; ?> posts found</h2>
<?php if ( $result->num_rows >=1 ) {
	while( $row = $result->fetch_assoc() ){
?>
<article>
	<h3><?php echo $row['title'] ?></h3>
	<h4>by <?php echo $row['username'] ?></h4>
	<p><?php echo $row['body'] ?></p>
</article>
<?php
	}//end if
}//end while
?>