<?php // FUNCTIONS

require($_SERVER['DOCUMENT_ROOT'] . "/include/main.php"); // main functions, and references
require($_SERVER['DOCUMENT_ROOT'] . "/template/output/header.php"); // get our output destination ready
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

/* Remove a table's contents */
$sql = 'TRUNCATE TABLE foods';
if (!mysqli_query($db, $sql))
{
	fail('Error truncating table: ', mysqli_error($db));
	exit();
}
else
{
	fail('Truncated table successfully.');
}

/* Completely delete a table */
	$sql = 'DROP TABLE foods';
	if (!mysqli_query($db, $sql))
	{
		fail('Error dropping table: ', mysqli_error($db));
		exit();
	}
	else
	{
		fail('Deleted table successfully.');
	}

/* Create a table */
	$sql = 'CREATE TABLE IF NOT EXISTS foods (
		fid int NOT NULL AUTO_INCREMENT,
		name varchar(255),
		group varchar(60),
		added_by int NOT NULL DEFAULT 0,
		date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		unique (name),
		primary key (fid),
		FOREIGN KEY (added_by) REFERENCES users(uid)
		) DEFAULT CHARACTER SET utf8';
	if (!mysqli_query($db, $sql))
	{
		fail('Error creating foods table: ', mysqli_error($db));
		exit();
	}
fail('\'foods\' table successfully created.');


// now to create the query
	$sql = '
		INSERT INTO foods SET
		name="Milk",
		group="Dairy",
		added_by=0
		';
	if (!mysqli_query($db, $sql))
	{
		fail('Error adding submitted row: ', mysqli_error($db));
		exit();
	}
	else
	{
		fail('Row inserted successfully.');
	}

require($_SERVER['DOCUMENT_ROOT'] . "/template/output/footer.php");
?>