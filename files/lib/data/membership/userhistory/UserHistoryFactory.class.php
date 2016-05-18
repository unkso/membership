<?php
namespace wcf\data\membership\userhistory;

use wcf\data\membership\userhistory\type\UserHistoryType;
use wcf\data\user\User;
use wcf\system\WCF;

// Always use the UserHistoryFactory to retrieve User Histories!
class UserHistoryFactory
{    
    /**
     * We're here to make history!
     * @return AbstractUserHistory
     */
    public static function makeHistory($id)
    {
        $userHistory = new BasicUserHistory($id);
        $historyClass = $userHistory->getHistoryType()->classPath;
        
        return new $historyClass(null, null, $userHistory);
    }
    
    public static function getUserHistory(User $id)
    {
        
    }
}