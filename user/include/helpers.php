<?php
/* Crohn's Kitchen user database functions
 * date: Jan 2015
 * author: freezurbern
 * 
*/
require '../../../protected/db_auth.php';
//db_host, db_user, db_pass, db_name;

// DEBUG MODE: If enabled, OK to leak server setup details.
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

// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}

?>