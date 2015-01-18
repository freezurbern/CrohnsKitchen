<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>
<article id="pagecontent">

<?php if(!$ul) { ?>
	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Can not login, but</legend>
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
		<br>
		<input type="text" name="know_text" size="20" placeholder="Write it here" required class="fullwide" ><br>
		<div class="g-recaptcha" data-sitekey="6LdcaQATAAAAAH6NCoVL4sLAmRlgzuhAHt_ikJG4"></div><br>
		<input type="hidden" name="op" value="recover">
		<input type="submit" value="Next..">
	</fieldset>
	</form>
<?php } else { ?>
	<h2>You're already logged in!</h2>
<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>