<?php

namespace wcf\page;

use wcf\system\WCF;
use wcf\data\membership\Membership;
use wcf\data\unit\scope\Scope;

class PersonnelOverviewPage extends AbstractPage
{
    public $activeMenuItem = 'wcf.page.personnel.overview';

    public $templateName = 'memberOverview';

    public function assignVariables()
    {
        parent::assignVariables();

        $scope = new Scope(1);
        $description = $scope->unitsInScope();

        $activeMembers = Membership::activeMemberships();

        WCF::getTPL()->assign([
            'example' => $description,
            'members' => $activeMembers,
        ]);
    }
}