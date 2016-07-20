<?php 

$database_name = 'playground';
$db_user	   = 'fnicolls';
$db_password   = 'FR33B34T5';

$db = new mysqli( 'localhost', $db_user, $db_password, $database_name );

if( $db->connect_errno > 0 ){
	die( 'could not connect to database' . $db->connect_error );
}

error_reporting(E_ALL & ~E_NOTICE);
//no close php