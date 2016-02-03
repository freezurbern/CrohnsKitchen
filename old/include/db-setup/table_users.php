<?php // FUNCTIONS

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
$sql = 'TRUNCATE TABLE users';
if (!mysqli_query($db, $sql))
{
	fail('Error truncating table: ', mysqli_error($db));
}
else
{
	fail('Truncated table successfully.');
}

/* Completely delete a table */
	$sql = 'DROP TABLE users';
	if (!mysqli_query($db, $sql))
	{
		fail('Error dropping table: ', mysqli_error($db));
	}
	else
	{
		fail('Deleted table successfully.');
	}

/* Create a table */
	$sql = 'CREATE TABLE IF NOT EXISTS users (
		uid int NOT NULL AUTO_INCREMENT,
		user varchar(60),
		email varchar(60),
		pass varchar(60),
		date_registered DATE,
		privilege int NOT NULL DEFAULT 0,
		unique (user),
		unique (email),
		primary key (uid)
		) DEFAULT CHARACTER SET utf8';
	if (!mysqli_query($db, $sql))
	{
		fail('Error creating users table: ', mysqli_error($db));
		exit();
	}
fail('\'users\' table successfully created.');

/* Create a new row with information */
	$username = 'hello';
	$useremail = 'freezurbern+no@gmail.com';
	$userpass = 'world';
	$username_conv = mysqli_real_escape_string($db, $username);
	$useremail_conv = mysqli_real_escape_string($db, $useremail);
	$userpass_conv = '$2a$08$ncxrsnmtALVkobpzFQ/Ja.Dd.8zdknQU3sb1ZwNRoxIqJvPAYTpUG';
// now to create the query
	$sql = '
		INSERT INTO users SET
		user="' . $username_conv . '",
		email="' . $useremail_conv . '",
		pass="' . $userpass_conv . '",
		date_registered=CURDATE()
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

// Test the user
/*
	$url = 'http://crohns.zachery.ninja/user/user-form.php';
	$data = array('user' => 'testme', 'pass' => 'crohnskitchen', 'op' => 'login');

	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	var_dump($result);
*/

require($_SERVER['DOCUMENT_ROOT'] . "/template/output/footer.php");
?>