<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 

//which post are we editing
$post_id = $_GET['post_id'];

//get all the info about the post to pre-fill the form
$query = "SELECT posts.*, categories.category_id
		  FROM posts, categories
		  WHERE posts.post_id = $post_id
		  AND posts.category_id = categories.category_id
		  AND posts.user_id = " . USER_ID .
		  " LIMIT 1";
$result = $db->query($query);

if( ! $result ){
	die($db->error);
}

if( $result->num_rows >= 1 ){
	$row = $result->fetch_assoc();
	extract($row);

//form parser
if ( $_POST['did_save'] ){
	$allowed_tags = '<img><br><p><b><i><a><h1><h2><h3><h4><h5><h6><blockquote>';
	//sanitize
	$title = mysqli_real_escape_string( $db, strip_tags($_POST['title']) );
	$body  = mysqli_real_escape_string( $db, strip_tags($_POST['body'], $allowed_tags) );
	$is_published 	= mysqli_real_escape_string( $db, filter_var($_POST['is_published'], FILTER_SANITIZE_NUMBER_INT) );
	$allow_comments = mysqli_real_escape_string( $db, filter_var($_POST['allow_comments'], FILTER_SANITIZE_NUMBER_INT) );
	$category_id 	= mysqli_real_escape_string( $db, filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) );

	//sanitize checkboxes to be 0 is unchecked instead of null
	if( $is_published == '' ){
		$is_published = 0;
	}
	if( $allow_comments == '' ){
		$allow_comments = 0;
	}

	//validate
	$valid = true;
	
	if ( $title == '' ){
		$valid = false;
		$errors['title'] = 'Title cannot be blank';
	}//end if title valid

	if ( $body == '' ){
		$valid = false;
		$errors['body'] = 'Your post cannot be blank';
	}

	if ( ! is_numeric($category_id) ){
		$valid = false;
		$errors['category_id'] = 'Choose a valid category';
	}

	//if valid, save to db & give feedback
	if( $valid ){
		$user_id = USER_ID;
		$query = "UPDATE posts
				  SET
				  	title 			= '$title',
				  	body 			= '$body',
				  	is_published 	= $is_published,
				  	allow_comments 	= $allow_comments,
				  	category_id 	= $category_id
				  WHERE post_id 	= $post_id
				  AND user_id		= $user_id";

		$result = $db->query($query);

		if( ! $result ){
			$feedback = $db->error;
		}elseif( $db->affected_rows == 1 ){
			//success
			$feedback = 'Your post was saved successfully';
		}else{
			$feedback = 'No changes made';
		}


	}else{
		$feedback = 'Fix the following problems:';
	}


}//end parser


?>

  <section class="panel important">
	<h2>Edit Your Post</h2>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $post_id ?>" method="post">
	
	<?php form_feedback( $feedback, $errors ) ?>
	<div class="twothirds">
		<label for="title">Title</label>
		<input type="text" name="title" value="<?php echo stripslashes($title); ?>">
		
		<label for="body">Body</label>
		<textarea name="body"><?php echo stripslashes($body); ?></textarea>
	</div>

	<div class="onethird">
		<label>
			<input type="checkbox" name="is_published" value="1" <?php echo $is_published == 1 ? 'checked' : ''; ?>>
			Make this post public
		</label>

		<label>
			<input type="checkbox" name="allow_comments" value="1" <?php echo $allow_comments == 1 ? 'checked' : ''; ?>>
			Allow comments
		</label>
		
		<label>Category:</label>
		<?php 
		$current_cat = $category_id;

		$query = "SELECT * FROM categories";
		$result = $db->query($query);

		if( $result->num_rows >= 1 ){
		?>
		<select name="category_id">
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<option value="<?php echo $row['category_id']; ?>" <?php echo $current_cat == $row['category_id'] ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
			<?php }//end while ?>
		</select>
		<?php }//end if ?>

		<input type="submit" value="Save Post" id="submit">

		<input type="hidden" name="did_save" value="1">
	</div>

	</form>

  </section>

<?php 
}else{
	echo 'No posts to show';
}//end if

include ('admin-footer.php'); ?>