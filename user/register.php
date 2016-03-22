<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
    <link href="/css/login.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js"></script> <!-- Google reCAPTCHA -->

<?php if (!empty($_POST)) {
// Form Submission code for registering a new user.
    $mydb = new ckdb; // create database object
    $mydb->connect(); // connect to database server

    $email = get_post_var('email');
    $password = get_post_var('password');

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/recaptcha-secret.inc.php"); //$recaptcha_secret

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Google ReCAPTCHA
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        //fail('reCAPTCHA error.');
        //echo 'recaptcha error';
        header('Location: /user/register.php?error=captcha');
        //exit();
    } else {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response, true);
        if ($response["success"] == true) {
            //fail('reCAPTCHA is okay. Carrying on.');
            $notspam = TRUE;
            echo 'not a robot' . $response["success"];
        } else {
            //fail('reCAPTCHA marked as robot.');
            $notspam = FALSE;
            echo 'You are a robot.' . $response["success"];
            //exit();
        }
    }
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

    if ($notspam) {
        $regoutput = $mydb->createUser($email, $password);
        if (strpos($regoutput, 'Duplicate entry' !== false)) {
            //echo "Register Failure: " . $output;
            header('Location: /user/register.php?error=dupemail');
        } elseif ($regoutput > 1) {
            header('Location: /user/register.php?error=unspecified');
        } else {
            header('Location: /template/success.php');
            //echo 'Success.'.$notspam;
            //print_r($response);
            //echo $notspam.$regoutput.$operation;
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
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h2 class="form-signin-heading">Create an account</h2>

                <?php if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'dupemail') { ?>
                        <div class="alert alert-warning"><strong>Failure.</strong> Email already registered.</div>
                    <?php } elseif ($_GET['error'] == 'captcha') { ?>
                        <div class="alert alert-warning"><strong>Failure.</strong> reCAPTCHA error.</div>
                    <?php }
                } ?>

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required
                       autofocus>

                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                       required>

                <label for="confirmpassword" class="sr-only">Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control"
                       placeholder="Confirm password" required>

                <div class="g-recaptcha" data-sitekey="6LcQQRcTAAAAAJXzo-XX1CvZct5rUgJidycO5Bw-"></div>

                <br/>

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