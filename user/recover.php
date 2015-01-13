<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Lost your account?</legend>
		I know my...<br>
          <input type = "radio"
                 name = "know_info"
                 id = "know_username"
                 value = "user"
                 checked = "checked" />
          <label for="know_username">Username</label><br>

          <input type = "radio"
                 name = "know_info"
                 id = "know_email"
                 value = "email" />
          <label for="know_email">Email</label><br>

          <input type = "radio"
                 name = "know_info"
                 id = "know_neither"
                 value = "neither" />
          <label for="know_neither">Neither</label><br>

			<input type="text" name="know_text" size="20" placeholder="Known Information" required><br>
		<input type="hidden" name="op" value="recover">
		<input type="submit" value="Change password">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>