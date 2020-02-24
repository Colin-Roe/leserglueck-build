<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$err = false;

if (array_key_exists('nameInput', $_POST)) {
	// Limit length and strip HTML tags
	$name = substr(strip_tags($_POST['nameInput']),0,255);
} else {
	$name = '';
}

// Make sure the email the user provided is valid before trying to use it
if (array_key_exists('emailInput', $_POST) && PHPMailer::validateAddress($_POST['emailInput'])) {
	$visitor_email = $_POST['emailInput'];
}
else {
    $err = true;	
}

if (array_key_exists('subjectInput', $_POST)) {
	// Limit length and strip HTML tags
	$subject = substr(strip_tags($_POST['subjectInput']),0,255);
} else {
	$err = true;
}

//Apply some basic validation and filtering to the query
if (array_key_exists('messageInput', $_POST)) {
	//Limit length and strip HTML tags
	$message = substr(strip_tags($_POST['messageInput']), 0, 16384);
} else {
	$err = true;
}

$enquiryData = [
    'fName' => $name,
    'visitorEmail' => $visitor_email,
    'subject' => $subject,
    'message' => $message
];

sendEmail($enquiryData, $err);

function sendEmail($enquiryData, $err) {
	if (!$err) {
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = false;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'mx2fc0.netcup.net';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'dagmar@leserglueck.de';                     // SMTP username
			$mail->Password   = 'Stuttgart@2020';                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to

			//Recipients
			$mail->setFrom('dagmar@leserglueck.de', 'Contact Form');
			$mail->addAddress('dagmar@leserglueck.de', 'Dagmar Mehling');    // Add a recipient
			// $mail->addAddress('ellen@example.com');               // Name is optional
			// $mail->addReplyTo('info@example.com', 'Information');
			// $mail->addCC('cc@example.com');
			// $mail->addBCC('bcc@example.com');

			// Attachments
			// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $enquiryData['subject'];

			$mailContent = "<h2>Contact Form Submission</h2>
				<p>Name: " . $enquiryData['fName'] . "</p>" . 
				"<p>Email: " . $enquiryData['visitorEmail'] . "</p>" .
				"<p>Message: " . $enquiryData['message'] . "</p>";

			$mail->Body = $mailContent;
			$mail->AltBody = strip_tags($mailContent);

			// Send the message, check for errors
			if ($mail->send()) {
				print 'Message has been sent';
			}
			else {
				print 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
			}
		} catch (Exception $e) {
			print "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}

?>