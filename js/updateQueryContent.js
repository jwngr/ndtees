$(document).ready(function() {
    $("#customQueryButton").click(function() {
        $(".commonQueryButton").css("background-color", "#006600");
        $("#queryContent").empty();
    	var query = $("input#queryInput").val();
	    var data = "query=" + query + "&title=" + query;
        $.ajax({
		    type: "POST",
            url: "../diagnostic/printTable.php",
            data: data,
            success: function(html) {
                $("#queryContent").append(html);
            }
        });
    });
    
    $(".commonQueryButton").click(function() {
        $(".commonQueryButton").css("background-color", "#006600");
        $(this).css("background-color", "#00BB00");
        $("#queryContent").empty();
    	var query = $(this).val();
    	var title = $(this).html();
	    var data = "query=" + query +"&title=" + title;
        $.ajax({
		    type: "POST",
            url: "../diagnostic/printTable.php",
            data: data,
            success: function(html) {
                $("#queryContent").append(html);
            }
        });
    });
});

function toggleDelivered(purchaseID)
{
    var data = "purchaseID=" + purchaseID;

    $.ajax({
	    type: "POST",
        url: "../diagnostic/toggleDelivered.php",
        data: data
    });

    var deliveredValue = $("#toggleDeliveredText" + purchaseID).html();
    if (deliveredValue == 0)
    {
        $("#toggleDeliveredText" + purchaseID).html("1");
    }
    else
    {
        $("#toggleDeliveredText" + purchaseID).html("0");
    }
}

function toggleActive(shirtID)
{
    var data = "shirtID=" + shirtID;

    $.ajax({
	    type: "POST",
        url: "../diagnostic/toggleActive.php",
        data: data
    });

    var activeValue = $("#toggleActiveText" + shirtID).html();
    if (activeValue == 0)
    {
        $("#toggleActiveText" + shirtID).html("1");
    }
    else
    {
        $("#toggleActiveText" + shirtID).html("0");
    }
}

function updateShirtDetail()
{
    var shirtID = $("select#shirtDetailSelect option:selected").val();
    $("#queryContent").empty();
    var title = "Shirt Detail";
	var data = "shirtID=" + shirtID + "&title=" + title;
    $.ajax({
	    type: "POST",
        url: "../diagnostic/printTable.php",
        data: data,
        success: function(html) {
            $("#queryContent").append(html);
        }
    });
}

function updateDeliveredFilter()
{
    var filter = $("select#deliveredFilterSelect option:selected").val();
    $("#queryContent").empty();
    var data = "title=Delivered&filter=" + filter;
    $.ajax({
	    type: "POST",
        url: "../diagnostic/printTable.php",
        data: data,
        success: function(html) {
            $("#queryContent").append(html);
        }
    });
}

function updateUndeliveredFilter()
{
    var filter = $("select#undeliveredFilterSelect option:selected").val();
    $("#queryContent").empty();
    var data = "title=Undelivered&filter=" + filter;
    $.ajax({
	    type: "POST",
        url: "../diagnostic/printTable.php",
        data: data,
        success: function(html) {
            $("#queryContent").append(html);
        }
    });
}
