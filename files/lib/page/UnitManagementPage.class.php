<?php
namespace wcf\page;

use wcf\data\membership\ClanMember;
use wcf\data\user\User;
use wcf\system\WCF;

class UnitManagementPage extends PersonnelPage
{
    public $activeMenuItem = 'wcf.page.personnel.management.unit';

    public function readParameters()
    {
        parent::readParameters();
    }

    public function assignVariables()
    {
        parent::assignVariables();
    }
}