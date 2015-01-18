<?php
/* Crohn's Kitchen ADMIN user listing
 * author: freezurbern
 * date: Jan 2015
*/
echo "hello.";
require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");
	if ($ul && $us) {} else { echo "not logged in." ; exit(); }
require($_SERVER['DOCUMENT_ROOT'] . "/../protected/db_auth.php"); // grab the server connection details.

/* Start DB connection */
$db = new mysqli(db_host, db_user, db_pass, db_name);
if (mysqli_connect_errno())
{
	fail('Unable to connect to the database server.', '');
	exit();
}
else {

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

/* Get information out of the database, and show it in a template */
($stmt = $db->prepare('SELECT * FROM users'))
	|| fail('MySQL prepare', $db->error);
$stmt->execute()
	|| fail('MySQL execute', $db->error);
$stmt->bind_result($idarr, $userarr, $passarr, $emailarr)
	|| fail('MySQL bind_result', $db->error);
if (!$stmt->fetch() && $db->errno)
	fail('MySQL fetch', $db->error);

if (!$result)
{
	fail('Failed.', $result);
	exit();
}
echo '</pre>'; // end prettified for now.
while ($row = mysqli_fetch_array($result))
{
	$userdata[] = array(
		'uid' => $row['uid'], 
		'user' => $row['user'], 
		'email' => $row['email'], 
		'pass' => $row['pass'], 
		'date_registered' => $row['date_registered']
		);
}




?>

<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">
	<h2>View all users here.</h2>
	<table>
		<thead>
			<tr>
				<th>Uid</th>
				<th>User</th>
				<th>Email</th>
				<th>Pass</th>
				<th>Date Registered</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($userdata as $curUser): ?>
			<tr>
				<td><?php echo htmlspecialchars($curUser['uid'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['user'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['email'], ENT_QUOTES, 'UTF-8'); ?></td> 
				<td><?php echo htmlspecialchars($curUser['pass'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['date_registered'], ENT_QUOTES, 'UTF-8'); ?></td> 
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>