<?php 
//db credentials

$database_name 	= 'ferran_blog';
$db_user 		= 'ferran_blog';
$db_password 	= 'JF8ZAuN5XfewGeFQ';

//connect to database
$db = new mysqli( 'localhost', $db_user, $db_password, $database_name );

//if there is a problem connecting
if ($db->connect_errno > 0) {
	die('could not connect to database' . $db->connect_error );
}

//site root constant - for file path relativity
//for HTML like <a> or <img>
define('ROOT_URL', 'http://localhost/ferran/blog');
//for server stuff, like include()
define('ROOT_PATH', 'C:\xampp\htdocs\ferran\blog');


error_reporting( E_ALL & ~E_NOTICE );
	
//no close php