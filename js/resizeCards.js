/* Resizes the product cards such that they span the entire width of any screen */
function resizeCards()
{
    // Get the available width for the product cards
    var totalAvailableWidth = $(window).width() - 110;
    
    // Determine how many cards fit across the width, ensuring each has at least a certain width
    var cardHeight = 0;
    var numCards = 10;
    while (cardHeight <= (250 + (16 * 2)))
    {
        cardHeight = (totalAvailableWidth - (34 * numCards)) / numCards;
        numCards = numCards - 1;
    }

    // Update the width and height of the necessary elements
    $(".card").width(cardHeight - 32);
    $(".card").height(cardHeight - 2);
    $(".cardImage").width(cardHeight - 32);
    $(".cardImage").height(cardHeight - 32);
    $(".cardLabel").width(cardHeight - 32);
};
