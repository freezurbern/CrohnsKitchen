<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/9/2016
 * Time: 7:48 AM
 */

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
        if (get_magic_quotes_gpc()) { $input = stripslashes($input); }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    filter_var($output, FILTER_SANITIZE_STRING);
    return $output;
}

$mydb = new ckdb;
$mydb->connect();

$operation = sanitize(get_post_var('type'));
$email = sanitize(get_post_var('email'));
$password = sanitize(get_post_var('password'));

switch ($operation) {
    case "register":
        // register a new user
        //require('/php/form/register.php');
        if ( $mydb->createUser($email, $password) ) {return "Register Success";} else {return "Register Failure";}
        break;
    case "login":
        // login a user
        //require('/php/form/login.php');
        if ( $mydb->loginUser($email,$password) ) {return "Login Success";} else {return "Login Failure";}
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
