/* Set the up the projection cycle */
$(document).ready(function() {
    $(".projectionRight").cycle( {
    	fx: "scrollUp",
	    timeout: 0
	});
});

/* On click event for the first projection slide */
$("#purchaseButton").click(function() {
    // Get the shirt ID and inception count
	var shirtID = $("img.projectionLeftImg").attr("id");
	var inceptionCount = $("span#inceptionCount").attr("value");
		
	// Send the data via ajax to a script which will put it in the database
	var data = "shirtID=" + shirtID + "&count=" + inceptionCount;
	$.ajax({
		type: "POST",
		url: "submission/inceptionProcess.php",
		data: data
	});
    
    // Cycle to the purchase form
    $("div.projectionRight").cycle("next");
});

/* On click event for the purchase form */
$("#purchaseSubmitButton").click(function() {
    // Get the purchase form input data and the shirt ID and price
	var name = $("input#name").val();
	var email = $("input#customerEmail").val();
	var shirtSize = $("select#purchaseFormSizeSelect").val();
	var shirtID = $("img.projectionLeftImg").attr("id");
	var price = $("p.shirtPrice").attr("value");
    
    // Clear any styling on invalid elements
    $("input#name").removeClass("invalidInput");
    $("input#customerEmail").removeClass("invalidInput");
    $("input#roomNumber").removeClass("invalidInput");
    //$("input#offCampusAddress").removeClass("invalidInput");
    //$("input#offCampusAddress2").removeClass("invalidInput");
    
    // Initially set the purchase form validity to true
    var valid = true;
	
	//Get the address depending on which address type is being used
    if ($("#onCampusRadioButton").is(":checked"))
    {
        var address = $("input#roomNumber").val() + " " + $("select#purchaseFormDormSelect").val();
    }
    else
    {
        valid = false;
    }
    /*
    else
    {
		var address = $("input#offCampusAddress").val();
	}
    */

    // Validate the name input
    var nameReg = /^[a-zA-Z-'\s]+?$/;
    if (!nameReg.test(name))
    {
        $("input#name").addClass("invalidInput");
        valid = false;
    }
    
    // Validate the email input
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if ((email == "") || (!emailReg.test(email)))
    {
        $("input#customerEmail").addClass("invalidInput");
        valid = false;
    }
    
    // Validate the address inputs
    var roomNumberReg = /^[\d]+$/;
    if (!roomNumberReg.test($("input#roomNumber").val()))
	{
        $("input#roomNumber").addClass("invalidInput");
	    valid = false;
	}

    // If the purchase form contains valid data, submit it to the database and move to the thank you page
    if (valid == true)
    {
    	// Send the data via ajax to a script which will put it in the database
	    var data = "customerEmail=" + email + "&shirtID=" + shirtID + "&shirtSize=" + shirtSize + "&name=" + name + "&address=" + address + "&price=" + price;
	    $.ajax({
    		type: "POST",
	    	url: "submission/purchaseProcess.php",
    		data: data
	    });
	    
	    // Also, send the confirmation email via ajax
	    var shirtName = $("p#shirtName").val();
	    var data2 = "email=" + email + "&shirtName=" + shirtName + "&shirtSize=" + shirtSize + "&name=" + name + "&address=" + address + "&price=" + price;
	    $.ajax({
    		type: "POST",
	    	url: "confirmationEmail.php",
    		data: data2
	    });
        
        // Move to the thank you page
        $(".projectionRight").cycle("next");
    }
});
