create table Client
(
    clientID int(7) NOT NULL AUTO_INCREMENT,
    
    email varchar(40) NOT NULL,
    clientName varchar(30) NOT NULL,

    PRIMARY KEY (clientID)
);
