<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
<link href="/css/login.css" rel="stylesheet">
<article>

<?php if(!isset($_SESSION['uid'])) { ?>
<div class="container">
  <form class="form-signin" action="/php/form-handler.php" method="POST">
	<h2 class="form-signin-heading">Create an account</h2>
      <?php if (isset($_GET['error'])) { if ($_GET['error'] == 'dupemail') { ?>
          <div class="alert alert-warning"><strong>Failure.</strong> Email already registered.</div>
      <?php } elseif ($_GET['error'] == 'captcha') { ?>
          <div class="alert alert-warning"><strong>Failure.</strong> reCAPTCHA error.</div>
      <?php } } ?>
	<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>

	<label for="password" class="sr-only">Password</label>
		<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

    <label for="confirmpassword" class="sr-only">Confirm Password</label>
        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm password" required>

	<div class="g-recaptcha" data-sitekey="6LcQQRcTAAAAAJXzo-XX1CvZct5rUgJidycO5Bw-"></div>
	<br>
    <input type="hidden" name="type" value="register">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Register account</button>
  </form>
<?php } else { ?>
	<div class="container">
		<form class="form-signin" action="" method="POST">
            <h2 class="form-signin-heading">Create an account</h2>
            <div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>
            <a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your profile</a>
		</form>
<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>
<script>
    $(document).ready(function(){
        $("button[type=submit]").attr('disabled','disabled');
        $('#confirmpassword, #password').keyup(function(){
            if ($('#password').val() == $('#confirmpassword').val()) {
                    $("button[type=submit]").removeAttr('disabled');
                    $("button[type=submit]").html('Register Account');
            }
            else {
                $("button[type=submit]").attr('disabled','disabled');
                $("button[type=submit]").html('Password mismatch');
            }
        });
    });
</script>