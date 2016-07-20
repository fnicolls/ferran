<?php
/**
 * convert mySQL datetime to more readable format Month day, Year 
 * @param  string $timestamp
 * @return date format F=month j=day Y=year
 */
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('F j, Y');
}


/**
 * counts comments for each post
 * @param  INT 		$post_id     the post id of a published post
 * @param  BOOLEAN  $number_only if true(default) will display just the number, 
 *                               if false will display comments next to #
 * @return STRING             	 echoes comment count
 */
function count_comments( $post_id, $number_only ){
	//look outside of function to find db connection
	global $db;
	//set up query to count comments on post
	$query = "SELECT COUNT(*) AS count
			  FROM comments
			  WHERE post_id = $post_id
			  AND is_approved = 1";
	//run it
	$result = $db->query($query);
	//check it
	if ( $result->num_rows>=1 ) {
		//loop it
		while ( $row = $result->fetch_assoc() ){
			echo $row['count'];
			if ( ! $number_only )
				if ( $row['count'] != 1 ) {
					echo ') comments';
				}else{
					echo ') comment';
				}
		}
		//free it
		$result->free();
	}//end if
	
}//end count_comments


/**
 * gets approved comments to list on single.php
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function list_comments( $post_id ){
	global $db;
	//get all approved comments for this post
	$comments = "SELECT name, date, body, url
				 FROM comments
				 WHERE is_approved = 1
				 AND post_id = $post_id
				 ORDER BY date ASC
				 LIMIT 20";
	//run it
	$result = $db->query($comments);
	//check it
	if ( $result->num_rows >= 1 ){
	?>
		<section class="comment-list" id="comm">
			<h4><?php echo $result->num_rows ?> comments on this post</h4>
			<ul>
			<?php while ( $row = $result->fetch_assoc()) {?>
				<li>
					<h5>Comment from <?php echo $row['name']; ?> on <?php echo nice_date($row['date']); ?>:</h5>
					<div class="comment-body"><?php echo $row['body']; ?></div>
				</li>
			<?php }//end comments while loop ?>
			</ul>

		</section>


	<?php 
	}//end if comments
}


/**
 * inserts error feedback at top of form
 * @param  string $feedback feedback message that appears at top of form
 * @param  array $errors list of input errors
 * @return HTML displays the complete div output for feedback box
 */
function form_feedback( $feedback, $errors ){
	if( isset($feedback) ){ ?>
	<div class="feedback">
		<?php echo $feedback; 
		//show the errors if any
		if( ! empty($errors) ){
			echo '<ul>';
				foreach ($errors as $error) {
					echo '<li>' . $error . '</li>';
				}
			echo '</ul>';
		}
		?>
	</div>
<?php }
}


function show_userpic( $user_id, $size = 'medium' ){
	global $db;
	//get userpic for this user
	$query = "SELECT userpic
			  FROM users
			  WHERE user_id = $user_id
			  LIMIT 1";
	$result = $db->query($query);
	if( ! $result ){
		echo $db->error;
	}
	if( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		//display userpic if it exists
		if( $row['userpic'] != '' ){
			$url = ROOT_URL . '/uploads/' . $row['userpic'] . '_' . $size . '.jpg';
		}else{
			//display generic user image
			$url = ROOT_URL . '/imgs/generic_user.jpg';
		}//end if userpic exists
	}//end if num_rows

	echo '<img src="'. $url . '" class="userpic" alt="userpic">';
}



//no close php