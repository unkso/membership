<?php

namespace wcf\system\event\listener;

use wcf\acp\form\UserEditForm;
use wcf\data\award\issued\IssuedAward;
use wcf\data\user\User;
use wcf\system\WCF;

class UserAddFormAwardEventListener implements IParameterizedEventListener
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
        $userID = $eventObj->userID;
        $awards = IssuedAward::getHighestAwardedTiersForUser(new User($userID));

        usort($awards, function ($a, $b) {
            return ($a->date > $b->date) ? -1 : 1;
        });

        WCF::getTPL()->assign([
            'canAssignAwards' => WCF::getSession()->getPermission('admin.clan.award.canIssueAwards'),
            'canDeleteAwards' => WCF::getSession()->getPermission('admin.clan.award.canDeleteIssuedAwards'),
            'awards' => $awards,
        ]);
    }
}