-- Create the User History table
CREATE TABLE wcf1_unkso_user_history (
    historyID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    membershipID INT(10) NOT NULL,
    date DATE NOT NULL,
    metadata LONGTEXT DEFAULT '{}', -- This has to be valid JSON
    historyTypeID INT(10) NOT NULL
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_user_history 
    ADD FOREIGN KEY (membershipID)
    REFERENCES wcf1_unkso_membership (membershipID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
        
ALTER TABLE wcf1_unkso_user_history 
    ADD FOREIGN KEY (historyTypeID) 
    REFERENCES wcf1_unkso_user_history_type (historyTypeID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
