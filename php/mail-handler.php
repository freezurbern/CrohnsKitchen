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
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 2;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    // Actual email contents
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!$mail->send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
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
        return TRUE;
    } else {
        //echo 'Message not sent.';
        //echo $testmail;
        //return $testmail;
        return $testmail;
    }
}