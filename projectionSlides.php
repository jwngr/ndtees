<html>
	<head>
        <script type="text/javascript" src="js/projectionSlideControl.js"></script>
        <script type="text/javascript"> 
            $(document).ready(function() {
                // Hide the on and off campus address elements
                $("#onCampusElements").hide();
                $("#offCampusElements").hide();

                // Show the on campus address elements if its radio button is clicked
                $("#onCampusRadioButton").click(function() {
                    $("#offCampusElements").hide(500, function(){
                        $("#onCampusElements").show(500);
                    });
                });
            
                // Show the off campus address elements if its radio button is clicked
                $("#offCampusRadioButton").click(function() {
                    $("#onCampusElements").hide(500, function(){
                        $("#offCampusElements").show(500);
                    });
                });
            });
        </script>
	</head>

    <body>
	    <div class="projectionRight">
		    <!-- SHIRT INFO PAGE -->
            <div class="projectionRightContainer">
	            <?php
    		        // Shirt title and price
                    echo "<p class='generalHeader' id='shirtName' style='margin-bottom:0px;'>" . $row['shirtName'] . "</p>\n";
	    	        echo "<p class='shirtPrice' value='". $row['price'] ."' style='margin-bottom:10px;'>$" . $row['price'] . "</p>\n";
		           
                    // Laundry bag
                    echo "<p class='generalParagraphText'>\n";
        		    $file = fopen("laundryBag/" . $row["laundryBagPath"],"r") or exit("Unable to open file!");
        	    	echo fgets($file);
                    echo "</p>\n";
            		fclose($file);
                
                    // Store the inception count on the page and update the page hit counter
					$inceptionCount = $row["inceptionCount"] + 1;
                    echo "<span id='inceptionCount' value = '$inceptionCount'></span>\n";
		            $hitCount = $row["pageHits"] + 1;
        		    mysql_query("UPDATE Shirt SET pageHits = $hitCount WHERE shirtID = $shirtID");
    	        
					// Stock table
                    echo "<p id='stockTableHeader'>Sizes in stock</p>\n";
                    echo "<table id='stockTable' border='1'>\n";
                    echo "<tr><th>Small</th><th>Medium</th><th>Large</th><th>Extra Large</th></tr>\n";
                    echo "<tr><td>" . $row["sCount"] . "</td><td>" . $row["mCount"] . "</td><td>" . $row["lCount"] . "</td><td>" . $row["xlCount"] . "</td></tr>\n";
                    echo "</table>\n";
                ?>

		        <!-- Purchase button -->
                <div style="text-align:center;">
                    <button id="purchaseButton">Get It!</button>
                </div>
            </div>

		    <!-- PURCHASE FORM -->
	        <div class="projectionRightContainer">
        		<!-- Header -->
                <p class="generalHeader">Purchase</p>

                <!-- Purchase text -->
		        <p class="generalParagraphText">
        		    Give us your info below and we'll bring the shirt to you. You don't even have to pay until we get there!
                </p>

                <!-- Purchase form -->
        		<div class="purchaseForm">
    		    	<!-- Name -->
                    <label class="generalFormLabel" for="name">Name</label>
                    <br />
                    <input id="name" class="validInput purchaseFormInput" name="name" size="30" type="text" />
    		        <br />

                    <!-- Email -->
	        		<label class="generalFormLabel" for="customerEmail">Email</label>
                    <br />
                    <input id="customerEmail" class="validInput purchaseFormInput" name="customerEmail" type="text" />

    		    	<!-- Address -->
        		    <label class="generalFormLabel">Address</label>
                    <br />
                    <div id="purchaseFormAddressContainer">
                        <!-- Radio buttons -->
                        <div id="addressRadioButtonContainer">
                            <input id="onCampusRadioButton" name="addressChoice" value="onCampus" type="radio">
                                <label for="onCampusRadioButton" style="margin-right: 15px;">On Campus</label>
                            </input>
                            <input id="offCampusRadioButton" name="addressChoice" value="offCampus" type="radio">
                                <label for="offCampusRadioButton">Off Campus</label>
                            </input>
                        </div>

                        <!-- On campus -->
	    			    <div id="onCampusElements">
		    				<label for="purchaseFormDormSelect" style="margin-right: 4px;">Dorm:</label>
			    			<select id="purchaseFormDormSelect" class="validInput">
    							<option value="alumni">Alumni</option>
	    						<option value="badin">Badin</option>
		    					<option value="breenPhillips">Breen-Phillips</option>
			    				<option value="carroll">Carroll</option>
				    			<option value="cavanaugh">Cavanaugh</option>
					    		<option value="dillon">Dillon</option>
						    	<option value="duncan">Duncan</option>
    							<option value="farley">Farley</option>
	    						<option value="fisher">Fisher</option>
		    					<option value="howard">Howard</option>
			    				<option value="keenan">Keenan</option>
				    			<option value="keough">Keough</option>
					    		<option value="knott">Knott</option>
						    	<option value="lewis">Lewis</option>
    							<option value="lyons">Lyons</option>
	    						<option value="mcglinn">McGlinn</option>
		    					<option value="morrissey">Morrissey</option>
			      				<option value="oneill">O'Neill</option>
					    		<option value="pangborn">Pangborn</option>
						    	<option value="pe">PE</option>
							    <option value="pw">PW</option>
    							<option value="ryan">Ryan</option>
	    						<option value="stEdward">St. Edward's</option>
		    					<option value="siegfried">Siegfried</option>
			    				<option value="sorin">Sorin</option>
				    			<option value="stanford">Stanford</option>
					    		<option value="walsh">Walsh</option>
						    	<option value="welsh">Welsh Fam</option>
							    <option value="zahm">Zahm</option>
    						</select>
		    				<label for="roomNumber">Room:</label>
			    			<input id="roomNumber" class="validInput" name="roomNumber" type="text" />
    				    </div>

                        <!-- Off campus -->
	    			    <div id="offCampusElements">
                            <p class="invalidText">
                                We are currently not delivering shirts off campus. If you still want one, have it delivered to a friend on campus and we will bring it there!
                            </p>
	    				</div>
		        	</div>
		        	
                    <!-- Size -->
	        		<label class="generalFormLabel" for="purchaseFormSizeSelect">Size</label>
		        	<br />
                    <select id="purchaseFormSizeSelect" class="validInput">
                        <?php
                            if ($row["sCount"]) { echo "<option value='s'>Small</option>\n"; }
                            if ($row["mCount"]) { echo "<option value='m'>Medium</option>\n"; }
                            if ($row["lCount"]) { echo "<option value='l'>Large</option>\n"; }
                            if ($row["xlCount"]) { echo "<option value='xl'>Extra Large</option>\n"; }
        			    ?>
                    </select>
			        
                    <!-- Purchase button -->
                    <div style="text-align:center;">
                        <button id="purchaseSubmitButton">Submit</button>
                    </div>
    		    </div>
	        </div>

            <!-- POST-PURCHASE PAGE -->
            <div class="projectionRightContainer">
		        <!-- Header -->
                <p class="generalHeader">
					<?php
						$lines = file("txt/excitement.txt");
						echo $lines[array_rand($lines)];
					?>
				</p>
		        
                <!-- Post-purchase text -->
                <p class="generalParagraphText">
                    Thanks for ordering one of our shirts! You will receive an email shortly confirming your oder.
                </p>
                
                <p class="generalParagraphText">
                    We'll stop by and deliver your shirt to you sometime within the week! If you have any questions until that time, send them to us from the contact us page.
                </p>

                <p class="generalParagraphText">
                    And, as usual, check back in a little while to see the next <span class="boldGreenText">The $10 Shirt</span>!
                </p>
	        </div>
        </div>
    </body>
</html>
