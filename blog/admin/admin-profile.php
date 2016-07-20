<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 

if($_POST['did_upload']){
	//uploads folder
	$upload_dir = '../uploads';
	$sizes = array(
		'thumbnail' => 150,
		'medium' 	=> 300,
		);

	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];

	if( $uploadedfile){
		//validate image
		list($width, $height) = getimagesize($uploadedfile);
	}//end if uploaded file not blank

	if( $width > 0 AND $height > 0 ){
		//what type of image is it
		$filetype = $_FILES['uploadedfile']['type'];
		
		switch ($filetype) {
			case 'image/gif':
				//process
				$src = imagecreatefromgif($uploadedfile);
			break;

			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				//process
				$src = imagecreatefromjpeg($uploadedfile);
			break;
			
			case 'image/png':
				//temporarily increase server memory
				ini_set( 'memory_limit', '16M' );
				//process
				$src = imagecreatefrompng($uploadedfile);
				//restore memory
				ini_restore('memory_limit');
			break;

			default:
				$feedback = 'The allowed file types are gif, jpg, and png';
			break;
		}//end switch

		//resize and save each image size
		$uniquestring = sha1( microtime() );
		foreach( $sizes as $size_name => $size_width ){
			//check if image is wider than target width
			if( $width > $size_width ){
				//large image: calculate target height
				$target_width = $size_width;
				$target_height = ($target_width * $height) / $width;
			}else{
				//smaller image
				$target_width = $width;
				$target_height = $height;
			}//end if width > size_width

			//resize image - make canvas of desired size
			$tmp_canvas = imagecreatetruecolor($target_width, $target_height);
			//copy original image onto canvas
			imagecopyresampled($tmp_canvas, $src, 0, 0, 0, 0, $target_width, $target_height, $width, $height);
			
			//save it (../uploads/eoiagheosfjesiof_thumbnail.jpg)
			$filepath = $upload_dir . '/' . $uniquestring . '_' . $size_name . '.jpg';
			$did_save = imagejpeg($tmp_canvas, $filepath, 75);
			// imagedestroy($tmp_canvas);

		}//end foreach sizes

		//if it worked, save file name in db for the logged in user
		if($did_save){
			//delete old avatar
			$query_old = "SELECT userpic FROM users WHERE user_id = " . USER_ID . " LIMIT 1";
			$result_old = $db->query($query_old);
				if( $result_old->num_rows == 1 ){
					$row_old = $result_old->fetch_assoc();
					foreach ($sizes as $size_name => $size_width) {
						$old_filepath = ROOT_PATH . '/uploads/' . $row_old['userpic'] . '_' . $size_name  . '.jpg';
						//delete it
						@unlink($old_filepath);
					}//end foreach
				}//end if

			$query = "UPDATE users
					  SET userpic = '$uniquestring'
					  WHERE user_id = " . USER_ID ;
			$result = $db->query($query);

			if( $db->affected_rows == 1 ){
				$feedback = 'Saved successfully';
			}else{
				$feedback = 'db error';
			}//end if affected
		}else{
			$feedback = 'File not saved, try again';
		}//end if did_save

	}else{
		$feedback = 'Please upload a valid image';
	}

}//end did_upload parser

?>

<section class="panel important">
	<h2>Edit Your Profile</h2>
	<?php show_userpic( USER_ID, 'thumbnail' ); ?>

	<?php form_feedback($feedback, array()) ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
		<label>Upload a Userpic</label>
		<input type="file" name="uploadedfile">
		<input type="submit" value="Upload">
		<input type="hidden" name="did_upload" value="1">
	</form>

</section>

<?php include ('admin-footer.php'); ?>