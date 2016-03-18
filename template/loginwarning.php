<?php
/*  This file is for checking whether a client is logged in or not. If logged in, does nothing.
    If not logged in, shows message and stops script execution (to hide the page that needs login)
    Requires: page-start.php loaded before it.
    To use:
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>
*/
if (!isset($_SESSION['uid'])) {
$loginwarning = <<<HEREDOC
<div class="container"><div class="jumbotron">
    <div class="alert alert-warning"><strong>Failure.</strong> You must be logged in to use this page.</div>
    <a class="btn btn-lg btn-primary" href="/user/login.php" role="button">Login now</a>
</div></div>
HEREDOC;
    echo $loginwarning;
    require_once($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");
    exit(); // prevent rest of page from loading. Only showing the above notice.
}