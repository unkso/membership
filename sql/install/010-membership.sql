-- Create the Membership table
CREATE TABLE wcf1_unkso_membership (
    membershipID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userID INT(10) NOT NULL,
    previousMembershipID INT(10),
    currentRankID INT(10) NOT NULL,
    currentStatus ENUM('A15', 'AWOL', 'LOA', 'Inactive Reserve', 'Active') NOT NULL,
    joinDate DATE NOT NULL,
    dischargeDate DATE,
    dischargeType ENUM('RET', 'HON', 'GEN', 'OTH', 'DIS')
);

-- Add Constraints for Foreign Keys
ALTER TABLE wcf1_unkso_membership 
    ADD FOREIGN KEY (userID) 
    REFERENCES wcf1_user (userID) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE;
        
ALTER TABLE wcf1_unkso_membership 
    ADD FOREIGN KEY (previousMembershipID)
    REFERENCES wcf1_unkso_membership (membershipID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
        
ALTER TABLE wcf1_unkso_membership 
    ADD FOREIGN KEY (currentRankID) 
    REFERENCES wcf1_unkso_rank (rankID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT;
