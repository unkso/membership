-- Create the Unit Member table
CREATE TABLE wcf1_unkso_unit_member (
    unitMemberID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    unitID INT(10) NOT NULL,
    userID INT(10) NOT NULL,
    isPrimaryPosition TINYINT(1) DEFAULT 1,
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_unit_member 
    ADD FOREIGN KEY (unitID)
    REFERENCES wcf1_unkso_unit (parentID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
        
ALTER TABLE wcf1_unkso_unit_member 
    ADD FOREIGN KEY (userID) 
    REFERENCES wcf1_user (userID) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE;