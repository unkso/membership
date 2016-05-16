-- Create the Unit Position table
CREATE TABLE wcf1_unkso_unit_position (
    unitPositionID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    unitID INT(10) NOT NULL,
    userID INT(10), -- Can be NULL (= Vacant)
    name VARCHAR(255),
    title VARCHAR(255),
    priority INT(10) -- Larger = Higher position in the clan
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_unit_position 
    ADD FOREIGN KEY (unitID)
    REFERENCES wcf1_unkso_unit (parentID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
        
ALTER TABLE wcf1_unkso_unit_position 
    ADD FOREIGN KEY (userID) 
    REFERENCES wcf1_user (userID) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE;