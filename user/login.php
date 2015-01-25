<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>
<article id="pagecontent">

<?php if(!$ul) { ?>
	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Login as existing</legend>
		Username:
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		Password:
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="hidden" name="op" value="login">
		<input type="submit" value="Login now">
	</fieldset>
	</form>
<?php } else { ?>
	<h2>You're already logged in!</h2>
<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>