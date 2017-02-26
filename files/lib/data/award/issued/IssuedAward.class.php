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

        if ($notify) {
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

        return $award;
    }

    public function getUser()
    {
        return new User($this->userID);
    }

    /**
     * @return Award
     */
    public function getAward()
    {
        $cache = AwardCache::getInstance()->getAwards();
        return $cache[$this->awardID];
    }

    public function getRibbonURL()
    {
        return $this->getAward()->getRibbonURL($this->awardedNumber - 1);
    }

    public static function getAllAwardsForUser(User $user)
    {
        $allAwards = AwardCache::getInstance()->getAwards();
        $allIssuedAwards = IssuedAwardCache::getInstance()->getAwards();
        $userAwards = array_filter($allIssuedAwards, function ($item) use ($user, $allAwards) {
            // Only return issued awards that
            // a) belong to the requested user, and
            // b) are linked to a valid award
            return $item->userID == $user->userID
                && isset($allAwards[$item->awardID]);
        });

        usort($userAwards, function ($a, $b) {
            $aa = $a->getAward();
            $ba = $b->getAward();

            return ($aa->sortOrder < $ba->sortOrder) ? -1 : 1;
        });

        return $userAwards;
    }

    public static function getVisibleAwardsForUser(User $user)
    {
        $awards = self::getAllAwardsForUser($user);

        $output = [];
        foreach ($awards as $issue) {
            if (!isset($output[$issue->awardID]) || $output[$issue->awardID]->awardedNumber < $issue->awardedNumber) {
                $output[$issue->awardID] = $issue;
            }
        }

        // We do another loop to be sure we already have all awards in the output.
        foreach ($awards as $issue) {
            $award = $issue->getAward();
            if ($award->isTiered && $award->replacesAward && isset($output[$award->replacesAward])) {
                unset($output[$award->replacesAward]);
            }
        }

        return $output;
    }
}
