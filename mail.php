<?php
	// Get the POST data and create the email message from it
	$name = $_POST["name"];
	$email = $_POST["email"];
	$subject = $_POST["subject"];
	$message = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . $_POST["message"];

    // Send the mail
	$to = "support@ndtees.com";
	if (mail($to, $subject, $message))
	{
		echo "Mail sent!";
		mail("jwenger@nd.edu", $subject, $message);
		mail("catwood@nd.edu", $subject, $message);
	}
	else
	{
		echo "Mail failed!"; echo "<br />";
		echo $to; echo "<br />";
		echo $name; echo "<br />";
		echo $email; echo "<br />";
		echo $subject; echo "<br />";
		echo $message; echo "<br />";
	}
?>
