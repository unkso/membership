<?php

namespace wcf\system\menu\user\profile\content;

use wcf\system\SingletonFactory;
use wcf\system\WCF;

class AwardUserProfileMenuContent extends SingletonFactory implements IUserProfileMenuContent
{
    public $objectTypeID = 0;

    public function getContent($userID)
    {
        return WCF::getTPL()->fetch('userProfileAwardList');
    }

    public function isVisible($userID)
    {
        return true;
    }
}