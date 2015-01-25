<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>
<article id="pagecontent">

<?php if($ul) { ?>
	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Change Email</legend>
		<input type="text" name="user" value="<?php echo $un; ?>" hidden required><br>
		New email:
			<input type="email" name="email" size="20" placeholder="Email" required><br>
		Password:
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="hidden" name="op" value="changeemail">
		<input type="submit" value="Change email">
	</fieldset>
	</form>
<?php } else { ?>
	<h2>You're not logged in!</h2>
<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>