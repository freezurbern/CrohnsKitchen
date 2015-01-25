<?php
// require the files
require('class.phpmailer.php');
require('class.pop3.php');
require('class.smtp.php');

//require($_SERVER['DOCUMENT_ROOT'] . "/../protected/authcodes.php"); // grab the server connection details.

//Create a new PHPMailer instance
function send_user_mail($M_ADDRESS, $M_SUBJECT, $M_MESSAGE) 
{
		$mail = new PHPMailer;
		//Set who the message is to be sent from
		$mail->setFrom('noreply@crohns.zachery.ninja', 'Crohns Kitchen');
		//Set an alternative reply-to address
		$mail->addReplyTo('admin@crohns.zachery.ninja', 'Crohns Kitchen');
		//Set who the message is to be sent to
		$mail->addAddress($M_ADDRESS);
		//Set the subject line
		$mail->Subject = $M_SUBJECT;
		$mail->isHTML(true); // Set email format to HTML
		$mail->Body = $M_MESSAGE;
		$mail->AltBody = 'non-HTML mail clients';
		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			return FALSE;
		} else {
			//echo "Message sent!";
			return TRUE;
		}
		unset($mail);
}


?>