<?php 
//header
require ('header.php'); 

//search config
$per_page 		= 3;
$current_page 	= 1; //what page to start on

//extract and sanitize search string
$phrase = mysqli_real_escape_string($db, $_GET['phrase']);

//get all published posts that match phrase
$query = "SELECT title, date, body, post_id
		  FROM posts
		  WHERE (title LIKE '%$phrase%'
		  OR body LIKE '%$phrase%')
		  AND is_published = 1 ";

//run it
$result = $db->query($query);
$totalposts = $result->num_rows;


?>

<main>
<?php //check it
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
		$query .= "LIMIT $offset, $per_page";
		//run it again
		$result = $db->query($query);

	?>
	<h2><?php echo $totalposts; ?> posts found for <?php echo $phrase; ?></h2>
	<h3>Showing page <?php echo $current_page; ?> of <?php echo $totalpages; ?></h3>

	<?php while ( $row = $result->fetch_assoc() ){?>
	<article>
		<h2><a href="single.php?post_id=<?php echo $row['post_id'];?>"><?php echo $row['title']; ?></a></h2>
		<h3><span><?php echo nice_date($row['date']); ?></span></h3>
		<p><?php echo substr($row['body'], 0, 55); ?>&hellip; <a href="single.php?post_id=<?php echo $row['post_id'];?>" class="rmore">read more</a></p>
	</article>
	<?php } ?>



	<section class="pagination">
		<?php 
		$prev = $current_page - 1;
		$next = $current_page + 1;

		//hide prev button on page 1
		if ( $current_page > 1 ){
		?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>">Prev</a><?php } 

		//BONUS: numbered pagination
		$counter = 1;
		while ( $counter <= $totalpages ){
			if ( $counter == $current_page ) {
				echo '<span class="current">' . $counter . '</span>';
			}else{
				echo '<a href="search.php?phrase=' . $phrase . '&amp;page=' . $counter . '">' . $counter . '</a>';
			}

			$counter++;
		}
		


		//hide next button on last page
		if ( $current_page < $totalpages) {
		?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">Next</a><?php } ?>
	</section>

<?php 
	}else{
		echo '<h2>whoopsy, this page is invalid</h2>';
	}//end if valid page
}else{
	echo '<h2>Sorry, no results found</h2>';
}//end if results ?>

</main>

<?php include ('aside.php'); ?>
<?php require ('footer.php'); ?>