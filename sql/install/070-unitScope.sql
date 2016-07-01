-- Create the Unit Scope table
CREATE TABLE wcf1_unkso_unit_scope (
    unitScopeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    title VARCHAR(255),
    headUnitID INT(10),           -- Head end of scope
    headUnitPositionID INT(10),   -- Head end of scope
);

-- Each unit has a head and 0..n tails

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_unit_scope
    ADD FOREIGN KEY (headUnitID)
    REFERENCES wcf1_unkso_unit (unitID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE wcf1_unkso_unit_scope
    ADD FOREIGN KEY (headUnitPositionID)
    REFERENCES wcf1_unkso_unit_position (unitPositionID)
        ON UPDATE CASCADE
        ON DELETE CASCADE;