<?php namespace wcf\page;

use wcf\data\award\AwardCache;
use wcf\system\WCF;

class RetiredMembersPage extends AbstractPage
{
  public $activeMenuItem = 'wcf.page.personnel.retired';

  public $templateName = 'retiredMembers';

  public function assignVariables() {
    parent::assignVariables();

    WCF::getTPL()->assign(array(
      
    ));
  }
}