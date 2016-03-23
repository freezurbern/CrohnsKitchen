<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
    <script src="https://www.google.com/recaptcha/api.js"></script> <!-- Google reCAPTCHA -->

<?php if (!empty($_POST)) {
// Form Submission code for registering a new user.
    $mydb = new ckdb; // create database object
    $mydb->connect(); // connect to database server

    $email = get_post_var('email');
    $password = get_post_var('password');

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/recaptcha-secret.inc.php"); //$recaptcha_secret
// Google ReCAPTCHA
    if (isset($_POST['g-recaptcha-response'])) { // captcha was included in POST?
        $captcha = $_POST['g-recaptcha-response'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response, true);
        if ($response["success"] == true) { // got a captcha reply, is it a robot?
            $notspam = TRUE;
            //echo 'not a robot' . $response["success"];
        } else {
            $notspam = FALSE;
            //echo 'You are a robot.' . $response["success"];
            exit();
        }
    } else {
        header('Location: /user/register.php?error=captcha');
        exit();
    }
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    if ($notspam) {
        // continue with creating the user
        $regoutput = $mydb->createUser($email, $password);
        if (strpos($regoutput, 'Duplicate') !== false) {
            //echo "Register Failure: " . $regoutput;
            header('Location: /user/register.php?error=dupemail');
        } elseif (strpos($regoutput, 'minmax') !== false) {
            //echo "Registration Failure: " . $regoutput;
            header('Location: /user/register.php?error=badpass');
        } elseif ($regoutput) {
            $userverifycode = $mydb->getUserVerify($email);
            $regemail = genRegEmail($userverifycode, $email);
            $mailoutput = cksendmail($email, "Crohn's Kitchen Registration", $regemail);
            if ($mailoutput === TRUE) {
                header('Location: /template/success.php');
                // email sent successfully
            } else {
                header('Location: /user/register.php?error=unspecified');
                // email did not send.
                //echo 'If 1, NOT SPAM: '.$notspam;
                //print_r($response);
                //echo 'regoutput: '.$regoutput;
                //echo $EMAILregverify;
                //echo $mailoutput;
            }
        } else {
            //echo "Registration Failure: " . $regoutput . '<br />';
            //echo 'not spam = ' . $notspam . '<br />';
            //echo 'captcha response: <br />';
            //print_r($response);
            header('Location: /user/register.php?error=unspecified');
        }
    } else {
        //echo 'Error: Invalid Captcha:'.$notspam.$operation;
        //print_r($response);
        header('Location: /user/register.php?error=captcha');
    }
} ?>

    <!-- ########################################################### -->
    <!-- ########################################################### -->
    <!-- ############# Page Content when not submitted ############# -->
    <!-- ########################################################### -->
    <article>
        <?php if (!isset($_SESSION['uid'])) { ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="well well-sm">
                            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                  method="POST">
                                <fieldset>
                                    <legend>Create an account</legend>

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
                                            <input type="email" name="email" id="inputEmail" class="form-control" aria-describedby="inputEmail"
                                                   placeholder="email" required
                                                   autofocus>
                                            <span class="label label-default">user@domain.tld</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputpassword" class="col-lg-2 control-label">Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="pass"
                                                   pattern=".{4,64}"
                                                   required>
                                            <span class="label label-default">4 to 64 chars</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmpassword" class="col-lg-2 control-label">Confirm Password</label>
                                        <div class="col-lg-10">
                                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="confirm"
                                                   pattern=".{4,64}" required>
                                            <span class="label label-default">reenter</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <b>Prove you're not a robot</b>
                                            <div class="g-recaptcha" data-sitekey="6LcQQRcTAAAAAJXzo-XX1CvZct5rUgJidycO5Bw-"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <input type="hidden" name="type" value="register">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                            <br/><span class="label label-default">click register when done</span>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <form class="form-signin" action="" method="POST">
                    <h2 class="form-signin-heading">Create an account</h2>
                    <div class="alert alert-warning"><strong>Failure.</strong> You are already logged in!</div>
                    <a class="btn btn-lg btn-primary" href="/user/index.php" role="button">Return to your
                        profile</a>
                </form>
            </div>
        <?php } ?>
    </article>
    <script>
        $(document).ready(function () {
            $("button[type=submit]").attr('disabled', 'disabled');
            $('#confirmpassword, #password').keyup(function () {
                if ($('#password').val() == $('#confirmpassword').val()) {
                    $("button[type=submit]").removeAttr('disabled');
                    $("button[type=submit]").html('Register Account');
                } else {
                    $("button[type=submit]").attr('disabled', 'disabled');
                    $("button[type=submit]").html('Password mismatch');
                }
            });
        });
    </script>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>