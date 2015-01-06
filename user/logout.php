<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Are you sure you want to logout?</legend>
		<input type="hidden" name="op" value="logout">
		<input type="submit" value="Logout now">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>