create table Shirt
(
    shirtID int(5) NOT NULL AUTO_INCREMENT,
    clientID int(5) NOT NULL,
    shirtName varchar(50) NOT NULL,
    shirtType varchar(10) NOT NULL,
    price decimal(4,2) NOT NULL,
    color varchar(10) NOT NULL,
	active bool NOT NULL,
    creationDate datetime NOT NULL,

    clientInvestment decimal(7,2) NOT NULL,
    ourInvestment decimal(7,2) NOT NULL,

    sCount int(5) NOT NULL,
    mCount int(5) NOT NULL,
    lCount int(5) NOT NULL,
    xlCount int(5) NOT NULL,

    pageHits int(5) NOT NULL,
    inceptionCount int(5) NOT NULL,  
    
    imagePath varchar(44) NOT NULL,
    laundryBagPath varchar(44) NOT NULL,

    PRIMARY KEY (shirtID),
    FOREIGN KEY (clientID) REFERENCES Client(clientID)
);
