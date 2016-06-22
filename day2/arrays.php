<?php 
$movies = array('Star Wars','Deadpool','The Lobster','Wet Hot American Summer', 'Purple Rain');
sort($movies);


//associative array example
$groceries = array(  
	'milk' => '1 gallon',
	'eggs' => 12,
	'sausage' => 'lotsa',
	'spinach' => '1 bunch',
	'bread' => '2 loaves',
	'bananas' => 6,
);
//add one item at a time
$groceries['olives'] = '1 jar';

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Array Practice</title>
</head>
<body>
<pre>
<?php 
	print_r ($groceries);
?>
</pre>

<?php 
	/* foreach ($movies as $movie) {
		echo '<h2>' . $movie . '</h2>';
	}*/
 ?>
<?php 
//show list if array is not empty
	if( !empty($groceries) ){

 ?>
<h1>Grocery List</h1>
<ul>
	<?php foreach ($groceries as $item => $amount) { ?>
	<li><b><?php echo $item; ?></b> qty: <?php echo $amount ?></li>
	<?php } ?>
</ul>

<?php } ?>



</body>
</html>