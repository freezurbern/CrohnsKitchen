<?php
/* Crohn's Kitchen User form handler
 * author: freezurbern
 * date: Jan 2015
*/
error_reporting(-1);
ini_set('display_errors', 'On');

//require($_SERVER['DOCUMENT_ROOT'] . "/include/main.php"); // main functions, and references
$operation = filter_var(get_post_var('op'), FILTER_SANITIZE_STRING);
$operation = "login";
switch ($operation)
{
	case "register":
		// register a new user
		require('form/register.php');
		break;
	case "recover":
		// help user recover their account
		require('form/recover.php');
		break;
	case "changepass":
		// change a user's password
		require('form/changepass.php');
		break;
	case "changeemail":
		// change a user's email
		require('form/changeemail.php');
		break;
	case "login":
		// login a user
		require('form/login.php');
		//break;
	case "logout":
		// logout a user
		require('form/logout.php');
		break;
	default:
		echo "Error. Invalid form operation.";
		//exit();
}