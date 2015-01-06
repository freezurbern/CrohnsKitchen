<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Change Email</legend>
		New email: 
			<input type="email" name="email" size="24" placeholder="Email" required><br>
		Password: 
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="hidden" name="op" value="change">
		<input type="submit" value="Change password">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>