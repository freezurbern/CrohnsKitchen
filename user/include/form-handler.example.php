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

if (!mysqli_set_charset($link, 'utf8'))
{
 $output = 'Unable to set database connection encoding.';
 include 'output.part.php';
 exit();
}

if (!mysqli_select_db($link, 'ckdata'))
{
 $output = 'Unable to locate the database.';
 include 'output.part.php';
 exit();
}

$output = 'Server and database connection established.';
include 'output.part.php';
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@@@	End Setup	@@@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

/* Remove a table's contents */
$sql = 'TRUNCATE TABLE users';
if (!mysqli_query($link, $sql))
{
	$output = 'Error truncating table: ' . mysqli_error($link);
	include 'output.part.php';
	exit();
}
else
{
	$output = 'Truncated table successfully.';
	include 'output.part.php';
}


/* Create a table */
$sql = 'CREATE TABLE IF NOT EXISTS users (
	uid int NOT NULL AUTO_INCREMENT,
	user varchar(60),
	email varchar(60),
	pass varchar(60),
	date_registered DATE,
	unique (user),
	unique (email),
	primary key (uid)
	) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating users table: ' . mysqli_error($link);
	include 'output.part.php';
	exit();
}
$output = '\'users\' table successfully created.';
include 'output.part.php';

/* Create a new row with information */
$username = 'testme';
$useremail = 'freezurbern+no@gmail.com';
$username_conv = mysqli_real_escape_string($link, $username);
$useremail_conv = mysqli_real_escape_string($link, $useremail);
 $sql = 'INSERT INTO users SET
     user="' . $username_conv . '",
     email="' . $useremail_conv . '"';
 if (!mysqli_query($link, $sql))
 {
   $output = 'Error adding submitted row: ' . mysqli_error($link);
   include 'output.part.php';
   exit();
 }
 else
 {
	$output = 'Row inserted successfully.';
	include 'output.part.php';
}

/* Update some rows with new information */
$sql = 'UPDATE users SET email="freezurbern+testme@gmail.com"
   WHERE user LIKE "%testme%"';
if (!mysqli_query($link, $sql))
{
	$output = 'Error performing update: ' . mysqli_error($link);
	include 'output.part.php';
	exit();
}

/* Get information out of the database, and show it in a template */
$result = mysqli_query($link, 'SELECT * FROM users');
if (!$result)
{
 $output = 'Error fetching user rows: ' . mysqli_error($link);
 include 'output.part.php';
 exit();
}

while ($row = mysqli_fetch_array($result))
{
	$userdata[] = array('uid' => $row['uid'], 'user' => $row['user'], 'pass' => $row['pass'], 'email' => $row['email']);
}

include 'user_table.html.php';


echo '</body>';
echo '</html>';
?>