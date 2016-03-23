<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>

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
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="well well-sm">
                        <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                              method="POST">
                            <fieldset>
                                <legend>Log in</legend>
                                <?php
                                if (isset($_GET['error'])) {
                                    echo '<div class="alert alert-warning"><strong>Failure.</strong> Incorrect email or password, or account not verified.</div>';
                                }
                                if (isset($_SESSION['uid'])) {
                                    echo '<script type="text/javascript" src="/js/hideLoginFields.js"></script>';
                                    echo '<div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>';
                                    echo '<a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your profile</a>';
                                    echo '<br /><br />UID:' . $_SESSION['uid'] . '<br />Email:' . $_SESSION['email'];
                                    exit(); // dont show rest of page
                                }
                                ?>
                                <?php if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 'dupemail') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> Email already registered.
                                        </div>
                                    <?php } elseif ($_GET['error'] == 'captcha') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> reCAPTCHA error.</div>
                                    <?php }
                                } ?>

                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputpassword" class="col-lg-2 control-label">Password</label>
                                    <div class="col-lg-10">
                                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="hidden" name="type" value="login">
                                        <button class="btn btn-primary" type="submit" id="inputSubmit">Sign in</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>

<!-- ############# End of login page ############# -->
<!-- ############################################# -->
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>