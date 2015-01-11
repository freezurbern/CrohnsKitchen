<?php
/* Crohn's Kitchen user registration code
 * author: freezurbern
 * date: Jan 2015
*/

require '../../../../protected/db_auth.php'; // grab the server connection details.
require 'PasswordHash.php'; // for creating the user passwords.
include '../output.header.php'; // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff

$link = mysqli_connect(db_host, db_user, db_pass, db_name);
if (!$link)
{
 $output = 'Unable to connect to the database server.';
 include '../output.part.php';
 exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
 $output = 'Unable to set database connection encoding.';
 include '../output.part.php';
 exit();
}

if (!mysqli_select_db($link, 'ckdata'))
{
 $output = 'Unable to locate the database.';
 include '../output.part.php';
 exit();
}

$output = 'Server and database connection established.';
include '../output.part.php';
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
$username = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
$userpass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
$useremail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

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
	$output = 'Error adding submitted: ' . mysqli_error($link);
	include '../output.part.php';
	exit();
}
else
{
	$output = 'User created successfully.';
	include '../output.part.php';
}
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


$user = get_post_var('user');
/* Sanity-check the username, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $user))
	fail('Invalid username');

$pass = get_post_var('pass');
/* Don't let them spend more of our CPU time than we were willing to.
 * Besides, bcrypt happens to use the first 72 characters only anyway. */
if (strlen($pass) > 72)
	fail('The supplied password is too long');

$hash = $hasher->HashPassword($pass);
if (strlen($hash) < 20)
{
	fail('Failed to hash new password');
	unset($hasher);
}

$email = get_post_var('email');
/* Sanity-check the email, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!filter_var($email,FILTER_VALIDATE_EMAIL))
	{
	echo "|".$email."|";
	fail('Invalid email');
	}

($stmt = $db->prepare('insert into users (user, pass, email) values (?, ?, ?)'))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('sss', $user, $hash, $email)
	|| fail('MySQL bind_param', $db->error);
if (!$stmt->execute()) {
/* Figure out why this failed - maybe the username is already taken?
 * It could be more reliable/portable to issue a SELECT query here.  We would
 * definitely need to do that (or at least include code to do it) if we were
 * supporting multiple kinds of database backends, not just MySQL.  However,
 * the prepared statements interface we're using is MySQL-specific anyway. */
		if ($db->errno === 1062 /* ER_DUP_ENTRY */)
			fail('This username is already taken');
		else
			fail('MySQL execute', $db->error);
	}

	$what = 'User created';
} else {
	$hash = '*'; // In case the user is not found
	($stmt = $db->prepare('select pass from users where user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($hash)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);

	if ($hasher->CheckPassword($pass, $hash)) {
		$what = 'Authentication succeeded';
	} else {
		$what = 'Authentication failed';
		echo $user.'|'.$pass.'|'.$hash.'|'.$email;
		$op = 'fail'; // Definitely not 'change'
	}

	if ($op === 'change') {
		$stmt->close();

		$newpass = get_post_var('newpass');
		if (strlen($newpass) > 72)
			fail('The new password is too long');
		$hash = $hasher->HashPassword($newpass);
		if (strlen($hash) < 20)
			fail('Failed to hash new password');
		unset($hasher);

		($stmt = $db->prepare('update users set pass=? where user=?'))
			|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $hash, $user)
			|| fail('MySQL bind_param', $db->error);
		$stmt->execute()
			|| fail('MySQL execute', $db->error);

		$what = 'Password changed';
	}

	unset($hasher);
}


// end of code, finish off the theme.
include 'output.footer.php';
?>