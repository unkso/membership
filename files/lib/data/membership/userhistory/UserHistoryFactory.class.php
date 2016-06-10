<?php
namespace wcf\data\membership\userhistory;

use wcf\data\membership\Membership;
use wcf\data\membership\userhistory\type\UserHistoryType;
use wcf\data\user\User;
use wcf\system\WCF;

// Always use the UserHistoryFactory to retrieve User Histories!
abstract class UserHistoryFactory
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

    public static function getMembershipHistoryWithType(Membership $membership, $class)
    {
        $identifier = $class::getIdentifier();

        $typeTableName    = UserHistoryType::getDatabaseTableName();
        $typeIndexName    = UserHistoryType::getDatabaseTableIndexName();
        $historyTableName = BasicUserHistory::getDatabaseTableName();

        $membershipIndexName = Membership::getDatabaseTableIndexName();

        $sql = "SELECT	$historyTableName.*
				FROM	$historyTableName
				JOIN    $typeTableName
				ON      $historyTableName.$typeIndexName = $typeTableName.$typeIndexName
				WHERE	$historyTableName.membershipID = ? AND $typeTableName.identifier = ?";

        $statement = WCF::getDB()->prepareStatement($sql);

        $statement->execute([$membership->$membershipIndexName, $identifier]);
        $results = $statement->fetchObjects($class);

        return $results;
    }
}