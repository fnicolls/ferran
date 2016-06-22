<?php 
error_reporting( E_ALL & ~E_NOTICE);

//if query string is blank, set page to home
if($_GET['page'] == ''){
	$_GET['page'] = 'home';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>my very own website so proud</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="<?php echo $_GET['page']; ?>">
	<header>
		<h1>MY SHITTY LIL WEBSITE</h1>
		<nav>
			<ul>
				<li class="home"><a href="index.php?page=home">Home</a></li>
				<li class="about"><a href="index.php?page=about">About</a></li>
				<li class="portfolio"><a href="index.php?page=port">Portfolio</a></li>
				<li class="contact"><a href="index.php?page=contact">Contact</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<?php
		//based on link clicked, content will change
		switch ( $_GET['page'] ) {
			case 'about':
				include('content-about.php');
				break;

			case 'port':
				include('content-portfolio.php');
				break;

			case 'contact':
				include('content-contact.php');
				break;
			
			default:
				include('content-home.php');
				break;
		}

		?>

	</main>

	<footer>
		<small>&copy; 2016 Ferran Nicolls</small>
	</footer>

</body>
</html>