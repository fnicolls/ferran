<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 

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
		$query = "INSERT INTO posts
				  ( user_id, title, date, category_id, body, is_published, allow_comments )
				  VALUES
				  ( $user_id, '$title', now(), $category_id, '$body', $is_published, $allow_comments )";
		$result = $db->query($query);

		if( ! $result ){
			$feedback = $db->error;
		}elseif( $db->affected_rows == 1 ){
			//success
			$feedback = 'Your post was saved successfully';
		}else{
			$feedback = 'Post NOT saved';
		}


	}else{
		$feedback = 'Fix the following problems:';
	}


}//end parser



?>

  <section class="panel important">
	<h2>Write a New Post</h2>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	<?php form_feedback( $feedback, $errors ) ?>
	<div class="twothirds">
		<label for="title">Title</label>
		<input type="text" name="title" value="<?php echo stripslashes($title); ?>">
		
		<label for="body">Body</label>
		<textarea name="body"><?php echo stripslashes($body); ?></textarea>
	</div>

	<div class="onethird">
		<label>
			<input type="checkbox" name="is_published" value="1">
			Make this post public
		</label>

		<label>
			<input type="checkbox" name="allow_comments" value="1">
			Allow comments
		</label>
		
		<label>Category:</label>
		<?php 
		$query = "SELECT * FROM categories";
		$result = $db->query($query);

		if( $result->num_rows >= 1 ){
		?>
		<select name="category_id">
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<option value="<?php echo $row['category_id']; ?>"><?php echo $row['name']; ?></option>
			<?php }//end while ?>
		</select>
		<?php }//end if ?>

		<input type="submit" value="Save Post" id="submit">

		<input type="hidden" name="did_save" value="1">
	</div>

	</form>

  </section>

<?php include ('admin-footer.php'); ?>