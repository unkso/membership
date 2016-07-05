<?php
namespace wcf\data\membership;

use wcf\data\DatabaseObject;
use wcf\data\membership\userhistory\DemotionHistory;
use wcf\data\membership\userhistory\JoinHistory;
use wcf\data\membership\userhistory\PromotionHistory;
use wcf\data\membership\userhistory\UserHistoryFactory;
use wcf\data\rank\Rank;
use wcf\data\user\User;
use wcf\system\WCF;

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

    public function getRank()
    {
        return new Rank($this->currentRankID);
    }

    public function getDisplayableUsername()
    {
        $prefix = '';

        $rank = $this->getRank();
        if ($rank) {
            $prefix = $rank->prefix . '.';
        }

        return $prefix . $this->getUser()->getUsername();
    }

    public function getRankAtTime($time)
    {
        $containsNewRank = [
            PromotionHistory::class,
            DemotionHistory::class,
            JoinHistory::class,
        ];

        // Merge all history types that contain a 'newRank' field into one array of rank changes
        $changes = [];
        foreach ($containsNewRank as $class) {
            $changes = array_merge($changes, UserHistoryFactory::getMembershipHistoryWithType($this, $class));
        }

        // Sort by date (newest one first)
        usort($changes, function ($a, $b) {
            if ($a->date > $b->date)
                return -1;

            elseif ($a->date < $b->date)
                return 1;

            return 0;
        });

        // Run through and pick the first one before the given time that has a 'rank' attribute
        $newest = null;
        foreach ($changes as $change) {
            if ($change->date <= $time && isset($change->attributes['newRank'])) {
                $newest = $change;
                break;
            }
        }

        // Return null if we found nothing.
        if (!$newest) {
            return null;
        }

        return $newest->attributes['newRank'];
    }

    /**
     * @param User|null $user If the user is not provided, the currently logged in user will be used
     * @returns Membership|null
     */
    public static function getCurrentMembership(User $user = null)
    {
        if (!$user) {
            $user = WCF::getUser();
        }

        $tableName = self::getDatabaseTableName();

        $sql = "SELECT	*
				FROM	$tableName
				WHERE	userID = ?
				ORDER BY membershipID DESC LIMIT 1";

        $statement = WCF::getDB()->prepareStatement($sql);

        $statement->execute([$user->getUserID()]);
        $row = $statement->fetchObject(self::class);

        var_dump($row);
        die();

        return $row;
    }

    public static function activeMemberships()
    {
        $tableName = self::getDatabaseTableName();
        
        $sql = "SELECT  *
                FROM    $tableName
                WHERE   dischargeDate IS NULL";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();

        return $statement->fetchObjects(self::class);
    }
}