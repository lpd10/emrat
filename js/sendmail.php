<?php
// Who you want to recieve the emails from the form.
$sendto = 'adresEmail@o.pl';

// The subject you'll see in your inbox
$subject = 'Wiadomość ze strony EMRAT';

// Message for the user when he/she doesn't fill in the form correctly.
$errormessage = 'Wykryto puste pola. Spróbuj jeszcze raz.&nbsp;';

//Message for the user when he/she fills in the form correctly.
$thanks = "Dziękujemy za wiadomość. Odezwiemy się wkrótce z odpowiedzią.&nbsp;";

// Message for the bot when it fills in in at all.
$honeypot = "You filled in the honeypot! If you're human, try again!&nbsp;";

// Various messages displayed when the fields are empty.
$emptyname =  'Wpisz imię.&nbsp;';
$emptyemail = 'Wpisz swój adres email.&nbsp;';
$emptymessage = 'Wpisz treść wiadomości.&nbsp;';
$emptyphone = 'Wpisz numer telefonu.&nbsp;';

// Various messages displayed when the fields are incorrectly formatted.
$alertname =  'Wpisz swoje imię używając znaków standarowego alfabetu&nbsp;';
$alertemail = 'Wpisz swój email podobnym formacie: <i>imie@przyklad.pl</i>?&nbsp;';
$alertmessage = "Sprawdź czy w treści wiadomości nie używasz znaków nietypowych znaków.&nbsp;";

$alert = '';
$pass = 0;

function clean_var($variable) {
	$variable = strip_tags(stripslashes(trim(rtrim($variable))));
  return $variable;
}

if ( empty($_REQUEST['last']) ) {

  if ( empty($_REQUEST['name']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptyname . "</li>";
	$alert .= "<script>jQuery(\"#name\").addClass(\"error\");</script>";
  } elseif ( preg_match( "/[][{}()*+?.\\^$|]/", $_REQUEST['name'] ) ) {
	$pass = 1;
	$alert .= "<li>" . $alertname . "</li>";
  }
  if ( empty($_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptyemail . "</li>";
	$alert .= "<script>jQuery(\"#email\").addClass(\"error\");</script>";
  } elseif ( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $alertemail . "</li>";
  }
  if ( empty($_REQUEST['message']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptymessage . "</li>";
	$alert .= "<script>jQuery(\"#message\").addClass(\"error\");</script>";
  } elseif ( preg_match( "/[][{}()*+?\\^$|]/", $_REQUEST['message'] ) ) {
	$pass = 1;
	$alert .= "<li>" . $alertmessage . "</li>";
  }

  if ( $pass==1 ) {

  echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"fast\").show(\"fast\"); </script>";
  echo "<script>$(\".message .alert\").addClass('alert-danger').removeClass('alert-success'); </script>";
  echo $errormessage;
  echo $alert;

  } elseif (isset($_REQUEST['message'])) {

	$message = "Od: " . clean_var($_REQUEST['name']) . "\n";
	$message .= "Email: " . clean_var($_REQUEST['email']) . "\n";
	$message .= "Telefon: " . clean_var($_REQUEST['phone']) . "\n";
	$message .= "Wiadomość: \n" . clean_var($_REQUEST['message']);	
	$header = 'Od:'. clean_var($_REQUEST['email']);

	mail($sendto, $subject, $message, $header);
	echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"fast\").show(\"fast\");$('#contactForm')[0].reset();</script>";
	echo "<script>$(\".message .alert\").addClass('alert-success').removeClass('alert-danger'); </script>";
	echo $thanks;
	echo "<script>jQuery(\"#name\").removeClass(\"error\");jQuery(\"#email\").removeClass(\"error\");jQuery(\"#message\").removeClass(\"error\");</script>";
	echo "<script>$(\".message .alert\").delay(4000).hide(\"fast\");</script>";
	die();

	echo "<br/><br/>" . $message;

	}

} else {
	echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"fast\").show(\"fast\");</script>";
	echo $honeypot;
}
?>
