<?php
    // Connect to the database
    $connection = mysql_connect("localhost", "root", $rootPassword);
    if (!$connection)
    {
        die("Could not connect: " . mysql_error());
    }
    mysql_select_db("ndtees", $connection);

    // Query the Shirt table
    $result = mysql_query("SELECT * FROM Shirt", $connection);

    // Counter for identification of card on page
    $cardNumber = 0;

    // Create a product card for each activeshirt
    while ($row = mysql_fetch_array($result))
    {
        // Make sure the current shirt is active
        if ($row["active"] == 1)
        {
            echo "<a id='card" . $cardNumber . "' class='card' href='productPage.php?shirtID=" . $row["shirtID"] . "'>";

            // Create a token with the page hit count and the number of shirts left to top left of the card
            $numLeft = $row["sCount"] + $row["mCount"] + $row["lCount"] + $row["xlCount"];
            echo "<div id='token" . $cardNumber . "' class='token'>";
            $hits = $row["pageHits"];
            if ($hits == 1)
            {
                echo "<div class='tokenSection' style='border-right: 1px solid #999;'><p class='tokenValueText'>1</p><p style='margin-top: -2px;'>HIT</p></div>";
            }
            else
            {
                echo "<div class='tokenSection' style='border-right: 1px solid #999;'><p class='tokenValueText'>" . $hits . "</p><p style='margin-top: -2px;'>HITS</p></div>";
            }
            echo "<div class='tokenSection'><p class='tokenValueText'>" . $numLeft . "</p><p style='margin-top: -2px;'>STOCK</p></div>";
            echo "</div>";

            // Add the image and label to the card
            echo "<img class='cardImage' src='images/designs/" . $row["imagePath"] . "' />";
            echo "<br />";
            echo "<div class='cardLabel'>" . $row["shirtName"] . "</div>";

            echo "</a>\n";

        }

        $cardNumber++;
    }

    // Close the database connection
    mysql_close($connection);
?>
