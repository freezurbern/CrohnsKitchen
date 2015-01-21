<?php
/*
 * This file goes in ../protected/
*/

define("db_host",".");
define("db_user",".");
define("db_pass",".");
define("db_name",".");

// https://www.google.com/recaptcha
define("recaptcha_secret","...");

// common functions
$debug = TRUE;
$allow_output = TRUE;
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


?>