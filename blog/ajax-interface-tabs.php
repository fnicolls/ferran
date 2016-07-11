<?php require ('db-config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AJAX interface</title>
	<link rel="stylesheet" href="css/ajax-style.css">
</head>
<body>
	
	<h1>Read all posts in a category</h1>
<?php 
$query = "SELECT * FROM categories"; 
$result = $db->query($query);

//check for query problems
if( ! $result ){
	echo $db->error;
}
//check if there are rows to show
if( $result->num_rows >=1 ){
?>
	<ul class="tabs">
	<?php while ( $row = $result->fetch_assoc() ) { ?>
		<li class="tab" data-cat="<?php echo $row['category_id']; ?>" >
		<?php echo $row['name']; ?>
		</li>
	<?php } ?>
	</ul>


<?php } ?>

<div id="display-area">Pick a category to view posts</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
	$('.tab').click(function(){
		//get the data-cat='id' of the chosen category
		var cat_id = $(this).data('cat');

		//"current" state
		$('.tab').removeClass('current');
		$(this).addClass('current');
		

		//make request to ajax-response.php
		$.ajax({
			method	: 'GET',
			url		: 'ajax-response.php',
			data	: { 'cat_id' : cat_id },
			dataType: 'html',
			success : function( response ){
				$('#display-area').html(response);
			}
		});

	});

	//handle the AJAX events to show "loading" feedback
	$(document).on({
		ajaxStart : function(){ $('#display-area').addClass('loading'); },
		ajaxStop  : function(){ $('#display-area').removeClass('loading'); }
	}); 

</script>


</body>
</html>