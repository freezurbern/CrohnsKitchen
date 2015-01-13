<?php
/* Crohn's Kitchen user registration code
 * author: freezurbern
 * date: Jan 2015
*/

if($_SERVER['REQUEST_METHOD'] == 'POST') {
// make sure we're using a form, first thing.

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/db_auth.php"); // grab the server connection details.
require 'PasswordHash.php'; // for creating the user passwords.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.header.php"); // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff



$link = mysqli_connect(db_host, db_user, db_pass, db_name);
if (!$link)
{
 $output = 'Unable to connect to the database server.';
 include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
 exit();
}
else {
	$myCount += 1;
}

if (!mysqli_set_charset($link, 'utf8'))
{
 $output = 'Unable to set database connection encoding.';
 include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
 exit();
}
$myCount += 1;

if (!mysqli_select_db($link, 'ckdata'))
{
 $output = 'Unable to locate the database.';
 include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
 exit();
}
$myCount += 1;

$output = 'Server and database connection established.' . $myCount;
include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@	End DB Setup	@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

// Base-2 logarithm of the iteration count used for password stretching
$hash_cost_log2 = 8;
// Do we require the hashes to be portable to older systems (less secure)?
$hash_portable = FALSE;
// create the object
$hasher = new PasswordHash($hash_cost_log2, $hash_portable);

/* Create a new row with information */
$user = get_post_var('user');
/* Sanity-check the username, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $user))
{
	$output = 'Username has invalid characters';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
}

$pass = get_post_var('pass');
/* Don't let them spend more of our CPU time than we were willing to.
 * Besides, bcrypt happens to use the first 72 characters only anyway. */
if (strlen($pass) > 72)
{
	$output = 'Password too long.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
}

if (!preg_match('/^[a-zA-Z0-9_]{1,72}$/', $pass))
{
	$output = 'Password has invalid characters.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
}

$email = get_post_var('email');
/* Sanity-check the email, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!filter_var($email,FILTER_VALIDATE_EMAIL))
	{
	echo "|".$email."|";
	$output = 'Invalid email.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
	}

$username = filter_var($user, FILTER_SANITIZE_STRING);
$userpass = filter_var($pass, FILTER_SANITIZE_STRING);
$useremail = filter_var($email, FILTER_SANITIZE_STRING);

$hash = $hasher->HashPassword($userpass);
if (strlen($hash) < 20)
{
	$output = 'Failed to hash password.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
	unset($hasher);
}

$username_conv = mysqli_real_escape_string($link, $username);
$useremail_conv = mysqli_real_escape_string($link, $useremail);
$userpass_conv = $hash;

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
	$output = 'Error adding submitted: ' . mysqli_error($link);
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
	unset($hasher);
	exit();
}
else
{
	$output = 'User created successfully.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
	unset($hasher);
}

// end of code, finish off the theme.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
} // close checking if using POST
?>