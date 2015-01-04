<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">
	<h2>View data as charts here!</h2>
	<p>for now, this page is for testing front end design elements.</p>

	<table>
		<thead>
			<tr>
				<td>fid</td>
				<td>name</td>
				<td>group</td>
			</tr>
		</thead>
		<tbody>
			<tr><td>0</td><td>turkey</td><td>meats</td></tr>
			<tr><td>1</td><td>cheetos</td><td>snacks</td></tr>
			<tr><td>2</td><td>green beans</td><td>vegetables</td></tr>
			<tr><td>3</td><td>baked potato</td><td>vegetables</td></tr>
		</tbody>
	</table>
	<hr />
	<form action="/include/user-manage.php" method="POST" class="skinny">
	<fieldset>
	<legend>Form Title</legend>
		E-mail: 
			<input type="text" name="user" size="20" placeholder="E-mail" required><br>
		Username: 
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		Password: 
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="submit" value="Create user">
	</fieldset>
	</form>

	<div class="spacer"></div>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>