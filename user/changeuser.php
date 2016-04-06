<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>

<?php
$mydb = new ckdb; $mydb->connect();
$foodlist = $mydb->getFoods();
?>

<?php if (!empty($_POST)): ?>
    <?php // Form Submission code for registering a new user.
    $mydb = new ckdb; // create database object
    $mydb->connect(); // connect to database server

    $email = get_post_var('email');
    $uid = $mydb->getUserUID($email);
    $password = get_post_var('password');
    $confirmpassword = get_post_var('confirmpassword');

        // continue with creating the user
        $updoutput = $mydb->changeUser($uid, $email, $password);
        if (strpos($updoutput, 'Duplicate') !== false) {
            //echo "Register Failure: " . $regoutput;
            header('Location: /user/changeuser.php?error=dupemail');
        } elseif (strpos($updoutput, 'minmax') !== false) {
            //echo "Registration Failure: " . $regoutput;
            header('Location: /user/changeuser.php?error=badpass');
        } elseif ($updoutput) {
            $userverifycode = $mydb->getUserVerify($email);
            $updemail = genUpdateEmail($userverifycode, $email);
            $mailoutput = cksendmail($email, "Crohn's Kitchen Profile Updated", $updemail);
            if ($mailoutput === TRUE) {
                //header('Location: /template/success.php');
                // email sent successfully
            } else {
                header('Location: /user/changeuser.php?error=unspecified');
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
            header('Location: /user/changeuser.php?error=unspecified');
        }
    ?>

    <!-- ##################################################### -->
    <!-- ############# AFTER Submission Contents ############# -->
    <!-- ##################################################### -->
    <article>
        <div class="container">
            <div class="page-header">
                <h1>User information change complete!</h1>
                <p>You will receive a confirmation email shortly.</p>
            </div>
        </div>
    </article>

    <!-- ########################################################### -->
    <!-- ########################################################### -->
<?php else: ?>
    <!-- ############# Page Content when not submitted ############# -->
    <!-- ########################################################### -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="well well-sm">
                        <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                              method="POST">
                            <fieldset>
                                <legend>Update your user profile</legend>

                                <?php if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 'dupemail') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> Email already registered.</div>
                                    <?php } elseif ($_GET['error'] == 'badpass') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> Password not valid.</div>
                                    <?php }
                                } ?>

                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-3 input-lg">
                                        <input type="email" name="email" id="inputEmail" class="form-control" aria-describedby="inputEmail"
                                               placeholder="email">
                                        <span class="label label-default">user@domain.tld</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputpassword" class="col-lg-2 control-label">Password</label>
                                    <div class="col-lg-3 input-lg">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="pass"
                                               pattern=".{4,64}" required>
                                        <span class="label label-default">4 to 64 chars</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmpassword" class="col-lg-2 control-label">Confirm Password</label>
                                    <div class="col-lg-3 input-lg">
                                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="confirm"
                                               pattern=".{4,64}">
                                        <span class="label label-default">reenter</span>
                                    </div>
                                </div>
                                <br />
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="hidden" name="type" value="register">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <br/><span class="label label-default">click update when done</span>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>