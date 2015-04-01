<?php
/*
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

//built-in for the PHP emailing functions
require './PHPMailerAutoload.php';

//written for code importation
require './readConfig.php';

//Check if arguments were passed properly


if(empty($_POST['name'])||    
empty($_POST['email'])  ||
empty($_POST['message'])||   
!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))    
{     
	echo "No arguments Provided!";   return false;    
} 

//Assign the arguments to variables
$name = $_POST['name']; 
$email_address = $_POST['email']; 
$message = $_POST['message'];      

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//
// read configuration values from a file 
// these will be used in the sending of the email
//
$configValues = readConfig('mailConfig.conf');

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = $configValues['smtpUsername'];

//Password to use for SMTP authentication
$mail->Password = $configValues['smtpPassword'];

//Set who the message is to be sent from
$mail->setFrom($configValues['smtpUsername'], $configValues['websiteName'].' form submission');

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress($configValues['destinationAddress'], $configValues['destinationName']);

//Set the subject line
$mail->Subject = $configValues['websiteName'].' contact form';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//$mail->msgHTML();

$mail->msgHTML(		'Name: ' . $name . '<br>' . 
			'Email: ' . $email_address . '<br>' .
			'Message: ' . $message . '<br>');
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
/*$mail->AltBody =	'Name: ' . $name . '\n' . 
			'Email: ' . $email . '\n' .
			'Message: ' . $message . '\n';
*/
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

return true;
