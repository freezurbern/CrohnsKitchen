<!DOCTYPE html>
<html lang="en">
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/head-nav.php");?>
<script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
<link href="/css/login.css" rel="stylesheet">
<body>
<?php if(!$userloggedin) { ?>
<div class="container">
  <form class="form-signin" action="/include/createuser.php" method="POST">
	<h2 class="form-signin-heading">Create an account</h2>
	<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
	<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
	<div class="g-recaptcha" data-sitekey="6LcQQRcTAAAAAJXzo-XX1CvZct5rUgJidycO5Bw-"></div>
	<br>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Register account</button>
  </form>
<?php } else { ?>
	<h2>You're already logged in!</h2>
<?php } ?>
</div> <!-- /container -->

<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/bootstrap-end.php");?>
</body>
</html>
