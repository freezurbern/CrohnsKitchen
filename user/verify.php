<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>

<?php

$verifykey = get_get_var('code');
$verifyemail = get_get_var('email');

$mydb = new ckdb; // create database object
$mydb->connect(); // connect to database server

$verified = $mydb->chkUserVerify($verifyemail, $verifykey);

if ($verified) {
    $result = TRUE;
} else {
    $result = FALSE;
}

?>
    <article>
        <div class="container">
            <div class="jumbotron">
                <h1>Account Verification</h1>
                <p>
                    <?php if ($result) { ?>
                <div class="alert alert-success">
                    <strong>Verification complete!</strong> You may now login.
                </div>
                <a class="btn btn-lg btn-primary" href="/user/login.php" role="button">Login now &raquo;</a>
                <?php } else { ?>
                    <div class="alert alert-warning">
                        <strong>Invalid pair.</strong>Please reset your password.
                    </div>
                    <a class="btn btn-lg btn-primary" href="/" role="button">Go home &raquo;</a>
                <?php } ?>
                </p>
                <?php
                echo '<p><pre>' . $verifyemail . '</pre>';
                echo '<pre>' . $verifykey . '</pre>';
                //echo '<pre>'.$dbKey.'</pre>';
                echo '</p>';
                ?>
            </div>
        </div> <!-- /container -->
    </article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>