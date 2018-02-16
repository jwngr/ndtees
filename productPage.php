<html>
    <body>
        <div id="shirtProjection">
            <?php
                // Connect to the database
			  	$connection = mysql_connect("localhost", "root", $rootPassword);
    			if (!$connection)
                {
                    die("Could not connect to database: " . mysql_error());
                }
	    	    mysql_select_db("ndtees", $connection);

                // Query the database for each shirt
                $shirtID = $_GET["shirtID"];
	    		$result = mysql_query("SELECT * FROM Shirt WHERE shirtID = $shirtID", $connection);

                // Create a product card for each shirt
                while($row = mysql_fetch_array($result))
		    	{
                    // Fill the left projection with the shirt image
				    echo "<div class='projectionLeft'>\n";
			    	echo "    <img class='projectionLeftImg' width='370px' height='400px' id='" . $row['shirtID'] . "' src='images/shirts/" . $row['imagePath'] . "' />\n";
				    echo "</div>\n";

                    // Fill the right projection with the purchase projection slides
	    		    include "projectionSlides.php";
		        }

                // Close the database connection
    			mysql_close($connection);
	    	?>
		</div>
	</body>
</html>
