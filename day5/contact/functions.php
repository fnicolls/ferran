<?php 
/** (doc block)
 * helper function to add class to inputs 
 * for inline error display
 * @param $array : array. this is the list of all errors from form
 * @param $key : string. the input that caused the error, by name attribute
 */
function inline_error( $array, $key ){
	if( isset($array[$key]) ){
				echo 'class="error"';
	}
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

//no close php