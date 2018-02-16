<head>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".shirtUpdatorLink").fancybox({
				scrolling: "no",
				overlayColor: "#000",
				overlayOpacity: ".5",
				speedIn: 200,
				speedOut: 200
			});
		});
	</script>
</head>

<?php
    $query = $_POST["query"];
    $title = $_POST["title"];
    $shirtID = $_POST["shirtID"];
    $filter = $_POST["filter"];
    if ($query != "")
    {
        printTable($title, $query);
    }
    else if ($title == "All")
    {
        printAllTables();
    }
    else if ($title == "Summary")
    {
        printSummary();
    }
    else if ($title == "Shirt Detail")
    {
        if ($shirtID)
        {
            printShirtDetail($shirtID);
        }
        else
        {
            printShirtDetail(1);
        }
    }
    else if ($title == "Delivered")
    {
        printDelivered($filter);
    }
    else if ($title == "Undelivered")
    {
        printUndelivered($filter);
    }
    else if ($title == "Undelivered by dorm")
    {
        printUndeliveredByDorm();
    }
    else if ($title == "Undelivered by quad")
    {
        printUndeliveredByQuad();
    }

    function printTable($title, $query, $deliveredButton)
    {
        if ($deliveredButton == null)
        {
            $deliveredButton = TRUE;
        }

        echo "<p class='generalHeader' style='font-size: 28px;'>" . $title . "</p>";
        echo "<table id='diagnosticTable' border='1'>";
        $connection = mysql_connect("localhost", "root", $rootPassword);
        if (!$connection)
        {
            die("Could not connect to database: " . mysql_error());
        }

        mysql_select_db("ndtees", $connection);

        $result = mysql_query($query, $connection);

        if (!$result)
        {
            die("Invalid query.");
        }

        $num_fields = mysql_num_fields($result);

        // Print table headers
        $deliveredIndex = -1;
        $activeIndex = -1;
        $shirtNameIndex=-1;
        echo "<tr>";
        for ($i = 0; $i < $num_fields; $i++)
        {
            $field = mysql_fetch_field($result);
            echo "<th>{$field->name}</th>";
            if ($field->name == "delivered")
            {
                $deliveredIndex = $i;
            }
            else if ($field->name == "active")
            {
                $activeIndex = $i;
            }
            else if($field->name == "shirtName")
            {
            	$shirtNameIndex = $i;
            }
        }
        echo "</tr>";

        // Print table data
        $rowCounter = 0;
        while($row = mysql_fetch_array($result))
        {
	        echo "<tr>";
            for($i = 0; $i < $num_fields; $i++)
        	{
                echo "<td>";
                if ($i == $deliveredIndex)
                {
                    echo "<span id='toggleDeliveredText".$row["purchaseID"]."'>$row[$i]</span>";
                    echo "<button id='toggleDeliveredButton".$row["purchaseID"]."' class='toggleDeliveredButton' style='font-size: 10px; margin-left: 10px; background-color: #2F4F2F;' onClick='toggleDelivered(".$row["purchaseID"].")'>Toggle</button>";
                }
                else if ($i == $activeIndex)
                {
                    echo "<span id='toggleActiveText".$row["shirtID"]."'>$row[$i]</span><br />";
                    echo "<button id='toggleActiveButton".$row["shirtID"]."' class='toggleActiveButton' style='font-size: 10px; background-color: #2F4F2F;' onClick='toggleActive(".$row["shirtID"].")'>Toggle</button>";
                }
                else if ($i == $shirtNameIndex)
                {
                	echo "<a class='shirtUpdatorLink' href='shirtUpdator.php?shirtID=" . $row["shirtID"] . "'>$row[$i]</a>";
                }
                else
                {
                    echo $row[$i];
                }
                echo "</td>";
            }
            echo "</tr>";
            $rowCounter = $rowCounter + 1;
        }

        echo "</table>\n";
    }

    function printAllTables()
    {
        printTable("Shirt", "SELECT * FROM Shirt");
        echo "<br />";
        printTable("Purchase", "SELECT * FROM Purchase");
        echo "<br />";
        printTable("Client", "SELECT * FROM Client");
    }

    function printSummary()
    {
        printTable("Summary", "SELECT COUNT(DISTINCT S.shirtID) numShirts, SUM(DISTINCT S.pageHits) pageHits, SUM(DISTINCT S.inceptionCount) inceptionCount, COUNT(DISTINCT P.purchaseID) numSold, SUM(P.delivered) numDelivered, COUNT(DISTINCT P.purchaseID) - SUM(P.delivered) numUndelivered, COUNT(DISTINCT C.clientID) numClients FROM Shirt S LEFT JOIN Purchase P ON S.shirtID = P.shirtID LEFT JOIN Client C ON S.clientID = C.clientID");
        echo "<br />";
    }

    function printShirtDetail($currentShirtID)
    {
        echo "<p class='generalHeader' style='font-size: 28px;'>Shirt Selection</p>";
        echo "<select id='shirtDetailSelect' class='validInput' name='shirtID' onChange='updateShirtDetail()' style='width: 200px;'>";
        $connection = mysql_connect("localhost", "root", $rootPassword);
        if (!$connection)
        {
            die("Could not connect to database: " . mysql_error());
        }

        mysql_select_db("ndtees", $connection);

        $result = mysql_query("SELECT shirtID, shirtName FROM Shirt", $connection);

        while($row = mysql_fetch_array($result))
        {
            if ($row["shirtID"] == $currentShirtID)
            {
                echo "<option value=".$row["shirtID"]." selected='selected'>".$row["shirtName"]."</option>";
            }
            else
            {
                echo "<option value=".$row["shirtID"].">".$row["shirtName"]."</option>";
            }
        }

        echo "</select>";
        echo "<br /><br />";
        printTable("Overview", "SELECT S.shirtID, S.shirtName, S.pageHits, S.inceptionCount, COUNT(P.purchaseID) numSold, SUM(P.delivered) numDelivered, COUNT(DISTINCT P.purchaseID) - SUM(P.delivered) numUndelivered, S.sCount + S.mCount + S.lCount + S.xlCount stock FROM Shirt S LEFT JOIN Purchase P ON S.shirtID = P.shirtID WHERE S.shirtID = ".$currentShirtID);
        echo "<br />";
        printTable("Shirt", "SELECT shirtType, price, color, active, creationDate, clientInvestment, ourInvestment, sCount, mCount, lCount, xlCount, imagePath, laundryBagPath FROM Shirt WHERE shirtID = ".$currentShirtID);
        echo "<br />";
        printTable("Client", "SELECT C.clientID, C.clientName, C.email FROM Shirt S, Client C WHERE S.clientID = C.clientID AND S.shirtID = ".$currentShirtID);
        echo "<br />";
        printTable("Purchases", "SELECT P.purchaseID, P.customerName, P.address, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE S.shirtID = P.shirtID AND S.shirtID = ".$currentShirtID) . " ORDER BY P.purchaseID";
        echo "<br />";
    }

    function printDelivered($filter)
    {
        echo "<p class='generalHeader'  style='font-size: 28px;'>Filter</p>";
        echo "<select id='deliveredFilterSelect' class='validInput' name='deliveredFilter' onChange='updateDeliveredFilter()' style='width: 200px;'>";
        if (($filter == "") or ($filter == "all"))
        {
            echo "<option value='all' selected='selected'>All delivered</option>";
            echo "<option value='dorm'>Delivered by dorm</option>";
            echo "<option value='quad'>Delivered by quad</option>";
        }
        else if ($filter == "dorm")
        {
            echo "<option value='all'>All delivered</option>";
            echo "<option value='dorm' selected='selected'>Delivered by dorm</option>";
            echo "<option value='quad'>Delivered by quad</option>";
        }
        else if ($filter == "quad")
        {
            echo "<option value='all'>All delivered</option>";
            echo "<option value='dorm'>Delivered by dorm</option>";
            echo "<option value='quad' selected='selected'>Delivered by quad</option>";
        }
        echo "</select>";
        echo "<br /><br />";

        if (($filter == "") or ($filter == "all"))
        {
            printTable("Delivered", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 ORDER BY P.purchaseID");
        }
        else if ($filter == "dorm")
        {
            printDeliveredByDorm();
        }
        else if ($filter == "quad")
        {
            printDeliveredByQuad();
        }
    }

    function printDeliveredByDorm()
    {
        $dorms = array("Alumni","Badin","Breen Phillips","Carroll","Cavanaugh","Dillon","Duncan","Farley","Fisher","Howard","Keenan","Keough","Knott","Lewis","Lyons","McGlinn","Morrissey","O'Neill","Pangborn","PE","PW","Ryan","St. Edward's","Siegfried","Sorin","Stanford","Walsh","Welsh Fam","Zahm");
        $dormsShort = array("alumni","badin","breenPhillips","carroll","cavanaugh","dillon","duncan","farley","fisher","howard","keenan","keough","knott","lewis","lyons","mcglinn","morrissey","oneill","pangborn","pe","pw","ryan","stEdward","siegfried","sorin","stanford","walsh","welsh","zahm");
        for ($i = 0; $i < 29; $i++)
        {
       	    printTable($dorms[$i], "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND P.address LIKE '% " . $dormsShort[$i] . "' ORDER BY P.address");
            echo "<br />";
        }
    }

    function printDeliveredByQuad()
    {
        printTable("God Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND (P.address LIKE '% sorin' OR P.address LIKE '% walsh')");
        echo "<br />";
       	printTable("Mod Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND (P.address LIKE '% knott' OR P.address LIKE '% pe' OR P.address LIKE '% pw' OR P.address LIKE '% siegfried' OR P.address LIKE '% welsh')");
        echo "<br />";
       	printTable("North Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND (P.address LIKE '% breenPhillips' OR P.address LIKE '% cavanaugh' OR P.address LIKE '% farley' OR P.address LIKE '% keenan' OR P.address LIKE '% lewis' OR P.address LIKE '% stanford' OR P.address LIKE '% zahm')");
        echo "<br />";
       	printTable("South Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND (P.address LIKE '% alumni' OR P.address LIKE '% badin' OR P.address LIKE '% carroll' OR P.address LIKE '% dillon' OR P.address LIKE '% fisher' OR P.address LIKE '% howard' OR P.address LIKE '% lyons' OR P.address LIKE '% morrissey' OR P.address LIKE '% pangborn')");
        echo "<br />";
       	printTable("West Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 1 AND (P.address LIKE '% duncan' OR P.address LIKE '% keough' OR P.address LIKE '% mcglinn' OR P.address LIKE '% oneill' OR P.address LIKE '% ryan' OR P.address LIKE '% welsh')");
    }

    function printUndelivered($filter)
    {
        echo "<p class='generalHeader'  style='font-size: 28px;'>Filter</p>";
        echo "<select id='undeliveredFilterSelect' class='validInput' name='undeliveredFilter' onChange='updateUndeliveredFilter()' style='width: 200px;'>";
        if (($filter == "") or ($filter == "all"))
        {
            echo "<option value='all' selected='selected'>All undelivered</option>";
            echo "<option value='dorm'>Undelivered by dorm</option>";
            echo "<option value='quad'>Undelivered by quad</option>";
        }
        else if ($filter == "dorm")
        {
            echo "<option value='all'>All undelivered</option>";
            echo "<option value='dorm' selected='selected'>Undelivered by dorm</option>";
            echo "<option value='quad'>Undelivered by quad</option>";
        }
        else if ($filter == "quad")
        {
            echo "<option value='all'>All undelivered</option>";
            echo "<option value='dorm'>Undelivered by dorm</option>";
            echo "<option value='quad' selected='selected'>Undelivered by quad</option>";
        }
        echo "</select>";
        echo "<br /><br />";

        if (($filter == "") or ($filter == "all"))
        {
            printTable("Undelivered", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 ORDER BY P.purchaseID");
        }
        else if ($filter == "dorm")
        {
            printUndeliveredByDorm();
        }
        else if ($filter == "quad")
        {
            printUndeliveredByQuad();
        }
    }

    function printUndeliveredByDorm()
    {
        $dorms = array("Alumni","Badin","Breen Phillips","Carroll","Cavanaugh","Dillon","Duncan","Farley","Fisher","Howard","Keenan","Keough","Knott","Lewis","Lyons","McGlinn","Morrissey","O'Neill","Pangborn","PE","PW","Ryan","St. Edward's","Siegfried","Sorin","Stanford","Walsh","Welsh Fam","Zahm");
        $dormsShort = array("alumni","badin","breenPhillips","carroll","cavanaugh","dillon","duncan","farley","fisher","howard","keenan","keough","knott","lewis","lyons","mcglinn","morrissey","oneill","pangborn","pe","pw","ryan","stEdward","siegfried","sorin","stanford","walsh","welsh","zahm");
        for ($i = 0; $i < 29; $i++)
        {
       	    printTable($dorms[$i], "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND P.address LIKE '% " . $dormsShort[$i] . "' ORDER BY P.address");
            echo "<br />";
        }
    }

    function printUndeliveredByQuad()
    {
        printTable("God Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND (P.address LIKE '% sorin' OR P.address LIKE '% walsh')");
        echo "<br />";
       	printTable("Mod Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND (P.address LIKE '% knott' OR P.address LIKE '% pe' OR P.address LIKE '% pw' OR P.address LIKE '% siegfried' OR P.address LIKE '% welsh')");
        echo "<br />";
       	printTable("North Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND (P.address LIKE '% breenPhillips' OR P.address LIKE '% cavanaugh' OR P.address LIKE '% farley' OR P.address LIKE '% keenan' OR P.address LIKE '% lewis' OR P.address LIKE '% stanford' OR P.address LIKE '% zahm')");
        echo "<br />";
       	printTable("South Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND (P.address LIKE '% alumni' OR P.address LIKE '% badin' OR P.address LIKE '% carroll' OR P.address LIKE '% dillon' OR P.address LIKE '% fisher' OR P.address LIKE '% howard' OR P.address LIKE '% lyons' OR P.address LIKE '% morrissey' OR P.address LIKE '% pangborn')");
        echo "<br />";
       	printTable("West Quad", "SELECT P.purchaseID, P.customerName, P.address, S.shirtName, P.shirtSize, P.delivered FROM Shirt S, Purchase P WHERE P.shirtID = S.shirtID AND P.delivered = 0 AND (P.address LIKE '% duncan' OR P.address LIKE '% keough' OR P.address LIKE '% mcglinn' OR P.address LIKE '% oneill' OR P.address LIKE '% ryan' OR P.address LIKE '% welsh')");
    }
?>
