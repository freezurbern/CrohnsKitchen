<?php
/* Crohn's Kitchen User form handler
 * author: freezurbern
 * date: Jan 2015
*/
$myCount = 1;

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
	//exit("An error occurred ($msg).\n");
$output = $msg;
include($_SERVER['DOCUMENT_ROOT'] . "/template/output.part.php");
}


// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}
$operation = filter_var(get_post_var('op'), FILTER_SANITIZE_STRING);



switch ($operation)
{
	case "register":
		$myCount += 1;
		// register a new user
		require('form/register.php');
		exit();
	case "recover":
		// help user recover their account
		require('form/recover.php');
		exit();
	case "changepass":
		// change a user's password
		require('form/changepass.php');
		exit();
	case "changeemail":
		// change a user's email
		require('form/changeemail.php');
		exit();
	case "login":
		// login a user
		require('form/login.php');
		exit();
	case "logout":
		// logout a user
		require('form/logout.php');
		exit();
	default:
		echo "Error. Invalid form operation.";
		exit();
}