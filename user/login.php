<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<link href="/css/login.css" rel="stylesheet">
<article>
    <div class="container">

      <form class="form-signin" action="/php/form-handler.php" method="post" >
        <h2 class="form-signin-heading">Log in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember Email
          </label>
        </div>
        <input type="hidden" name="type" value="login">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>