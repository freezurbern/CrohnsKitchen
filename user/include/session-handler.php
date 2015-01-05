<?php
/* Crohn's Kitchen User Sessions
 * functions and how-to
 * date: Jan 2015
 * author: freezurbern
*/

require 'helpers.php';

// generate an sid
function gen_sid()
{
	$length = '64';
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $length; $i++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}
	return $string;
}
// echo gen_sid(); // test sid generation

// create the cookie and add to database
function user_persist_create($user)
{
	$stored_sid = gen_sid();
	$cookie_value = $user . '|' . $stored_sid;
	
	// connect to the database.
	$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		fail('MySQL connect', mysqli_connect_error());
	
	($stmt = $db->prepare('insert into sessions (sid, user) values (?, ?)'))
	|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('ss', $stored_sid, $user)
	|| fail('MySQL bind_param', $db->error);
	if (!$stmt->execute()) {
	/* Figure out why this failed - maybe the username is already taken?
	 * It could be more reliable/portable to issue a SELECT query here.  We would
	 * definitely need to do that (or at least include code to do it) if we were
	 * supporting multiple kinds of database backends, not just MySQL.  However,
	 * the prepared statements interface we're using is MySQL-specific anyway. */
	if ($db->errno === 1062 /* ER_DUP_ENTRY */)
		echo 'collision detected';
		else
			echo $db->error;
	} else {
	setcookie("user", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day, so use 30 days.
	echo "<br><i><br>&nbsp;" . $stored_sid . "<br></i><b>has been added to the database.</b>";
	}
	
}
user_persist_create('skiingpenguins'); // test creation

// get rid of the cookie, and remove from database
function user_persist_remove()
{
// first get the user and sid from the cookie
	if(!isset($_COOKIE["user"])) {
		echo "DESTROY no cookie set";
	} else {
		$attempt = $_COOKIE["user"];
		echo "DESTROY cookie read: " . $attempt;
		$input = explode("|", $attempt);
		$cookie_user = $input[0];
			if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $cookie_user))
				echo 'DESTROY: Malformed cookie user<br>';
		$cookie_sid = $input[1];
			if (!preg_match('/^[a-zA-Z0-9_]{1,254}$/', $cookie_sid))
				echo 'DESTROY: Malformed cookie sid<br>';
	}
// remove the cookie
	setcookie("user", "", time() - 3600);
	
// connect to the database.
	$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		fail('MySQL connect', mysqli_connect_error());

// remove the sid and user pair from database, using cookie data
	($stmt = $db->prepare('delete * from sessions where sid=? and user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('ss', $cookie_sid, $cookie_user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($sid_found)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);
}


// read the database to check for valid sid, then remove it.
function user_persist_verify()
{
	if(!isset($_COOKIE["user"])) {
		echo "VERIFY no cookie set";
	} else {
		$attempt = $_COOKIE["user"];
		echo "VERIFY cookie read: " . $attempt;
	}
	
	$input = explode("|", $attempt);
		$cookie_user = $input[0];
			if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $cookie_user))
				echo 'VERIFY: Malformed cookie user<br>';
		$cookie_sid = $input[1];
			if (!preg_match('/^[a-zA-Z0-9_]{1,254}$/', $cookie_sid))
				echo 'VERIFY: Malformed cookie sid<br>';
	
	// connect to the database.
	$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		fail('MySQL connect', mysqli_connect_error());
	
	($stmt = $db->prepare('select sid from sessions where user=?'))
		|| fail('MySQL prepare', $db->error);
	$stmt->bind_param('s', $cookie_user)
		|| fail('MySQL bind_param', $db->error);
	$stmt->execute()
		|| fail('MySQL execute', $db->error);
	$stmt->bind_result($sid_found)
		|| fail('MySQL bind_result', $db->error);
	if (!$stmt->fetch() && $db->errno)
		fail('MySQL fetch', $db->error);

	if (strpos($cookie_sid, $sid_found) !== false) {
		echo "<h2>Authenticated successfully.</h2>";
		echo "Data: ".$cookie_user .'|'. $cookie_sid .'|'. $sid_found;
	} else {
		echo "<hr><h2>Authentication failed.</h2><br>".$cookie_user .'|'. $cookie_sid .'|'. $sid_found;
		$op = 'fail'; // Definitely not 'change'
	}
}

echo "<hr />";
user_persist_verify();

// remove all sid's for a specific user
function user_removeall($user)
{

}


?>