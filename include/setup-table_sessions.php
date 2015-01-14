<?php

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

require($_SERVER['DOCUMENT_ROOT'] . "/../protected/db_auth.php"); // grab the server connection details.

// construct a table for all the sessions
function create_session_table()
{
// connect to the database.
	$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		fail('MySQL connect', mysqli_connect_error());

// sql to remove the table
	$sql = "drop table sessions;";
	if ($db->query($sql) === TRUE) {
		echo "Table removed successfully<br>";
	} else {
		echo "Error removing table: " . $db->error;
		echo "<br>";
	}

// sql to create table
	$sql = "CREATE TABLE sessions (
	sid varchar(255) NOT NULL,
	user varchar(60), 
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	primary key (sid)
	)";

	if ($db->query($sql) === TRUE) {
		echo "Table created successfully<br>";
	} else {
		echo "Error creating table: " . $db->error;
		echo "<br>";
	}
}

create_session_table();

?>