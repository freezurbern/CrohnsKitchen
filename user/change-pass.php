<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Change password</legend>
		Old Password:
			<input type="password" name="pass" size="20" placeholder="Old" required><br>
		New Password:
			<input type="password" name="newpass" size="20" placeholder="New" required><br>
		<input type="hidden" name="op" value="changepass">
		<input type="submit" value="Submit change">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>