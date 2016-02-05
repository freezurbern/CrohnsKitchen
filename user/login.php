<!DOCTYPE html>
<html lang="en">
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/head-nav.php");?>
<link href="/css/login.css" rel="stylesheet">
<body>

    <div class="container">
      <form class="form-signin">
        <h2 class="form-signin-heading">Please log in here</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/bootstrap-end.php");?>
</body>
</html>
