<?php
/* Crohn's Kitchen user change email code
 * author: freezurbern
 * date: Jan 2015
*/

if(!$_SERVER['REQUEST_METHOD'] == 'POST') { exit(); } // make sure we're using a form, first thing

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
require($_SERVER['DOCUMENT_ROOT'] . "/include/PHPMailer/load.php"); // email functions
require 'PasswordHash.php'; // for creating the user passwords.
include($_SERVER['DOCUMENT_ROOT'] . "/template/output.header.php"); // get our output destination ready
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

/* Sanity-check the email, don't rely on our use of prepared statements
 * alone to prevent attacks on the SQL server via malicious usernames. */
if (!filter_var(get_post_var('email'),FILTER_VALIDATE_EMAIL))
{
	fail('Invalid email. ', '');
	exit();
} else {
$user_new_email = get_post_var('email');
}

$hash_cost_log2 = 8;
$hash_portable = FALSE;
$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
$hash = '*'; // In case the user is not found

$pass = filter_var(get_post_var('pass'), FILTER_SANITIZE_STRING);
$user = filter_var(get_post_var('user'), FILTER_SANITIZE_STRING);

($stmt = $db->prepare('SELECT pass, email FROM users WHERE user=?'))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('s', $user)
	|| fail('MySQL bind_param', $db->error);
$stmt->execute()
	|| fail('MySQL execute', $db->error);
$stmt->bind_result($hash, $user_old_email)
	|| fail('MySQL bind_result', $db->error);
if (!$stmt->fetch() && $db->errno)
	fail('MySQL fetch', $db->error);
if ($hasher->CheckPassword($pass, $hash)) {
	fail('Authentication succeeded.', '');
	//require($_SERVER['DOCUMENT_ROOT'] . "user/include/session-handler.php");
	//grant_session($user_uid, $myuser);
	//$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	//echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$root.'">';
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
	
	($stmt = $db->prepare('UPDATE users SET email=? WHERE user=?'))
			|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', $user_new_email, $user)
			|| fail('MySQL bind_param', $db->error);
		$stmt->execute()
			|| fail('MySQL execute', $db->error);
		if ($stmt->errno)
			echo "FAIL. " . $stmt->error;
		if (!$stmt->fetch() && $db->errno)
			fail('MySQL fetch', $db->error);
	fail('UPDATE done.');
	fail('users affected: ', $stmt->affected_rows);
	
	// send mail to new address, showing email was changed
	// send_user_mail($ADDRESS, $SUBJECT, $MESSAGE);
	send_user_mail($user_new_email, 'Email changed at Crohns Kitchen', $user . '\'s account email has been changed to this address.');
	// done with sending email code.
	
} else {
	$output .= $user.'|'.$pass.'|'.$user_new_email;
	fail('Authentication failed.', $output);
	$op = 'fail'; // Definitely not 'login'!
}

// end of code, finish off the theme.
if($allow_output) {
	include($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
}
?>