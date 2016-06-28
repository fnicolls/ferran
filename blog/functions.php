<?php
/**
 * convert mySQL datetime to more readable format Month day, Year 
 * @param  string $timestamp
 * @return date format F=month j=day Y=year
 */
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('F j, Y');
}

//no close php