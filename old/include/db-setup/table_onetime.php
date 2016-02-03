<?php
/* Create the onetime table */

include($_SERVER['DOCUMENT_ROOT'] . "/template/output/header.php"); // get our output destination ready
echo '<pre>'; // prettify my output.part.php stuff

// construct a table for all the sessions
function create_onetime_table()
{
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

// sql to remove the table
	$sql = "drop table onetime;";
	if ($db->query($sql) === TRUE) {
		echo "Table removed successfully<br>";
	} else {
		echo "Error removing table: " . $db->error;
	}

// sql to create table
	$sql = "CREATE TABLE onetime (
	oid INT NOT NULL AUTO_INCREMENT,
	uid INT NOT NULL, 
	onekey VARCHAR(60) NOT NULL, 
	purpose VARCHAR(20) NOT NULL DEFAULT 'register',
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	UNIQUE (onekey), 
	UNIQUE (uid), 
	PRIMARY KEY (oid),
	FOREIGN KEY (uid) REFERENCES users(uid)
	)";

	if ($db->query($sql) === TRUE) {
		echo "Table created successfully<br>";
	} else {
		echo "Error creating table: " . $db->error;
	}
	
// sql to add a one-time link.
	$sql = "INSERT INTO onetime (
				uid, onekey) VALUES ('1', 'kasjdfhklajsdfhlkajsfhdlkajsdhflaksjdhlaksjdhfasdfkljhakslj');";
	if ($db->query($sql) === TRUE) {
		echo "<i>1/kasjdfhklajsdfhlkajsfhdlkajsdhflaksjdhlaksjdhfasdfkljhakslj</i> one-time added successfully<br>";
	} else {
		echo "Error adding data to table: " . $db->error;
	}
}

create_onetime_table();

?>