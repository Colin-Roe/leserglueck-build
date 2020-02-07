<?php

$name = $_POST['nameInput'];
$visitor_email = $_POST['emailInput'];
$how = $_POST['wieInput'];
$subject = $_POST['subjectInput'];
$message = $_POST['messageInput'];


$email_from = 'coileain@protonmail.com';//<== update the email address
$email_subject = "New Form submission";
$email_body = "You have received a new message from the user $name.\n".
    "Here is the message:\n $message".
    
$to = "coileain@protonmail.com";//<== update the email address
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8 " . "\r\n";
$headers .= "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers) or die("Error!");

?>