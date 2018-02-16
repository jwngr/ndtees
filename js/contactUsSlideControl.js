$(document).ready(function() {
    $(".contactUsForm").cycle( {
	    fx: "scrollUp",
    	//speed: "slow",
	    timeout: 0
    });	
});
// On click event for the submit email button 
$("#emailSubmitButton").click(function() {
    // Get the contact us form input data
	var name = $("input#contactUsName").val();
	var email = $("input#contactUsEmail").val();
	var subject = $("input#contactUsSubject").val();
	var message = $("textarea#contactUsMessage").val();

    // Clear any styling on invalid elements
    $("input#contactUsName").removeClass("invalidInput");
    $("input#contactUsEmail").removeClass("invalidInput");
    $("input#contactUsSubject").removeClass("invalidInput");
    $("textarea#contactUsMessage").removeClass("invalidInput");
    
    // Initially set the contact us form validity to true
    var valid = true;

    // Validate the name input
    var nameReg = /^[a-zA-Z-'\s]+?$/;
    if (!nameReg.test(name))
    {
        $("input#contactUsName").addClass("invalidInput");
        valid = false;
    }
    
    // Validate the email input
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if ((email == "") || (!emailReg.test(email)))
    {
        $("input#contactUsEmail").addClass("invalidInput");
        valid = false;
    }
    
    // Validate the subject input
    var subjectReg = /^[^;]+$/;
    if (!subjectReg.test(subject))
    {
        $("input#contactUsSubject").addClass("invalidInput");
        valid = false;
    }
    
    // Validate the message input
    var messageReg = /^[^;]+$/;
    if (!messageReg.test(message))
    {
        $("textarea#contactUsMessage").addClass("invalidInput");
        valid = false;
    }

    // If the contact us form contains valid data, move to the thank you page
    if (valid == true)
    {
	    var data = "name=" + name + "&email=" + email + "&subject=" + subject + "&message=" + message;
        $.ajax({
		    type: "POST",
            url: "mail.php",
            data: data,
            cache: false
        });

        $(".contactUsForm").cycle("next");
    }
});
