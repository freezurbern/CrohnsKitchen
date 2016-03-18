<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<link href="/css/login.css" rel="stylesheet">

<?php if(!empty($_POST)) {
    // Form Submission code
    $mydb = new ckdb; // create database object
    $mydb->connect(); // connect to database server

    $email = get_post_var('email');
    $password = get_post_var('password');
    if ($mydb->loginUser($email, $password)) {
        //echo "Login Success";
        $uid = $mydb->getUserUID($email)[0]['uid'];
        $_SESSION['uid'] = $uid;
        $_SESSION['email'] = $email;
        // redirect
        header('Location: /about.php');
    } else {
        //echo "Login Failure";
        header('Location: /user/login.php?error=1');
    }
} ?>

<!-- ########################################################### -->
<!-- ########################################################### -->
<!-- ############# Page Content when not submitted ############# -->
<!-- ########################################################### -->
    <article>
        <div class="container">
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2 class="form-signin-heading">Log in</h2>
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-warning"><strong>Failure.</strong> Incorrect email or password.</div>';
                }
                if (isset($_SESSION['uid'])) {
                    echo '<script type="text/javascript" src="/js/hideLoginFields.js"></script>';
                    echo '<div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>';
                    echo '<a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your profile</a>';
                    echo '<br /><br />UID:' . $_SESSION['uid'] . '<br />Email:' . $_SESSION['email'];
                }
                ?>
                <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember Email Remmember
                    </label>
                </div>
                <input type="hidden" name="type" value="login">
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="inputSubmit">Sign in</button>
            </form>
        </div> <!-- /container -->
    </article>

<!-- ############# End of login page ############# -->
<!-- ############################################# -->
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>