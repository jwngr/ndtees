create table Purchase
(
    purchaseID int(7) NOT NULL AUTO_INCREMENT,
    shirtID int(5) NOT NULL,

    price decimal(5,2) NOT NULL,
    shirtSize varchar(4) NOT NULL,

    orderDate datetime,
	delivered bool NOT NULL,
    
    email varchar(40) NOT NULL,
    customerName varchar(30) NOT NULL,
    address varchar(200) NOT NULL,
	onCampus bool DEFAULT TRUE NOT NULL,
	isReserved bool NOT NULL,

    PRIMARY KEY (purchaseID),
    FOREIGN KEY (shirtID) REFERENCES Shirt(shirtID)
);
