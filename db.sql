
DROP DATABASE IF EXISTS espace_membres; 
CREATE DATABASE IF NOT EXISTS espace_membres; 
USE espace_membres; 


-- CREATE USER IF NOT EXISTS 'malik'@'localhost' IDENTIFIED BY 'nabila'; 
-- GRANT ALL ON espace_membres.* TO 'malik'@'localhost';

CREATE TABLE Adherents(
    AdherentID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NULL,
    prenom VARCHAR(100) NULL,
    pseudo varchar(250) NOT NULL,
    mail varchar(250) NOT NULL,
    numero varchar(250) NULL,
    Addresse1 varchar(250) NULL,
    code_postal INT (5) NULL,
    ville VARCHAR(255) NULL,
    dateAdhesion date DEFAULT NULL,
    motdepasse VARCHAR(250) NOT NULL

    
)ENGINE=InnoDB;

CREATE TABLE Interets(
    InteretID INT(255) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL
 
)ENGINE=InnoDB;


CREATE TABLE interetAdherent(
    CentreInteretID INT(25)  NOT NULL,
    AdherentID INT(25)  NOT NULL, 
    PRIMARY KEY(CentreInteretID, AdherentID),

    CONSTRAINT Adherents_FK FOREIGN KEY (AdherentID) REFERENCES Adherents(AdherentID),
    CONSTRAINT Interets_FK FOREIGN KEY(CentreInteretID) REFERENCES Interets(InteretID)

)ENGINE=InnoDB;



CREATE TABLE Profils(
    ProfilID INT(11)  NOT NULL AUTO_INCREMENT,
    Titre VARCHAR(100) NULL,
    Photo VARCHAR(100) NULL,
    Description TEXT(100) NOT NULL,
    AdherentID int(25) NOT NULL,
    PRIMARY KEY(ProfilID), 

     CONSTRAINT Profils_FK FOREIGN KEY (AdherentID) REFERENCES Adherents(AdherentID) 
)ENGINE=InnoDB;


-- INSERT INTO Adherents(pseudo, mail, motdepasse) VALUES ('malik', "malik@gmail.com", "123"); 

       -- CONSTRAINT interetAdherent     - On donne un nom à notre clé
       -- FOREIGN KEY (CentreInteretID)  - Colonne sur laquelle on crée la clé
       -- REFERENCES Interets(InteretID) - Colonne de référence

INSERT INTO Adherents(nom, prenom, pseudo, mail, numero, Addresse1, code_postal, ville, dateAdhesion, motdepasse) 
VALUES ('tantast', 'nabila', 'nabila', 'nabila@gmail.com', '0609074376', 'boulevard andré aune', '13006', 'Marseille', '2021-01-28', 'malik'); 