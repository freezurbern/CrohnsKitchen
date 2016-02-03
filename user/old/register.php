<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>
<article id="pagecontent">
<script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
<?php if(!$ul) { ?>
<form action="include/form-handler.php" method="POST" class="skinny" style="width: 30%;">
	<fieldset>
	<legend>Create a new user</legend>
		E-mail:
			<input type="text" name="email" size="20" placeholder="E-mail" required><br>
		Username:
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		Password:
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<div class="g-recaptcha" data-sitekey="6LdcaQATAAAAAH6NCoVL4sLAmRlgzuhAHt_ikJG4"></div><br>
		<input type="hidden" name="op" value="register">
		<input type="submit" value="Create user">
		
	</fieldset>
</form>
<?php } else { ?>
	<h2>You're already logged in!</h2>
<?php } ?>
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>