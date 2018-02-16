<?php
	$email = $_POST["customerEmail"];
	$shirtID = $_POST["shirtID"];
	$size = $_POST["shirtSize"];
	$name = $_POST["name"];
	$address = $_POST["address"];
	$price = $_POST["price"];

	$connection = mysql_connect('localhost','root',$rootPassword);
	if(!$connection){die('could not connect ' . mysql_error());}
	mysql_select_db("ndtees", $connection);

	// Decrement the size stock
	switch ($size)
	{
		case 's':
			$sizeCat='sCount';
			break;
		case 'm':
			$sizeCat='mCount';
			break;
		case 'l':
			$sizeCat='lCount';
			break;
		case 'xl':
			$sizeCat='xlCount';
			break;
	}

	$row = mysql_query("SELECT $sizeCat FROM Shirt WHERE shirtID=$shirtID", $connection);
	$stock = mysql_result($row, 0)-1;
	mysql_query("UPDATE Shirt SET $sizeCat=$stock WHERE shirtID=$shirtID", $connection);

	mysql_query("INSERT INTO Purchase (shirtID, price, shirtSize, orderDate, delivered, email, customerName, address, isReserved)
		VALUES ($shirtID, $price, '$size',  NOW(), FALSE, '$email', '$name', '$address', FALSE)", $connection);
	mysql_close($connection);
?>
