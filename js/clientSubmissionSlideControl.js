$(document).ready(function() {
    $(".clientSubmissionForm").cycle( {
	    fx: "scrollVert",
	    timeout: 0,
	    rev: 1
    });
	
    // Set the default tee color picker
    $("#tankColorPicker").hide();
});

// Update the color picker when the shirt type is changed
$('select#shirtType').change(function() {
    // Clear the currently selected color option
    $(".colorPickerOptionSelected").removeClass("colorPickerOptionSelected");

    // Switch the selected color picker
	if($("select#shirtType").val() == "tee")
    {
    	$("#tankColorPicker").hide();
	    $("#teeColorPicker").show();
    	$("#cTeeIrish").addClass("colorPickerOptionSelected");
    }
	else if($("select#shirtType").val() == "tank")
    {
    	$("#teeColorPicker").hide();
	    $("#tankColorPicker").show();
    	$("#cTankWhite").addClass("colorPickerOptionSelected");
    }
	
    // Update the selected color
	$("#selectedColor").html($(".colorPickerOptionSelected").attr("name"));
});

// Update the selected color option when a color option is clicked
$(".colorPickerOption").click(function() {
    // Clear the currently selected color option
    $(".colorPickerOptionSelected").removeClass("colorPickerOptionSelected");
	
    // Set the clicked color option to the selected color option
    $(this).addClass("colorPickerOptionSelected");
	$("#selectedColor").html($(this).attr("name"));
});

function copyFileLocation()
{
    $("#shirtImage").val($("#shirtImageHidden").val());	
}

$("#clientSubmissionButtonBack").click(function() {
	$(".clientSubmissionForm").cycle("prev");
});

$("#clientSubmissionButton1").click(function() {
	// Get the necessary client submission input data
	var clientName = $("input#clientName").val();
	var clientEmail = $("input#clientEmail").val();
	var shirtName = $("input#shirtName").val();

	// Clear any styling for invalid elements
	$("input#clientName").removeClass("invalidInput");
	$("input#clientEmail").removeClass("invalidInput");
	$("input#shirtName").removeClass("invalidInput");

	// Initially set the client submission form validity to true
	var valid = true;

	// Validate the client name
	var nameReg = /^[a-zA-Z-'\s]+?$/;
	if (!nameReg.test(clientName))
	{
		$("input#clientName").addClass("invalidInput");
		valid = false;
	}

	// Validate the client email
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if ((clientEmail == "") || (!emailReg.test(clientEmail)))
	{
		$("input#clientEmail").addClass("invalidInput");
		valid = false;
	}
	
    // Validate the shirt name
	if (!nameReg.test(shirtName))
	{
		$("input#shirtName").addClass("invalidInput");
		valid = false;
	}

	// If all the data is valid, move to the second part of the client submission form page
	if (valid == true)
	{
		$(".clientSubmissionForm").cycle("next");
	}
});

$("#clientSubmissionButton2").click(function() {
	// Get the necessary client submission input data
	var clientName = $("input#clientName").val();
	var clientEmail = $("input#clientEmail").val();
	var shirtName = $("input#shirtName").val();
	var shirtType = $("select#shirtType").val();
	var shirtColor = $("#selectedColor").html();
	var shirtImage = $("input#shirtImage").val();
	var laundryBag = $("textarea#laundryBag").val();
	var shirtPrice = $("select#shirtPrice").val();

	// Clear any styling for invalid elements
	$("input#shirtImage").removeClass("invalidInput");
	$("textarea#laundryBag").removeClass("invalidInput");

	// Initially set the client submission form validity to true
	var valid = true;
	
    // Validate the shirt image
	if (shirtImage == "")
	{
		$("input#shirtImage").addClass("invalidInput");
		valid = false;
	}

	// Validate the laundry bag
    var laundryBagReg = /^[^;]+$/;
	if (!laundryBagReg.test(laundryBag))
	{
		$("textarea#laundryBag").addClass("invalidInput");
		valid = false;
	}

	// If all the data is valid, submit it to the database and move to the thank you page
	if (valid == true)
	{
		var data = "clientName=" + clientName + "&clientEmail=" + clientEmail + "&shirtPrice=" + shirtPrice + "&shirtName=" + shirtName + "&shirtType=" + shirtType + "&laundryBag=" + laundryBag + "&shirtColor=" + shirtColor;
		$.ajax({
			type: "POST",
			url: "submission/clientProcess.php",
			data: data
		});

		$(".clientSubmissionForm").cycle("next");	
	}
});
