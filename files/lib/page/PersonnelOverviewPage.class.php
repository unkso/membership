<?php namespace wcf\page;

use wcf\system\WCF;

class PersonnelOverviewPage extends AbstractPage
{
  public $activeMenuItem = 'wcf.page.personnel.overview';

  public $templateName = 'memberOverview';

  public function assignVariables() {
    parent::assignVariables();

    $description = '';

    $scope = new \wcf\data\unit\scope\Scope(1);

    echo "<h2>Navy Scope</h2>";
    echo "<pre>";
    var_dump($scope->unitsInScope());
    echo "</pre>";
    die();
    
    WCF::getTPL()->assign(array(
      'historyExample' => $description,
    ));
  }
}