<?php
	// POST the client Submission Information
	$email = $_POST["clientEmail"];
	$clientName = $_POST["clientName"];
	$price = $_POST["shirtPrice"];
	$shirtName = $_POST["shirtName"];
	$shirtColor = $_POST["shirtColor"];
	$laundryBag = $_POST["laundryBag"];
	$shirtType = $_POST["shirtType"];

	echo "$email</br>";
	echo "$clientName</br>";
	echo "$price</br>";
	echo "$shirtName</br>";
	echo "$shirtColor</br>";
	echo "$laundryBag</br>";
	echo "$shirtType</br>";

	// Connect to the database
	$connection = mysql_connect('localhost','root',$rootPassword);
	if(!$connection){die('could not connect ' . mysql_error());}
	mysql_select_db("ndtees", $connection);

	// Logic for naming laundryBag and images
	// Parse the Name for file saving
	$output = strtolower($shirtName);
	//$output = preg_replace("/[^[:space:]a-z0-9]/e", "", $output);
	$output = trim($output);
	$output = preg_replace('/\s+/', '', $output);

	$laundryBagPath = "$output.txt";
	$imagePath = "$output.png";

	// Check to see if the client already exists
	$match = mysql_query("SELECT clientID FROM Client WHERE email=$email",$connection);
	if(mysql_fetch_array($match))
	{
		// Existing Client
		$clientID = $match['clientID'];
		echo "</br></br> Client exists: $clientID";
	}
	else
	{
		echo "</br></br> New Client";
		// Inject a new Client
		mysql_query("INSERT INTO Client (email, clientName) VALUES ('$email', '$clientName')", $connection);
		$maxID = mysql_query("SELECT MAX(clientID) clientID FROM Client", $connection);
		$row = mysql_fetch_array($maxID);
		$clientID = $row['clientID'];
	}

	// Add the shirt to the database with the associated clientID
	mysql_query("INSERT INTO Shirt (clientID, shirtName, shirtType, price, color, active, creationDate, clientInvestment, ourInvestment, sCount, mCount, lCount, xlCount, pageHits, inceptionCount, imagePath, laundryBagPath)
							VALUES ($clientID, '$shirtName', '$shirtType', $price, '$shirtColor', FALSE, NOW(), 0, 0, 0, 0, 0, 0, 0, 0, '$imagePath', '$laundryBagPath')", $connection);
	mysql_close($connection);

	// Write out the laundryBag
	$laundryBagWriter = fopen("../laundryBag/$laundryBagPath", 'w') or die("can't open file");
	fwrite($laundryBagWriter, $laundryBag);
	fclose($laundryBagWriter);

	// Write the image
	//TODO
?>
