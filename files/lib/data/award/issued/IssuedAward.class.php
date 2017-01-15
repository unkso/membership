<?php

namespace wcf\data\award\issued;

use wcf\data\award\Award;
use wcf\data\award\AwardCache;
use wcf\data\award\AwardTier;
use wcf\data\DatabaseObject;
use wcf\data\user\User;
use wcf\system\cache\builder\AwardCacheBuilder;
use wcf\system\user\notification\object\AwardReceivedUserNotificationObject;
use wcf\system\user\notification\UserNotificationHandler;
use wcf\system\WCF;

class IssuedAward extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_issued_award';

    protected static $databaseTableIndexName = 'issuedAwardID';

    public static function giveToUser(User $user, AwardTier $tier, $description, $date, $notify = true)
    {
        $action = new IssuedAwardAction([], 'create', [
            'data' => [
                'userID' => $user->getUserID(),
                'tierID' => $tier->getObjectID(),
                'description' => $description,
                'date' => $date,
            ]
        ]);
        $action->executeAction();
        $award = $action->getReturnValues()['returnValues'];

        $notificationObject = new AwardReceivedUserNotificationObject($award);
        UserNotificationHandler::getInstance()->fireEvent(
            'awardReceived',
            'com.clanunknownsoldiers.award.received',
            $notificationObject,
            [$award->userID],
            [
                'tierID' => $award->tierID,
            ]
        );
    }

    public function getTier()
    {
        $cache = AwardCacheBuilder::getInstance()->getData([], 'tiers');
        return $cache[$this->tierID];
    }

    public static function getAllAwardedTiersForUser(User $user)
    {
        $issued = self::getDatabaseTableName();
        $tier = AwardTier::getDatabaseTableName();
        $award = Award::getDatabaseTableName();

        $sql = "SELECT $issued.issuedAwardID, $issued.tierID FROM $issued 
                  JOIN $tier ON $tier.tierID = $issued.tierID 
                  JOIN $award ON $tier.awardID = $award.awardID 
                 WHERE $issued.userID = ?
                ORDER BY ($award.relevance * 100 + $tier.level) ASC";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$user->userID]);

        $tierList = AwardCacheBuilder::getInstance()->getData([], 'tiers');
        $issued = [];
        $tiers = [];
        while ($statement && $row = $statement->fetchArray()) {
            $issued[] = new self($row['issuedAwardID']);
        }

        return $issued;
    }

    public static function getHighestAwardedTiersForUser(User $user)
    {
        $issuedAwards = self::getAllAwardedTiersForUser($user);
        $highestAwards = [];

        foreach ($issuedAwards as $key => $issuedAward) {
            $tier = $issuedAward->getTier();
            if (isset($highestAwards[$tier->awardID]) && $highestAwards[$tier->awardID]->level >= $tier->level) {
                continue;
            }

            $highestAwards[$tier->awardID] = $issuedAward;
        }

        return $highestAwards;
    }

    public static function getAwardsForUser(User $user)
    {
        $tiers = self::getAllAwardedTiersForUser($user);
        $awards = [];
        foreach ($tiers as $tier) {
            $tier = $tier->getTier();
            $awards[] = $tier->awardID;
        }

        $awards = array_unique($awards);
        $awards = array_intersect_key(AwardCache::getInstance()->getAwards(), array_flip($awards));

        return $awards;
    }
}