<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config/maintenance-toggle.php");

if ($MAINTENANCE_MODE_ENABLED)
{
    if ($_SERVER['REQUEST_URI'] != "/maintenance.html") {
        header('Location: /maintenance.html');
        echo '<META http-equiv="refresh" content="5;URL=/maintenance.html">';
    } else {
        echo "already on maintenance page";
    }

}