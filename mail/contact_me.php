<?php
/*
na razie to nie potrzebne bo callback z google robi co trzeba
//@author = mycodde.blogspot.com
require_once "recaptchalib.php";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = "pl";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha("6Le1DRsTAAAAABigv4RWZu27W9WwrTtEGhxrmprh");
if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
   // print_r($resp); //To See the response object uncomment this
} else {
    echo "Recaptcha Not submitted";
	echo "mail stop";
	return false;
}
if ($resp != null && $resp->success) {
    echo "Recaptcha Verification Success";
    //Write other FORM password and Email Validation Procedures
} else {
    echo "Recaptcha Verification Error";
}
*/

// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];



// Create the email and send the message
$to = 'email@oo.pl'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Nowa wiadomość ze strony EMRAT";
$email_body = "Szczegóły wiadomości:\n\nImię: $name\n\nEmail: $email_address\n\nNr Telefonu: $phone\n\nWiadomość:\n$message";
$headers = "From: WWWemratautomatyka.pl\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers.= "Content-Type: text/plain;charset=utf-8\r\n";
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
return true;			
?>

