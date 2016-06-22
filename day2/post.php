<?php 
//hide notices but keep errors
error_reporting( E_ALL & ~E_NOTICE );

?>
<!DOCTYPE html>
<html>
<head>
	<title>simple POST method example</title>
	<style type="text/css">
	body{
		font-family: Calibri, sans-serif;
		width: 50%;
		margin: 0 auto;
		background: lavender;
	}
	form{
		background: white;
		padding-left: 1em;
		padding-top: 0.5em;
		padding-bottom: 1em;
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
	<h1>Simple POST Demo</h1>

	<?php 
	//only show message if forms are filled in

	if( $_POST['name'] != '' ){
		echo 'Hello, ' . $_POST['name'] . '<br>';	
	}
	
	if( $_POST['lunch'] != '' ){
	echo $_POST['lunch'] . ' sounds delicious';
	}


	?>
	<form method="post" action="post.php">
		<label>What's your name?</label>
		<input type="text" name="name" value="<?php echo $_POST['name']; ?>">
		<label>What's for lunch?</label>
		<input type="text" name="lunch" value="<?php echo $_POST['lunch']; ?>">

		<input type="submit" value="GO!">



	</form>
</div>


</body>
</html>