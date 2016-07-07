<?php namespace wcf\system\event\listener;

use wcf\acp\form\UserEditForm;
use wcf\data\membership\Membership;
use wcf\data\user\User;
use wcf\system\WCF;

class UserAddFormEventListener implements IParameterizedEventListener
{
    /**
     * Executes this action.
     *
     * @param    UserEditForm $eventObj Object firing the event
     * @param    string $className class name of $eventObj
     * @param    string $eventName name of the event fired
     * @param    array &$parameters given parameters
     */
    public function execute($eventObj, $className, $eventName, array &$parameters)
    {
        WCF::getTPL()->assign([
            'memberships' => Membership::getAllMembershipsForUser(new User($eventObj->userID)),
        ]);
    }
}