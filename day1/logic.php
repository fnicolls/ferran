<?php  
//define variables
$status = 'success';
//set content based on value of status
if($status == 'success'){
	$title = 'Yay! Success!';
	$content = 'Thanks good job';
}else{
	$title = 'Oh No!';
	$content = 'Try again';
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Logic Example</title>
	<style>
	.message{
		background-color: aliceblue;
		border: solid 6px lightcoral;
		padding: .5em;
		border-radius: 1em;
		font-family: Calibri, sans-serif;
	}
	.success{
		border-color: lightgreen;
	}
	.error{
		border-color: coral;
	}
	</style>
</head>
<body>
	<div class="<?php echo $status; ?> message">
		<h2><?php echo $title; ?></h2>
		<p><?php echo $content; ?></p>
	</div>


</body>
</html>