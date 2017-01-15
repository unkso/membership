<?php namespace wcf\system\user\notification\object\type;

use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardList;
use wcf\system\user\notification\object\AwardReceivedUserNotificationObject;

class AwardReceivedUserNotificationObjectType extends AbstractUserNotificationObjectType
{
    protected static $decoratorClassName = AwardReceivedUserNotificationObject::class;

    protected static $objectClassName = IssuedAward::class;

    protected static $objectListClassName = IssuedAwardList::class;
}