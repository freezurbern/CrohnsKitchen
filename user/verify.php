<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">
<h2>Verifying your account...</h2>

<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.
echo '<pre>'; // prettify my output.part.php stuff

$db = new mysqli(db_host, db_user, db_pass, db_name);
if (mysqli_connect_errno())
	{fail('Unable to connect to the database server.', ''); exit();}
if (!mysqli_set_charset($db, 'utf8'))
	{fail('Unable to set database connection encoding.', ''); exit();}
if (!mysqli_select_db($db, 'ckdata'))
	{fail('Unable to locate the database.', ''); exit();}
fail('Server and database connection established.', '');
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@	End DB Setup	@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

$username   = htmlspecialchars($_GET["un"]);
$onetimekey = htmlspecialchars($_GET["ot"]);

($stmt = $db->prepare('SELECT onetime.purpose, onetime.uid, users.user, users.privilege FROM onetime INNER JOIN users ON onetime.uid = users.uid WHERE onekey=?'))
	|| fail('MySQL prepare', $db->error);
$stmt->bind_param('s', $onetimekey)
	|| fail('MySQL bind_param', $db->error);
$stmt->execute()
	|| fail('MySQL execute', $db->error);
$stmt->bind_result($ot_purpose, $ot_uid, $ot_user, $ot_privilege)
	|| fail('MySQL bind_result', $db->error);
if (!$stmt->fetch() && $db->errno)
	fail('MySQL fetch', $db->error);

echo mysqli_stmt_num_rows($stmt);
fail('purpose:'.$ot_purpose.'|'.' user: '.$ot_user);
if($ot_purpose == 'register' && $ot_user == $username && $ot_privilege == 0) {
	$ot_valid == TRUE;
	
	//$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	//echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$root.'">';
}


if ($ot_valid) {
	$db = new mysqli(db_host, db_user, db_pass, db_name);
	if (mysqli_connect_errno())
		{fail('Unable to connect to the database server.', ''); exit();}
	if (!mysqli_set_charset($db, 'utf8'))
		{fail('Unable to set database connection encoding.', ''); exit();}
	if (!mysqli_select_db($db, 'ckdata'))
		{fail('Unable to locate the database.', ''); exit();}
	fail('Server and database connection established.', '');
	
	($stmt = $db->prepare('UPDATE users SET privilege=? WHERE uid=?'))
			|| fail('MySQL prepare', $db->error);
		$stmt->bind_param('ss', 1, $ot_uid)
			|| fail('MySQL bind_param', $db->error);
		$stmt->execute()
			|| fail('MySQL execute', $db->error);
		if ($stmt->errno)
			echo "FAIL. " . $stmt->error;
		if (!$stmt->fetch() && $db->errno)
			fail('MySQL fetch', $db->error);
	fail('UPDATE done.');
	fail('users affected: ', $stmt->affected_rows);
}

?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>