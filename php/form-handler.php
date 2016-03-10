<?php

if(!$_SERVER['REQUEST_METHOD'] == 'POST') { exit(); } // make sure we're using a form, first thing.

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
    if(isset($_POST[$var])) {
        $val = $_POST[$var];
        return sanitize($val);
    } else {
        return '';
    }
}

//printArray($_POST);
function printArray($array){
    echo '<code>';
    foreach ($array as $key => $value){
        echo "$key => $value<br />";
        if(is_array($value)){ //If $value is an array, print it as well!
            printArray($value);
        }
    }
    echo '</code>';
}

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
        printArray($_POST);
        echo "<hr />";

        $f1 = explode(" (", get_post_var('food1') );
            $f1name = $f1[0];
            if(isset($f2[1])) { $f1group = str_replace(")","",$f2[1]); }
            //echo 'f1name: '.$f1name.'<br />f1group: '.$f1group;
        $f2 = explode(" (", get_post_var('food2') );
            $f2name = $f2[0];
            if(isset($f2[1])) { $f2group = str_replace(")","",$f2[1]); }
            //echo 'f2name: '.$f2name.'<br />f2group: '.$f2group;
        $f3 = explode(" (", get_post_var('food3') );
            $f3name = $f3[0];
            if(isset($f3[1])) { $f3group = str_replace(")","",$f3[1]); }
            //echo 'f3name: '.$f3name.'<br />f3group: '.$f3group;
        $f4 = explode(" (", get_post_var('food4') );
            $f4name = $f4[0];
            if(isset($f4[1])) { $f4group = str_replace(")","",$f4[1]); }
            //echo 'f4name: '.$f4name.'<br />f4group: '.$f4group;
        $f5 = explode(" (", get_post_var('food5') );
            $f5name = $f5[0];
            if(isset($f5[1])) { $f5group = str_replace(")","",$f5[1]); }
            //echo 'f5name: '.$f5name.'<br />f5group: '.$f5group;
		$rb1 = get_post_var('rb1'); $rn1 = get_post_var('rn1'); $rg1 = get_post_var('rg1');
		$rb2 = get_post_var('rb2'); $rn2 = get_post_var('rn2'); $rg2 = get_post_var('rg2');
		$rb3 = get_post_var('rb3'); $rn3 = get_post_var('rn3'); $rg3 = get_post_var('rg3');
		$rb4 = get_post_var('rb4'); $rn4 = get_post_var('rn4'); $rg4 = get_post_var('rg4');
		$rb5 = get_post_var('rb5'); $rn5 = get_post_var('rn5'); $rg5 = get_post_var('rg5');
        //foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}

        //$tryAddFood1 = $mydb->addFood();


        break;
    default:
        echo "Error. Invalid form operation.";
        exit();
}


require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");