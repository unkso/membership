<?php

namespace wcf\acp\page;

use wcf\page\SortablePage;
use wcf\system\WCF;

class MemberListPage extends SortablePage
{
    public $activeMenuItem = 'wcf.acp.menu.link.clan.membership.member.list';

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([]);
    }
}
