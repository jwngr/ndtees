<html>
	<head>
        <title>NDTees | Shamrock Diagnostic Interface</title>

        <!-- Favicon -->
        <link rel="shorcut icon" type="image/x-icon" href="../images/miscellaneous/favicon.ico">

        <!-- CSS files -->
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/diagnostic.css" />

        <!-- JavaScript files -->
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="../js/updateQueryContent.js"></script>

        <!-- PHP files -->
        <?php
            include("printTable.php");
        ?>
	</head>

	<body>
        <!-- Page header -->
		<center><p class="generalHeader">Shamrock Diagnostic Interface</p></center>

        <!-- Validate user credentials -->
        <?php
        	$user = $_POST["username"];
        	$password = $_POST["password"];
        	if (($user != "ndtees") || ($password != $ndteesPassword))
        	{
        		die("<p>User credentials incorrect!</p>");
        	}
        ?>

        <!-- SQL Query -->
        <div id="customQueryContainer">
            <label class="generalHeader" for="queryInput" style="font-size: 28px;">SQL Query</label>
            <input id="queryInput" class="validInput" type="text" value="" name="query" size="80" />
       	    <button id="customQueryButton">Query</button>
		</div>

        <!-- Common queries -->
        <div id="commonQueryContainer">
            <p class="generalHeader" style="font-size: 28px;">Tables</p>
            <button id="allTablesQueryButton" class="commonQueryButton">All</button>
       	    <button id="shirtsQueryButton" class="commonQueryButton" value="SELECT * from Shirt">Shirt</button>
           	<button id="purchasesQueryButton" class="commonQueryButton" value="SELECT * from Purchase">Purchase</button>
           	<button id="clientsQueryButton" class="commonQueryButton" value="SELECT * from Client">Client</button>
		    <br /><br />
            <p class="generalHeader" style="font-size: 28px;">Common Queries</p>
           	<button id="summaryQueryButton" class="commonQueryButton">Summary</button>
           	<button id="shirtDetailQueryButton" class="commonQueryButton">Shirt Detail</button>
       	    <button id="deliveredQueryButton" class="commonQueryButton">Delivered</button>
       	    <button id="undeliveredQueryButton" class="commonQueryButton">Undelivered</button>
		</div>

        <!-- Query content -->
        <div id="queryContent">
            <?php printAllTables(); ?>
        </div>
    </body>
</html>
