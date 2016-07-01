-- Create the Unit Scope Tails table
CREATE TABLE wcf1_unkso_unit_scope_tail (
    unitScopeTailID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    unitScopeID VARCHAR(255),
    tailUnitID INT(10),           -- Tail end of scope
    tailUnitPositionID INT(10),   -- Tail end of scope
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_unit_scope_tail
    ADD FOREIGN KEY (unitScopeID)
    REFERENCES wcf1_unkso_unit_scope (unitScopeID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE wcf1_unkso_unit_scope_tail
    ADD FOREIGN KEY (tailUnitID)
    REFERENCES wcf1_unkso_unit (unitID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE wcf1_unkso_unit_scope_tail
    ADD FOREIGN KEY (tailUnitPositionID)
    REFERENCES wcf1_unkso_unit_position (unitPositionID)
        ON UPDATE CASCADE
        ON DELETE CASCADE;