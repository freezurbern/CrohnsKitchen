<?php
/* Crohn's Kitchen ADMIN user listing
 * author: freezurbern
 * date: Jan 2015
*/
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

//fail('Server and database connection established.', '');
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
/* @@@@@	End DB Setup	@@@@@ */
/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

/* Get information out of the database, and show it in a template */
($stmt = $db->prepare('SELECT uid, user, pass, email, date_registered FROM users'))
	|| fail('MySQL prepare', $db->error);
$stmt->execute()
	|| fail('MySQL execute', $db->error);
$meta = $stmt->result_metadata();
while ($field = $meta->fetch_field()) {
  $parameters[] = &$row[$field->name];
}
call_user_func_array(array($stmt, 'bind_result'), $parameters);
while ($stmt->fetch()) {
  foreach($row as $key => $val) {
    $x[$key] = $val;
  }
  $results[] = $x;
}
if (!$stmt->fetch() && $db->errno)
	fail('MySQL fetch', $db->error);
	
//echo "<hr />";
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
				<!--<th>Pass</th>-->
				<th>Date Registered</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($results as $curUser): ?>
			<tr>
				<td><?php echo htmlspecialchars($curUser['uid'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['user'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['email'], ENT_QUOTES, 'UTF-8'); ?></td> 
				<!--<td><?php echo htmlspecialchars($curUser['pass'], ENT_QUOTES, 'UTF-8'); ?></td>-->
				<td><?php echo htmlspecialchars($curUser['date_registered'], ENT_QUOTES, 'UTF-8'); ?></td> 
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>