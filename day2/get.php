<?php 
//hide notices but keep errors
error_reporting( E_ALL & ~E_NOTICE );

?>
<!DOCTYPE html>
<html>
<head>
	<title>simple GET method example</title>
	<style type="text/css">
	body{
		font-family: Calibri, sans-serif;
		width: 50%;
		margin: 0 auto;
	}
	label{
		display: block;
		margin-top: 1em;
		color: cornflowerblue;
		font-weight: bold;
	}
	input{
		display: block;
		margin-top: 0.5em;
		background: aliceblue;
	}
	input[type="submit"]{
		width: 8em;
		background: lightcoral;
		color: white;
		border: none;
		padding: .5em;
	}
	</style>
</head>
<body>
	<div id="con">
	<h1>Simple GET Demo</h1>

	<?php 
	//only show message if forms are filled in

	if( $_GET['name'] != '' ){
		echo 'Hello, ' . $_GET['name'] . '<br>';	
	}
	
	if( $_GET['lunch'] != '' ){
	echo $_GET['lunch'] . ' sounds delicious';
	}


	?>
	<form method="get" action="get.php">
		<label>What's your name?</label>
		<input type="text" name="name" value="<?php echo $_GET['name']; ?>">
		<label>What's for lunch?</label>
		<input type="text" name="lunch" value="<?php echo $_GET['lunch']; ?>">

		<input type="submit" value="GO!">



	</form>
</div>


</body>
</html>