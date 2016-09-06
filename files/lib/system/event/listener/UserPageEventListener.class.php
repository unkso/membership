<?php

namespace wcf\system\event\listener;

use wcf\data\membership\ClanMember;
use wcf\data\user\User;
use wcf\page\UserPage;
use wcf\system\WCF;

class UserPageEventListener implements IParameterizedEventListener
{
    /**
     * Executes this action.
     *
     * @param    UserPage $eventObj Object firing the event
     * @param    string $className class name of $eventObj
     * @param    string $eventName name of the event fired
     * @param    array &$parameters given parameters
     */
    public function execute($eventObj, $className, $eventName, array &$parameters)
    {
        WCF::getTPL()->assign([
            'clanmember' => new ClanMember(new User($eventObj->userID)),
        ]);
    }
}