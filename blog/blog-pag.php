<?php 
//header includes the db connection and functions file + doctype
require('header.php'); 
?>

<main>
	<?php
	$per_page 		= 5;
	$current_page 	= 1;
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

	
	if ( $totalposts>=1 ){ 
	//how many pages will it take to display all posts
	$totalpages = ceil($totalposts/$per_page);

	//what page is user on?
	//the url will look like: search.php?phrase=x&page=2
	if ( $_GET['page'] ) {
		$current_page = $_GET['page'];
	}
	//make sure user is viewing valid page
	if ( $current_page <= $totalpages ) {
		//calculate offset for limit
		$offset = ( $current_page - 1 ) * $per_page;
		//add on to orginal query
		$get_posts .= "LIMIT $offset, $per_page";
		//run it again
		$result = $db->query($get_posts);
	

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

	<section class="pagination">
		<?php 
		$prev = $current_page - 1;
		$next = $current_page + 1;

		//hide prev button on page 1
		if ( $current_page > 1 ){
		?>
		<a href="blog.php?page=<?php echo $prev; ?>">Prev</a><?php } 

		//BONUS: numbered pagination
		$counter = 1;
		while ( $counter <= $totalpages ){
			if ( $counter == $current_page ) {
				echo '<span class="current">' . $counter . '</span>';
			}else{
				echo '<a href="blog.php?page=' . $counter . '">' . $counter . '</a>';
			}

			$counter++;
		}
		


		//hide next button on last page
		if ( $current_page < $totalpages) {
		?>
		<a href="blog.php?page=<?php echo $next; ?>">Next</a><?php } ?>
	</section>

<?php 
	}else{
		echo '<h2>whoopsy, this page is invalid</h2>';
	}//end if valid page
}else{
	echo '<h2>Sorry, no results found</h2>';
}//end if results ?>



	</main>

<?php 
include('aside.php');

//footer closes the db connection
require('footer.php'); ?>