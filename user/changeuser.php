<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>

<?php if (!empty($_POST)): ?>
    <?php // Form Submission code for changing auser's details.
    $mydb = new ckdb; // create database object
    $mydb->connect(); // connect to database server
    //error_log("ChangeUser Page Start", 0);

    $uid = $_SESSION['uid'];
    $currentemail = $_SESSION['email'];
    $newemail = get_post_var('newemail');
    $currentpassword = get_post_var('currentpassword');
    $newpassword = get_post_var('newpassword');
    $confirmpassword = get_post_var('confirmpassword');

    //error_log($uid."|".$currentemail."|".$newemail."|".$currentpassword."|".$newpassword."|".$confirmpassword,0);

    // testing current email and pass. do this before anything else.
    // if successful, keep going.
    // else, return to page with error message.
    $tryLogin = $mydb->loginUser($currentemail, $currentpassword);
    if ($tryLogin) {
        // success is good. carry on.
    } else {
        //error_log("ChangeUser User Failed Login|".$tryLogin, 0);
        header('Location: /user/changeuser.php?error=badpass');
    }

    function logmeout() {
        //error_log("ChangeUser Logout", 0);
        // done with updating, lets logout to make sure session vars are up to date
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['uid'])) {
            //echo "Running logout";
            // Logout the user. Remove PHPSESSID from browser
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), "", time() - 3600, "/");
            }
            //clear session from globals
            $_SESSION = array();
            //clear session from disk
            session_destroy();
        }
        return;
    }

    // did user want to change their email?
    if (strcasecmp($currentemail, $newemail) == 0) {
        // current email is equal to new email
        //error_log("ChangeUser DupEmail", 0);
        header('Location: /user/changeuser.php?error=dupemail');
    }

    // determine what to do then go to a switch.
    // create variable for switch
    $actionSwitch = 0;

    if(strpos($newemail, "@") === false) {
        /* no change to email requested, because no @ symbol in string */
    } else {
        // email is requested
            //error_log("ChangeUser Email Change Requested", 0);
            $actionSwitch += 1;
    }

    if ($newpassword !== '' && $newpassword === $confirmpassword) {
        $actionSwitch += 2;
    }

    //error_log("ChangeUser: Action Switch:".$actionSwitch, 0);
    switch ($actionSwitch) {
        case 1:
            // change email but not password
            $emailChangeRequest = $mydb->changeUserEmail($uid, $newemail);
            if ($emailChangeRequest !== TRUE) {
                // email change bad
                //error_log("ChangeUser: Email Change Bad", 0);
                //error_log($emailChangeRequest, 0);
                header('Location: /user/changeuser.php?error=emailChangeBad');
            } else {
                //error_log("ChangeUser: Email Change GOOD", 0);
                //error_log($emailChangeRequest, 0);
                logmeout();
            }
            break;
        case 2:
            // change pass but not email
            $passChangeRequest = $mydb->changeUserPass($uid, $newpassword);
            if ($passChangeRequest !== TRUE) {
                // pass change bad
                //error_log("ChangeUser: Pass Change Bad", 0);
                //error_log($passChangeRequest, 0);
                header('Location: /user/changeuser.php?error=passChangeBad');
            } else {
                //error_log("ChangeUser: Pass Change GOOD", 0);
                //error_log($passChangeRequest, 0);
                logmeout();
            }
            break;
        case 3:
            // change both email and password
            $bothChangeRequest1 = $mydb->changeUserPass($uid, $newpassword);
            $bothChangeRequest2 = $mydb->changeUserEmail($uid, $newemail);
            if ($bothChangeRequest1 !== TRUE OR $bothChangeRequest2 !== TRUE) {
                // request bad
                //error_log("ChangeUser: Both Change Bad", 0);
                //error_log($bothChangeRequest1."|".$bothChangeRequest2, 0);
                header('Location: /user/changeuser.php?error=bothChangeBad');
            } else {
                //error_log("ChangeUser: Both Change GOOD", 0);
                //error_log($bothChangeRequest1."|".$bothChangeRequest2, 0);
                logmeout();
            }
            break;
        default:
            // no changes requested, return to page
            //error_log("ChangeUser: No Change", 0);
            header('Location: /user/changeuser.php?error=nochange');
            break;
    }




    ?>

    <!-- ##################################################### -->
    <!-- ############# AFTER Submission Contents ############# -->
    <!-- ##################################################### -->
    <META http-equiv="refresh" content="10;URL=/user/logout.php">
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
    <article>
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
                                        <div class="alert alert-warning"><strong>Failure.</strong> Email already
                                            registered.
                                        </div>
                                    <?php } elseif ($_GET['error'] == 'badpass') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> Password not valid.
                                        </div>
                                    <?php } elseif ($_GET['error'] == 'unspecified') { ?>
                                        <div class="alert alert-warning"><strong>Failure.</strong> Unknown error. Please
                                            try again.
                                        </div>
                                    <?php } elseif ($_GET['error'] == 'passchanged') { ?>
                                        <div class="alert alert-success"><strong>Woo!</strong> Password updated!</div>
                                    <?php } elseif ($_GET['error'] == 'emailchanged') { ?>
                                        <div class="alert alert-success"><strong>Woo!</strong> Email updated!</div>
                                    <?php }
                                } ?>

                                <div class="input-group">
                                    <span class="input-group-addon">New Email</span>
                                    <input type="email" name="newemail" id="newemail" class="form-control"
                                           aria-describedby="inputNewEmail"
                                           placeholder="user@foo.com">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Current Password<span class="red">*</span></span>
                                    <input type="password" name="currentpassword" id="currentpassword"
                                           class="form-control" placeholder="MySecretPassW0rd!!"
                                           pattern=".{4,64}" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">New Password</span>
                                    <input type="password" name="newpassword" id="newpassword" class="form-control"
                                           placeholder="new"
                                           pattern=".{4,64}">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Confirm New Password</span>
                                    <input type="password" name="confirmpassword" id="confirmpassword"
                                           class="form-control" placeholder="confirm"
                                           pattern=".{4,64}">
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <br/>
                                        <input type="hidden" name="type" value="register">
                                        <button type="submit" class="btn btn-primary">Update</button>

                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </article>
    <!--<script>
        $(document).ready(function () {
            $("button[type=submit]").attr('disabled', 'disabled');
            $('#confirmpassword, #newpassword').keyup(function () {
                if ($('#newpassword').val() == $('#confirmpassword').val()) {
                    $("button[type=submit]").removeAttr('disabled');
                    $("button[type=submit]").html('Register Account');
                } else {
                    $("button[type=submit]").attr('disabled', 'disabled');
                    $("button[type=submit]").html('Password mismatch');
                }
            });
        });
    </script>-->
<?php endif; ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>