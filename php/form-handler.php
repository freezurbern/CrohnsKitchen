<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/9/2016
 * Time: 7:48 AM
 */
require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");


function cleanInput($input) {
    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    ); $output = preg_replace($search, '', $input); return $output;
}
function sanitize($input) {
    $output = "";
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    } else {
        $input = stripslashes($input);
        $input  = cleanInput($input);
        $output = $input;
    }
    filter_var($output, FILTER_SANITIZE_STRING);
    return $output;
}
// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
    $val = $_POST[$var];
    return sanitize($val);
}

$mydb = new ckdb;
$mydb->connect();

$operation = get_post_var('type');
$email = get_post_var('email');
$password = get_post_var('password');

//printArray($_POST);
function printArray($array){
    foreach ($array as $key => $value){
        echo "$key => $value";
        if(is_array($value)){ //If $value is an array, print it as well!
            printArray($value);
        }
    }
}


switch ($operation) {
    case "register":
        // register a new user
        //require('/php/form/register.php');
        if ( $mydb->createUser($email, $password) ) {echo "Register Success";} else {echo "Register Failure";}
        break;
    case "login":
        // login a user
        //require('/php/form/login.php');
        if ( $mydb->loginUser($email,$password) ) {
            $success = 1;
            echo "Login Success";

            $uid = $mydb->getUserUID($email)[0]['uid'];

            $_SESSION['uid'] = $uid;
            $_SESSION['email'] = $email;
        } else {
            $success = 0;
            echo "Login Failure";
        }

        break;
    case "logout":
        // logout a user
        //require('/php/form/logout.php');
        //remove PHPSESSID from browser
            if ( isset( $_COOKIE[session_name()] ) )
               setcookie( session_name(), “”, time()-3600, “/” );
        //clear session from globals
            $_SESSION = array();
        //clear session from disk
            session_destroy();
        break;
    case "recover":
        // help user recover their account
        //require('/php/form/recover.php');
        break;
    case "changepass":
        // change a user's password
        //require('/php/form/changepass.php');
        break;
    case "changeemail":
        // change a user's email
        //require('/php/form/changeemail.php');
        break;
    default:
        echo "Error. Invalid form operation.";
        exit();
}


require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");