<?php

namespace wcf\page;

use wcf\system\WCF;

class MyMembershipPage extends PersonnelPage
{
    public $activeMenuItem = 'wcf.page.personnel.mymember';

    public function assignVariables()
    {
        parent::assignVariables();

        $membership = '';
        WCF::getTPL()->assign(compact('membership'));
    }
}