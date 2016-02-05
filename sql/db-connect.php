<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/5/2016
 * Time: 2:44 PM
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/dbconfig.inc.php');
$db = new PDO('mysql:host=localhost;dbname=$config['dbname'];charset=utf8', $config['dbuser'], $config['dbpass']);