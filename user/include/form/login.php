<?php
/* Crohn's Kitchen user login code
 * author: freezurbern
 * date: Jan 2015
*/

if(!$_SERVER['REQUEST_METHOD'] == 'POST') { exit(); } // make sure we're using a form, first thing.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output/header.php"); // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff

$db = new mysqli(db_host, db_user, db_pass, db_name);
if (mysqli_connect_errno())
{
	fail('Unable to connect to the database server.', '');
	exit();
}

if (!mysqli_set_charset($db, 'utf8'))
{
	fail('Unable to set database connection encoding.', '');
	exit();
}

if (!mysqli_select_db($db, 'ckdata'))
{
	fail('Unable to locate the database.', '');
	exit();
}

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
$hash = '*'; // In case the user is not found

$pass = filter_var(get_post_var('pass'), FILTER_SANITIZE_STRING);
$user = filter_var(get_post_var('user'), FILTER_SANITIZE_STRING);
$myuser = $user;

($stmt = $db->prepare('SELECT uid, pass FROM users WHERE user=?'))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('s', $user)
	|| fail('MySQL bind_param', $db->error);
$stmt->execute()
	|| fail('MySQL execute', $db->error);
$stmt->bind_result($user_uid, $hash)
	|| fail('MySQL bind_result', $db->error);
if (!$stmt->fetch() && $db->errno)
	fail('MySQL fetch', $db->error);
if ($hasher->CheckPassword($pass, $hash)) {
	fail('Authentication succeeded.', '');
	require($_SERVER['DOCUMENT_ROOT'] . "/user/include/session-handler.php");
	grant_session($user_uid, $myuser);
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$root.'">';
} else {
	$output .= $user.'|'.$pass.'|'.$email;
	fail('Authentication failed.', $output);
	$op = 'fail'; // Definitely not 'login'
}
?>