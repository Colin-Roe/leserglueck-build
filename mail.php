<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';



$name = $_POST['nameInput'];
$visitor_email = $_POST['emailInput'];
$how = $_POST['wieInput'];
$subject = $_POST['subjectInput'];
$message = $_POST['messageInput'];

$enquiryData = [
    'fName' => $name,
    'visitorEmail' => $visitor_email,
    'how' => $how,
    'subject' => $subject,
    'message' => $message
];

function sendEmail($enquiryData) {
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
        $mail->addAddress('colinkroe@gmail.com', $enquiryData['fName']);    // Add a recipient
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

        $mailContent = "<h2>Contact form submission</h2>
            <p>Name: " . $enquiryData['fName'] . "</p>" . 
            "<p>Message: " . $enquiryData['message'] . "</p>" . 
            "<p>Email: " . $enquiryData['visitorEmail'] . "</p>" .
            "<p>Wie hast du mich gefunden? " . $enquiryData['how'] . "</p>";

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

sendEmail($enquiryData);

?>