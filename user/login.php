<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<link href="/css/login.css" rel="stylesheet">
<article>
    <div class="container">

      <form class="form-signin" action="/php/form-handler.php" method="post" >
        <h2 class="form-signin-heading">Log in</h2>
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-warning"><strong>Failure.</strong> Incorrect email or password.</div>';
            }
            if (isset($_SESSION['uid'])) {
                echo '<div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>';
                echo '<a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your profile</a>';
                echo '<br /><br />UID:'.$_SESSION['uid'].'<br />Email:'.$_SESSION['email'];
                $jqHideFormElements = <<<HEREDOC
                    <script>
                        $('#inputEmail').hide();
                        $('#inputPassword').hide();
                        $('.checkbox').hide();
                        $('#inputSubmit').hide();
HEREDOC;
                echo $jqHideFormElements;

            }
            ?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember Email
          </label>
        </div>
        <input type="hidden" name="type" value="login">
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="inputSubmit">Sign in</button>
      </form>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>