<?php 
	
//this file will store all the functions for the site	

function nice_date($ugly_date){
	$date = new DateTime($ugly_date);
	echo $date->format('l, F j, Y');
}


//no close PHP because we don't need to switch back into HTML