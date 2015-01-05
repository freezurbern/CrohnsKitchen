<?php // FUNCTIONS

require 'helpers.php';

// Are we debugging this code?  If enabled, OK to leak server setup details.
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
?>

<?php // connect to the database.
$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		fail('MySQL connect', mysqli_connect_error());
?>

<?php // Code to remove an existing users table, then create it correctly.
	

	// sql to remove the table
	$sql = "drop table users;";
	if ($db->query($sql) === TRUE) {
		echo "Table removed successfully<br>";
	} else {
		echo "Error removing table: " . $db->error;
		echo "<br>";
	}

	// sql to create table
	$sql = "CREATE TABLE users (
	uid int NOT NULL AUTO_INCREMENT,
	user varchar(60), 
	pass varchar(60), 
	email varchar(60), 
	unique (user), 
	unique (email),
	primary key (uid)
	)";

	if ($db->query($sql) === TRUE) {
		echo "Table created successfully<br>";
	} else {
		echo "Error creating table: " . $db->error;
		echo "<br>";
	}

?>

<?php // Code to insert a test user

	// sql to remove the table
	$sql = "INSERT INTO users (
				user, pass, email) VALUES (
					'testme', 
					'$2a$08$UWZa0A429pDpEfxDMepaUeaewXKH1rXwLIKNp8WS.bjOWa00EyTvC', 
					'freezurbern+cktest@gmail.com'
			);";
	if ($db->query($sql) === TRUE) {
		echo "<i>testme/hello</i> user added successfully<br>";
	} else {
		echo "Error adding user to table: " . $db->error;
		echo "<br>";
	}

?>

<?php // Test the user

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
?>

<?php $db->close(); // CLOSE IT ALL DOWN! ?>