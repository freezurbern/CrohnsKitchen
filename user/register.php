<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
<link href="/css/login.css" rel="stylesheet">
<article>

<?php if(!$_SESSION['uid']) { ?>
<div class="container">
  <form class="form-signin" action="/sql/formhandler.php" method="POST">
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
	<div class="container">
		<form class="form-signin" action="" method="POST">
            <h2 class="form-signin-heading">Create an account</h2>
            <div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>
            <a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your profile</a>
		</form>
	<div class="container">
<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>

