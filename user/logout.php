<?php
if (isset($_SESSION['uid'])) {
    // Logout the user. Remove PHPSESSID from browser
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 3600, "/");
    }
    //clear session from globals
    $_SESSION = array();
    //clear session from disk
    session_destroy();
    //reload the page to show logout message, if it was successful.
    //  If not successful, try again.
    header('Location: /user/logout.php');
}
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
    <link href="/css/login.css" rel="stylesheet">
    <article>
        <div class="container">
            <div class="alert alert-danger">You are no longer logged in.</div>
            <a class="btn btn-lg btn-primary" href="/" role="button">Return to homepage</a>
            <a class="btn btn-lg btn-success" href="/user/login.php" role="button">Login again</a>
        </div> <!-- /container -->
    </article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>