<?php
    $shirtID = $_POST["shirtID"];

    $connection = mysql_connect("localhost", "root", $rootPassword);
    if (!$connection)
    {
        die("Could not connect to database: " . mysql_error());
    }

    mysql_select_db("ndtees", $connection);

    $result = mysql_query("UPDATE Shirt SET active = NOT active WHERE shirtID = " . $shirtID, $connection);
?>
