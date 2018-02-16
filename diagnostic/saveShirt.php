<?php
	$shirtID = $_POST["shirtID"];
	$clientID = $_POST["clientID"];
	$shirtName = $_POST["shirtName"];
	$shirtType = $_POST["shirtType"];
	$price = $_POST["price"];
	$color = $_POST["color"];
	$clientInvestment = $_POST["clientInvestment"];
	$ourInvestment = $_POST["ourInvestment"];
	$sCount = $_POST["sCount"];
	$mCount = $_POST["mCount"];
	$lCount = $_POST["lCount"];
	$xlCount = $_POST["xlCount"];
	$imagePath = $_POST["imagePath"];
	$laundryBagPath = $_POST["laundryBagPath"];

	$connection = mysql_connect('localhost','root',$rootPassword);
	if(!$connection){die('could not connect ' . mysql_error());}
	mysql_select_db("ndtees", $connection);

	$query = "UPDATE Shirt SET clientID=$clientID, shirtName='$shirtName', shirtType='$shirtType', price=$price, color='$color', clientInvestment=$clientInvestment, ourInvestment=$ourInvestment, sCount=$sCount, mCount=$mCount, lCount=$lCount, xlCount=$xlCount, imagePath='$imagePath', laundryBagPath='$laundryBagPath' WHERE shirtID=$shirtID";

	//echo $query;

	mysql_query($query, $connection);

	echo "Successfully Saved! (Reload the Diagnostic for now...)";

	mysql_close($connection);
?>
