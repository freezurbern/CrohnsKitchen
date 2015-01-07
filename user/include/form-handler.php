<?php
/*
 * Crohn's Kitchen, user form functions
 * This file accepts POST's from the /user/ forms and changes the database
 * author: freezurbern
 * date: Jan 2015
*/

require '../../../protected/db_auth.php';
include 'output.header.php';

$link = mysqli_connect(db_host, db_user, db_pass, db_name); 
if (!$link) 
{ 
	$output = 'Unable to connect to the database server.'; 
	include 'output.part.php'; 
	exit(); 
}
else
{
	$output = 'Database connection succeeded.'; 
	include 'output.part.php'; 
	exit(); 
}
if (!mysqli_set_charset($link, 'utf8')) 
{ 
	$output = 'Unable to set database connection encoding.'; 
	include 'output.part.php'; 
	exit(); 
}
else
{
	$output = 'Set database connection encoding.'; 
	include 'output.part.html.php'; 
	exit(); 
}



echo '</body>';
echo '</html>';
?>