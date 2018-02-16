<html>
	<head>
        <script type="text/javascript">
        	function save()
        	{
        		$("#debug").append("saving...");
        		var shirtID = $('#shirtIDUp').html();
        		var clientID = $('#clientIDUp').val();
        		var shirtName = $('#shirtNameUp').val();
        		var shirtType = $('#shirtTypeUp').val();
        		var price = $('#priceUp').val();
        		var color = $('#colorUp').val();
        		var clientInvestment = $('#clientInvestmentUp').val();
        		var ourInvestment = $('#ourInvestmentUp').val();
        		var sCount = $('#sCountUp').val();
        		var mCount = $('#mCountUp').val();
        		var lCount = $('#lCountUp').val();
        		var xlCount = $('#xlCountUp').val();
        		var imagePath = $('#imagePathUp').val();
        		var laundryBagPath = $('#laundryBagPathUp').val();
				var data = "shirtID=" + shirtID +
							"&clientID=" + clientID +
							"&shirtName=" + shirtName +
							"&shirtType=" + shirtType +
							"&price=" + price +
							"&color=" + color +
							"&clientInvestment=" + clientInvestment +
							"&ourInvestment=" + ourInvestment +
							"&sCount=" + sCount +
							"&mCount=" + mCount +
							"&lCount=" + lCount +
							"&xlCount=" + xlCount +
							"&imagePath=" + imagePath +
							"&laundryBagPath=" + laundryBagPath;
				//$('#debug').html(data);
				$.ajax({
					type: "POST",
					url: "saveShirt.php",
					data: data,
					success: function(html) {
						parent.$.fancybox(html,
						{
							scrolling: "no",
							overlayColor: "#000",
							overlayOpacity: ".5",
							speedIn: 200,
							speedOut: 200
						});
						parent.$.fancybox.close();
        			}
    			});
        	}
        	function cancel()
        	{
        		parent.$.fancybox.close();
        	}
        </script>
    </head>

	<body>
        <!-- Page header -->
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
		    if (!$result){die("Invalid query.");}

		    $row = mysql_fetch_array($result);
		    echo "<center><p class='generalHeader'>" . $row['shirtName'] . "</p></center>";
			echo "<img id='" . $row['shirtID'] . "a' src='../images/shirts/" . $row['imagePath'] . "' />\n";
			echo "<img id='" . $row['shirtID'] . "b' src='../images/designs/" . $row['imagePath'] . "' />\n";

			echo "<table id='diagnosticTable' border='1'>";
			$num_fields = mysql_num_fields($result);
			for ($i = 0; $i < $num_fields/2; $i++)
			{
				echo "<tr>";

			    $field = mysql_fetch_field($result, $i);
			    echo "<th>{$field->name}</th>";
			    echo "<td>$row[$i]</td>";
			    if($field->name == "shirtID" || $field->name == "active" || $field->name == "creationDate" || $field->name == "inceptionCount" || $field->name == "pageHits")
			    	echo "<td><p id = '{$field->name}Up'>$row[$i]</p></td>";
			    else
			    	echo "<td><input id = '{$field->name}Up' value='$row[$i]'></input></td>";

			    $i2 = $i + $num_fields/2;
			   	$field = mysql_fetch_field($result, $i2);
			    echo "<th>{$field->name}</th>";
			    echo "<td>$row[$i2]</td>";
			    if($field->name == "shirtID" || $field->name == "active" || $field->name == "creationDate" || $field->name == "inceptionCount" || $field->name == "pageHits")
			    	echo "<td><p id = '{$field->name}Up'>$row[$i2]</p></td>";
			    else
			    	echo "<td><input id = '{$field->name}Up' value='$row[$i2]'></input></td>";

			    echo "</tr>";
			}
	        echo "</table>\n";
	        echo "<button id='shirtUpdatorSave' onclick='save()'>Save</button>";
	        echo "<button id='shirtUpdatorCancel' onclick='cancel()'>Cancel</button>";
	        echo "<p id='debug'></p>";

			// Close the database connection
			mysql_close($connection);
		?>
    </body>
</html>
