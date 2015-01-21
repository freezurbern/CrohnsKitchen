<?php // FUNCTIONS

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.header.php"); // get our output destination ready
?>

<p>To create a database for Crohn's Kitchen, please login with your MySQL Administrator details.</p><br>
<form action="setup-database_ckdata.php" method="POST" class="skinny">
	<fieldset>
	<legend>Credentials</legend>
		MySQL User:
			<input type="text" name="user" size="20" placeholder="" required><br>
		MySQL Pass:
			<input type="password" name="pass" size="20" placeholder="" required><br>
		MySQL Host:
			<input type="text" name="host" size="20" placeholder="" required><br>
		<input type="hidden" name="op" value="database">
		<input type="submit" value="Create Database">
	</fieldset>
</form>

<?php
function create_now() {
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
($stmt = $db->prepare("GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES ON ckdata.* TO \'?\'@\'localhost\' IDENTIFIED BY \'?\'"))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('ss', db_user, db_pass)
	|| fail('MySQL bind_param', $db->error);
if (!$stmt->execute()) {
/* Figure out why this failed - maybe the username is already taken?
 * It could be more reliable/portable to issue a SELECT query here.  We would
 * definitely need to do that (or at least include code to do it) if we were
 * supporting multiple kinds of database backends, not just MySQL.  However,
 * the prepared statements interface we're using is MySQL-specific anyway. */
	fail('MySQL execute', $db->error);
} else { fail('User created successfully.');}

fail('Done.');
require($_SERVER['DOCUMENT_ROOT'] . "/template/output.footer.php");
}

if( isset($_POST['submit']) && $_POST['op'] == "database") { create_now(); } else { echo "Please submit the form."; }
?>