<?php
namespace wcf\data\membership;

use wcf\data\DatabaseObject;
use wcf\data\user\User;

class Membership extends DatabaseObject
{
	protected static $databaseTableName = 'unkso_membership';
	
	protected static $databaseTableIndexName = 'membershipID';
    
    public function getUser()
    {
        return new User($this->userID);
    }
    
    public function isRetired()
    {
        return $this->dischargeType == 'RET';
    }
    
    public function isActive()
    {
        return is_null($this->dischargeDate);
    }
}