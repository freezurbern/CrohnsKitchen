<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHPMailer/PHPMailerAutoload.php");
/*
$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->isHTML(true);                                  // Set email format to HTML
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
// ===
$mail->addAddress('ellen@example.com');
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
*/

function cksendmail($email, $subject, $message)
{
    $mail = new PHPMailer;
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/mailconfig.inc.php");
    // Extra config here
    

    // Actual email contents
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!$mail->send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //error_log($mail->ErrorInfo, 0);
        return $mail->ErrorInfo;

    } else {
        //echo 'Message has been sent';
        return TRUE;
    }
}

function test_cksendmail()
{
    $testmail = cksendmail('freezurbern@gmail.com', 'Testing Crohn\'s Kitchen Email', 'This is a test message.');
    //echo 'TESTMAIL: '.$testmail;
    if ($testmail) {
        //echo 'Message sent.';
        //echo $testmail;
        //return $testmail;
        //error_log("Email Test Successful:".$testmail, 0);
        return TRUE;
    } else {
        //echo 'Message not sent.';
        //echo $testmail;
        //return $testmail;
        //error_log("Email Test failure:".$testmail, 0);
        return $testmail;
    }
}

function genRegEmail($code, $email) {
    // This function returns the user registration verification email with the verify code and email added correctly.
$EMAILregverifyStart = <<<HEREDOC
Welcome to Crohn's Kitchen!
===========================
To complete your registration, please click the link below:
http://crohns.freezurbern.com/user/verify.php?code=
HEREDOC;

$EMAILregverifyFinish = <<<HEREDOC

Thank you for registering!
- Crohn's Kitchen
HEREDOC;

return $EMAILregverifyStart . urlencode($code) . '&email=' . urlencode($email) . $EMAILregverifyFinish;
}

function genUpdateEmail($code, $email) {
    // This function returns the user profile change verification email with the verify code and email added correctly.
    $EMAILUpdverifyStart = <<<HEREDOC
Thank you for updating your profile!
===========================
To complete your change request, please click the link below:
http://crohns.freezurbern.com/user/verify.php?code=
HEREDOC;

    $EMAILUpdverifyFinish = <<<HEREDOC

Thank you,
- Crohn's Kitchen

PS: If you did not request this change, please contact us via our website.
HEREDOC;

    return $EMAILUpdverifyStart . urlencode($code) . '&email=' . urlencode($email) . $EMAILUpdverifyFinish;
}