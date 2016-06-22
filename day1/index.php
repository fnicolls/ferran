<?php 
//grab functions file
include('includes/functions.php');

//define some variables
$breakfast = 'waffle';
$beverage = 'coffee';

//constant example
define('USER', 'bob');

$score = 500;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Simple PHP Demo</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1>Normal HTML Heading</h1>
	<?php 
	include('includes/nav.php');
	//this is a single line comment
	#this is also a single line comment
	/*
	multiple line
	comment
	*/

	// echo or print - display something on page
	// print ('Hello')
	// echo 'some random text';
	// echo '<div>hello</div>';

	//use double quotes when using variables
	//quotes are optional when just passing variable
	echo "<p>I had a $breakfast with $beverage for breakfast</p>";


	//display constant
	echo USER;

	//call custom function
	echo '<div>';
	nice_date('2016-06-20');
	echo '</div>';

	//concatenate with .
	// echo 'div' . nice_date('2016-06-20') . '</div>';

	//if the score is higher than 1000, show a success message
	if($score > 1000){
		echo '<div>You win!</div>';
	}else{
		echo '<div>Your score is not high enough</div>';
	}


	//switch example
	//date('N') is numerical representation of the day of the week (monday == 1)
	switch (date('N')) {
		case 1:
			echo 'Somebody\'s got a case of the mondays';
		break;
		
		case 2:
			echo 'Happy Taco Tuesday';
		break;

		case 3:
			echo 'Happy Hump Day';
		break;

		default:
			echo 'Today is not a day';
	}

	 ?>
</body>
</html>