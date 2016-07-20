<?php

function is_logged_in(){
	if( defined('USER_ID') ){
		return true;
	}else{
		return false;
	}
}

function auth_user(){
	global $db;
	$user_id = $_SESSION['user_id'];
	$secretkey = $_SESSION['key'];

	$query = "SELECT username FROM users
			  WHERE user_id = $user_id
			  AND secretkey = '$secretkey'
			  LIMIT 1";
	$result = $db->query($query);

	if ( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		define('USER_ID', $user_id);
		define('USERNAME', $row['username']);
	}
}



/**
 * convert mySQL datetime to more readable format Month day, Year 
 * @param  string $timestamp
 * @return date format F=month j=day Y=year
 */
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('F j, Y');
}

function nice_time( $timestamp ){
	$time = new DateTime( $timestamp );
	return $time->format('g a');
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
				}//end foreach
			echo '</ul>';
		}//end if
		?>
	</div>
<?php }//end isset
}//end form_feedback



//no close php