<?php 
/* Update some rows with new information */
$sql = 'UPDATE users SET email="freezurbern+testme@gmail.com"
   WHERE user LIKE "%testme%"';
if (!mysqli_query($link, $sql))
{
	$output = 'Error performing update: ' . mysqli_error($link);
	include 'output.part.php';
	exit();
}

?>