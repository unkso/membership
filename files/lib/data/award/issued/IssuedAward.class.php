<?php

namespace wcf\data\award\issued;

use wcf\data\award\Award;
use wcf\data\award\AwardCache;
use wcf\data\award\AwardTier;
use wcf\data\DatabaseObject;
use wcf\data\user\User;
use wcf\system\cache\builder\AwardCacheBuilder;
use wcf\system\WCF;

class IssuedAward extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_issued_award';

    protected static $databaseTableIndexName = 'issuedAwardID';

    public static function getAllAwardedTiersForUser(User $user)
    {
        $issued = self::getDatabaseTableName();
        $tier = AwardTier::getDatabaseTableName();
        $award = Award::getDatabaseTableName();

        $sql = "SELECT $issued.tierID FROM $issued 
                  JOIN $tier ON $tier.tierID = $issued.tierID 
                  JOIN $award ON $tier.awardID = $award.awardID 
                 WHERE $issued.userID = ?
                ORDER BY ($award.relevance * 100 + $tier.level) DESC";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$user->userID]);

        $tierList = AwardCacheBuilder::getInstance()->getData([], 'tiers');
        $tiers = [];
        while ($statement && $row = $statement->fetchArray()) {
            $tiers[] = $tierList[$row['tierID']];
        }

        return $tiers;
    }

    public static function getHighestAwardedTiersForUser(User $user)
    {
        $tiers = self::getAllAwardedTiersForUser($user);
        $awards = [];

        foreach ($tiers as $key => $tier) {
            if (isset($awards[$tier->awardID])) {
                $highest = $awards[$tier->awardID];

                if ($highest['level'] < $tier->level) {
                    unset($tiers[$highest['key']]);
                    continue;
                } elseif ($highest['level'] > $tier->level) {
                    unset($tiers[$key]);
                    continue;
                }
            }

            $awards[$tier->awardID] = [
                'level' => $tier->level,
                'key' => $key,
            ];
        }

        return $tiers;
    }

    public static function getAwardsForUser(User $user)
    {
        $tiers = self::getAllAwardedTiersForUser($user);
        $awards = [];
        foreach ($tiers as $tier) {
            $awards[] = $tier->awardID;
        }

        $awards = array_unique($awards);
        $awards = array_intersect_key(AwardCache::getInstance()->getAwards(), array_flip($awards));

        return $awards;
    }
}