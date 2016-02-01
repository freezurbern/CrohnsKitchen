<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>
<article id="pagecontent">
	<?php if($ul) { ?>
		<form action="include/form-handler.php" method="POST" class="skinny">
		<fieldset>
		<legend>Are you sure?</legend>
			Clicking the button will force you to login again to access your account.
			<input type="hidden" name="op" value="logout">
			<input type="submit" value="Logout now">
		</fieldset>
		</form>
	<?php } else { ?>
		<h2>You're not logged in!</h2>
	<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>