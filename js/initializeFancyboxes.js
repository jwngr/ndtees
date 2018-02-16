$(document).ready(function() {
    // Create the purchase fancybox
    $("a.card").fancybox({
	    scrolling: "no",
		overlayColor: "#000",
		overlayOpacity: ".5",
        speedIn: 200,
	    speedOut: 200,
        onStart: function(html) {
            // Update the page hits count
            var shirtID = String(html).split("=")[1];
            var cardID = "#card" + (parseInt(shirtID) - 1);
            var value = parseInt($(cardID).find(".tokenValueText:first").text()) + 1;
            $(cardID).find(".tokenValueText:first").html(value);
        }
	});
                
    // Create the contact us fancybox
    $("#contactUsLink").fancybox({
		scrolling: "no",
		overlayColor: "#000",
		overlayOpacity: ".5",
        speedIn: 200,
		speedOut: 200
	});
                
    // Create the client submission fancybox
    $("#clientSubmissionLink").fancybox({
		scrolling: "no",
		overlayColor: "#000",
		overlayOpacity: ".5",
        speedIn: 200,
		speedOut: 200
	});
				
    // Create the philosophy fancybox
    $("#ourPhilosophyLink").fancybox({
		scrolling: "no",
		overlayColor: "#000",
		overlayOpacity: ".5",
        speedIn: 200,
		speedOut: 200
	});
});
