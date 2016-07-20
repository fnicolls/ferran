<?php 
session_start();
require('header.php');
require ('interior_head.php');


	if ( $_POST['did_submit'] ){
		//extract and sanitize
		$bandname 	= strip_tags(mysqli_real_escape_string($db, $_POST['bandname']));
		$date 		= strip_tags(mysqli_real_escape_string($db, $_POST['date']));
		$time 		= strip_tags(mysqli_real_escape_string($db, $_POST['time']));
		$venue 		= strip_tags(mysqli_real_escape_string($db, $_POST['venue']));
		$city 		= strip_tags(mysqli_real_escape_string($db, $_POST['city']));
		$state 		= strip_tags(mysqli_real_escape_string($db, $_POST['state']));
		$url 		= strip_tags(mysqli_real_escape_string($db, $_POST['url']));

		//validate
		$valid = true;
			if ( '' == $bandname ){
				$valid = false;
				$errors['bandname'] = 'Please enter a band name';
			}
			if ( '' == $date ){
				$valid = false;
				$errors['date'] = 'Please enter a date';
			}
			if ( '' == $time ){
				$valid = false;
				$errors['time'] = 'Please enter a time';
			}
			if ( '' == $venue ){
				$valid = false;
				$errors['venue'] = 'Please enter a venue';
			}
			if ( '' == $city ){
				$valid = false;
				$errors['city'] = 'Please enter a city';
			}
			if ( '' == $state ){
				$valid = false;
				$errors['state'] = 'Please select a state';
			}
			if ( !empty($url) ) {
				if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ){
					$valid = false;
					$errors['url'] = 'Please enter a valid url (http://www.website.com)';
				}
			}

		//if valid, insert into db
		if ( $valid ){
			$newevent = "INSERT INTO events
						 ( bandname, date, time, venue, city, state, url )
						 VALUES
						 ( '$bandname', '$date', '$time', '$venue', '$city', '$state', '$url' )";
			//run it
			$result = $db->query($newevent);

			//check it
			if ( $db->affected_rows ==1 ){
				$feedback = 'Thank you, your event has been added!';
				$bandname = '';
				$date = '';
				$time = '';
				$venue = '';
				$city = '';
				$state = '';
				$url = '';
				header("location:calendar.php");
			}else{
				$feedback = 'Sorry, something went wrong. Please refresh and try again.';
				echo $db->error;
			}//end check result

		}else{
			$feedback = 'Please correct the following and try again:';
		}//end if valid

	}//end parser



?>

<main id="cal">
<div class="add-event">
	<h2 class="add">Add an Event</h2>
	
	<?php form_feedback( $feedback, $errors ); ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="left">
		<label for="bandname">Band Name</label>
		<input type="text" name="bandname" id="bandname" value="<?php echo $bandname; ?>">
		<label for="date">Date of Event</label>
		<input type="date" name="date" id="date" value="<?php echo $date; ?>">
		<label for="time">Time of Event</label>
		<input type="time" name="time" id="time" value="<?php echo $time; ?>">
		</div>
		<div class="right">
		<label for="venue">Location (Venue)</label>
		<input type="text" name="venue" id="venue" value="<?php echo $venue; ?>">
		<label for="city">Location (City, State)</label>
		<input type="text" name="city" id="city" value="<?php echo $city; ?>">
		<select name="state">
		<option value="AL">AL</option>
		<option value="AK">AK</option>
		<option value="AZ">AZ</option>
		<option value="AR">AR</option>
		<option value="CA" selected>CA</option>
		<option value="CO">CO</option>
		<option value="CT">CT</option>
		<option value="DE">DE</option>
		<option value="DC">DC</option>
		<option value="FL">FL</option>
		<option value="GA">GA</option>
		<option value="HI">HI</option>
		<option value="ID">ID</option>
		<option value="IL">IL</option>
		<option value="IN">IN</option>
		<option value="IA">IA</option>
		<option value="KS">KS</option>
		<option value="KY">KY</option>
		<option value="LA">LA</option>
		<option value="ME">ME</option>
		<option value="MD">MD</option>
		<option value="MA">MA</option>
		<option value="MI">MI</option>
		<option value="MN">MN</option>
		<option value="MS">MS</option>
		<option value="MO">MO</option>
		<option value="MT">MT</option>
		<option value="NE">NE</option>
		<option value="NV">NV</option>
		<option value="NH">NH</option>
		<option value="NJ">NJ</option>
		<option value="NM">NM</option>
		<option value="NY">NY</option>
		<option value="NC">NC</option>
		<option value="ND">ND</option>
		<option value="OH">OH</option>
		<option value="OK">OK</option>
		<option value="OR">OR</option>
		<option value="PA">PA</option>
		<option value="RI">RI</option>
		<option value="SC">SC</option>
		<option value="SD">SD</option>
		<option value="TN">TN</option>
		<option value="TX">TX</option>
		<option value="UT">UT</option>
		<option value="VT">VT</option>
		<option value="VA">VA</option>
		<option value="WA">WA</option>
		<option value="WV">WV</option>
		<option value="WI">WI</option>
		<option value="WY">WY</option>
		</select>
		<label for="url">Band Website (optional)</label>
		<input type="url" name="url" id="url" value="<?php echo $url; ?>">
		</div>
		<input type="submit" value="Submit" id="submit">
		<input type="hidden" name="did_submit" value="true">
	</form>
</div>

<h2>Recently Added Events</h2>
<div class="cal">


<?php 
	$query = "SELECT *
			  FROM events
			  ORDER BY date DESC
			  LIMIT 20";

	$result = $db->query($query);


	if( $result->num_rows >=1 ){
		while( $row = $result->fetch_assoc() ){

 ?>
	<div class="event cf">
		<h3><?php echo $row['bandname']; ?></h3>
		<h3 class="venue">at <?php echo $row['venue']; ?></h3>
		<h4><?php echo nice_date($row['date']); ?> <span>|</span> <?php echo nice_time($row['time']); ?></h4>
		<h4><?php echo $row['city']; ?>, <?php echo $row['state']; ?></h4>
		
<?php 
	if ( !empty($row['url']) ){
?>
		<a href="<?php echo $row['url']; ?>" target="_blank">WEBSITE</a>
<?php } ?>
	</div>	
<?php 
		}//end while
		$result->free();
	}else{
		echo 'there are currently no events scheduled';
	}//end if
?>
</div>
</main>

<?php
require('footer.php');

 ?>

 