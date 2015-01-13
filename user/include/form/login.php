<?php
/* Crohn's Kitchen user registration code
 * author: freezurbern
 * date: Jan 2015
*/

$debug = TRUE;
function fail($pub, $pvt = '')
{
	global $debug;
	$msg = $pub;
	if ($debug && $pvt !== '')
		$msg .= ": $pvt";
/* The $pvt debugging messages may contain characters that would need to be
 * quoted if we were producing HTML output, like we would be in a real app,
 * but we're using text/plain here.  Also, $debug is meant to be disabled on
 * a "production install" to avoid leaking server setup details. */
	exit("An error occurred ($msg).\n");
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
// make sure we're using a form, first thing.

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/db_auth.php"); // grab the server connection details.
require 'PasswordHash.php'; // for creating the user passwords.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.header.php"); // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff

$db = new mysqli(db_host, db_user, db_pass, db_name);
if (mysqli_connect_errno())
{
 $output = 'Unable to connect to the database server.';
 include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
 exit();
}
else {
	$myCount += 1;
}

if (!mysqli_set_charset($db, 'utf8'))
{
 $output = 'Unable to set database connection encoding.';
 include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
 exit();
}
$myCount += 1;

if (!mysqli_select_db($db, 'ckdata'))
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
$hash = '*'; // In case the user is not found

$pass = filter_var(get_post_var('pass'), FILTER_SANITIZE_STRING);
$user = filter_var(get_post_var('user'), FILTER_SANITIZE_STRING);

($stmt = $db->prepare('SELECT pass FROM users WHERE user=?'))
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
	$output = 'Authentication succeeded.';
	$output .= $hash;
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
} else {
	$output = 'Authentication failed.';
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
	$output .= $user.'|'.$pass.'|'.$hash.'|'.$email;
	$op = 'fail'; // Definitely not 'change'
}

// end of code, finish off the theme.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
} // close checking if using POST
?>