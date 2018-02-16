<?php
	$shirtID = $_POST["shirtID"];
	$count = $_POST["count"];

	$connection = mysql_connect('localhost','root',$rootPassword);
	if(!$connection){die('could not connect ' . mysql_error());}
	mysql_select_db("ndtees", $connection);

	mysql_query("UPDATE Shirt SET inceptionCount=$count WHERE shirtID=$shirtID");

	$result = mysql_query("SELECT * FROM Shirt WHERE shirtID=$shirtID", $connection);

	mysql_close($connection);
?>
