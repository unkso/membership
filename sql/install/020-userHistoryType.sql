-- Create the User History Type table
CREATE TABLE wcf1_unkso_user_history_type (
    historyTypeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    displayName VARCHAR(255) NOT NULL,
    packageID INT(10) NOT NULL,
    displayTemplate MEDIUMTEXT,
    identifier VARCHAR(255) NOT NULL UNIQUE,
    classPath VARCHAR(255) NOT NULL
);