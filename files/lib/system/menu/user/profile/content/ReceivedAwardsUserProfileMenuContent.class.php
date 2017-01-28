<?php
namespace wcf\system\menu\user\profile\content;

use wcf\data\award\issued\IssuedAward;
use wcf\data\user\User;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class ReceivedAwardsUserProfileMenuContent extends SingletonFactory implements IUserProfileMenuContent
{
    public function getContent($userID)
    {
        $user = new User($userID);
        $awards = IssuedAward::getHighestAwardedTiersForUser($user);

        WCF::getTPL()->assign([
            'awards' => $awards,
        ]);

        return WCF::getTPL()->fetch('userProfileMenuContent_awards');
    }

    public function isVisible($userID)
    {
        $user = new User($userID);
        $awards = IssuedAward::getHighestAwardedTiersForUser($user);

        return count($awards);
    }
}