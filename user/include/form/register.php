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

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Google ReCAPTCHA
	if(isset($_POST['g-recaptcha-response'])){
	  $captcha=$_POST['g-recaptcha-response'];
	}
	if(!$captcha){
	  fail('reCAPTCHA error.');
	  exit();
	}
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".recaptcha_secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
	if($response.success==false)
	{
	  fail('reCAPTCHA marked as robot.');
	  exit();
	} else
	{
	  fail('reCAPTCHA is okay. Carrying on.');
	}
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


$db = new mysqli(db_host, db_user, db_pass, db_name);
if (mysqli_connect_errno())
{
	fail('Unable to connect to the database server.', '');
	exit();
}
else {
	$myCount += 1;
}

if (!mysqli_set_charset($db, 'utf8'))
{
	fail('Unable to set database connection encoding.', '');
	exit();
}
$myCount += 1;

if (!mysqli_select_db($db, 'ckdata'))
{
	fail('Unable to locate the database.', '');
	exit();
}
$myCount += 1;

fail('Server and database connection established.', '');

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
	fail('Username has invalid characters. ', $user);
	exit();
}

$pass = get_post_var('pass');
/* Don't let them spend more of our CPU time than we were willing to.
 * Besides, bcrypt happens to use the first 72 characters only anyway. */
if (strlen($pass) > 72)
{
	fail('Password too long. ', '');
	exit();
}

if (!preg_match('/^[a-zA-Z0-9_]{1,72}$/', $pass))
{
	fail('Password has invalid characters. ', '');
	exit();
}

$email = get_post_var('email');
/* Sanity-check the email, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!filter_var($email,FILTER_VALIDATE_EMAIL))
{
	fail('Invalid email. ', '');
	exit();
}

$hash = $hasher->HashPassword( filter_var($pass, FILTER_SANITIZE_STRING) );
if (strlen($hash) < 20)
{
	unset($hasher);
	fail('Failed to hash password. ', '');
	exit();
}

$username_conv = mysqli_real_escape_string($db, filter_var($user, FILTER_SANITIZE_STRING));
$useremail_conv = mysqli_real_escape_string($db, filter_var($email, FILTER_SANITIZE_STRING));
$userpass_conv = $hash;

($stmt = $db->prepare('INSERT INTO users (user, pass, email, date_registered) values (?, ?, ?, CURDATE())'))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('sss', $username_conv, $userpass_conv, $useremail_conv)
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
} else { 
	fail('User created successfully.');
	exit();
}

// end of code, finish off the theme.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
} // close checking if using POST
?>