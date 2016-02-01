<?php
/*
 * Crohn's Kitchen, user form functions
 * Examples of how to code the back end functions for forms.
 * author: freezurbern
 * date: Jan 2015
*/

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
include 'output.header.php'; // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff

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

/* Completely delete a table */
$sql = 'DROP TABLE users';
if (!mysqli_query($link, $sql))
{
	$output = 'Error dropping table: ' . mysqli_error($link);
	include 'output.part.php';
	exit();
}
else
{
	$output = 'Deleted table successfully.';
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
$userpass = 'crohnskitchen';
$username_conv = mysqli_real_escape_string($link, $username);
$useremail_conv = mysqli_real_escape_string($link, $useremail);
$userpass_conv = 'alkjdhfasdkjfh3424lkj15h1jh123kjh123jkh1239s8f';
// now to create the query
$sql = '
	INSERT INTO users SET
	user="' . $username_conv . '",
	email="' . $useremail_conv . '",
	pass="' . $userpass_conv . '",
	date_registered=CURDATE()
	';
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
/* Create ANOTHER row with information */
$username = 'thetestuser';
$useremail = 'freezurbern+help@gmail.com';
$userpass = 'kitchensink';
$username_conv = mysqli_real_escape_string($link, $username);
$useremail_conv = mysqli_real_escape_string($link, $useremail);
$userpass_conv = 'lkj2lk4j524hkg5jhb1jhwie99f724fjhfidudtw8eh2fkjh'; // add the password code here.
// now to create the query
$sql = '
	INSERT INTO users SET
	user="' . $username_conv . '",
	email="' . $useremail_conv . '",
	pass="' . $userpass_conv . '",
	date_registered=CURDATE()
	';
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

echo '</pre>'; // end prettified for now.

while ($row = mysqli_fetch_array($result))
{
	$userdata[] = array(
		'uid' => $row['uid'], 
		'user' => $row['user'], 
		'email' => $row['email'], 
		'pass' => $row['pass'], 
		'date_registered' => $row['date_registered']
		);
}

include 'user_table.html.php';

// this is the end of the examples, so we need to finish off the theme.
include 'output.footer.php';
?>