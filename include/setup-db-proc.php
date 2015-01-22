<?php
/*
 * Create the database and the database user.
 * Must use MySQL admin account to create these, so ask for it them pass onto this file through a form.
 * 
*/

// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
	$val = $_POST[$var];
	if (get_magic_quotes_gpc())
		$val = stripslashes($val);
	return $val;
}
require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.header.php");

//if ($_POST['op'] == "database") {echo "form operation not found."; exit();} 

$admin_user = get_post_var('user');
$admin_pass = get_post_var('pass');
$admin_host = get_post_var('host');

echo '<pre>'; // prettify my output.part.php stuff

$db = new mysqli($admin_host, $admin_user, $admin_pass);
	if (mysqli_connect_errno()) 			{fail('Unable to connect to the database server.', ''); exit();}
	if (!mysqli_set_charset($db, 'utf8'))	{fail('Unable to set database connection encoding.', ''); exit();}
	//if (!mysqli_select_db($db, 'ckdata'))	{fail('Unable to locate the database.', ''); exit();}
fail('Server and database connection established.', '');
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@	End DB Setup	@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

/* Create the database */
	$sql = 'CREATE DATABASE IF NOT EXISTS ckdata CHARACTER SET utf8 COLLATE utf8_general_ci';
	if (!mysqli_query($db, $sql))
	{
		fail('Error creating database: ', mysqli_error($db));
		exit();
	}
/* Create the user for later use */
$db = new mysqli($admin_host, $admin_user, $admin_pass);
	if (mysqli_connect_errno()) 			{fail('Unable to connect to the database server.', ''); exit();}
	if (!mysqli_set_charset($db, 'utf8'))	{fail('Unable to set database connection encoding.', ''); exit();}
	if (!mysqli_select_db($db, 'ckdata'))	{fail('Unable to locate the database.', ''); exit();}
fail('Server and database connection established.', '');
$sql = "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, 
	DROP, INDEX, ALTER, CREATE TEMPORARY TABLES 
	ON ckdata.* TO '".db_user."' IDENTIFIED BY '".db_pass."'";
($stmt = $db->prepare($sql))
	|| fail('MySQL prepare', $db->error);
if (!$stmt->execute()) {
/* Figure out why this failed - maybe the username is already taken?
 * It could be more reliable/portable to issue a SELECT query here.  We would
 * definitely need to do that (or at least include code to do it) if we were
 * supporting multiple kinds of database backends, not just MySQL.  However,
 * the prepared statements interface we're using is MySQL-specific anyway. */
	fail('MySQL execute', $db->error);
} else { fail('User created successfully.');}

fail('Done.');
echo "</pre>";
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
?>
