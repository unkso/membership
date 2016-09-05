-- Create the Unit table
CREATE TABLE wcf1_unkso_unit (
    unitID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    -- Add icon!
    parentID INT(10),
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    extraData TEXT,
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_unit 
    ADD FOREIGN KEY (parentID)
    REFERENCES wcf1_unkso_unit (unitID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;