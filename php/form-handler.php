<?php

if(!$_SERVER['REQUEST_METHOD'] == 'POST') { exit(); } // make sure we're using a form, first thing.

// start the page
require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");

$mydb = new ckdb;
$mydb->connect();

$operation = get_post_var('type');

// Start the actual process of handling form input.
switch ($operation) {
    case "register":
        $email = get_post_var('email');
        $password = get_post_var('password');
        // register a new user
        require_once($_SERVER['DOCUMENT_ROOT'] . "/recaptcha-secret.php");
        //$recaptcha_secret
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Google ReCAPTCHA
        if(isset($_POST['g-recaptcha-response'])) { $captcha=$_POST['g-recaptcha-response']; }
        if(!$captcha){
            //fail('reCAPTCHA error.');
            //echo 'recaptcha error';
            header('Location: /user/register.php?error=captcha');
            //exit();
        } else {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
            $response = json_decode($response, true);
            if($response["success"] == true) {
                //fail('reCAPTCHA is okay. Carrying on.');
                $notspam = TRUE;
                echo 'not a robot'.$response["success"];
            } else {
                //fail('reCAPTCHA marked as robot.');
                $notspam = FALSE;
                echo 'You are a robot.'.$response["success"];
                //exit();
            }
        }
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        if($notspam) {

            $regoutput = $mydb->createUser($email, $password);

            if( strpos($regoutput, 'Duplicate entry' !== false) ) {
                //echo "Register Failure: " . $output;
                header('Location: /user/register.php?error=dupemail');
            } else {
                header('Location: /template/success.php');
                //echo 'Success.'.$notspam;
                //print_r($response);
                //echo $notspam.$regoutput.$operation;
            }
        } else {
            //echo 'Error: Invalid Captcha:'.$notspam.$operation;
            //print_r($response);
            header('Location: /user/register.php?error=captcha');
        }
        break;
    case "login":
        $email = get_post_var('email');
        $password = get_post_var('password');
        // login a user
        //require('/php/form/login.php');
        //echo $email . ' ' . $password;
        if ( $mydb->loginUser($email,$password) ) {
            echo "Login Success";
            header('Location: /about.php');

            $uid = $mydb->getUserUID($email)[0]['uid'];
            $_SESSION['uid'] = $uid;
            $_SESSION['email'] = $email;
        } else {
            //echo "Login Failure";
            header('Location: /user/login.php?error=1');
        }
        break;
    case "logout":
        // logout a user
        header('Location: /user/logout.php');
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

    case "addrating":

        break;
    default:
        echo "Error. Invalid form operation.";
        exit();
}


require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");