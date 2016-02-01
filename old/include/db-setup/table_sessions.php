<?php

require($_SERVER['DOCUMENT_ROOT'] . "/include/main.php"); // main functions, and references

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