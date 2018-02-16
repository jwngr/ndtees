<?php
    $purchaseID = $_POST["purchaseID"];

    $connection = mysql_connect("localhost", "root", $rootPassword);
    if (!$connection)
    {
        die("Could not connect to database: " . mysql_error());
    }

    mysql_select_db("ndtees", $connection);

    $result = mysql_query("UPDATE Purchase SET delivered = NOT delivered WHERE purchaseID = " . $purchaseID, $connection);
?>
