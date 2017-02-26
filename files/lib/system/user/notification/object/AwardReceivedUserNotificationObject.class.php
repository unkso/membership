<?php namespace wcf\system\user\notification\object;

use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardList;
use wcf\data\DatabaseObjectDecorator;
use wcf\data\user\User;
use wcf\system\WCF;

class AwardReceivedUserNotificationObject extends DatabaseObjectDecorator implements IUserNotificationObject
{
    protected static $baseClass = IssuedAward::class;

    public function getObjectID()
    {
        return $this->issuedAwardID;
    }

    public function getTitle()
    {
        $tier = $this->getDecoratedObject();
        return $tier->getAward()->title;
    }

    public function getURL()
    {
        $user = new User($this->userID);
        return $user->getLink();
    }

    public function getAuthorID()
    {
        return WCF::getUser()->getUserID();
    }
}