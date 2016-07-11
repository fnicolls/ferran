<?php 
//this template is for displaying one post
//link will look like
//domain.com/single.php?post_id=#

//extract the post id
$post_id = $_GET['post_id'];



//header includes the db connection and functions file + doctype
require('header.php'); 

//parse the comment form when submitted
if ( $_POST['did_comment'] ){
	//extract and sanitize
	$name 	= strip_tags(mysqli_real_escape_string($db, $_POST['name']));
	$email 	= strip_tags(mysqli_real_escape_string($db, $_POST['email']));
	$url 	= strip_tags(mysqli_real_escape_string($db, $_POST['url']));
	$body 	= strip_tags(mysqli_real_escape_string($db, $_POST['body']));
	//validate
	$valid = true;
		if ( '' == $name ){
			$valid = false;
			$errors['name'] = 'Please enter your name';
		}
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
			$valid = false;
			$errors['email'] = 'Please enter a valid email';
		}
		if ( '' == $body ){
			$valid = false;
			$errors['body'] = 'The comment cannot be blank';
		}

	//if valid, add to db and show user feedback
	if ( $valid ) {
		//set up query
		$newcomm = "INSERT INTO comments
					( name, email, url, body, date, post_id, is_approved)
					VALUES
					( '$name', '$email', '$url', '$body', now(), $post_id, 1 )";
		//run it
		$result = $db->query($newcomm);

		//check it
		if ( $db->affected_rows == 1 ){
			$feedback = 'Thank you for your comment';
		}else{
			$feedback = 'Sorry, something went wrong. Please refresh and try again';
		}//end check result

	}else{
		$feedback = 'Please correct the following errors and try again';
	}//end if valid

}//end comment parser



?>

	<main>
	<?php
	//set up query to get the post we're trying to view
	$get_posts = "SELECT posts.post_id, posts.title, posts.date, posts.body, posts.allow_comments, 
						 users.username, categories.name AS catname
			  	  FROM posts, users, categories
			  	  WHERE posts.is_published = 1
			  	  AND posts.user_id = users.user_id
			  	  AND posts.category_id = categories.category_id
			  	  AND posts.post_id = $post_id
			  	  LIMIT 1";
	//run it
	$result = $db->query( $get_posts );
	//check it
	if ( $result->num_rows >= 1 ){
	
	//loop it
	while ( $row = $result->fetch_assoc() ){
		
	
	
	 ?>
		<article>
			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>
			<h3>
			posted by <span><?php echo $row['username']; ?></span>
			on <span><?php echo nice_date($row['date']); ?></span>
			category <span><?php echo $row['catname']; ?></span>
			</h3>
			
			<h3><span>(<?php count_comments( $row['post_id'], 0 ); ?></span></h3>
		</article>


	<?php 
			//show all comments on this post (defined in functions.php)
			list_comments( $post_id );

			//show the comment form, if comments are allowed on this post
			if( $row['allow_comments'] ){ ?>
				<h4 id="commform">Leave a Comment:</h4>

				<?php form_feedback( $feedback, $errors ); ?>

				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $post_id; ?>#commform" method="post">
					<label for="name">Your Name</label>
					<input type="text" name="name" id="name" value="<?php echo $name; ?>">

					<label for="email">Email</label>
					<input type="email" name="email" id="email" value="<?php echo $email; ?>">

					<label for="url">URL (optional)</label>
					<input type="url" name="url" id="url" value="<?php echo $url; ?>">

					<label for="body">Comment:</label>
					<textarea name="body" id="body"><?php echo $body; ?></textarea>

					<input type="submit" value="Post Comment" id="submit">

					<input type="hidden" name="did_comment" value="1">
				</form>
			<?php
			}//end if comments allowed




		}//end post while loop

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