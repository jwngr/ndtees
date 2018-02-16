<?php
	// Get the POST data
	$name = $_POST["name"];
	$price = $_POST["price"];
	$email = $_POST["email"];
	$address = $_POST["address"];
	$shirtName = $_POST["shirtName"];
	$size = $_POST["shirtSize"];

    // Create the email message
	$subject = "NDTees Purchase Confirmation!";
	$message = "Hey $name,<br />
        Thanks for purchasing a shirt from NDTees!<br />
		Below is a summary of your order:<br />
		<br />
		Shirt: $shirtName<br />
		Price: $price<br />
		Size: $size<br />
		Address: $address<br />
		<br />
		We'll be by in the next few days to deliver your shirt. As of right now we only accept cash upon delivery, so between now and then, make sure you have a few bucks on hand to cover your order. Also, make sure to check back soon as students create more shirts and our marketplace grows!<br />
        <br />
		Thanks,<br />
        Your friends at NDTees<br />";
    
    // Send the confirmation email
	/*
    if(mail($email,$subject,$message))
	{
		echo "Confirmation Sent";
	}
    */
?>
