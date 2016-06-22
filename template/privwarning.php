<?php
/*  This file is for checking whether a client has the correct permissions or not.
    Requires: page-start.php loaded before it.
    To use:
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/privwarning.php"); ?>
*/

if( !isset($PRIVNEEDED) ) { $PRIVNEEDED = 1; }

if ($_SESSION['privlevel'] < $PRIVNEEDED) {
$privwarning = <<<HEREDOC
<div class="container"><div class="jumbotron">
    <div class="alert alert-danger"><strong>Failure.</strong> You lack permission to use this page.</div>
    <a class="btn btn-lg btn-primary" href="/user/login.php" role="button">Login now</a>
</div></div>
HEREDOC;
    echo $privwarning;
    require_once($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");
    exit(); // prevent rest of page from loading. Only showing the above notice.
}