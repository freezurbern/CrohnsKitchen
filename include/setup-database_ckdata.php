<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

<p>To create a database for Crohn's Kitchen, please login with your MySQL Administrator details.</p><br>
<form action="setup-db-proc.php" method="POST" class="skinny">
	<fieldset>
	<legend>Credentials</legend>
		MySQL User:
			<input type="text" name="user" size="20" placeholder="" required><br>
		MySQL Pass:
			<input type="password" name="pass" size="20" placeholder="" required><br>
		MySQL Host:
			<input type="text" name="host" size="20" placeholder="" required><br>
		<input type="hidden" name="op" value="database">
		<input type="submit" value="Create Database">
	</fieldset>
</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>

