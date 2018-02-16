<?php
    $user = $_POST["username"];
    $password = $_POST["password"];
    if (($user != "ndtees") || ($password != $ndteesPassword))
    {
        include("checkCred.html");
    }
    else
    {
        include("diagnostic.php");
    }
?>
