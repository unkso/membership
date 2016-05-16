<?php namespace wcf\page;

use wcf\data\award\AwardCache;
use wcf\system\WCF;

class PersonnelOverviewPage extends AbstractPage
{
  public $activeMenuItem = 'wcf.page.personnel.overview';

  public $templateName = 'memberOverview';

  public function assignVariables() {
    parent::assignVariables();

    WCF::getTPL()->assign(array(
      
    ));
  }
}