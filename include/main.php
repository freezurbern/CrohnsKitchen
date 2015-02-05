<?php 

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// common functions
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
require($_SERVER['DOCUMENT_ROOT'] . "/template/output/part.php");
}

// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
require($_SERVER['DOCUMENT_ROOT'] . "/include/PasswordHash.php"); // for creating the user passwords.
require($_SERVER['DOCUMENT_ROOT'] . "/include/PHPMailer/load.php"); // email functions
require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php"); // user login

?>