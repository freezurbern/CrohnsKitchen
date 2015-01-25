<?php
/* Crohn's Kitchen User form handler
 * author: freezurbern
 * date: Jan 2015
*/
require($_SERVER['DOCUMENT_ROOT'] . "/include/main.php"); // main functions, and references
$operation = filter_var(get_post_var('op'), FILTER_SANITIZE_STRING);

switch ($operation)
{
	case "register":
		$myCount += 1;
		// register a new user
		require('form/register.php');
		exit();
	case "recover":
		// help user recover their account
		require('form/recover.php');
		exit();
	case "changepass":
		// change a user's password
		require('form/changepass.php');
		exit();
	case "changeemail":
		// change a user's email
		require('form/changeemail.php');
		exit();
	case "login":
		// login a user
		require('form/login.php');
		exit();
	case "logout":
		// logout a user
		require('form/logout.php');
		exit();
	default:
		echo "Error. Invalid form operation.";
		exit();
}