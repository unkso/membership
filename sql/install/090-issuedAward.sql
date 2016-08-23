-- Create the Unit Scope Tails table
CREATE TABLE wcf1_unkso_issued_award (
    issuedAwardID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userID INT(10) NOT NULL,
    tierID INT(10) NOT NULL,
    description TEXT,
    date DATE,
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_issued_award
    ADD FOREIGN KEY (userID)
    REFERENCES wcf1_user (userID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

-- Can't install with this for some reason...
-- ALTER TABLE wcf1_unkso_issued_award
--     ADD FOREIGN KEY (tierID)
--     REFERENCES wcf1_unkso_award_tier (tierID)
--         ON UPDATE CASCADE
--         ON DELETE RESTRICT;