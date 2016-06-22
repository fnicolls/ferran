<?php 
//make a list of all products
$products = array(
	1 => array(
			'title' 		=> 'dumb shirt',
			'description' 	=> 'a stupid little shirt i hate it',
			'price' 		=> '$666',
			'image' 		=> 'http://fillmurray.com/200/200',
 		), 
	2 => array(
			'title' 		=> 'lame hat',
			'description' 	=> 'the worst hat ever get it away',
			'price' 		=> '$1',
			'image' 		=> 'http://placekitten.com/200/200',
 		), 
	3 => array(
			'title' 		=> 'terrible pants',
			'description' 	=> 'do not wear these pants ever or else',
			'price' 		=> '$69',
			'image' 		=> 'http://placecorgi.com/200/200',
 		), 


	);

 ?>
<html>
<head>
	<title>catalog with multi-dimensional arrays</title>
</head>
<style type="text/css">
	*{
		box-sizing: border-box;
	}
	.cf:after {
     visibility: hidden;
     display: block;
     font-size: 0;
     content: " ";
     clear: both;
     height: 0;
     }
	.cf { display: inline-block; }
	* html .cf { height: 1%; }
	.cf { display: block; }

	body{
		font-family: sans-serif;
		background: black;
	}
	#contain{
		margin: 3em auto;
		width: 80%;
		background: white;
		padding-left: 2em;
		padding-right: 2em;
		padding-bottom: 4em;
		padding-top: 1em;
	}
	div.product{
		width: 33%;
		float: left;
		margin: 0 auto;
	}
	h2{
		font-size: 1.25em;
		text-transform: uppercase;
	}
	p{
		font-size: 0.8em;
	}
	.price{
		font-weight: bold;
		font-size: 1em;
		color: red;
	}
	a{
		text-decoration: none;
		color: white;
		font-size: 0.8em;
	}
	.button{
		width: 6em;
		background: black;
		padding: 0.75em;
		text-align: center;
	}
	.message{
		margin-bottom: 2em;
	}
</style>
<body>
	<div id="contain" class="cf">

	<h1>BAD PRODUCTS</h1>
	<?php //only show when user selects something
		if( isset($_GET['id']) ){
			$id = $_GET['id'];
		 ?>
	<div class="message">You just added <b><?php echo $products[$id]['title'] ?></b> to your cart, you idiot</div>
	<?php } ?>


	<?php  
	//check if array is not empty
	if ( !empty($products) ) {
		foreach ($products as $id => $product) {
		
	?>
	<div class="product">
		<img src="<?php echo $product['image']; ?>" width="200" height="200">
		<h2><?php echo $product['title']; ?></h2>
		<p><?php echo $product['description']; ?></p>
		<p class="price"><?php echo $product['price']; ?></p>
		<div class="button"><a href="?id=<?php echo $id; ?>">Add to Cart</a></div>
	</div>
	<?php
		}//end foreach
	}else{
		echo 'sorry nothing here today goodbye';
	}//end ifelse
	 ?>

	</div>
</body>
</html>