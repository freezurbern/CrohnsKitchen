<?php

session_start();
if(session_destroy())
{
//header("Location: ");
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$root.'">';
}

?>