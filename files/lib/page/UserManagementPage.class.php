<?php

namespace wcf\page;

use wcf\data\membership\ClanMember;
use wcf\data\user\User;
use wcf\system\WCF;

class UserManagementPage extends PersonnelPage
{
    public $activeMenuItem = 'wcf.page.personnel.management.user';

    protected $user;

    public function readParameters()
    {
        parent::readParameters();

        if (isset($_POST['username'])) $this->user = new ClanMember(User::getUserByUsername($_POST['username']));
    }

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'user' => $this->user,
        ]);
    }
}